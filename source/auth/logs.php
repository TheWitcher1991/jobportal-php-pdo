<?php
if (isset($_SESSION['id']) && isset($_SESSION['password'])) {

    if ($_SESSION['type'] == 'users') {
        $r = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($r['id'])) {
            $app->notFound();
        }
    } else if ($_SESSION['type'] == 'company') {
        $r = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($r['id'])) {
            $app->notFound();
        }
    } else {
        $app->notFound();
    }



    Head('Логи входов');

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
                    <span>Безопасность</span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span>Логи входов</span>
                </div>

                <div class="manage-resume-data">

                    <? include 'template/more/profileHead.php'; ?>

                    <div class="manage-profile-block">

                        <div class="log-stat">

                            <div>

                                <span>Успешных входов по IP</span>

                                <p> <?    if ($_SESSION['type'] == 'company') {
                                        echo $app->rowCount("SELECT * FROM `log_company` WHERE `company_id` = :id AND `type` = 0", [':id' => $r['id']]);
                                    }

                                    if ($_SESSION['type'] == 'users') {
                                        echo $app->rowCount("SELECT * FROM `log_users` WHERE `user_id` = :id AND `type` = 0", [':id' => $r['id']]);
                                    } ?> </p>

                            </div>

                            <div>

                                <span>Неудачные попытки по IP</span>

                                <p> <?    if ($_SESSION['type'] == 'company') {
                                        echo $app->rowCount("SELECT * FROM `log_company` WHERE `company_id` = :id AND `type` = 1", [':id' => $r['id']]);
                                    }

                                    if ($_SESSION['type'] == 'users') {
                                        echo $app->rowCount("SELECT * FROM `log_users` WHERE `user_id` = :id AND `type` = 1", [':id' => $r['id']]);
                                    } ?> </p>

                            </div>


                        </div>

                        <div class="block-table">
                            <table class="default-table">
                                <thead>
                                <tr>
                                    <th><span><i class="mdi mdi-clipboard-text-clock-outline"></i> Дата и время (последний раз)</span></th>
                                    <th><span><i class="mdi mdi-crosshairs-gps"></i> IP</span></th>
                                    <th><span><i class="mdi mdi-map-marker-outline"></i> Страна и город</span></th>
                                    <th><span><i class="mdi mdi-login-variant"></i> Кол-во операций</span></th>
                                    <th><span><i class="mdi mdi-security"></i> Статус</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                if ($_SESSION['type'] == 'company') {
                                    $number_of_results = $app->count("SELECT * FROM `log_company` WHERE `company_id` = '$r[id]'");
                                }

                                if ($_SESSION['type'] == 'users') {
                                    $number_of_results = $app->count("SELECT * FROM `log_users` WHERE `user_id` = '$r[id]'");
                                }

                                $results_per_page = 10;

                                $number_of_pages = ceil($number_of_results / $results_per_page);
                                if (!isset($_GET['page'])) {
                                    $pag = 1;
                                } else {
                                    $pag = $_GET['page'];
                                }
                                $this_page_first_result = ($pag - 1) * $results_per_page;


                                if ($_SESSION['type'] == 'company') {
                                    $sql2 = "SELECT * FROM `log_company` WHERE `company_id` = ? ORDER BY `id` DESC LIMIT $this_page_first_result, $results_per_page";
                                    $stmt2 = $PDO->prepare($sql2);
                                    $stmt2->execute([$r['id']]);
                                }
                                if ($_SESSION['type'] == 'users') {
                                    $sql2 = "SELECT * FROM `log_users` WHERE `user_id` = ? ORDER BY `id` DESC LIMIT $this_page_first_result, $results_per_page";
                                    $stmt2 = $PDO->prepare($sql2);
                                    $stmt2->execute([$r['id']]);
                                }
                                if ($stmt2->rowCount() <= 0) {

                                } else {
                                    $count = 0;
                                    while ($rr = $stmt2->fetch()) {
                                        $count = $count + 1;


                                        ?>
                                        <tr class="resume-<?php echo $count ?>">
                                            <td class="tb-title"><span><?php echo $rr['day'] . ' в ' . $rr['hour'] ?></span></td>
                                            <td class="tb-title"><span><?php echo $rr['ip'] ?></span></td>
                                            <td class="tb-title"><span><?php echo $rr['country'] . ', ' . $rr['city'] ?></span></td>
                                            <td class="tb-title"><span><?php echo $rr['counter'] ?></span></td>
                                            <td class="tb-title"><?php

                                                if ($rr['type'] == 0) {
                                                    echo '<div class="log-t-a">OK</div>';
                                                } else if ($rr['type'] == 1) {
                                                    echo '<div class="log-t-e">ERR</div>';
                                                }

                                                ?></td>
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


                                echo $paginator->table($pag, $number_of_results, 10, '/logs/?page=');

                                ?>




                                <!--<?php
                                if ($pag > 1) {
                                    ?>
                                    <div data-page="<?php echo $pag - 1?>" class="tp-none"><a href="/logs/?page=<?php echo $pag - 1?>">Назад</a></a></div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($pag < $number_of_pages) {
                                    ?>
                                    <div data-page="<?php echo $pag + 1 ?>" class="tp-active"><a href="/logs/?page=<?php echo $pag + 1 ?>">Дальше</a></a></div>
                                    <?php
                                }
                                ?>-->
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


    <?php require('template/more/profileFooter.php'); ?>

    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>