<?php
if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {



    if ($_SESSION['type'] == 'admin') {
        $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($a['id'])) {
            $app->notFound();
        }
    }

    Head('Дашборд - Агрокадры');

    $sth = $PDO->prepare("SELECT * FROM `visits` GROUP BY `day` ORDER BY `id`");
    $sth->execute();
    $res = $sth->fetchAll(PDO::FETCH_ASSOC);

    $sth2 = $PDO->prepare("SELECT * FROM `visits` WHERE `time` > ? GROUP BY `day` ORDER BY `id`");
    $sth2->execute([date('Y-m-d', strtotime('-7 days'))]);
    $res2 = $sth2->fetchAll(PDO::FETCH_ASSOC);

    $sth3 = $PDO->prepare("SELECT * FROM `visits` WHERE `time` > ? GROUP BY `day` ORDER BY `id`");
    $sth3->execute([date('Y-m-d', strtotime('-1 month'))]);
    $res3 = $sth3->fetchAll(PDO::FETCH_ASSOC);

    $sth4 = $PDO->prepare("SELECT * FROM `visits` WHERE `day` = ? AND `year` = ? GROUP BY `hour` ORDER BY `time`");
    $sth4->execute([$Date_ru, date("Y")]);
    $res4 = $sth4->fetchAll(PDO::FETCH_ASSOC);

    ?>




    <body class="profile-body">



    <main class="wrapper wrapper-profile" id="wrapper">


        <?php require('admin/template/adminAside.php'); ?>

        <section class="profile-base">

            <?php require('admin/template/adminHeader.php'); ?>

            <div class="profile-content admin-content">

                <div class="section-nav-profile">
                    <span><a href="/analysys">Кабинет</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a href="/analysys">Дашборд</a></span>
                </div>

                <span style="margin: 0 0 30px 0;" class="lock-site">
                                Админ панель находится на стадии разработки<br>
                                Возможны недоработки, неисправности, реализованы ещё не все функции!</span>

                <div class="analytics-block">


                    <?



                    ?>

                    <div class="al-stats">
                        <ul>
                            <li>
                                <div class="as-t">
                                    <span class="as-tt"><? echo $app->count("SELECT * FROM `vacancy`") ?></span>
                                    <span class="as-tk">Вакансий</span>
                                </div>
                                <div class="as-i"><i class="mdi mdi-database-check-outline"></i></div>

                            </li>

                            <li>
                                <div class="as-t">
                                    <span class="as-tt"><? echo $app->count("SELECT * FROM `company`") ?></span>
                                    <span class="as-tk">Компаний</span>
                                </div>
                                <div class="as-i"><i class="mdi mdi-briefcase-variant-outline"></i></div>

                            </li>
                            <li>
                                <div class="as-t">
                                    <span class="as-tt"><? echo $app->count("SELECT * FROM `users`") ?></span>
                                    <span class="as-tk">Студентов</span>
                                </div>
                                <div class="as-i"><i class="mdi mdi-school-outline"></i></div>

                            </li>
                            <li>
                                <div class="as-t">
                                    <span class="as-tt"><?php echo $app->count("SELECT * FROM `online`") ?></span>
                                    <span class="as-tk">На сайте сейчас</span>
                                </div>
                                <div class="as-i"><i class="mdi mdi-eye-outline"></i></div>

                            </li>
                        </ul>
                    </div>

                    <div class="al-create">

                        <ul>
                            <li>
                                <span>Разместить вакансию</span>
                                <a href="/admin/jobs-add" class="ald-1">
                                    <i class="mdi mdi-folder-plus-outline"></i>
                                    <span>Разместить вакансию</span>
                                </a>
                            </li>
                            <li>
                                <span>Добавить компанию</span>
                                <a href="/admin/companys-add" class="ald-2">
                                    <i class="mdi mdi-mdi mdi-briefcase-outline"></i>
                                    <span>Добавить компанию</span>
                                </a>
                            </li>
                            <li>
                                <span>Добавить студента</span>
                                <a href="/admin/students-add" class="ald-3">
                                    <i class="mdi mdi-account-school"></i>
                                    <span>Добавить студента</span>
                                </a>
                            </li>
                            <li>
                                <span></span>
                            </li>
                        </ul>

                    </div>

                    <div class="table-list">

                        <div class="table-little-main">
                            <span>Последние вакансии</span>
                            <div class="table-block">
                                <table>
                                    <thead>
                                        <tr>
                                            <th><span><i class="mdi mdi-pound"></i> Имя</span></th>
                                            <th><span><i class="mdi mdi-briefcase-variant-outline"></i> Компания</span></th>
                                            <th><span><i class="mdi mdi-crosshairs-gps"></i> Город</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql = $app->query("SELECT * FROM `vacancy` WHERE `status` = 0 ORDER BY `id` DESC LIMIT 10");
                                    while ($rr = $sql->fetch()) {
                                        ?>
                                        <tr>
                                            <td class="tl-title"><a href="/job?id=<?php echo $rr['id'] ?>"><?php echo mb_strimwidth($rr['title'], 0, 30, "..."); ?> </a></td>
                                            <td class="tl-cat"><a href="/company?id=<?php echo $rr['company_id'] ?>"><?php echo $rr['company'] ?></a></td>
                                            <td class="tl-cat"><a href="/job-list?loc=<?php echo $rr['address'] ?>""><?php echo $rr['address'] ?></a></td>
                                        </tr>
                                        <?php

                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="table-little-main">
                            <span>Последние компании</span>
                            <div class="table-block">
                                <table>
                                    <thead>
                                    <tr>
                                        <th><span><i class="mdi mdi-pound"></i> Имя</span></th>
                                        <th><span><i class="mdi mdi-account"></i> Контактное лицо</span></th>
                                        <th><span><i class="mdi mdi-phone"></i> Телефон</span></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql = $app->query("SELECT * FROM `company` ORDER BY `id` DESC LIMIT 10");
                                    while ($rr = $sql->fetch()) {
                                        ?>
                                        <tr>
                                            <td class="tl-title"><a target="_blank" href="/admin/info-companys?id=<?php echo $rr['id'] ?>">
                                                    <?php

                                                    if (trim($rr['name']) != '') {
                                                        echo mb_strimwidth($rr['name'], 0, 30, "...");
                                                    } else {
                                                        echo '${Нет названия}';
                                                    }


                                                    ?>
                                                </a></td>
                                            <td class="tl-text"><span><?php echo $rr['username'] ?></span></td>
                                            <td class="tl-text"><span><?php echo $rr['phone'] ?></span></td>
                                        </tr>
                                        <?php

                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>




                    </div>


                    <div class="table-list" style="margin: 20px 0 0 0;">

                        <div class="table-little-main">
                            <span>Кто онлайн?</span>
                            <div class="table-block">
                                <table>
                                    <thead>
                                    <tr>
                                        <th><span><i class="mdi mdi-pound"></i> Тип</span></th>
                                        <th><span><i class="mdi mdi-mdi mdi-crosshairs-gps"></i> ip</span></th>
                                        <th><span><i class="mdi mdi-mdi mdi-map-marker-outline"></i> Страна, город</span></th>
                                        <th><span><i class="mdi mdi-mdi mdi-web"></i> URL</span></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql = $app->query("SELECT * FROM `online` ORDER BY `id` DESC LIMIT 10");
                                    while ($rr = $sql->fetch()) {
                                        $who = clientInfo(getIp());

                                        if ($rr['type'] == 'users') {
                                            $temp = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $rr['id']]);
                                            $user = $temp['name'] . ' ' . $temp['surname'];
                                        } else if ($rr['type'] == 'company') {
                                            $temp = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $rr['id']]);
                                            $user = $temp['name'];
                                        } else {
                                            $user = 'undefined';
                                        }
                                        ?>
                                        <tr>
                                            <td class="tl-title"><a><?php echo $rr['type'] ?><?php echo ' — ' . mb_strimwidth($user, 0, 25, "..."); ?></a></td>
                                            <td class="tl-cat"><span><?php echo $rr['ip'] ?></span></td>
                                            <td class="tl-cat"><span><?php echo $who['country'] . ', ' .  $who['city']  ?></span></td>
                                            <td class="tl-cat"><a target="_blank" href="<?php echo $rr['url'];  ?>"> <?php echo mb_strimwidth($rr['url'], 0, 30, "..."); ?></a></td>
                                        </tr>
                                        <?php

                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="table-little-main">
                            <span>#{NAME}</span>
                            <div class="table-block">
                                #{TABLE}
                            </div>
                        </div>




                    </div>


                    <div class="admin-map-main">
                        <span>Вакансии на карте</span>
                        <div class="admin-map-ctx">
                            <ul class="map-admin-ul">
                                <?php
                                $sql = $app->query("SELECT * FROM `map_list` WHERE `map_code` = 'stav' ORDER BY `id`");
                                $sql2 = $app->query("SELECT * FROM `map_list` WHERE `map_code` = 'stav' ORDER BY `id`");
                                $rrd = $sql2->fetch();
                                $gg = $app->fetch("SELECT * FROM `map` WHERE `id` = :code", [':code' => (int) $rrd['map_id']]);

                                while ($r = $sql->fetch()) {
                                    ?>
                                    <li>
                                        <a data-name="<?php echo $r['name'] ?>" data-job="<?php echo $app->count("SELECT * FROM `vacancy` WHERE (`region` = '$r[name]' OR `area` = '$r[name]' OR `address` = '$r[name]') AND `status` = 0"); ?>" target="_blank" href="/job-list?loc=<?php echo $r['code'] ?>" class="okrug-<?php echo $r['id'] ?> map-tab-link" data-color="<?php echo $r['color'] ?>">
                                            <div class="caption"><?php echo $r['name'] ?></div>
                                            <div class="label">Вакансий <?php echo $app->count("SELECT * FROM `vacancy` WHERE (`region` = '$r[name]' OR `area` = '$r[name]' OR `address` = '$r[name]') AND `status` = 0"); ?></div>
                                        </a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>

                            <div class="map-tooltip">
                                <span class="tol-caption"></span>
                            </div>

                            <div class="svg-wrap">
                                <svg id="svg2" xmlns="http://www.w3.org/2000/svg" viewBox="<?php echo $gg['view']; ?>">
                                    <defs></defs>
                                    <g>

                                        <?php
                                        $sql = $app->query("SELECT * FROM `map_list` WHERE `map_code` = 'stav' ORDER BY `name` DESC");
                                        while ($r = $sql->fetch()) {
                                            ?>

                                            <a data-name="<?php echo $r['text'] ?>" data-job="<?php echo $app->count("SELECT * FROM `vacancy` WHERE (`region` = '$r[name]' OR `area` = '$r[name]' OR `address` = '$r[name]') AND `status` = 0"); ?>"
                                               href="/job-list?loc=<?php echo $r['code'] ?>" target="_blank" class="okrug-<?php echo $r['id'] ?> map-tab-link" data-color="<?php echo $r['color'] ?>">
                                                <?php echo $r['g'] ?>
                                            </a>

                                            <?php
                                        }
                                        ?>

                                    </g>

                                </svg>
                            </div>



                        </div>
                    </div>



                    <div class="p-al-admin">
                        <p>За всё время: <?php echo count($res); ?></p>
                        <p>За неделю: <?php echo count($res2); ?></p>
                        <p>За месяц: <?php echo count($res3); ?></p>
                        <p>За сегодня: <?php echo $app->rowCount("SELECT count(`counter`) FROM `visits` WHERE `day` = :d AND `year` = :y GROUP BY `hour` ORDER BY `time`", [
                                ':d' => $Date_ru,
                                ':y' => date("Y")
                            ]); ?></p>

                    </div>


                    <div class="block-al" style="margin: 0 0 30px 0">
                        <span>Просмотры за сегодня <i class="fa-solid fa-minus"></i></span>
                        <div class="chart">
                            <div id="visits_4" style="height: 250px;"></div>
                        </div>
                    </div>
                    <div class="block-al" style="margin: 0 0 30px 0">
                        <span>Просмотры за неделю <i class="fa-solid fa-minus"></i></span>
                        <div class="chart">
                            <div id="visits_2" style="height: 250px;"></div>
                        </div>
                    </div>
                    <div class="block-al" style="margin: 0 0 30px 0">
                        <span>Просмотры за месяц <i class="fa-solid fa-minus"></i></span>
                        <div class="chart">
                            <div id="visits_3" style="height: 250px;"></div>
                        </div>
                    </div>
                    <div class="block-al" style="margin: 0 0 30px 0">
                        <span>Просмотры за всё время <i class="fa-solid fa-minus"></i></span>
                        <div class="chart">
                            <div id="visits" style="height: 250px;"></div>
                        </div>
                    </div>
                    <div class="chart-block cblock-1">


                    </div>


                    <div id="chart"></div>
                </div>


            </div>


        </section>

    </main>


    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    <?php require('admin/template/adminFooter.php'); ?>

    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


    <script>


        new Morris.Bar({

            element: 'visits',

            data: <?php echo json_encode($res); ?>,

            xkey: 'day',

            ykeys: ['counter'],

            labels: ['Просмотры']

        });

        new Morris.Bar({

            element: 'visits_2',

            data: <?php echo json_encode($res2); ?>,

            xkey: 'day',

            ykeys: ['counter'],

            labels: ['Просмотры']

        });


        new Morris.Bar({

            element: 'visits_3',

            data: <?php echo json_encode($res3); ?>,

            xkey: 'day',

            ykeys: ['counter'],

            labels: ['Просмотры']

        });




        new Morris.Bar({

            element: 'visits_4',

            data: <?php echo json_encode($res4); ?>,

            xkey: 'hour',

            ykeys: ['counter'],

            labels: ['Просмотры']

        });




    </script>

    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>