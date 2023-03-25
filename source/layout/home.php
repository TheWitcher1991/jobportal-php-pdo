<?php

if (isset($_POST['send'])) {

    if ($_POST['text']) {
        $app->execute("INSERT INTO `search` (`text`, `date`) VALUES(:t, :d)", [
            ':t' => $_POST['text'],
            ':d' => date('Y-m-d')
        ]);
    }

    if (!empty($_POST['text']) and !empty($_POST['loc'])) exit(header('location: /job-list?key='.$_POST['text'].'&loc=' . $_POST['loc']));
    else if (!empty($_POST['text']) and empty($_POST['loc'])) exit(header('location: /job-list?key=' . $_POST['text']));
    else if (empty($_POST['text']) and !empty($_POST['loc'])) exit(header('location: /job-list?loc=' . $_POST['loc']));
}


Head('СтГАУ Агрокадры');





?>
<body>

<?php require('template/base/nav.php'); ?>

<?php require('template/base/header.php'); ?>

<div id="auth">
    <div class="contact-wrapper">
        <div class="auth-container auth-log">
            <div class="auth-title">
                Контакты
                <i class="mdi mdi-close form-close"></i>
            </div>
            <div class="auth-form">
                <span class="company"><i class="icon-briefcase"></i> ></span>
                <span class="user"><i class="icon-user"></i> </span>
                <span class="email"><i class="icon-envelope"></i> </span>
                <span class="phone"><i class="icon-phone"></i> </span>
            </div>
        </div>
    </div>
</div>

<main id="wrapper" class="wrapper">


    <section class="about-home for-student">
        <div class="container wow fadeIn about-container">
            <div class="about-left-img">
                <span>
                    <img src="/static/image/home/4.jpg" alt="">
                </span>
                <div class="card-about card-about-1 ">
                    <span><? echo $app->count("SELECT * FROM `company` WHERE `ban` = 0"); ?> компаний</span>
                    <div>
                        <?php
                        $sql = $app->query("SELECT * FROM `company` WHERE `ban` = 0 AND `img` != 'placeholder.png' ORDER BY `job` DESC LIMIT 6");
                        $i = 1;
                        while ($r = $sql->fetch()) {





                        ?>

                            <a href="/company/?id=<?php echo $r['id'] ?>" class="card-img-<?php echo $i ?>">
                                <img src="/static/image/company/placeholder.png" alt="">
                            </a>

                            <?php
                            $i++;
                        }
                        ?>
                    </div>
                </div>

                <div class="card-about-cat card-about-2 ">
                    <span>Множество отраслей</span>
                    <div>
                        <?php
                        $sql = $app->query("SELECT * FROM `category` ORDER BY `job` DESC LIMIT 6");
                        $i = 1;
                        while ($r = $sql->fetch()) {
                            ?>

                            <a href="/category/?id=<?php echo $r['id'] ?>" class="card-ico-<?php echo $i; ?>">
                                <i class="mdi mdi-<?php echo $r['icon'] ?>"></i>
                            </a>


                            <?php
                            $i++;
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="about-right-text about-text">
                <h1>Профессиональное резюме — ваш билет на работу мечты</h1>
                <span>Ставропольский ГАУ заботится о своих студентах. Мы поможем Вам найти подходящую работу и трудоустроиться,
                    но для начала — надо создать аккаунт и заполнить резюме — это займет пару минут.</span>

                <? if (isset($_SESSION['id']) && $_SESSION['type'] == 'users') { ?>
                <a href="/profile">Заполнить резюме</a>
                <? } else if (isset($_SESSION['id']) && $_SESSION['type'] == 'company') { ?>

                <? } else { ?>
                <a href="/create/user">Создать аккаунт</a>
                <? } ?>

            </div>
        </div>

        <div class="container wow fadeIn company-stav-container">
            <span>Компании из Ставрополья</span>
            <ul class="stav-li">

                <?php
                $sql = $app->query("SELECT * FROM `company` WHERE `ban` = 0 AND (`address` = 'Ставрополь' OR `address` = 'Ессентуки') ORDER BY RAND() DESC LIMIT 6");
                while ($r = $sql->fetch()) {





                    ?>

                        <li>
                            <a target="_blank" href="/company/?id=<?php echo $r['id'] ?>">
                                <img src="/static/image/company/<?php echo $r['img'] ?>" alt="">
                            </a>

                        </li>

                    <?php
                }
                ?>

            </ul>
        </div>
    </section>


    <!--<section class="home-section stats">
        <div class="container">
            <div class="section-items">
                <ul class="stats-ul">
                    <li class="fadeIn wow">
                        <span class="counter"><? echo $app->count("SELECT * FROM `vacancy` WHERE `status` = 0"); ?></span>
                        <span class="s-i"><? echo $app->count("SELECT * FROM `vacancy` WHERE `status` = 0"); ?> открытых вакансий</span>
                    </li>
                    <li class="fadeIn wow">
                        <span class="counter"><? echo $app->count("SELECT * FROM `users`") ?></span>
                        <span class="s-i"><? echo $app->count("SELECT * FROM `users`"); ?> готовых резюме</span>
                    </li>
                    <li class="fadeIn wow">
                        <span class="counter"><? echo $app->count("SELECT * FROM `company`") ?></span>
                        <span class="s-i"><? echo $app->count("SELECT * FROM `company`"); ?> активных компаний</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>-->



    <section class="home-section popular categ">
        <div class="container wow fadeIn">
            <div class="section-header">
                <span class="home-title">Популярные отрасли по всем регионам</span>
            </div>
            <div class="section-items">
                <ul class="category-male">
                    <?php
                    $sql = $app->query("SELECT * FROM `category` ORDER BY `job` DESC LIMIT 12");
                    while ($r = $sql->fetch()) {

                        $sqlc = "SELECT * FROM `vacancy` WHERE `category_id` = :n";
                        $stmtc = $PDO->prepare($sqlc);
                        $stmtc->bindValue(':n', $r['id']);
                        $stmtc->execute();

                        $salary = 0;
                        $i = 0;

                        while ($d = $stmtc->fetch()) {
                            $salary += (int) $d['salary'] + $d['salary_end'];
                            if ($d['salary'] > 0 && $d['salary_end'] > 0) {
                                $i += 2;
                            } else if ($d['salary'] > 0 && empty($d['salary_end'])) {
                                $i += 1;
                            } else if ($d['salary_end'] > 0 && empty($d['salary'])) {
                                $i += 1;
                            }
                        }
                    ?>

                    <li>
                        <a target="_blank" href="/category?id=<?php echo $r['id'] ?>">
                            <div class="cat-b-1">
                                <span><?php echo mb_strimwidth($r['name'], 0, 30, "..."); ?></span>
                                <p><?php if ($i > 0) { echo ceil($salary / $i); } else { echo '0'; }  ?> руб. в среднем</p>
                            </div>
                            <div class="cat-b-2">
                            <span class="cat-icon">
                                <i class="mdi mdi-<?php echo $r['icon'];  ?>"></i>
                            </span>
                            </div>
                        </a>
                    </li>
                        <?php
                    }
                    ?>


                </ul>
            </div>
            <div class="section-bth">
                <a href="/all">Полный список</a>
            </div>
        </div>
    </section>


    
    <section class="home-section pop-b popular popular-vacancy">
        <div class="container">
            <div class="section-items section-slider">

                <div class="pop-v-block">
                    <div class="section-header">
                        <span class="home-title">Последние вакансии во всех регионах</span>
                    </div>




                    <ul class="vac-home">
                        <?php
                        $count = 0;
                        $sql = $app->query("SELECT * FROM `vacancy` WHERE `status` = 0 ORDER BY `id` DESC LIMIT 8");

                        if ($sql->rowCount() > 0) {

                            while ($r = $sql->fetch()) {


                                ?>
                                <li data-jd="<?php echo $r['id'] ?>" class="wow fadeIn">
                                    <?php
                                        $onv = $app->count("SELECT * FROM `online_job` WHERE `job` = '$r[id]'");
                                        if ($onv > 0) {
                                            ?>
                                            <div class="resume-stat">Сейчас просматривают <?php echo $app->count("SELECT * FROM `online_job` WHERE `job` = $r[id]"); ?></div>
                                            <?php
                                        }
                                    ?>
                                    <?php
                                    $onc = $app->count("SELECT * FROM `online` WHERE `id` = '$r[company_id]' AND `type` = 'company'");
                                    if ($onc > 0) {
                                        ?>
                                        <div class="resume-stat">Работодатель сейчас онлайн</div>
                                        <?php
                                    }
                                    ?>



                                    <div class="vac-name">

                                        <div class="vac-name-a">
                                            <a target="_blank" href="/job?id=<?php echo $r['id'] ?>"><?php echo $r['title'] ?></a>

                                            <?php
                                            if (isset($_SESSION['id']) && isset($_SESSION['password']) && $_SESSION['type'] == 'users') {
                                            ?>

                                            <?php

                                            $bs = $app->rowCount("SELECT * FROM `bookmark-job` WHERE `job` = :id AND `user` = :ui", [
                                                ':id' => $r['id'],
                                                ':ui' => $_SESSION['id'],
                                            ]);

                                            if ($bs <= 0) {
                                                ?>


                                                <div data-jd="<?php echo $r['id'] ?>" class="bookmark-wrap bookmark-li bookmark-<?php echo $r['id'] ?>">
                                                    <button type="button" onclick="saveJob('<?php echo $r['id'] ?>')"><i class="mdi mdi-bookmark-outline"></i></button>
                                                </div>
                                                <?php
                                            } else {
                                                    ?>
                                                <div data-jd="<?php echo $r['id'] ?>" class="bookmark-wrap bookmark-li bookmark-<?php echo $r['id'] ?>">
                                                    <button type="button" class="active-book" onclick="removeJob('<?php echo $r['id'] ?>')"><i class="mdi mdi-bookmark"></i></button>
                                                </div>
                                                    <?php
                                                }



                                            ?>

                                                <?php
                                            }



                                            ?>

                                        </div>


                                        <span>
                                                <?php

                                                $rc = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $r['company_id']]);

                                                if ($r['salary'] > 0 && $r['salary_end'] > 0) {

                                                    if ($r['salary'] == $r['salary_end']) {
                                                        echo $r['salary'];
                                                    } else {
                                                        echo 'от ' . $r['salary'] . ' до ' . $r['salary_end'];
                                                    }


                                                } else if ($r['salary'] > 0 && ($r['salary_end'] <= 0 || trim($r['salary_end']) == '')) {
                                                    echo 'от ' . $r['salary'];
                                                } else if (($r['salary'] <= 0 || trim($r['salary']) == '') && $r['salary_end'] > 0) {
                                                    echo 'до ' . $r['salary_end'];
                                                } else {
                                                    echo 'по договоренности';
                                                }

                                                ?>

                                                <i class="mdi mdi-currency-rub"></i>
                                        </span>
                                        <ul class="vl-b-tag">
                                            <li title="Адрес"><i class="mdi mdi-crosshairs-gps"></i> <?php echo $r['address'] ?></li>
                                            <li title="Опыт работы"><i class="mdi mdi-briefcase-variant-outline"></i> <?php echo $r['exp'] ?></li>
                                            <li title="График работы"><i class="mdi mdi-calendar-month-outline"></i> <?php echo $r['time'] ?></li>

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
                                            <?php if ($r['admin'] == 0) { ?>
                                            <div <?php if ($rc['verified'] == 1) { echo 'class="shield-hover"'; } ?>>

                                                <?php if ($rc['verified'] == 1) { echo '
                                                    <div class="shield-wrap">
                                                        <i class="mdi mdi-check-circle-outline shiled-success"></i>
                                                        <div class="shield-block">Компания прошла проверку на сайте.</div>
                                                    </div>
                                                '; } ?>



                                                    <a target="_blank" href="/company/?id=<?php echo $r['company_id'] ?>">
                                                        <?php



                                                        echo mb_strimwidth(strip_tags($r['company']), 0, 20, "..."); ?>
                                                    </a>


                                            </div>

                                            <?php } else { ?>

                                                <div class="shield-hover">



                                                    <div class="shield-wrap">
                                                        <i class="mdi mdi-alert-circle-outline shiled-success shiled-admin"></i>
                                                        <div class="shield-block">Вакансия выложена администратором</div>
                                                    </div>

                                                    <a>
                                                        <?php echo mb_strimwidth(strip_tags($r['company']), 0, 20, "..."); ?>
                                                    </a>


                                                </div>

                                            <?php } ?>

                                        </div>
                                        <div class="right">
                                            <?php if ($r['admin'] == 0) {

                                                if ($r['img'] != 'placeholder.png') {


                                                ?>
                                                <a target="_blank" href="/company/?id=<?php echo $r['company_id'] ?>">
                                                    <img




                                                            src="/static/image/company/<?php echo $r['img'] ?>" alt="">
                                                </a>
                                            <?php

                                                }
                                            } ?>


                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                        } else {
                            echo '<span>Вакансии не найдены</span>';
                        }
                        ?>
                    </ul>
                </div>



                <div class="sect-slide">

                    <div>
                        <?php
                        $sql = $app->query("SELECT * FROM `company` WHERE `ban` = 0 ORDER BY RAND() DESC LIMIT 4");
                        if ($sql->rowCount() > 0) {
                            while ($r = $sql->fetch()) {
                                ?>
                                <a target="_blank" href="/company?id=<?php echo $r['id'] ?>" class="home-company-vac">
                                    <div class="hc-img">
                                <span>
                                     <img src="/static/image/company/<?php echo $r['img'] ?>" alt="">
                                </span>
                                    </div>
                                    <div class="hc-text">
                                        <div><?php echo $r['name'] ?></div>
                                        <span><?php echo $app->count("SELECT * FROM `vacancy` WHERE `company_id` = '$r[id]' AND `status` = 0"); ?> вакансий</span>
                                    </div>
                                </a>
                                <?php
                            }
                        }
                        ?>
                    </div>



                </div>
            </div>
            <div class="section-bth">
                <a href="/job-list">Больше вакансий</a>
            </div>
        </div>
    </section>

    <section class="home-section po-b popular popular-company">
        <div class="container wow fadeIn">
            <div class="section-header">
                <div class="container">
                    <span class="home-title">Популярные компании</span>
                </div>
            </div>


            <section class="items">
                <div class="owl-carousel popular-company-slide">

                    <?php
                    $sql = $app->query("SELECT * FROM `company` WHERE `ban` = 0 ORDER BY `views` DESC LIMIT 10 ");
                    if ($sql->rowCount() > 0) {
                        while ($r = $sql->fetch()) {

                            $sth = $PDO->prepare("SELECT * FROM `review` WHERE `company_id` = ?");
                            $sth->execute(array((int) $r['id']));
                            $data = $sth->fetchAll(PDO::FETCH_ASSOC);
                            $count = count($data);

                            if ($count > 0) {
                                $rating = 0;
                                foreach ($data as $row) {
                                    $rating += $row['rating'];
                                }
                                $rating = $rating / $count;
                            } else {
                                $rating = 0;
                            }
                        ?>
                            <div class="card">
                                <div class="imgBx">
                                    <img src="/static/image/company/<?php echo $r['img'] ?>" alt="">
                                </div>
                                <div class="card-content">
                                    <div class="card-details">
                                        <a><?php echo $r['name'] ?></a>
                                        <span><?php echo $r['specialty'] ?></span>
                                        <div class="data">
                                            <h3><?php echo $app->count("SELECT * FROM `vacancy` WHERE `company_id` = '$r[id]' AND `status` = 0"); ?>  <br> <span>Вакансий</span></h3>
                                            <h3><?php echo $r['address'] ?> <br> <span>Город</span></h3>
                                            <h3><?php echo $rating ?> <br> <span>Рейтинг</span></h3>
                                        </div>
                                    </div>
                                    <div class="actionBth">
                                        <a href="/company?id=<?php echo $r['id'] ?>">Перейти</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<span>Компании не найдены</span>';
                    }
                    ?>
                </div>
            </section>

            <div class="section-bth">
                <a href="/company-list">Больше компаний</a>
            </div>
        </div>
    </section>


    <section class="about-home for-student" style="border: 0">
        <div class="container wow fadeIn about-container" >
            <div class="about-left-img">
                <div class="asi">
                    <div class="asi-1">
                        <span></span>
                    </div>
                    <div class="asi-2">
                        <span><img src="/static/image/home/1.jpg" alt=""></span>
                        <span><img src="/static/image/home/2.JPG" alt=""></span>
                    </div>
                </div>
                <div class="card-about card-about-1 ">
                    <span><? echo $app->count("SELECT * FROM `users`"); ?> резюме</span>
                    <div>

                        <? if (isset($_SESSION['id']) && $_SESSION['type'] == 'company') { ?>
                            <?php
                            $sql = $app->query("SELECT * FROM `users` WHERE `ban` = 0 ORDER BY `view` DESC LIMIT 6");
                            $i = 1;
                            while ($r = $sql->fetch()) {



                                ?>

                                <a href="/resume/?id=<?php echo $r['id'] ?>" class="card-img-<?php echo $i ?>">
                                    <img src="/static/image/users/<?php echo $r['img'] ?>" alt="">
                                </a>


                                <?php
                                $i++;
                            }
                            ?>
                        <? } else {  ?>

                        <?php
                        $sql = $app->query("SELECT * FROM `users` WHERE `ban` = 0 ORDER BY `view` DESC LIMIT 6");
                        $i = 1;
                        while ($r = $sql->fetch()) {
                            ?>

                            <a href="/resume/?id=<?php echo $r['id'] ?>" class="card-img-lock card-img-<?php echo $i ?>">
                                <m><i class="icon-lock"></i></m>
                                <img src="/static/image/users/placeholder.png" alt="">
                            </a>


                                <?php
                                $i++;
                            }
                            ?>


                            <? }   ?>
                    </div>
                </div>

                <div class="card-about card-about-2 ">
                    <span>10 факультетов</span>
                    <div>

                        <a href="/students?f=Экономический факультет" class="card-img-1">
                            <img src="/static/image/fak/faculty/econom.jpg" alt="">
                        </a>
                        <a href="/students?f=Электроэнергетический факультет" class="card-img-2">
                            <img src="/static/image/fak/faculty/electro.jpg" alt="">
                        </a>

                        <a href="/students?f=Факультет агробиологии и земельных ресурсов" class="card-img-3">
                            <img src="/static/image/fak/faculty/agro.jpg" alt="">
                        </a>

                        <a href="/students?f=Инженерно-технологический факультет" class="card-img-4">
                            <img src="/static/image/fak/faculty/meh.jpg" alt="">
                        </a>

                        <a href="/students?f=Факультет социально-культурного сервиса и туризма" class="card-img-5">
                            <img src="/static/image/fak/faculty/skst.jpg" alt="">
                        </a>

                        <a href="/students?f=Факультет экологии и ландшафтной архитектуры" class="card-img-6">
                            <img src="/static/image/fak/faculty/eco.jpg" alt="">
                        </a>

                    </div>
                </div>
            </div>
            <div class="about-right-text about-text">
                <h1>Резюме по актуальным направлениям</h1>
                <span>
                    <!--Важнейшим показателем оценки качества подготовки выпускников вуза является их востребованность на рынке труда.
                    Проблема трудоустройства молодых специалистов в России за последнее время стала очень значимой. Решению этой проблемы в нашем университете отдается большое внимание.
                    Мы обучаем студентов по разным направлениям, чтобы получить доступ к базе — создайте аккаунт-->
                    Центр трудоустройства и развития карьеры выпускников ФГБОУ ВО Ставропольского государственного аграрного университета это надежный источник квалифицированных кадров,
                    специалистов для самых разных отраслей. Вы подбираете временный персонал или хотите точечно закрыть вакансию компетентным специалистом?
                    Надежную репутацию выпускников и студентов ФГБОУ ВО «Ставропольского Государственного аграрного университета» на рынке труда
                    подтверждают многолетние партнерские отношения с крупнейшими компаниями — работодателями, предоставляющими свои вакансии выпускникам вуза.
                </span>



                <? if (isset($_SESSION['id']) && $_SESSION['type'] == 'company') { ?>
                    <a href="/create-job">Разместить вакансию</a>
                <? } else if (isset($_SESSION['id']) && $_SESSION['type'] == 'users') { ?>

                <? } else { ?>
                    <a href="/create/employers">Создать аккаунт</a>
                <? } ?>
            </div>
        </div>
    </section>



    <section class="home-section po-b popular popular-faculty">
        <div class="container wow fadeIn">
            <div class="section-header">
                <div class="">
                    <span class="home-title">Наши факультеты</span>
                </div>
            </div>


            <section class="items">
                <div style="padding: 0;" class="owl-carousel popular-company-slide">


                            <a href="/students?f=Экономический факультет" class="faculty-card">
                                <span>
                                    <img src="/static/image/fak/faculty/econom.jpg" alt="">
                                </span>
                                <h1>Экономический</h1>
                                <p><?php echo $app->count("SELECT * FROM `users` WHERE `faculty` = 'Экономический факультет'") ;?> резюме</p>
                            </a>

                    <a href="/students?f=Электроэнергетический факультет" class="faculty-card">
                                <span>
                                    <img src="/static/image/fak/faculty/electro.jpg" alt="">
                                </span>
                        <h1>Электроэнергетический</h1>
                        <p><?php echo $app->count("SELECT * FROM `users` WHERE `faculty` = 'Электроэнергетический факультет'") ;?> резюме</p>
                    </a>


                    <a href="/students?f=Факультет агробиологии и земельных ресурсов" class="faculty-card">
                                <span>
                                    <img src="/static/image/fak/faculty/agro.jpg" alt="">
                                </span>
                        <h1>Агробиологии и земельных ресурсов</h1>
                        <p><?php echo $app->count("SELECT * FROM `users` WHERE `faculty` = 'Факультет агробиологии и земельных ресурсов'") ;?> резюме</p>
                    </a>



                    <a href="" class="faculty-card">
                                <span>
                                    <img src="/static/image/fak/faculty/meh.jpg" alt="">
                                </span>
                        <h1>Инженерно-технологический</h1>
                        <p>0 резюме</p>
                    </a>

                    <a href="/students?f=Факультет экологии и ландшафтной архитектуры" class="faculty-card">
                                <span>
                                    <img src="/static/image/fak/faculty/eco.jpg" alt="">
                                </span>
                        <h1>Экологии и ландшафтной архитектуры</h1>
                        <p><?php echo $app->count("SELECT * FROM `users` WHERE `faculty` = 'Факультет экологии и ландшафтной архитектуры'") ;?> резюме</p>
                    </a>



                    <a href="/students?f=Факультет социально-культурного сервиса и туризма" class="faculty-card">
                                <span>
                                    <img src="/static/image/fak/faculty/skst.jpg" alt="">
                                </span>
                        <h1>Социально-культурного сервиса и туризма</h1>
                        <p><?php echo $app->count("SELECT * FROM `users` WHERE `faculty` = 'Факультет социально-культурного сервиса и туризма'") ;?> резюме</p>
                    </a>

                    <a href="/students?f=Учетно-финансовый факультет" class="faculty-card">
                                <span>
                                    <img src="/static/image/fak/faculty/uchet.jpg" alt="">
                                </span>
                        <h1>Учетно-финансовый</h1>
                        <p><?php echo $app->count("SELECT * FROM `users` WHERE `faculty` = 'Учетно-финансовый факультет'") ;?> резюме</p>
                    </a>



                    <a href="/students?f=Факультет среднего профессионального образования" class="faculty-card">
                                <span>
                                    <img src="/static/image/fak/faculty/spo.jpg" alt="">
                                </span>
                        <h1>Среднего профессионального образования</h1>
                        <p><?php echo $app->count("SELECT * FROM `users` WHERE `faculty` = 'Факультет среднего профессионального образования'") ;?> резюме</p>
                    </a>

                    <a href="/students?f=Факультет ветеринарной медицины" class="faculty-card">
                                <span>
                                    <img src="/static/image/fak/vetfak.jpg" alt="">
                                </span>
                        <h1>Ветеринарной медицины</h1>
                        <p><?php echo $app->count("SELECT * FROM `users` WHERE `faculty` = 'Факультет ветеринарной медицины'") ;?> резюме</p>
                    </a>

                    <a href="/students?f=Биотехнологический факультет" class="faculty-card">
                                <span>
                                    <img src="/static/image/fak/tehmenfak.jpg" alt="">
                                </span>
                        <h1>Биотехнологический</h1>
                        <p><?php echo $app->count("SELECT * FROM `users` WHERE `faculty` = 'Биотехнологический факультет'") ;?> резюме</p>
                    </a>


                </div>
            </section>

        </div>
    </section>



</main>

<?php include 'template/base/footer.php'; ?>

</body>
</html>