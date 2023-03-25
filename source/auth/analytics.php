<?php 
use Work\plugin\lib\pQuery;

if (isset($_SESSION['id']) && isset($_SESSION['password']) && $_SESSION['type'] == 'company') {
    $r = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $_SESSION['id']]);
    
    if (empty($r['id'])) {
        $app->notFound();
        exit;
    }

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


    $res = [];
    $sql = $app->query("SELECT * FROM `visits_job` WHERE `company_id` = '$_SESSION[id]' AND `time` >= SUBTIME(NOW(), '0 168:0:0') GROUP BY `day` ORDER BY `id` ASC");
    while ($a = $sql->fetch()) {
        $re = $app->rowCount("SELECT * FROM `respond` WHERE `date_ru` = :d AND `company_id` = :id AND `time` >= SUBTIME(NOW(), '0 168:0:0') GROUP BY `date_ru` ORDER BY `id`", [
            ':d' => $a['day'],
            ':id' => $_SESSION['id']
        ]);
        $res[] = [
            'y' => $a['day'],
            'counter'  => $a['counter'],
            'respond' => $re
        ];
    }

    $res2 = [];
    $sql = $app->query("SELECT * FROM `visits_job` WHERE `company_id` = '$_SESSION[id]' AND `time` >= SUBTIME(NOW(), '0 731:0:0') GROUP BY `day` ORDER BY `id` ASC");
    while ($a = $sql->fetch()) {
        $re = $app->rowCount("SELECT * FROM `respond` WHERE `date_ru` = :d AND `company_id` = :id AND `time` >= SUBTIME(NOW(), '0 731:0:0') GROUP BY `date_ru` ORDER BY `id`", [
            ':d' => $a['day'],
            ':id' => $_SESSION['id']
        ]);
        $res2[] = [
            'y' => $a['day'],
            'counter'  => $a['counter'],
            'respond' => $re
        ];
    }




    Head('Аналитика');


?>
<body class="profile-body">



<main class="wrapper wrapper-profile" id="wrapper">

    <?php require('template/more/profileAside.php'); ?>

    

    <section class="profile-base">

        <?php require('template/more/profileHeader.php'); ?>
    

        <div class="profile-content analytics">

            <div class="section-nav-profile">
                <span><a href="/profile">Профиль</a></span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span><a href="/analytics">Аналитика</a></span>
            </div>

            <div class="analytics-block">
                <div class="al-stats" style="margin: 0 0 30px 0;">
                    <ul>
                        <li>
                            <div class="as-t">
                                <span class="as-tt"><?php echo $r['job'] ?></span>
                                <span class="as-tk">Вакансии</span>
                            </div>
                            <div class="as-i"><i class="icon-briefcase"></i></div>

                        </li>
                        <li>
                            <div class="as-t">
                                <span class="as-tt"><?php echo $app->rowCount("SELECT * FROM `respond` WHERE `company_id` = :id", [':id' => $r['id']]) ?></span>
                                <span class="as-tk">Отклики</span>
                            </div>
                            <div class="as-i"><i class="icon-graduation"></i></div>

                        </li>
                        <li>
                            <div class="as-t">
                                <span class="as-tt"><?php echo $rating ?></span>
                                <span class="as-tk">Рейтинг</span>
                            </div>
                            <div class="as-i"><i class="icon-star"></i></div>

                        </li>
                        <li>
                            <div class="as-t">
                                <span class="as-tt"><?php echo $count ?></span>
                                <span class="as-tk">Отзывы</span>
                            </div>
                            <div class="as-i"><i class="icon-bubble"></i></div>

                        </li>
                    </ul>
                </div>

                <?php if (count($res) > 0) { ?>

                    <div class="analysis-manage-flex">
                        <div class="block-result">
                            <span>Просмотры и отклики за неделю <i class="fa-solid fa-minus"></i></span>
                            <div class="chart">
                                <div id="respond1" style="height: 250px"></div>
                            </div>
                        </div>

                        <div class="block-result">
                            <span>Просмотры и отклики за месяц <i class="fa-solid fa-minus"></i></span>
                            <div class="chart">
                                <div id="respond2" style="height: 250px"></div>
                            </div>
                        </div>

                    </div>



                <?php } else {

                    echo "<p>Когда наберутся просмотры, тут будут графики. Если Вам будет чего-то не хватать - сообщите нам</p>";

                } ?>


                <div class="table-list">

                    <div class="table-little-main">
                        <span>Последние вакансии</span>
                        <div class="table-block">
                            <table>
                                <thead>
                                <tr>
                                    <th><span><i class="mdi mdi-pound"></i> Имя</span></th>
                                    <th><span><i class="mdi mdi-crosshairs-gps"></i> Город</span></th>
                                    <th><span><i class="mdi mdi-account"></i> Отклики</span></th>
                                    <th><span><i class="mdi mdi-eye-outline"></i> Просмотры</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sql = $app->query("SELECT * FROM `vacancy` WHERE `company_id` = '$_SESSION[id]' ORDER BY `id` DESC LIMIT 10");
                                while ($rr = $sql->fetch()) {
                                    ?>
                                    <tr>
                                        <td class="tl-title"><a href="/job?id=<?php echo $rr['id'] ?>"><?php echo mb_strimwidth($rr['title'], 0, 30, "..."); ?> </a></td>
                                        <td class="tl-cat"><?php echo $rr['address'] ?></td>
                                        <td class="tl-cat"><?php echo $app->rowCount("SELECT * FROM `respond` WHERE `job_id` = :id", [':id' => $rr['id']]); ?></td>
                                        <td class="tl-cat"><?php echo $rr['views'] ?></td>
                                    </tr>
                                    <?php

                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="table-little-main">
                        <span>Последние отклики</span>
                        <div class="table-block">
                            <table>
                                <thead>
                                <tr>
                                    <th><span><i class="mdi mdi-pound"></i> Профессия</span></th>
                                    <th><span><i class="mdi mdi-account"></i> Контактное лицо</span></th>
                                    <th><span><i class="mdi mdi-phone"></i> Телефон</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sql = $app->query("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' ORDER BY `id` DESC LIMIT 10");
                                while ($rr = $sql->fetch()) {
                                    ?>
                                    <tr>
                                        <td class="tl-title"><a href="/company?id=<?php echo $rr['id'] ?>"><?php echo mb_strimwidth($rr['name'], 0, 30, "..."); ?> </a></td>
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




                <!--<div class="chart-block cblock-1">
                    <div class="block-views block-al">
                        <span>Просмотры вакансий</span>
                        <div class="chart">
                            <div id="viewsChart"></div>
                        </div>

                    </div>
                    <div class="block-rating block-al">
                        <span>Рейтинг</span>
                        <div class="chart">
                            <div id="ratingChart"></div>
                        </div>
                    </div>
                </div>-->
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
        element: 'respond1',
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


    new Morris.Bar({
        element: 'respond2',
        data: <?php echo json_encode($res2); ?>,
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
    pQuery::notFound();
}
?>