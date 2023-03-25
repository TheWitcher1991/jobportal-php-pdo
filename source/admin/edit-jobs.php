<?php
if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

    if ($_SESSION['type'] == 'admin') {
        $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($a['id'])) {
            $app->notFound();
        }
    }

    $sid = intval($_GET['id']);

    $jo = $app->fetch("SELECT * FROM `vacancy` WHERE `id` = :id", [
        ':id' => $sid
    ]);

    if (empty($jo['id'])) {
        $app->notFound();
    }

    Head('JOB: ' . $jo['title'] . ' - редактировать');
    ?>

    <body class="profile-body">



    <main class="wrapper wrapper-profile" id="wrapper">


        <?php require('admin/template/adminAside.php'); ?>

        <section class="profile-base">

            <div class="errors-block-fix">

            </div>



            <?php require('admin/template/adminHeader.php'); ?>

            <div class="profile-content admin-content">

                <div class="section-nav-profile">
                    <span><a href="/admin/analysys">Кабинет</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a href="/admin/jobs-list">Каталог вакансий</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a>  <?php echo $jo['title']; ?></a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a>Редактировать</a></span>
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

                                    <div class="block-status">

                                        <a target="_blank" href="/admin/info-jobs?id=<? echo $jo['id']; ?>">
                                            <i class="mdi mdi-finance"></i>
                                            Анализ </a>

                                        <a target="_blank" href="/admin/info-companys?id=<? echo $jo['company_id']; ?>">
                                            <i class="mdi mdi-briefcase-variant-outline"></i>
                                            <? echo $jo['company']; ?></a>

                                        <a target="_blank" href="/job?id=<? echo $jo['id']; ?>">
                                            <i class="mdi mdi-web"></i>
                                            Вакансия</a>


                                    </div>



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











                                </div>
                            </div>

                        </div>

                    </form>

                </div>

            </div>



        </section>

    </main>


    <?php require('admin/template/adminFooter.php'); ?>


    <script>


        'use strict';

        (function ($) {


            function _getEdit() {
                setTimeout(function () {
                    $.ajax({
                        url: '/admin/admin-js',
                        data: `${$('.form-edit-job').serialize()}&job=${$_GET['id']}&cid=${$_GET['act']}&MODULE_EDIT_JOB=1`,
                        type: 'POST',
                        cache: false,
                        dataType: 'json',
                        error: (response) => {
                            MessageBox('Ошибка')
                            $('.edit-job').html('Изменить')
                            document.querySelector('.edit-job').removeAttribute('disabled')
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
                                    $(`.e-${i}`).fadeIn(50)
                                }
                                $('.edit-job').html('Изменить')
                                document.querySelector('.edit-job').removeAttribute('disabled')
                                MessageBox('Ошибка валидации')
                            } else {
                                if (responce.code === 'success') {
                                    MessageBox('Изменения внесены')
                                    $('.edit-job').html('Изменить')
                                    document.querySelector('.edit-job').removeAttribute('disabled')
                                } else {
                                    _catalogError(responce)
                                    $('.edit-job').html('Изменить')
                                    document.querySelector('.edit-job').removeAttribute('disabled')
                                }
                            }


                        }})
                }, 500)



            }

            $('.edit-job').on('click', function (e) {
                e.preventDefault()
                $('#editor-area').val(quill.root.innerHTML)
                $('.empty').fadeOut(50)
                $('select').removeClass('errors')
                $('input').removeClass('errors')
                $('.label-block .select2-container--default .select2-selection--single').css({
                    'border': '1px solid #cdd0d5',
                    'background': '#ffffff'
                })
                $('.edit-job').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
                $('.edit-job').attr('disabled', 'true')
                _getEdit()

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