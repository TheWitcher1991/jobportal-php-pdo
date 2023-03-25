<?php

if (isset($_SESSION['id']) && isset($_SESSION['password'])) {

    if ($_SESSION['type'] == 'users') {
        $r = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($r['id'])) {
            $app->notFound();
            exit;
        }
    } else if ($_SESSION['type'] == 'company') {
        $r = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($r['id'])) {
            $app->notFound();
            exit;
        }
    } else {
        $app->notFound();
        exit;
    }


    Head('Избранное');

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
                    <span><a>Избранное</a></span>
                </div>


                <div class="manage-resume-data">

                    <div class="manage-job-wrapper">

                        <div class="block-wrapper-manag">

                            <div class="manage-filter">
                                <div class="manage-title">
                                    <span><div class="placeholder-item jx-title"></div></span>
                                </div>




                                <div class="manage-search-block">
                                    <input type="text" name="title" id="title" placeholder="Поиск по названию">
                                    <input type="text" name="loc" id="loc" placeholder="Населённый пункт">
                                    <button type="button">Найти</button>
                                </div>


                            </div>


                        </div>


                        <div class="manage-list">

                            <div class="manage-ul">
                                <div class="bsc-list">
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
                                </div>

                                <div class="paginator"></div>
                            </div>


                                <div class="manage-filter-list">
                                    <div class="filter-title">
                                        Фильтры <i class="mdi mdi-close"></i>
                                    </div>

                                    <form role="form" class="form-job form-filter" method="GET">

                                        <div class="filter-main filter-resume">


                                            <div class="filter-load" style="display: none;">

                                            </div>

                                            <div class="filter-layout salary">
                                                <div class="fl-title">Опыт работы<i class="fa-solid fa-chevron-up"></i> </div>
                                                <div class="filter-block-pop">
                                                    <div class="filter-ul">
                                                        <ul class="filter-up filter-exp">
                                                            <li>
                                                                <div>
                                                                    <input class="custom-radio" checked="" name="exp" type="radio" id="99" value="0">
                                                                    <label for="99">Не важно</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input class="custom-radio" name="exp" type="radio" id="100" value="1">
                                                                    <label for="100">Без опыта</label>
                                                                </div>
                                                                <span></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input class="custom-radio" name="exp" type="radio" id="101" value="2">
                                                                    <label for="101">1-3 года</label>
                                                                </div>
                                                                <span></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input class="custom-radio" name="exp" type="radio" id="102" value="3">
                                                                    <label for="102">3-6 лет</label>
                                                                </div>
                                                                <span></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input class="custom-radio" name="exp" type="radio" id="103" value="4">
                                                                    <label for="103">Более 6 лет</label>
                                                                </div>
                                                                <span></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="filter-layout salary">
                                                <div class="fl-title">График работы <i class="fa-solid fa-chevron-up"></i> </div>
                                                <div class="filter-block-pop">
                                                    <div class="filter-ul">
                                                        <ul class="filter-up filter-time">
                                                            <li>
                                                                <div>
                                                                    <input type="checkbox" class="custom-checkbox" id="1" name="time[]" value="1">
                                                                    <label for="1">Полный рабочий день</label>
                                                                </div>
                                                                <span></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input type="checkbox" class="custom-checkbox" id="2" name="time[]" value="2">
                                                                    <label for="2">Гибкий график</label>
                                                                </div>
                                                                <span></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input type="checkbox" class="custom-checkbox" id="3" name="time[]" value="3">
                                                                    <label for="3">Сменный график</label>
                                                                </div>
                                                                <span></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input type="checkbox" class="custom-checkbox" id="4" name="time[]" value="4">
                                                                    <label for="4">Ненормированный рабочий день</label>
                                                                </div>
                                                                <span></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input type="checkbox" class="custom-checkbox" id="5" name="time[]" value="5">
                                                                    <label for="5">Вахтовый метод</label>
                                                                </div>
                                                                <span></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input type="checkbox" class="custom-checkbox" id="6" name="time[]" value="6">
                                                                    <label for="6">Неполный рабочий день</label>
                                                                </div>
                                                                <span></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="filter-layout salary">
                                                <div class="fl-title">Тип занятости <i class="fa-solid fa-chevron-up"></i> </div>
                                                <div class="filter-block-pop">
                                                    <div class="filter-ul">
                                                        <ul class="filter-up filter-type">
                                                            <li>
                                                                <div>
                                                                    <input type="checkbox" class="custom-checkbox" id="7" name="type[]" value="1">
                                                                    <label for="7">Полная занятость</label>
                                                                </div>
                                                                <span></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input type="checkbox" class="custom-checkbox" id="8" name="type[]" value="2">
                                                                    <label for="8">Частичная занятость</label>
                                                                </div>
                                                                <span></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input type="checkbox" class="custom-checkbox" id="9" name="type[]" value="3">
                                                                    <label for="9">Временная работа</label>
                                                                </div>
                                                                <span></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input type="checkbox" class="custom-checkbox" id="10" name="type[]" value="4">
                                                                    <label for="10">Стажировка</label>
                                                                </div>
                                                                <span></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input type="checkbox" class="custom-checkbox" id="11" name="type[]" value="5">
                                                                    <label for="11">Сезонная работа</label>
                                                                </div>
                                                                <span></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input type="checkbox" class="custom-checkbox" id="12" name="type[]" value="6">
                                                                    <label for="12">Удаленная работа</label>
                                                                </div>
                                                                <span></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="filter-layout salary">
                                                <div class="fl-title">Дополнительно <i class="fa-solid fa-chevron-up"></i> </div>
                                                <div class="filter-block-pop">
                                                    <div class="filter-ul">
                                                        <ul class="filter-up filter-more" style="padding: 0 10px 0 0">
                                                            <li>
                                                                <div>
                                                                    <input type="checkbox" class="custom-checkbox" id="q101" name="more1" value="1">
                                                                    <label for="q101">Помогут с переездом</label>
                                                                </div>
                                                                <span></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input type="checkbox" class="custom-checkbox" id="q102" name="more2" value="1">
                                                                    <label for="q102">Только с адресом</label>
                                                                </div>
                                                                <span></span>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <input type="checkbox" class="custom-checkbox" id="q103" name="more3" value="1">
                                                                    <label for="q103">	Только доступные для людей с инвалидностью</label>
                                                                </div>
                                                                <span></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="filter-ul">
                                                        <ul class="fl-none">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </form>

                                </div>


                        </div>


                    </div>









                </div>
            </div>
        </section>

    </main>

    <?php require('template/more/profileFooter.php'); ?>

    <script language="JavaScript" src="/static/scripts/catalogSave.js?v=<?= date('YmdHis') ?>"></script>

    <?php

    if (isset($_SESSION['id']) && isset($_SESSION['password']) && $_SESSION['type'] == 'users') {

        ?>

        <script>

            function removeJob(id) {

                $.ajax({
                    url: '/scripts/profile-js',
                    data: `id=${Number(id)}&MODULE_UNMARK_J0B=1`,
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    error: (response) => console.log(response),
                    success: function (responce) {
                        if (responce.code === 'success') {
                            $(`.new-block-${id}`).remove()
                            $('.manage-title').html(`Найдено ${responce.count} вакансий`)
                        } else {
                            console.log(responce)
                        }
                    }
                })
            }


        </script>


        <?php
    }


    ?>


    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>