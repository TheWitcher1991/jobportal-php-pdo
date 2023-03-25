<?php

use Work\plugin\lib\pQuery;



$id = (int) $_GET['id'];

$rv = $app->fetch("SELECT * FROM `vacancy` WHERE `id` = :id", [':id' => $id]);


if (empty($rv['id'])) {
    pQuery::notFound();
}

$rcs = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $rv['company_id']]);

$sth = $PDO->prepare("SELECT * FROM `review` WHERE `company_id` = ?");
$sth->execute(array((int) $rcs['id']));
$data = $sth->fetchAll(PDO::FETCH_ASSOC);
$count = count($data);

if ($count > 0) {
    $rating = 0;
    foreach ($data as $row) {
        $rating += $row['rating'];
    }
    $rating = $rating / $count;
}


if (isset($_SESSION['id']) AND $_SESSION['type'] == 'users') {
    $rus = $_SESSION['id'];
} else {
    $rus = 0;
}



if ($rus !== 0) {
    $stmt = $PDO->prepare("SELECT * FROM `online_job` WHERE `users` = ? AND `job` = ?");
    $stmt->execute([$rus, $rv['id']]);
    if ($stmt->rowCount() > 0) {
        $app->execute("UPDATE `online_job` SET `time` = NOW() WHERE `users` = :users AND `job` = :job", [
            ':users' => $rus,
            ':job' => $rv['id']
        ]);
    } else {
        $app->execute("INSERT INTO `online_job` (`ip`, `users`, `time`, `job`, `company`) VALUES(:ip, :users, NOW(), :job, :company)", [
            ':ip' => $_SERVER['REMOTE_ADDR'],
            ':users' => $rus,
            ':job' => $rv['id'],
            ':company' => $rv['company_id']
        ]);
        $app->execute("UPDATE `vacancy` SET `views` = `views` + 1 WHERE `id` = :id", [
            ':id' => $id
        ]);
    }

    $stmt2 = $PDO->prepare("SELECT * FROM `visits_job` WHERE `user` = ? AND `job_id` = ? AND `day` = ? AND `year` = ?");
    $stmt2->execute([$rus, $rv['id'], $Date_ru, date("Y")]);
    if ($stmt2->rowCount() > 0) {
        $date_now = date('Y-m-d H:i:s');
        $stmt = $PDO->prepare("SELECT * FROM `visits_job` WHERE `job_id` = ? AND `user` = ? AND `day` = ? AND `year` = ? AND `time` < SUBTIME(NOW(), '0 0:5:0')");
        $stmt->execute([$rv['id'], $rus, $Date_ru, date("Y")]);
        if ($stmt->rowCount() > 0) {
            $app->execute("UPDATE `visits_job` SET 
                        `counter` = `counter` + 1, 
                        `time` = NOW(),
                        `hour`= :h,
                        `ip` = :ip
                        WHERE `job_id` = :ji AND `user` = :ui AND `day` = :d AND `year` = :yr", [
                ':ji' => $rv['id'],
                ':ui' => $rus,
                ':h' => date("H:i"),
                ':ip' => getIp(),
                ':d' => $Date_ru,
                ':yr' => date("Y"),
            ]);
        }
    } else {
        $app->execute("INSERT INTO `visits_job` (`job`, `job_id`, `company`, `company_id`, `user`, `time`, `hour`, `day`, `ip`, `counter`, `year`) 
        VALUES(:jn, :ji, :cn, :ci, :ui, NOW(), :h, :d, :ip, :counter, :yr)", [
            ':jn' => $rv['title'],
            ':ji' => $rv['id'],
            ':cn' => $rv['company'],
            ':ci' => $rv['company_id'],
            ':ui' => $rus,
            ':h' => date("H:i"),
            ':d' => $Date_ru,
            ':ip' => getIp(),
            ':counter' => 1,
            ':yr' => date("Y")
        ]);
    }

} else {

}


if (isset($_POST['send'])) {
    if (!empty($_POST['text']) and !empty($_POST['loc'])) exit(header('location: /job-list?key='.$_POST['text'].'&loc=' . $_POST['loc']));
    if (!empty($_POST['text']) and empty($_POST['loc'])) exit(header('location: /job-list?key=' . $_POST['text']));
    if (empty($_POST['text']) and !empty($_POST['loc'])) exit(header('location: /job-list?loc=' . $_POST['loc']));
}


Head('Вакансия - ' . $rv['title']);

?>
<body>

<?php require('template/base/nav.php'); ?>

<header id="header-search">
    <?php require('template/base/navblock.php'); ?>
    <div class="header-search-container">
        <div class="container">
            <span class="hs-h">Свежие вакансии</span>
            <form method="post">
                <div class="header-input-container">
                        <div class="hi-field">
                            <i class="mdi mdi-magnify"></i>
                            <input class="hi-title" type="text" name="text" placeholder="Должность или ключевое слово">
                        </div>
                        <div class="hi-field">
                            <i class="mdi mdi-crosshairs-gps"></i>
                            <input class="hi-location" type="text" name="loc" value="Ставропольский край" placeholder="Город">
                        </div>
                        <input type="submit" class="hs-bth" name="send" value="Найти">
                </div>
            </form>
        </div>
    </div>
</header>



    <div id="auth">
        <div class="contact-wrapper">
            <div class="auth-container auth-log">
                <div class="auth-title">
                    Контакты
                    <i class="mdi mdi-close form-close"></i>
                </div>
                <div class="auth-form">
                    <span><i class="icon-briefcase"></i> <?php echo $rv['company'] ?></span>
                    <?php if (trim($rcs['username']) != '') { ?><span><i class="icon-user"></i> <?php echo $rcs['username'] ?></span> <?php } ?>
                    <span><i class="icon-envelope"></i> <?php echo $rv['email'] ?></span>
                    <span><i class="icon-phone"></i> <?php echo $rv['phone'] ?></span>
                </div>
            </div>
        </div>
    </div>


<main id="wrapper" class="wrapper">

    <section class="detail-list-section">
        <div class="container">
            <div class="section-nav" itemscope itemtype="http://schema.org/BreadcrumbList">
                <span itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="/">Главная</a>
                </span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="/job-list">Каталог вакансий</a>
                </span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                    <a itemprop="item"><?php echo $rv['region'] ?></a>
                </span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="/category/?id=<?php echo $rv['category_id'] ?>"><?php echo $rv['category'] ?></a>
                </span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                    <a itemprop="item"><?php echo $rv['title'] ?></a>
                </span>
            </div>





            <article itemscope itemtype="http://schema.org/Article" class="section-items">

                <div class="message-block">

                    <?php
                    if ((int) $_GET['success'] == 1) {
                        echo '<span class="success-blue">Мы отправили отклик работодателю, скоро он с Вами свяжеться! <i class="mdi mdi-close"></i></span>';
                    }
                    ?>

                    <?php
                    if (isset($err['captcha'])) {
                        echo '<span class="success-blue">'.$err['captcha'].' <i class="mdi mdi-close"></i></span>';
                    }
                    ?>

                </div>

                <?php
                if (!isset($_SESSION['id'], $_SESSION['password'])) {
                    ?>
                    <div class="section-no-info">
                        <div class="sn-left">
                            <i class="mdi mdi-lock-outline"></i>
                            <div>
                                <span>Больше информации по вакансии будет доступно после регистрации</span>
                                <p>После регистрации откроем контактные данные и возможность отклика</p>
                            </div>
                        </div>
                        <a href="/create/user">Зарегистрироваться</a>
                    </div>
                    <?php
                }
                ?>


                <div class="errors-block-fix"></div>

                <?php
                if ($rv['status'] != 0) {
                    echo '<span class="lock-site">Вакансия в архиве <br/> Работодатель, вероятно, уже нашел нужного кандидата и больше не принимает отклики на эту вакансию</span>';
                }
                ?>


                <div class="job-detail-block">
                    <div class="job-d-left">
                        <div class="job-d-title job-d">

                            <div>

                            <?
                            $people = $app->count("SELECT * FROM `online_job` WHERE `job` = $rv[id]");

                            $onc = $app->count("SELECT * FROM `online` WHERE `id` = '$rv[company_id]' AND `type` = 'company'");

                            if ($people > 0) {
                            ?>
                                <span class="resume-stat">Сейчас просматривают <?php echo $people ?></span>
                                <?
                            }
                            ?>

                                <?
                                if ($onc > 0) {
                                    ?>
                                    <span class="resume-stat">Работодатель сейчас онлайн</span>
                                    <?
                                }
                                ?>

                            </div>

                            <div class="job-d-name">


                                Вакансия - <?php echo $rv['title'] ?>


                                <?php
                                if ($rv['status'] != 0) {
                                    echo '<span style="font-size: 14px; display: block">Вакансия в архиве с ' . $rv['trash'] . '</span>';
                                }
                                ?>


                            </div>
                            <div class="job-d-date">
                                <span>
                                    <i class="mdi mdi-crosshairs-gps"></i>

                                    <?php echo $rv['region'] . '; ' . $rv['address'] . '; '



                                    ?>

                                    <?php if (trim($rv['urid']) != '' && isset($rv['urid']) && trim($rv['urid']) != 'none') {

                                        echo $rv['urid'];

                                    }?>


                                </span>
                                <span><i class="mdi mdi-clock-time-four-outline"></i> опубликовано: <?php echo $rv['date'] ?>, <?php echo $rv['timses'] ?></span>
                                <span><i class="mdi mdi-eye-outline"></i> <?php echo $rv['views'] ?> просмотров</span>
                            </div>
                        </div>
                        <div class="job-d-content job-d">
                            <div class="job-d-tags">
                                <ul>
                                    <li>
                                        <div class="ji-l"><i class="mdi mdi-currency-rub"></i></div>
                                        <div class="ji-r">
                                            <span>Зарплата</span>
                                            <span><?php

                                            if ($rv['salary'] > 0 && $rv['salary_end'] > 0) {
                                                if ($rv['salary'] == $rv['salary_end']) {
                                                    echo $rv['salary'];
                                                } else {
                                                    echo 'от ' . $rv['salary'] . ' до ' . $rv['salary_end'];
                                                }
                                            } else if ($rv['salary'] > 0 && ($rv['salary_end'] <= 0 || trim($rv['salary_end']) == '')) {
                                                echo 'от ' . $rv['salary'];
                                            } else if (($rv['salary'] <= 0 || trim($rv['salary']) == '') && $rv['salary_end'] > 0) {
                                                echo 'до ' . $rv['salary_end'];
                                            } else {
                                                echo 'по договоренности';
                                            }

                                            ?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ji-l"><i class="mdi mdi-calendar-month-outline"></i></div>
                                        <div class="ji-r">
                                            <span>График работы</span>
                                            <span><?php echo $rv['time']; ?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ji-l"><i class="mdi mdi-clock-time-four-outline"></i></div>
                                        <div class="ji-r">
                                            <span>Тип занятости</span>
                                            <span><?php echo $rv['type']; ?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ji-l"><i class="mdi mdi-briefcase-variant-outline"></i></div>
                                        <div class="ji-r">
                                            <span>Опыт работы</span>
                                            <span><?php echo $rv['exp']; ?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ji-l"><i class="mdi mdi-school-outline"></i></div>
                                        <div class="ji-r">
                                            <span>Образование</span>
                                            <span><?php if (empty($rv['degree']) or $rv['degree'] == 'Не указано') {echo 'Не указано';} else { echo $rv['degree']; } ?></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="job-about job-bag">



                                <div class="addi">
                                    <?php if ($rv['invalid'] == 1) {
                                        ?>
                                        <span><i class="mdi mdi-wheelchair"></i> Доступна людям с инвалидностью</span>
                                        <?php
                                    } ?>
                                    <?php if ($rv['go'] == 1) {
                                        ?>
                                        <span><i class="mdi mdi-plane-car"></i> Поможем с переездом</span>
                                        <?php
                                    } ?>
                                    <?php if (trim($rv['urid']) != '' && isset($rv['urid']) && trim($rv['urid']) != 'none') {
                                        ?>
                                        <span><i class="mdi mdi-map-marker-outline"></i> <?php echo $rv['address'] ?>, <?php echo $rv['urid'] ?> </span>
                                        <?php
                                    } ?>
                                </div>



                                <div>
                                    <?php echo '<pre class="text-content-job">' . $rv['text'] . '</pre>' ?>
                                </div>


                            </div>

                            <?php
                            $sqlsk = "SELECT * FROM `skills_job` WHERE `job_id` = :t";
                            $stmtsk = $PDO->prepare($sqlsk);
                            $stmtsk->bindValue(':t', (int) $rv['id']);
                            $stmtsk->execute();
                            if ($stmtsk->rowCount() > 0) {
                                ?>
                                <div class="resume-d-skills job-bag">
                                    <span>Необходимые навыки</span>
                                    <ul>
                                        <?php
                                        while ($rs = $stmtsk->fetch()) {
                                            ?>
                                            <li>
                                                <a><?php echo $rs['text'] ?></a>

                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <?php
                            }
                            ?>
                        </div>

                        <?php
                        $sql = "SELECT * FROM `vacancy` WHERE (`title` LIKE concat('%', ?, '%') OR `text` LIKE concat('%', ?, '%'))
                                AND `category_id` = ? AND `status` = 0 ORDER BY `id` DESC LIMIT 10";
                        $stmt = $PDO->prepare($sql);
                        $stmt->execute([$rv['title'], $rv['text'], $rv['category_id']]);
                        if ($stmt->rowCount() > 1) {
                        ?>
                    <div class="detail-list-vacancy dl-vac">
                        <span class="dl-h">Рекомендуемые вакансии</span>
                        <ul class="vac-list-ul">
                        <?php
                            while ($r = $stmt->fetch()) {

                                $rc = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $r['company_id']]);

                                if ($r['id'] == $rv['id']) {
                                    continue;
                                }

                                ?>
                                <li class="wow fadeIn">
                                    <div class="vac-name">
                                        <a target="_blank" href="/job?id=<?php echo $r['id'] ?>"><?php echo $r['title'] ?></a>
                                        <span>
                                            <?php

                                            if ($r['salary'] > 0 && $r['salary_end'] > 0) {
                                                echo 'от ' . $r['salary'] . ' до ' . $r['salary_end'];
                                            } else if ($r['salary'] > 0 && ($r['salary_end'] <= 0 || trim($r['salary_end']) == '')) {
                                                echo 'от ' . $r['salary'];
                                            } else if (($r['salary'] <= 0 || trim($r['salary']) == '') && $r['salary_end'] > 0) {
                                                echo 'до ' . $r['salary_end'];
                                            } else {
                                                echo 'договорная';
                                            }

                                            ?>

                                            <i class="mdi mdi-currency-rub"></i>
                                    </span>
                                        <ul class="vl-b-tag">
                                            <li title="Адрес"><i class="icon-location-pin"></i> <?php echo $r['address'] ?></li>
                                            <li title="Опыт работы"><i class="icon-briefcase"></i> <?php echo $r['exp'] ?></li>
                                            <li title="График работы"><i class="icon-calendar"></i> <?php echo $r['time'] ?></li>
                                        </ul>
                                        <?php if ($r['invalid'] == 1 || $r['type'] == 'Удалённая' || $r['type'] == 'Стажировка') { ?>
                                        <ul class="vip-b-tag">
                                            <?php if ($r['type'] == 'Удаленная') { ?> <li><i class="mdi mdi-home"></i> Удалённая работа</li> <?php } ?>
                                            <?php if ($r['type'] == 'Стажировка') { ?> <li><i class="mdi mdi-account-school"></i> Стажировка</li> <?php } ?>
                                            <?php if ($r['invalid'] == 1) { ?> <li><i class="mdi mdi-wheelchair"></i> Люди с инвалидностью</li> <?php } ?>
                                        </ul>
                                        <?php } ?>
                                    </div>

                                    <div class="vac-text">
                                    <span>
                                        <?php echo mb_strimwidth(strip_tags($r['text']), 0, 250, "..."); ?>
                                    </span>
                                    </div>

                                    <div class="vac-comp">

                                            <div class="left">
                                                <span><?php echo $r['date'] ?>, <?php echo $r['timses'] ?></span>

                                                <div <?php if ($rc['verified'] == 1) { echo 'class="shield-hover"'; } ?>>

                                                    <?php if ($rc['verified'] == 1) { echo '
                                                    <div class="shield-wrap">
                                                        <i class="mdi mdi-check-circle-outline shiled-success"></i>
                                                        <div class="shield-block">Компания прошла проверку на сайте.</div>
                                                    </div>
                                                '; } ?>

                                                    <a target="_blank" href="/company/?id=<?php echo $r['company_id'] ?>">
                                                        <?php echo $r['company'] ?>
                                                    </a>


                                                </div>

                                            </div>

                                            <div class="right">
                                                <a target="_blank" href="/company/?id=<?php echo $r['company_id'] ?>">
                                                    <img src="/static/image/company/<?php echo $r['img'] ?>" alt="">
                                                </a>
                                            </div>

                                    </div>

                                </li>
                                <?php
                            }
                                ?>
                            </ul>
                        </div>

                        <?php

                        }
                                ?>
                    </div>

                    <div class="job-d-right">
                        <div class="job-d-company job-d">
                            <div class="jc-img">
                                <?php if ($rv['admin'] == 0) { ?>
                                <span>
                                    <img src="/static/image/company/<?php echo $rv['img'] ?>" alt="">
                                </span>
                                <?php } ?>
                                <?php  $rcc = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $rv['company_id']]); ?>

                                <div class="jb-flex-s">

                                    <?php if ($rcc['verified'] == 1) { echo '
                                                    <div class="shield-wrap shiled-job-w">
                                                        <i class="mdi mdi-check-circle-outline shiled-success"></i>
                                                        <div class="shield-block">Компания прошла проверку на сайте.</div>
                                                    </div>
                                                '; } ?>
                                    <?php if ($rv['admin'] == 0) { ?>
                                        <a href="/company?id=<?php echo $rv['company_id'] ?>">
                                            <?php echo mb_strimwidth(strip_tags($rv['company']), 0, 40, "..."); ?>
                                        </a>
                                    <?php } else {?>
                                        <a>
                                            <?php echo mb_strimwidth(strip_tags($rv['company']), 0, 40, "..."); ?>
                                        </a>
                                        <span>Вакансия выложена администратором</span>
                                        <?php } ?>
                                </div>


                            </div>
                            <?php if (ceil($rating) > 0) { ?>
                                    <div class="job-rating-block">
                                        <span><?php echo ceil($rating); ?></span>
                                        <div class="rating-result" style="width: fit-content">
                                            <span class="<?php if (ceil($rating) >= 1) echo 'active-r'; ?>"></span>
                                            <span class="<?php if (ceil($rating) >= 2) echo 'active-r'; ?>"></span>
                                            <span class="<?php if (ceil($rating) >= 3) echo 'active-r'; ?>"></span>
                                            <span class="<?php if (ceil($rating) >= 4) echo 'active-r'; ?>"></span>
                                            <span class="<?php if (ceil($rating) >= 5) echo 'active-r'; ?>"></span>
                                        </div>
                                    </div>
                            <?php } ?>



                            <div class="job-active">
                                <span>Вакансия активна до</span>

                                <p><?php echo DateTime::createFromFormat('Y-m-d', $rv['task'])->format('d.m.Y');  ?></p>

                                <?php
                                if ($rv['status'] == 0) {
                                    echo ' <div id="timer-job"></div>';
                                }
                                ?>
                            </div>
                            <div class="job-d-button">



                                <?php
                                if ($rv['status'] != 0) {

                                ?>
                                    <span>Работодатель закрыл вакансию</span>
                                    <?php

                                } else {
                                    ?>

                                    <?php
                                    if (isset($_SESSION['id'], $_SESSION['password']) and $_SESSION['type'] == 'users') {

                                        ?>
                                        <button class="job-cont">Контакты</button>

                                        <?php


                                        $sql = "SELECT * FROM `respond` WHERE `job_id` = :ji AND `user_id` = :ui";
                                        $stmt = $PDO->prepare($sql);
                                        $stmt->bindValue(':ji', (int) $rv['id']);
                                        $stmt->bindValue(':ui', (int) $_SESSION['id']);
                                        $stmt->execute();


                                        $ar = $app->rowCount("SELECT * FROM `archive-respond` WHERE `job_id` = :ji AND `user_id` = :ui", [
                                            ':ji' => (int) $rv['id'],
                                            ':ui' => (int) $_SESSION['id'],
                                        ]);

                                        if ($stmt->rowCount() > 0 || $ar > 0) {

                                            $jb = $stmt->fetch();

                                            if ($jb['status'] == 6) {
                                                echo '<span style="text-decoration: underline">Вы не можете оставить отклик, так как компания уже пригласила Вас на эту вакансию</span>';
                                            } else {
                                                echo ' <span style="text-decoration: underline">Вы оставили свой отклик</span>';
                                            }

                                            ?>

                                            <?php
                                        } else{
                                            ?>

                                            <?php if ($rv['admin'] == 0) { ?>
                                                <form action="" method="post">
                                                    <button type="button" onclick="respondVac('<?php echo $rv['id']; ?>')" class="job-send open-job-send">Откликнуться</button>
                                                </form>
                                            <?php } ?>

                                            <?php
                                        };
                                        ?>

                                        <?php

                                    }
                                    ?>



                                    <?php
                                }
                                ?>






                            </div>

                            <div class="link-job-wrap">

                                <div data-jd="<?php echo $rv['id'] ?>" class="print-wrap">
                                    <button type="button" class="print-bth"><i class="mdi mdi-cloud-print-outline"></i></button>
                                    <span class="tooltip-mili tool-print">Печать</span>
                                </div>


                                <div data-jd="<?php echo $rv['id'] ?>" class="link-wrap">
                                    <button onclick="copyLink()" type="button"><i class="mdi mdi-link-variant"></i></button>
                                    <span class="tooltip-mili tool-link">Скопировать ссылку</span>
                                </div>

                                <?php
                                if (isset($_SESSION['id']) && isset($_SESSION['password']) && $_SESSION['type'] == 'users') {
                                    ?>

                                    <?php

                                    $bs = $app->rowCount("SELECT * FROM `bookmark-job` WHERE `job` = :id AND `user` = :ui", [
                                        ':id' => $rv['id'],
                                        ':ui' => $_SESSION['id'],
                                    ]);

                                    if ($bs <= 0) {
                                        ?>


                                        <div data-jd="<?php echo $rv['id'] ?>" class="bookmark-<?php echo $rv['id'] ?>">
                                            <button type="button" onclick="saveJob('<?php echo $rv['id'] ?>')"><i class="mdi mdi-bookmark-outline"></i></button>
                                            <span class="tooltip-mili tool-mark">В избранное</span>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <div data-jd="<?php echo $rv['id'] ?>" class="bookmark-<?php echo $rv['id'] ?>">
                                            <button type="button" class="active-book" onclick="removeJob('<?php echo $rv['id'] ?>')"><i class="mdi mdi-bookmark"></i></button>
                                            <span class="tooltip-mili tool-mark">Убрать из избранного</span>
                                        </div>
                                        <?php
                                    }



                                    ?>

                                    <?php
                                }



                                ?>

                            </div>
                        </div>
                    </div>
                </div>



            </article>
        </div>
    </section>

</main>



<?php require('template/base/footer.php'); ?>

<script>

    function copyLink() {
        let inp = document.createElement('input')
        inp.value = document.location.href;
        document.body.appendChild(inp)
        inp.select()

        if (document.execCommand('copy')) $('.link-wrap span').html('Скопировано').css('width', '100px')
        document.body.removeChild(inp)

    }

    $('.link-wrap button').on('mouseleave', function () {
        setTimeout(function () {
            $('.link-wrap span').html('Скопировать ссылку').css('width', '135px')
        }, 100)
    })

    let countDownDate = new Date("<?php echo $rv['task']; ?>").getTime();
    let x = setInterval(function() {

        let now = new Date().getTime();
        let distance = countDownDate - now;
        let days = Math.floor(distance / (1000 * 60 * 60 * 24));
        let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((distance % (1000 * 60)) / 1000);
        document.querySelector("#timer-job").innerHTML = `<div>${days}д ${hours}ч ${minutes}м ${seconds}с</div>`;
        if (distance <= 0) {
            clearInterval(x);
            if (location.href.indexOf('reload') === -1) {location.href=location.href+'?reload';}
        }
    }, 1000);
</script>


<?php
if (isset($_SESSION['id'], $_SESSION['password']) and $_SESSION['type'] == 'users') {

?>





<script>

    function deleteFormJob(){document.querySelector('.auth-job').remove()}
    function createRespond(id) {
        $('.empty').fadeOut(50)
        $('input').removeClass('errors')
        $('.respond-job').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
        $('.respond-job').attr('disabled', 'true')
        $.ajax({
            url: '/scripts/profile-js',
            data: `${$('.respond-create-form').serialize()}&id=${id}&MODULE_CREATE_RESPOND=1`,
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
                        $('.job-send').remove()

                        deleteFormJob()
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
    function respondVac(id){
        document.querySelector('body').innerHTML+=`

                        <div class="auth-job" id="auth" style="display:flex">
                    <div class="contact-wrapper" style="display:block">
                        <div class="auth-container auth-log" style="display:block">
                            <div class="auth-title">
                                Отклик
                                <i class="mdi mdi-close" onclick="document.querySelector('.auth-job').remove();"></i>
                            </div>
                            <div class="auth-form">

                                <form method="post" role="form" class="respond-create-form">
                                    <div class="label-block">
                                            <label for="letter">Сопроводительное письмо</label>
                                            <textarea name="letter" id="letter" cols="30" rows="5"></textarea>
                                    </div>

                             <div class="pop-text">
                                    Нам надо проверить, что Вы не робот
                                </div>
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
</script>


    <?php
};
?>

</body>
</html>