<?php

if (isset($_POST["company-search"]) and (isset($_POST["c_key"]) or isset($_POST["c_loc"]))) {

    if ($_POST["c_key"] != '' and $_POST["c_loc"] != '') {
        exit(header('location: /company-list?key=' . $_POST['c_key'] . '&loc=' . $_POST["c_loc"]));
    }

    if (empty($_POST["c_key"]) and $_POST["c_loc"] != '') {
        exit(header('location: /company-list?loc=' . $_POST["c_loc"]));
    }

    if ($_POST["c_key"] != '' and empty($_POST["c_loc"])) {
        exit(header('location: /company-list?key=' . $_POST['c_key']));
    }
}

if (isset($_POST['filter'])) {
    global $sql_s;
    $where = "";
    if ($_POST['name']) $where = addWhere($where, "`name` LIKE '%$_POST[name]%'");
    if ($_POST['address']) $where = addWhere($where, "`address` LIKE '%$_POST[address]%'");
    if ($_POST['specialty']) $where = addWhere($where, "`specialty` LIKE '%$_POST[specialty]%'");
    if ($_POST['people']) $where = addWhere($where, "`people` LIKE '%$_POST[people]%'");
    if ($_POST['type']) $where = addWhere($where, "`type` LIKE '%$_POST[type]%'");
    if ($_POST['non-job']) $where = addWhere($where, '`job` > 0');
    $sql_s = "SELECT * FROM `company`";
    if ($where) $sql_s .= " WHERE $where";
    echo $sql_s;
}

if (isset($_GET['key']) and isset($_GET['loc'])) {
    global $sql_s;
    $sql_s = "SELECT * FROM `company` WHERE (`name` LIKE '%$_GET[key]%' OR `about` LIKE '%$_GET[key]%'
            OR `specialty` LIKE '%$_GET[key]%' OR `middle` LIKE '%$_GET[key]%' OR `people` LIKE '%$_GET[key]%') AND `address` LIKE '%$_GET[loc]%' ORDER BY `id` DESC";
} elseif (!isset($_GET['key']) and isset($_GET['loc'])) {
    global $sql_s;
    $sql_s = "SELECT * FROM `company` WHERE `address` LIKE '%$_GET[loc]%' ORDER BY `id` DESC";
}  elseif (isset($_GET['key']) and !isset($_GET['loc'])) {
    global $sql_s;
    $sql_s = "SELECT * FROM `company` WHERE `name` LIKE '%$_GET[key]%' OR `about` LIKE '%$_GET[key]%'
            OR `specialty` LIKE '%$_GET[key]%' OR `middle` LIKE '%$_GET[key]%' OR `people` LIKE '%$_GET[key]%' ORDER BY `id` DESC";
}





Head('Каталог кампаний');

?>
<body>

<?php require('template/base/nav.php'); ?>

<header id="header-search">
    <?php require('template/base/navblock.php'); ?>
    <div class="header-search-container">
        <div class="container">
            <form action="" method="post">
                <span class="hs-h">Найдите организацию</span>
                <div class="header-input-container">
                    <div class="hi-field">
                        <i class="mdi mdi-magnify"></i>
                        <input class="hi-title" type="text" name="c_key" placeholder="Название или ключевое слово">
                    </div>
                    <div class="hi-field">
                        <i class="mdi mdi-crosshairs-gps"></i>
                        <input class="hi-location" name="c_loc" type="text" placeholder="Город" value="<?php echo $_GET['loc'] ?>">
                    </div>
                    <input type="button" class="hs-bth" name="company-search" value="Найти">
                </div>
            </form>
        </div>
    </div>
</header>


<div class="filter-up-bth">
    <span>
        <i class="mdi mdi-tune"></i> фильтры
    </span>

</div>


<main id="wrapper" class="wrapper">

<section class="company">
        <div class="container">
            <div class="section-nav">
                <span><a href="/">Главная</a></span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span>Каталог компаний</span>
            </div>
            <div class="section-header">

                <?php

                if (!isset($_GET['key']) and !isset($_GET['loc']) and empty($sql_s)) {

                    ?>
                    <span>Найдено <? echo $app->count("SELECT * FROM `company`"); ?> компаний</span>
                    <?php
                } elseif (isset($_GET['key']) and isset($_GET['loc'])) {
                    ?>
                    <span>Найдено <? echo $app->count($sql_s); ?> компаний, по запросу <? echo $_GET['key'] ?></span>
                    <?php
                } elseif (isset($_GET['key']) and !isset($_GET['loc'])) {
                    ?>
                    <span>Найдено <? echo $app->count($sql_s); ?> компаний, по запросу <? echo $_GET['key'] ?></span>
                    <?php
                } elseif (!isset($_GET['key']) and isset($_GET['loc'])) {
                    ?>
                    <span>Найдено <? echo $app->count($sql_s); ?> компаний, в данном регионе</span>
                    <?php
                }
                ?>
            </div>

            <div class="filter-who-list">
                <!--<div class="fw-type"></div>
                <div class="fw-people"></div>
                <div class="fw-notype"></div>
                <div class="fw-novac"></div>-->
            </div>

            <div class="seach-block">


                <?php


                if (!isset($_GET['key']) and !isset($_GET['loc']) and empty($sql_s)) {



                    ?>

                    <div class="section-items">
                        <ul class="company-ul">
                            <div id="placeholder-main">
                                <div class="placeholder placeholder-flex">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item mx-little"></div>
                                        <div class="placeholder-item mx-bigger"></div>
                                        <div class="placeholder-item mx-middle"></div>
                                        <div class="placeholder-item mx-middle-2"></div>
                                        <div class="mx-flex">
                                            <div class="placeholder-item mx-flit"></div>
                                            <div class="placeholder-item mx-flit"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-item pasi-img">

                                    </div>
                                </div>
                                <div class="placeholder placeholder-flex">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item mx-little"></div>
                                        <div class="placeholder-item mx-bigger"></div>
                                        <div class="placeholder-item mx-middle"></div>
                                        <div class="placeholder-item mx-middle-2"></div>
                                        <div class="mx-flex">
                                            <div class="placeholder-item mx-flit"></div>
                                            <div class="placeholder-item mx-flit"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-item pasi-img">

                                    </div>
                                </div>
                                <div class="placeholder placeholder-flex">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item mx-little"></div>
                                        <div class="placeholder-item mx-bigger"></div>
                                        <div class="placeholder-item mx-middle"></div>
                                        <div class="placeholder-item mx-middle-2"></div>
                                        <div class="mx-flex">
                                            <div class="placeholder-item mx-flit"></div>
                                            <div class="placeholder-item mx-flit"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-item pasi-img">

                                    </div>
                                </div>
                                <div class="placeholder placeholder-flex">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item mx-little"></div>
                                        <div class="placeholder-item mx-bigger"></div>
                                        <div class="placeholder-item mx-middle"></div>
                                        <div class="placeholder-item mx-middle-2"></div>
                                        <div class="mx-flex">
                                            <div class="placeholder-item mx-flit"></div>
                                            <div class="placeholder-item mx-flit"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-item pasi-img">

                                    </div>
                                </div>
                                <div class="placeholder placeholder-flex">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item mx-little"></div>
                                        <div class="placeholder-item mx-bigger"></div>
                                        <div class="placeholder-item mx-middle"></div>
                                        <div class="placeholder-item mx-middle-2"></div>
                                        <div class="mx-flex">
                                            <div class="placeholder-item mx-flit"></div>
                                            <div class="placeholder-item mx-flit"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-item pasi-img">

                                    </div>
                                </div>
                                <div class="placeholder placeholder-flex">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item mx-little"></div>
                                        <div class="placeholder-item mx-bigger"></div>
                                        <div class="placeholder-item mx-middle"></div>
                                        <div class="placeholder-item mx-middle-2"></div>
                                        <div class="mx-flex">
                                            <div class="placeholder-item mx-flit"></div>
                                            <div class="placeholder-item mx-flit"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-item pasi-img">

                                    </div>
                                </div>
                                <div class="placeholder placeholder-flex">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item mx-little"></div>
                                        <div class="placeholder-item mx-bigger"></div>
                                        <div class="placeholder-item mx-middle"></div>
                                        <div class="placeholder-item mx-middle-2"></div>
                                        <div class="mx-flex">
                                            <div class="placeholder-item mx-flit"></div>
                                            <div class="placeholder-item mx-flit"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-item pasi-img">

                                    </div>
                                </div>
                                <div class="placeholder placeholder-flex">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item mx-little"></div>
                                        <div class="placeholder-item mx-bigger"></div>
                                        <div class="placeholder-item mx-middle"></div>
                                        <div class="placeholder-item mx-middle-2"></div>
                                        <div class="mx-flex">
                                            <div class="placeholder-item mx-flit"></div>
                                            <div class="placeholder-item mx-flit"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-item pasi-img">

                                    </div>
                                </div>
                            </div>
                        </ul>

                        <div class="paginator">

                        </div>
                    </div>

                    <?php

                } else {



                ?>

                    <div class="section-items">
                        <ul class="company-ul">
                            <span class="vac-none wow fadeIn">Загрука...</span>
                        </ul>

                        <div class="paginator">

                        </div>
                    </div>


                    <?php

                }

                ?>



                <div class="c-search-block">

                    <div class="filter-title">
                        Фильтры <i class="mdi mdi-close"></i>
                    </div>

                    <form role="form" method="GET" class="form-company form-filter">

                        <div class="filter-main">

                            <div class="filter-load">

                            </div>

                            <div class="filter-bth-wrap">
                                <button class="filter-bth-none" type="button">Загрузка...</button>
                            </div>

                            <?

                            $hash_filter = md5(random_str(10) . time());

                            $_SESSION["company-$hash_filter"] = $hash_filter;

                            ?>

                            <input style="display: none" name="token" type="text" id="" value="<? echo $hash_filter; ?>">

                            <!--<div class="all-filter-bth">Расширенный поиск</div>-->

                            <div class="filter-layout address">
                                <div class="fl-title">Тип <i class="fa-solid fa-chevron-up"></i> </div>
                                <div class="filter-block-pop">
                                    <div class="filter-ul">
                                        <ul class="filter-up filter-type">
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="1" name="type[]" value="1">
                                                    <label for="1">Частная</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `company` WHERE `type` LIKE '%Частная%'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="2" name="type[]" value="2">
                                                    <label for="2">Государственная</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `company` WHERE `type` LIKE '%Государственная%'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="3" name="type[]" value="3">
                                                    <label for="3">Смешанная</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `company` WHERE `type` LIKE '%Смешанная%'"); ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-layout address">
                                <div class="fl-title">Размер компании <i class="fa-solid fa-chevron-up"></i> </div>
                                <div class="filter-block-pop">
                                    <div class="filter-ul">
                                        <ul class="filter-up filter-people">
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="4" name="people[]" value="1">
                                                    <label for="4">10-50</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `company` WHERE `people` LIKE '%10-50%'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="5" name="people[]" value="2">
                                                    <label for="5">50-100</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `company` WHERE `people` LIKE '%50-100%'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="6" name="people[]" value="3">
                                                    <label for="6">100-200</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `company` WHERE `people` LIKE '%100-200%'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="7" name="people[]" value="4">
                                                    <label for="7">200-400</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `company` WHERE `people` LIKE '%200-400%'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="8" name="people[]" value="5">
                                                    <label for="8">400-500</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `company` WHERE `people` LIKE '%400-500%'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="9" name="people[]" value="6">
                                                    <label for="9">500-1000</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `company` WHERE `people` LIKE '%500-1000%'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="10" name="people[]" value="7">
                                                    <label for="10">Более 1000</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `company` WHERE `people` LIKE '%Более 1000%'"); ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-layout address">
                                <div class="fl-title">Исключения <i class="fa-solid fa-chevron-up"></i> </div>
                                <div class="filter-block-pop">
                                    <div class="filter-ul">
                                        <ul class="filter-up filter-task">
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="11" name="kard" value="1">
                                                    <label for="11">без кадровых агенств</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `company` WHERE `type` LIKE '%Кадровое агенство%'"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input type="checkbox" class="custom-checkbox" id="12" name="vac-non" value="1">
                                                    <label for="12">скрыть без вакансий</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `company` WHERE `job` < 1"); ?></span>
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

<script language="JavaScript" src="/static/scripts/catalogCompany.js?v=<?= date('YmdHis') ?>"></script>

</body>
</html>