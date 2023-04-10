<?php 

use Work\plugin\lib\pQuery;

if (isset($_SESSION['company']) && isset($_SESSION['password']) && $_SESSION['type'] == 'company') {

    if ($_SESSION['type'] == 'company') {
        $sql = "SELECT * FROM `company` WHERE `id` = :id";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() <= 0) {
            $app->notFound();
        }
    
        $r = $stmt->fetch();
    } else {
        $app->notFound();
    }

    Head('Мои вакансии');


    $profileNavigator = [
        'Профиль' => '/profile',
        'Мои вакансии' => '/manage-job'
    ];


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
                <span><a href="/manage-job">Мои вакансии</a></span>
            </div>

            <div class="errors-block-fix"></div>

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

                        <div class="manage-sort profile-sort">
                            <div class="mgss-block">
                                <select class="sort-select" name="sorted" id="sort_job">
                                    <option value="1">По дате публикации</option>
                                    <option value="2">По просмотрам</option>
                                </select>
                            </div>
                        </div>

                    </div>




                    <div class="manage-list">

                        <ul class="manage-ul">

                            <div>
                                <div class="man-job">

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


                        </ul>
                        <div class="manage-filter-list">
                            <div class="filter-title">
                                Фильтры <i class="mdi mdi-close"></i>
                            </div>

                            <form role="form" class="form-job form-filter" method="GET">

                                <div class="filter-main filter-job">

                                    <div class="filter-load">

                                    </div>

                                    <div class="filter-layout salary">
                                        <div class="fl-title">Контактное лицо <i class="fa-solid fa-chevron-up"></i> </div>
                                        <div class="filter-block-pop">
                                            <div class="filter-ul">
                                                <ul class="filter-up filter-exp">
                                                    <?php
                                                        $sql = $app->query("SELECT * FROM `vacancy` WHERE `status` = 0 AND `contact` != '' AND `company_id` = '$r[id]' GROUP BY `contact`");
                                                        while ($v = $sql->fetch()) {
                                                    ?>
                                                            <li>
                                                                <div>
                                                                    <input type="checkbox" class="custom-checkbox" id="qq<? echo $v['id'] ?>" name="contact[]" value="<? echo $v['contact'] ?>">
                                                                    <label for="qq<? echo $v['id'] ?>"><? echo $v['contact'] ?></label>
                                                                </div>
                                                                <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `contact` = '$v[contact]' AND `status` = 0 AND `company_id` = '$_SESSION[id]'"); ?></span>
                                                            </li>
                                                    <?php
                                                        }
                                                    ?>
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
                                                        <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `exp` = 'Без опыта' AND `status` = 0 AND `company_id` = '$_SESSION[id]'"); ?></span>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <input class="custom-radio" name="exp" type="radio" id="101" value="2">
                                                            <label for="101">1-3 года</label>
                                                        </div>
                                                        <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `exp` = '1-3 года' AND `status` = 0 AND `company_id` = '$_SESSION[id]'"); ?></span>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <input class="custom-radio" name="exp" type="radio" id="102" value="3">
                                                            <label for="102">3-6 лет</label>
                                                        </div>
                                                        <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `exp` = '3-6 лет' AND `status` = 0 AND `company_id` = '$_SESSION[id]'"); ?></span>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <input class="custom-radio" name="exp" type="radio" id="103" value="4">
                                                            <label for="103">Более 6 лет</label>
                                                        </div>
                                                        <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `exp` = 'Более 6 лет' AND `status` = 0 AND `company_id` = '$_SESSION[id]'"); ?></span>
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
                                                        <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `time` = 'Полный рабочий день' AND `status` = 0 AND `company_id` = '$_SESSION[id]'"); ?></span>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <input type="checkbox" class="custom-checkbox" id="2" name="time[]" value="2">
                                                            <label for="2">Гибкий график</label>
                                                        </div>
                                                        <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `time` = 'Гибкий график' AND `status` = 0 AND `company_id` = '$_SESSION[id]'"); ?></span>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <input type="checkbox" class="custom-checkbox" id="3" name="time[]" value="3">
                                                            <label for="3">Сменный график</label>
                                                        </div>
                                                        <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `time` = 'Сменный график' AND `status` = 0 AND `company_id` = '$_SESSION[id]'"); ?></span>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <input type="checkbox" class="custom-checkbox" id="4" name="time[]" value="4">
                                                            <label for="4">Ненормированный рабочий день</label>
                                                        </div>
                                                        <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `time` = 'Ненормированный рабочий день' AND `status` = 0 AND `company_id` = '$_SESSION[id]'"); ?></span>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <input type="checkbox" class="custom-checkbox" id="5" name="time[]" value="5">
                                                            <label for="5">Вахтовый метод</label>
                                                        </div>
                                                        <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `time` = 'Вахтовый метод' AND `status` = 0 AND `company_id` = '$_SESSION[id]'"); ?></span>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <input type="checkbox" class="custom-checkbox" id="6" name="time[]" value="6">
                                                            <label for="6">Неполный рабочий день</label>
                                                        </div>
                                                        <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `time` = 'Неполный рабочий день' AND `status` = 0 AND `company_id` = '$_SESSION[id]'"); ?></span>
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
                                                        <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `type` = 'Полная занятость' AND `status` = 0 AND `company_id` = '$_SESSION[id]'"); ?></span>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <input type="checkbox" class="custom-checkbox" id="8" name="type[]" value="2">
                                                            <label for="8">Частичная занятость</label>
                                                        </div>
                                                        <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `type` = 'Частичная занятость' AND `status` = 0 AND `company_id` = '$_SESSION[id]'"); ?></span>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <input type="checkbox" class="custom-checkbox" id="9" name="type[]" value="3">
                                                            <label for="9">Временная работа</label>
                                                        </div>
                                                        <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `type` = 'Временная' AND `status` = 0 AND `company_id` = '$_SESSION[id]'"); ?></span>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <input type="checkbox" class="custom-checkbox" id="10" name="type[]" value="4">
                                                            <label for="10">Стажировка</label>
                                                        </div>
                                                        <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `type` = 'Стажировка' AND `status` = 0 AND `company_id` = '$_SESSION[id]'"); ?></span>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <input type="checkbox" class="custom-checkbox" id="11" name="type[]" value="5">
                                                            <label for="11">Сезонная работа</label>
                                                        </div>
                                                        <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `type` = 'Сезонная' AND `status` = 0 AND `company_id` = '$_SESSION[id]'"); ?></span>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <input type="checkbox" class="custom-checkbox" id="12" name="type[]" value="6">
                                                            <label for="12">Удаленная работа</label>
                                                        </div>
                                                        <span><? echo $app->count("SELECT * FROM `vacancy` WHERE `type` = 'Удаленная' AND `status` = 0 AND `company_id` = '$_SESSION[id]'"); ?></span>
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
    </section>

</main>

<?php require('template/more/profileFooter.php'); ?>

<script language="JavaScript" src="/static/scripts/manage-job.js?v=<?= date('YmdHis') ?>"></script>

<script>
    function getRandomInt(max) {
        return Math.floor(Math.random() * max);
    }

    function MessageBox(text) {
        let id = getRandomInt(100);
        $('.errors-block-fix').html(`
                            <div class="alert-block alert-${id}">
                                <div>
                                    <span>${text}</span>
                                    </br />
                                </div>
                                <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                            </div>
                            `)
        $('.errors-block-fix > div').css('display', 'flex')
        setTimeout (() => {
            $(`.alert-${id}`).remove();
        }, 3000)
    }

    function deleteForm(){document.querySelector('#auth').remove()}

    function deleteJob(id, ctx) {
        $('.yes-delete-vac').attr('disabled', 'true');
        $('.yes-delete-vac').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`);
        $.ajax({
            url: '/scripts/profile-js',
            data: `id=${id}&MODULE_DELETE_JOB=1`,
            type: 'POST',
            cache: false,
            dataType: 'json',
            error: (response) => {
                MessageBox('Произошла ошибка. Повторите')
                $('.yes-delete-vac').removeAttr('disabled');
                $('.yes-delete-vac').html('Закрыть');
            },
            success: function (responce) {
                if (responce.code === 'success') {
                    MessageBox('Убираем в архив...')
                    location.reload()
                } else {
                    MessageBox('Произошла ошибка. Повторите')
                    $('.yes-delete-vac').removeAttr('disabled');
                    $('.yes-delete-vac').html('Закрыть');
                }
            }})
    }

    function deleteVac(id,name){document.querySelector('.profile-body').innerHTML+=`

                        <div id="auth" style="display:flex">
                    <div class="contact-wrapper" style="display:block">
                        <div class="auth-container auth-log" style="display:block">
                            <div class="auth-title">
                                Закрыть вакансию
                                <i class="mdi mdi-close form-detete" onclick="deleteForm()"></i>
                            </div>
                            <div class="auth-form">
                                <div class="pop-text">
                                    Вы уверены, что хотите закрыть данную вакансию?
                                </div>
                                <span><i class="icon-briefcase"></i> ${name}</span>
                                <form method="post">
                                    <div class="pop-flex-bth">
                                        <button class="more-inf" type="button" onclick="deleteForm()">Отмена</button>
                                        <button data-id="${id}" type="button" class="lock-yes yes-delete-vac" name="delete-${id}" onclick="deleteJob(${id}, this)">Закрыть</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `}
</script>

</body>
</html>
<?php
} else {
    pQuery::notFound();
}
?>