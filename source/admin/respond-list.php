<?php
if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

    if ($_SESSION['type'] == 'admin') {
        $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($a['id'])) {
            $app->notFound();
        }
    }

    Head('Отклики студентов');
    ?>

    <body class="profile-body">



    <main class="wrapper wrapper-profile" id="wrapper">


        <?php require('admin/template/adminAside.php'); ?>

        <section class="profile-base">

            <?php require('admin/template/adminHeader.php'); ?>

            <div class="profile-content admin-content">

                <div class="section-nav-profile">
                    <span><a href="/analysys">Кабинет</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a href="/admin/respond-list">Отклики студентов</a></span>
                </div>

                <div class="manage-resume-data">


                    <div class="al-stats">
                        <ul>

                            <li>
                                <div class="as-t">
                                    <span class="as-tt"><?php echo $app->rowCount("SELECT * FROM `respond` WHERE `status` = :st", [':st' => 0]) ?></span>
                                    <span class="as-tk">На рассмотрении</span>
                                </div>
                                <div class="as-i"><i class="mdi mdi-alert-decagram-outline"></i></div>

                            </li>

                            <li>
                                <div class="as-t">
                                    <span class="as-tt"><?php echo $app->rowCount("SELECT * FROM `respond` WHERE `status` = :st", [':st' => 2]) ?></span>
                                    <span class="as-tk">Разговор по телефону</span>
                                </div>
                                <div class="as-i"><i class="mdi mdi-phone-in-talk-outline"></i></div>

                            </li>


                            <li>
                                <div class="as-t">
                                    <span class="as-tt"><?php echo $app->rowCount("SELECT * FROM `respond` WHERE `status` = :st", [':st' => 3]) ?></span>
                                    <span class="as-tk">Собеседование</span>
                                </div>
                                <div class="as-i"><i class="mdi mdi-head-question-outline"></i></div>

                            </li>

                            <li>
                                <div class="as-t">
                                    <span class="as-tt"><?php echo $app->rowCount("SELECT * FROM `respond` WHERE `status` = :st", [':st' => 5]) ?></span>
                                    <span class="as-tk">Отказ</span>
                                </div>
                                <div class="as-i"><i class="mdi mdi-delete-variant"></i></div>

                            </li>

                            <li>
                                <div class="as-t">
                                    <span class="as-tt"><?php echo $app->rowCount("SELECT * FROM `respond` WHERE `status` = :st", [':st' => 4]) ?></span>
                                    <span class="as-tk">Принят на работу</span>
                                </div>
                                <div class="as-i"><i class="mdi mdi-hand-wave-outline"></i></div>

                            </li>
                        </ul>
                    </div>



                    <div class="table-wrapper">

                        <div class="table-h1">Загрузка...</div>

                        <div class="table-title">

                            <div class="table-title-left">

                                <div class="table-field">
                                    <label for="">
                                        <input type="text" name="key" id="title" placeholder="Поиск...">
                                        <button class="table-search" type="button"><i class="mdi mdi-magnify"></i></button>
                                    </label>
                                </div>

                            </div>

                            <div class="table-title-right">

                                <div class="table-select-field">
                                    <span>
                                        <i class="icon-equalizer"></i> Фильтр
                                    </span>
                                    <div class="table-select-popup">

                                        <span>Параметры фильтра</span>

                                        <form method="post" class="table-select-label">

                                            <label for="columns">
                                                <span>Столбец:</span>
                                                <select name="sort_columns" id="sort_columns">
                                                    <option selected value="1">По ключу</option>
                                                    <option value="2">По вакансии</option>
                                                    <option value="3">По студенту</option>
                                                    <option value="4">По дате</option>
                                                    <option value="5">По статусу</option>
                                                    <!--<option value="4">По откликам</option>-->
                                                </select>
                                            </label>

                                            <label for="type">
                                                <span>Тип:</span>
                                                <select name="sort_type" id="sort_type">
                                                    <option selected value="1">От Я-А</option>
                                                    <option value="2">От А-Я</option>
                                                </select>
                                            </label>

                                        </form>



                                        <div class="table-select-button">

                                            <button class="table-reset" name="table-reset" type="button">Сбросить</button>
                                            <button class="table-apply" name="table-apply" type="button">Применить</button>

                                        </div>

                                    </div>
                                </div>

                                <a class="table-title-a export-respond"><i class="icon-cloud-download"></i> Экспорт</a>


                            </div>

                        </div>

                        <div class="table-scroll">

                            <i class="fa-solid fa-arrow-left-long"></i>

                            Горизонтальный скроллинг

                            <i class="fa-solid fa-arrow-right-long"></i>

                        </div>

                        <section class="table-content">

                            <header class="table-thead">
                                <div class="table-tr">
                                    <div class="table-th"><span><i class="mdi mdi-key-outline"></i> </span></div>
                                    <div class="table-th"><span><i class="mdi mdi-pound"></i> Вакансия</span></div>
                                    <div class="table-th"><span><i class="mdi mdi-account-school-outline"></i> Студент</span></div>
                                    <div class="table-th"><span><i class="mdi mdi-weather-cloudy-clock"></i> Дата</span></div>
                                    <div class="table-th"><span><i class="mdi mdi-source-branch-check"></i> Статус</span></div>
                                    <div class="table-th"><span><i class="mdi mdi-map-marker-radius-outline"></i> Город</span></div>
                                    <div class="table-th"><span><i class="mdi mdi-button-pointer"></i> Действия</span></div>
                                </div>
                            </header>

                            <div class="table-tbody">
                                <div class="table-tr">
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                </div>
                                <div class="table-tr">
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                </div>
                                <div class="table-tr">
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                </div>
                                <div class="table-tr">
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                </div>
                                <div class="table-tr">
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                </div>
                                <div class="table-tr">
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                </div>
                                <div class="table-tr">
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                </div>
                                <div class="table-tr">
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                </div>
                                <div class="table-tr">
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                </div>
                                <div class="table-tr">
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                </div>
                                <div class="table-tr">
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                </div>
                                <div class="table-tr">
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                </div>
                                <div class="table-tr">
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                </div>
                                <div class="table-tr">
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                </div>
                                <div class="table-tr">
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                    <div><span class="table-placeholder"></span></div>
                                </div>
                            </div>

                        </section>


                        <div class="table-pagination">
                            <div class="table-paginator-all">
                                <span class="tp-now"></span>
                            </div>

                            <div class="table-paginator-list">

                            </div>
                        </div>



                    </div>





                </div>


            </div>



        </section>

    </main>


    <?php require('admin/template/adminFooter.php'); ?>

    <script>

        let $keyInput = $('#title'),
            $colInput = $('#sort_columns'),
            $typeInput = $('#sort_type');

        let $pag = $('.table-paginator-list')

        function _bindHandlers() {
            $pag.on('click', 'a', function (e) {
                e.preventDefault()
                _changePage(e)
            });
        }

        function _changePage(e) {
            e.preventDefault();
            e.stopPropagation();

            let $page = $(e.target).parent('div');
            $pag.find('div').removeClass('page-active');
            $page.addClass('page-active');
            _getData($page.attr('data-page'));
            $page.addClass('page-active');

        }


        function _getData(page = 1) {
            $('.table-paginator-list a').attr('disabled', 'true')

            let data = '';

            $.ajax({
                url: '/admin/admin-js',
                data: `col=${$colInput.val()}&type=${$typeInput.val()}&key=${$keyInput.val()}&limit=15&page=${+page}&MODULE_GET_RESPOND_LIST=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (responce) => console.log(responce),
                success: function (responce) {
                    if (responce.code === 'success') {
                        console.log(responce)
                        $('.table-tbody').html(responce.data.list);
                        $('.table-paginator-list').html(responce.data.pagination)
                        $('.table-paginator-all').html(` <span class="tp-now">${page}</span> из <span class="tp-total">${responce.data.countPages}</span>`)
                        $('.table-h1').html(`Найден ${responce.data.countAll}`)
                    } else {
                        console.log(responce)
                    }
                }});
        }

        function init () {
            _getData(1)
            _bindHandlers()
        }

        $(document).on('click', '.table-search', function () {
            _getData(1)
        })

        $(document).on('click', '.table-select-field > span', function () {
            $(this).toggleClass('table-select-active');
            $('.table-select-popup').toggle();
        })

        $(document).on('click', '.table-reset', function (e) {
            e.preventDefault()
            $('.table-select-label')[0].reset()
            $('.table-select-field > span').removeClass('table-select-active');
            $('.table-select-popup').fadeOut(200);
            _getData(1)
        })

        $(document).on('click', '.table-apply', function (e) {
            e.preventDefault()
            $('.table-select-field > span').removeClass('table-select-active');
            $('.table-select-popup').fadeOut(200);
            _getData(1)
        })

        init()

    </script>

    <script>

        $(document).on('click', '.export-respond', function (e) {
            e.preventDefault()

            $.ajax({
                url: '/admin/export-js',
                data: `MODULE_GET_RESPOND_LIST=1`,
                type: 'POST',
                cache: false,
                error: (responce) => console.log(responce),
                success: function (responce) {
                    let a = document.createElement('a')
                    let file = new Blob([responce])
                    a.href = URL.createObjectURL(file)
                    let Data = new Date();
                    a.download = `respond_agro_${Data.getDate()}.${Data.getMonth()}.${Data.getFullYear()}-export.xls`
                    a.click()
                }});
        })


    </script>

    <script>
        function deleteForm(){document.querySelector('#auth').style.display = 'none';document.querySelector('.contact-wrapper').style.display = 'none';document.querySelector('#auth').remove()}
    </script>


    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>