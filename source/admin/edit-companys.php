<?php
if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

    if ($_SESSION['type'] == 'admin') {
        $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($a['id'])) {
            $app->notFound();
        }
    }

    $sid = intval($_GET['id']);

    $rc = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [
        ':id' => $sid
    ]);

    if (empty($rc['id'])) {
        $app->notFound();
    }

    Head($rc['name'] . ' - редактировать');
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
                    <span><a href="/admin/companys-list">Каталог компаний</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a>  <?php echo $rc['name']; ?></a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a>Редактировать</a></span>
                </div>

                <div class="manage-resume-data">

                    <?php

                    $sth = $PDO->prepare("SELECT * FROM `review` WHERE `company_id` = ?");
                    $sth->execute(array((int) $rc['id']));
                    $data = $sth->fetchAll(PDO::FETCH_ASSOC);
                    $count = count($data);

                    if ($count > 0) {
                        $rating = 0;
                        foreach ($data as $row) {
                            $rating += $row['rating'];
                        }
                        $rating = $rating / $count;
                    } else {
                        $rating = 0;
                    }



                    ?>

                    <div class="al-stats" style="margin: 0 0 30px 0;">
                        <ul>
                            <li>
                                <div class="as-t">
                                    <span class="as-tt"><?php echo $rc['job'] ?></span>
                                    <span class="as-tk">Вакансии</span>
                                </div>
                                <div class="as-i"><i class="mdi mdi-database-check-outline"></i></div>

                            </li>
                            <li>
                                <div class="as-t">
                                    <span class="as-tt"><?php echo $app->rowCount("SELECT * FROM `respond` WHERE `company_id` = :id", [':id' => $rc['id']]) ?></span>
                                    <span class="as-tk">Отклики</span>
                                </div>
                                <div class="as-i"><i class="mdi mdi-school-outline"></i></div>

                            </li>
                            <li>
                                <div class="as-t">
                                    <span class="as-tt"><?php echo $rating ?></span>
                                    <span class="as-tk">Рейтинг</span>
                                </div>
                                <div class="as-i"><i class="mdi mdi-star-outline"></i></div>

                            </li>
                            <li>
                                <div class="as-t">
                                    <span class="as-tt"><?php echo $count ?></span>
                                    <span class="as-tk">Отзывы</span>
                                </div>
                                <div class="as-i"><i class="mdi mdi-message-star-outline"></i></div>

                            </li>
                        </ul>
                    </div>


                    <div class="pr-data-block block-p bl-1">





                        <span>Данные компании</span>
                        <form role="form" class="form-profile" method="post">


                            <div class="block-status">

                                <a target="_blank" href="/admin/info-companys?id=<? echo $rc['id']; ?>">
                                    <i class="mdi mdi-information-outline"></i>
                                    Информация </a>

                                <a target="_blank" href="/admin/info-companys?id=<? echo $rc['id']; ?>&t=2">
                                    <i class="mdi mdi-database-export-outline"></i>
                                    Вакансии </a>

                                <a target="_blank" href="/admin/info-companys?id=<? echo $rc['id']; ?>&t=3">
                                    <i class="mdi mdi-school-outline"></i>
                                    Отклики </a>

                                <a target="_blank" href="/admin/info-companys?id=<? echo $rc['id']; ?>&t=4">
                                    <i class="mdi mdi-message-star-outline"></i>
                                    Отзывы </a>

                                <a target="_blank" href="/admin/info-companys?id=<? echo $rc['id']; ?>&t=5">
                                    <i class="mdi mdi-bell-ring-outline"></i>
                                    Подписчики </a>


                                <a target="_blank" href="/company?id=<? echo $rc['id']; ?>">
                                    <i class="mdi mdi-web"></i>
                                    Компания</a>

                            </div>


                         <!--   <h3>Логотип компании</h3>
                            <div class="pfa-a pfa-comp">
                                <div class="pfa-a-bth more-inf"><i class="mdi mdi-pencil"></i> Изменить</div>
                                <span>
                                <img src="/static/image/company/<?php echo $rc['img'] ?>" alt="">
                                <?php if ($rc['img'] != 'placeholder.png') { ?>
                                    <button type="submit" name="delete-logo-user"><span class="mdi mdi-window-close"></span></button>
                                <?php } ?>
                            </span>
                            </div>
                            <h3>Баннер компании</h3>
                            <div style="margin: 0 0 20px 0" class="pfb-a">
                                <div class="pfb-bth more-inf"><i class="mdi mdi-pencil"></i> <?php if (isset($rc['baner']) AND trim($rc['baner']) != '') echo 'Изменить'; else echo 'Добавить'; ?></div>
                                <?php if (isset($rc['baner']) AND trim($rc['baner']) != '') { ?>
                                    <div class="prof-baner">
                                        <img src="/static/image/company_banner/<?php echo $rc['baner'] ?>" alt="">
                                        <button type="submit" name="delete-logo-baner"><span class="mdi mdi-window-close"></span></button>
                                    </div>
                                <?php } ?>
                            </div> -->

                            <div class="flex f-n">
                                <div class="label-block au-fn au-fn-1">
                                    <label for="">Контактное лицо</label>
                                    <input type="text" id="username" name="username" value="<?php echo $rc['username'] ?>" placeholder="">
                                    <span class="empty e-username">Это поле не должно быть пустым</span>
                                </div>


                                <div class="label-block au-fn">
                                    <label for="">Телефон <span>*</span></label>
                                    <input  type="tel" id="tel" name="tel" value="<?php echo $rc['phone'] ?>" placeholder="">
                                    <span class="empty e-tel">Это поле не должно быть пустым</span>
                                </div>
                            </div>



                            <div class="flex f-n">
                                <div class="label-block au-fn au-fn-1">
                                    <label for="">ИНН Компании <span>*</span></label>
                                    <input type="number" id="inn" name="inn" value="<?php echo $rc['inn'] ?>" placeholder="">
                                    <span class="empty e-inn">Это поле не должно быть пустым</span>
                                </div>
                                <div class="label-block au-fn">
                                    <label class="" for="">Тип компании <span>*</span></label>
                                    <div class="label-select-block">
                                        <select id="type" name="type">
                                            <?php
                                            $job_type = ['Частная', 'Государственная', 'Смешанная', 'Кадровое агенство'];

                                            if (isset($rc['type'])) {
                                                foreach ($job_type as $key) {
                                                    if ($rc['type'] == $key) {
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
                                    <span class="empty e-type">Тип обязателен</span>
                                </div>
                            </div>
                            <div class="flex f-n">
                                <div class="label-block au-fn au-fn-1">
                                    <label for="name">Название <span>*</span></label>
                                    <input disabled type="text" value="<?php echo $rc['name'] ?>" placeholder="">


                                </div>
                                <div class="label-block au-fn">
                                    <label for="email">E-mail <span>*</span></label>
                                    <input disabled type="email" value="<?php echo $rc['email'] ?>" placeholder="">
                                </div>
                            </div>
                            <div class="flex f-n">
                                <div class="label-block au-fn  au-fn-1">
                                    <label for="">Город <span>*</span></label>
                                    <div class="label-select-block">
                                        <select <? if (isset($err['address'])) { ?> class="errors" <? } ?> name="address" id="address" placeholder="Выберите город">
                                            <?php

                                            if (isset($r['address'])) {
                                                foreach ($city as $key) {
                                                    if ($rc['address'] == $key) {
                                                        echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                    } else {
                                                        echo '<option value="'.$key.'">'.$key.'</option>';
                                                    }
                                                }
                                            } else {
                                                foreach ($city as $key) {
                                                    echo '<option value="'.$key.'">'.$key.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="label-arrow">
                                            <i class="mdi mdi-chevron-down"></i>
                                        </div>
                                    </div>
                                    <span class="empty e-address">Город обязателн</span>
                                </div>

                                <div class="label-block au-fn">
                                    <label for="email">Специализация</label>
                                    <input type="text" name="specialty" id="specialty" value="<?php echo $rc['specialty'] ?>">

                                </div>



                            </div>

                            <div class="label-block">
                                <label for="about">О компании</label>
                                <textarea name="about" id="about" id="about" cols="30" rows="5"><?php echo $rc['about'] ?></textarea>
                            </div>

                            <div class="flex f-n">
                                <div class="label-block au-fn au-fn-1">
                                    <label for="">Количество работников</label>
                                    <div class="label-select-block">
                                        <select name="people" id="people">
                                            <option selected value="<?php echo $rc['people'] ?>"><?php echo $rc['people'] ?></option>
                                            <option value="10-50">10-50</option>
                                            <option value="50-100">50-100</option>
                                            <option value="100-200">100-200</option>
                                            <option value="200-400">200-400</option>
                                            <option value="400-500">400-500</option>
                                            <option value="500-1000">500-1000</option>
                                            <option value="Более 1000">Более 1000</option>
                                        </select>
                                        <div class="label-arrow">
                                            <i class="mdi mdi-chevron-down"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="label-block au-fn">
                                    <label for="">Средняя зарплата</label>
                                    <div class="lb-block">
                                        <input type="number" id="middle" name="middle" value="<?php echo $rc['middle'] ?>" placeholder="">
                                        <span class="lb-in">руб.</span>
                                    </div>
                                </div>
                            </div>


                            <div style="margin:0" class="label-block">
                                <label for="">Web-site</label>
                                <input type="text" id="website" name="website" value="<?php echo $rc['website'] ?>" placeholder="">
                            </div>
                            <div class="pf-bth" style="margin: 30px 0 0 0;">
                                <button class="bth save-company" type="button" name="">Сохранить</button>
                            </div>
                        </form>

                    </div>


                </div>


            </div>



        </section>

    </main>


    <?php require('admin/template/adminFooter.php'); ?>


    <script>


        'use strict';

        (function ($) {

            $(document).ready(function () {

                $(document).on('click', '.save-company', function (e) {
                    e.preventDefault();
                    $('.save-company').attr('disabled', 'true')
                    $('.save-company').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
                    $('.empty').fadeOut(50)
                    $('select').removeClass('errors')
                    $('input').removeClass('errors')
                    $('textarea').removeClass('errors')
                    $('.label-block .select2-container--default .select2-selection--single').css({
                        'border': '1px solid #cdd0d5',
                        'background': '#ffffff'
                    })

                    setTimeout(function () {
                        $.ajax({
                            url: '/admin/admin-js',
                            data: `${$('.form-profile').serialize()}&cid=${$_GET['id']}&MODULE_SAVE_COMPANY=1`,
                            type: 'POST',
                            cache: false,
                            dataType: 'json',
                            error: (response) => {
                                MessageBox('Произошла ошибка. Повторите')
                                console.log(response)
                            },
                            success: function (responce) {
                                console.log(responce)
                                if (responce.code === 'validate_error') {
                                    let $arr = responce.error
                                    for (let i in $arr) {
                                        if (i === 'address') $('span[aria-controls="select2-address-container"]').css({
                                            'border': '1px solid #ff4c4c',
                                            'background': 'rgba(255,22,46,.06)'
                                        })
                                        $(`#${i}`).addClass('errors');
                                        $(`.e-${i}`).fadeIn(50)
                                    }
                                    $('.save-company').removeAttr('disabled')
                                    $('.save-company').html('Сохранить')
                                    MessageBox('Ошибка валидации')
                                } else {
                                    if (responce.code === 'success') {
                                        $('.save-company').removeAttr('disabled')
                                        $('.save-company').html('Отправить')
                                        MessageBox('Изменения внесены')
                                    } else {
                                        MessageBox('Произошла ошибка. Повторите')
                                    }
                                }
                            }});
                    }, 500)


                })


            });

        })(jQuery)


    </script>


    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>