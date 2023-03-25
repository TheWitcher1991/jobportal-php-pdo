<?php
if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

    if ($_SESSION['type'] == 'admin') {
        $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($a['id'])) {
            $app->notFound();
        }
    }

    $sid = intval($_GET['id']);

    $rc = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [
        ':id' => $sid
    ]);

    if (empty($rc['id'])) {
        $app->notFound();
    }


    $sth = $PDO->prepare("SELECT * FROM `review` WHERE `company_id` = ?");
    $sth->execute(array((int) $rc['id']));
    $data = $sth->fetchAll(PDO::FETCH_ASSOC);
    $count = count($data);

    if ($count > 0) {
        $rating = 0;
        foreach ($data as $row) {
            $rating += $row['rating'];
        }
        $rating = $rating / $count;
    }


    $res2 = [];
    $sql = $app->query("SELECT * FROM `visits_job` WHERE `company_id` = '$rc[id]' GROUP BY `day` ORDER BY `id` ASC");
    while ($a = $sql->fetch()) {
        $re = $app->rowCount("SELECT * FROM `respond` WHERE `date_ru` = :d AND `company_id` = :id GROUP BY `date_ru` ORDER BY `id`", [
            ':d' => $a['day'],
            ':id' => $rc['id']
        ]);
        $res2[] = [
            'y' => $a['day'],
            'counter'  => $a['counter'],
            'respond' => $re
        ];
    }

    Head($rc['name'] . ' - анализ');
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
                    <span><a href="/admin/companys-list">Каталог компаний</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a>  <?php echo $rc['name']; ?></a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a>Анализ</a></span>
                </div>

                <div class="manage-resume-data profile-data">

                    <div class="errors-block-fix">

                    </div>

                    <div class="user-block">

                        <div class="user-info">

                            <div class="ui-name">
                                    <span class="ui-c-img">
                                <img src="/static/image/company/<?php echo $rc['img']; ?>" alt="">
                            </span>

                                <h1><?php echo $rc['name'] ?></h1>

                                <h3><?php echo $rc['specialty']; ?></h3>

                                <div class="ui-stat">

                                    <div class="uis-item">
                                        <span><i class="mdi mdi-briefcase-variant-outline"></i> <m class=""><?php echo $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_GET[id]'"); ?></m></span>

                                        <p>Отклики</p>
                                    </div>

                                    <div class="uis-item">
                                        <span><i class="mdi mdi-eye-outline"></i> <m class=""><?php echo $rc['views']; ?></m></span>

                                        <p>Просмотры</p>
                                    </div>

                                    <div class="uis-item">
                                        <span><i class="mdi mdi-hand-back-left-outline"></i> <m class=""><?php echo $count; ?></m></span>

                                        <p>Отзывов</p>
                                    </div>

                                </div>
                            </div>



                            <div class="ui-detail">

                                <div>
                                    <span>Регистрация</span>
                                    <p><?php echo $rc['date']; ?></p>
                                </div>

                                <div>
                                    <span>Контакт</span>
                                    <p><?php echo $rc['username']; ?></p>
                                </div>

                                <div>
                                    <span>ИНН</span>
                                    <p><?php echo $rc['inn']; ?></p>
                                </div>

                                <div>
                                    <span>Email</span>
                                    <p><?php echo $rc['email']; ?></p>
                                </div>

                                <div>
                                    <span>Телефон</span>
                                    <p><?php echo $rc['phone']; ?></p>
                                </div>

                                <div>
                                    <span>Тип</span>
                                    <p><?php echo $rc['type']; ?></p>
                                </div>

                                <div>
                                    <span>Штат</span>
                                    <p><?php echo $rc['people']; ?></p>
                                </div>

                                <div>
                                    <span>Сайт</span>
                                    <p><?php echo $rc['website']; ?></p>
                                </div>


                            </div>

                        </div>

                        <div class="user-tabs">

                            <div class="ut-list">

                                <a class="<?php if (empty($_GET['t'])) { echo 'ut-active'; } ?>" href="/admin/info-companys?id=<?php echo $rc['id']; ?>">Обзор</a>
                                <a class="<?php if ($_GET['t'] == 2) { echo 'ut-active'; } ?>" href="/admin/info-companys?id=<?php echo $rc['id']; ?>&t=2">Безопасность</a>
                                <a class="<?php if ($_GET['t'] == 3) { echo 'ut-active'; } ?>" href="/admin/info-companys?id=<?php echo $rc['id']; ?>&t=3">Вакансии</a>
                                <a class="<?php if ($_GET['t'] == 4) { echo 'ut-active'; } ?>" href="/admin/info-companys?id=<?php echo $rc['id']; ?>&t=4">Отклики</a>
                                <a class="<?php if ($_GET['t'] == 5) { echo 'ut-active'; } ?>" href="/admin/info-companys?id=<?php echo $rc['id']; ?>&t=5">События и логи</a>

                            </div>

                            <div class="ut-items">

                                <?php

                                if (empty($_GET['t'])) {

                                    require('admin/module/company-tabs/company-overview.php');

                                } else if ($_GET['t'] == 2) {

                                    require('admin/module/company-tabs/company-security.php');

                                } else if ($_GET['t'] == 3) {

                                    require('admin/module/company-tabs/company-job.php');

                                } else if ($_GET['t'] == 4) {

                                    require('admin/module/company-tabs/company-respond.php');

                                } else if ($_GET['t'] == 5) {

                                    require('admin/module/company-tabs/company-event.php');

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

                $(document).on('click', '.save-company', function (e) {

                    e.preventDefault();
                    $('.save-company').attr('disabled', 'true')
                    $('.save-company').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
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
                            data: `${$('.form-profile').serialize()}&cid=${$_GET['id']}&MODULE_SAVE_COMPANY=1`,
                            type: 'POST',
                            cache: false,
                            dataType: 'json',
                            error: (response) => {
                                MessageBox('Произошла ошибка. Повторите')
                                console.log(response)
                            },
                            success: function (responce) {
                                console.log(responce)
                                if (responce.code === 'validate_error') {
                                    let $arr = responce.error
                                    for (let i in $arr) {
                                        if (i === 'address') $('span[aria-controls="select2-address-container"]').css({
                                            'border': '1px solid #ff4c4c',
                                            'background': 'rgba(255,22,46,.06)'
                                        })
                                        $(`#${i}`).addClass('errors');
                                        $(`.e-${i}`).fadeIn(50)
                                    }
                                    $('.save-company').removeAttr('disabled')
                                    $('.save-company').html('Сохранить')
                                    MessageBox('Ошибка валидации')
                                } else {
                                    if (responce.code === 'success') {
                                        $('.save-company').removeAttr('disabled')
                                        $('.save-company').html('Отправить')
                                        MessageBox('Изменения внесены')
                                    } else {
                                        MessageBox('Произошла ошибка. Повторите')
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

    </script>
    <script>function deleteForm(){document.querySelector('#auth').style.display = 'none';document.querySelector('.contact-wrapper').style.display = 'none';document.querySelector('#auth').remove()}</script>



    <script>

        'use strict';

        (function ($) {


            let $_GET = window
                .location
                .search
                .replace('?','')
                .split('&')
                .reduce(
                    function(p,e){
                        let a = e.split('=');
                        p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
                        return p;
                    },
                    {}
                );


            let $form = $('.form-job'),
                $expInput = $('.filter-exp input'),
                $timeInput = $('.filter-time input'),
                $typeInput = $('.filter-type input'),
                $keyInput = $('#title'),
                $locInput = $('#loc'),
                $sort = $('#sort_job'),
                $pag = $('.paginator'),
                $alive = $('#block_job');


            let limit = 10;

            function _bindHandlers() {
                $pag.on('click', 'a', _changePage);
                $expInput.on('change', _getData);
                $timeInput.on('change', _getData);
                $typeInput.on('change', _getData);
                $sort.on('change', _getData);
                $alive.on('change', _getData);
            }

            function _catalogError(responce) {
                console.log(responce)
                $('.manage-title').html(responce.data.countText)
                $('.man-job').html('<span class="wow fadeIn vac-error">Возникла непредвиденная ошибка</span>');
            }

            function _catalogSuccess(responce) {
                $('.manage-title').html(responce.data.countText)
                $('.man-job').html(responce.data.list);
            }

            function _changePage(e) {
                e.preventDefault();
                e.stopPropagation();

                let $page = $(e.target).parent('div');
                $pag.find('div').removeClass('page-active');
                $page.addClass('page-active');
                _getData($page.attr('data-page'), $_GET['t'] > 0 ? $_GET['t'] : 0);
                $page.addClass('page-active');

                $('html, body').animate({
                    scrollTop: 0
                }, 0);
            }

            function _renderPagination({ pagination }) {
                $pag.html(pagination);
            }


            function _getData(page = 1) {
                $('.man-job').html(`
        <div id="placeholder-main">
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                            </div>

        `);


                $('select').attr('disabled', 'true')
                $('.manage-search-block button').attr('disabled', 'true');
                $('.filter-load').fadeIn(10)
                $('.manage-title').html(`<span><div class="placeholder-item jx-title"></div></span>`)
                let data = `alive=${$alive.val()}&sort=${$sort.val()}&page=${+page}&limit=${+limit}&key=${$keyInput.val()}&loc=${$locInput.val()}&${$form.serialize()}`
                setTimeout(function () {
                    $.ajax({
                        url: '/admin/admin-js',
                        data: `${data}&cid=${$_GET['id']}&MODULE_GET_COMPANY_JOB=1`,
                        type: 'POST',
                        cache: false,
                        dataType: 'json',
                        error: _catalogError,
                        success: function (responce) {
                            if (responce.code === 'success') {
                                $('.manage-search-block button').removeAttr('disabled')
                                $('select').removeAttr('disabled')
                                $('.filter-load').fadeOut(10)
                                $('.man-job').html('')
                                _catalogSuccess(responce);
                                _renderPagination({
                                    pagination: responce.data.pagination
                                });
                                console.log(responce)
                            } else {
                                _catalogError(responce)
                            }
                        }})
                }, 1000)

            }

            function init () {
                _getData(1)
                _bindHandlers()
            }

            $(document).on('click', '.manage-search-block button', function () {
                _getData()
            })



            init();
        })(jQuery);


    </script>


    <script>

        'use strict';

        (function ($) {


            let $_GET = window
                .location
                .search
                .replace('?','')
                .split('&')
                .reduce(
                    function(p,e){
                        let a = e.split('=');
                        p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
                        return p;
                    },
                    {}
                );


            let $form = $('.form-resume'),
                $salaryInput = $('.filter-salary input'),
                $ageTo = $('.age-to'),
                $expInput = $('.filter-exp input'),
                $ageFrom = $('.age-from'),
                $genderInput = $('.filter-gender input'),
                $pag = $('.paginator'),
                $keyInput = $('#title'),
                $locInput = $('#type_search'),
                $sort = $('#sort_respond'),
                $sortFaculty = $('#sort_faculty');

            function _bindHandlers() {
                $pag.on('click', 'a', _changePage);
                $salaryInput.on('change', function () {
                    _getData(1, $_GET['f'] > 0 ? $_GET['f'] : 0)
                });
                $expInput.on('change', function () {
                    _getData(1, $_GET['f'] > 0 ? $_GET['t'] : 0)
                });
                $genderInput.on('change', function () {
                    _getData(1, $_GET['f'] > 0 ? $_GET['f'] : 0)
                });
                $sortFaculty.on('change', function () {
                    _getData(1, $_GET['f'] > 0 ? $_GET['f'] : 0)
                });
                $ageTo.on('change', function () {
                    _getData(1, $_GET['f'] > 0 ? $_GET['f'] : 0)
                });
                $ageFrom.on('change', function () {
                    _getData(1, $_GET['f'] > 0 ? $_GET['f'] : 0)
                });
                $sort.on('change', function () {
                    _getData(1, $_GET['f'] > 0 ? $_GET['f'] : 0)
                });
            }

            function _catalogError(responce) {
                console.log(responce)
                $('.bsc-list').html('Произошла ошибка. Повторите');
            }

            function _catalogSuccess(responce) {
                $('.manage-title').html(responce.data.count)
                $('.bsc-list').html(`${responce.data.list}`);
                $('.manage-search-block button').removeAttr('disabled')
                $('select').removeAttr('disabled')
                $('.filter-load').fadeOut(10)
            }

            function _changePage(e) {
                e.preventDefault();
                e.stopPropagation();

                let $page = $(e.target).parent('div');
                $pag.find('div').removeClass('page-active');
                $page.addClass('page-active');
                _getData($page.attr('data-page'), $_GET['f'] > 0 ? $_GET['f'] : 0);
                $page.addClass('page-active');

                $('html, body').animate({
                    scrollTop: 0
                }, 0);
            }

            function _renderPagination({ pagination }) {
                $pag.html(pagination);
            }


            function _getData(page = 1, type = 0) {
                $('.bsc-list').html(`
        <div id="placeholder-main">
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                            </div>

        `);
                $('select').attr('disabled', 'true')
                $('.manage-search-block button').attr('disabled', 'true');
                $('.filter-load').fadeIn(10)
                $('.manage-title').html(`<span><div class="placeholder-item jx-title"></div></span>`)
                setTimeout(function () {
                    $.ajax({
                        url: '/admin/admin-js',
                        data: `cid=${$_GET['id']}&faculty=${$sortFaculty.val()}&sort=${$sort.val()}&key=${$keyInput.val()}&loc=${$locInput.val()}&t=${type}&page=${+page}&${$form.serialize()}&MODULE_GET_COMPANY_STUDENT=1`,
                        type: 'POST',
                        cache: false,
                        dataType: 'json',
                        error: _catalogError,
                        success: function (responce) {
                            if (responce.code === 'success') {
                                $('.bsc-list').html('');
                                _catalogSuccess(responce);
                                _renderPagination({
                                    pagination: responce.data.pagination
                                });
                            } else {
                                _catalogError(responce);
                            }
                        }});
                }, 500)


            }

            function init () {
                _getData(1, $_GET['f'] > 0 ? $_GET['f'] : 0)
                _bindHandlers()
            }

            $(document).on('click', '.manage-search-block button', function () {
                _getData(1, $_GET['f'] > 0 ? $_GET['f'] : 0)
            })

            init();
        })(jQuery);


    </script>


    <script>



        new Morris.Bar({
            element: 'respond2',
            data: <?php echo json_encode($res2); ?>,
            xkey: 'y',
            ykeys: ['counter', 'respond'],
            labels: ['Просмотры', 'Отклики'],
            fillOpacity: 0.6,
            hideHover: 'auto',
            behaveLikeLine: true,
            resize: true,
            pointFillColors:['#ffffff'],
            pointStrokeColors: ['black'],
            lineColors:['#259ef9','#00e396'],
        });

    </script>

    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>