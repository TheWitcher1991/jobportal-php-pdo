<?php 
use Work\plugin\lib\pQuery;

$id = (int) $_GET['id'];

$rr = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $id]);

if (empty($rr['id'])) {
    $app->notFound();
}


if ($_SESSION['type'] == 'company') {
    $rco = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => (int) $_SESSION['id']]);
}

if (isset($_POST["create-chat"]) AND $_SESSION['type'] == 'company') {

    $app->execute("INSERT INTO `chat` (`user`, `user_id`, `company`, `company_id`, `creates`, `create_type`, `img`, `com_img`, `date`) 
            VALUES(:u, :ui, :cn, :ci, :cs, :ct, :img, :com_img, :d)", [
        ':u' => $rr['name'] . ' ' . $rr['surname'],
        ':ui' => $rr['id'],
        ':cn' => $_SESSION['company'],
        ':ci' => (int) $_SESSION['id'],
        ':cs' => (int) $_SESSION['id'],
        ':ct' => $_SESSION['type'],
        ':img' => $rr['img'],
        ':com_img' => $rco['img'],
        ':d' => $Date
    ]);

    $app->execute("INSERT INTO `notice` (`type`, `title`, `date`, `hour`, `time`, `user_id`, `company_id`, `who`)
                    VALUES(:typ, :title, :dat, :h, NOW(), :ui, :ci, :wh)", [
        ':typ' => 'user_chat',
        ':title' => 'С Вами начали чат!',
        ':dat' => $Date,
        ':h' => date("H:i"),
        ':ui' => $rr['id'],
        ':ci' => $_SESSION['id'],
        ':wh' => 2
    ]);

    exit(header('location: /messages'));

}

if (isset($_SESSION['id']) AND $_SESSION['type'] == 'company') {
    $rus = $_SESSION['id'];
} else {
    $rus = 0;
}

if ($rus !== 0) {
    $stmt = $PDO->prepare("SELECT * FROM `online_resume` WHERE `company` = ? AND `users` = ?");
    $stmt->execute([$rus, $rr['id']]);
    if ($stmt->rowCount() > 0) {
        $app->execute("UPDATE `online_resume` SET `time` = NOW() WHERE `users` = :users AND `company` = :company", [
            ':users' => $rr['id'],
            ':company' => $rus
        ]);
    } else {
        $app->execute("INSERT INTO `online_resume` (`ip`, `users`, `time`, `company`) VALUES(:ip, :users, NOW(), :company)", [
            ':ip' => $_SERVER['REMOTE_ADDR'],
            ':users' => $rr['id'],
            ':company' => $rus
        ]);
        $app->execute("UPDATE `users` SET `view` = `view` + 1 WHERE `id` = :id", [
            ':id' => (int)$rr ['id']
        ]);
    }

    $stmt2 = $PDO->prepare("SELECT * FROM `visits_resume` WHERE `company_id` = ? AND `user` = ? AND `day` = ? AND `year` = ?");
    $stmt2->execute([$rus, $rr['id'], $Date_ru, date("Y")]);
    if ($stmt2->rowCount() > 0) {
        $date_now = date('Y-m-d H:i:s');
        $stmt = $PDO->prepare("SELECT * FROM `visits_resume` WHERE `company_id` = ? AND `user` = ? AND `day` = ? AND `year` = ? AND `time` < SUBTIME(NOW(), '0 0:5:0')");
        $stmt->execute([$_SESSION['id'], $rr['id'], $Date_ru, date("Y")]);
        if ($stmt->rowCount() > 0) {
            $app->execute("UPDATE `visits_resume` SET 
                        `counter` = `counter` + 1, 
                        `time` = NOW(),
                        `hour`= :h,
                        `ip` = :ip
                        WHERE `company_id` = :ji AND `user` = :ui AND `day` = :d AND `year` = :yr", [
                ':h' => date("H:i"),
                ':ip' => getIp(),
                ':ji' => $_SESSION['id'],
                ':ui' => $rr['id'],
                ':d' => $Date_ru,
                ':yr' => date("Y"),
            ]);
        }
    } else {
        $app->execute("INSERT INTO `visits_resume` (`company`, `company_id`, `user`, `time`, `hour`, `day`, `ip`, `counter`, `year`) 
        VALUES(:cn, :ci, :ui, NOW(), :h, :d, :i, :con, :yr)", [
            ':cn' => $_SESSION['company'],
            ':ci' => $rus,
            ':ui' => $rr['id'],
            ':h' => date("H:i"),
            ':d' => $Date_ru,
            ':i' => getIp(),
            ':con' => intval(1),
            ':yr' => date("Y")
        ]);
    }

} else {

}

if (isset($_POST['send'])) {
    if (!empty($_POST['text'])) exit(header('location: /resume-list?key=' . $_POST['text']));
    else exit(header('location: /resume-list'));
}

$countinvite = $app->rowCount("SELECT * FROM `respond` WHERE `status` = 6 AND `user_id` = :id AND `company_id` = :ci", [
    ':id' => $rr['id'],
    ':ci' => $_SESSION['id']
]);


Head('Резюме - ' . $rr['prof']);


?>
<body>

<?php require('template/base/nav.php'); ?>

<header id="header-search">
    <?php require('template/base/navblock.php'); ?>
    <div class="header-search-container">
        <div class="container">
            <form action="" method="post">
                <span class="hs-h">Свежие резюме</span>
                <div class="header-input-container">
                    <div class="hi-field" style="width: 100%;border: 0">
                        <i class="mdi mdi-magnify"></i>
                        <input class="hi-title" type="text" name="text" placeholder="Должность или ключевое слово">
                    </div>

                    <input type="submit" class="hs-bth" name="send" value="Найти">
                </div>
            </form>
        </div>
    </div>
</header>

<?php
if (isset($_SESSION['id'], $_SESSION['password']) and $_SESSION['type'] == 'company') {
    ?>
<div id="auth">
    <div class="respond-wrapper">
        <div class="invite-container auth-log">
            <div class="auth-title">
                Пригласить
                <i class="mdi mdi-close form-close" onclick="deleteForm()"></i>
            </div>
            <div class="auth-form">
                    <form class="form-respond" role="form" method="post">
                        <div style="margin: 0 0 10px 0;" class="label-b-check">
                            <input onclick="
    let c = document.querySelector('#q2')
                    if (c.checked) {
                        $('.text').removeAttr('disabled')
                    } else {
                        $('.text').val('')
                        $('.text').attr('disabled', 'true')
                        $('.form-respond input, .form-respond textarea').removeClass('errors')
                        $('span.error').hide()
                    }
    " checked type="checkbox" class="custom-checkbox" id="q2" name="notext" value="1">
                            <label for="q2">
                                отправить сообщение
                            </label>
                        </div>
                        <div style="margin: 0 0 10px 0;" class="label-block">
                            <label for="">Сообщение <span>*<span></label>
                            <textarea name="text" class="text" id="text" cols="30" rows="10" style="height:95px;">
Здравствуйте, <?php echo $rr['name'] ?>!
Ваше резюме показалось нам очень интересным...
    </textarea>
                            <span class="error e-text" style="display: none">Введите сообщение</span>
                        </div>

                        <div class="vac-invite-wrap">
                            <span>Выберите вакансию, на которую желаете пригласить студента</span>
                            <div class="viw-search">
                                <input placeholder="Заголовок..." type="text" name="viw-text">
                                <button type="button" name="viw-search"><i class="mdi mdi-magnify"></i></button>
                            </div>
                            <div class="viw-ctx">
                                <?php

                                $stmt = $PDO->prepare("SELECT * FROM `vacancy` WHERE `company_id` = ? AND `status` = 0 ORDER BY `id` DESC");
                                $stmt->execute([$rco['id']]);

                                if ($stmt->rowCount() > 0) {
                                    while ($r = $stmt->fetch()) {
                                        echo '
                                            <div class="viw-item select-'.$r['id'].'" data-select="'.$r['id'].'">
                                                <div>
                                                    <a target="_blank" href="/job/?id='.$r['id'].'">'.$r['title'].' <m>'.$r['date'].'</m></a>
                                                    <span>'.$r['time'].', '.$r['type'].', '.$r['address'].'</span>
                                                </div>
                                                <div>
                                                    <button type="button" data-select="'.$r['id'].'" name="access-select"><i class="mdi mdi-check"></i></button>
                                                </div>
                                            </div>
                                        ';
                                    }
                                } else {
                                    echo 'У Вас нет активный вакансий';
                                }





                                ?>
                            </div>
                        </div>

                        <div style="margin: 0 0 10px 0;" class="label-b-check">
                            <input onclick="" checked type="checkbox" class="custom-checkbox" id="q4" name="chaty" value="1">
                            <label for="q4">
                                создать новую ветку чата со студентом по этой вакансии
                            </label>
                        </div>
                    </form>
                    <form method="post">
                        <div class="pop-flex-bth">
                            <button class="more-inf form-close" type="button">Отмена</button>
                            <button onclick="createRespond()" type="button" class="lock-yes">Пригласить</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>


    <div class="contact-wrapper">
        <div class="auth-container auth-log">
            <div class="auth-title">
                Связаться
                <i class="mdi mdi-close form-close"></i>
            </div>
            <div class="auth-form">
                <div class="pop-flex-bth">

                    <?php

                    $countrr = $app->rowCount("SELECT * FROM `respond` WHERE `status` = 6 AND `user_id` = :id", [
                            ':id' => $rr['id']
                    ]);


                    $sql = "SELECT * FROM `chat` WHERE `company_id` = :ji AND `user_id` = :ui";
                    $stmt = $PDO->prepare($sql);
                    $stmt->bindValue(':ji', (int) $_SESSION['id']);
                    $stmt->bindValue(':ui', (int) $rr['id']);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        $chr = $stmt->fetch();
                        ?>

                 <div style="width: 100%">
                     <?php if ($countrr <= 0 && $countinvite <= 0) { ?>
                     <form action="" method="post">
                         <!--<input class="more-inf create-respond-mini" name="create-respond" type="button" value="Пригласить">-->
                     </form>
                     <?php } ?>

                     <span style="display: flex; align-items: center;margin: 0 0 16px 0;flex-wrap: wrap">У вас имеется <a href="/messages?id=<?php echo $chr['id'] ?>">чат</a> с данным студентом</span>

                 </div>


                        <?php
                    } else{
                        ?>
                        <form action="" method="post">
                            <input class="more-inf" name="create-chat" type="submit" value="Начать чат">
                            <!--<?php if ($countrr <= 0 && $countinvite <= 0) { ?><input class="more-inf create-respond-mini" name="create-respond" type="button" value="Пригласить"><?php } ?>-->
                        </form>
                        <?php
                    };
                    ?>

                </div>
                <span><i class="icon-user"></i> <?php echo $rr['name'] . ' ' . $rr['surname'] ?></span>
                <span><i class="icon-envelope"></i> <?php echo $rr['email'] ?></span>
                <span><i class="icon-phone"></i> <?php echo $rr['phone'] ?></span>
                <?php if (trim($rr['vk']) != '') { ?> <span><i class="icon-social-vkontakte"></i> <?php echo $rr['vk'] ?></span> <?php } ?>
                <?php if (trim($rr['telegram']) != '') { ?> <span><i class="icon-paper-plane"></i> <?php echo $rr['telegram'] ?></span> <?php } ?>
                <?php if (trim($rr['github']) != '') { ?> <span><i class="icon-social-github"></i> <?php echo $rr['github'] ?></span> <?php } ?>
                <?php if (trim($rr['skype']) != '') { ?> <span><i class="icon-social-skype"></i> <?php echo $rr['skype'] ?></span> <?php } ?>
            </div>
        </div>
    </div>
</div>
    <?php
}
?>


<main id="wrapper" class="wrapper">

    <section class="detail-list-section">
        <div class="container">
            <div class="section-nav" itemscope itemtype="http://schema.org/BreadcrumbList">
                <span itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="/">Главная</a>
                </span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="/resume-list">Резюме студентов</a>
                </span>



                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="/students/?f=<?php echo $rr['faculty'] ?>"><?php echo $rr['faculty'] ?></a>
                </span>

                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                    <a itemprop="item"><?php echo $rr['direction'] ?></a>
                </span>

                <span><i class="fa-solid fa-chevron-right"></i></span>
                <?php if (isset($rr['category']) && trim($rr['category']) != '') { ?>
                <span itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                    <a itemprop="item"><?php echo $rr['category'] ?></a>
                </span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <?php } ?>
                <span itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="/resume/?id=<?php echo $rr['id'] ?>"><?php echo $rr['prof'] ?></a>
                </span>
            </div>



            <article itemscope itemtype="http://schema.org/Article" class="section-items">

                <?php
                if (!isset($_SESSION['id'], $_SESSION['password'])) {
                    ?>
                    <div class="section-no-info">
                        <div class="sn-left">
                            <i class="mdi mdi-lock-outline"></i>
                            <div>
                                <span>Больше информации по резюме будет доступно после регистрации</span>
                                <p>После регистрации откроем фото и контактные данные</p>
                            </div>
                        </div>
                        <a href="/create/employers">Зарегистрироваться</a>
                    </div>
                    <?php
                }
                ?>


                <div class="errors-block-fix">

                </div>


                <div class="message-block"></div>

                <div class="resume-detail-block">
                    <div class="resume-d-left resume-d">
                        <div class="resume-d-img">
                            <div class="rd-img">

                                <?php
                                    if (!isset($_SESSION['id'], $_SESSION['password'])) {
                                        ?>
                                        <span class="resume-lock-photo lock-photo">
                                                    <m><i class="icon-lock"></i></m>
                                                    <img src="/static/image/users/placeholder.png"
                                                         alt="">
                                                </span>
                                        <?php
                                    } else {
                                ?>
                                        <span>
                                            <img src="/static/image/users/<?php echo $rr['img'] ?>"
                                                 alt="">
                                        </span>
                                        <?php
                                    };
                                ?>

                            </div>
                            <div class="rsn-name rsn-print" style="margin: 0;text-align: center">

                                <?php
                                if (!isset($_SESSION['id'], $_SESSION['password'])) {
                                    ?>
                                    <span class="rsn-1">*********</span>
                                    <?php
                                } else {
                                    ?>
                                    <span class="rsn-1"><?php echo $rr['name'] . ' ' . $rr['surname'] ?></span>
                                    <?php
                                };
                                ?>

                                <span itemprop="headline" class="rsn-2"><?php echo $rr['prof'] ?></span>
                            </div>
                            <div class="rd-name">

                                <?php
                                if (isset($_SESSION['id'], $_SESSION['password']) && $_SESSION['type'] == 'company') {
                                ?>

                                <ul class="social-list">
                                    <li><a class="vk-bth" href="tel:+<?php echo phone_format2(trim($rr['phone'])); ?>"><i class="mdi mdi-phone-in-talk"></i></a></li>
                                    <li><a target="_blank" class="whatsapp-bth" href="https://api.whatsapp.com/send?phone=<?php echo phone_format2(trim($rr['phone'])); ?>"><i class="mdi mdi-whatsapp"></i></a></li>
                                    <li><a target="_blank" class="viber-bth" href="viber://chat?number=+<?php echo phone_format2(trim($rr['phone'])); ?>"><i class="fa-brands fa-viber"></i></a></li>
                                    <li><a class="mail-bth" href="mailto:<?php echo $rr['email']; ?>"><i class="mdi mdi-at"></i></a></li>
                                    <!--<?php if (trim($rr['vk']) != '') { ?>  <li><a class="vk-bth" href="<?php echo $rr['vk'] ?>"><i class="fa-brands fa-vk"></i></a></li> <?php } ?>
                                <?php if (trim($rr['telegram']) != '') { ?>  <li><a class="telegram-bth" href="<?php echo $rr['telegram'] ?>"><i class="fa-brands fa-telegram"></i></i></a></li> <?php } ?>
                                <?php if (trim($rr['github']) != '') { ?>  <li><a class="github-bth" href="<?php echo $rr['github'] ?>"><i class="fa-brands fa-github"></i></a></li> <?php } ?>
                                <?php if (trim($rr['dribbble']) != '') { ?>  <li><a class="dribbble-bth" href="<?php echo $rr['dribbble'] ?>"><i class="fa-brands fa-dribbble"></i></a></li> <?php } ?>
                                <?php if (trim($rr['pinterest']) != '') { ?>  <li><a class="pinterest-bth" href="<?php echo $rr['pinterest'] ?>"><i class="fa-brands fa-pinterest-p"></i></a></li> <?php } ?>
                                <?php if (trim($rr['skype']) != '') { ?>  <li><a class="skype-bth" href="<?php echo $rr['skype'] ?>"><i class="fa-brands fa-skype"></i></i></a></li> <?php } ?>-->
                                </ul>

                                    <?php
                                }
                                ?>

                            </div>
                            <div class="rd-bth"><a class="job-print print-bth">Распечатать</a></div>
                            <div class="rd-bth">

                                <?php
                                if (isset($_SESSION['id'], $_SESSION['password']) and $rr['doc'] and $_SESSION['type'] == 'company') {
                                    ?>
                                    <a href="">Скачать документ</a>
                                    <?php
                                }
                                ?>




                            </div>
                        </div>
                        <div class="resume-d-info">
                            <ul class="detail-info-ul">
                                <?php if (!empty($rr['exp'])) { ?>
                                    <li>
                                        <div class="di-l"><i class="mdi mdi-briefcase-variant-outline"></i></div>
                                        <div class="di-r">
                                            <span>Опыт работы</span>
                                            <span><?php echo $rr['exp'] ?></span>
                                        </div>
                                    </li>
                                <?php } ?>
                                <li>
                                    <div class="di-l"><i class="mdi mdi-school-outline"></i></div>
                                    <div class="di-r">
                                        <span>Образование</span>
                                        <span><?php echo $rr['degree'] ?></span>
                                    </div>
                                </li>
                                <?php if (!empty($rr['city'])) { ?>
                                    <li>
                                        <div class="di-l"><i class="mdi mdi-home-city-outline"></i></div>
                                        <div class="di-r">
                                            <span>Город</span>
                                            <span><?php echo $rr['city'] ?></span>
                                        </div>
                                    </li>
                                <?php } ?>
                                <li>
                                    <div class="di-l"><i class="mdi mdi-currency-rub"></i></div>
                                    <div class="di-r">
                                        <span>Зарплата</span>
                                        <span><?php if(!empty($rr['salary'])) { echo $rr['salary']; } else {echo "По договорённости"; } ?></span>
                                    </div>
                                </li>
                                <?php if (!empty($rr['time'])) { ?>
                                    <li>
                                        <div class="di-l"><i class="mdi mdi-calendar-month-outline"></i></div>
                                        <div class="di-r">
                                            <span>График работы</span>
                                            <span><?php echo $rr['time']; ?></span>
                                        </div>
                                    </li>
                                <?php } ?>
                                <?php if (!empty($rr['type'])) { ?>
                                    <li>
                                        <div class="di-l"><i class="mdi mdi-clock-outline"></i></div>
                                        <div class="di-r">
                                            <span>Тип занятости</span>
                                            <span><?php echo $rr['type']; ?></span>
                                        </div>
                                    </li>
                                <?php } ?>
                                <?php if (!empty($rr['drive'])) { ?>
                                <li>
                                    <div class="di-l"><i class="mdi mdi-car"></i></div>
                                    <div class="di-r">
                                        <span>Водительские права</span>
                                        <span><?php echo $rr['drive']; ?><?php if ($rr['car'] == 1) echo ', имею личное авто' ?> </span>
                                    </div>
                                </li>
                                <?php } ?>
                                <?php if (!empty($rr['age']) && !empty($_SESSION['type'])) { ?>
                                <li>
                                    <div class="di-l"><i class="mdi mdi-baby-face-outline"></i></div>
                                    <div class="di-r">
                                        <span>Дата рождения</span>
                                            <span><?php echo $rr['age'] . ' ('.calculate_age($rr['age']).')'; ?></span>
                                    </div>
                                </li>
                                <?php } ?>
                                <?php if (!empty($rr['gender']) && !empty($_SESSION['type'])) { ?>
                                    <li>
                                        <div class="di-l"><i class="mdi mdi-gender-male"></i></div>
                                        <div class="di-r">
                                            <span>Пол</span>
                                            <span><?php echo $rr['gender']; ?></span>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>

                        <div class="resume-d-contact"></div>
                    </div>
                    <div class="resume-d-right resume-d">

                        <?php

                        if ($rr['id'] == $_SESSION['id'] && $_SESSION['type'] == 'users') {
                            echo '<a class="resume-fix-bth-1 resume-fix-bth" href="/profile"><i class="mdi mdi-account-edit"></i></a>';
                        }

                        ?>

                        <div class="" style="margin: 0 0 10px 0;">

                            <?php
                            $onr = $app->count("SELECT * FROM `online` WHERE `id` = '$rr[id]' AND `type` = 'users'");
                            if ($onr > 0) {
                                echo '<span class="resume-stat">Сейчас на сайте</span>';
                            }
                            ?>
                            <?php
                            $peo = $app->count("SELECT * FROM `online_resume` WHERE `users` = $rr[id]");
                            if ($peo > 0) {
                                echo '<span class="resume-stat">Сейчас просматривают ' . $peo . '</span>';
                            }
                            ?>
                            <span class="resume-stat"><?php echo $rr['stat'] ?></span>
                        </div>
                        <div class="rsn-wrap">
                            <div class="rsn-name rsn-no-print">

                                <?php
                                if (!isset($_SESSION['id'], $_SESSION['password'])) {
                                    ?>
                                    <span class="rsn-1">*********</span>
                                    <?php
                                } else {
                                    ?>
                                    <span class="rsn-1"><?php echo $rr['name'] . ' ' . $rr['surname'] ?></span>
                                    <?php
                                };
                                ?>

                                <span itemprop="headline" class="rsn-2"><?php echo $rr['prof'] ?></span>
                            </div>
                            <?php
                            if (isset($_SESSION['id'], $_SESSION['password']) and $_SESSION['type'] == 'company') {
                                ?>
                                    <div class="rd-bth"><a class="job-cont">Связаться</a></div>

                                <?php
                            }
                            ?>
                        </div>



                        <div class="resume-d-about res-bag">
                            <span><m><i class="mdi mdi-information-outline"></i></m> Обо мне</span>
                            <p>
                                <?php
                                if (!empty($rr['about'])) {
                                    echo '<pre class="text-content-job">' . $rr['about'] . '</pre>' ;
                                } else {
                                    echo 'Нет информации';
                                }
                                ?>
                            </p>
                        </div>



                        <?php


                        $sqled = "SELECT * FROM `exp` WHERE `user_id` = :t";
                        $stmted = $PDO->prepare($sqled);
                        $stmted->bindValue(':t', $rr['id']);
                        $stmted->execute();
                        if ($stmted->rowCount() > 0) {
                        ?>
                        <div class="resume-d-exp res-bag">
                            <span><m><i class="mdi mdi-briefcase-variant-outline"></i></m> Опыт работы

                                <?php

                                if ($rr['id'] == $_SESSION['id'] && $_SESSION['type'] == 'users') {
                                    echo '<a class="resume-fix-bth-2 resume-fix-bth" href="/add-exp"><i class="mdi mdi-pencil"></i></a>';
                                }

                                ?>
                            </span>
                            <div class="db-text">
                                <ul class="dl-exp">
                                    <?php
                                    while ($rx = $stmted->fetch()) {
                                        ?>
                                        <li>
                                            <div class="de-time">
                                                <?php
                                                echo $arr_m[(DateTime::createFromFormat('m.Y', $rx['date_1'])->format('n'))] . ' ' .
                                                DateTime::createFromFormat('m.Y', $rx['date_1'])->format('Y') .  ' — <br />';

                                                $date1 = DateTime::createFromFormat('m.Y', $rx['date_1'])->format('Y-m').'-1';
                                                $date1 = new DateTime($date1);

                                                $date2 = '';

                                                if ($rx['present'] == 1) {
                                                    $date2 = date('Y.m.d');
                                                    $date2 = DateTime::createFromFormat('Y.m.d', $date2)->format('Y-m-d');
                                                    $date2 = new DateTime($date2);
                                                    echo 'по настоящее время';
                                                } else {
                                                    $date2 = DateTime::createFromFormat('m.Y', $rx['date_2'])->format('Y-m-d');
                                                    $date2 = new DateTime($date2);
                                                    echo $arr_m[(DateTime::createFromFormat('m.Y', $rx['date_2'])->format('n'))] . ' ' .
                                                        DateTime::createFromFormat('m.Y', $rx['date_2'])->format('Y');
                                                }


                                                $period = getPeriod($date1,$date2);

                                                ?>
                                                <p> <?php echo $period; ?></p>
                                            </div>
                                            <div class="de-content">
                                                <span class="dle-t"><?php echo $rx['title']; ?></span>
                                                <span class="dle-p"><?php echo $rx['prof']; ?></span>
                                                <div class="dle-text">
                                                    <p>
                                                        <?php echo $rx['text']; ?>
                                                    </p>
                                                </div>
                                            </div>

                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <?php
                        }
                        ?>

                        <?php
                        $sqled = "SELECT * FROM `education` WHERE `user_id` = :t";
                        $stmted = $PDO->prepare($sqled);
                        $stmted->bindValue(':t', $rr['id']);
                        $stmted->execute();
                        if ($stmted->rowCount() > 0) {
                            ?>
                            <div class="resume-d-education res-bag">
                            <span><m><i class="mdi mdi-school-outline"></i></m> Образование

                                <?php

                                if ($rr['id'] == $_SESSION['id'] && $_SESSION['type'] == 'users') {
                                    echo '<a class="resume-fix-bth-2 resume-fix-bth" href="/add-education"><i class="mdi mdi-pencil"></i></a>';
                                }

                                ?>

                            </span>
                                <div class="db-text">
                                    <ul class="dl-exp">
                                        <?php
                                        while ($re = $stmted->fetch()) {
                                            ?>
                                            <li>
                                                <div class="de-time">
                                                    <?php echo $re['date']; ?>
                                                </div>
                                                <div class="de-content">
                                                    <span class="dle-t"><?php echo $re['title']; ?></span>
                                                    <span class="dle-p"><?php echo $re['prof']; ?></span>
                                                    <div class="dle-text">
                                                        <p>
                                                            <?php echo $re['text']; ?>
                                                        </p>
                                                    </div>
                                                </div>

                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <?php
                        }

                        ?>

                        <?php


                        $sqled = "SELECT * FROM `achievement` WHERE `user` = :t";
                        $stmted = $PDO->prepare($sqled);
                        $stmted->bindValue(':t', $rr['id']);
                        $stmted->execute();
                        if ($stmted->rowCount() > 0) {
                            ?>
                            <div class="resume-d-exp res-bag">
                                <span><m><i class="mdi mdi-trophy-variant-outline"></i></m> Достижения
                                    <?php

                                    if ($rr['id'] == $_SESSION['id'] && $_SESSION['type'] == 'users') {
                                        echo '<a class="resume-fix-bth-2 resume-fix-bth" href="/add-achievement"><i class="mdi mdi-pencil"></i></a>';
                                    }

                                    ?>
                                </span>
                                <div class="db-text">
                                    <ul class="dds-exp">
                                        <?php
                                        while ($rx = $stmted->fetch()) {
                                            ?>
                                            <li>
                                                <div class="dle-title">
                                                    <span class="dle-t"><?php echo $rx['name']; ?></span>
                                                    <span class="dle-time"><?php echo $rx['type']; ?></span>
                                                </div>
                                                <div class="dle-text">
                                                    <p> <?php echo $rx['text']; ?></p>
                                                </div>
                                                <?php

                                                if ($_SESSION['type'] == 'company' || ($rr['id'] == $_SESSION['id'] && $_SESSION['type'] == 'users')) {


                                                $sqlei = "SELECT * FROM `achievement_images` WHERE `user_id` = :ui AND `hash` = :hash ORDER BY `id` DESC";
                                                $stmtei = $PDO->prepare($sqlei);
                                                $stmtei->bindValue(':ui', $rr['id']);
                                                $stmtei->bindValue(':hash', $rx['hash']);
                                                $stmtei->execute();

                                                if ($stmtei->rowCount() > 0) {


                                                ?>
                                                <div class="dle-img">
                                                    <?php while ($i = $stmtei->fetch()) {

                                                        $ext = mb_strtolower(mb_substr(mb_strrchr(@$i['filename'], '.'), 1));


                                                        ?>
                                                        <a class="none" href="/static/file/users_file/<?php echo $i['filename'] ?>" download=""><i class="icon-cloud-download"></i> .<?php echo $ext ?></a>


                                                    <?php } ?>


                                                </div>
                                                <?php }
                                                }
                                                ?>
                                            </li>

                                            <?php

                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                        <div class="addi">
                            <?php if ($rr['inv'] == 1) {
                                ?>
                                <span><i class="mdi mdi-wheelchair"></i> Есть инвалидность</span>
                                <?php
                            } ?>
                            <?php if ($rr['go'] == 1) {
                                ?>
                                <span><i class="mdi mdi-plane-car"></i> Готов к переезду</span>
                                <?php
                            } ?>
                        </div>

                        <?php
                        $sqlsk = "SELECT * FROM `skills_resume` WHERE `user_id` = :t ORDER BY `id` DESC";
                        $stmtsk = $PDO->prepare($sqlsk);
                        $stmtsk->bindValue(':t', (int) $rr['id']);
                        $stmtsk->execute();
                        if ($stmtsk->rowCount() > 0) {
                            ?>

                            <div class="resume-d-skills res-bag">
                                <span><m><i class="mdi mdi-brain"></i></m> Ключевые навыки</span>
                                <div class="res-tags">
                                    <?php
                                    while ($rs = $stmtsk->fetch()) {
                                        ?>
                                        <div>
                                            - <?php echo $rs['text'] ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                        <?php
                        $sqlsk = "SELECT * FROM `lang` WHERE `user` = :t ORDER BY `id` DESC";
                        $stmtsk = $PDO->prepare($sqlsk);
                        $stmtsk->bindValue(':t', (int) $rr['id']);
                        $stmtsk->execute();
                        if ($stmtsk->rowCount() > 0) {
                            ?>

                            <div class="resume-d-lang res-bag">
                                <span><m><i class="mdi mdi-translate"></i></m> Знание языков</span>
                                <div class="res-tags">
                                    <?php
                                    while ($rs = $stmtsk->fetch()) {
                                        ?>
                                        <div>
                                            <?php echo $rs['name'] ?> - <?php echo $rs['lvl'] ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>



                    </div>
                </div>

            </article>


        </div>
    </section>
</main>



<?php require('template/base/footer.php'); ?>

<?php if ($_SESSION['type'] == 'company' && isset($_SESSION['id'])) { ?>

<script>

    function createRespond() {
        $('#auth .error').fadeOut(50)
        $('#auth select').removeClass('errors')
        $('#auth input').removeClass('errors')
        $('.lock-yes').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
        $('.lock-yes').attr('disabled', 'true')
        $.ajax({
            url: '/scripts/respond-js',
            data: `id=${<?php echo $rr['id']; ?>}&MODULE_INVITE=1&${$('.form-respond').serialize()}`,
            type: 'POST',
            cache: false,
            dataType: 'json',
            error: (response) => {
                $('.lock-yes').removeAttr('disabled')
                $('.lock-yes').html('Пригласить')
                MessageBox('Произошла ошибка. Повторите')
            },
            success: function (responce) {
                if (responce.code === 'success') {
                    $('.respond-wrapper').remove()
                    $('.create-respond-mini').remove()
                    $('#auth').removeClass('auth-b-act');
                    $('body').removeClass('body-hidden');
                    $('.lock-yes').html('Пригласить')
                    $('.message-block').html('<span class="success-blue">Мы отправили приглашение студенту, скоро он с Вами свяжется! <i onclick="$(this).parent().remove()" class="mdi mdi-close"></i></span>')
                } else {
                    if (responce.code === 'validate_error') {
                        $('.lock-yes').removeAttr('disabled')
                        $('.lock-yes').html('Пригласить')
                        let $r = responce.array;
                        if ($r['text']) {
                            $('.text').addClass('errors')
                            $('.e-text').show()
                        }
                    } else {
                        $('.lock-yes').removeAttr('disabled')
                        $('.lock-yes').html('Пригласить')
                        MessageBox('Произошла ошибка. Повторите')
                    }
                }
            }
        })



    }


</script>

<?php  } ?>


</body>
</html>