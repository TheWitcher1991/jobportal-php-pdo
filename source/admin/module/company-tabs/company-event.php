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

            $number_of_results = $app->count("SELECT * FROM `log_company` WHERE `company_id` = '$rc[id]'");


            $results_per_page = 10;

            $number_of_pages = ceil($number_of_results / $results_per_page);
            if (!isset($_GET['page'])) {
                $pag = 1;
            } else {
                $pag = $_GET['page'];
            }
            $this_page_first_result = ($pag - 1) * $results_per_page;


            $sql2 = "SELECT * FROM `log_company` WHERE `company_id` = ? ORDER BY `id` DESC LIMIT $this_page_first_result, $results_per_page";
            $stmt2 = $PDO->prepare($sql2);
            $stmt2->execute([$rc['id']]);

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


                echo $paginator->table($pag, $number_of_results, 10, '/admin/info-companys?id='.$rc['id'].'&t=5&page=');

                ?>




            </div>
        </div>
        <?
    }
    ?>
</div>