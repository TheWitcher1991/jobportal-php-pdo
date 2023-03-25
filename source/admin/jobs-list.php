<?php
if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

    if ($_SESSION['type'] == 'admin') {
        $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($a['id'])) {
            $app->notFound();
        }
    }

    Head('Каталог вакансий');
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
                    <span><a href="/jobs-add">Каталог вакансий</a></span>
                </div>

                <div class="manage-resume-data">
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
                                                    <option value="2">По названию</option>
                                                    <option value="3">По компании</option>
                                                    <option value="4">По просмотрам</option>
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

                                <a class="table-title-a export-job-active"><i class="icon-cloud-download"></i> Экспорт</a>

                                <a target="_blank" href="/admin/jobs-add" class="table-title-a"><i class="icon-pencil"></i> Добавить</a>

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
                                    <div class="table-th"><span><i class="mdi mdi-pound"></i> Заголовок</span></div>
                                    <div class="table-th"><span><i class="mdi mdi-briefcase-variant-outline"></i> Компания</span></div>
                                    <div class="table-th"><span><i class="mdi mdi-eye-outline"></i> Просмотры</span></div>
                                    <div class="table-th"><span><i class="mdi mdi-account-school-outline"></i> Отклики</span></div>
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


                    <!--
                    <div class="manage-profile-block">
                        <div class="block-table">
                            <table class="default-table">
                                <thead>
                                <tr>
                                    <th><span><i class="mdi mdi-key-outline"></i> </span></th>
                                    <th><span><i class="mdi mdi-pound"></i> Заголовок</span></th>
                                    <th><span><i class="mdi mdi-briefcase-variant-outline"></i> Компания</span></th>
                                    <th><span><i class="mdi mdi-eye"></i> Просмотры</span></th>
                                    <th><span><i class="mdi mdi-account-school"></i> Отклики</span></th>
                                    <th><span><i class="mdi mdi-crosshairs-gps"></i> Город</span></th>
                                    <th><span><i class="mdi mdi-button-pointer"></i> Действия</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                $results_per_page = 20;

                                $number_of_results = (int)$app->count("SELECT * FROM `vacancy` WHERE `status` = 0");

                                $number_of_pages = ceil($number_of_results / $results_per_page);

                                if (!isset($_GET['page'])) {
                                    $pag = 1;
                                } else {
                                    $pag = $_GET['page'];
                                }

                                $this_page_first_result = ($pag - 1) * $results_per_page;


                                $count = 0;
                                $sql = $app->query("SELECT * FROM `vacancy` WHERE `status` = 0 ORDER BY `id` DESC LIMIT $this_page_first_result, $results_per_page");
                                while ($rr = $sql->fetch()) {
                                    $count = $count + 1;





                                    ?>
                                    <tr class="resume-<?php echo $count ?>">
                                        <td class="tb-title"><?php echo $rr['id'] ?></td>
                                        <td class="tb-title"><a href="/job?id=<?php echo $rr['id'] ?>"><?php echo mb_strimwidth($rr['title'], 0, 30, "..."); ?> </a></td>
                                        <td class="tb-cat"><a href="/company?id=<?php echo $rr['company_id'] ?>"><?php echo $rr['company'] ?></a></td>
                                        <td class="tb-date"><?php echo $rr['views'] ?></td>
                                        <td class="tb-date"><?php echo $app->rowCount("SELECT * FROM `respond` WHERE `job_id` = :id", [
                                                ':id' => $rr['id']
                                            ]) ?></td>
                                        <td class="tb-cat"><a href="/job-list?loc=<?php echo $rr['address'] ?>""><?php echo $rr['address'] ?></a></td>
                                        <td class="tb-form">
                                            <form action="" method="post">
                                                 <div class="block-manage">

                                                     <a title="Статистика" target="_blank" class="manage-bth-mini" target="_blank" href="/admin/info-jobs?id=<?php echo $rr['id'] ?>"><i class="icon-pie-chart"></i></a>

                                                     <a title="Изменить" target="_blank" class="manage-bth-mini" href="/admin/edit-jobs?id=<?php echo $rr['id'] ?>&act=<?php echo $rr['company_id'] ?>"><i class="icon-pencil"></i></a>

                                                     <button title="Закрыть" name="delete-<?php echo $count ?>" class="manage-bth-mini" type="button"><i class="icon-close"></i></button>

                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php

                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-paginator">
                            <div class="tp-1">
                                <span class="tp-now"><?php echo $pag ?></span> из <span class="tp-total"><?php echo $number_of_pages ?></span>
                            </div>
                            <div class="tp-2">
                                <?php
                                echo $paginator->table($pag, $number_of_results, 20, '/admin/jobs-list/?page=');
                                ?>
                            </div>
                        </div>
                    </div>

-->



                </div>


            </div>



        </section>

    </main>


    <?php require('admin/template/adminFooter.php'); ?>

    <script>

        $(document).on('click', '.export-job-active', function (e) {
            e.preventDefault()

            $.ajax({
                url: '/admin/export-js',
                data: `MODULE_GET_JOB_ACTIVE_LIST=1`,
                type: 'POST',
                cache: false,
                error: (responce) => console.log(responce),
                success: function (responce) {
                    let a = document.createElement('a')
                    let file = new Blob([responce])
                    a.href = URL.createObjectURL(file)
                    let Data = new Date();
                    a.download = `job_active_agro_${Data.getDate()}.${Data.getMonth()}.${Data.getFullYear()}-export.xls`
                    a.click()
                }});
        })


    </script>

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
                data: `col=${$colInput.val()}&type=${$typeInput.val()}&key=${$keyInput.val()}&limit=20&page=${+page}&MODULE_GET_JOB_LIST=1`,
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
                        $('.table-h1').html(`Найдено ${responce.data.countAll} активных`)
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


    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>