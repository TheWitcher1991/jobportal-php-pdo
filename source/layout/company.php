<?php
$id = (int) $_GET['id'];

$rc = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $id]);

if (empty($rc['id'])) {
    $app->notFound();
}


if (isset($_SESSION['id']) AND $_SESSION['type'] == 'users') {
    $rus = $_SESSION['id'];
} else {
    $rus = 0;
}

if ($rus !== 0) {
    $stmt = $PDO->prepare("SELECT * FROM `online_company` WHERE `user` = ? AND `company` = ?");
    $stmt->execute([$rus, $rc['id']]);
    if ($stmt->rowCount() > 0) {
        $app->execute("UPDATE `online_company` SET `time` = NOW() WHERE `user` = :users AND `company` = :company", [
            ':users' => $rus,
            ':company' => $rc['id']
        ]);
    } else {
        $app->execute("INSERT INTO `online_company` (`ip`, `user`, `time`, `company`) VALUES(:ip, :users, NOW(), :company)", [
            ':ip' => $_SERVER['REMOTE_ADDR'],
            ':users' => $rus,
            ':company' => $rc['id']
        ]);
        $app->execute("UPDATE `company` SET `views` = `views` + 1 WHERE `id` = :id", [
            ':id' => (int) $rc['id']
        ]);
    }

} else {

}

if (isset($_POST['add-rev'])) {

    if (empty($_POST['prof']) or trim($_POST['prof']) == '') $err['prof'] = 'Введите профессию';

    if (empty($err)) {



        $rating = (int) $_POST['rating'];
        $prof = XSS_DEFENDER($_POST['prof']);
        $me = XSS_DEFENDER($_POST['me']);
        $text = XSS_DEFENDER($_POST['text']);

        if ($rating > 0) {

            $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']]);

            $app->execute("INSERT INTO `review` (`user`, `user_id`, `company`, `company_id`, `rating`, `me`, `prof`, `text`, `date`) 
                                    VALUES(:un, :ui, :cn, :ci, :r, :m, :p, :t, :da)", [
                ':un' => $user['name'] . ' ' . $user['surname'],
                ':ui' => $user['id'],
                ':cn' => $rc['name'],
                ':ci' => $rc['id'],
                ':r' => $rating,
                ':m' => $me,
                ':p' => $prof,
                ':t' => $text,
                ':da' => $Date
            ]);

            $app->execute("INSERT INTO `notice` (`type`, `title`, `date`, `hour`, `time`, `user_id`, `company_id`, `who`)
                    VALUES(:typ, :title, :dat, :h, NOW(), :ui, :ci, :wh)", [
                ':typ' => 'company_review',
                ':title' => 'У Вас новый отзыв!',
                ':dat' => $Date,
                ':h' => date("H:i"),
                ':ui' => $user['id'],
                ':ci' => $rc['id'],
                ':wh' => 1
            ]);

            header('location: /company/?id=' . $rc['id'] . '&t=3');
        }

    }
}

$sth = $PDO->prepare("SELECT * FROM `review` WHERE `company_id` = ?");
$sth->execute(array((int) $rc['id']));
$data = $sth->fetchAll(PDO::FETCH_ASSOC);
$count = count($data);

if ($count > 0) {
    $rating = 0;
    foreach ($data as $row) {
        $rating += $row['rating'];
    }
    $rating = $rating / $count;
}

$filename = '/home/s/stgau/public_html/static/image/company/' . $rc['img'];
$info = getimagesize($filename);

switch ($info[2]) {
    case 1:
        $img = imagecreatefromgif($filename);
        break;
    case 2:
        $img = imagecreatefromjpeg($filename);
        break;
    case 3:
        $img = imagecreatefrompng($filename);
        break;
    case 4:
        $img = imagecreatefromwebp($filename);
        break;
}

if ($img != '') {
    $width = imagesx($img);
    $height = imagesy($img);

    $total_r = $total_g = $total_b = 0;
    for ($x = 0; $x < $width; $x++) {
        for ($y=0; $y<$height; $y++) {
            $c = imagecolorat($img, $x, $y);
            $total_r += ($c>>16) & 0xFF;
            $total_g += ($c>>8) & 0xFF;
            $total_b += $c & 0xFF;
        }
    }

    $rgb = array(
        round($total_r / $width / $height),
        round($total_g / $width / $height),
        round($total_b / $width / $height)
    );

    $bg = '#';
    foreach ($rgb as $row) {
        $bg .= str_pad(dechex($row), 2, '0', STR_PAD_LEFT);
    }

    imagedestroy($img);
} else {
    $bg = '';
}




Head('Компания - ' . $rc['name']);

?>
<body>

<?php require('template/base/nav.php'); ?>

<header id="header-search">
    <?php require('template/base/navblock.php'); ?>

    <div class="container-mini company-container">
        <div class="company-header">

            <div class="company-banner

<?php if (!empty($rc['baner']) && trim($rc['baner']) != '') { ?>
company-banner-img
<?php } ?>
" style="background: <?php echo $bg; ?>">
                <?php if (!empty($rc['baner']) && trim($rc['baner']) != '') { ?>
                <img src="/static/image/company_banner/<?php echo $rc['baner'] ?>" alt="">
                <?php } ?>
            </div>

            <div class="company-title">

                <div class="cct-left">
                    <div class="cct-img">

                        <?php

                        if (trim($rc['img']) != 'placeholder.png') {
                            echo '<span><img src="/static/image/company/' . $rc['img'] . '" alt=""></span>';
                        }



                        ?>

                    </div>
                    <div class="cct-name">
                        <span> <?php if ($rc['verified'] == 1) { ?> <i class="mdi mdi-check-circle-outline shiled-success"></i> <?php } ?> <?php

                            if (trim($rc['name']) != '') {
                                echo $rc['name'];
                            } else {
                                echo 'Без названия';
                            }

                            ?></span>
                        <div>
                             <?php

                                if (trim($rc['specialty']) != '') {
                                    echo '<span><i class="mdi mdi-pound"></i> ' . $rc['specialty'] . '</span> ';
                                }



                                ?>
                            <span><i class="mdi mdi-crosshairs-gps"></i> <?php echo $rc['address'] ?></span>
                            <span><i class="mdi mdi-account-multiple-outline"></i> Подписчиков       <?

                                echo $app->rowCount("SELECT * FROM `sub` WHERE `company` = :id", [
                                    ':id' => $rc['id'],
                                ]);

                                ?></span>
                        </div>
                    </div>
                </div>

                <div class="cct-right">

                    <? if (isset($_SESSION['id']) && $_SESSION['type'] == 'users') { ?>

                        <?

                        $cs = $app->rowCount("SELECT * FROM `sub` WHERE `company` = :id AND `user` = :ui", [
                            ':id' => $rc['id'],
                            ':ui' => $_SESSION['id']
                        ]);

                        ?>

                        <? if ($cs <= 0) { ?>
                                <button class="reg-sub create-sub" onclick="createSub()" type="button"><i class="mdi mdi-bell-plus-outline"></i> Подписаться</button>

                            <? } else {?>
                            <button class="del-sub" onclick="delSub()" type="button"><i class="mdi mdi-bell-ring-outline"></i> Вы подписаны</button>
                        <? }?>


                    <? } else if ($_SESSION['type'] != 'company') {
                    ?>
                        <a class="reg-sub open-auth"><i class="mdi mdi-bell-plus-outline"></i> Подписаться</a>
                        <?
                    } ?>



                </div>

            </div>

            <div class="company-tabs">
                <div class="detail-tabs">
                    <ul>
                        <li class="<? if (empty($_GET['t'])) { echo 'dt-active'; } ?> dt-a-1"><a href="/company/?id=<? echo $rc['id']; ?>">Информация</a></li>
                        <li class="<? if ($_GET['t'] == 2) { echo 'dt-active'; } ?> dt-a-2"><a href="/company/?id=<? echo $rc['id']; ?>&t=2">Вакансии</a></li>
                        <li class="<? if ($_GET['t'] == 3) { echo 'dt-active'; } ?> dt-a-3"><a href="/company/?id=<? echo $rc['id']; ?>&t=3">Отзывы</a></li>
                    </ul>
                </div>
            </div>

        </div>



    </div>


</header>






<div class="errors-block-fix"></div>

<main id="wrapper" class="wrapper">

    <section class="detail-list-section">
        <div class="container-mini">



            <div class="message-block"></div>

            <div class="section-items">

                <div class="company-detail-block">

                    <div class="company-d-left">
                        <div class="detail-block">
                            <div class="detail-item <? if (empty($_GET['t'])) { echo 'dt-active'; } ?>  dt-b-1">


                                <div class="al-stats">
                                    <ul>
                                        <li>
                                            <div class="as-t">
                                                <span class="as-tt"><? echo $app->count("SELECT * FROM `vacancy` WHERE `status` = 0 AND `company_id` = ".(int) $rc['id']); ?></span>
                                                <span class="as-tk">Вакансий</span>
                                            </div>
                                            <div class="as-i"><i class="mdi mdi-database-check-outline"></i></div>

                                        </li>

                                        <li>
                                            <div class="as-t">
                                                <span class="as-tt"><?php echo $app->count("SELECT * FROM `visits_job` WHERE `company_id` = ".(int) $rc['id']) + $rc['views'] ?></span>
                                                <span class="as-tk">Просмотров</span>
                                            </div>
                                            <div class="as-i"><i class="mdi mdi-eye-outline"></i></div>

                                        </li>
                                        <li>
                                            <div class="as-t">
                                                <span class="as-tt"><?php echo count($data) ?></span>
                                                <span class="as-tk">Отзывов</span>
                                            </div>
                                            <div class="as-i"><i class="mdi mdi-message-star-outline"></i></div>

                                        </li>
                                    </ul>
                                </div>



                                <div style="font-size: 15px;line-height: 26px;color: #081935;position: relative;padding: 0 20px 0 0;">
                                    <?php
                                    if (trim($rc['about']) > '') {
                                        echo '<pre class="text-content">' . $rc['about'] . '</pre>';
                                    } else {
                                        echo 'Нет информации';
                                    }
                                    ?>
                                </div>
                                <div class="office-block">
                                    <?php
                                    $sqlsk = "SELECT * FROM `office_img` WHERE `company_id` = :t ORDER BY `id` DESC";
                                    $stmtsk = $PDO->prepare($sqlsk);
                                    $stmtsk->bindValue(':t', (int) $rc['id']);
                                    $stmtsk->execute();
                                    if ($stmtsk->rowCount() > 0) {
                                        ?>

                                        <ul>
                                            <?php

                                            while ($rs = $stmtsk->fetch()) {


                                                ?>
                                                <li>

                                                    <img src="/static/image/c_office/<?php echo $rs['img'] ?>" alt="">

                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>

                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="detail-item <? if ($_GET['t'] == 2) { echo 'dt-active'; } ?>  dt-b-2">

                                <?php

                                $sql = "SELECT * FROM `vacancy` WHERE `company` = :company AND `status` = :st ORDER BY `id` DESC";
                                $stmt = $PDO->prepare($sql);
                                $stmt->bindValue(':company', $rc['name']);
                                $stmt->bindValue(':st', 0);
                                $stmt->execute();
                                if ($stmt->rowCount() > 0) {


                                    ?>
                                    <div class="detail-list-flex-b" style="margin: 0;">
                                        <div class="detail list-b-1">
                                            <div class="detail-list-vacancy dl-vac">
                                                <span class="dl-h">Доступно <?php echo $stmt->rowCount()  ?> вакансий</span>
                                                <div class="dl-input-block">
                                                    <form role="form" method="GET" class="form-company-vac">
                                                        <input class="company-vacancy" type="text" name="key" placeholder="Должность">
                                                        <input type="button" class="search-lk" name="search-lk" value="Найти">
                                                    </form>
                                                </div>
                                                <ul class="vac-list-ul">
                                                    <div id="placeholder-main">
                                                        <div class="placeholder">
                                                            <div style="width: 100%;">
                                                                <div class="placeholder-item jx-nav"></div>
                                                                <div class="placeholder-item jx-title"></div>
                                                                <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                                                <div class="mx-flex" style="margin: 0;">
                                                                    <div class="placeholder-item mx-flit"></div>
                                                                    <div class="placeholder-item mx-flit"></div>
                                                                    <div class="placeholder-item mx-flit"></div>
                                                                </div>
                                                                <div  style="margin: 16px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                                                <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                                            </div>
                                                        </div>
                                                        <div class="placeholder">
                                                            <div style="width: 100%;">
                                                                <div class="placeholder-item jx-nav"></div>
                                                                <div class="placeholder-item jx-title"></div>
                                                                <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                                                <div class="mx-flex" style="margin: 0;">
                                                                    <div class="placeholder-item mx-flit"></div>
                                                                    <div class="placeholder-item mx-flit"></div>
                                                                    <div class="placeholder-item mx-flit"></div>
                                                                </div>
                                                                <div  style="margin: 16px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                                                <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                                            </div>
                                                        </div>
                                                        <div class="placeholder">
                                                            <div style="width: 100%;">
                                                                <div class="placeholder-item jx-nav"></div>
                                                                <div class="placeholder-item jx-title"></div>
                                                                <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                                                <div class="mx-flex" style="margin: 0;">
                                                                    <div class="placeholder-item mx-flit"></div>
                                                                    <div class="placeholder-item mx-flit"></div>
                                                                    <div class="placeholder-item mx-flit"></div>
                                                                </div>
                                                                <div  style="margin: 16px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                                                <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                                            </div>
                                                        </div>
                                                        <div class="placeholder">
                                                            <div style="width: 100%;">
                                                                <div class="placeholder-item jx-nav"></div>
                                                                <div class="placeholder-item jx-title"></div>
                                                                <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                                                <div class="mx-flex" style="margin: 0;">
                                                                    <div class="placeholder-item mx-flit"></div>
                                                                    <div class="placeholder-item mx-flit"></div>
                                                                    <div class="placeholder-item mx-flit"></div>
                                                                </div>
                                                                <div  style="margin: 16px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                                                <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                                            </div>
                                                        </div><div class="placeholder">
                                                            <div style="width: 100%;">
                                                                <div class="placeholder-item jx-nav"></div>
                                                                <div class="placeholder-item jx-title"></div>
                                                                <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                                                <div class="mx-flex" style="margin: 0;">
                                                                    <div class="placeholder-item mx-flit"></div>
                                                                    <div class="placeholder-item mx-flit"></div>
                                                                    <div class="placeholder-item mx-flit"></div>
                                                                </div>
                                                                <div  style="margin: 16px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                                                <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                                            </div>
                                                        </div><div class="placeholder">
                                                            <div style="width: 100%;">
                                                                <div class="placeholder-item jx-nav"></div>
                                                                <div class="placeholder-item jx-title"></div>
                                                                <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                                                <div class="mx-flex" style="margin: 0;">
                                                                    <div class="placeholder-item mx-flit"></div>
                                                                    <div class="placeholder-item mx-flit"></div>
                                                                    <div class="placeholder-item mx-flit"></div>
                                                                </div>
                                                                <div  style="margin: 16px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                                                <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    echo '<span class="non-vac">Вакансии не найдены</span>';
                                }
                                ?>
                            </div>
                            <div class="detail-item <? if ($_GET['t'] == 3) { echo 'dt-active'; } ?> dt-b-3">
                                <div class="review-block">
                                    <div class="review-block-top">
                                        <div class="review-top-title">Отзывы о компании</div>
                                        <div class="rating-num"><?php echo $rating; ?></div>
                                        <div class="rating-result">
                                            <span class="<?php if (ceil($rating) >= 1) echo 'active-r'; ?>"></span>
                                            <span class="<?php if (ceil($rating) >= 2) echo 'active-r'; ?>"></span>
                                            <span class="<?php if (ceil($rating) >= 3) echo 'active-r'; ?>"></span>
                                            <span class="<?php if (ceil($rating) >= 4) echo 'active-r'; ?>"></span>
                                            <span class="<?php if (ceil($rating) >= 5) echo 'active-r'; ?>"></span>
                                        </div>
                                        <div class="rating-text">На основе <?php echo count($data); ?> оценок</div>
                                    </div>
                                </div>

                                <?php

                                $stmt2 = $PDO->prepare("SELECT * FROM `review` WHERE `user_id` = :ci AND `company_id` = :ui ORDER BY `id` DESC");
                                $stmt2->bindValue(':ci', (int) $_SESSION['id']);
                                $stmt2->bindValue(':ui', (int) $rc['id']);
                                $stmt2->execute();
                                if ($_SESSION['type'] == 'users' and $stmt2->rowCount() < 1) {

                                    ?>
                                    <div class="company-d-about com-bag review-bag">
                                        <span>Добавить отзыв</span>
                                        <form action="" method="post">
                                            <div class="label-block">
                                                <label for="">Как вы бы оценили данного работодателя? <span>*</span></label>
                                                <div class="rating-area">
                                                    <input type="radio" id="star-5" name="rating" value="5">
                                                    <label for="star-5" title="Оценка «5»"></label>
                                                    <input type="radio" id="star-4" name="rating" value="4">
                                                    <label for="star-4" title="Оценка «4»"></label>
                                                    <input type="radio" id="star-3" name="rating" value="3">
                                                    <label for="star-3" title="Оценка «3»"></label>
                                                    <input type="radio" id="star-2" name="rating" value="2">
                                                    <label for="star-2" title="Оценка «2»"></label>
                                                    <input type="radio" id="star-1" name="rating" value="1">
                                                    <label for="star-1" title="Оценка «1»"></label>
                                                </div>
                                            </div>

                                            <div class="label-block">
                                                <label for="">Кто вы? <span>*</span></label>
                                                <div class="label-select-block">
                                                    <select name="me" id="">
                                                        <option value="бывший сотрудник">бывший сотрудник</option>
                                                        <option value="текущий сотрудник">текущий сотрудник</option>
                                                    </select>
                                                    <div class="label-arrow">
                                                        <i class="mdi mdi-chevron-down"></i>
                                                    </div>
                                                </div>
                                                <? if (isset($err['me'])) { ?> <span class="error"><? echo $err['me']; ?></span> <? } ?>
                                            </div>
                                            <div class="label-block">
                                                <label for="">Профессия <span>*</span></label>
                                                <input type="text" name="prof" placeholder="" value="<? echo $err['prof']; ?>">
                                                <? if (isset($err['prof'])) { ?> <span class="error"><? echo $err['prof']; ?></span> <? } ?>
                                            </div>
                                            <div class="label-block">
                                                <label for="">Комментарий</label>
                                                <textarea name="text" id="text" cols="30" rows="10" style="height:100px;"><? echo $_POST['text']; ?></textarea>
                                                <? if (isset($err['text'])) { ?> <span class="error"><? echo $err['text']; ?></span> <? } ?>
                                            </div>
                                            <div class="a-bth">
                                                <input id="reg-user" name="add-rev" type="submit" value="Добавить" />
                                            </div>
                                        </form>
                                    </div>
                                    <?php
                                }
                                ?>


                                <div class="review-list">
                                    <ul class="review-list-ul">

                                        <?php

                                        if (isset($_SESSION['id']) AND $_SESSION['type'] == 'users') {
                                            $stmt3 = $PDO->prepare("SELECT * FROM `review` WHERE `user_id` = :ci AND `company_id` = :ui ORDER BY `id` DESC");
                                            $stmt3->bindValue(':ci', (int) $_SESSION['id']);
                                            $stmt3->bindValue(':ui', (int) $rc['id']);
                                            $stmt3->execute();
                                            if ($stmt3->rowCount() > 0) {
                                                $rp = $stmt3->fetch();
                                                ?>
                                                <li style="border: 1px solid #1967d2;padding: 16px" class="review-<?php echo $rp['id'] ?>">
                                                    <div>
                                                        <div class="rv-name"><span><?php echo $rp['prof'] ?></span>, <?php echo $rp['me'] ?></div>
                                                        <div class="rv-prof"></div>
                                                        <div class="rating-list">
                                                            <span class="<?php if (ceil($rp['rating']) >= 1) echo 'active-r'; ?>"></span>
                                                            <span class="<?php if (ceil($rp['rating']) >= 2) echo 'active-r'; ?>"></span>
                                                            <span class="<?php if (ceil($rp['rating']) >= 3) echo 'active-r'; ?>"></span>
                                                            <span class="<?php if (ceil($rp['rating']) >= 4) echo 'active-r'; ?>"></span>
                                                            <span class="<?php if (ceil($rp['rating']) >= 5) echo 'active-r'; ?>"></span>
                                                        </div>
                                                        <div class="rl-text"><?php echo $rp['text'] ?></div>
                                                    </div>
                                                    <div class="review-bth-l">
                                                        <button class="review-trash" onclick="deleteDetail('<?php echo $rp['id'] ?>')" type="button"><i class="mdi mdi-delete-outline"></i></button>
                                                        <button class="review-edit" onclick="editDetailView('<?php echo $rp['id'] ?>', '<?php echo $rp['me'] ?>', '<?php echo $rp['prof'] ?>', `<?php echo $rp['text'] ?>`, '<?php echo ceil($rp['rating']) ?>')" type="button"><i class="mdi mdi-pencil"></i></button>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                        }





                                        $stmt2 = $PDO->prepare("SELECT * FROM `review` WHERE `company_id` = :ci ORDER BY `id` DESC");
                                        $stmt2->bindValue(':ci', (int) $rc['id']);
                                        $stmt2->execute();
                                        while ($r = $stmt2->fetch()) {

                                            if (isset($_SESSION['id']) AND $_SESSION['type'] == 'users') {
                                                if ($r['user_id'] == $_SESSION['id']) {
                                                    continue;
                                                }
                                            }

                                            ?>
                                            <li>
                                                <div>
                                                    <div class="rv-name"><?php echo $r['prof'] ?>, <?php echo $r['me'] ?></div>
                                                    <div class="rv-prof"></div>
                                                    <div class="rating-list">
                                                        <span class="<?php if (ceil($r['rating']) >= 1) echo 'active-r'; ?>"></span>
                                                        <span class="<?php if (ceil($r['rating']) >= 2) echo 'active-r'; ?>"></span>
                                                        <span class="<?php if (ceil($r['rating']) >= 3) echo 'active-r'; ?>"></span>
                                                        <span class="<?php if (ceil($r['rating']) >= 4) echo 'active-r'; ?>"></span>
                                                        <span class="<?php if (ceil($r['rating']) >= 5) echo 'active-r'; ?>"></span>
                                                    </div>
                                                    <div class="rl-text"><?php echo $r['text'] ?></div>
                                                </div>
                                            </li>
                                            <?php
                                        }

                                        ?>
                                    </ul>
                                </div>





                            </div>
                        </div>









                        
                        
                        
                    </div>

                    <div class="company-d-right com-bag">

                        <?php if ((isset($_SESSION['id']) && $_SESSION['type'] == 'users')) { ?>

                        <!--<button type="button" class="wanna-bth" onclick="wannaCompany('<?php echo $rc['id']; ?>')">Хочу тут работать</button>-->

                        <?php } ?>

                        <ul class="detail-info-ul" style="margin: 0;padding: 0;border: 0">
                            <li>
                                <div class="di-l"><i class="mdi mdi-calendar-today-outline"></i></div>
                                <div class="di-r">
                                    <span>Регистрация</span>
                                    <span><?php echo $rc['date'] ?></span>
                                </div>
                            </li>
                            <?php if ((isset($_SESSION['id']) && $_SESSION['type'] == 'users') ||$_SESSION['type'] == 'admin') { ?>
                                <li>
                                    <div class="di-l"><i class="mdi mdi-phone"></i></div>
                                    <div class="di-r">
                                        <span>Телефон</span>
                                        <span><?php echo $rc['phone'] ?></span>
                                    </div>
                                </li>
                            <li>
                                <div class="di-l"><i class="mdi mdi-at"></i></div>
                                <div class="di-r">
                                    <span>Email</span>
                                    <span><?php echo $rc['email'] ?></span>
                                </div>
                            </li>
                            <?php } ?>
                            <li>
                                <div class="di-l"><i class="mdi mdi-pound"></i></div>
                                <div class="di-r">
                                    <span>Тип</span>
                                    <span><?php echo $rc['type'] ?></span>
                                </div>
                            </li>
                            <?php if (!empty($rc['middle']) and $rc['middle'] > 0) { ?>
                                <li>
                                    <div class="di-l"><i class="mdi mdi-currency-rub"></i></div>
                                    <div class="di-r">
                                        <span>Средняя зарплата</span>
                                        <span><?php echo $rc['middle'] ?></span>
                                    </div>
                                </li>
                            <?php } ?>
                            <?php if (!empty($rc['people'])) { ?>
                                <li>
                                    <div class="di-l"><i class="mdi mdi-account-group"></i></div>
                                    <div class="di-r">
                                        <span>Штат</span>
                                        <span><?php echo $rc['people']; ?></span>
                                    </div>
                                </li>
                            <?php } ?>
                            <?php if (!empty($rc['website']) and trim($rc['website']) > '') { ?>
                                <li>
                                    <div class="di-l"><i class="mdi mdi-web"></i></div>
                                    <div class="di-r">
                                        <span>Сайт</span>
                                        <span><?php echo $rc['website']; ?></span>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>



            </div>
        </div>
    </section>

</main>

<?php require('template/base/footer.php'); ?>

<?php

if (isset($_SESSION['id']) && isset($_SESSION['password']) && $_SESSION['type'] == 'users') {

    ?>

    <script>


        function createRespond(id) {
            $('.empty').fadeOut(50)
            $('input').removeClass('errors')
            $('.respond-job').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
            $('.respond-job').attr('disabled', 'true')
            $.ajax({
                url: '/scripts/profile-js',
                data: `${$('.respond-create-form').serialize()}&id=${id}&MODULE_CREATE_WANNA=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => {
                    deleteFormJob()
                    MessageBox('Произошла ошибка. Повторите')
                    $('.respond-job').html('Подтвердить')
                    document.querySelector('.respond-job').removeAttribute('disabled')
                },
                success: function (responce) {
                    if (responce.code === 'validate_error') {
                        let $arr = responce.error
                        for (let i in $arr) {
                            $(`#${i}`).addClass('errors');
                            $(`.e-${i}`).fadeIn(50)
                        }
                        $('.respond-job').html('Подтвердить')
                        document.querySelector('.respond-job').removeAttribute('disabled')
                    } else {
                        if (responce.code === 'success') {
                            $('.wanna-bth').remove()
                            document.querySelector('.auth-job').remove();
                            $('.message-block').html('<span class="success-blue">Мы отправили отклик работодателю, скоро он с Вами свяжется! <i onclick="$(this).parent().remove()" class="mdi mdi-close"></i></span>')
                            $('.respond-job').html('Подтвердить')
                        } else {
                            deleteFormJob()
                            MessageBox('Произошла ошибка. Повторите')
                            $('.respond-job').html('Подтвердить')
                            document.querySelector('.respond-job').removeAttribute('disabled')
                        }
                    }


                }})
        }

        function wannaCompany(id){
            document.querySelector('body').innerHTML+=`

                        <div class="auth-job" id="auth" style="display:flex">
                    <div class="contact-wrapper" style="display:block">
                        <div class="auth-container auth-log" style="display:block">
                            <div class="auth-title">
                                Вы робот?
                                <i class="mdi mdi-close" onclick="document.querySelector('.auth-job').remove();"></i>
                            </div>
                            <div class="auth-form">
                                <div class="pop-text">
                                    Нам надо проверить, что Вы не робот
                                </div>
                                <form method="post" role="form" class="respond-create-form">
                                    <div class="captcha" style="margin: 0;">
                                    <div class="captcha__image-reload">
                                        <img class="captcha__image" src="/scripts/captcha" width="132" alt="captcha">
                                        <button type="button" class="captcha__refresh"><i class="mdi mdi-refresh"></i></button>
                                    </div>
                                    <div style="margin: 0 0 35px" class="captcha__group">
                                        <label for="captcha">Код, изображенный на картинке</label>
                                        <input type="text" name="captcha" id="captcha">
                                        <div class="empty e-captcha">Код неверный или устарел</div>
                                    </div>
                                    </div>
                                    <div class="pop-flex-bth">
                                        <button class="more-inf" type="button" onclick="document.querySelector('.auth-job').remove();">Отмена</button>
                                        <button onclick="createRespond(${id})" type="button" class="lock-yes respond-job" name="respond-job">Подтвердить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `
            const refreshCaptcha = (target) => {
                const captchaImage = target.closest('.captcha__image-reload').querySelector('.captcha__image');
                captchaImage.src = '/scripts/captcha?r=' + new Date().getUTCMilliseconds();
            }
            if (document.querySelector('.captcha__refresh')) {
                const captchaBtn = document.querySelector('.captcha__refresh');
                captchaBtn.addEventListener('click', (e) => refreshCaptcha(e.target));
            }
        }


        function deleteDetail(id) {
            $(`.review-${Number(id)}`).fadeOut(200);
            $(`.review-${Number(id)} .review-trash`).html('<i class="mdi mdi-reload reload-bth"></i>')
            $(`.review-${Number(id)} .review-trash`).attr('disabled', 'true')
            $.ajax({
                url: '/scripts/profile-js',
                data: `id=${id}&MODULE_DELETE_REVIEW=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => {
                    MessageBox('Произошла ошибка. Повторите')
                },
                success: function (responce) {
                    if (responce.code === 'success') {
                        $(`.review-${Number(id)}`).remove()
                    } else {
                        MessageBox('Произошла ошибка. Повторите')
                    }
                }
            })
        }

        function editReview(id) {
            $(`.lock-yes`).html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
            $(`.lock-yes`).attr('disabled', 'true')
            $('.empty').fadeOut(50)
            $('select').removeClass('errors')
            $('input').removeClass('errors')
            $.ajax({
                url: '/scripts/profile-js',
                data: `id=${id}&${$('.edit-review-form').serialize()}&MODULE_EDIT_REVIEW=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => {
                    MessageBox('Произошла ошибка. Повторите')
                    $(`.lock-yes`).html('Применить')
                    $(`.lock-yes`).removeAttr('disabled')
                },
                success: function (responce) {
                    if (responce.code === 'validate_error') {
                        let $arr = responce.error
                        for (let i in $arr) {
                            $(`#${i}`).addClass('errors');
                            $(`.e-${i}`).fadeIn(50)
                        }
                        $(`.lock-yes`).html('Применить')
                        $(`.lock-yes`).removeAttr('disabled')
                    } else {
                        if (responce.code === 'success') {
                            MessageBox('Публикуем....')
                            location.reload()
                        } else {
                            MessageBox('Произошла ошибка. Повторите')
                            $(`.lock-yes`).html('Применить')
                            $(`.lock-yes`).removeAttr('disabled')
                        }
                    }
                }
            })
        }

        function delSub() {
            $(`.del-sub`).html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path-black" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
            $(`.del-sub`).attr('disabled', 'true')

            $.ajax({
                url: '/scripts/profile-js',
                data: `id=${<? echo $rc['id']; ?>}&MODULE_DELETE_SUB=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => {
                    MessageBox('Произошла ошибка. Повторите')
                    $(`.del-sub`).html('<i class="mdi mdi-bell-ring-outline"></i> Вы подписаны')
                    $(`.del-sub`).removeAttr('disabled')
                },
                success: function (responce) {
                    if (responce.code === 'validate_error') {
                        let $arr = responce.error
                        $(`.del-sub`).html('<i class="mdi mdi-bell-ring-outline"></i> Вы подписаны')
                        $(`.del-sub`).removeAttr('disabled')
                    } else {
                        if (responce.code === 'success') {

                            $('.cct-right .del-sub').remove()
                            $('.cct-right').html(`
<button class="reg-sub create-sub" onclick="createSub()" type="button"><i class="mdi mdi-bell-plus-outline"></i> Подписатьcя</button>
                            `)
                        } else {
                            MessageBox('Произошла ошибка. Повторите')
                            $(`.del-sub`).html('<i class="mdi mdi-bell-ring-outline"></i> Вы подписаны')
                            $(`.del-sub`).removeAttr('disabled')
                        }
                    }
                }
            })


        }


        function createSub() {
            $(`.create-sub`).html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
            $(`.create-sub`).attr('disabled', 'true')

            $.ajax({
                url: '/scripts/profile-js',
                data: `id=${<? echo $rc['id']; ?>}&MODULE_CREATE_SUB=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => {
                    MessageBox('Произошла ошибка. Повторите')
                    $(`.create-sub`).html('<i class="mdi mdi-bell-plus-outline"></i> Подписатьcя')
                    $(`.create-sub`).removeAttr('disabled')
                },
                success: function (responce) {
                    if (responce.code === 'validate_error') {
                        let $arr = responce.error
                        $(`.create-sub`).html('<i class="mdi mdi-bell-plus-outline"></i> Подписатьcя')
                        $(`.create-sub`).removeAttr('disabled')
                    } else {
                        if (responce.code === 'success') {
                            document.querySelector('body').innerHTML += `

                        <div id="auth" style="display:flex">
                    <div class="contact-wrapper" style="display:block">
                        <div class="auth-container auth-log" style="display:block;width: 650px;">
                            <div class="auth-title">
                                Подписаться
                                <i class="mdi mdi-close" onclick="document.querySelector('#auth').remove();"></i>
                            </div>
                            <div class="auth-form">
                                    <div class="success-big-icon"><i class="mdi mdi-check-circle-outline shiled-success"></i></div>
                                   <span style="text-align:center">Вы подписались на рассылку <? echo $rc['name']; ?>. Теперь Вы будете получать сообщения на почту о новых вакансиях</span>
                            </div>
                        </div>
                    </div>
                </div>
            `

             $('.cct-right .create-sub').remove()
                            $('.cct-right').html(`
<button class="del-sub" onclick="delSub()" type="button"><i class="mdi mdi-bell-ring-outline"></i> Вы подписаны</button>
                            `)
                        } else {
                            MessageBox('Произошла ошибка. Повторите')
                            $(`.create-sub`).html('<i class="mdi mdi-bell-plus-outline"></i> Подписатьcя')
                            $(`.create-sub`).removeAttr('disabled')
                        }
                    }
                }
            })


        }

        function editDetailView(id, me, prof, text, rating) {
            document.querySelector('body').innerHTML += `

                        <div id="auth" style="display:flex">
                    <div class="contact-wrapper" style="display:block">
                        <div class="auth-container auth-log" style="display:block;width: 650px;">
                            <div class="auth-title">
                                Редактировать отзыв
                                <i class="mdi mdi-close" onclick="document.querySelector('#auth').remove();"></i>
                            </div>
                            <div class="auth-form">
                                    <form role="form" class="edit-review-form" method="post">
                                            <div class="label-block">
                                                <label for="">Как вы бы оценили данного работодателя? <span>*</span></label>
                                                <div class="rating-area">
                                                    <input type="radio" id="star-5" name="rating" value="5">
                                                    <label  for="star-5" title="Оценка «5»"></label>
                                                    <input type="radio" id="star-4" name="rating" value="4">
                                                    <label for="star-4" title="Оценка «4»"></label>
                                                    <input type="radio" id="star-3" name="rating" value="3">
                                                    <label for="star-3" title="Оценка «3»"></label>
                                                    <input type="radio" id="star-2" name="rating" value="2">
                                                    <label for="star-2" title="Оценка «2»"></label>
                                                    <input type="radio" id="star-1" name="rating" value="1">
                                                    <label for="star-1" title="Оценка «1»"></label>
                                                </div>
                                                <span class="empty e-rating">Рейтинг указан неверно</span>
                                            </div>

                                            <div class="label-block">
                                                <label for="">Кто вы? <span>*</span></label>
                                                <div class="label-select-block">
                                                    <select name="me" id="me">
                                                         <option value="${me}" selected>${me}</option>
                                                        <option value="бывший сотрудник">бывший сотрудник</option>
                                                        <option value="текущий сотрудник">текущий сотрудник</option>
                                                    </select>
                                                    <div class="label-arrow">
                                                        <i class="mdi mdi-chevron-down"></i>
                                                    </div>
                                                </div>
                                                           <span class="empty e-me">Это поле не должно быть пустым</span>
                                                                                            </div>
                                            <div class="label-block">
                                                <label for="">Профессия <span>*</span></label>
                                                <input type="text" name="prof" id="prof" placeholder="" value="${prof}">
 <span class="empty e-prof">Введите профессию</span>
                                                                                            </div>
                                            <div class="label-block">
                                                <label for="">Комментарий</label>
                                                <textarea name="text" id="text" cols="30" rows="10" style="height:100px;">${text}</textarea>
                                                                                            </div>

                                        </form>
                                <form method="post">
                                    <div class="pop-flex-bth">
                                        <button class="more-inf" type="button" onclick="document.querySelector('#auth').remove();">Отмена</button>
                                        <button type="button" class="lock-yes" name="edit-review-${id}" onclick="editReview(${id})">Применить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `
        }


    </script>


    <?php
}


?>

<script language="" src="/static/scripts/catalogLkCompany.js?v=<?= date('YmdHis') ?>"></script>

</body>
</html>