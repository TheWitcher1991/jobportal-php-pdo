<?php
if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

    if ($_SESSION['type'] == 'admin') {
        $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($a['id'])) {
            $app->notFound();
        }
    }



    /*if (isset($_POST["create-job"])) {
        $err = array();

        if (empty($_POST['date'])) $err['date'] = 'Укажите дату закрытыя вакансии';
        if (empty($_POST['title']) || trim($_POST['title']) == '') $err['title'] = 'Укажите загаловок';
        if (empty($_POST['region']) || trim($_POST['region']) == '') $err['region'] = 'Укажите регион';
        if (empty($_POST['username']) || trim($_POST['username']) == '') $err['username'] = 'Укажите контактное лицо';
        if (empty($_POST['phone']) || trim($_POST['phone']) == '') $err['phone'] = 'Укажите телефон';
        if (empty($_POST['email']) || trim($_POST['email']) == '') $err['email'] = 'Укажите email';
        if (empty($_POST['phone']) || trim($_POST['phone']) == '') $err['phone'] = 'Укажите телефон';
        if (empty($_POST['text']) || trim($_POST['text']) == '') $err['text'] = 'Введите информацию';
        if (empty($_POST['exp']) || trim($_POST['exp']) == '') $err['exp'] = 'Укажите опыт работы';
        if (empty($_POST['time']) || trim($_POST['time']) == '') $err['time'] = 'Укажите график работы';
        if (empty($_POST['job_type']) || trim($_POST['job_type']) == '') $err['job_type'] = 'Укажите тип занятости';
        if (empty($_POST['category']) || trim($_POST['category']) == '') $err['category'] = 'Укажите сферу деятельности';


        if (empty($err)) {
            $title = XSS_DEFENDER($_POST['title']);
            $text = preg_replace("'<script[^>]*?>.*?</script>'si", "", $_POST['text']);
            $text = str_replace($xss, "", $text);
            $category = XSS_DEFENDER($_POST['category']);
            $del = XSS_DEFENDER($_POST['date']);
            $username = XSS_DEFENDER($_POST['username']);
            $phone = XSS_DEFENDER($_POST['phone']);
            $email = XSS_DEFENDER($_POST['email']);
            $region = XSS_DEFENDER($_POST['region']);
            $address = XSS_DEFENDER($_POST['address']);
            $salary = XSS_DEFENDER($_POST['salary']);
            $salary_end = XSS_DEFENDER($_POST['salary_end']);
            $time = XSS_DEFENDER($_POST['time']);
            $exp = XSS_DEFENDER($_POST['exp']);
            $job_type = XSS_DEFENDER($_POST['job_type']);
            $dog = $_POST['salary_dog'];
            if ($dog == 1) {
                $salary = '';
                $salary_end = '';
            } else {
                $salary = (int)XSS_DEFENDER($_POST['salary']);
                $salary_end = (int)XSS_DEFENDER($_POST['salary_end']);
            }
            if ($_POST['urid']) {
                $urid = $_POST['urid'];
            } else {
                $urid = 'none';
            }
            $degree = '';
            if ($_POST['degree']) {
                $degree = XSS_DEFENDER($_POST['degree']);
            } else {
                $degree = '';
            }
            $status = $_POST['invalid'];
            if ($status == 1) {
                $status = 1;
            } else {
                $status = 0;
            }
            $go = $_POST['per'];
            if ($go == 1) {
                $go = 1;
            } else {
                $go = 0;
            }

            if (isset($_POST['area'])) {
                $area = $_POST['area'];
                $ar = $reg = $app->fetch("SELECT * FROM `map_list` WHERE `name` = :d",
                    [
                        ':d' => $_POST['area']
                    ]
                );
                $app->execute("UPDATE `map_list` SET `job` = `job` + 1 WHERE `id` = :id", [
                    ':id' => $ar['id']
                ]);
            } else {
                $area = '';
            }

            if (isset($_POST['name_2']) and empty($_POST['name_1'])) {
                $company = $_POST['name_2'];
                $r = $app->fetch("SELECT * FROM `company` WHERE `name` = :n", [':n' => $company]);
                $num = (int) $r['job'] + 1;
                $app->execute("UPDATE `company` SET `job` = `job` + 1 WHERE `id` = :i", [
                    ':i' => $r['id']
                ]);
                $id = $r['id'];
            } else {
                $company = $_POST['name_1'];
                $id = 0;
            }

            $city_add = $app->fetch("SELECT * FROM `map_list` WHERE `name` = :d", [':d' => $address]);
            if ($city_add['id']) {
                $app->execute("UPDATE `map_list` SET `job` = `job` + 1 WHERE `id` = :id", [
                    ':id' => $city_add['id']
                ]);
            }

            $c = $app->fetch("SELECT * FROM `category` WHERE `name` = :n", [':n' => $_POST['category']]);

            $hour = date("H:i");

            $countS = (int) trim($_POST['countSkills']);

            $c = $app->fetch("SELECT * FROM `category` WHERE `name` = :n", [':n' => $_POST['category']]);

            $reg = $app->fetch("SELECT * FROM `map_list` WHERE `name` = :d", [':d' => $_POST['region']]);

            $app->execute("INSERT INTO `vacancy` (`go`, `times`, `timses`, `contact`, `salary_end`, `title`, `category_id`, `degree`, `area`, `type`, `invalid`, `company`, `task`, `text`, `date`, `time`, `region`, `district`, `address`, `phone`, `email`, `category`, `company_id`, `img`, `salary`, `exp`, `urid`)
            VALUES(:goo, NOW(), :tims, :contc, :saled, :t, :ccs, :deg, :ar, :jb, :inv, :cd, :tas, :cnt, :d, :tim, :reg, :dist, :addres, :phone, :email, :category, :c_i, :im, :sal, :exp, :urid)", [
                ':goo' => $go,
                ':tims' => $hour,
                ':contc' => $username,
                ':saled' => $salary_end,
                ':t' => $title,
                ':ccs' => $c['id'],
                ':deg' => $degree,
                ':ar' => $area,
                ':jb' => $job_type,
                ':inv' => $status,
                ':cd' => $company,
                ':tas' => $del,
                ':cnt' => $text,
                ':d' => $Date,
                ':tim' => $time,
                ':reg' => $reg['name'],
                ':dist' => $reg['map_name'],
                ':addres' => $address,
                ':phone' => $phone,
                ':email' => $email,
                ':category' => $category,
                ':c_i' => $id,
                ':im' => 'placeholder.png',
                ':sal' => $salary,
                ':exp' => $exp,
                ':urid' => $urid
            ]);


            $app->execute("UPDATE `map_list` SET `job` = `job` + 1 WHERE `id` = :id", [
                ':id' => $reg['id']
            ]);

            $app->execute("UPDATE `map` SET `job` = `job` + 1 WHERE `id` = :id", [
                ':id' => $reg['map_id']
            ]);

            $app->execute("UPDATE `category` SET `job` = `job` + 1 WHERE `name` = :i", [
                ':i' => $c['name']
            ]);



            exit("<meta http-equiv='refresh' content='0; url= /admin/jobs-list'>");
        }
    }*/

    Head('Разместить вакансию');
    ?>

    <body class="profile-body">



    <main class="wrapper wrapper-profile" id="wrapper">


        <?php require('admin/template/adminAside.php'); ?>

        <section class="profile-base">

            <?php require('admin/template/adminHeader.php'); ?>

            <div class="profile-content admin-content">

                <div class="section-nav-profile">
                    <span><a href="/analysys">Кабинет</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a href="/jobs-add">Добавить вакансию</a></span>
                </div>

                <div class="errors-block">

                </div>

                <div class="create-resume-data profile-data">
                    <form role="form" class="form-create-job" method="POST">
                        <div class="resume-bth">
                            <input class="preview-resume" type="button" value="Предпросмотр">
                            <button type="button" name="create-job" class="create-job">Разместить</button>
                        </div>
                        <div class="resume-form-block">
                            <div class="job-main-info">
                                <span class="pff-t">Основная информация</span>
                                <div class="res-inp-b">
                                    <div class="flex f-n">
                                        <div class="label-block au-fn au-fn-1">
                                            <label for="">Название компании</label>
                                            <input type="text" name="name_1" placeholder="">
                                            <span class="empty e-company">Введите название</span>
                                        </div>
                                        <span class="label-flex-span">Либо</span>
                                        <div class="label-block au-fn au-fn-2">
                                            <label for="">Выберите компанию</label>
                                            <div class="label-select-block">
                                                <select  class="company-list-select" name="name_2">
                                                    <option value="">Выбрать</option>
                                                    <?php
                                                    $sqlc = $app->query("SELECT * FROM `company`");
                                                    while ($c = $sqlc->fetch()) {
                                                        ?>
                                                        <option value="<?php echo $c['id'] ?>"><?php echo $c['name'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div class="label-arrow">
                                                    <i class="mdi mdi-chevron-down"></i>
                                                </div>
                                            </div>
                                            <span class="empty e-company">Введите название</span>
                                        </div>
                                    </div>


                                    <div class="label-block">
                                        <label for="title">Название вакансии <span>*</span></label>
                                        <input <? if (isset($err['title'])) { ?> class="errors" <? } ?> type="text" id="title" name="title" placeholder="" value="<?php echo $_POST['title'] ?>">
                                        <span class="empty e-title">Введите название</span>
                                    </div>



                                    <div class="flex f-n">
                                        <div class="label-block au-fn au-fn-1">
                                            <label for="date">Ожидаемая дата закрытия <span>*</span></label>
                                            <input <? if (isset($err['date'])) { ?> class="errors" <? } ?> type="date" id="date" name="date" min="<?php echo date("Y-m-d", time() + 1 * 24 * 60 * 60); ?>" value="<?php echo date('Y-m-d', time() + 31 * 24 * 60 * 60); ?>"
                                                                                                           max="<?php echo date('Y-m-d', time() + 562 * 24 * 60 * 60); ?>">

                                            <span class="empty e-date">Укажите дату закрытия</span>
                                            <span class="empty e-z-date">Укажите дату закрытия</span>
                                        </div>



                                        <div class="label-block au-fn">
                                            <label for="email">E-mail <span>*</span></label>
                                            <input <? if (isset($err['email'])) { ?> class="errors" <? } ?> type="email" id="email" name="email" placeholder="" value="">
                                            <span class="empty e-email">Введите email</span>
                                        </div>
                                    </div>

                                    <div class="flex f-n">
                                        <div class="label-block au-fn au-fn-1">
                                            <label for="tel">Телефон <span>*</span></label>
                                            <input <? if (isset($err['phone'])) { ?> class="errors" <? } ?> type="text" id="tel" name="phone" placeholder="+7 (999) 999-99-99" value="<?php echo $r['phone'] ?>">
                                            <span class="empty e-phone">Введите телефон</span>
                                        </div>

                                        <div class="label-block au-fn">
                                            <label for="username">Контактное лицо</label>
                                            <input <? if (isset($err['username'])) { ?> class="errors" <? } ?> type="text" id="username" name="username" value="<?php echo $r['username'] ?>" placeholder="">
                                            <span class="empty e-username">Введите контактное лицо</span>
                                        </div>
                                    </div>

                                    <div class="label-block">
                                        <label for="region">Регион <span>*</span></label>
                                        <div class="label-select-block">
                                            <select  class="select2-region <? if (isset($err['region'])) { ?> errors <? } ?>" id="region" name="region" placeholder="Выберите регион">
                                                <option value=""></option>
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

                                    </div>

                                    <div class="label-block profile-city">

                                    </div>

                                    <div class="label-block">
                                        <label for="urid">Юридический адрес</label>
                                        <input type="text" id="urid" name="urid" placeholder="" value="<?php echo $_POST['urid'] ?>">
                                    </div>

                                    <div class="label-block">
                                        <label for="text">Обязанности, требования, условия <span>*</span></label>
                                        <div id="standalone-container">
                                            <div id="toolbar">
                                            </div>
                                            <div id="editor">
                                                <p><strong>Обязанности:</strong></p><ol><li><br></li><li><br></li></ol><p><br></p><p><strong>Требования:</strong></p><ol><li><br></li><li><br></li></ol><p><br></p><p><strong> Условия:</strong></p><ol><li><br></li><li><br></li></ol><p><br></p>
                                            </div>
                                            <textarea style="display: none" name="text" id="editor-area" cols="30" rows="10"></textarea>
                                        </div>
                                        <!--<textarea <? if (isset($err['text'])) { ?> class="errors" <? } ?> name="text" id="text" cols="30" rows="5" value="<?php echo $_POST['text'] ?>"><?php echo $_POST['text'] ?></textarea>-->
                                        <span class="empty e-text">Введите текст</span>
                                    </div>

                                    <div class="label-block flex-label-block" style="margin: 0 0 6px 0;">
                                        <label for="salary">Зарплата <span>*</span></label>
                                        <div class="lb-column">
                                            <div class="lb-block">
                                                <span class="lb-start">от</span>
                                                <input <? if (isset($err['salary'])) { ?> class="errors" <? } ?> id="salary" type="number" class="salary" name="salary" value="<?php echo $_POST['salary'] ?>">
                                                <span class="lb-center">до</span>
                                                <input <? if (isset($err['salary'])) { ?> class="errors" <? } ?> id="salary_end" type="number" class="salary_end" name="salary_end" value="<?php echo $_POST['salary_end'] ?>">
                                                <span class="lb-in">руб.</span>
                                            </div>
                                        </div>
                                        <span class="empty e-salary">Введите зарплату</span>
                                    </div>
                                    <div class="label-b-check">
                                        <input type="checkbox" class="custom-checkbox" id="q1" name="salary_dog" value="1">
                                        <label for="q1">
                                            с договорной зарплатой
                                        </label>
                                    </div>

                                    <div class="label-block ">
                                        <label for="category">Сфера деятельности <span>*</span></label>
                                        <div class="label-select-block">
                                            <select name="category" id="category" <? if (isset($err['category'])) { ?> class="errors" <? } ?>>
                                                <option value="">Выбрать</option>
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

                                                    if (isset($_POST['exp'])) {
                                                        foreach ($exp as $key) {
                                                            if ($_POST['exp'] == $key) {
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
                                                    $degree = ['Не важно', 'Среднее профессиональное', 'Высшее', 'Бакалавр', 'Магистр', 'Специалитет'];

                                                    if (isset($_POST['degree'])) {
                                                        foreach ($degree as $key) {
                                                            if ($_POST['degree'] == $key) {
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

                                                    if (isset($_POST['time'])) {
                                                        foreach ($time as $key) {
                                                            if ($_POST['time'] == $key) {
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

                                                    if (isset($_POST['job_type'])) {
                                                        foreach ($job_type as $key) {
                                                            if ($_POST['job_type'] == $key) {
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
                                            <? if (isset($err['job_type'])) { ?> <span class="error"><? echo $err['job_type']; ?></span> <? } ?>
                                            <span class="empty e-job_type">Выберите тип занятости</span>
                                        </div>

                                    </div>



                                    <div class="label-b-check">
                                        <input type="checkbox" class="custom-checkbox" id="q2" name="invalid" value="1">
                                        <label for="q2">
                                            для людей с инвалидностью
                                        </label>
                                    </div>
                                    <div class="label-b-check">
                                        <input type="checkbox" class="custom-checkbox" id="q3" name="per" value="1">
                                        <label for="q3">
                                            поможем с переездом
                                        </label>
                                    </div>



                            </div>
                        </div>
                    </form>
                </div>


            </div>




        </section>

    </main>

    <div class="errors-block-fix"></div>


    <?php require('admin/template/adminFooter.php'); ?>

    <script>
        (function ($) {

            'use strict';

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



            function _getData() {
                $.ajax({
                    url: '/admin/admin-js',
                    data: `${$('.form-create-job').serialize()}&MODULE_CREATE_JOB=1`,
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    error: (response) => {
                        MessageBox('Произошла ошибка. Повторите')
                        $('.create-job').html('Разместить')
                        document.querySelector('.create-job').removeAttribute('disabled')
                        console.log(response)
                    },
                    success: function (responce) {
                        if (responce.code === 'validate_error') {
                            let $arr = responce.error
                            for (let i in $arr) {
                                if (i === 'region') $('span[aria-controls="select2-region-container"]').css({
                                    'border': '1px solid #ff4c4c',
                                    'background': 'rgba(255,22,46,.06)'
                                })
                                if (i === 'address') $('span[aria-controls="select2-address-container"]').css({
                                    'border': '1px solid #ff4c4c',
                                    'background': 'rgba(255,22,46,.06)'
                                })
                                if (i === 'area') $('span[aria-controls="select2-area-container"]').css({
                                    'border': '1px solid #ff4c4c',
                                    'background': 'rgba(255,22,46,.06)'
                                })
                                if (i === 'text') {
                                    $('.ql-container.ql-snow, .ql-toolbar.ql-snow').css('border', '1px solid #ff4c4c')
                                    $('.ql-toolbar.ql-snow + .ql-container.ql-snow').css('border-top', '0')
                                }
                                $(`#${i}`).addClass('errors');
                                $(`.e-${i}`).show()
                            }
                            $('.create-job').html('Разместить')
                            document.querySelector('.create-job').removeAttribute('disabled')
                            MessageBox('Ошибка валидации')
                        } else {
                            if (responce.code === 'success') {
                                $('.form-create-job')[0].reset()
                                $('.create-job').html('Разместить')
                                document.querySelector('.create-job').removeAttribute('disabled')
                                MessageBox('Публикуем...')
                                window.location.href = '/admin/jobs-list';
                            } else {
                                MessageBox('Произошла ошибка. Повторите')
                                console.log(responce)
                                $('.create-job').html('Разместить')
                                document.querySelector('.create-job').removeAttribute('disabled')
                            }
                        }


                    }})
            }



            $('.create-job').on('click', function (e) {
                e.preventDefault()
                $('#editor-area').val(quill.root.innerHTML)
                $('.empty').fadeOut(50)
                $('select').removeClass('errors')
                $('input').removeClass('errors')
                $('.label-block .select2-container--default .select2-selection--single').css({
                    'border': '1px solid #cdd0d5',
                    'background': '#ffffff'
                })
                $('.create-job').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
                $('.create-job').attr('disabled', 'true')
                _getData()
            })




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
                        q2 = document.querySelector('#q2'),
                        q3 = document.querySelector('#q3')
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
                                            Вакансия - ${title.trim() === '' ? 'ЗАГОЛОВОК' : title}
                                            </div>
                                            <div class="job-d-date">
                                                <span><i class="icon-location-pin"></i>
                                                 ${urid.trim() === '' && regin.trim() === '' ? 'РЕГИОН; ГОРОД; АДРЕС' : `${regin}; ${address}; ${urid}`}

                                                </span>
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
                                                <div class="addi">
                                                ${q1.checked ? '<span><i class="mdi mdi-wheelchair"></i> Доступна людям с инвалидностью</span>' : ''}
                                                ${q2.checked ? '<span><i class="mdi mdi-plane-car"></i> Поможем с переездом</span>' : ''}

                                                     ${urid.trim() !== '' ? '<span><i class="mdi mdi-map-marker-outline"></i> ${address}, ${urid} </span>' : ''}

                                                </div>

                                                <div>
                                                    <pre class="text-content-job">${$('.ql-editor').html()}</pre>
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
                                                <a>
                                                    КОМПАНИЯ
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

    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>