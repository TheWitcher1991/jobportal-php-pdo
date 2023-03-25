<?php

use Work\plugin\lib\pQuery;

if (isset($_SESSION['company']) && isset($_SESSION['password']) && $_SESSION['type'] == 'company') {

    if ($_SESSION['type'] == 'company') {
        $sql = "SELECT * FROM `company` WHERE `id` = :id";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() <= 0) {
            pQuery::notFound();
        }

        $r = $stmt->fetch();
    } else {
        $app->notFound();
    }

    Head($r['name'] . ' - Откликнувшиеся');


    ?>
    <body class="profile-body">

    <div class="filter-up-bth">
    <span>
        <i class="mdi mdi-tune"></i> фильтры
    </span>

    </div>

    <main class="wrapper wrapper-profile" id="wrapper">

        <?php require('template/more/profileAside.php'); ?>



        <section class="profile-base">

            <?php require('template/more/profileHeader.php'); ?>


            <div class="profile-content create-resume">

                <div class="section-nav-profile">
                    <span><a href="/profile">Профиль</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a>Отклики</a></span>
                </div>

                <div class="errors-block-fix"></div>

                <div class="manage-resume-data">


                    <div class="manage-respond-wrapper">




                        <div class="block-respond-content">

                            <div class="bsc-1">

                                <div class="block-wrapper-manag">

                                    <div class="block-status">

                                        <a class="r-new <?php if (empty($_GET['t'])) { echo 'bs-active'; } ?>" href="/responded">
                                            <i class="mdi mdi-alert-decagram-outline"></i>
                                            Неразобранные (<?php echo $app->count("SELECT * FROM `respond` WHERE `status` = 0 AND `company_id` = '$_SESSION[id]'"); ?>)</a>

                                        <a class="r-talk <?php if ($_GET['t'] == 2) { echo 'bs-active'; } ?>" href="/responded/?t=2">
                                            <i class="mdi mdi-phone-in-talk-outline"></i>
                                            Разговор по телефону (<?php echo $app->count("SELECT * FROM `respond` WHERE `status` = 2 AND `company_id` = '$_SESSION[id]'"); ?>)</a>

                                        <a class="r-meeting <?php if ($_GET['t'] == 3) { echo 'bs-active'; } ?>" href="/responded/?t=3">
                                            <i class="mdi mdi-head-question-outline"></i>
                                            Собеседование (<?php echo $app->count("SELECT * FROM `respond` WHERE `status` = 3 AND `company_id` = '$_SESSION[id]'"); ?>)</a>

                                        <a class="r-accept <?php if ($_GET['t'] == 4) { echo 'bs-active'; } ?>" href="/responded/?t=4">
                                            <i class="mdi mdi-hand-wave-outline"></i>
                                            Принят на работу (<?php echo $app->count("SELECT * FROM `respond` WHERE `status` = 4 AND `company_id` = '$_SESSION[id]'"); ?>)</a>

                                        <a class="r-none <?php if ($_GET['t'] == 5) { echo 'bs-active'; } ?>" href="/responded/?t=5">
                                            <i class="mdi mdi-delete-variant"></i>
                                            Отказ (<?php echo $app->count("SELECT * FROM `respond` WHERE `status` = 5 AND `company_id` = '$_SESSION[id]'"); ?>)</a>

                                        <a class="r-none <?php if ($_GET['t'] == 6) { echo 'bs-active'; } ?>" href="/responded/?t=6">
                                            <i class="mdi mdi-account-plus-outline"></i>
                                            Приглашённые (<?php echo $app->count("SELECT * FROM `respond` WHERE `status` = 6 AND `company_id` = '$_SESSION[id]'"); ?>)</a>


                                    </div>


                                    <div class="manage-filter">
                                        <div class="manage-title">
                                            <span><div class="placeholder-item jx-title"></div></span>
                                        </div>
                                        <div class="manage-search-block">
                                            <input type="text" name="title" id="title" placeholder="Поиск по названию">
                                            <? if ($_GET['t'] != 6 && $_GET['t'] != 7) { ?>
                                                <select name="type_search" id="type_search">
                                                    <option value="1">По резюме</option>
                                                    <option value="2">По вакансии</option>
                                                </select>
                                            <? } ?>
                                            <button type="button">Найти</button>
                                        </div>
                                    </div>

                                    <div class="manage-sort profile-sort">
                                        <div class="mgss-block">
                                            <select class="sort-select" name="sort" id="sort_respond">
                                                <option value="1">По дате отклика</option>
                                                <option value="2">По зарплате</option>
                                            </select>
                                        </div>
                                        <div class="mgss-block">
                                            <select class="sort-select" name="faculty" id="sort_faculty">
                                                <option value="" selected="">Любой факультет</option>
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

                                        <form role="form" class="form-resume form-filter" method="GET">

                                            <div class="filter-main filter-resume">
                                                <!--<div class="all-filter-bth">Расширенный поиск</div>-->

                                                <div class="filter-load" style="display: none;">

                                                </div>

                                                <div class="filter-layout salary">
                                                    <div class="fl-title">Зарплата <i class="fa-solid fa-chevron-up"></i> </div>
                                                    <div class="filter-block-pop">
                                                        <div class="filter-ul">
                                                            <ul class="filter-up filter-salary">
                                                                <li>
                                                                    <div>
                                                                        <input class="custom-radio" checked="" name="salary" type="radio" id="1" value="-1">
                                                                        <label for="1">Не важно</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div>
                                                                        <input class="custom-radio" name="salary" type="radio" id="2" value="">
                                                                        <label for="2">По договорённости</label>
                                                                    </div>
                                                                    <span><? echo $app->count("SELECT * FROM `respond` WHERE `salary` = '' AND `company_id` = $_SESSION[id]"); ?></span>
                                                                </li>
                                                                <li>
                                                                    <div>
                                                                        <input class="custom-radio" name="salary" type="radio" id="3" value="15000">
                                                                        <label for="3">до 15 000 руб.</label>
                                                                    </div>
                                                                    <span><? echo $app->count("SELECT * FROM `respond` WHERE `salary` <= 15000 AND `company_id` = $_SESSION[id]"); ?></span>
                                                                </li>
                                                                <li>
                                                                    <div>
                                                                        <input class="custom-radio" name="salary" type="radio" id="4" value="25000">
                                                                        <label for="4">до 25 000 руб.</label>
                                                                    </div>
                                                                    <span><? echo $app->count("SELECT * FROM `respond` WHERE `salary` <= 25000 AND `company_id` = $_SESSION[id]"); ?></span>
                                                                </li>
                                                                <li>
                                                                    <div>
                                                                        <input class="custom-radio" name="salary" type="radio" id="5" value="45000">
                                                                        <label for="5">до 45 000 руб.</label>
                                                                    </div>
                                                                    <span><? echo $app->count("SELECT * FROM `respond` WHERE `salary` <= 45000 AND `company_id` = $_SESSION[id]"); ?></span>
                                                                </li>
                                                                <li>
                                                                    <div>
                                                                        <input class="custom-radio" name="salary" type="radio" id="6" value="85000">
                                                                        <label for="6">до 85 000 руб.</label>
                                                                    </div>
                                                                    <span><? echo $app->count("SELECT * FROM `respond` WHERE `salary` <= 85000 AND `company_id` = $_SESSION[id]"); ?></span>
                                                                </li>
                                                                <li>
                                                                    <div>
                                                                        <input class="custom-radio" name="salary" type="radio" id="7" value="100000">
                                                                        <label for="7">до 100 000 руб.</label>
                                                                    </div>
                                                                    <span><? echo $app->count("SELECT * FROM `respond` WHERE `salary` <= 100000 AND `company_id` = $_SESSION[id]"); ?></span>
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
                                                                    <span>1</span>
                                                                </li>
                                                                <li>
                                                                    <div>
                                                                        <input class="custom-radio" name="salary" type="radio" id="8" value="300000">
                                                                        <label for="8">до 300 000 руб.</label>
                                                                    </div>
                                                                    <span>1</span>
                                                                </li>
                                                                <li>
                                                                    <div>
                                                                        <input class="custom-radio" name="salary" type="radio" id="9" value="400000">
                                                                        <label for="9">до 400 000 руб.</label>
                                                                    </div>
                                                                    <span>1</span>
                                                                </li>
                                                                <li>
                                                                    <div>
                                                                        <input class="custom-radio" name="salary" type="radio" id="10" value="500000">
                                                                        <label for="10">до 500 000 руб.</label>
                                                                    </div>
                                                                    <span>1</span>
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
                                                                    <span><? echo $app->count("SELECT * FROM `respond` WHERE `exp` = 'Без опыта' AND `company_id` = $_SESSION[id]"); ?></span>
                                                                </li>
                                                                <li>
                                                                    <div>
                                                                        <input class="custom-checkbox" name="exp[]" type="checkbox" id="12" value="2">
                                                                        <label for="12">1-3 года</label>
                                                                    </div>
                                                                    <span><? echo $app->count("SELECT * FROM `respond` WHERE `exp` = '1-3 года' AND `company_id` = $_SESSION[id]"); ?></span>
                                                                </li>
                                                                <li>
                                                                    <div>
                                                                        <input class="custom-checkbox" name="exp[]" type="checkbox" id="13" value="3">
                                                                        <label for="13">3-6 лет</label>
                                                                    </div>
                                                                    <span><? echo $app->count("SELECT * FROM `respond` WHERE `exp` = '3-6 лет' AND `company_id` = $_SESSION[id]"); ?></span>
                                                                </li>
                                                                <li>
                                                                    <div>
                                                                        <input class="custom-checkbox" name="exp[]" type="checkbox" id="14" value="4">
                                                                        <label for="14">Более 6 лет</label>
                                                                    </div>
                                                                    <span><? echo $app->count("SELECT * FROM `respond` WHERE `exp` = 'Более 6 лет' AND `company_id` = $_SESSION[id]"); ?></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="filter-layout salary">
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
                                                </div>

                                                <div class="filter-layout salary">
                                                    <div class="fl-title">Пол <i class="fa-solid fa-chevron-up"></i> </div>
                                                    <div class="filter-block-pop">
                                                        <div class="filter-ul">
                                                            <ul class="filter-up filter-gender">
                                                                <li>
                                                                    <div>
                                                                        <input checked="" class="custom-radio" name="gender" type="radio" id="32" value="">
                                                                        <label for="32">Не важно</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div>
                                                                        <input class="custom-radio" name="gender" type="radio" id="33" value="1">
                                                                        <label for="33">Мужчина</label>
                                                                    </div>
                                                                    <span><? echo $app->count("SELECT * FROM `respond` WHERE (`gender` = 'Мужчина' OR `gender` = 'Мужской') AND `company_id` = $_SESSION[id]"); ?></span>
                                                                </li>
                                                                <li>
                                                                    <div>
                                                                        <input class="custom-radio" name="gender" type="radio" id="34" value="2">
                                                                        <label for="34">Женщина</label>
                                                                    </div>
                                                                    <span><? echo $app->count("SELECT * FROM `respond` WHERE (`gender` = 'Женщина' OR `gender` = 'Женский') AND `company_id` = $_SESSION[id]"); ?></span>
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



                        </div>



                    </div>







                </div>
            </div>
        </section>

    </main>


    <?php require('template/more/profileFooter.php'); ?>

    <?php require('template/more/respondScript.php'); ?>

    <script language="JavaScript" src="/static/scripts/catalogRespond.js?v=<?= date('YmdHis') ?>"></script>

    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>



