<?php
if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

    if ($_SESSION['type'] == 'admin') {
        $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($a['id'])) {
            $app->notFound();
        }
    }

    Head('IP адреса');
    ?>

    <body class="profile-body">



    <main class="wrapper wrapper-profile" id="wrapper">


        <?php require('admin/template/adminAside.php'); ?>

        <section class="profile-base">

            <?php require('admin/template/adminHeader.php'); ?>

            <div class="profile-content admin-content">

                <div class="section-nav-profile">
                    <span><a href="/admin/analysis">Кабинет</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a href="/admin/ip">IP адреса</a></span>
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
                                                    <option selected value="1">По дате</option>
                                                    <option value="2">По IP</option>
                                                    <option value="3">По городу</option>
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
                                    <div class="table-th"><span><i class="mdi mdi-timeline-clock-outline"></i> Дата и время (последний раз)</span></div>
                                    <div class="table-th"><span><i class="mdi mdi-crosshairs-question"></i> IP</span></div>
                                    <div class="table-th"><span><i class="mdi mdi-map-marker-radius-outline"></i> Локация</span></div>
                                    <div class="table-th"><span><i class="mdi mdi-login-variant"></i> Кол-во появлений</span></div>
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
                                    <th><span><i class="mdi mdi-clipboard-text-clock-outline"></i> Дата и время (последний раз)</span></th>
                                    <th><span><i class="mdi mdi-crosshairs-gps"></i> IP</span></th>
                                    <th><span><i class="mdi mdi-map-marker-outline"></i> Страна и город</span></th>
                                    <th><span><i class="mdi mdi-login-variant"></i> Количество появлений</span></th>
                                    <th><span><i class="mdi mdi-button-pointer"></i> Действия</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                $number_of_results = $app->count("SELECT * FROM `ip`");

                                $results_per_page = 20;

                                $number_of_pages = ceil($number_of_results / $results_per_page);
                                if (!isset($_GET['page'])) {
                                    $pag = 1;
                                } else {
                                    $pag = $_GET['page'];
                                }
                                $this_page_first_result = ($pag - 1) * $results_per_page;

                                $sql2 = "SELECT * FROM `ip` ORDER BY `id` DESC LIMIT $this_page_first_result, $results_per_page";
                                $stmt2 = $PDO->prepare($sql2);
                                $stmt2->execute();

                                if ($stmt2->rowCount() <= 0) {
                                    echo '<tr><td><span class="error-opt">Список пуст.</span></td><td></td><td></td><td></td></tr>';
                                } else {
                                    $count = 0;
                                    while ($rr = $stmt2->fetch()) {
                                        $count = $count + 1;
                                        $ipc = $app->rowCount("SELECT * FROM `black_list` WHERE `ip` = :ip", [':ip' => $rr['ip']]);

                                        ?>
                                        <tr class="tr-<?php echo $count ?>">
                                            <td class="tb-title"><?php echo $rr['id'] ?></td>
                                            <td class="tb-title"><span><?php echo $rr['date'] . ' в ' . $rr['hour'] ?></span></td>
                                            <td class="tb-title"><span><?php echo $rr['ip'] ?> <?php if ($rr['ip'] == getIp()) { echo '(мой)'; } ?></span></td>
                                            <td class="tb-title"><span><?php echo $rr['country'] . ', ' . $rr['city'] ?></span></td>
                                            <td class="tb-title"><span><?php echo $rr['counter'] ?></span></td>
                                            <td>
                                                <form action="" method="post">

                                                    <div class="block-manage">
                                                        <?php if ($rr['ip'] != getIp()) { ?>

                                                            <?php if ($ipc > 0) { ?>

                                                                <button onclick="removeBlackList('<?php echo $rr['ip'] ?>', '<?php echo $count ?>')" class="manage-bth success-list" type="button"><i class="icon-check"></i> Разблокировать</button>
                                                            <?php } else { ?>
                                                                <button onclick="addBlackList('<?php echo $rr['ip'] ?>', '<?php echo $count ?>')" class="manage-bth black-list" type="button"><i class="icon-ban"></i> Заблокировать</button>
                                                            <?php } ?>


                                                        <?php } ?>
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
                        <div class="table-paginator">
                            <div class="tp-1">
                                <span class="tp-now"><?php echo $pag ?></span> из <span class="tp-total"><?php echo $number_of_pages ?></span>
                            </div>
                            <div class="tp-2">
                                <?php
                                echo $paginator->table($pag, $number_of_results, 20, '/admin/ip/?page=');
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
                data: `col=${$colInput.val()}&type=${$typeInput.val()}&key=${$keyInput.val()}&limit=20&page=${+page}&MODULE_GET_IP_LIST=1`,
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
                        $('.table-h1').html(`Найдено ${responce.data.countAll}`)
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

        function addBlackList(ip, id) {
            $.ajax({
                url: '/admin/admin-js',
                data: `ip=${ip}&MODULE_ADD_BLACK=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => console.log(response),
                success: function (responce) {
                    if (responce.code === 'success') {
                        $(`.tr-${id} .black-list`).remove()
                        $(`.tr-${id} form`).html(`
                        <button onclick="removeBlackList(${ip}, ${id})" class="manage-bth success-list" type="button"><i class="icon-check"></i> Разблокировать</button>
                        `)
                        console.log(responce)
                    } else {
                        alert('Произошла ошибка! Повторите!')
                        console.log(responce)
                    }
                }
            })
        }


        function removeBlackList(ip, id) {
            $.ajax({
                url: '/admin/admin-js',
                data: `ip=${ip}&MODULE_REMOVE_BLACK=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => console.log(response),
                success: function (responce) {
                    if (responce.code === 'success') {
                        $(`.tr-${id} .success-list-list`).remove()
                        $(`.tr-${id} form`).html(`
                        <button onclick="addBlackList(${ip}, ${id})" class="manage-bth black-list" type="button"><i class="icon-ban"></i> Заблокировать</button>
                        `)
                    } else {
                        alert('Произошла ошибка! Повторите!')
                        console.log(responce)
                    }
                }
            })
        }

    </script>

    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>