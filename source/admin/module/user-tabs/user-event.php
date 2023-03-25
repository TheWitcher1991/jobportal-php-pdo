


<div class="manage-profile-block">
    <div class="block-table">
        <span class="mp-span">Логи входов</span>
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

                $number_of_results = $app->count("SELECT * FROM `log_users` WHERE `user_id` = '$user[id]'");


            $results_per_page = 10;

            $number_of_pages = ceil($number_of_results / $results_per_page);
            if (!isset($_GET['page'])) {
                $pag = 1;
            } else {
                $pag = $_GET['page'];
            }
            $this_page_first_result = ($pag - 1) * $results_per_page;


            $sql2 = "SELECT * FROM `log_users` WHERE `user_id` = ? ORDER BY `id` DESC LIMIT $this_page_first_result, $results_per_page";
            $stmt2 = $PDO->prepare($sql2);
            $stmt2->execute([$user['id']]);

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


                echo $paginator->table($pag, $number_of_results, 10, '/admin/info-students?id='.$user['id'].'&t=5&page=');

                ?>




            </div>
        </div>
        <?
    }
    ?>
</div>


<div class="manage-profile-block" style="margin: 30px 0 0 0;">
    <span class="mp-span">Просмотры</span>
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
            $number_of_results = $app->count("SELECT * FROM `visits_resume` WHERE `user` = '$user[id]'");
            $number_of_pages = ceil($number_of_results / $results_per_page);
            if (!isset($_GET['page'])) {
                $pag = 1;
            } else {
                $pag = $_GET['page'];
            }
            $this_page_first_result = ($pag - 1) * $results_per_page;


            $sql2 = "SELECT * FROM `visits_resume` WHERE `user` = ? ORDER BY `id` DESC LIMIT $this_page_first_result, $results_per_page";
            $stmt2 = $PDO->prepare($sql2);
            $stmt2->execute([$user['id']]);
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


                echo $paginator->table($pag, $number_of_results, 15, '/admin/info-students?id='.$user['id'].'&t=5&page=');

                ?>
            </div>

        </div>
        <?
    }
    ?>
</div>