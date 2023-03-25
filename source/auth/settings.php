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



    Head('Настройки ');

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
                    <span>Настройки </span>
                </div>

                <div class="errors-block-fix">

                </div>

                <div class="manage-resume-data">

                    <div class="pr-data-block block-p bl-1">
                        <span>Рассылки</span>

                        <?php
                        if (isset($_SESSION['id'], $_SESSION['password']) and $_SESSION['type'] == 'company') {

                            ?>
                            <form role="form" class="form-push" method="POST">



                                <div class="push-wrap">
                                    <div class="label-h1">PUSH-уведомления</div>

                                    <div class="push-ctx">
                                        <div class="label-b-check label-push">
                                            <input type="checkbox" class="custom-checkbox" id="p1" name="resp-p" value="1" checked>
                                            <label for="p1">
                                                Новый отклик
                                            </label>
                                        </div>

                                        <div class="label-b-check label-push">
                                            <input type="checkbox" class="custom-checkbox" id="p2" name="review-p" value="1" checked>
                                            <label for="p2">
                                                Новый отзыв
                                            </label>
                                        </div>

                                        <div class="label-b-check label-push">
                                            <input type="checkbox" class="custom-checkbox" id="p3" name="job-p" value="1" checked>
                                            <label for="p3">
                                                Статус вакансии
                                            </label>
                                        </div>

                                        <div class="label-b-check label-push">
                                            <input type="checkbox" class="custom-checkbox" id="p4" name="chat-p" value="1" checked>
                                            <label for="p4">
                                                Переписка со студентом
                                            </label>
                                        </div>
                                    </div>

                                </div>






                                <div class="pf-bth">
                                    <button class="bth save-push" type="button" name="">Сохранить</button>
                                </div>
                            </form>


                            <?php
                        } ?>



    <?php
    if (isset($_SESSION['id'], $_SESSION['password']) and $_SESSION['type'] == 'users') {

        ?>
                        <form role="form" class="form-push" method="POST">

                            <div class="push-wrap">
                                <div class="label-h1">Почтовые рассылки</div>

                                <div class="push-ctx">

                                    <div class="label-b-check label-push">
                                        <input type="checkbox" class="custom-checkbox" id="g1" name="view-g" value="1">
                                        <label for="g1">
                                            Просмотры вашего резюме
                                        </label>
                                    </div>

                                    <div class="label-b-check label-push">
                                        <input type="checkbox" class="custom-checkbox" id="g2" name="status-g" value="1" checked>
                                        <label for="g2">
                                            Смена статуса вакансии
                                        </label>
                                    </div>

                                    <div class="label-b-check label-push">
                                        <input type="checkbox" class="custom-checkbox" id="g3" name="go-g" value="1" checked>
                                        <label for="g3">
                                            Приглашения от работодателей
                                        </label>
                                    </div>

                                    <div class="label-b-check label-push">
                                        <input type="checkbox" class="custom-checkbox" id="g4" name="sub-g" value="1" checked>
                                        <label for="g4">
                                            Вакансии по подписке на компании
                                        </label>
                                    </div>

                                </div>
                            </div>

                            <div class="push-wrap">
                                <div class="label-h1">PUSH-уведомления</div>

                                <div class="push-ctx">
                                    <div class="label-b-check label-push">
                                        <input type="checkbox" class="custom-checkbox" id="p1" name="view-p" value="1">
                                        <label for="p1">
                                            Просмотры вашего резюме
                                        </label>
                                    </div>

                                    <div class="label-b-check label-push">
                                        <input type="checkbox" class="custom-checkbox" id="p2" name="status-p" value="1" checked>
                                        <label for="p2">
                                            Смена статуса вакансии
                                        </label>
                                    </div>

                                    <div class="label-b-check label-push">
                                        <input type="checkbox" class="custom-checkbox" id="p3" name="chat-p" value="1" checked>
                                        <label for="p3">
                                            Переписка с работодателем
                                        </label>
                                    </div>

                                    <div class="label-b-check label-push">
                                        <input type="checkbox" class="custom-checkbox" id="p4" name="go-p" value="1" checked>
                                        <label for="p4">
                                            Приглашения от работодателей
                                        </label>
                                    </div>

                                    <div class="label-b-check label-push">
                                        <input type="checkbox" class="custom-checkbox" id="p5" name="news-p" value="1" checked>
                                        <label for="p5">
                                            Новости сайта и рекламная информация
                                        </label>
                                    </div>

                                    <div class="label-b-check label-push">
                                        <input type="checkbox" class="custom-checkbox" id="p5" name="sub-p" value="1" checked>
                                        <label for="p5">
                                            Вакансии по подписке на компании
                                        </label>
                                    </div>
                                </div>

                            </div>






                            <div class="pf-bth">
                                <button class="bth save-push" type="button" name="">Сохранить</button>
                            </div>
                        </form>


        <?php
    } ?>
                    </div>

                </div>
            </div>
        </section>

    </main>


    <?php require('template/more/profileFooter.php'); ?>


    <script language="JavaScript" src="/static/scripts/profile.js?v=<?= date('YmdHis') ?>"></script>


    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>