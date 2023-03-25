<?php

if (isset($_POST["resume-search"]) and (isset($_POST["s_key"]))) {

    if ($_POST["s_key"] != '') {
        exit(header('location: /resume-list?key=' . $_POST['s_key']));
    }

}



Head('Каталог резюме');


?>
<body>

<?php require('template/base/nav.php'); ?>

<header id="header-search">
    <?php require('template/base/navblock.php'); ?>
    <div class="header-search-container">
        <div class="container">

                <span class="hs-h">Свежие резюме</span>
                <div class="header-input-container">
                    <div class="hi-field" style="width: 100%;border: 0">
                        <i class="mdi mdi-magnify"></i>
                        <input class="hi-title" type="text" name="s_key" placeholder="Должность или ключевое слово">
                    </div>
                    <input type="button" class="hs-bth" name="resume-search" value="Найти">
                </div>

        </div>
    </div>
</header>

<div class="filter-up-bth">
    <span>
        <i class="mdi mdi-tune"></i> фильтры
    </span>

</div>

<main id="wrapper" class="wrapper">

    <section class="job-list-section">
        <div class="container">
            <div class="section-nav">
                <span><a href="/">Главная</a></span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span>Работодателям</span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span>Каталог резюме</span>
            </div>

            <div class="section-header">

                <span><div class="placeholder-item jx-title"></div></span>


            </div>

            <div class="seach-block">

                <?php

                    $results_per_page = 25;

                    $number_of_results = (int)$app->count("SELECT * FROM `users`");

                    $number_of_pages = ceil($number_of_results / $results_per_page);

                    if (!isset($_GET['page'])) {
                        $pag = 1;
                    } else {
                        $pag = $_GET['page'];
                    }

                    $this_page_first_result = ($pag - 1) * $results_per_page;

                    ?>


                    <div class="content-items">

                        <?php
                        if (!isset($_SESSION['id'], $_SESSION['password'])) {
                            ?>
                            <div class="section-no-info">
                                <div class="sn-left">
                                    <i class="mdi mdi-lock-outline"></i>
                                    <div>
                                        <span>Больше информации по резюме будет доступно после регистрации</span>
                                        <p>После регистрации откроем фото и контактные данные</p>
                                    </div>
                                </div>
                                <a href="/create/employers">Зарегистрироваться</a>
                            </div>
                            <?php
                        }
                        ?>

                        <div class="filter-block-bth">
                            <div class="all-filt">
                                <form method="GET" role="POST">
                                    <div class="sort-block">
                                        <select class="sort-select" name="sorted" id="sort_resume">
                                            <option value="1">По убыванию зарплат</option>
                                            <option value="2">По возрастанию зарплаты</option>
                                            <option selected value="3">По дате</option>
                                        </select>
                                        <div>
                                            <i class="mdi mdi-chevron-down"></i>
                                        </div>
                                    </div>
                                    <div class="sort-block">
                                        <select class="sort-select" name="sort_faculty" id="sort_faculty">
                                            <option value="" selected>Любой факультет</option>
                                            <option value="1">Факультет агробиологии и земельных ресурсов</option>
                                            <option value="2">Факультет экологии и ландшафтной архитектуры</option>
                                            <option value="3">Экономический факультет</option>
                                            <option value="4">Инженерно-технологический факультет</option>
                                            <option value="5">Биотехнологический факультет</option>
                                            <option value="6">Факультет социально-культурного сервиса и туризма</option>
                                            <option value="7">Электроэнергетический факультет</option>
                                            <option value="8">Учетно-финансовый факультет</option>
                                            <option value="9">Факультет ветеринарной медицины</option>
                                            <option value="10">Факультет среднего профессионального образования</option>
                                        </select>
                                        <div>
                                            <i class="mdi mdi-chevron-down"></i>
                                        </div>
                                    </div>
                                </form>
                                <!--<a href="/resume-list" class="fb-active">соответствию</a>
                                <a href="/resume-list/?sort=salary">зарплате</a>-->
                            </div>
                        </div>

                        <ul class="resume-list-ul">
                            <div id="placeholder-main">
                                <div class="placeholder">
                                    <div class="pr-flex">
                                        <div class="placeholder-item pr-img"></div>
                                        <div>
                                            <div class="placeholder-item pr-little-1"></div>
                                            <div class="placeholder-item pr-little-2"></div>
                                            <div class="placeholder-item pr-little-3"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-item pr-stat"></div>
                                    <div  style="margin: 6px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                    <div class="placeholder-item pr-middle"></div>
                                </div>
                                <div class="placeholder">
                                    <div class="pr-flex">
                                        <div class="placeholder-item pr-img"></div>
                                        <div>
                                            <div class="placeholder-item pr-little-1"></div>
                                            <div class="placeholder-item pr-little-2"></div>
                                            <div class="placeholder-item pr-little-3"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-item pr-stat"></div>
                                    <div  style="margin: 6px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                    <div class="placeholder-item pr-middle"></div>
                                </div>
                                <div class="placeholder">
                                    <div class="pr-flex">
                                        <div class="placeholder-item pr-img"></div>
                                        <div>
                                            <div class="placeholder-item pr-little-1"></div>
                                            <div class="placeholder-item pr-little-2"></div>
                                            <div class="placeholder-item pr-little-3"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-item pr-stat"></div>
                                    <div  style="margin: 6px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                    <div class="placeholder-item pr-middle"></div>
                                </div>
                                <div class="placeholder">
                                    <div class="pr-flex">
                                        <div class="placeholder-item pr-img"></div>
                                        <div>
                                            <div class="placeholder-item pr-little-1"></div>
                                            <div class="placeholder-item pr-little-2"></div>
                                            <div class="placeholder-item pr-little-3"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-item pr-stat"></div>
                                    <div  style="margin: 6px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                    <div class="placeholder-item pr-middle"></div>
                                </div><div class="placeholder">
                                    <div class="pr-flex">
                                        <div class="placeholder-item pr-img"></div>
                                        <div>
                                            <div class="placeholder-item pr-little-1"></div>
                                            <div class="placeholder-item pr-little-2"></div>
                                            <div class="placeholder-item pr-little-3"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-item pr-stat"></div>
                                    <div  style="margin: 6px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                    <div class="placeholder-item pr-middle"></div>
                                </div><div class="placeholder">
                                    <div class="pr-flex">
                                        <div class="placeholder-item pr-img"></div>
                                        <div>
                                            <div class="placeholder-item pr-little-1"></div>
                                            <div class="placeholder-item pr-little-2"></div>
                                            <div class="placeholder-item pr-little-3"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-item pr-stat"></div>
                                    <div  style="margin: 6px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                    <div class="placeholder-item pr-middle"></div>
                                </div>
                                <div class="placeholder">
                                    <div class="pr-flex">
                                        <div class="placeholder-item pr-img"></div>
                                        <div>
                                            <div class="placeholder-item pr-little-1"></div>
                                            <div class="placeholder-item pr-little-2"></div>
                                            <div class="placeholder-item pr-little-3"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-item pr-stat"></div>
                                    <div  style="margin: 6px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                    <div class="placeholder-item pr-middle"></div>
                                </div>
                                <div class="placeholder">
                                    <div class="pr-flex">
                                        <div class="placeholder-item pr-img"></div>
                                        <div>
                                            <div class="placeholder-item pr-little-1"></div>
                                            <div class="placeholder-item pr-little-2"></div>
                                            <div class="placeholder-item pr-little-3"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-item pr-stat"></div>
                                    <div  style="margin: 6px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                    <div class="placeholder-item pr-middle"></div>
                                </div>
                            </div>
                        </ul>

                        <div class="paginator">
                            <?php

                            for ($pag = 1; $pag <= $number_of_pages; $pag++) {

                                if ($number_of_pages == 1) {
                                    echo '<a class="page-active" style="border-radius:4px" href="/resume-list?page=' . $pag . '">' . $pag . '</a> ';
                                } elseif (!isset($_GET['page']) && $pag == 1) {
                                    echo '<a class="page-active" href="/resume-list?page=' . $pag . '">' . $pag . '</a> ';
                                } elseif ((int)$_GET['page'] == $pag) {
                                    echo '<a class="page-active" href="/resume-list?page=' . $pag . '">' . $pag . '</a> ';
                                } else {
                                    echo '<a href="/resume-list?page=' . $pag . '">' . $pag . '</a> ';
                                }
                            }

                            ?>
                        </div>
                    </div>


                <div class="c-search-block">

                    <div class="filter-title">
                        Фильтры <i class="mdi mdi-close"></i>
                    </div>

                    <form role="form" class="form-resume form-filter" method="GET">

                        <div class="filter-main filter-resume">
                            <!--<div class="all-filter-bth">Расширенный поиск</div>-->

                            <div class="filter-load">

                            </div>

                            <div class="filter-bth-wrap">
                                <button class="filter-bth-none" type="button">Загрузка...</button>
                            </div>

                            <?

                            $hash_filter = md5(random_str(10) . time());

                            $_SESSION["resume-$hash_filter"] = $hash_filter;

                            ?>

                            <input style="display: none" name="token" type="text" id="" value="<? echo $hash_filter; ?>">

                            <div class="filter-layout salary">
                                <div class="fl-title">Зарплата <i class="fa-solid fa-chevron-up"></i> </div>
                                <div class="filter-block-pop">
                                    <div class="filter-ul">
                                        <ul class="filter-up filter-salary">
                                            <li>
                                                <div>
                                                    <input class="custom-radio" checked name="salary" type="radio" id="1" value="-1">
                                                    <label for="1">Не важно</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="salary" type="radio" id="2" value="">
                                                    <label for="2">По договорённости</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `salary` = ''"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="salary" type="radio" id="3" value="15000">
                                                    <label for="3">до 15 000 руб.</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `salary` <= 15000 AND `salary` != ''"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="salary" type="radio" id="4" value="25000">
                                                    <label for="4">до 25 000 руб.</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `salary` <= 25000 AND `salary` != ''"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="salary" type="radio" id="5" value="45000">
                                                    <label for="5">до 45 000 руб.</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `salary` <= 45000 AND `salary` != ''"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="salary" type="radio" id="6" value="85000">
                                                    <label for="6">до 85 000 руб.</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `salary` <= 85000 AND `salary` != ''"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="salary" type="radio" id="7" value="100000">
                                                    <label for="7">до 100 000 руб.</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `salary` <= 100000 AND `salary` != ''"); ?></span>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="filter-ul">
                                        <ul class="fl-none">
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="salary" type="radio" id="8" value="200000">
                                                    <label for="8">до 200 000 руб.</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `salary` < 200000"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="salary" type="radio" id="8" value="300000">
                                                    <label for="8">до 300 000 руб.</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `salary` < 300000"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="salary" type="radio" id="9" value="400000">
                                                    <label for="9">до 400 000 руб.</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `salary` < 400000"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="salary" type="radio" id="10" value="500000">
                                                    <label for="10">до 500 000 руб.</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `salary` < 500000"); ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--<div class="fl-bth">
                                        Ещё 5
                                    </div>-->
                                </div>
                            </div>

                            <div class="filter-layout salary">
                                <div class="fl-title">Опыт <i class="fa-solid fa-chevron-up"></i> </div>
                                <div class="filter-block-pop">
                                    <div class="filter-ul">
                                        <ul class="filter-up filter-exp">
                                            <li>
                                                <div>
                                                    <input class="custom-checkbox" name="exp[]" type="checkbox" id="11" value="1">
                                                    <label for="11">Без опыта</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `exp` = 'Без опыта'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-checkbox" name="exp[]" type="checkbox" id="12" value="2">
                                                    <label for="12">1-3 года</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `exp` = '1-3 года'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-checkbox" name="exp[]" type="checkbox" id="13" value="3">
                                                    <label for="13">3-6 лет</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `exp` = '3-6 лет'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-checkbox" name="exp[]" type="checkbox" id="14" value="4">
                                                    <label for="14">Более 6 лет</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `exp` = 'Более 6 лет'"); ?></span>
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
                                                    <input type="checkbox" class="custom-checkbox" id="15" name="time[]" value="1">
                                                    <label for="15">Полный рабочий день</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `time` LIKE '%Полный рабочий день%'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="16" name="time[]" value="2">
                                                    <label for="16">Гибкий график</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `time` LIKE '%Гибкий график%'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="17" name="time[]" value="3">
                                                    <label for="17">Сменный график</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `time` LIKE '%Сменный график%'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="18" name="time[]" value="4">
                                                    <label for="18">Ненормированный рабочий день</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `time` LIKE '%Ненормированный рабочий день%'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="19" name="time[]" value="5">
                                                    <label for="19">Вахтовый метод</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `time` LIKE '%Вахтовый метод%'"); ?></span>
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
                                                    <input type="checkbox" class="custom-checkbox" id="21" name="type[]" value="1">
                                                    <label for="21">Полная занятость</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `type` LIKE '%Полная занятость%'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="22" name="type[]" value="2">
                                                    <label for="22">Частичная занятость</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `type` LIKE '%Частичная занятость%'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="23" name="type[]" value="3">
                                                    <label for="23">Проектная работа</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `type` LIKE '%Проектная работа%'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="24" name="type[]" value="4">
                                                    <label for="24">Стажировка</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `type` LIKE '%Стажировка%'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="25" name="type[]" value="5">
                                                    <label for="25">Удаленная работа</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `type` LIKE '%Удаленная работа%'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="26" name="type[]" value="6">
                                                    <label for="26">Волонтерство</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `type` LIKE '%Волонтерство%'"); ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="filter-layout salary">
                                <div class="fl-title">Образование <i class="fa-solid fa-chevron-up"></i> </div>
                                <div class="filter-block-pop">
                                    <div class="filter-ul">
                                        <ul class="filter-up filter-degree">
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="27" name="degree[]" value="1">
                                                    <label for="27">Среднее профессиональное</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `degree` = 'Среднее профессиональное'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="28" name="degree[]" value="2">
                                                    <label for="28">Высшее (Бакалавриат)</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `degree` = 'Высшее (Бакалавриат)'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="29" name="degree[]" value="3">
                                                    <label for="29">Высшее (Специалитет)</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `degree` = 'Высшее (Специалитет)'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="30" name="degree[]" value="4">
                                                    <label for="30">Высшее (Магистратура)</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `degree` = 'Высшее (Магистратура)'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="31" name="degree[]" value="5">
                                                    <label for="31">Высшее (Аспирантура)</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `degree` = 'Высшее (Аспирантура)'"); ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!--<div class="filter-layout salary">
                                <div class="fl-title">Возраст <i class="fa-solid fa-chevron-up"></i> </div>
                                <div class="filter-block-pop">
                                    <div class="filter-ul">
                                        <ul class="filter-up filter-age">
                                            <li>
                                                <div class="filter-input">
                                                    <span>от</span>
                                                    <input min="1" max="100" type="age" class="age-to" name="ageTo">
                                                    <span>до</span>
                                                    <input min="1" max="100" type="age" class="age-from" name="ageFrom">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>-->

                            <div class="filter-layout salary">
                                <div class="fl-title">Пол <i class="fa-solid fa-chevron-up"></i> </div>
                                <div class="filter-block-pop">
                                    <div class="filter-ul">
                                        <ul class="filter-up filter-gender">
                                            <li>
                                                <div>
                                                    <input checked class="custom-radio" name="gender" type="radio" id="32" value="">
                                                    <label for="32">Не важно</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="gender" type="radio" id="33" value="1">
                                                    <label for="33">Мужчина</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `gender` = 'Мужчина' OR `gender` = 'Мужской'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="gender" type="radio" id="34" value="2">
                                                    <label for="34">Женщина</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `gender` = 'Женщина' OR `gender` = 'Женский'"); ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-layout salary">
                                <div class="fl-title">Категория прав <i class="fa-solid fa-chevron-up"></i> </div>
                                <div class="filter-block-pop">
                                    <div class="filter-ul">
                                        <ul class="filter-up filter-drive">
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="35" name="drive[]" value="1">
                                                    <label for="35">A</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `drive` = 'A'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="36" name="drive[]" value="2">
                                                    <label for="36">B</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `drive` = 'B'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="37" name="drive[]" value="3">
                                                    <label for="37">C</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `drive` = 'C'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="38" name="drive[]" value="4">
                                                    <label for="38">D</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `drive` = 'D'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="39" name="drive[]" value="5">
                                                    <label for="39">E</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `users` WHERE `drive` = 'E'"); ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

</main>

<?php require('template/base/footer.php'); ?>

<script language="JavaScript" src="/static/scripts/catalogResume.js?v=<?= date('YmdHis') ?>"></script>


</body>
</html>