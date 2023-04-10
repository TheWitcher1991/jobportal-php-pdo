<?php

if (isset($_POST["job_search"]) and (isset($_POST["j_key"]) or isset($_POST["j_loc"]))) {

    if ($_POST["j_key"] != '' and $_POST["j_loc"] != '') {
        exit(header('location: /job-list?key=' . $_POST['j_key'] . '&loc=' . $_POST["j_loc"]));
    }

    if (empty($_POST["j_key"]) and $_POST["j_loc"] != '') {
        exit(header('location: /job-list?loc=' . $_POST["j_loc"]));
    }

    if ($_POST["j_key"] != '' and empty($_POST["j_loc"])) {
        exit(header('location: /job-list?key=' . $_POST['j_key']));
    }

}

Head('Каталог ваканский');

$loc = (string) $_GET['loc'];

$stmtl = $PDO->prepare("SELECT * FROM `map` WHERE `code` = :code");
$stmtl->bindValue(':code', $loc);
$stmtl->execute();
$mn = $loc;
if ($stmtl->rowCount() > 0) {
    $lk = $stmtl->fetch();
    $mn = trim($lk['text']);
}  else {
    $stmtl2 = $PDO->prepare("SELECT * FROM `map_list` WHERE `code` = :code");
    $stmtl2->bindValue(':code', $loc);
    $stmtl2->execute();
    if ($stmtl2->rowCount() > 0) {
        $lk = $stmtl2->fetch();
        $mn = trim($lk['name']);
    }
}

if (isset($_GET['key']) and isset($_GET['loc'])) {
    global $sql_s;
    $sql_s = "SELECT * FROM `vacancy` WHERE (`title` LIKE '%$_GET[key]%' OR `text` LIKE '%$_GET[key]%'
            OR `type` LIKE '%$_GET[key]%' OR `exp` LIKE '%$_GET[key]%' OR `time` LIKE '%$_GET[key]%' OR `company` LIKE '%$_GET[key]%' OR `salary` LIKE '%$_GET[key]%' OR `category` LIKE '%$_GET[key]%') AND (`address` LIKE '%$mn%' OR `region` LIKE '%$mn%' OR `district` LIKE '%$mn%' OR `area` LIKE '%$mn%') AND `status` = 0 ORDER BY `id` DESC";
} elseif (!isset($_GET['key']) and isset($_GET['loc'])) {
    global $sql_s;
    $sql_s = "SELECT * FROM `vacancy` WHERE (`address` LIKE '%$mn%' OR `region` LIKE '%$mn%' OR `district` LIKE '%$mn%' OR `area` LIKE '%$mn%') AND `status` = 0 ORDER BY `id` DESC";
}  elseif (isset($_GET['key']) and !isset($_GET['loc'])) {
    global $sql_s;
    $sql_s = "SELECT * FROM `vacancy` WHERE (`title` LIKE '%$_GET[key]%' OR `text` LIKE '%$_GET[key]%'
            OR '%$_GET[key]%' OR `type` LIKE '%$_GET[key]%' OR `exp` LIKE '%$_GET[key]%' OR `time` LIKE '%$_GET[key]%' OR `company` LIKE '%$_GET[key]%' OR `salary` LIKE '%$_GET[key]%' OR `category` LIKE '%$_GET[key]%') AND `status` = 0 ORDER BY `id` DESC";
}




?>
<body>

<?php require('template/base/nav.php'); ?>


<header id="header-search">
    <?php require('template/base/navblock.php'); ?>
    <div class="header-search-container">
        <div class="container">
            <form action="" method="post">
                <?php require('template/more/map.php'); ?>

                <?php

                if (isset($_GET['loc']) and $_GET['loc'] != 'stav' and $_GET['loc'] != 'Ставропольский край' and $_GET['loc'] != 'город Ставрополь' and $_GET['loc'] != 'stavropol') {
                    $stmt2 = $PDO->prepare("SELECT * FROM `map_list` WHERE (`code` = :code OR `name` LIKE '%$loc%') AND `type` != 'area'
                    AND `code` != 'stav_lermon' AND `code` != 'stav_jelezn' AND `code` != 'stav_georgivsk' AND `code` != 'stav_pyati' AND `code` != 'stav_essent'
                    AND `code` != 'stav_kislovodsk' AND `code` != 'stav_nevin' AND `code` != 'sevas' AND `code` != 'mosc' AND `code` != 'sankt' ORDER BY `name` DESC");
                    $stmt2->bindValue(':code', $loc);
                    $stmt2->execute();
                    if ($stmt2->rowCount() > 0) {
                        $l = $stmt2->fetch();
                        ?>
                        <div class="map">
                        <div class="left-menu" style="width: 100%;">
                        <a class="reset-okr" href="/job-list"><i class="mdi mdi-arrow-left"></i> Обзор России</a>
                        <ul>
                        <?php

                        foreach ($district as $key => $val) {
                            foreach ($val as $kk => $vv) {

                                if ($kk == $l['name']) {
                                    foreach ($vv as $key_g => $value) {
                                        if (gettype($value) != 'array') {
                                        ?>

                                                        <li>
                                                            <a data-name="<?php echo $value ?>" data-job="<?php echo $app->count("SELECT * FROM `vacancy` WHERE (`region` = '$value' OR `area` = '$value' OR `address` = '$value') AND `status` = 0"); ?>" href="/job-list?loc=<?php echo $value ?>">
                                                                <div class="caption"><?php echo $value ?></div>
                                                                <div class="label">Вакансий <?php echo $app->count("SELECT * FROM `vacancy` WHERE (`region` = '$value' OR `area` = '$value' OR `address` = '$value') AND `status` = 0"); ?></div>
                                                            </a>
                                                        </li>

                                        <?php
                                        } else {
                        ?>
                                            <script>document.querySelector('.map').remove()</script>
                                            <?php
                                        }
                                    }
                                }
                            }
                        }

                        ?>
                        </ul>
                        </div>
                        </div>
                        <?php
                    } else {
                        $stmt2 = $PDO->prepare("SELECT * FROM `map_list` WHERE (`code` = :code OR `name` LIKE '%$loc%') AND `type` = 'area'
                           AND `code` != 'stav_lermon' AND `code` != 'stav_jelezn' AND `code` != 'stav_georgivsk' AND `code` != 'stav_pyati' AND `code` != 'stav_essent'
                           AND `code` != 'stav_kislovodsk' AND `code` != 'stav_nevin' AND `code` != 'sevas' AND `code` != 'mosc' AND `code` != 'sankt' ORDER BY `name` DESC");
                        $stmt2->bindValue(':code', $loc);
                        $stmt2->execute();
                        if ($stmt2->rowCount() > 0) {
                            $l = $stmt2->fetch();
                        ?>
                <div class="map">
                    <div class="left-menu" style="width: 100%;">
                        <a class="reset-okr" href="/job-list"><i class="mdi mdi-arrow-left"></i> Обзор России</a>
                        <ul>
                            <?php
                            $arr = $district['Северо-Кавказский федеральный округ']['Ставропольский край'];
                            foreach ($arr as $key => $val) {
                                if ($key == $l['name']) {
                                    foreach ($val as $key_g => $value) {
                                        if (gettype($value) != 'array') {
                                        ?>

                                        <li>
                                            <a data-name="<?php echo $value ?>" data-job="<?php echo $app->count("SELECT * FROM `vacancy` WHERE (`region` = '$value' OR `area` = '$value' OR `address` = '$value') AND `status` = 0"); ?>" href="/job-list?loc=<?php echo $value ?>">
                                                <div class="caption"><?php echo $value ?></div>
                                                <div class="label">Вакансий <?php echo $app->count("SELECT * FROM `vacancy` WHERE (`region` = '$value' OR `area` = '$value' OR `address` = '$value') AND `status` = 0"); ?></div>
                                            </a>
                                        </li>

                                        <?php
                                        } else {
                                        ?>
                                            <script>document.querySelector('.map').remove()</script>
                                            <?php
                                        }
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                            <?php
                        }

                    }
                }

                ?>

                <div class="hs-container">
                    <? if (empty($_GET['loc'])) { ?>
                        <span class="hs-h">Свежие вакансии по всей России</span>
                        <div class="header-input-container">
                            <div class="hi-field">
                                <i class="mdi mdi-magnify"></i>
                                <input class="hi-title" name="j_key" type="text" placeholder="Должность или ключевое слово">
                            </div>
                            <div class="hi-field">
                                <i class="mdi mdi-crosshairs-gps"></i>
                                <input class="hi-location" name="j_loc" type="text" placeholder="Город или регион" value="">
                            </div>
                            <input type="button" class="hs-bth" name="job_search" value="Найти">
                        </div>
                    <? } else if (isset($loc)) {
                        $stmt = $PDO->prepare("SELECT * FROM `map` WHERE `code` = :code OR `text` LIKE '%$loc%'");
                        $stmt->bindValue(':code', $loc);
                        $stmt->execute();
                        if ($stmt->rowCount() > 0) {
                            global $l;
                            $l = $stmt->fetch();
                            ?>
                            <span class="hs-h">Свежие вакансии — <? echo $l['text']; ?></span>
                            <div class="header-input-container">
                                <div class="hi-field">
                                    <i class="mdi mdi-magnify"></i>
                                    <input class="hi-title" name="j_key" type="text" placeholder="Должность или ключевое слово">
                                </div>
                                <div class="hi-field">
                                    <i class="mdi mdi-crosshairs-gps"></i>
                                    <input disabled class="hi-location" name="j_loc" type="text" placeholder="Город или регион" value="<? echo $l['text']; ?>">
                                </div>
                                <input type="button" class="hs-bth" name="job_search" value="Найти">
                            </div>
                            <?php
                        } else {
                            $stmt2= $PDO->prepare("SELECT * FROM `map_list` WHERE `code` = :code OR `name` LIKE '%$loc%'");
                            $stmt2->bindValue(':code', $loc);
                            $stmt2->execute();
                            if ($stmt2->rowCount() > 0) {
                                global $l;
                                $l = $stmt2->fetch();
                            ?>
                                <span class="hs-h">Свежие вакансии — <? echo $l['name']; ?></span>
                                <div class="header-input-container">
                                    <div class="hi-field">
                                        <i class="mdi mdi-magnify"></i>
                                        <input class="hi-title" name="j_key" type="text" placeholder="Должность или ключевое слово">
                                    </div>
                                    <div class="hi-field">
                                        <i class="mdi mdi-crosshairs-gps"></i>
                                        <input disabled class="hi-location" name="j_loc" type="text" placeholder="Город или регион" value="<? echo $l['name']; ?>">
                                    </div>
                                    <input type="button" class="hs-bth" name="job_search" value="Найти">
                                </div>
                            <?php
                                } else {

                            ?>
                            <span class="hs-h">Свежие вакансии</span>
                            <div class="header-input-container">
                                <div class="hi-field">
                                    <i class="mdi mdi-magnify"></i>
                                    <input class="hi-title" name="j_key" type="text" placeholder="Должность или ключевое слово">
                                </div>
                                <div class="hi-field">
                                    <i class="mdi mdi-crosshairs-gps"></i>
                                    <input class="hi-location" name="j_loc" type="text" placeholder="Город или регион" value="<? echo $loc; ?>">
                                </div>
                                <input type="button" class="hs-bth" name="job_search" value="Найти">
                            </div>
                            <?php
                            }
                        }
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</header>

<main id="wrapper" class="wrapper">

    <section class="job-list-section">
        <div class="container">
            <div class="section-nav">
                <span><a href="/">Главная</a></span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span>Каталог вакансий</span>
            </div>
            <div class="section-header">
                <span><div class="placeholder-item jx-title"></div></span>
            </div>

            <div class="seach-block">

                <div class="filter-up-bth">
    <span>
        <i class="mdi mdi-tune"></i> фильтры
    </span>

                </div>


                <?php

                if (!isset($_GET['key']) and !isset($_GET['loc'])) {



                ?>


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
                        
                        <!--<div class="fast-filter-block">
                            <a class="<?php if ($_GET['key'] == 'Удаленная работа') echo 'fl-active'  ?>" href="<?php echo get_params() . 'key=Удаленная работа'  ?>">Удаленная работа</a>
                            <a href="<?php echo get_params() . 'key=Сменный график'   ?>">Сменный график</a>
                            <a href="<?php echo get_params() . 'key=Без опыта'  ?>">Без опыта</a>
                        </div>-->

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
                                    <!--<div class="sort-block">
                                        <select class="sort-select" name="sorted" id="time_job">
                                            <option selected value="1">За всё время</option>
                                            <option value="2">За сутки</option>
                                            <option value="3">За неделю</option>
                                            <option value="4">За месяц</option>
                                            <option value="5">За послдение три дня</option>
                                        </select>
                                        <div>
                                            <i class="mdi mdi-chevron-down"></i>
                                        </div>
                                    </div>-->
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
                           <!-- <?php

                            $PAGE = (int) $_GET['page'];

                            if ($number_of_pages > 1 and $PAGE != 1 and isset($_GET['page'])) {
                                echo '<a href="/job-list?page=' . ($PAGE - 1) . '"><i class="fa-solid fa-chevron-left"></i></a> ';
                            }

                            for ($pag = 1; $pag <= $number_of_pages; $pag++) {

                                if ($number_of_pages == 1) {
                                    echo '<a class="page-active" style="border-radius:4px" href="/job-list?page=' . $pag . '">' . $pag . '</a> ';
                                } elseif (!isset($_GET['page']) && $pag == 1) {
                                    echo '<a class="page-active" href="/job-list?page=' . $pag . '">' . $pag . '</a> ';
                                } elseif ((int) $_GET['page'] == $pag) {
                                    echo '<a class="page-active" href="/job-list?page=' . $pag . '">' . $pag . '</a> ';
                                } else {
                                    echo '<a href="/job-list?page=' . $pag . '">' . $pag . '</a> ';
                                }
                            }

                            if ($PAGE < $number_of_pages and isset($_GET['page'])) {
                                echo '<a href="/job-list?page=' . ($PAGE + 1) . '"><i class="fa-solid fa-chevron-right"></i></a> ';
                            }


                            ?>-->
                        </div>

                    </div>

                    <?php

                } else {



                    ?>


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

                        <!--<div class="fast-filter-block">
                            <a class="<?php if ($_GET['key']=='Удаленная работа') echo 'fl-active'  ?>" href="<?php echo get_params() . 'key=Удаленная работа'  ?>">Удаленная работа</a>
                            <a class="<?php if ($_GET['key']=='Сменный график') echo 'fl-active'  ?>" href="<?php echo get_params() . 'key=Сменный график'   ?>">Сменный график</a>
                            <a class="<?php if ($_GET['key']=='Без опыта') echo 'fl-active'  ?>" href="<?php echo get_params() . 'key=Без опыта'  ?>">Без опыта</a>
                        </div>-->

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
                                    <!--<div class="sort-block">
                                        <select class="sort-select" name="sorted" id="time_job">
                                            <option selected value="1">За всё время</option>
                                            <option value="2">За сутки</option>
                                            <option value="3">За неделю</option>
                                            <option value="4">За месяц</option>
                                            <option value="5">За послдение три дня</option>
                                        </select>
                                        <div>
                                            <i class="mdi mdi-chevron-down"></i>
                                        </div>
                                    </div>-->
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



                    <?php

                }

                ?>


                <div class="c-search-block">

                    <div class="filter-title">
                        Фильтры <i class="mdi mdi-close"></i>
                    </div>



                    <form role="form" class="form-job form-filter" method="GET">


                        <div class="filter-main filter-job">

                            <div class="filter-load">

                            </div>

                            <div class="filter-bth-wrap">
                                <button class="filter-bth-none" type="button">Загрузка...</button>
                            </div>



                            <!--<div class="all-filter-bth">Расширенный поиск</div>-->
                           <!-- <?php
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




                                            <?php



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

                                            <?php } ?>

                                        </ul>
                                    </div>
                                    <div class="fl-bth">
                                        Ещё <?php echo $app->count('SELECT `address` FROM `vacancy` WHERE `status` = 0 AND `status` = 0 GROUP BY `address`') - 6  ?>
                                    </div>
                                </div>
                            </div>
                                <?php

                            }

                            ?>-->

                            <?

                            $hash_filter = md5(random_str(10) . time());

                            $_SESSION["job-$hash_filter"] = $hash_filter;

                            ?>

                            <input style="display: none" name="token" type="text" id="" value="<? echo $hash_filter; ?>">

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
                                            <!--<li>
                                                <div>
                                                    <input class="custom-radio" name="salary" type="radio" id="105" value="10000">
                                                    <label for="105">от 10 000 руб.</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `salary` > 10000 AND `status` = 0"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="salary" type="radio" id="106" value="20000">
                                                    <label for="106">от 20 000 руб</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `salary` > 20000 AND `status` = 0"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="salary" type="radio" id="107" value="30000">
                                                    <label for="107">от 30 000 руб</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `salary` > 30000 AND `status` = 0"); ?></span>
                                            </li>
                                            <li>
                                                <div>
                                                    <input class="custom-radio" name="salary" type="radio" id="108" value="40000">
                                                    <label for="108">от 40 000 руб</label>
                                                </div>
                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `salary` > 40000 AND `status` = 0"); ?></span>
                                            </li>-->
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
                                            $sql = $app->query('SELECT * FROM `company` ORDER BY `views` DESC');
                                            while ($r = $sql->fetch()) {
                                            ?>
                                                <li>
                                                    <div>
                                                        <input type="checkbox" class="custom-checkbox" id="c<?php echo $r['id'] ?>" name="company[]" value="<?php echo $r['id'] ?>">
                                                        <label for="c<?php echo $r['id'] ?>"><?php echo $r['name'] ?></label>
                                                    </div>
                                                    <span><?php echo $app->count("SELECT * FROM `vacancy` WHERE `company_id` = '$r[id]' AND `status` = 0") ?></span>
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
                                <div class="fl-title">Отрасли <i class="fa-solid fa-chevron-up"></i> </div>
                                <div class="filter-block-pop">
                                    <div class="filter-ul">
                                        <ul class="filter-up filter-category" style="padding: 0 10px 0 0">
                                            <?php
                                            $sql = $app->query('SELECT * FROM `category` ORDER BY `job` DESC');
                                            while ($r = $sql->fetch()) {
                                                ?>
                                                <li>
                                                    <div>
                                                        <input type="checkbox" class="custom-checkbox" id="t<?php echo $r['id'] ?>" name="category[]" value="<?php echo $r['id'] ?>">
                                                        <label for="t<?php echo $r['id'] ?>"><?php echo $r['name'] ?></label>
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