<?php
if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

    if ($_SESSION['type'] == 'admin') {
        $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($a['id'])) {
            $app->notFound();
        }
    }

    Head('Каталог компаний');
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
                    <span><a href="/companys-list">Каталог компаний</a></span>
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
                                                    <option value="3">По вакансиям</option>
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

                                <a class="table-title-a export-company"><i class="icon-cloud-download"></i> Экспорт</a>

                                <a target="_blank" href="/admin/companys-add" class="table-title-a"><i class="icon-pencil"></i> Добавить</a>

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
                                    <div class="table-th"><span><i class="mdi mdi-pound"></i> Название</span></div>
                                    <div class="table-th"><span><i class="mdi mdi-account-outline"></i> Контактное лицо</span></div>
                                    <div class="table-th"><span><i class="mdi mdi-phone-in-talk-outline"></i> Телефон</span></div>
                                    <div class="table-th"><span><i class="mdi mdi-texture-box"></i> Кол-во вакансий</span></div>
                                    <div class="table-th"><span><i class="mdi mdi-account-school-outline"></i> Кол-во откликов</span></div>
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
                                    <th><span><i class="mdi mdi-pound"></i> Название</span></th>
                                    <th><span><i class="mdi mdi-account"></i> Контактное лицо</span></th>
                                    <th><span><i class="mdi mdi-phone"></i> Телефон</span></th>
                                    <th><span><i class="mdi mdi-texture-box"></i> Кол-во вакансий</span></th>
                                    <th><span><i class="mdi mdi-account-school-outline"></i> Кол-во откликов</span></th>
                                    <th><span><i class="mdi mdi-button-pointer"></i> Действия</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php


                                $results_per_page = 15;

                                $number_of_results = (int)$app->count("SELECT * FROM `company`");

                                $number_of_pages = ceil($number_of_results / $results_per_page);

                                if (!isset($_GET['page'])) {
                                    $pag = 1;
                                } else {
                                    $pag = $_GET['page'];
                                }

                                $this_page_first_result = ($pag - 1) * $results_per_page;

                                $count = 0;


                                $sql = $app->query('SELECT * FROM `company` ORDER BY `id` DESC LIMIT ' . $this_page_first_result . ',' .  $results_per_page);

                                while ($rr = $sql->fetch()) {
                                    $count = $count + 1;





                                    ?>
                                    <tr class="tr-<?php echo $count ?> wow fadeIn">
                                        <td class="tb-title"><?php echo $rr['id'] ?></td>
                                        <td class="tb-title"><a href="/company?id=<?php echo $rr['id'] ?>"><?php echo $rr['name'] ?></a></td>
                                        <td class="tb-date"><span><?php echo $rr['username'] ?></span></td>
                                        <td class="tb-date"><span><?php echo $rr['phone'] ?></span></td>
                                        <td class="tb-date"><span><?php echo $rr['job'] ?></span></td>
                                        <td class="tb-date"><span><?php echo $app->rowCount("SELECT * FROM `respond` WHERE `company_id` = :id", [
                                                ':id' => $rr['id']
                                                ]) ?></span></td>
                                        <td class="tb-form">
                                            <form action="" method="post">

                                                 <div class="block-manage">
                                                     <?php if ($rr['verified'] != 1) { ?>
                                                         <button onclick="addChecked('<?php echo $rr['id'] ?>', <?php echo $count ?>)" class="manage-bth good-list" type="button"><i class="icon-check"></i> Проверена</button>
                                                     <?php } ?>

                                                     <a title="Статистика" target="_blank" class="manage-bth-mini" target="_blank" href="/admin/info-companys?id=<?php echo $rr['id'] ?>"><i class="icon-pie-chart"></i></a>


                                                     <a title="Изменить" target="_blank" class="manage-bth-mini" href="/admin/edit-companys?id=<?php echo $rr['id'] ?>"><i class="icon-pencil"></i></a>

                                                     <button title="Скрыть из поиска" onclick="deleteVac('<?php echo $rr['name'] ?>', '<?php echo $rr['id'] ?>')" class="manage-bth-mini" type="button"><i class="icon-ban"></i></button>


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
                                echo $paginator->table($pag, $number_of_results, 15, '/admin/companys-list/?page=');
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

        $(document).on('click', '.export-company', function (e) {
            e.preventDefault()

            $.ajax({
                url: '/admin/export-js',
                data: `MODULE_GET_COMPANY_LIST=1`,
                type: 'POST',
                cache: false,
                error: (responce) => console.log(responce),
                success: function (responce) {
                    let a = document.createElement('a')
                    let file = new Blob([responce])
                    a.href = URL.createObjectURL(file)
                    let Data = new Date();
                    a.download = `company_agro_${Data.getDate()}.${Data.getMonth()}.${Data.getFullYear()}-export.xls`
                    a.click()
                }});
        })


    </script>

    <script>

        function deleteForm(){document.querySelector('#auth').remove()}

        function deleteVac(name, id){document.querySelector('.profile-body').innerHTML+=`

                        <div id="auth" style="display:flex">
                    <div class="contact-wrapper" style="display:block">
                        <div class="auth-container auth-log" style="display:block">
                            <div class="auth-title">
                                Заблокировать компанию
                                <i class="mdi mdi-close form-detete" onclick="deleteForm()"></i>
                            </div>
                            <div class="auth-form">
                                <div class="pop-text">
                                    Вы уверены, что заблокировать компанию? Из базы она удалена не будет, но она будет скрыта из системы поиска и не сможет публиковать новые вакансии
                                </div>
                                <span><i class="icon-briefcase"></i> ${name}</span>
                                <form method="post">
                                    <div class="pop-flex-bth">
                                        <button class="more-inf" type="button" onclick="deleteForm()">Отмена</button>
                                        <button data-id="${id}" type="button" class="lock-yes yes-lock-comp" name="delete-${id}" onclick="deleteJob(${id}, this)">Заблокировать</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `}
    </script>


    <script>

        function addChecked(t, id) {
            $.ajax({
                url: '/admin/admin-js',
                data: `id=${t}&MODULE_ADD_BLACK=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => console.log(response),
                success: function (responce) {
                    if (responce.code === 'success') {
                        $(`.tr-${id} .good-list`).remove()
                    } else {
                        alert('Произошла ошибка! Повторите!')
                        console.log(responce)
                    }
                }
            })
        }

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
                data: `col=${$colInput.val()}&type=${$typeInput.val()}&key=${$keyInput.val()}&limit=15&page=${+page}&MODULE_GET_COMPANY_LIST=1`,
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


    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>