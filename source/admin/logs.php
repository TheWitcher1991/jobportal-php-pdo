<?php
if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

    if ($_SESSION['type'] == 'admin') {
        $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($a['id'])) {
            $app->notFound();
        }
    }
    Head('Логи входов');
    ?>
        

    <body class="profile-body">



    <main class="wrapper wrapper-profile" id="wrapper">


        <?php require('admin/template/adminAside.php'); ?>

        <section class="profile-base">

            <?php require('admin/template/adminHeader.php'); ?>

            <div class="profile-content admin-content">

                <div class="section-nav-profile">
                    <span><a href="/admin/analysis">Кабинет</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a href="/admin/log">Логи входов</a></span>
                </div>

                <div class="manage-resume-data">



                    <div class="manage-profile-block">
                        <div class="block-table">
                            <table class="default-table">
                                <thead>

                                <tr>
                                    <th><span><i class="mdi mdi-key-outline"></i> </span></th>
                                    <th><span><i class="mdi mdi-clipboard-text-clock-outline"></i> Дата и время (последний раз)</span></th>
                                    <th><span><i class="mdi mdi-crosshairs-gps"></i> IP</span></th>
                                    <th><span><i class="mdi mdi-map-marker-outline"></i> Страна и город</span></th>
                                    <th><span><i class="mdi mdi-login-variant"></i> Количество входов</span></th>
                                    <th><span><i class="mdi mdi-button-pointer"></i> Действия</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                $number_of_results = $app->rowCount("SELECT * FROM `log_admin` WHERE `admin_id` = :id", [
                                        ':id' => $a['id']
                                ]);
                                

                                $results_per_page = 10;

                                $number_of_pages = ceil($number_of_results / $results_per_page);
                                if (!isset($_GET['page'])) {
                                    $pag = 1;
                                } else {
                                    $pag = $_GET['page'];
                                }
                                $this_page_first_result = ($pag - 1) * $results_per_page;

                                $sql2 = "SELECT * FROM `log_admin` WHERE `admin_id` = ? ORDER BY `id` DESC LIMIT $this_page_first_result, $results_per_page";
                                $stmt2 = $PDO->prepare($sql2);
                                $stmt2->execute([$a['id']]);

                                if ($stmt2->rowCount() <= 0) {
                                    echo '<tr><td><span class="error-opt">Список пуст.</span></td><td></td><td></td><td></td></tr>';
                                } else {
                                    $count = 0;
                                    while ($rr = $stmt2->fetch()) {
                                        $count = $count + 1;
                                        $ipc = $app->rowCount("SELECT * FROM `black_list` WHERE `ip` = :ip", [':ip' => $rr['ip']]);
                                        ?>
                                        <tr class="tr-<?php echo $count ?>">
                                            <td class="tb-title"><?php echo $rr['id'] ?></td>
                                            <td class="tb-title"><span><?php echo $rr['day'] . ' в ' . $rr['hour'] ?></span></td>
                                            <td class="tb-title"><span><?php echo $rr['ip'] ?> <?php if ($rr['ip'] == getIp()) { echo '(мой)'; } ?></span></td>
                                            <td class="tb-title"><span><?php echo $rr['country'] . ', ' . $rr['city'] ?></span></td>
                                            <td class="tb-title"><span><?php echo $rr['counter'] ?></span></td>
                                            <td>
                                                <form action="" method="post">

                                                    <div class="block-manage">
                                                        <?php if ($rr['ip'] != getIp()) { ?>

                                                            <?php if ($ipc > 0) { ?>

                                                            <button onclick="removeBlackList('<?php echo $rr['ip'] ?>', '<?php echo $count ?>')" class="manage-bth success-list" type="button"><i class="icon-check"></i> Разблокировать</button>
                                                            <?php } else { ?>
                                                                <button onclick="addBlackList('<?php echo $rr['ip'] ?>', '<?php echo $count ?>')" class="manage-bth black-list" type="button"><i class="icon-ban"></i> Заблокировать</button>
                                                            <?php } ?>


                                                        <?php } ?>
                                                    </div>

                                                </form>
                                            </td>
                                        </tr>
                                        <?php

                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-paginator">
                            <div class="tp-1">
                                <span class="tp-now"><?php echo $pag ?></span> из <span class="tp-total"><?php echo $number_of_pages ?></span>
                            </div>
                            <div class="tp-2">
                                <?php
                                echo $paginator->table($pag, $number_of_results, 10, '/admin/logs/?page=');
                                ?>
                            </div>
                        </div>
                    </div>


                    
                </div>


            </div>



        </section>

    </main>


    <?php require('admin/template/adminFooter.php'); ?>

    <script>

        function addBlackList(ip, id) {
            $.ajax({
                url: '/admin/admin-js',
                data: `ip=${ip}&MODULE_ADD_BLACK=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => console.log(response),
                success: function (responce) {
                    if (responce.code === 'success') {
                        $(`.tr-${id} .black-list`).remove()
                        $(`.tr-${id} form`).html(`
                        <button onclick="removeBlackList(${ip}, ${id})" class="manage-bth success-list" type="button"><i class="icon-check"></i> Разблокировать</button>
                        `)
                    } else {
                        alert('Произошла ошибка! Повторите!')
                        console.log(responce)
                    }
                }
            })
        }


        function removeBlackList(ip, id) {
            $.ajax({
                url: '/admin/admin-js',
                data: `ip=${ip}&MODULE_REMOVE_BLACK=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => console.log(response),
                success: function (responce) {
                    if (responce.code === 'success') {
                        $(`.tr-${id} .success-list-list`).remove()
                        $(`.tr-${id} form`).html(`
                        <button onclick="addBlackList(${ip}, ${id})" class="manage-bth black-list" type="button"><i class="icon-ban"></i> Заблокировать</button>
                        `)
                    } else {
                        alert('Произошла ошибка! Повторите!')
                        console.log(responce)
                    }
                }
            })
        }

    </script>

    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>