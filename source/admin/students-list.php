<?php
if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

    if ($_SESSION['type'] == 'admin') {
        $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($a['id'])) {
            $app->notFound();
        }
    }

    Head('Каталог студентов');
    ?>

    <body class="profile-body">



    <main class="wrapper wrapper-profile" id="wrapper">


        <?php require('admin/template/adminAside.php'); ?>

        <section class="profile-base">

            <?php require('admin/template/adminHeader.php'); ?>

            <div class="profile-content admin-content">

                <div class="section-nav-profile">
                    <span><a href="admin/analysys">Кабинет</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a href="admin/students-list">Каталог студентов</a></span>
                </div>

                <div class="manage-resume-data">

                    <div class="al-stats">
                        <ul>


                            <li>
                                <div class="as-t">
                                    <span class="as-tt"><? echo $app->count("SELECT * FROM `users`") ?></span>
                                    <span class="as-tk">Студентов</span>
                                </div>
                                <div class="as-i"><i class="mdi mdi-school-outline"></i></div>

                            </li>


                            <li>
                                <div class="as-t">
                                    <span class="as-tt"><? echo $app->count("SELECT * FROM `respond`") ?></span>
                                    <span class="as-tk">Откликов</span>
                                </div>
                                <div class="as-i"><i class="mdi mdi-briefcase-variant-outline"></i></div>

                            </li>

                            <li>
                                <div class="as-t">
                                    <span class="as-tt"><?php echo $app->count("SELECT * FROM `online` WHERE `type` = 'users'") ?></span>
                                    <span class="as-tk">На сайте сейчас</span>
                                </div>
                                <div class="as-i"><i class="mdi mdi-eye-outline"></i></div>

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
                                                    <option value="2">По фамилии</option>
                                                    <option value="3">По факультету</option>
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

                                <a class="table-title-a export-students"><i class="icon-cloud-download"></i> Экспорт</a>

                                <a target="_blank" href="/admin/students-add" class="table-title-a"><i class="icon-pencil"></i> Добавить</a>

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
                                    <div class="table-th"><span><i class="mdi mdi-pound"></i> Имя</span></div>
                                    <div class="table-th"><span><i class="mdi mdi-account-school-outline"></i> Факультет</span></div>
                                    <div class="table-th"><span><i class="mdi mdi-head-question-outline"></i> Профессиия</span></div>
                                    <div class="table-th"><span><i class="mdi mdi-phone-in-talk-outline"></i> Телефон</span></div>
                                    <div class="table-th"><span><i class="mdi mdi-briefcase-variant-outline"></i> Откликов</span></div>
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


               <!--     <div class="manage-profile-block">
                        <div class="block-table">
                            <table class="default-table">
                                <thead>
                                <tr>
                                    <th><span><i class="mdi mdi-key-outline"></i> </span></th>
                                    <th><span><i class="mdi mdi-pound"></i> Имя</span></th>
                                    <th><span><i class="mdi mdi-account-school"></i> Факультет</span></th>
                                    <th><span><i class="mdi mdi-head-question-outline"></i> Профессия</span></th>
                                    <th><span><i class="mdi mdi-phone"></i> Телефон</span></th>
                                    <th><span><i class="mdi mdi-briefcase-variant-outline"></i> Отклики</span></th>
                                    <th><span><i class="mdi mdi-button-pointer"></i> Действия</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                    $results_per_page = 15;

                                    $number_of_results = (int)$app->count("SELECT * FROM `users`");

                                    $number_of_pages = ceil($number_of_results / $results_per_page);

                                    if (!isset($_GET['page'])) {
                                        $pag = 1;
                                    } else {
                                        $pag = $_GET['page'];
                                    }

                                    $this_page_first_result = ($pag - 1) * $results_per_page;


                                    $count = 0;



                                    $sql = $app->query('SELECT * FROM `users`  ORDER BY `id` DESC LIMIT ' . $this_page_first_result . ',' .  $results_per_page);
                                    while ($rr = $sql->fetch()) {
                                        $count = $count + 1;





                                        ?>
                                        <tr class="resume-<?php echo $count ?> wow fadeIn">
                                            <td class="tb-title"><?php echo $rr['id'] ?></td>
                                            <td class="tb-title"><a href="/resume?id=<?php echo $rr['id'] ?>"><?php echo $rr['name'] . ' ' . $rr['surname'] ?></a></td>
                                            <td class="tb-cat"><a href="/students?f=<?php echo $rr['faculty'] ?>"><?php echo $rr['faculty'] ?></a></td>
                                            <td class="tb-date"><span><?php echo $rr['prof'] ?></span></td>
                                            <td class="tb-date"><span><?php echo $rr['phone'] ?></span></td>
                                            <td class="tb-date"><span><?php echo $app->rowCount("SELECT * FROM `respond` WHERE `user_id` = :id", [
                                                    ':id' => $rr['id']
                                                    ]) ?></span></td>
                                            <td class="tb-form">
                                                <form action="" method="post">
                                                    
                                                    <div class="block-manage">
                                                        <a class="manage-bth-mini" target="_blank" href="/admin/info-students?id=<?php echo $rr['id'] ?>"><i class="icon-pie-chart"></i></a>
                                                        <a class="manage-bth-mini" target="_blank" href="/admin/edit-students?id=<?php echo $rr['id'] ?>"><i class="icon-pencil"></i></a>
                                                        <button onclick="deleteVac('<?php echo $rr['name'] . ' ' . $rr['surname'] ?>','<?php echo $rr['id'] ?>')" class="manage-bth-mini" type="button"><i class="icon-ban"></i></button>
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
                                echo $paginator->table($pag, $number_of_results, 15, '/admin/students-list/?page=');
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

        function deleteForm(){document.querySelector('#auth').remove()}

        function deleteVac(name, id){document.querySelector('.profile-body').innerHTML+=`

                        <div id="auth" style="display:flex">
                    <div class="contact-wrapper" style="display:block">
                        <div class="auth-container auth-log" style="display:block">
                            <div class="auth-title">
                                Заблокировать студента
                                <i class="mdi mdi-close form-detete" onclick="deleteForm()"></i>
                            </div>
                            <div class="auth-form">
                                <div class="pop-text">
                                    Вы уверены, что заблокировать студента? Из базы он удалён не будет, но его резюме будет скрыто из системы поиска
                                </div>
                                <span><i class="icon-briefcase"></i> ${name}</span>
                                <form method="post">
                                    <div class="pop-flex-bth">
                                        <button class="more-inf" type="button" onclick="deleteForm()">Отмена</button>
                                        <button data-id="${id}" type="button" class="lock-yes yes-lock-stud" name="delete-${id}" onclick="deleteJob(${id}, this)">Заблокировать</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `}
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
                data: `col=${$colInput.val()}&type=${$typeInput.val()}&key=${$keyInput.val()}&limit=15&page=${+page}&MODULE_GET_STUDENT_LIST=1`,
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

        $(document).on('click', '.export-students', function (e) {
            e.preventDefault()

            $.ajax({
                url: '/admin/export-js',
                data: `MODULE_GET_USERS_LIST=1`,
                type: 'POST',
                cache: false,
                error: (responce) => console.log(responce),
                success: function (responce) {
                    let a = document.createElement('a')
                    let file = new Blob([responce])
                    a.href = URL.createObjectURL(file)
                    let Data = new Date();
                    a.download = `students_agro_${Data.getDate()}.${Data.getMonth()}.${Data.getFullYear()}-export.xls`
                    a.click()
                }});
        })


    </script>


    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>