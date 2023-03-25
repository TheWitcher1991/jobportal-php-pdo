<?php

$id = (int) $_GET['id'];

$c = $app->fetch("SELECT * FROM `category` WHERE `id` = :id", [':id' => $id]);

if (empty($c['id'])) {
    $app->notFound();
}

Head('Категория - ' . $c['name']);

?>
<body>

<?php require('template/base/nav.php'); ?>

<header id="header-search">
    <?php require('template/base/navblock.php'); ?>
    <div class="header-search-container">
        <div class="container">

            <div class="hs-container">
                <span class="hs-h">Свежие вакансии</span>
                <div class="header-input-container">
                    <div class="hi-field">
                        <i class="mdi mdi-magnify"></i>
                        <input class="hi-title" type="text" placeholder="Должность или ключевое слово">
                    </div>
                    <div class="hi-field">
                        <i class="mdi mdi-crosshairs-gps"></i>
                        <input class="hi-location" type="text" placeholder="Город">
                    </div>
                    <input type="submit" class="hs-bth" value="Найти">
                </div>
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
                <span><a href="/job-list">Каталог вакансий</a></span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span><? echo $c['name']; ?></span>
            </div>
            <?php
                        $sqlc = "SELECT * FROM `vacancy` WHERE `category` = :n";
                        $stmtc = $PDO->prepare($sqlc);
                        $stmtc->bindValue(':n', $c['name']);
                        $stmtc->execute();
            ?>

            <div class="section-header">
                <span><div class="placeholder-item jx-title"></div></span>
            </div>
            <div class="seach-block">
                <div class="section-items">

                    <?php
                    if (!isset($_SESSION['id'], $_SESSION['password'])) {
                        ?>
                        <div class="section-no-info">
                            <div class="sn-left">
                                <i class="mdi mdi-lock-outline"></i>
                                <div>
                                    <span>Больше информации по вакансии будет доступно после регистрации</span>
                                    <p>После регистрации откроем контактные данные и возможность отклика</p>
                                </div>
                            </div>
                            <a href="/create/user">Зарегистрироваться</a>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="filter-block-bth">
                        <div class="all-filt">
                            <form method="GET" role="POST">
                                <div class="sort-block">
                                    <select class="sort-select" name="sorted" id="sort_job">
                                        <option value="1">По убыванию зарплат</option>
                                        <option value="2">По возрастанию зарплаты</option>
                                        <option selected value="3">По дате</option>
                                    </select>
                                    <div>
                                        <i class="mdi mdi-chevron-down"></i>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <ul class="vac-list-ul">
                        <div id="placeholder-main">
                            <div class="placeholder">
                                <div style="width: 100%;">
                                    <div class="placeholder-item jx-nav"></div>
                                    <div class="placeholder-item jx-title"></div>
                                    <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                    <div class="mx-flex" style="margin: 0;">
                                        <div class="placeholder-item mx-flit"></div>
                                        <div class="placeholder-item mx-flit"></div>
                                        <div class="placeholder-item mx-flit"></div>
                                    </div>
                                    <div  style="margin: 16px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                    <div class="placeholder-flex" style="margin: 20px 0 0 0;">
                                        <div>
                                            <div class="placeholder-item jx-little-2">

                                            </div>
                                            <div class="placeholder-item jx-little-3" style="margin: 6px 0 0 0;">

                                            </div>
                                        </div>
                                        <div class="placeholder-item jx-img"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="placeholder">
                                <div style="width: 100%;">
                                    <div class="placeholder-item jx-nav"></div>
                                    <div class="placeholder-item jx-title"></div>
                                    <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                    <div class="mx-flex" style="margin: 0;">
                                        <div class="placeholder-item mx-flit"></div>
                                        <div class="placeholder-item mx-flit"></div>
                                        <div class="placeholder-item mx-flit"></div>
                                    </div>
                                    <div  style="margin: 16px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                    <div class="placeholder-flex" style="margin: 20px 0 0 0;">
                                        <div>
                                            <div class="placeholder-item jx-little-2">

                                            </div>
                                            <div class="placeholder-item jx-little-3" style="margin: 6px 0 0 0;">

                                            </div>
                                        </div>
                                        <div class="placeholder-item jx-img"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="placeholder">
                                <div style="width: 100%;">
                                    <div class="placeholder-item jx-nav"></div>
                                    <div class="placeholder-item jx-title"></div>
                                    <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                    <div class="mx-flex" style="margin: 0;">
                                        <div class="placeholder-item mx-flit"></div>
                                        <div class="placeholder-item mx-flit"></div>
                                        <div class="placeholder-item mx-flit"></div>
                                    </div>
                                    <div  style="margin: 16px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                    <div class="placeholder-flex" style="margin: 20px 0 0 0;">
                                        <div>
                                            <div class="placeholder-item jx-little-2">

                                            </div>
                                            <div class="placeholder-item jx-little-3" style="margin: 6px 0 0 0;">

                                            </div>
                                        </div>
                                        <div class="placeholder-item jx-img"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="placeholder">
                                <div style="width: 100%;">
                                    <div class="placeholder-item jx-nav"></div>
                                    <div class="placeholder-item jx-title"></div>
                                    <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                    <div class="mx-flex" style="margin: 0;">
                                        <div class="placeholder-item mx-flit"></div>
                                        <div class="placeholder-item mx-flit"></div>
                                        <div class="placeholder-item mx-flit"></div>
                                    </div>
                                    <div  style="margin: 16px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                    <div class="placeholder-flex" style="margin: 20px 0 0 0;">
                                        <div>
                                            <div class="placeholder-item jx-little-2">

                                            </div>
                                            <div class="placeholder-item jx-little-3" style="margin: 6px 0 0 0;">

                                            </div>
                                        </div>
                                        <div class="placeholder-item jx-img"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="placeholder">
                                <div style="width: 100%;">
                                    <div class="placeholder-item jx-nav"></div>
                                    <div class="placeholder-item jx-title"></div>
                                    <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                    <div class="mx-flex" style="margin: 0;">
                                        <div class="placeholder-item mx-flit"></div>
                                        <div class="placeholder-item mx-flit"></div>
                                        <div class="placeholder-item mx-flit"></div>
                                    </div>
                                    <div  style="margin: 16px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                    <div class="placeholder-flex" style="margin: 20px 0 0 0;">
                                        <div>
                                            <div class="placeholder-item jx-little-2">

                                            </div>
                                            <div class="placeholder-item jx-little-3" style="margin: 6px 0 0 0;">

                                            </div>
                                        </div>
                                        <div class="placeholder-item jx-img"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="placeholder">
                                <div style="width: 100%;">
                                    <div class="placeholder-item jx-nav"></div>
                                    <div class="placeholder-item jx-title"></div>
                                    <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                    <div class="mx-flex" style="margin: 0;">
                                        <div class="placeholder-item mx-flit"></div>
                                        <div class="placeholder-item mx-flit"></div>
                                        <div class="placeholder-item mx-flit"></div>
                                    </div>
                                    <div  style="margin: 16px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                    <div class="placeholder-flex" style="margin: 20px 0 0 0;">
                                        <div>
                                            <div class="placeholder-item jx-little-2">

                                            </div>
                                            <div class="placeholder-item jx-little-3" style="margin: 6px 0 0 0;">

                                            </div>
                                        </div>
                                        <div class="placeholder-item jx-img"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="placeholder">
                                <div style="width: 100%;">
                                    <div class="placeholder-item jx-nav"></div>
                                    <div class="placeholder-item jx-title"></div>
                                    <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                    <div class="mx-flex" style="margin: 0;">
                                        <div class="placeholder-item mx-flit"></div>
                                        <div class="placeholder-item mx-flit"></div>
                                        <div class="placeholder-item mx-flit"></div>
                                    </div>
                                    <div  style="margin: 16px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                    <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                    <div class="placeholder-flex" style="margin: 20px 0 0 0;">
                                        <div>
                                            <div class="placeholder-item jx-little-2">

                                            </div>
                                            <div class="placeholder-item jx-little-3" style="margin: 6px 0 0 0;">

                                            </div>
                                        </div>
                                        <div class="placeholder-item jx-img"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ul>

                    <div class="paginator">

                    </div>
                </div>

                <div class="c-search-block">

                    <div class="filter-title">
                        Фильтры <i class="mdi mdi-close"></i>
                    </div>

                    <form role="form" class="form-job" method="GET">


                        <div class="filter-main filter-job">
                            <div class="filter-load">

                            </div>

                            <div class="filter-bth-wrap">
                                <button class="filter-bth-none" type="button">Загрузка...</button>
                            </div>


                            <?

                            $hash_filter = md5(random_str(10) . time());

                            $_SESSION["job-$hash_filter"] = $hash_filter;

                            ?>

                            <input style="display: none" name="token" type="text" id="" value="<? echo $hash_filter; ?>">

                            <!--<div class="all-filter-bth">Расширенный поиск</div>-->
                            <?php
                            $locs = $app->fetch("SELECT * FROM `map_list` WHERE `code` = :n", [':n' => $_GET['loc']]);
                            if ($locs['id']) {

                                ?>
                                <div class="filter-layout area">
                                    <div class="fl-title">Регионы <i class="fa-solid fa-chevron-up"></i> </div>
                                    <div class="filter-block-pop">
                                        <div class="filter-ul">
                                            <ul class="filter-up filter-area">

                                                <li class="active-filters">
                                                    <div>
                                                        <input checked type="checkbox" class="custom-checkbox" id="id=<? echo $locs['name']; ?>" name="area[]" value="<? echo $locs['id']; ?>">
                                                        <label for="id=<? echo $locs['name']; ?>"><? echo $locs['name']; ?></label>
                                                    </div>
                                                    <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `address` LIKE '%$locs[name]%' OR `region` LIKE '%$locs[name]%'"); ?></span>
                                                </li>




                                                <!--<?php



                                                $sql = $app->query('SELECT `address`, `id` FROM `vacancy` WHERE `status` = 0 GROUP BY `address` ORDER BY count(*) DESC LIMIT 6');
                                                while ($r = $sql->fetch()) {
                                                    $ad = $app->fetch("SELECT * FROM `map_list` WHERE `name` = :n", [':n' => $r['address']])
                                                    ?>
                                                <li>
                                                    <div>
                                                        <input type="checkbox" class="custom-checkbox" id="id=<? echo $r['id']; ?>" name="area[]" value="<? echo $ad['id']; ?>">
                                                        <label for="id=<? echo $r['id']; ?>"><? echo $r['address']; ?></label>
                                                    </div>
                                                    <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `address` LIKE '%$r[address]%' AND `status` = 0"); ?></span>
                                                </li>

                                            <?php } ?>-->

                                            </ul>


                                        </div>
                                        <!--<div class="fl-bth">
                                        Ещё <?php echo $app->count('SELECT `address` FROM `vacancy` WHERE `status` = 0 AND `status` = 0 GROUP BY `address`') - 6  ?>
                                    </div>-->
                                    </div>
                                </div>
                                <?php

                            }

                            ?>

                            <div class="filter-layout category">
                                <div class="fl-title">Отрасль <i class="fa-solid fa-chevron-up"></i> </div>
                                <div class="filter-block-pop">
                                    <div class="filter-ul">
                                        <? $ra = $app->fetch("SELECT * FROM `category` WHERE `id` = :id", [':id' => $_GET['id']]); ?>
                                        <ul class="filter-up filter-category">
                                            <li>
                                                <div>
                                                    <input checked type="radio" class="custom-radio" id="<? echo $ra['id'] + 300; ?>" name="category_only" value="<? echo $ra['id']; ?>">
                                                    <label for="<? echo $ra['id'] + 300; ?>"><? echo $ra['name']; ?></label>
                                                </div>
                                                <span><? echo $ra['job']; ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="filter-ul">
                                        <ul class="fl-none">
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="filter-layout salary">
                                <div class="fl-title">Зарплата <i class="fa-solid fa-chevron-up"></i> </div>
                                <div class="filter-block-pop">
                                    <div class="filter-ul">
                                        <ul class="filter-up filter-salary">
                                            <li>
                                                <div>
                                                    <input class="custom-radio" checked name="salary_me" type="radio" id="q104" value="1">
                                                    <label for="q104">Не важно</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="salary_me" type="radio" id="q304" value="2">
                                                    <label for="q304">По договорённости</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `salary` = '' AND `salary_end` = ''"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="salary_me" type="radio" id="q305" value="3">
                                                    <label for="q305">Своя</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="filter-input">
                                                    <span>от</span>
                                                    <input type="number" disabled class="salaryTo" name="salaryTo">
                                                    <span>до</span>
                                                    <input type="number" disabled class="salaryFrom" name="salaryFrom">
                                                    <span>руб.</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="filter-layout salary">
                                <div class="fl-title">Опыт работы<i class="fa-solid fa-chevron-up"></i> </div>
                                <div class="filter-block-pop">
                                    <div class="filter-ul">
                                        <ul class="filter-up filter-exp">
                                            <li>
                                                <div>
                                                    <input class="custom-radio" checked name="exp" type="radio" id="99" value="0">
                                                    <label for="99">Не важно</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="exp" type="radio" id="100" value="1">
                                                    <label for="100">Без опыта</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `exp` = 'Без опыта' AND `status` = 0"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="exp" type="radio" id="101" value="2">
                                                    <label for="101">1-3 года</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `exp` = '1-3 года' AND `status` = 0"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="exp" type="radio" id="102" value="3">
                                                    <label for="102">3-6 лет</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `exp` = '3-6 лет' AND `status` = 0"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="exp" type="radio" id="103" value="4">
                                                    <label for="103">Более 6 лет</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `exp` = 'Более 6 лет' AND `status` = 0"); ?></span>
                                            </li>

                                            <!--<li><a href="">Более 6 лет</a> <span>< echo $app->count("SELECT * FROM `vacancy` WHERE `exp` = 'Более 6 лет'"); ></span></li>-->
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
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `time` = 'Полный рабочий день' AND `status` = 0"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="2" name="time[]" value="2">
                                                    <label for="2">Гибкий график</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `time` = 'Гибкий график' AND `status` = 0"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="3" name="time[]" value="3">
                                                    <label for="3">Сменный график</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `time` = 'Сменный график' AND `status` = 0"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="4" name="time[]" value="4">
                                                    <label for="4">Ненормированный рабочий день</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `time` = 'Ненормированный рабочий день' AND `status` = 0"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="5" name="time[]" value="5">
                                                    <label for="5">Вахтовый метод</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `time` = 'Вахтовый метод' AND `status` = 0"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="6" name="time[]" value="6">
                                                    <label for="6">Неполный рабочий день</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `time` = 'Неполный рабочий день' AND `status` = 0"); ?></span>
                                            </li>
                                            <!--<li><a href="">Неполный рабочий день</a> <span>< echo $app->count("SELECT * FROM `vacancy` WHERE `time` = 'Неполный рабочий день'"); ></span></li>-->
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
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `type` = 'Полная занятость' AND `status` = 0"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="8" name="type[]" value="2">
                                                    <label for="8">Частичная занятость</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `type` = 'Частичная занятость' AND `status` = 0"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="9" name="type[]" value="3">
                                                    <label for="9">Временная работа</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `type` = 'Временная' AND `status` = 0"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="10" name="type[]" value="4">
                                                    <label for="10">Стажировка</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `type` = 'Стажировка' AND `status` = 0"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="11" name="type[]" value="5">
                                                    <label for="11">Сезонная работа</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `type` = 'Сезонная' AND `status` = 0"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="12" name="type[]" value="6">
                                                    <label for="12">Удаленная работа</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `type` = 'Удаленная' AND `status` = 0"); ?></span>
                                            </li>
                                            <!--<li><a href="">Удаленная работа</a> <span>< echo $app->count("SELECT * FROM `vacancy` WHERE `type` = 'Удаленная'"); ></span></li>-->
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="filter-layout salary">
                                <div class="fl-title">Компании <i class="fa-solid fa-chevron-up"></i> </div>
                                <div class="filter-block-pop">
                                    <div class="filter-ul">
                                        <ul class="filter-up filter-company" style="padding: 0 10px 0 0">
                                            <?php
                                            $sql = $app->query('SELECT * FROM `company` ORDER BY `job` DESC');
                                            while ($r = $sql->fetch()) {
                                                ?>
                                                <li>
                                                    <div>
                                                        <input type="checkbox" class="custom-checkbox" id="c<?php echo $r['id'] ?>" name="company[]" value="<?php echo $r['id'] ?>">
                                                        <label for="c<?php echo $r['id'] ?>"><?php echo $r['name'] ?></label>
                                                    </div>
                                                    <span><?php echo $r['job'] ?></span>
                                                </li>

                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <div class="filter-ul">
                                        <ul class="fl-none">
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
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `go` = 1 AND `status` = 0"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="q102" name="more2" value="1">
                                                    <label for="q102">Только с адресом</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `urid` != '' AND `status` = 0"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="q103" name="more3" value="1">
                                                    <label for="q103">	Только доступные для людей с инвалидностью</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `invalid` = 1 AND `status` = 0"); ?></span>
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
    </section>

</main>

<?php require('template/base/footer.php'); ?>

<script language="JavaScript" src="/static/scripts/catalogJob.js?v=<?= date('YmdHis') ?>"></script>

</body>
</html>