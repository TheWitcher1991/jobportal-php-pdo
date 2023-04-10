<?php

use Work\plugin\lib\pQuery;

if (isset($_SESSION['id']) && isset($_SESSION['password']) && $_SESSION['type'] == 'company') {
    $id_j = (int) $_GET['id'];

    $jo = $app->fetch("SELECT * FROM `vacancy` WHERE `id` = :id AND `company_id` = :cid", [
        ':id' => $id_j,
        ':cid' => $_SESSION['id']
    ]);

    if (empty($jo['id'])) {
        $app->notFound();
        exit;
    }

    $r = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $_SESSION['id']]);

    if (empty($r['id'])) {
        $app->notFound();
    }


    Head($r['name'] . ' - изменить вакансию');

    $profileNavigator = [
        'Профиль' => '/profile',
        'Мои вакансии' => '/manage-job',
        'Редактировать вакансию - '.$jo['title'] => '#',
    ];
?>
<body class="profile-body">

<main class="wrapper wrapper-profile" id="wrapper">

    <?php require('template/more/profileAside.php'); ?>

    <section class="profile-base">

        <?php require('template/more/profileHeader.php'); ?>

        <div class="profile-content edit-prof">

            <div class="section-nav-profile">
                <span><a href="/profile">Профиль</a></span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span>Редактировать вакансию - <?php echo $jo['title']; ?></span>
            </div>

            <div class="errors-block">

            </div>

            <div class="errors-block-fix">

            </div>


            <div class="create-resume-data profile-data">

                <form role="form" method="POST" class="form-edit-job">

                    <div class="resume-bth">
                        <!--<input class="preview-job" type="button" value="Предпросмотр">-->
                        <button type="button" class="edit-job" name="edit-job">Изменить</button>
                    </div>

                    <div class="resume-form-block">
                        <div class="job-main-info">
                            <span class="pff-t">Основная информация</span>
                            <div class="res-inp-b cont-mov">
                                <div class="label-block">
                                    <label for="title">Название вакансии <span>*</span></label>
                                    <input <? if (isset($err['title'])) { ?> class="errors" <? } ?> type="text" id="title" name="title" placeholder="" value="<?php echo $jo['title'] ?>">
                                    <span class="empty e-title">Введите название</span>
                                </div>



                                <div class="flex f-n">
                                    <div class="label-block au-fn au-fn-1">
                                        <label for="date">Ожидаемая дата закрытия <span>*</span></label>
                                        <input <? if (isset($err['date'])) { ?> class="errors" <? } ?> type="date" id="date" name="date" min="<?php echo date("Y-m-d", time() + 1 * 24 * 60 * 60); ?>" value="<?php echo $jo['task'] ?>"
                                                                                                       max="<?php echo date('Y-m-d', time() + 562 * 24 * 60 * 60); ?>">
                                        <span class="empty e-date">Укажите дату закрытия</span>
                                        <span class="empty e-z-date">Укажите дату закрытия</span>
                                    </div>



                                    <div class="label-block au-fn">
                                        <label for="email">E-mail <span>*</span></label>
                                        <input <? if (isset($err['email'])) { ?> class="errors" <? } ?> type="email" id="email" name="email" placeholder="" value="<?php echo $jo['email'] ?>">
                                        <span class="empty e-email">Введите email</span>
                                    </div>
                                </div>

                                <div class="flex f-n">
                                    <div class="label-block au-fn au-fn-1">
                                        <label for="tel">Телефон <span>*</span></label>
                                        <input <? if (isset($err['phone'])) { ?> class="errors" <? } ?> type="text" id="tel" name="phone" placeholder="+7 (999) 999-99-99" value="<?php echo $jo['phone'] ?>">
                                        <span class="empty e-phone">Введите телефон</span>
                                    </div>

                                    <div class="label-block au-fn">
                                        <label for="username">Контактное лицо</label>
                                        <input <? if (isset($err['username'])) { ?> class="errors" <? } ?> type="text" id="username" name="username" value="<?php echo $jo['contact'] ?>" placeholder="">
                                        <span class="empty e-username">Введите контактное лицо</span>
                                    </div>
                                </div>

                                <div class="label-block">
                                    <label for="region">Регион <span>*</span></label>
                                    <div class="label-select-block">
                                        <select  class="select2-region <? if (isset($err['region'])) { ?> errors <? } ?>" id="region" name="region" placeholder="Выберите регион">
                                            <option selected value="<?php echo $jo['region'] ?>"><?php echo $jo['region'] ?></option>
                                            <? foreach ($district as $k1 => $v1) {
                                                foreach($v1 as $k2 => $v2) {


                                                    ?>
                                                    <option value="<? echo $k2 ?>"><? echo $k2; ?></option>
                                                    <?

                                                }
                                            } ?>
                                        </select>
                                        <div class="label-arrow">
                                            <i class="mdi mdi-chevron-down"></i>
                                        </div>
                                    </div>
                                    <span class="empty e-region">Выберите регион</span>
                                </div>

                                <div class="label-block profile-area">
                                    <? if (isset($jo['area']) || trim($jo['area']) != '') { ?>
                                    <? if (isset($jo['region']) && trim($jo['region']) == 'Ставропольский край') { ?>
                                        <label for="address">Район <span>*</span></label>
                                        <div class="label-select-block">
                                            <select class="select2-area" id="area" name="area" placeholder="Выберите район">

                                                <? foreach ($district['Северо-Кавказский федеральный округ']['Ставропольский край'] as $k1 => $v1) {
                                                        if ($k1 == $jo['area']) {
                                                            echo "<option value=\"$k1\">$k1</option>";
                                                        } else {
                                                            echo "<option value=\"$k1\">$k1</option>";
                                                        }
                                                    ?>
                                                <? } ?>
                                            </select>
                                            <div class="label-arrow">
                                                <i class="mdi mdi-chevron-down"></i>
                                            </div>

                                        </div>
                                        <span class="empty e-area">Выберите район</span>
                                    <? } ?>
                                    <? } ?>
                                </div>

                                <div class="label-block profile-city">
                                    <label for="address">Населённый пункт <span>*</span></label>
                                    <div class="label-select-block">
                                        <select class="select2-address" id="address" name="address" placeholder="Выберите населённый пункт">
                                            <? if (isset($jo['region']) && trim($jo['region']) == 'Ставропольский край') { ?>
                                                <? foreach ($district['Северо-Кавказский федеральный округ']['Ставропольский край'] as $k1 => $v1) {
                                                foreach ($v1 as $k2 => $v2) {
                                                    if ($k2 == $jo['area']) {
                                                        echo "<option value=\"$v2\">$v2</option>";
                                                    } else {
                                                        echo "<option value=\"$v2\">$v2</option>";
                                                    }
                                                }
                                            }
                                            ?>
                                            <? } else { ?>
                                                <? foreach ($district[$jo['district']][$jo['region']] as $k1 => $v1) {
                                                    foreach ($v1 as $k2 => $v2) {
                                                        if ($k2 == $jo['area']) {
                                                            echo "<option value=\"$v2\">$v2</option>";
                                                        } else {
                                                            echo "<option value=\"$v2\">$v2</option>";
                                                        }
                                                    }
                                                }
                                                ?>
                                            <? } ?>
                                        </select>
                                        <div class="label-arrow">
                                            <i class="mdi mdi-chevron-down"></i>
                                        </div>
                                    </div>
                                    <span class="empty e-address">Выберите населённый пункт</span>
                                </div>

                                <div class="label-block">
                                    <label for="urid">Юридический адрес</label>
                                    <input type="text" id="urid" name="urid" placeholder="" value="<?php echo $jo['urid'] ?>">
                                </div>

                                <div class="label-block">
                                    <label for="text">Обязанности, требования, условия <span>*</span></label>
                                    <div id="standalone-container">
                                        <div id="toolbar">
                                        </div>
                                        <div id="editor"><?php echo $jo['text'] ?></div>
                                        <textarea style="display: none" name="text" id="editor-area" cols="30" rows="10"><?php echo $jo['text'] ?></textarea>
                                    </div>
                                    <!--<textarea <? if (isset($err['text'])) { ?> class="errors" <? } ?> name="text" id="text" cols="30" rows="5" value="<?php echo $_POST['text'] ?>"><?php echo $_POST['text'] ?></textarea>-->
                                    <span class="empty e-text">Введите текст</span>
                                </div>

                                <div class="label-block flex-label-block" style="margin: 0 0 6px 0;">
                                    <label for="salary">Зарплата <span>*</span></label>
                                    <div class="lb-column">
                                        <div class="lb-block">
                                            <span class="lb-start">от</span>
                                            <input <? if ($jo['salary'] <= 0 && $jo['salary_end'] <= 0) { ?> disabled <? } ?> <? if (isset($err['salary'])) { ?> class="errors" <? } ?> id="salary" type="number" class="salary" name="salary" <? if ($jo['salary'] > 0) { ?> value="<?php echo $jo['salary'] ?>" <? } ?>/>
                                            <span class="lb-center">до</span>
                                            <input <? if ($jo['salary'] <= 0 && $jo['salary_end'] <= 0) { ?> disabled <? } ?> <? if (isset($err['salary'])) { ?> class="errors" <? } ?> id="salary_end" type="number" class="salary_end" name="salary_end" <? if ($jo['salary_end'] > 0) { ?> value="<?php echo $jo['salary_end'] ?>" <? } ?>>
                                            <span class="lb-in">руб.</span>
                                        </div>
                                    </div>
                                    <span class="empty e-salary">Введите зарплату</span>
                                </div>
                                <div class="label-b-check">
                                    <input <? if ($jo['salary'] <= 0 && $jo['salary_end'] <= 0) { ?> checked <? } ?> type="checkbox" class="custom-checkbox" id="q1" name="salary_dog" value="1">
                                    <label for="q1">
                                        с договорной зарплатой
                                    </label>
                                </div>

                                <div class="label-block">
                                    <label for="category">Сфера деятельности <span>*</span></label>
                                    <div class="label-select-block">
                                        <select name="category" id="category" <? if (isset($err['category'])) { ?> class="errors" <? } ?>>
                                            <option value="<?php echo $jo['category'] ?>"><?php echo $jo['category'] ?></option>
                                            <?php
                                            $sqlc = $app->query("SELECT * FROM `category`");
                                            while ($c = $sqlc->fetch()) {
                                                ?>
                                                <option value="<?php echo $c['name'] ?>"><?php echo $c['name'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="label-arrow">
                                            <i class="mdi mdi-chevron-down"></i>
                                        </div>
                                    </div>
                                    <span class="empty e-category">Выберите сферу деятельности</span>
                                </div>




                                <div class="flex f-n">
                                    <div class="label-block au-fn au-fn-1">
                                        <label for="exp">Опыт работы в сфере <span>*</span></label>
                                        <div class="label-select-block">
                                            <select name="exp" id="exp" <? if (isset($err['exp'])) { ?> class="errors" <? } ?>>
                                                <?php
                                                $exp = ['Не важно', 'Без опыта', '1-3 года', '3-6 лет', 'Более 6 лет'];

                                                if (isset($jo['exp'])) {
                                                    foreach ($exp as $key) {
                                                        if ($jo['exp'] == $key) {
                                                            echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                        } else {
                                                            echo '<option value="'.$key.'">'.$key.'</option>';
                                                        }
                                                    }
                                                } else {
                                                    foreach ($exp as $key) {
                                                        echo '<option value="'.$key.'">'.$key.'</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="label-arrow">
                                                <i class="mdi mdi-chevron-down"></i>
                                            </div>
                                        </div>
                                        <span class="empty e-exp">Выберите опыт работы</span>
                                    </div>

                                    <div class="label-block au-fn">
                                        <label for="degree">Образование <span>*</span></label>
                                        <div class="label-select-block">
                                            <select name="degree" id="degree">
                                                <?php
                                                $degree = ['Не важно', 'Среднее профессиональное', 'Высшее', 'Бакалавр', 'Магистр'];

                                                if (isset($jo['degree'])) {
                                                    foreach ($degree as $key) {
                                                        if ($jo['degree'] == $key) {
                                                            echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                        } else {
                                                            echo '<option value="'.$key.'">'.$key.'</option>';
                                                        }
                                                    }
                                                } else {
                                                    foreach ($degree as $key) {
                                                        echo '<option value="'.$key.'">'.$key.'</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="label-arrow">
                                                <i class="mdi mdi-chevron-down"></i>
                                            </div>
                                        </div>
                                        <span class="empty e-degree">Введите образование</span>
                                    </div>
                                </div>

                                <div class="flex f-n">
                                    <div class="label-block au-fn au-fn-1">
                                        <label for="">График работы <span>*</span></label>
                                        <div class="label-select-block">
                                            <select name="time" id="time">
                                                <?php
                                                $time = ['Полный рабочий день', 'Гибкий график', 'Сменный график', 'Ненормированный рабочий день', 'Вахтовый метод', 'Неполный рабочий день'];

                                                if (isset($jo['time'])) {
                                                    foreach ($time as $key) {
                                                        if ($jo['time'] == $key) {
                                                            echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                        } else {
                                                            echo '<option value="'.$key.'">'.$key.'</option>';
                                                        }
                                                    }
                                                } else {
                                                    foreach ($time as $key) {
                                                        echo '<option value="'.$key.'">'.$key.'</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="label-arrow">
                                                <i class="mdi mdi-chevron-down"></i>
                                            </div>
                                        </div>
                                        <span class="empty e-time">Введите график работы</span>
                                    </div>


                                    <div class="label-block au-fn">
                                        <label for="job_type">Тип занятости <span>*</span></label>
                                        <div class="label-select-block">
                                            <select name="job_type" id="job_type" <? if (isset($err['job_type'])) { ?> class="errors" <? } ?>>
                                                <?php
                                                $job_type = ['Полная занятость', 'Частичная занятость', 'Временная', 'Стажировка', 'Сезонная', 'Удаленная'];

                                                if (isset($jo['type'])) {
                                                    foreach ($job_type as $key) {
                                                        if ($jo['type'] == $key) {
                                                            echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                        } else {
                                                            echo '<option value="'.$key.'">'.$key.'</option>';
                                                        }
                                                    }
                                                } else {
                                                    foreach ($job_type as $key) {
                                                        echo '<option value="'.$key.'">'.$key.'</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="label-arrow">
                                                <i class="mdi mdi-chevron-down"></i>
                                            </div>
                                        </div>
                                        <span class="empty e-job_type">Выберите тип занятости</span>
                                    </div>

                                </div>



                                <div class="label-b-check">
                                    <input <?php if ($jo['invalid'] == 1) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="q2" name="invalid" value="1">
                                    <label for="q2">
                                        для людей с инвалидностью
                                    </label>
                                </div>
                                <div class="label-b-check">
                                    <input <?php if ($jo['go'] == 1) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="q3" name="per" value="1">
                                    <label for="q3">
                                        поможем с переездом
                                    </label>
                                </div>

                                <div class="label-b-check">
                                    <input <?php if ($jo['email-d'] == 1) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="q4" name="email-d" value="1">
                                    <label for="q4">
                                        отправлять информацию об откликах на почту
                                    </label>
                                </div>

                                <div class="label-block">
                                    <label for="degree">Ключевые навыки</label>
                                    <div class="label-select-block">
                                        <div class="skills-form rsk-p">
                                            <input style="display:none" type="text" name="countSkills" class="countSkills" value="">
                                            <div class="skills-box">

                                            </div>
                                        </div>
                                        <div class="skills-bth">
                                            <input style="max-width: 360px;border-right: 0;border-radius: 4px 0 0 4px" class="skills-input" type="text" placeholder="Навык">
                                            <button type="button"><i class="mdi mdi-plus"></i></button>
                                        </div>
                                    </div>
                                </div>




                                <div class="captcha" style="margin: 0;">
                                    <div class="captcha__image-reload">
                                        <img class="captcha__image" src="/scripts/captcha" width="132" alt="captcha">
                                        <button type="button" class="captcha__refresh"><i class="mdi mdi-refresh"></i></button>
                                    </div>
                                    <div style="margin: 0 0 20px" class="captcha__group">
                                        <label for="captcha">Код, изображенный на картинке <span>*</span></label>
                                        <input type="text" name="captcha" id="captcha">
                                        <span class="empty e-captcha">Код неверный или устарел</span>
                                    </div>
                                </div>









                            </div>
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </section>
</main>

<?php require('template/more/profileFooter.php'); ?>

<script language="JavaScript" src="/static/scripts/job.js?v=<?= date('YmdHis') ?>"></script>

<script>
    (function ($) {

        'use strict';


        $(document).ready(function () {

            $('#q1').on('click', function () {
                let c = document.querySelector('#q1')
                if (c.checked) {
                    $('.salary').val('')
                    $('.salary_end').val()
                    $('.salary').attr('disabled', 'true')
                    $('.salary_end').attr('disabled', 'true')
                } else {
                    $('.salary').removeAttr('disabled')
                    $('.salary_end').removeAttr('disabled')
                }


            })

            $('.preview-resume').on('click', function () {
                const date = $('#date').val(),
                    title = $('#title').val(),
                    salary = $('#salary').val(),
                    salary_end = $('#salary_end').val(),
                    q1 = $('#q1').val(),
                    urid = $('#urid').val(),
                    regin = $('#region').val(),
                    contact = $('#username').val(),
                    tel = $('#tel').val(),
                    email = $('#email').val(),
                    text = $('#text').val(),
                    exp = $('#exp').val(),
                    time = $('#time').val(),
                    type = $('#job_type').val(),
                    category = $('#category').val(),
                    degree = $('#degree').val(),
                    duties = $('#duties').val(),
                    requirements = $('#requirements').val(),
                    terms = $('#terms').val(),
                    note = $('#note').val()
                let address = ''
                if ($('#address').val()) {
                    address = $('#address').val();
                }
                let salary_start = ''
                if (salary > 0 && salary_end > 0) {
                    salary_start = `от ${salary} до ${salary_end}`
                } else if (salary > 0 && (salary_end == '' || salary_end <= 0)) {
                    salary_start = `от ${salary}`
                } else if ((salary == '' || salary <= 0) && salary_end > 0) {
                    salary_start = `до ${salary_end}`
                } else {
                    salary_start = 'договорная';
                }
                let degree_start = '';
                if (!degree || degree === 'Не указано') {
                    degree_start = 'Не указано'
                } else {
                    degree_start = degree
                }
                let date_now = new Date();
                let output = String(date_now.getDate()).padStart(2, '0') + '.' + String(date_now.getMonth() + 1).padStart(2, '0') + '.' + date_now.getFullYear();
                $('.profile-body').append(`
                <div id="preview_back" style="display:flex">
                    <div class="preview-wrapper" style="display:block">
                        <div class="container" style="display:block">
                            <div class="preview-title">
                                Предпросмотр вакансии
                                <i class="mdi mdi-close form-detete" onclick=" document.querySelector('#preview_back').remove();"></i>
                            </div>
                            <div class="preview-content">
                                <div class="job-detail-block">
                                    <div class="job-d-left">
                                        <div class="job-d-title job-d">
                                            <div class="job-d-name">
                                            Вакансия - ${title}
                                            </div>
                                            <div class="job-d-date">
                                                <span><i class="icon-location-pin"></i> ${regin}, ${address}, ${urid}</span>
                                                <span><i class="icon-clock"></i> опубликовано: ${output}</span>
                                                <span><i class="icon-eye"></i> 0 просмотров</span>
                                            </div>
                                        </div>
                                        <div class="job-d-content job-d">
                                            <div class="job-d-tags">
                                                <ul>
                                                    <li>
                                                        <div class="ji-l"><i class="mdi mdi-currency-rub"></i></div>
                                                        <div class="ji-r">
                                                            <span>Зарплата</span>
                                                            <span>${salary_start}</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="ji-l"><i class="icon-calendar"></i></div>
                                                        <div class="ji-r">
                                                            <span>График работы</span>
                                                            <span>${time}</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="ji-l"><i class="icon-clock"></i></div>
                                                        <div class="ji-r">
                                                            <span>Тип занятости</span>
                                                            <span>${type}</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="ji-l"><i class="icon-briefcase"></i></div>
                                                        <div class="ji-r">
                                                            <span>Опыт работы</span>
                                                            <span>${exp}</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="ji-l"><i class="icon-graduation"></i></div>
                                                        <div class="ji-r">
                                                            <span>Образование</span>
                                                            <span>${degree_start}</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="job-about job-bag">
                                                <span>О работе</span>
                                                <div>
                                                    <pre class="text-content-job">${text}</pre>
                                                </div>
                                            </div>
                                            <div class="job-duties job-bag">
                                                <span>Обязанности:</span>
                                                <div>
                                                    <pre class="text-content-job">${duties}</pre>
                                                </div>
                                            </div>
                                            <div class="job-requirements job-bag">
                                                <span>Требования к сотруднику:</span>
                                                <div>
                                                    <pre class="text-content-job">${requirements}</pre>
                                                </div>
                                            </div>
                                            <div class="job-terms job-bag">
                                                <span>Условия труда:</span>
                                                <div>
                                                    <pre class="text-content-job">${terms}</pre>
                                                </div>
                                            </div>
                                            <div class="job-note job-bag">
                                                <div>
                                                    <pre class="text-content-job">${note}</pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="job-d-right">
                                        <div class="job-d-company job-d">
                                            <div class="jc-img">
                                                <span>
                                                    <img src="/static/image/company/<?php echo $r['img'] ?>" alt="">
                                                </span>
                                                <a href="company?id=<?php echo $r['id'] ?>">
                                                    <?php echo $r['name'] ?>
                                                </a>
                                            </div>
                                            <div class="job-active">
                                                <span>Вакансия активна до</span>
                                                <p>${date.replace(/(\d+)\-(\d+)\-(\d+)/, '$3.$2.$1')}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `)
            })


        });

    })(jQuery, window, document);
</script>

<script>
    (function ($) {
        $(document).ready(function () {
            $('.select2-area').select2({
                placeholder: "Выберите район",
                maximumSelectionLength: 2,
                language: "ru"
            });
            $('.select2-address').select2({
                placeholder: "Выберите населённый пункт",
                maximumSelectionLength: 2,
                language: "ru"
            });
            $('.select2-area').on('change', function () {
                $('.profile-city label').remove();
                $('.profile-city .label-select-block').remove();
                document.querySelector('.profile-city').innerHTML += '<label for="address">Населённый пункт <span>*</span></label>'
                document.querySelector('.profile-city').innerHTML += `
                            <div class="label-select-block">
                                 <select class="select2-address" id="address" name="address" placeholder="Выберите населённый пункт">
                                    <option></option>
                                 </select>
                                <div class="label-arrow">
                                    <i class="mdi mdi-chevron-down"></i>
                                </div>
                            </div>
                            <span class="empty e-address">Выберите населённый пункт</span>
                            `
                let rx = $('.select2-area').val();
                let data = district['Северо-Кавказский федеральный округ']['Ставропольский край'][rx];
                for (let key in data) {
                    document.querySelector('.select2-address').innerHTML += `<option value="${data[key]}">${data[key]}</option`
                }
                $('.select2-address').select2({
                    placeholder: "Выберите населённый пункт",
                    maximumSelectionLength: 2,
                    language: "ru"
                });
            });
        })
    })(jQuery)
</script>


</body>
</html>
<?php
} else {
    $app->notFound();
}
?>
