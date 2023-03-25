<?php
if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

    if ($_SESSION['type'] == 'admin') {
        $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($a['id'])) {
            $app->notFound();
        }
    }

    $sid = intval($_GET['id']);

    $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [
        ':id' => $sid
    ]);

    if (!isset($user['id'])) {
        $app->notFound();
    }

    $sth = $PDO->prepare("SELECT * FROM `visits_resume` WHERE `time` > SUBTIME(NOW(), '0 732:0:0') AND `user` = ? AND `year` = ? GROUP BY `day` ORDER BY `id`");
    $sth->execute([$user['id'], date("Y")]);
    $res = $sth->fetchAll(PDO::FETCH_ASSOC);

    $arr = [];
    $sql = $PDO->query("SELECT * FROM `visits_resume` WHERE `user` = '$user[id]' AND `time` >= SUBTIME(NOW(), '0 732:0:0') GROUP BY `company_id`");
    while ($s = $sql->fetch()) {
        $count = $app->query("SELECT * FROM `visits_resume` WHERE `user` = '$user[id]' AND `company_id` = ' $s[company_id]' AND `time` >= SUBTIME(NOW(), '0 732:0:0')");
        $counter = 0;
        while ($c = $count->fetch()) {
            $counter += $c['counter'];
        }

        $arr[] = [
            'label' => $s['company'],
            'value' => $counter
        ];
    }

    Head($user['name'] . ' ' . $user['surname'] . ' - анализ');
    ?>

    <body class="profile-body">



    <main class="wrapper wrapper-profile" id="wrapper">


        <?php require('admin/template/adminAside.php'); ?>

        <section class="profile-base">

            <?php require('admin/template/adminHeader.php'); ?>

            <div class="profile-content admin-content">

                <div class="section-nav-profile">
                    <span><a href="/admin/analysys">Кабинет</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a href="/admin/students-list">Каталог студентов</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a>  <?php echo $user['name'] . ' ' . $user['surname']; ?></a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a>Анализ</a></span>
                </div>

                <div class="manage-resume-data profile-data">

                    <div class="errors-block-fix">

                    </div>

                    <div class="user-block">

                        <div class="user-info">

                            <div class="ui-name">
                                    <span class="ui-img">
                                <img src="/static/image/users/<?php echo $user['img']; ?>" alt="">
                            </span>

                                <h1><?php echo $user['name'] . ' ' . $user['surname']; ?></h1>

                                <h3><?php echo $user['prof']; ?></h3>

                                <div class="ui-stat">

                                    <div class="uis-item">
                                        <span><i class="mdi mdi-briefcase-variant-outline"></i> <m class=""><?php echo $app->count("SELECT * FROM `respond` WHERE `user_id` = '$_GET[id]'"); ?></m></span>

                                        <p>Отклики</p>
                                    </div>

                                    <div class="uis-item">
                                        <span><i class="mdi mdi-eye-outline"></i> <m class=""><?php echo $user['view']; ?></m></span>

                                        <p>Просмотры</p>
                                    </div>

                                    <div class="uis-item">
                                        <span><i class="mdi mdi-hand-back-left-outline"></i> <m class=""><?php echo 0; ?></m></span>

                                        <p>Отказов</p>
                                    </div>

                                </div>
                            </div>



                            <div class="ui-detail">

                                <div>
                                    <span>Регистрация</span>
                                    <p><?php echo $user['date']; ?></p>
                                </div>

                                <div>
                                    <span>Email</span>
                                    <p><?php echo $user['email']; ?></p>
                                </div>

                                <div>
                                    <span>Телефон</span>
                                    <p><?php echo $user['phone']; ?></p>
                                </div>

                                <div>
                                    <span>Дата рождения</span>
                                    <p><?php echo $user['age']; ?></p>
                                </div>

                                <div>
                                    <span>Пол</span>
                                    <p><?php echo $user['gender']; ?></p>
                                </div>

                                <div>
                                    <span>Курс</span>
                                    <p><?php echo $user['course']; ?></p>
                                </div>

                                <div>
                                    <span>Факультет</span>
                                    <p><?php echo $user['faculty']; ?></p>
                                </div>

                                <div>
                                    <span>Направление</span>
                                    <p><?php echo $user['direction']; ?></p>
                                </div>

                                <div>
                                    <span>Образование</span>
                                    <p><?php echo $user['degree']; ?></p>
                                </div>

                                <div>
                                    <span>Тип финансирования</span>
                                    <p><?php echo $user['financing']; ?></p>
                                </div>

                                <div>
                                    <span>Форма обучения</span>
                                    <p><?php echo $user['form_education']; ?></p>
                                </div>

                                <div>
                                    <span>ИНН</span>
                                    <p><?php echo $user['inn']; ?></p>
                                </div>

                                <div>
                                    <span>СНИЛС</span>
                                    <p><?php echo $user['snils']; ?></p>
                                </div>



                            </div>

                        </div>

                        <div class="user-tabs">

                            <div class="ut-list">

                                <a class="<?php if (empty($_GET['t'])) { echo 'ut-active'; } ?>" href="/admin/info-students?id=<?php echo $user['id']; ?>">Обзор</a>
                                <a class="<?php if ($_GET['t'] == 2) { echo 'ut-active'; } ?>" href="/admin/info-students?id=<?php echo $user['id']; ?>&t=2">Настройки</a>
                                <a class="<?php if ($_GET['t'] == 3) { echo 'ut-active'; } ?>" href="/admin/info-students?id=<?php echo $user['id']; ?>&t=3">Безопасность</a>
                                <a class="<?php if ($_GET['t'] == 4) { echo 'ut-active'; } ?>" href="/admin/info-students?id=<?php echo $user['id']; ?>&t=4">Отклики</a>
                                <a class="<?php if ($_GET['t'] == 5) { echo 'ut-active'; } ?>" href="/admin/info-students?id=<?php echo $user['id']; ?>&t=5">События и логи</a>
                                
                            </div>

                            <div class="ut-items">

                                <?php

                                if (empty($_GET['t'])) {

                                    require('admin/module/user-tabs/user-overview.php');

                                } else if ($_GET['t'] == 2) {

                                    require('admin/module/user-tabs/user-setting.php');

                                } else if ($_GET['t'] == 3) {

                                    require('admin/module/user-tabs/user-security.php');

                                } else if ($_GET['t'] == 4) {

                                    require('admin/module/user-tabs/user-respond.php');

                                } else if ($_GET['t'] == 5) {

                                    require('admin/module/user-tabs/user-event.php');

                                }



                                ?>

                            </div>
                            
                        </div>

                    </div>























                </div>


            </div>


        </section>

    </main>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    <?php require('admin/template/adminFooter.php'); ?>

    <script>


        'use strict';

        (function ($) {

            $(document).ready(function () {

                $(document).on('click', '.save-resume', function (e) {
                    e.preventDefault();
                    $('.save-resume').attr('disabled', 'true')
                    $('.save-resume').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
                    $('.empty').fadeOut(50)
                    $('select').removeClass('errors')
                    $('input').removeClass('errors')
                    $('textarea').removeClass('errors')
                    $('.label-block .select2-container--default .select2-selection--single').css({
                        'border': '1px solid #cdd0d5',
                        'background': '#ffffff'
                    })

                    setTimeout(function () {
                        $.ajax({
                            url: '/admin/admin-js',
                            data: `${$('.form-profile').serialize()}&uid=${$_GET['id']}&MODULE_SAVE_STUDENT=1`,
                            type: 'POST',
                            cache: false,
                            dataType: 'json',
                            error: (response) => {
                                MessageBox('Произошла ошибка. Повторите')
                                console.log(response)
                            },
                            success: function (responce) {
                                if (responce.code === 'validate_error') {
                                    let $arr = responce.error
                                    for (let i in $arr) {
                                        if (i === 'faculty') $('span[aria-controls="select2-faculty-container"]').css({
                                            'border': '1px solid #ff4c4c',
                                            'background': 'rgba(255,22,46,.06)'
                                        })
                                        if (i === 'direction') $('span[aria-controls="select2-direction-container"]').css({
                                            'border': '1px solid #ff4c4c',
                                            'background': 'rgba(255,22,46,.06)'
                                        })
                                        if (i === 'degree') $('span[aria-controls="select2-degree-container"]').css({
                                            'border': '1px solid #ff4c4c',
                                            'background': 'rgba(255,22,46,.06)'
                                        })
                                        $(`#${i}`).addClass('errors');
                                        $(`.e-${i}`).fadeIn(50)
                                    }
                                    $('.save-resume').removeAttr('disabled')
                                    $('.save-resume').html('Отправить')
                                    MessageBox('Ошибка валидации')
                                } else {
                                    if (responce.code === 'success') {
                                        $('.save-resume').removeAttr('disabled')
                                        $('.save-resume').html('Сохранить')
                                        MessageBox('Изменения внесены')
                                    } else {
                                        MessageBox('Произошла ошибка. Повторите')
                                        console.log(responce)
                                    }
                                }
                            }});
                    }, 500)


                })


            });

        })(jQuery)


    </script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <script>
        new Morris.Bar({
            element: 'visits',
            data: <?php echo json_encode($res); ?>,
            xkey: 'day',
            ykeys: ['counter'],
            labels: ['Просмотры'],
            fillOpacity: 0.6,
            hideHover: 'auto',
            behaveLikeLine: true,
            resize: true,
            pointFillColors:['#ffffff'],
            pointStrokeColors: ['black'],
            lineColors:['#259ef9','#00e396'],
        });

        console.log(<?php echo json_encode($arr); ?>)

        new Morris.Donut({
            element: 'views',
            resize: true,
            colors: ['#259ef9', '#00e396', '#f39c12', '#f56954', '#3c8dbc'],
            data: <?php echo json_encode($arr); ?>,
            hideHover: 'auto'
        });
    </script>
    <script>function deleteForm(){document.querySelector('#auth').style.display = 'none';document.querySelector('.contact-wrapper').style.display = 'none';document.querySelector('#auth').remove()}</script>


    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>