<?php

use Work\plugin\lib\pQuery;

if (isset($_SESSION['company']) && isset($_SESSION['password']) && $_SESSION['type'] == 'company') {

    if ($_SESSION['type'] == 'company') {
        $sql = "SELECT * FROM `company` WHERE `id` = :id";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() <= 0) {
            pQuery::notFound();
        }

        $r = $stmt->fetch();
    } else {
        $app->notFound();
    }

    Head($r['name'] . ' - закрытые вакансии');


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
                    <span><a href="/manage-job">Архив откликов</a></span>
                </div>

                <div class="manage-resume-data">
                    <div class="manage-profile-block">
                        <div class="block-table">
                            <table class="default-table">
                                <thead>
                                <tr>
                                    <th><span><i class="mdi mdi-pound"></i> Вакансия</span></th>
                                    <th><span><i class="mdi mdi-account-school"></i> Студент</span></th>
                                    <th><span><i class="mdi mdi-calendar"></i> Дата</span></th>
                                    <th><span><i class="mdi mdi-account-check"></i> Статус</span></th>
                                    <th><span><i class="mdi mdi-button-pointer"></i> Действия</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $results_per_page = 20;
                                $number_of_results = $app->count("SELECT * FROM `archive-respond` WHERE `company_id` = '$r[id]'");
                                $number_of_pages = ceil($number_of_results / $results_per_page);
                                if (!isset($_GET['page'])) {
                                    $pag = 1;
                                } else {
                                    $pag = $_GET['page'];
                                }
                                $this_page_first_result = ($pag - 1) * $results_per_page;


                                $sql2 = "SELECT * FROM `archive-respond` WHERE `company_id` = ? ORDER BY `id` DESC LIMIT $this_page_first_result, $results_per_page";
                                $stmt2 = $PDO->prepare($sql2);
                                $stmt2->execute([$r['id']]);



                                if ($stmt2->rowCount() <= 0) {
                                } else {
                                    $count = 0;
                                    while ($rr = $stmt2->fetch()) {
                                        $count = $count + 1;
                                        $ru = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [
                                            ':id' => (int) $rr['user_id']
                                        ]);

                                        if ($rr['status'] == 0 || $rr['status'] == 1) {
                                            $st = 'На рассмотрении';
                                        } else if ($rr['status'] == 2) {
                                            $st = 'Разговор по телефону';
                                        } else if ($rr['status'] == 3) {
                                            $st = 'Назначена встреча';
                                        } else if ($rr['status'] == 4) {
                                            $st = 'Принят на работу';
                                        } else if ($rr['status'] == 5) {
                                            $st = 'Отказано';
                                        } else if ($rr['status'] == 6) {
                                            $st = 'Приглашение';
                                        } else {
                                            $st = ' Не определён';
                                        }

                                        $stext = '';

                                        if ($rr['status'] == 0 || $rr['status'] == 1 || $rr['status'] == 2 || $rr['status'] == 3 || $rr['status'] == 4) {
                                            $stext = '<span class="status-yes">'.$st.'</span>';
                                        } else if ($rr['status'] == 5) {
                                            $stext =  '<span class="status-none">'.$st.'</span>';
                                        } else if ($rr['status'] == 6) {
                                            $stext = '<span class="status-yes">'.$st.'</span>';
                                        } else {
                                            $stext = '<span class="status-unf">Не определён</span>';
                                        }


                                        ?>
                                        <tr class="resume-<?php echo $count ?>">
                                            <td class="tb-title"><a href="/job?id=<?php echo $rr['job_id'] ?>"><?php echo $rr['job'] ?></a></td>
                                            <td class="tb-cat"><a href="/resume?id=<?php echo $ru['id'] ?>"><?php echo $ru['name'] . ' ' . $ru['surname'] ?></a></td>
                                            <td class="tb-date"><span><?php echo $rr['date'] ?></span></td>
                                            <td class="tb-date"><?php echo $stext ?></td>
                                            <td class="tb-form">

                                                <div class="block-manage">
                                                    <button class="manage-bth" onclick="createContanct('<?php echo $ru['id'] ?>', '<?php echo $ru['name'] . ' ' . $ru['surname'] ?>', '<?php echo $ru['email'] ?>', '<?php echo $ru['phone'] ?>')"   type="button"><i class="icon-eye"></i> Контакты</button>
                                                </div>

                                            </td>
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


                                echo $paginator->table($pag, $number_of_results, 20, '/archive-responded/?page=');

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

    <?php require('template/more/profileFooter.php'); ?>

    <script>
        function deleteForm(){document.querySelector('#auth').remove()}
        function createContanct(id,name,email,phone){document.querySelector('.profile-body').innerHTML+=`

                        <div id="auth" style="display:flex">
                    <div class="contact-wrapper" style="display:block">
                        <div class="auth-container auth-log" style="display:block">
                            <div class="auth-title">
                                Контакты
                                <i class="mdi mdi-close form-detete" onclick="deleteForm()"></i>
                            </div>
                            <div class="auth-form">
                                <span><i class="icon-user"></i> ${name}</span>
                                <span><i class="icon-envelope"></i> ${email}</span>
                                <span><i class="icon-phone"></i> ${phone}</span>
                            </div>
                        </div>
                    </div>
                </div>

           `}
    </script>

    </body>
    </html>
    <?php
} else {
    pQuery::notFound();
}
?>