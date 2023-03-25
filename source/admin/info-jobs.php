<?php
if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

    if ($_SESSION['type'] == 'admin') {
        $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($a['id'])) {
            $app->notFound();
        }
    }

    $id_job = intval($_GET['id']);

    $jo = $app->fetch("SELECT * FROM `vacancy` WHERE `id` = :id", [':id' => $id_job]);

    if (!isset($jo['id'])) {
        $app->notFound();
    }

    Head('Анализ - ' . $jo['title']);
    ?>

<body class="profile-body">

<div id="auth">
    <div class="respond-wrapper">
        <div class="graph-container auth-log">
            <div class="auth-title">
                Просмотры
                <i class="mdi mdi-close form-close" onclick="deleteForm()"></i>
            </div>
            <div class="auth-form">
                <div class="table-little-main">
                    <span>Последние просмотры</span>
                    <div class="table-block">

                        <?php

                        $sql = $app->query("SELECT * FROM `visits_job` WHERE `job_id` = '$jo[id]' ORDER BY `id` DESC LIMIT 10");

                        $s = $sql->rowCount();

                        if ($s > 0) {
                            ?>

                            <table>
                                <thead>
                                <tr>
                                    <th><span><i class="mdi mdi-account"></i> Имя</span></th>
                                    <th><span><i class="mdi mdi-clock-time-eight-outline"></i> Время</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sql = $app->query("SELECT * FROM `visits_job` WHERE `job_id` = '$jo[id]' ORDER BY `id` DESC LIMIT 10");

                                $s = $sql->rowCount();


                                while ($rr = $sql->fetch()) {
                                    $u = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => (int) $rr['user']])
                                    ?>
                                    <tr>
                                        <td class="tl-title"><a target="_blank" href="/resume?id=<?php echo $u['id'] ?>"><?php echo $u['name'] . ' ' . $u['surname'] . ' — ' . $u['prof'] ?> </a></td>
                                        <td class="tl-cat"><a><?php echo $rr['time'] ?></a></td>
                                    </tr>
                                    <?php

                                }
                                ?>
                                </tbody>
                            </table>

                            <?php
                        } else {
                            ?>
                            Просмотров нет
                            <?php
                        }

                        ?>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<main class="wrapper wrapper-profile" id="wrapper">


    <?php require('admin/template/adminAside.php'); ?>

    <section class="profile-base">

        <?php require('admin/template/adminHeader.php'); ?>

        <div class="profile-content admin-content">

            <div class="section-nav-profile">
                <span><a href="/admin/analysys">Кабинет</a></span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span><a href="/admin/jobs-list">Каталог вакансий</a></span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span><a>  <?php echo $jo['title']; ?></a></span>
            </div>

            <div class="manage-resume-data">

                <div class="manage-resume-data">




                    <div class="manag-bth-a">
                        <a href="<?php echo '/job/?id='.$jo['id']?>" target="_blank"><i class="mdi mdi-link-variant"></i> Показать вакансию</a>
                        <a href="<?php echo '/admin/edit-jobs/?id='.$jo['id'].'&act='.$jo['company_id'] ?>" target="_blank"><i class="mdi mdi-pencil"></i> Редактировать</a>
                    </div>


                    <div class="manage-jobs-data">

                        <div class="mj-left">

                            <div class="mj-stat-mini">

                                <div class="mjs-t">

                                    <span>Аналитика</span>

                                    <p><?php echo $app->count("SELECT * FROM `visits_job` WHERE `job_id` = '$jo[id]' AND `time` >= SUBTIME(NOW(), '0 24:0:0')") ?> просмотров за день</p>

                                </div>

                                <div class="mjs-b">

                                    <div class="mjb-item">
                                        <i class="mdi mdi-database-eye-outline"></i>

                                        <div>
                                            <span><?php echo $jo['views'] ?></span>
                                            <p>Просмотров</p>
                                        </div>
                                    </div>

                                    <div class="mjb-item">
                                        <i class="mdi mdi-fire"></i>

                                        <div>
                                            <span><?php echo $app->rowCount("SELECT * FROM `online_job` WHERE `job` = :id", [':id' => $jo['id']]) ?></span>
                                            <p>Сейчас смотрят</p>
                                        </div>
                                    </div>

                                    <div class="mjb-item">
                                        <i class="mdi mdi-school-outline"></i>

                                        <div>
                                            <span><?php echo $app->rowCount("SELECT * FROM `respond` WHERE `job_id` = :id", [':id' => $jo['id']]) ?></span>
                                            <p>Откликов</p>
                                        </div>
                                    </div>

                                    <div class="mjb-item">
                                        <i class="mdi mdi-timer-sand-complete"></i>

                                        <div>
                                            <span><?php
                                                $earlier = new DateTime($Date);
                                                $later = new DateTime($jo['task']);
                                                echo $later->diff($earlier)->format("%a") . ' дней' ;
                                                ?></span>
                                            <p>Осталось</p>
                                        </div>
                                    </div>

                                </div>

                            </div>


                            <div class="mj-views">

                                <div class="table-little-main">
                                    <span>Кто смотрел?</span>
                                    <div class="table-block">

                                        <?php

                                        $sql = $app->query("SELECT * FROM `visits_job` WHERE `job_id` = '$jo[id]' ORDER BY `id` DESC LIMIT 12");

                                        $s = $sql->rowCount();

                                        if ($s > 0) {
                                            ?>

                                            <table>
                                                <thead>
                                                <tr>
                                                    <th><span><i class="mdi mdi-account"></i> Имя</span></th>
                                                    <th><span><i class="mdi mdi-clock-time-eight-outline"></i> Время</span></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $sql = $app->query("SELECT * FROM `visits_job` WHERE `job_id` = '$jo[id]' ORDER BY `id` DESC LIMIT 10");

                                                $s = $sql->rowCount();


                                                while ($rr = $sql->fetch()) {
                                                    $u = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => (int) $rr['user']])
                                                    ?>
                                                    <tr>
                                                        <td class="tl-title"><a target="_blank" href="/resume?id=<?php echo $u['id'] ?>"><?php echo $u['name'] . ' ' . $u['surname'] ?> </a></td>
                                                        <td class="tl-cat"><a><?php echo $rr['time'] ?></a></td>
                                                    </tr>
                                                    <?php

                                                }
                                                ?>
                                                </tbody>
                                            </table>

                                            <?php
                                        } else {
                                            ?>
                                            За последнее время нет просмотров
                                            <?php
                                        }

                                        ?>


                                    </div>
                                </div>

                            </div>

                        </div>


                        <div class="mj-right">

                            <?php if ($jo['status'] == 1)  { ?>

                                <span style="margin: 0 0 30px 0;" class="lock-site">
                                Вакансия в архиве с  <?php echo $jo['trash']; ?><br>
                                Истёк срок активности либо Вы сами её закрыли</span>

                            <?php } ?>


                            <?php

                            $res = [];
                            $sql = $app->query("SELECT * FROM `visits_job` WHERE `job_id` = '$jo[id]' AND `time` >= SUBTIME(NOW(), '0 168:0:0') GROUP BY `day` ORDER BY `id` ASC");
                            while ($a = $sql->fetch()) {
                                $re = $app->rowCount("SELECT * FROM `respond` WHERE `date_ru` = :d AND `job_id` = :ji AND `company_id` = :id AND `time` >= SUBTIME(NOW(), '0 168:0:0') GROUP BY `date_ru` ORDER BY `id`", [
                                    ':d' => $a['day'],
                                    ':ji' => $jo['id'],
                                    ':id' => $_SESSION['id']
                                ]);
                                $res[] = [
                                    'y' => $a['day'],
                                    'counter'  => $a['counter'],
                                    'respond' => $re
                                ];
                            }

                            $ctx = [];
                            $sql = $app->query("SELECT * FROM `visits_job` WHERE `job_id` = '$jo[id]' GROUP BY `day` ORDER BY `id` ASC");
                            while ($a = $sql->fetch()) {
                                $re = $app->rowCount("SELECT * FROM `respond` WHERE `date_ru` = :d AND `job_id` = :ji AND `company_id` = :id GROUP BY `date_ru` ORDER BY `id`", [
                                    ':d' => $a['day'],
                                    ':ji' => $jo['id'],
                                    ':id' => $_SESSION['id']
                                ]);
                                $ctx[] = [
                                    'y' => $a['day'],
                                    'counter'  => $a['counter'],
                                    'respond' => $re
                                ];
                            }


                            ?>

                            <div class="analysis-manage-flex" style="display:block;">

                                <?php if (count($ctx) > 0) { ?>

                                    <div style="width: 100%;margin: 0 0 30px 0;" class="block-result">
                                        <span>Динамика за всё время <i class="fa-solid fa-minus"></i></span>
                                        <div class="chart">
                                            <div id="visits_2" style="height: 250px"></div>
                                        </div>
                                    </div>
                                    <div style="width: 100%;" class="block-result">
                                        <span>Просмотры и отклики за неделю<i class="fa-solid fa-minus"></i></span>
                                        <div class="chart">
                                            <div id="visits" style="height: 250px"></div>
                                        </div>
                                    </div>

                                <?php } ?>
                            </div>


                            <div class="manag-block-text">

                                <ul>
                                    <li>
                                        <div class="ji-l"><i class="mdi mdi-currency-rub"></i></div>
                                        <div class="ji-r">
                                            <span>Зарплата</span>
                                            <span><?php

                                                if ($jo['salary'] > 0 && $jo['salary_end'] > 0) {
                                                    if ($jo['salary'] == $jo['salary_end']) {
                                                        echo $jo['salary'];
                                                    } else {
                                                        echo 'от ' . $jo['salary'] . ' до ' . $jo['salary_end'];
                                                    }
                                                } else if ($jo['salary'] > 0 && ($jo['salary_end'] <= 0 || trim($jo['salary_end']) == '')) {
                                                    echo 'от ' . $jo['salary'];
                                                } else if (($jo['salary'] <= 0 || trim($jo['salary']) == '') && $jo['salary_end'] > 0) {
                                                    echo 'до ' . $jo['salary_end'];
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
                                            <span><?php echo $jo['time']; ?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ji-l"><i class="mdi mdi-clock-time-four-outline"></i></div>
                                        <div class="ji-r">
                                            <span>Тип занятости</span>
                                            <span><?php echo $jo['type']; ?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ji-l"><i class="mdi mdi-briefcase-variant-outline"></i></div>
                                        <div class="ji-r">
                                            <span>Опыт работы</span>
                                            <span><?php echo $jo['exp']; ?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ji-l"><i class="mdi mdi-school-outline"></i></div>
                                        <div class="ji-r">
                                            <span>Образование</span>
                                            <span><?php if (empty($jo['degree']) or $jo['degree'] == 'Не указано') {echo 'Не указано';} else { echo $jo['degree']; } ?></span>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="ji-l"><i class="mdi mdi-email-outline"></i></div>
                                        <div class="ji-r">
                                            <span>Email</span>
                                            <span><?php echo $jo['email']; ?></span>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="ji-l"><i class="mdi mdi-phone-in-talk-outline"></i></div>
                                        <div class="ji-r">
                                            <span>Телефон</span>
                                            <span><?php echo $jo['phone']; ?></span>
                                        </div>
                                    </li>

                                    <?php if (trim($jo['contact']) != '') { ?>

                                        <li>
                                            <div class="ji-l"><i class="mdi mdi-account-outline"></i></div>
                                            <div class="ji-r">
                                                <span>Контактное лицо</span>
                                                <span><?php echo $jo['contact']; ?></span>
                                            </div>
                                        </li>

                                    <?php } ?>

                                    <li>
                                        <div class="ji-l"><i class="mdi mdi-map-marker-radius-outline"></i></div>
                                        <div class="ji-r">
                                            <span>Город работы</span>
                                            <span><?php echo $jo['address']; ?></span>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="ji-l"><i class="mdi mdi-calendar-outline"></i></div>
                                        <div class="ji-r">
                                            <span>Опубликовано</span>
                                            <span><?php echo $jo['date'] . ' ' . $jo['timses']; ?></span>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="ji-l"><i class="mdi mdi-timer-sand-complete"></i></div>
                                        <div class="ji-r">
                                            <span>Период активности</span>
                                            <span><?php echo $jo['date'] . ' — ' . DateTime::createFromFormat('Y-m-d', $jo['task'])->format('d.m.Y'); ?></span>
                                        </div>
                                    </li>




                                </ul>


                                <div class="manag-block-text-info">

                                    <?

                                    echo strip_tags($jo['text'])

                                    ?>

                                </div>

                            </div>



                        </div>



                    </div>












                    <div class="analysis-manage-content">

                        <div class="block-wrapper-manag">

                            <div class="block-status">

                                <a class="r-new <?php if (empty($_GET['f'])) { echo 'bs-active'; } ?>" href="/admin/info-jobs?id=<? echo $jo['company_id']; ?>">
                                    <i class="mdi mdi-alert-decagram-outline"></i>
                                    На рассмотрении (<?php echo $app->count("SELECT * FROM `respond` WHERE `status` = 0 AND `company_id` = '$_GET[id]'"); ?>)</a>

                                <a class="r-talk <?php if ($_GET['f'] == 2) { echo 'bs-active'; } ?>" href="/admin/info-jobs?id=<? echo $jo['company_id']; ?>&f=2">
                                    <i class="mdi mdi-phone-in-talk-outline"></i>
                                    Разговор по телефону (<?php echo $app->count("SELECT * FROM `respond` WHERE `status` = 2 AND `company_id` = '$_GET[id]'"); ?>)</a>

                                <a class="r-meeting <?php if ($_GET['f'] == 3) { echo 'bs-active'; } ?>" href="/admin/info-jobs?id=<? echo $jo['company_id']; ?>&f=3">
                                    <i class="mdi mdi-head-question-outline"></i>
                                    Собеседование (<?php echo $app->count("SELECT * FROM `respond` WHERE `status` = 3 AND `company_id` = '$_GET[id]'"); ?>)</a>

                                <a class="r-accept <?php if ($_GET['f'] == 4) { echo 'bs-active'; } ?>" href="/admin/info-jobs?id=<? echo $jo['company_id']; ?>&f=4">
                                    <i class="mdi mdi-hand-wave-outline"></i>
                                    Принят на работу (<?php echo $app->count("SELECT * FROM `respond` WHERE `status` = 4 AND `company_id` = '$_GET[id]'"); ?>)</a>

                                <a class="r-none <?php if ($_GET['f'] == 5) { echo 'bs-active'; } ?>" href="/admin/info-jobs?id=<? echo $jo['company_id']; ?>&f=5">
                                    <i class="mdi mdi-delete-variant"></i>
                                    Отказ (<?php echo $app->count("SELECT * FROM `respond` WHERE `status` = 5 AND `company_id` = '$_GET[id]'"); ?>)</a>

                                <a class="r-none <?php if ($_GET['f'] == 6) { echo 'bs-active'; } ?>" href="/admin/info-jobs?id=<? echo $jo['company_id']; ?>&f=6">
                                    <i class="mdi mdi-account-plus-outline"></i>
                                    Приглашённые (<?php echo $app->count("SELECT * FROM `respond` WHERE `status` = 6 AND `company_id` = '$_GET[id]'"); ?>)</a>



                            </div>

                            <div class="manage-filter">
                                <div class="manage-title">
                                    <span><div class="placeholder-item jx-title"></div></span>
                                </div>
                                <div class="manage-search-block">
                                    <input type="text" name="title" id="title" placeholder="Поиск по названию">

                                    <button type="button">Найти</button>
                                </div>
                            </div>

                            <div class="manage-sort profile-sort">
                                <div class="mgss-block">
                                    <select class="sort-select" name="sort" id="sort_respond">
                                        <option value="1">По дате отклика</option>
                                        <option value="2">По зарплате</option>
                                    </select>
                                </div>
                                <div class="mgss-block">
                                    <select class="sort-select" name="faculty" id="sort_faculty">
                                        <option value="" selected="">Любой факультет</option>
                                        <option value="1">Факультет агробиологии и земельных ресурсов</option>
                                        <option value="2">Факультет экологии и ландшафтной архитектуры</option>
                                        <option value="3">Экономический факультет</option>
                                        <option value="4">Инженерно-технологический факультет</option>
                                        <option value="5">Биотехнологический факультет</option>
                                        <option value="6">Факультет социально-культурного сервиса и туризма</option>
                                        <option value="7">Электроэнергетический факультет</option>
                                        <option value="8">Учетно-финансовый факультет</option>
                                        <option value="9">Факультет ветеринарной медицины</option>
                                        <option value="10">Факультет среднего профессионального образования</option>
                                    </select>
                                </div>
                            </div>
                        </div>




                        <div class="respond-als-wrap">



                            <div class="manage-list">

                                <div class="manage-ul">
                                    <div class="bsc-list">
                                        <div id="placeholder-main">
                                            <div class="placeholder">
                                                <div style="width: 100%;">
                                                    <div class="placeholder-item jx-nav"></div>
                                                    <div class="placeholder-item jx-title"></div>
                                                    <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                                    <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                                </div>
                                            </div>
                                            <div class="placeholder">
                                                <div style="width: 100%;">
                                                    <div class="placeholder-item jx-nav"></div>
                                                    <div class="placeholder-item jx-title"></div>
                                                    <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                                    <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                                </div>
                                            </div>
                                            <div class="placeholder">
                                                <div style="width: 100%;">
                                                    <div class="placeholder-item jx-nav"></div>
                                                    <div class="placeholder-item jx-title"></div>
                                                    <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                                    <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                                </div>
                                            </div>
                                            <div class="placeholder">
                                                <div style="width: 100%;">
                                                    <div class="placeholder-item jx-nav"></div>
                                                    <div class="placeholder-item jx-title"></div>
                                                    <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                                    <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                                </div>
                                            </div>
                                            <div class="placeholder">
                                                <div style="width: 100%;">
                                                    <div class="placeholder-item jx-nav"></div>
                                                    <div class="placeholder-item jx-title"></div>
                                                    <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                                    <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="paginator"></div>
                                </div>

                                <div class="manage-filter-list">
                                    <form role="form" class="form-resume form-filter" method="GET">

                                        <div class="filter-main filter-resume">
                                            <!--<div class="all-filter-bth">Расширенный поиск</div>-->

                                            <div class="filter-load" style="display: none;">

                                            </div>

                                            <div class="filter-layout salary">
                                                <div class="fl-title">Зарплата <i class="fa-solid fa-chevron-up"></i> </div>
                                                <div class="filter-block-pop">
                                                    <div class="filter-ul">
                                                        <ul class="filter-up filter-salary">
                                                            <li>
                                                                <div>
                                                                    <input class="custom-radio" checked="" name="salary" type="radio" id="1" value="-1">
                                                                    <label for="1">Не важно</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input class="custom-radio" name="salary" type="radio" id="2" value="">
                                                                    <label for="2">По договорённости</label>
                                                                </div>
                                                                <span><? echo $app->count("SELECT * FROM `respond` WHERE `salary` = '' AND `company_id` = $_SESSION[id]"); ?></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input class="custom-radio" name="salary" type="radio" id="3" value="15000">
                                                                    <label for="3">до 15 000 руб.</label>
                                                                </div>
                                                                <span><? echo $app->count("SELECT * FROM `respond` WHERE `salary` <= 15000 AND `company_id` = $_SESSION[id]"); ?></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input class="custom-radio" name="salary" type="radio" id="4" value="25000">
                                                                    <label for="4">до 25 000 руб.</label>
                                                                </div>
                                                                <span><? echo $app->count("SELECT * FROM `respond` WHERE `salary` <= 25000 AND `company_id` = $_SESSION[id]"); ?></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input class="custom-radio" name="salary" type="radio" id="5" value="45000">
                                                                    <label for="5">до 45 000 руб.</label>
                                                                </div>
                                                                <span><? echo $app->count("SELECT * FROM `respond` WHERE `salary` <= 45000 AND `company_id` = $_SESSION[id]"); ?></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input class="custom-radio" name="salary" type="radio" id="6" value="85000">
                                                                    <label for="6">до 85 000 руб.</label>
                                                                </div>
                                                                <span><? echo $app->count("SELECT * FROM `respond` WHERE `salary` <= 85000 AND `company_id` = $_SESSION[id]"); ?></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input class="custom-radio" name="salary" type="radio" id="7" value="100000">
                                                                    <label for="7">до 100 000 руб.</label>
                                                                </div>
                                                                <span><? echo $app->count("SELECT * FROM `respond` WHERE `salary` <= 100000 AND `company_id` = $_SESSION[id]"); ?></span>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                    <div class="filter-ul">
                                                        <ul class="fl-none">
                                                            <li>
                                                                <div>
                                                                    <input class="custom-radio" name="salary" type="radio" id="8" value="200000">
                                                                    <label for="8">до 200 000 руб.</label>
                                                                </div>
                                                                <span>1</span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input class="custom-radio" name="salary" type="radio" id="8" value="300000">
                                                                    <label for="8">до 300 000 руб.</label>
                                                                </div>
                                                                <span>1</span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input class="custom-radio" name="salary" type="radio" id="9" value="400000">
                                                                    <label for="9">до 400 000 руб.</label>
                                                                </div>
                                                                <span>1</span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input class="custom-radio" name="salary" type="radio" id="10" value="500000">
                                                                    <label for="10">до 500 000 руб.</label>
                                                                </div>
                                                                <span>1</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!--<div class="fl-bth">
                                                        Ещё 5
                                                    </div>-->
                                                </div>
                                            </div>

                                            <div class="filter-layout salary">
                                                <div class="fl-title">Опыт <i class="fa-solid fa-chevron-up"></i> </div>
                                                <div class="filter-block-pop">
                                                    <div class="filter-ul">
                                                        <ul class="filter-up filter-exp">
                                                            <li>
                                                                <div>
                                                                    <input class="custom-checkbox" name="exp[]" type="checkbox" id="11" value="1">
                                                                    <label for="11">Без опыта</label>
                                                                </div>
                                                                <span><? echo $app->count("SELECT * FROM `respond` WHERE `exp` = 'Без опыта' AND `company_id` = $_SESSION[id]"); ?></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input class="custom-checkbox" name="exp[]" type="checkbox" id="12" value="2">
                                                                    <label for="12">1-3 года</label>
                                                                </div>
                                                                <span><? echo $app->count("SELECT * FROM `respond` WHERE `exp` = '1-3 года' AND `company_id` = $_SESSION[id]"); ?></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input class="custom-checkbox" name="exp[]" type="checkbox" id="13" value="3">
                                                                    <label for="13">3-6 лет</label>
                                                                </div>
                                                                <span><? echo $app->count("SELECT * FROM `respond` WHERE `exp` = '3-6 лет' AND `company_id` = $_SESSION[id]"); ?></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input class="custom-checkbox" name="exp[]" type="checkbox" id="14" value="4">
                                                                    <label for="14">Более 6 лет</label>
                                                                </div>
                                                                <span><? echo $app->count("SELECT * FROM `respond` WHERE `exp` = 'Более 6 лет' AND `company_id` = $_SESSION[id]"); ?></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="filter-layout salary">
                                                <div class="fl-title">Возраст <i class="fa-solid fa-chevron-up"></i> </div>
                                                <div class="filter-block-pop">
                                                    <div class="filter-ul">
                                                        <ul class="filter-up filter-age">
                                                            <li>
                                                                <div class="filter-input">
                                                                    <span>от</span>
                                                                    <input min="1" max="100" type="age" class="age-to" name="ageTo">
                                                                    <span>до</span>
                                                                    <input min="1" max="100" type="age" class="age-from" name="ageFrom">
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="filter-layout salary">
                                                <div class="fl-title">Пол <i class="fa-solid fa-chevron-up"></i> </div>
                                                <div class="filter-block-pop">
                                                    <div class="filter-ul">
                                                        <ul class="filter-up filter-gender">
                                                            <li>
                                                                <div>
                                                                    <input checked="" class="custom-radio" name="gender" type="radio" id="32" value="">
                                                                    <label for="32">Не важно</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input class="custom-radio" name="gender" type="radio" id="33" value="1">
                                                                    <label for="33">Мужчина</label>
                                                                </div>
                                                                <span><? echo $app->count("SELECT * FROM `respond` WHERE (`gender` = 'Мужчина' OR `gender` = 'Мужской') AND `company_id` = $_SESSION[id]"); ?></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input class="custom-radio" name="gender" type="radio" id="34" value="2">
                                                                    <label for="34">Женщина</label>
                                                                </div>
                                                                <span><? echo $app->count("SELECT * FROM `respond` WHERE (`gender` = 'Женщина' OR `gender` = 'Женский') AND `company_id` = $_SESSION[id]"); ?></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>


                    </div>

                </div>



            </div>

            </div>

    </section>

</main>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

<?php require('admin/template/adminFooter.php'); ?>

<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<script>

    'use strict';

    (function ($) {





        let $form = $('.form-resume'),
            $salaryInput = $('.filter-salary input'),
            $ageTo = $('.age-to'),
            $expInput = $('.filter-exp input'),
            $ageFrom = $('.age-from'),
            $genderInput = $('.filter-gender input'),
            $pag = $('.paginator'),
            $keyInput = $('#title'),
            $locInput = $('#type_search'),
            $sort = $('#sort_respond'),
            $sortFaculty = $('#sort_faculty');

        function _bindHandlers() {
            $pag.on('click', 'a', _changePage);
            $salaryInput.on('change', function () {
                _getData(1, $_GET['f'] > 0 ? $_GET['f'] : 0)
            });
            $expInput.on('change', function () {
                _getData(1, $_GET['f'] > 0 ? $_GET['t'] : 0)
            });
            $genderInput.on('change', function () {
                _getData(1, $_GET['f'] > 0 ? $_GET['f'] : 0)
            });
            $sortFaculty.on('change', function () {
                _getData(1, $_GET['f'] > 0 ? $_GET['f'] : 0)
            });
            $ageTo.on('change', function () {
                _getData(1, $_GET['f'] > 0 ? $_GET['f'] : 0)
            });
            $ageFrom.on('change', function () {
                _getData(1, $_GET['f'] > 0 ? $_GET['f'] : 0)
            });
            $sort.on('change', function () {
                _getData(1, $_GET['f'] > 0 ? $_GET['f'] : 0)
            });
        }

        function _catalogError(responce) {
            console.log(responce)
            $('.bsc-list').html('Произошла ошибка. Повторите');
        }

        function _catalogSuccess(responce) {
            $('.manage-title').html(responce.data.count)
            $('.bsc-list').html(`${responce.data.list}`);
            $('.manage-search-block button').removeAttr('disabled')
            $('select').removeAttr('disabled')
            $('.filter-load').fadeOut(10)
        }

        function _changePage(e) {
            e.preventDefault();
            e.stopPropagation();

            let $page = $(e.target).parent('div');
            $pag.find('div').removeClass('page-active');
            $page.addClass('page-active');
            _getData($page.attr('data-page'), $_GET['f'] > 0 ? $_GET['f'] : 0);
            $page.addClass('page-active');

            $('html, body').animate({
                scrollTop: 0
            }, 0);
        }

        function _renderPagination({ pagination }) {
            $pag.html(pagination);
        }


        function _getData(page = 1, type = 0) {
            $('.bsc-list').html(`
        <div id="placeholder-main">
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                            </div>

        `);
            $('select').attr('disabled', 'true')
            $('.manage-search-block button').attr('disabled', 'true');
            $('.filter-load').fadeIn(10)
            $('.manage-title').html(`<span><div class="placeholder-item jx-title"></div></span>`)
            setTimeout(function () {
                $.ajax({
                    url: '/admin/admin-js',
                    data: `cid=${$_GET['id']}&faculty=${$sortFaculty.val()}&sort=${$sort.val()}&key=${$keyInput.val()}&loc=${$locInput.val()}&t=${type}&page=${+page}&${$form.serialize()}&MODULE_GET_COMPANY_STUDENT=1`,
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    error: _catalogError,
                    success: function (responce) {
                        if (responce.code === 'success') {
                            $('.bsc-list').html('');
                            _catalogSuccess(responce);
                            _renderPagination({
                                pagination: responce.data.pagination
                            });
                        } else {
                            _catalogError(responce);
                        }
                    }});
            }, 500)


        }

        function init () {
            _getData(1, $_GET['f'] > 0 ? $_GET['f'] : 0)
            _bindHandlers()
        }

        $(document).on('click', '.manage-search-block button', function () {
            _getData(1, $_GET['f'] > 0 ? $_GET['f'] : 0)
        })

        init();
    })(jQuery);


</script>

<script>

    $(document).on('click', '.pop-m-graph', function (e) {
        e.preventDefault();
        $('#auth').addClass('auth-b-act');
        $('#auth .respond-wrapper').addClass('auth-c-act');
        $('body').addClass('body-hidden');
    })

</script>

<script>

    let ctx =  <?php echo json_encode($ctx); ?>;

    console.log(ctx);

    new Morris.Bar({
        element: 'visits_2',
        data: <?php echo json_encode($ctx); ?>,
        xkey: 'y',
        ykeys: ['counter', 'respond'],
        labels: ['Просмотры', 'Отклики'],
        fillOpacity: 0.6,
        hideHover: 'auto',
        behaveLikeLine: true,
        resize: true,
        pointFillColors:['#ffffff'],
        pointStrokeColors: ['black'],
        lineColors:['#259ef9','#00e396'],
    });

    new Morris.Bar({
        element: 'visits',
        data: <?php echo json_encode($res); ?>,
        xkey: 'y',
        ykeys: ['counter', 'respond'],
        labels: ['Просмотры', 'Отклики'],
        fillOpacity: 0.6,
        hideHover: 'auto',
        behaveLikeLine: true,
        resize: true,
        pointFillColors:['#ffffff'],
        pointStrokeColors: ['black'],
        lineColors:['#259ef9','#00e396'],
    });

</script>

</body>
</html>

    <?php
} else {
    $app->notFound();
}
?>
