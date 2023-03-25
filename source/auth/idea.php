<?php

use Work\plugin\lib\pQuery;

if (isset($_SESSION['surname']) && isset($_SESSION['password']) && $_SESSION['type'] == 'users') {

    $r = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']]);

    if (empty($r['id'])) {
        $app->notFound();
    }


    Head('Есть идея');

    ?>

    <body class="profile-body">

    <div class="filter-up-bth">
    <span>
        <i class="mdi mdi-tune"></i> фильтры
    </span>

    </div>

    <main class="wrapper wrapper-profile" id="wrapper">

        <?php require('template/more/profileAside.php'); ?>



        <section class="profile-base">

            <?php require('template/more/profileHeader.php'); ?>


            <div class="profile-content create-resume">

                <div class="section-nav-profile">
                    <span><a href="/profile">Профиль</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a>Есть идея</a></span>
                </div>

                <div class="manage-resume-data manage-flex-data">

                    <div class="idea-block">

                    </div>

                    <div class="idea-bth-wrap">

                        <div>
                            Предлагайте свои идеи по улучшению нашего сайта.
                            Отличную идею мы с удовольствием воплотим в жизнь.
                        </div>

                        <button type="button" onclick="createForm()">Предложить идею</button>

                    </div>

                </div>

            </div>

        </section>

    </main>


    <?php require('template/more/profileFooter.php'); ?>

    <script>


        function createForm() {
            document.querySelector('.profile-body').innerHTML += `
        <div id="auth" style="display:flex">
            <div class="contact-wrapper" style="display:block">
                <div class="auth-container auth-log auth-form-r" >
                    <div class="auth-title">
                        Предложить идею
                        <i class="mdi mdi-close form-detete" onclick="deleteForm()"></i>
                    </div>
                    <div class="auth-form">
                        <form class="form-education" role="form" method="post">

                                <div class="label-block">
                                    <label for="">Тема <span>*</span></label>
                                    <input type="text" name="ed-title" id="ed-title" placeholder="" value="">
                                    <span class="empty e-ed-title">Введите тему</span>
                                </div>

                                <div class="label-block">
                                    <label for="">Текст <span>*</span></label>
                                    <textarea name="ed-text" id="ed-text" style="height:100px;" cols="30" rows="10" placeholder="Кратко опишите суть идеи..."></textarea>
                                    <span class="empty e-ed-title">Введите текст</span>
                                </div>

                        </form>

                        <form method="post">
                            <div class="pop-flex-bth">
                                <button class="more-inf" type="button" onclick="deleteForm()">Отмена</button>
                                <button onclick="" type="button" class="lock-yes">Отправить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        `
        }


        function deleteForm () {
            $('#auth').css('display', 'none')
            $('#auth').remove();
        }



    </script>

    </body>
    </html>
    <?php
} else {
    pQuery::notFound();
}
?>