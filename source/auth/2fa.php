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



    Head('Двухфакторная аутентификация ');

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
                    <span>Двухфакторная аутентификация </span>
                </div>

                <div class="errors-block-fix">

                </div>

                <div class="manage-resume-data">

                    <? include 'template/more/profileHead.php'; ?>

                    <div class="fa2-info-block">

                        <i class="mdi mdi-shield-account"></i>

                        <span>Подтверждение входа</span>


                        <p>Чтобы войти в аккаунт, нужно ввести одноразовый код, который придёт на Вашу электронную почту</p>


                        <?php if ($_SESSION['type'] == 'users') {?>

                            <?php if ($r['2fa'] == 0) {?>

                                <button type="button" onclick="create2FA()" class="create-2fa">Включить</button>

                            <?php }  else { ?>

                                <button type="button" onclick="delete2FA()" class="delete-2fa"><i class="mdi mdi-check-circle"></i> Включено</button>

                            <? } ?>

                        <?php } ?>

                        <?php if ($_SESSION['type'] == 'company') {?>

                            <?php if ($r['2fa'] == 0) {?>

                                <button type="button" onclick="create2FA()" class="create-2fa">Включить</button>

                            <?php }  else { ?>

                                <button type="button" onclick="delete2FA()" class="delete-2fa"><i class="mdi mdi-check-circle"></i> Включено</button>

                            <? } ?>

                        <?php } ?>

                    </div>

                </div>
            </div>
        </section>

    </main>


    <?php require('template/more/profileFooter.php'); ?>



        <script>

            function respond2FA() {
                $('.empty').fadeOut(50)
                $('input').removeClass('errors')
                $('.lock-yes').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
                $('.lock-yes').attr('disabled', 'true')
                $.ajax({
                    url: '/scripts/profile-js',
                    data: `${$('.form-2fa').serialize()}&MODULE_CREATE_2FA=1`,
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    error: (response) => {
                        $('.lock-yes').html('Включить')
                        $('.lock-yes').removeAttr('disabled')
                    },
                    success: function (responce) {
                        if (responce.code === 'validate_error') {
                            $(`#password`).addClass('errors');
                            $('.e-password').fadeIn(50)
                            $('.e-password').html(responce.error['password'])
                            $('.lock-yes').html('Включить')
                            $('.lock-yes').removeAttr('disabled')
                        } else if (responce.code === 'success') {
                            $('.lock-yes').removeAttr('disabled')
                            location.reload()
                        } else {
                            $('.lock-yes').html('Включить')
                            $('.lock-yes').removeAttr('disabled')
                        }
                    }
                })
            }

            function untill2FA() {
                $('.empty').fadeOut(50)
                $('input').removeClass('errors')
                $('.lock-yes').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
                $('.lock-yes').attr('disabled', 'true')
                $.ajax({
                    url: '/scripts/profile-js',
                    data: `${$('.form-2fa').serialize()}&MODULE_DELETE_2FA=1`,
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    error: (response) => {
                        $('.lock-yes').html('Удалить')
                        $('.lock-yes').removeAttr('disabled')
                    },
                    success: function (responce) {
                        if (responce.code === 'validate_error') {
                            $(`#password`).addClass('errors');
                            $('.e-password').fadeIn(50)
                            $('.e-password').html(responce.error['password'])
                            $('.lock-yes').html('Удалить')
                            $('.lock-yes').removeAttr('disabled')
                        } else if (responce.code === 'success') {
                            $('.lock-yes').removeAttr('disabled')
                            location.reload()
                        } else {
                            $('.lock-yes').html('Удалить')
                            $('.lock-yes').removeAttr('disabled')
                        }
                    }
                })
            }


            function create2FA() {
                document.querySelector('.profile-body').innerHTML += `
                        <div id="auth" style="display:flex">
                    <div class="contact-wrapper" style="display:block">
                        <div class="auth-container auth-log" style="display:block;">
                            <div class="auth-title">
                                Включить 2FA
                                <i class="mdi mdi-close form-detete" onclick="deleteForm()"></i>
                            </div>
                            <div class="auth-form">
                                <span>Для продолжения необходимо подтвердить, что Вы являетесь владельцем аккаунта</span>
                                <form class="form-2fa" role="form" method="post">

                                    <div class="label-block">
                                        <label for="">Ваш пароль <span>*<span></label>
                                         <div class="label-password">
                                            <input type="password" id="password" name="password">
                                            <i class="mdi mdi-eye-outline eye-password in-pass"></i>
                                        </div>
                                        <span class="empty e-password">Введите пароль</span>
                                    </div>
                                </form>

                                <form method="post">
                                    <div class="pop-flex-bth">
                                        <button class="more-inf" type="button" onclick="deleteForm()">Отмена</button>
                                        <button onclick="respond2FA()" type="button" class="lock-yes">Включить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `
            }

            function delete2FA() {
                document.querySelector('.profile-body').innerHTML += `
                        <div id="auth" style="display:flex">
                    <div class="contact-wrapper" style="display:block">
                        <div class="auth-container auth-log" style="display:block;">
                            <div class="auth-title">
                                Удалить 2FA
                                <i class="mdi mdi-close form-detete" onclick="deleteForm()"></i>
                            </div>
                            <div class="auth-form">
                                <span>Для продолжения необходимо подтвердить, что Вы являетесь владельцем аккаунта</span>
                                <form class="form-2fa" role="form" method="post">

                                    <div class="label-block">
                                        <label for="">Ваш пароль <span>*<span></label>
                                         <div class="label-password">
                                            <input type="password" id="password" name="password">
                                            <i class="mdi mdi-eye-outline eye-password in-pass"></i>
                                        </div>
                                        <span class="empty e-password">Введите пароль</span>
                                    </div>
                                </form>

                                <form method="post">
                                    <div class="pop-flex-bth">
                                        <button class="more-inf" type="button" onclick="deleteForm()">Отмена</button>
                                        <button onclick="untill2FA()" type="button" class="lock-yes">Удалить</button>
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
    $app->notFound();
}
?>