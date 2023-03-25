<?php

if (isset($_SESSION['id']) && isset($_SESSION['password'])) {

    if ($_SESSION['type'] == 'company') {
        $sql = "SELECT * FROM `company` WHERE `id` = :id";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() <= 0) {
            $app->notFound();
        }

        $r = $stmt->fetch();
    } else if ($_SESSION['type'] == 'users') {
        $sql = "SELECT * FROM `users` WHERE `id` = :id";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() <= 0) {
            $app->notFound();
        }

        $r = $stmt->fetch();
    } else {
        $app->notFound();
    }


    if (isset($_POST['del-all'])) {

        if ($_SESSION['type'] == 'users') {
            $app->execute("DELETE FROM `notice` WHERE `who` = 2 AND `user_id` = :id", [
                ':id' => $_SESSION['id']
            ]);
            $app->go('/notice');
        }

        if ($_SESSION['type'] == 'company') {
            $app->execute("DELETE FROM `notice` WHERE `who` = 1 AND `user_id` = :id", [
                ':id' => $_SESSION['id']
            ]);
            $app->go('/notice');
        }

    }


    Head('Мои уведомления');


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
                    <span><a>Уведомления</a></span>
                </div>

                <div class="manage-resume-data">
                    <div class="manage-profile-block">
                        <div class="block-table">
                            <ul class="notice-ul">

                            <?php




                            if ($_SESSION['type'] == 'users') {
                                $results_per_page = 20;
                                $number_of_results = $app->count("SELECT * FROM `notice` WHERE `user_id` = '$r[id]' AND `who` = 2");
                                $number_of_pages = ceil($number_of_results / $results_per_page);
                                if (!isset($_GET['page'])) {
                                    $pag = 1;
                                } else {
                                    $pag = $_GET['page'];
                                }
                                $this_page_first_result = ($pag - 1) * $results_per_page;




                                $stmt = $PDO->prepare("SELECT * FROM `notice` WHERE `user_id` = ? AND `who` = 2 ORDER BY `id` DESC LIMIT $this_page_first_result, $results_per_page");
                                $stmt->execute([$r['id']]);
                                if ($stmt->rowCount() > 0) {

                                    $app->execute("UPDATE `notice` SET `status` = 1 WHERE `who` = 2 AND `user_id` = :id", [
                                        ':id' => $_SESSION['id']
                                    ]);

                                    $result = '';
                                    $result = '<form action="" method="post"><div class="notice-del-block"><button type="submit" name="del-all">Удалить всё</button></div></form>';
                                    while ($n = $stmt->fetch()) {
                                        if ($n['type'] == 'invite') {
                                            $company = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $n['company_id']]);
                                            $result .= "<li class=\"notice notice-$n[id]\">
 <span><img src=\"/static/image/company/$company[img]\"></span>
                                <form role=\"form\" method=\"GET\">
                                <div class=\"notice-wrap\">
                                    <span>У Вас приглашение <m>$n[date], $n[hour]</m></span>
                                    <p>Компания <a href=\"company/?id=$company[id]\">$company[name]</a> пригласила Вас на работу к себе</p>
                                   
                                </div>
                                </form>
                            </li>";
                                        }
                                        if ($n['type'] == 'reset_status') {
                                            $company = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $n['company_id']]);
                                            $result .= "<li class=\"notice notice-$n[id]\">
                                                 <span><img src=\"/static/image/company/$company[img]\"></span>
                                            <form role=\"form\" method=\"GET\">
                                            <div class=\"notice-wrap\">
                                                <span>Изменён статус отклика <m>$n[date], $n[hour]</m></span>
                                                <p>Компания <a href=\"company/?id=$company[id]\">$company[name]</a> изменила статус Вашего на отклика</p>
                                              
                                            </div>
                                          <!--<button><i class=\"icon-close\"></i>Удалить</button>-->
                                            </form>
                                        </li>";
                                        }
                                        if ($n['type'] == 'user_chat') {
                                            $company = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $n['company_id']]);
                                            $result .= "<li class=\"notice notice-$n[id]\">
                                <span><img src=\"/static/image/company/$company[img]\"></span>
                                <form role=\"form\" method=\"GET\">
                                <div class=\"notice-wrap\">
                                    <span>С Вами начали чат <m>$n[date], $n[hour]</m></span>
                                    <p>Компания <a href=\"company/?id=$company[id]\">$company[name]</a>, начала с Вами чат</p>
                                </div>
                                 
                                </form>
                            </li>";
                                        }
                                        if ($n['type'] == 'chat_message') {
                                            $company = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $n['company_id']]);
                                            $chat = $app->fetch("SELECT * FROM `chat` WHERE `id` = :id", [':id' => $n['chat_id']]);
                                                $result .= "<li class=\"notice notice-$n[id]\">
                                <span><img src=\"/static/image/company/$company[img]\"></span>
                                <form role=\"form\" method=\"GET\">
                                <div class=\"notice-wrap\">
                                    <span>У Вас новое сообщение <m>$n[date], $n[hour]</m></span>
                                    <p>$chat[last_c] ($chat[last])  - <a href=\"company/?id=$company[id]\">$company[name]</a></p>
                                </div>
                                 
                                </form>
                              
                            </li>";
                                        }
                                    }
                                    echo $result;
                                } else {
                                    ?>
                                    <span class="error-opt" style="padding: 16px 30px;display:block;">Нет уведомлений</span>
                                    <?php
                                }
                            } else if ($_SESSION['type'] == 'company') {
                                $results_per_page = 20;
                                $number_of_results = $app->count("SELECT * FROM `notice` WHERE `company_id` = '$r[id]' AND `who` = 1");
                                $number_of_pages = ceil($number_of_results / $results_per_page);
                                if (!isset($_GET['page'])) {
                                    $pag = 1;
                                } else {
                                    $pag = $_GET['page'];
                                }
                                $this_page_first_result = ($pag - 1) * $results_per_page;



                                $stmt = $PDO->prepare("SELECT * FROM `notice` WHERE `company_id` = ? AND `who` = 1 ORDER BY `id` DESC LIMIT $this_page_first_result, $results_per_page");
                                $stmt->execute([$r['id']]);
                                if ($stmt->rowCount() > 0) {
                                    $result = '';
                                    $result = '<form action="" method="post"><div class="notice-del-block"><button type="submit" name="del-all">Удалить всё</button></div></form>';

                                    $app->execute("UPDATE `notice` SET `status` = 1 WHERE `who` = 1 AND `company_id` = :id", [
                                        ':id' => $_SESSION['id']
                                    ]);

                                    while ($n = $stmt->fetch()) {
                                        if ($n['type'] == 'company_respond') {
                                            $stud = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $n['user_id']]);
                                            $job = $app->fetch("SELECT * FROM `vacancy` WHERE `id` = :id", [':id' => $n['job_id']]);
                                            $result .= "<li class=\"notice notice-$n[id]\">
                                    <span><img src=\"/static/image/users/$stud[img]\"></span>
                                    <form role=\"form\" method=\"GET\">
                                    <div class=\"notice-wrap\">
                                        <span>У Вас новый отклик <m>$n[date], $n[hour]</m></span>
                                        <p>Студент <a href=\"resume/?id=$stud[id]\">$stud[name] $stud[surname]</a>, откликнулся на вакансию - <a href=\"job/?id=$job[id]\">$job[title]</a></p>
                                   
                                    </div>
                                    
                                    </form>
                                </li>";
                                        }
                                        if ($n['type'] == 'company_review') {
                                            $stud = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $n['user_id']]);
                                            $result .= "<li class=\"notice notice-$n[id]\">
                                     <span><img src=\"/static/image/users/$stud[img]\"></span>
                                    <form role=\"form\" method=\"GET\">
                                    <div class=\"notice-wrap\">
                                        <span>У Вас новый отзыв <m>$n[date], $n[hour]</m></span>
                                        <p>Студент <a href=\"resume/?id=$stud[id]\">$stud[name] $stud[surname]</a>, оставил отзыв о Вас</p>
                                     
                                    </div>
                                    </form>
                                </li>";
                                        }
                                        if ($n['type'] == 'company_vacancy') {
                                            $job = $app->fetch("SELECT * FROM `vacancy` WHERE `id` = :id AND `status` = 1", [':id' => $n['job_id']]);
                                            $result .= "<li class=\"notice notice-$n[id]\">
                                        <span><img src=\"/static/image/company/$r[img]\"></span>
                                    <form role=\"form\" method=\"GET\">
                                    <div class=\"notice-wrap\">
                                        <span>Вакансия закрылась <m>$n[date], $n[hour]</m></span>
                                        <p>Вакансия - $job[title] закрылась, так как прошёл срок активности</p>
                                       
                                    </div>
                                    </form>
                                </li>";
                                        }
                                        if ($n['type'] == 'chat_message') {
                                            $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $n['user_id']]);
                                            $chat = $app->fetch("SELECT * FROM `chat` WHERE `id` = :id", [':id' => $n['chat_id']]);
                                            $result .= "<li class=\"notice notice-$n[id]\">
                                     <span><img src=\"/static/image/users/$user[img]\"></span>
                                    <form role=\"form\" method=\"GET\">
                                    <div class=\"notice-wrap\">
                                        <span>У Вас новое сообщение <m>$n[date], $n[hour]</m></span>
                                        <p>$chat[last_u] ($chat[last])  - <a href=\"resume/?id=$user[id]\">$user[name] $user[surname]</a></p>
                                       
                                    </div>
                                    </form>
                                </li>";
                                        }
                                    }
                                    echo $result;
                                } else {
                                    ?>
                                    <span class="error-opt" style="padding: 16px 30px;display:block;">Нет уведомлений</span>
                                    <?php
                                }

                            } else {
                                $app->go('/404');
                            }
                            ?>
                            </ul>
                        </div>

                        <div class="table-paginator">
                            <?
                            if ($stmt->rowCount() > 0) {
                            ?>
                            <div class="tp-1">
                                <span class="tp-now"><?php echo $pag ?></span> из <span class="tp-total"><?php echo $number_of_pages ?></span>
                            </div>
                            <div class="tp-2">
                                <?php
                                echo $paginator->table($pag, $number_of_results, 10, '/notice/?page=');
                                ?>
                            </div>
                                <?
                            }
                            ?>
                        </div>
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