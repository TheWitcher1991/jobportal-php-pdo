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
                    <span><a>Мои отзывы</a></span>
                </div>

                <div class="manage-resume-data">

    <?php if ($_SESSION['type'] == 'users') { ?>

                    <div class="manage-profile-block">
                        <div class="block-table">
                            <table class="default-table">
                                <thead>
                                <tr>
                                    <th><span><i class="mdi mdi-pound"></i> Компания</span></th>
                                    <th><span><i class="mdi mdi-calendar"></i> Дата</span></th>
                                    <th><span><i class="mdi mdi-star-outline"></i> Рейтинг</span></th>
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


                                $sql2 = "SELECT * FROM `review` WHERE `user_id` = :id ORDER BY `id` DESC LIMIT $this_page_first_result, $results_per_page";
                                $stmt2 = $PDO->prepare($sql2);
                                $stmt2->bindParam(':id', $r['id'], PDO::PARAM_INT);
                                $stmt2->execute();
                                if ($stmt2->rowCount() <= 0) {

                                } else {
                                    $count = 0;
                                    while ($rr = $stmt2->fetch()) {
                                        $count = $count + 1;

                                        if (isset($_POST["del-$rr[id]"])) {

                                            $app->execute("DELETE FROM `review` WHERE `id` = :id", [
                                                    ':id' => $rr['id']
                                            ]);

                                            $app->go('/me-review');

                                        }

                                        ?>
                                        <tr class="resume-<?php echo $count ?>">
                                            <td  class="tb-title"><a target="_blank" href="/company?id=<?php echo $rr['company_id'] ?>&t=3"><?php echo $rr['company'] ?></a></td>
                                            <td class="tb-cat"><span><?php echo $rr['date'] ?></span></td>
                                            <td class="tb-cat"><span><?php echo $rr['rating'] ?></span></td>
                                            <td class="tb-form">
                                                <form action="" method="post">
                                                    <div class="block-manage">

                                                        <a target="_blank" href="/company?id=<?php echo $rr['company_id'] ?>&t=3" class="manage-bth"><i class="icon-pencil"></i> Изменить </a>
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
                                echo $paginator->table($pag, $number_of_results, 20, '/me-review/?page=');
                                ?>
                            </div>
                        </div>
    <?
}
?>
                    </div>

    <?php }

    if ($_SESSION['type'] == 'company') {


        $cf = $app->rowCount("SELECT * FROM `review` WHERE `company_id` = :ci ORDER BY `id` DESC", [':ci' => $_SESSION['id']]);


        include 'template/more/profileHead.php';

        ?>

            <div class="review-block-r">

                <div class="review-block">
                    <div class="review-block-top">
                        <div class="review-top-title">Отзывы о компании</div>
                        <div class="rating-num"><?php echo $rating; ?></div>
                        <div class="rating-result">
                            <span class="<?php if (ceil($rating) >= 1) echo 'active-r'; ?>"></span>
                            <span class="<?php if (ceil($rating) >= 2) echo 'active-r'; ?>"></span>
                            <span class="<?php if (ceil($rating) >= 3) echo 'active-r'; ?>"></span>
                            <span class="<?php if (ceil($rating) >= 4) echo 'active-r'; ?>"></span>
                            <span class="<?php if (ceil($rating) >= 5) echo 'active-r'; ?>"></span>
                        </div>
                        <div class="rating-text">На основе <?php echo count($data); ?> оценок</div>
                    </div>
                </div>


            </div>


            <div class="review-block-l">
                <div class="review-list">
                    <ul class="review-list-ul">
                <?php
                $stmt2 = $PDO->prepare("SELECT * FROM `review` WHERE `company_id` = :ci ORDER BY `id` DESC");
                $stmt2->bindValue(':ci', (int) $r['id']);
                $stmt2->execute();
                if (count($data) > 0) {

                    while ($r = $stmt2->fetch()) {



                    ?>
                    <li>
                        <div>
                            <div class="rv-name"><?php echo $r['prof'] ?>, <?php echo $r['me'] ?></div>
                            <div class="rv-prof"></div>
                            <div class="rating-list">
                                <span class="<?php if (ceil($r['rating']) >= 1) echo 'active-r'; ?>"></span>
                                <span class="<?php if (ceil($r['rating']) >= 2) echo 'active-r'; ?>"></span>
                                <span class="<?php if (ceil($r['rating']) >= 3) echo 'active-r'; ?>"></span>
                                <span class="<?php if (ceil($r['rating']) >= 4) echo 'active-r'; ?>"></span>
                                <span class="<?php if (ceil($r['rating']) >= 5) echo 'active-r'; ?>"></span>
                            </div>
                            <div class="rl-text"><?php echo $r['text'] ?></div>
                        </div>
                    </li>
                    <?php

                        }

                    } else {
                        echo 'Отзывов нет';
                    }

                ?>
                    </ul>
                </div>

            </div>


    <?php }


        ?>



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