<?php

use Work\plugin\lib\pQuery;

if (isset($_SESSION['id']) && isset($_SESSION['password'])) {

    if ($_SESSION['type'] == 'users') {
        $r = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($r['id'])) {
            $app->notFound();
            exit;
        }
    } else if ($_SESSION['type'] == 'company') {
        $r = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($r['id'])) {
            $app->notFound();
            exit;
        }
    } else {
        $app->notFound();
        exit;
    }

    Head('Мои отзывы');

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
                    <span><a>Мои подписки</a></span>
                </div>

                <div class="manage-resume-data">



                    <?php if ($_SESSION['type'] == 'users') { ?>

                    <div class="manage-profile-block">
                        <div class="block-table">
                            <table class="default-table">
                                <thead>
                                <tr>
                                    <th><span><i class="mdi mdi-pound"></i> Компания</span></th>
                                    <th><span><i class="mdi mdi-button-pointer"></i> Действия</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $results_per_page = 20;
                                $number_of_results = $app->count("SELECT * FROM `review` WHERE `user_id` = '$r[id]'");
                                $number_of_pages = ceil($number_of_results / $results_per_page);
                                if (!isset($_GET['page'])) {
                                    $pag = 1;
                                } else {
                                    $pag = $_GET['page'];
                                }
                                $this_page_first_result = ($pag - 1) * $results_per_page;


                                $sql2 = "SELECT * FROM `sub` WHERE `user` = :id ORDER BY `id` DESC LIMIT $this_page_first_result, $results_per_page";
                                $stmt2 = $PDO->prepare($sql2);
                                $stmt2->bindParam(':id', $r['id'], PDO::PARAM_INT);
                                $stmt2->execute();
                                if ($stmt2->rowCount() <= 0) {

                                } else {
                                    $count = 0;
                                    while ($rr = $stmt2->fetch()) {
                                        $count = $count + 1;

                                        $com = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $rr['company']]);

                                        if (isset($_POST["del-$rr[id]"])) {

                                            $app->execute("DELETE FROM `sub` WHERE `id` = :id", [
                                                ':id' => $rr['id']
                                            ]);

                                            $app->go('/me-sub');

                                        }

                                        ?>
                                        <tr class="resume-<?php echo $count ?>">
                                            <td  class="tb-title"><a target="_blank" href="/company?id=<?php echo $com['id'] ?>&t=3"><?php echo $com['name'] ?></a></td>
                                            <td class="tb-form">
                                                <form action="" method="post">
                                                    <div class="block-manage">

                                                        <button onclick="" class="manage-bth" name="del-<?php echo $rr['id'] ?>" type="submit"><i class="icon-trash"></i> Удалить </button>
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
                        <?
                        if ($stmt2->rowCount() > 0) {
                            ?>
                            <div class="table-paginator">
                                <div class="tp-1">
                                    <span class="tp-now"><?php echo $pag ?></span> из <span class="tp-total"><?php echo $number_of_pages ?></span>
                                </div>
                                <div class="tp-2">
                                    <?php
                                    echo $paginator->table($pag, $number_of_results, 20, '/me-sub/?page=');
                                    ?>
                                </div>
                            </div>
                            <?
                        }
                        ?>
                    </div>


                    <?php }

                    if ($_SESSION['type'] == 'company') {


                        $cf = $app->rowCount("SELECT * FROM `sub` WHERE `company` = :ci", [':ci' => $_SESSION['id']]);


                    ?>

                        <? include 'template/more/profileHead.php';

                        if ($cf > 0) {
                            echo '<span style="    display: block;
    margin: 0 0 26px 0;
    color: #111;
    font-size: 18px;
    font-weight: 500;">Найдено ' . $cf . '</span>';
                        }

                        ?>



                        <div>


                            <ul class="info-f-d">

                               <?php


                        if ($cf > 0) {


                                $stmt2 = $PDO->prepare("SELECT * FROM `sub` WHERE `company` = :ci ORDER BY `id` DESC");
                                $stmt2->bindValue(':ci', (int) $_SESSION['id']);
                                $stmt2->execute();
                                while ($rs = $stmt2->fetch()) {



                                    $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $rs['user']])
                                    ?>

                                    <li>
                                                                        <span>
                                                                            <img src="/static/image/users/<?php echo $user['img'] ?>" alt="">
                                                                        </span>
                                        <div>
                                            <a target="_blank" href="/resume?id=<?php echo $user['id'] ?>"><?php echo $user['name'] . ' ' . $user['surname'] ?></a>
                                            <span><?php echo $user['prof'] ?></span>
                                        </div>
                                    </li>

                                    <?
                                }

                        } else {
                            echo 'Найдено 0';
                        }

                                ?>

                            </ul>
                        </div>

                    <?php }  ?>

                </div>
            </div>
        </section>

    </main>


    <?php require('template/more/profileFooter.php'); ?>

    </body>
    </html>
    <?php
} else {
    pQuery::notFound();
}
?>