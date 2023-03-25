<?php

use Work\plugin\lib\pQuery;

if (isset($_SESSION['surname']) && isset($_SESSION['password']) && $_SESSION['type'] == 'users') {

    $r = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']]);

    if (empty($r['id'])) {
        $app->notFound();
    }

    $sth = $PDO->prepare("SELECT * FROM `visits_resume` WHERE `time` > SUBTIME(NOW(), '0 732:0:0') AND `user` = ? AND `year` = ? GROUP BY `day` ORDER BY `id`");
    $sth->execute([$_SESSION['id'], date("Y")]);
    $res = $sth->fetchAll(PDO::FETCH_ASSOC);

    $arr = [];
    $sql = $PDO->query("SELECT * FROM `visits_resume` WHERE `user` = '$_SESSION[id]' AND `time` >= SUBTIME(NOW(), '0 732:0:0') GROUP BY `company_id`");
    while ($s = $sql->fetch()) {
        $count = $app->query("SELECT * FROM `visits_resume` WHERE `user` = '$_SESSION[id]' AND `company_id` = ' $s[company_id]' AND `time` >= SUBTIME(NOW(), '0 732:0:0')");
        $counter = 0;
        while ($c = $count->fetch()) {
            $counter += $c['counter'];
        }

        $arr[] = [
            'label' => $s['company'],
            'value' => $counter
        ];
    }



    Head('Просмотры');

    ?>

    <body class="profile-body">

    <main class="wrapper wrapper-profile" id="wrapper">

        <?php require('template/more/profileAside.php'); ?>



        <section class="profile-base">

            <?php require('template/more/profileHeader.php'); ?>


            <div class="profile-content create-resume">

                <div class="section-nav-profile">
                    <span><a href="/profile">Профиль</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a>Мои просмотры</a></span>
                </div>


                <div class="manage-resume-data">



                    <? include 'template/more/profileHead.php'; ?>

                    <?php if(count($res) > 0) { ?>
                    <div class="analysis-manage-flex">
                        <div class="block-result">
                            <span>Просмотры за месяц <i class="fa-solid fa-minus"></i></span>
                            <div class="chart">
                                <div id="visits" style="height: 250px"></div>
                            </div>
                        </div>

                        <div class="block-result">
                            <span>Просмотры компаний за месяц <i class="fa-solid fa-minus"></i></span>
                            <div class="chart">
                                <div id="views" style="height: 250px"></div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="manage-profile-block">
                        <div class="block-table">
                            <table class="default-table">
                                <thead>
                                <tr>
                                    <th><span><i class="mdi mdi-pound"></i> Компания</span></th>
                                    <th><span><i class="mdi mdi-calendar"></i> Дата и время (Последний раз)</span></th>
                                    <th><span><i class="mdi mdi-eye"></i> Всего просмотров за день</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $results_per_page = 15;
                                $number_of_results = $app->count("SELECT * FROM `visits_resume` WHERE `user` = '$r[id]'");
                                $number_of_pages = ceil($number_of_results / $results_per_page);
                                if (!isset($_GET['page'])) {
                                    $pag = 1;
                                } else {
                                    $pag = $_GET['page'];
                                }
                                $this_page_first_result = ($pag - 1) * $results_per_page;


                                $sql2 = "SELECT * FROM `visits_resume` WHERE `user` = ? ORDER BY `id` DESC LIMIT $this_page_first_result, $results_per_page";
                                $stmt2 = $PDO->prepare($sql2);
                                $stmt2->execute([$r['id']]);
                                if ($stmt2->rowCount() <= 0) {

                                } else {
                                    $count = 0;
                                    while ($rr = $stmt2->fetch()) {
                                        $count = $count + 1;

                                        $rs = $app->count("SELECT * FROM `online_resume` WHERE `users` = '$r[id]' AND `company` = '$rr[company_id]'");

                                        ?>
                                        <tr class="resume-<?php echo $count ?>">
                                            <td class="tb-title"><a href="/company/?id=<?php echo $rr['company_id'] ?>">
                                                    <?php echo $rr['company'] ?>

                                                    <?php if ($rs > 0) { echo '(смотрит Ваше резюме)'; } ?>
                                                </a></td>
                                            <td class="tb-cat"><span><?php echo $rr['day'] . ' в ' . $rr['hour'] ?></span></td>
                                            <td class="tb-date"><span><?php echo $rr['counter'] ?></span></td>
                                        </tr>
                                        <?php

                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <?
                        if ($stmt2->rowCount() > 0) {
                        ?>
                        <div class="table-paginator">

                            <div class="tp-1">
                                <span class="tp-now"><?php echo $pag ?></span> из <span class="tp-total"><?php echo $number_of_pages ?></span>
                            </div>
                            <div class="tp-2">
                                <?php


                                echo $paginator->table($pag, $number_of_results, 15, '/views/?page=');

                                ?>
                            </div>

                        </div>
                            <?
                        }
                        ?>
                    </div>





                </div>
            </div>
        </section>

    </main>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    <?php require('template/more/profileFooter.php'); ?>

    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<script>
    new Morris.Bar({
        element: 'visits',
        data: <?php echo json_encode($res); ?>,
        xkey: 'day',
        ykeys: ['counter'],
        labels: ['Просмотры'],
        fillOpacity: 0.6,
        hideHover: 'auto',
        behaveLikeLine: true,
        resize: true,
        pointFillColors:['#ffffff'],
        pointStrokeColors: ['black'],
        lineColors:['#259ef9','#00e396'],
    });

    console.log(<?php echo json_encode($arr); ?>)

    new Morris.Donut({
        element: 'views',
        resize: true,
        colors: ['#259ef9', '#00e396', '#f39c12', '#f56954', '#3c8dbc'],
        data: <?php echo json_encode($arr); ?>,
        hideHover: 'auto'
    });
</script>

    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>