<?php

use Work\plugin\lib\pQuery;

if (isset($_SESSION['surname']) && isset($_SESSION['password']) && $_SESSION['type'] == 'users') {

    if ($_SESSION['type'] == 'users') {
        $sql = "SELECT * FROM `users` WHERE `id` = :id";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() <= 0) {
            pQuery::notFound();
        }

        $r = $stmt->fetch();
    }




    if (isset($_POST['add'])) {

        $err = array();
        $captcha = $_SESSION['captcha'];
        unset($_SESSION['captcha']);
        session_write_close();
        $code = $_POST['captcha'];
        $code = crypt(trim($code), '$1$itchief$7');

        if (empty($_POST['captcha']) or trim($_POST['captcha']) == '') $err['captcha'] = 'Пожалуйста введите код';
        else if ($captcha != $code)  $err['captcha'] = 'Введенный код не соответствует изображению!';
        if (empty($_POST['exp-title']) or trim($_POST['exp-title']) == '') $err['exp-title'] = 'Введите организацию';
        if (empty($_POST['exp-prof']) or trim($_POST['exp-prof']) == '') $err['exp-prof'] = 'Введите специальность';
        if (empty($_POST['exp-date']) or trim($_POST['exp-date']) == '') $err['exp-date'] = 'Введите дату';

        if (empty($err)) {
            $title = $_POST['exp-title'];
            $text = $_POST['exp-text'];
            $dates = $_POST['exp-date'];
            $prof = $_POST['exp-prof'];
            $user_id = $r['id'];

            $sql = "INSERT INTO `exp` (`user_id`, `date`, `title`, `text`, `prof`)
                                            VALUES(:ui, :d, :title, :t, :pf)";
            $stmt = $PDO->prepare($sql);
            $stmt->execute([
                ':ui' => $user_id,
                ':d' => $dates,
                ':title' => $title,
                ':t' => $text,
                ':pf' => $prof
            ]);

            $success = 'Данные успешно записаны!';

            header('location: /add-exp');
        }


    }

    Head($r['name'] . ' ' . $r['surname'] . ' - опыт работы');

    ?>

    <body class="profile-body">

    <main class="wrapper wrapper-profile" id="wrapper">


        <?php require('template/more/profileAside.php'); ?>

        <section class="profile-base">

            <?php require('template/more/profileHeader.php'); ?>


            <div class="profile-content profile">

                <div class="section-nav-profile">
                    <span><a href="/profile">Профиль</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a>Добавить опыт работы</a></span>
                </div>

                <div class="errors-block-fix">

                </div>


                <?php if (isset($success)) { ?>
                    <div class="alert-block">
                        <div>
                            <span><?php echo $success; ?></span>
                        </div>
                        <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                    </div>
                <?php } ?>
                <div class="profile-data">

                    <? include 'template/more/profileHead.php'; ?>

                    <div class="resume-bth">
                        <a onclick="createForm()" class="bth-a create-exp">Добавить опыт работы</a>
                    </div>



                    <?php
                    $sqled = "SELECT * FROM `exp` WHERE `user_id` = :t";
                    $stmted = $PDO->prepare($sqled);
                    $stmted->bindValue(':t', $r['id']);
                    $stmted->execute();
                    if ($stmted->rowCount() > 0) {
                        ?>

                        <div class="u-d-ab">
                            <span>Ваши данные</span>
                            <div class="db-text" style="padding: 16px 26px">
                                <ul class="dl-exp">
                                    <?php
                                    while ($rx = $stmted->fetch()) {
                                        ?>
                                        <li class="exp-<?php echo $rx['id']; ?>">
                                            <div class="de-time">
                                                <?php
                                                echo $arr_m[(DateTime::createFromFormat('m.Y', $rx['date_1'])->format('n'))] . ' ' .
                                                    DateTime::createFromFormat('m.Y', $rx['date_1'])->format('Y') .  ' — <br />';

                                                $date1 = DateTime::createFromFormat('m.Y', $rx['date_1'])->format('Y-m').'-1';
                                                $date1 = new DateTime($date1);

                                                $date2 = '';

                                                if ($rx['present'] == 1) {
                                                    $date2 = date('Y.m.d');
                                                    $date2 = DateTime::createFromFormat('Y.m.d', $date2)->format('Y-m-d');
                                                    $date2 = new DateTime($date2);
                                                    echo 'по настоящее время';
                                                } else {
                                                    $date2 = DateTime::createFromFormat('m.Y', $rx['date_2'])->format('Y-m-d');
                                                    $date2 = new DateTime($date2);
                                                    echo $arr_m[(DateTime::createFromFormat('m.Y', $rx['date_2'])->format('n'))] . ' ' .
                                                    DateTime::createFromFormat('m.Y', $rx['date_2'])->format('Y');
                                                }


                                                $period = getPeriod($date1,$date2);

                                                ?>
                                                <p> <?php echo $period; ?></p>
                                            </div>
                                            <div class="de-content">
                                                <span class="dle-t"><?php echo $rx['title']; ?></span>
                                                <span class="dle-p"><?php echo $rx['prof']; ?></span>
                                                <div class="dle-text">
                                                    <p>
                                                        <?php echo $rx['text']; ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <button type="button" class="del-detatil" onclick="deleteDetail('<?php echo $rx['id']; ?>')"><i class="mdi mdi-trash-can-outline"></i></button>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>


                        <?php
                    }

                    ?>

                </div>
            </div>
        </section>

    </main>


    <?php require('template/more/profileFooter.php'); ?>

    <?php

    if (isset($_SESSION['id']) && isset($_SESSION['password']) && $_SESSION['type'] == 'users') {

        ?>

        <script>

            function deleteDetail(id) {
                $(`.exp-${Number(id)} button`).html('<i class="mdi mdi-reload reload-bth"></i>')
                $(`.exp-${Number(id)} button`).attr('disabled', 'true')
                $.ajax({
                    url: '/scripts/profile-js',
                    data: `id=${id}&MODULE_DELETE_EXP=1`,
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    error: function (response) {
                        $('.errors-block-fix').html(`
                            <div class="alert-block">
                                <div>
                                    <span>Произошла ошибка. Повторите</span>
                                    </br />
                                </div>
                                <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                            </div>
                            `)
                        $('.errors-block-fix > div').css('display', 'flex')

                    },
                    success: function (responce) {
                        if (responce.code === 'success') {
                            $(`.exp-${Number(id)}`).remove()
                        } else {
                            $('.errors-block-fix').html(`
                            <div class="alert-block">
                                <div>
                                    <span>Произошла ошибка. Повторите</span>
                                    </br />
                                </div>
                                <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                            </div>
                            `)
                            $('.errors-block-fix > div').css('display', 'flex')
                        }
                    }
                })
            }


            function respondExp () {
                $('#auth .empty').fadeOut(50)
                $('#auth select').removeClass('errors')
                $('#auth input').removeClass('errors')
                $('.lock-yes').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
                $('.lock-yes').attr('disabled', 'true')
                $.ajax({
                    url: '/scripts/profile-js',
                    data: `${$('.form-exp').serialize()}&MODULE_ADD_EXP=1`,
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    error: function (response) {
                        $('.errors-block-fix').html(`
                            <div class="alert-block">
                                <div>
                                    <span>Произошла ошибка. Повторите</span>
                                    </br />
                                </div>
                                <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                            </div>
                            `)
                        $('.lock-yes').removeAttr('disabled')
                        $('.lock-yes').html('Добавить')
                        $('.errors-block-fix > div').css('display', 'flex')
                        console.log(responce)
                    },
                    success: function (responce) {
                        if (responce.code === 'success') {
                            if (responce.count === 1) {
                                location.reload()
                            } else {
                                deleteForm()
                                $('.dl-exp').append(responce.list)
                                $('.errors-block-fix').html(`
                            <div class="alert-block">
                                <div>
                                    <span>Успешно!</span>
                                    </br />
                                </div>
                                <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                            </div>
                            `)
                                $('.lock-yes').removeAttr('disabled')
                                $('.lock-yes').html('Добавить')
                                $('.errors-block-fix > div').css('display', 'flex')
                            }
                        } else {
                            if (responce.code === 'validate_error') {
                                $('.lock-yes').removeAttr('disabled')
                                $('.lock-yes').html('Добавить')
                                let $arr = responce.error
                                for (let i in $arr) {
                                    if (i === 'date-1') {
                                        $(`#date-n-1`).addClass('errors');
                                        $('.e-exp-date-1').fadeIn(50)
                                    }
                                    if (i === 'date-2') {
                                        $(`#date-n-2`).addClass('errors');
                                        $('.e-exp-date-1').fadeIn(50)
                                    }
                                    if (i === 'date-3') {
                                        $(`#date-k-1`).addClass('errors');
                                        $('.e-exp-date-2').fadeIn(50)
                                    }
                                    if (i === 'date-4') {
                                        $(`#date-k-2`).addClass('errors');
                                        $('.e-exp-date-2').fadeIn(50)
                                    }
                                    $(`#${i}`).addClass('errors');
                                    $(`#${i}`).text($arr[i]);
                                    $(`.e-${i}`).fadeIn(50)
                                    $(`.e-${i}`).text($arr[i]);
                                }
                            } else {
                                console.log(responce)
                                $('.errors-block-fix').html(`
                            <div class="alert-block">
                                <div>
                                    <span>Произошла ошибка. Повторите</span>
                                    </br />
                                </div>
                                <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                            </div>
                            `)
                                $('.lock-yes').removeAttr('disabled')
                                $('.lock-yes').html('Добавить')
                                $('.errors-block-fix > div').css('display', 'flex')
                            }
                        }
                    }
                })
            }


            function createForm() {
                document.querySelector('.profile-body').innerHTML += `
        <div id="auth" style="display:flex">
            <div class="contact-wrapper" style="display:block">
                <div class="auth-container auth-log auth-form-r" >
                    <div class="auth-title">
                        Образование
                        <i class="mdi mdi-close form-detete" onclick="deleteForm()"></i>
                    </div>
                    <div class="auth-form">
                        <form class="form-exp" role="form" method="post">

                                <div class="label-block">
                                    <label for="">Организация <span>*</span></label>
                                    <input type="text" name="exp-title" id="exp-title" placeholder="" value="">
                                    <span class="empty e-exp-title">Введите организацию</span>
                                </div>

                                <div class="label-block">
                                    <label for="">Профессия <span>*</span></label>
                                    <input type="text" name="exp-prof" id="exp-prof" value="">
                                    <span class="empty e-exp-prof">Введите профессию</span>
                                </div>

                                <div class="label-block">
                                    <label for="">Начало работы <span>*</span></label>
                                    <div class="label-two-mini">
                                        <div class="label-select-block">
                                            <select name="date-n-1" id="date-n-1">

                                                    <option selected value="">Месяц</option>
                                                    <option value="01">Январь</option>
                                                    <option value="02">Февраль</option>
                                                    <option value="03">Март</option>
                                                    <option value="04">Апрель</option>
                                                    <option value="05">Май</option>
                                                    <option value="06">Июнь</option>
                                                    <option value="07">Июль</option>
                                                    <option value="08">Август</option>
                                                    <option value="09">Сентябрь</option>
                                                    <option value="10">Октябрь</option>
                                                    <option value="11">Ноябрь</option>
                                                    <option value="12">Декабрь</option>
                                            </select>
                                            <div class="label-arrow">
                                                <i class="mdi mdi-chevron-down"></i>
                                            </div>
                                        </div>
                                        <input value="" type="number" maxlength="4" size="4" inputmode="numeric" name="date-n-2" id="date-n-2" placeholder="Год">
                                    </div>
                                    <span class="empty e-exp-date-1">Некорректная дата</span>
                                </div>

                                <div class="label-block" style="margin-bottom: 10px;">
                                    <label for="">Окончание <span>*</span></label>
                                    <div class="label-two-mini">
                                        <div class="label-select-block">
                                            <select name="date-k-1" id="date-k-1">

                                                    <option selected value="">Месяц</option>
                                                    <option value="01">Январь</option>
                                                    <option value="02">Февраль</option>
                                                    <option value="03">Март</option>
                                                    <option value="04">Апрель</option>
                                                    <option value="05">Май</option>
                                                    <option value="06">Июнь</option>
                                                    <option value="07">Июль</option>
                                                    <option value="08">Август</option>
                                                    <option value="09">Сентябрь</option>
                                                    <option value="10">Октябрь</option>
                                                    <option value="11">Ноябрь</option>
                                                    <option value="12">Декабрь</option>
                                            </select>
                                            <div class="label-arrow">
                                                <i class="mdi mdi-chevron-down"></i>
                                            </div>
                                        </div>
                                        <input value="" type="number" maxlength="4" size="4" inputmode="numeric" name="date-k-2" id="date-k-2" placeholder="Год">
                                    </div>
                                    <span style="bottom: -50px;" class="empty e-exp-date-2">Некорректная дата</span>
                                </div>

                                <div class="label-b-check">
                                    <input onclick="restartJob()" type="checkbox" class="custom-checkbox" id="n1" name="no-rb" value="1">
                                    <label for="n1">
                                        	По настоящее время
                                    </label>
                                </div>

                                <!--<div class="label-block">
                                    <label for="">Дата работы (Начало-Конец) <span>*</span></label>
                                    <input type="text" name="exp-date" id="exp-date" placeholder="Например, 2011-2018" value="">
                                     <span class="empty e-exp-date">Введите дату работы</span>
                                </div>-->

                                <div class="label-block">
                                    <label for="">Краткое описание </label>
                                    <textarea name="exp-text" id="exp-text" style="height:100px;" cols="30" rows="10"></textarea>
                                </div>

                        </form>

                        <form method="post">
                            <div class="pop-flex-bth">
                                <button class="more-inf" type="button" onclick="deleteForm()">Отмена</button>
                                <button onclick="respondExp()" type="button" class="lock-yes">Добавить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        `
            }


            function deleteForm () {
                $('#auth').css('display', 'none')
                $('#auth').remove();
            }


            function restartJob() {

                let c = document.querySelector('#n1')
                if (c.checked) {
                    $('#date-k-1').val('')
                    $('#date-k-2').val('')
                    $('#date-k-1').attr('disabled', 'true')
                    $('#date-k-2').attr('disabled', 'true')
                    $(`#date-k-1`).removeClass('errors');
                    $(`#date-k-2`).removeClass('errors');
                    $('.e-exp-date-2').fadeOut(50)
                } else {
                    $('#date-k-1').removeAttr('disabled')
                    $('#date-k-2').removeAttr('disabled')
                }

            }

        </script>

        <?php
    }


    ?>

    </body>
    </html>
    <?php
} else {
    pQuery::notFound();
}
?>