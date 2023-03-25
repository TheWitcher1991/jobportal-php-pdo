<?php

session_start();

use Work\plugin\lib\pQuery;


if (!isset($_SESSION['id']) && !isset($_SESSION['password'])) {
   

    /*if (isset($_POST["reg-company"]) and (isset($_POST["name_c"]) and isset($_POST["password_c"]))) {
        $err = array();

        $captcha = $_SESSION['captcha'];
        unset($_SESSION['captcha']);
        $code = $_POST['captcha'];
        $code = crypt(trim($code), '$1$itchief$7');

        if (empty($_POST['inn']) or trim($_POST['inn']) == '') $err['inn'] = 'Введите ИНН';
        if (empty($_POST['username']) or trim($_POST['username']) == '') $err['username'] = 'Введите имя';
        if (empty($_POST['type']) or trim($_POST['type']) == '') $err['type'] = 'Укажите тип компании';
        if (empty($_POST['name_c']) or trim($_POST['name_c']) == '') $err['name_c'] = 'Введите название компании';
        if (empty($_POST['phone_c']) or trim($_POST['phone_c']) == '') $err['phone_c'] = 'Введите телефон';
        if (empty($_POST['email_c']) or trim($_POST['email_c']) == '') $err['email_c'] = 'Введите email';
        if (empty($_POST['address_c']) or trim($_POST['address_c']) == '') $err['address_c'] = 'Введите город';
        if (strlen ($_POST['password_c']) < 8) $err[] = $err['password_c'] = 'Пароль должен быть не меньше 8 символов';
        if (empty($_POST['captcha']) or trim($_POST['captcha']) == '') $err['captcha'] = 'Пожалуйста введите код';
        else if ($captcha != $code)  $err['captcha'] = 'Введенный код не соответствует изображению!';

        if (empty($err)) {

            $ers = $app->fetch("SELECT * FROM `temp_company` WHERE `email` = :email", [':email' => XSS_DEFENDER($_POST['email_c'])]);

            if (isset($ers['id'])) {
                $err['email_c'] = 'Извините, но аккаунт с данной почтой находится на стадии подтверждения.';
            } else {
                $inn = XSS_DEFENDER($_POST['inn']);
                $username = XSS_DEFENDER($_POST['username']);
                $type = XSS_DEFENDER($_POST['type']);
                $name = XSS_DEFENDER($_POST['name_c']);
                $phone = XSS_DEFENDER($_POST['phone_c']);
                $email = XSS_DEFENDER($_POST['email_c']);
                $address = XSS_DEFENDER($_POST['address_c']);
                $password = XSS_DEFENDER($_POST['password_c']);

                $r = $app->fetch("SELECT * FROM `users` WHERE `email` = :email", [':email' => $email]);
                $r2 = $app->fetch("SELECT * FROM `company` WHERE `email` = :email", [':email' => $email]);

                if (!empty($r['id']) || !empty($r2['id'])) {
                    $err['email_c'] = 'Данная E-mail почта занята';
                } else {
                    $code = md5(md5(random_str(25)));
                    $pass_code = md5(md5(random_str(25)));

                    $new_pass = md5(md5($password . $pass_code . $email));

                    if (SENDMAIL($mail, "Подтверждение почты", $email, $name, '
Здравствуйте! Для подтверждения почты и окончательной регистрации на сайте <a target="_blank" href="stgaujob.ru">СтГАУ Агрокадры</a>
пройдите по нижеследующей ссылке. Ссылка действует 24 часа.
Ваш логин: '.$email.'
Ваш пароль: '.$password.'
<a style="margin: 16px 0 0 0;
            font-size: 14px;
            font-weight: 400;
            cursor: pointer;
            padding: 6px 21px;
            border: 0;
            border-radius: 3px;
            transition: all 0.2s linear;
            outline: none;
            color: #fff;
            box-shadow: 0 4px 20px rgb(0 0 0 / 10%);
            background-color: #1967D2;
            background-clip: padding-box;
            border-color: #1967D2;
            position: relative;
            text-decoration: none;
            display: inline-block;" class="go-bth" target="_blank" href="http://stgaujob.ru/registers/confirm-company?email='.$email.'&code='.$code.'">Подтвердить</a>    
                    ')) {
                        $_SESSION["$email-confirm-company"] = [
                            'email' => $email,
                            'code' => $code,
                            'msg' => 'На Вашу почту был отправлен запрос на подтверждения Вашего аккаунта. Пожалуйста, следуйте инструкциям в письме.'
                        ];

                        $app->execute("INSERT INTO `temp_company` (`inn`, `username`, `type`, `name`, `email`, `phone`, `city`, `password`, `password_hash`, `code`, `time`)
                        VALUES (:inn, :un, :typ, :nm, :email, :phone, :city, :password, :hash, :code, NOW())", [
                            ':inn' => $inn,
                            ':un' => $username,
                            ':typ' => $type,
                            ':nm' => $name,
                            ':email' => $email,
                            ':phone' => $phone,
                            ':city' => $address,
                            ':password' => $new_pass,
                            ':hash' => $pass_code,
                            ':code' => $code
                        ]);


                        header("Location: /create-success/?c=$email&code=$code");
                        exit;
                    } else {
                        $err['email_error'] = 'Извините, что-то пошло не так, повторите регистрацию';
                    }


                }
            }


        }
    }*/

    if (isset($_POST['login'])) {
        $err = [];

        if (trim($_POST['email_l']) == '') $err[] = 'Введите e-mail!';
        if (trim($_POST['password_l']) == '') $err[] = 'Введите пароль!';

        if (empty($err)) {
            $app->login($_POST['email'], $_POST['password']);
        }
    }
    Head('Регистрация работодателя');
    ?>
    <body class="body-auth">

    <!-- Auth -->
    <div id="auth">
        <div class="lost-wrapper">
            <div class="auth-container auth-log">
                <div class="auth-title">
                    Восстановление пароля
                    <i class="fa-solid fa-xmark form-close"></i>
                </div>
                <div class="auth-form">
                    <form class="form" action="" method="POST">
                        <div class="label-block label-b-info">
                            Введите email, который Вы указали при регистрации. </br />
                            На него будет отправленно сообщение, </br />
                            для воостановления пароля.
                        </div>

                        <div class="label-block">
                            <label for="">E-mail</label>
                            <input type="email" id=lost_email" name="lost_email" required placeholder="">
                        </div>
                        <div class="a-bth">
                            <input name="lost" type="submit" value="Отправить">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="auth-wrapper">
            <div class="auth-container auth-log">

                <div class="auth-title">
                    Авторизация
                    <i class="mdi mdi-close form-close"></i>
                </div>



                <div class="auth-form">
                    <form class="form" action="" method="POST">
                        <div class="label-block">
                            <label for="">E-mail</label>
                            <input type="email" id="email" name="email" required placeholder="">
                        </div>

                        <div class="label-block">
                            <label for="">Пароль</label>
                            <input type="password" id=password" name="password" required placeholder="">
                        </div>
                        <div class="a-r">
                            <input type="checkbox" name="" id="">
                            <span>Запомнить меня</span>
                        </div>
                        <div class="a-bth">
                            <input name="login" type="submit" value="Войти">
                        </div>
                        <div class="a-p">
                            <a class="lost-pass-a">Забыли пароль?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- / Auth -->

    <main id="wrapper" class="wrapper wrapper-auth">
        <section class="auth-section">
            <div class="auth-container-auth-ms">
                <?php
                if (isset($success)) {
                    ?>
                    <div class="alert-block" style="margin: 0">
                        <div>
                            <span><?php echo $success; ?></span>
                        </div>
                        <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="auth-container-aut">
                <a href="/" class="auth-span-a"><i class="mdi mdi-close"></i></a>
                <div class="auth-form">
                    <div>
                        <h1>Регистрация</h1>

                        <div class="errors-block"></div>

                        <div class="af-tabs">
                            <ul class="tabs-li">
                                <li><a href="/create/user">Как студент</a></li>
                                <li><a class="tabs-act" href="/create/employers">Как работадатель</a></li>
                            </ul>
                        </div>
                        <div class="tabs-item">
                            <div class="tabs-form tb-si-a tabs-act">
                                <form role="form" class="form-create-company" method="post">
                                    <div class="flex-h">
                                        <div class="flex f-n">
                                            <div class="label-block au-fn au-fn-1">
                                                <label for="">ИНН компании <span>*</span></label>
                                                <input data-name="inn" <? if (isset($err['inn'])) { ?> class="errors" <? } ?>  type="text" id="inn" name="inn" placeholder="" value="<? echo $_POST['inn']; ?>">
                                                <? if (isset($err['inn'])) { ?> <span class="error"><? echo $err['inn']; ?></span> <? } ?>
                                                <span class="empty e-inn">Введите ИНН</span>
                                            </div>

                                            <div class="label-block au-fn">
                                                <label for="">Контактное лицо <span>*</span></label>
                                                <input data-name="username" <? if (isset($err['username'])) { ?> class="errors" <? } ?>  type="text" id="username" name="username" placeholder="Например, Иван Иванов" value="<? echo $_POST['username']; ?>">
                                                <? if (isset($err['username'])) { ?> <span class="error"><? echo $err['username']; ?></span> <? } ?>
                                                <span class="empty e-username">Введите контактное лицо</span>
                                            </div>
                                        </div>

                                        <div class="flex f-n">
                                            <div class="label-block au-fn au-fn-1">
                                                <label for="">Тип компании <span>*</span></label>
                                                <div class="label-select-block">
                                                    <select data-name="type" id="type" name="type" <? if (isset($err['type'])) { ?> class="errors" <? } ?> >
                                                        <option value="">Выбрать</option>
                                                        <?php
                                                        $job_type = ['Частная', 'Государственная', 'Смешанная', 'Кадровое агенство'];

                                                        if (isset($_POST['type'])) {
                                                            foreach ($job_type as $key) {
                                                                if ($_POST['type'] == $key) {
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
                                                <span class="empty e-type">Выберите тип</span>
                                                <? if (isset($err['type'])) { ?> <span class="error"><? echo $err['type']; ?></span> <? } ?>
                                            </div>

                                            <div class="label-block au-fn">
                                                <label for="">Название компании <span>*</span></label>
                                                <input data-name="name" <? if (isset($err['name_c'])) { ?> class="errors" <? } ?> type="text" id="name" name="name" placeholder="" value="<? echo $_POST['name_c']; ?>">
                                                <? if (isset($err['name_c'])) { ?> <span class="error"><? echo $err['name_c']; ?></span> <? } ?>
                                                <span class="empty e-name">Введите название</span>
                                            </div>
                                        </div>
                                        <div class="flex f-i">
                                            <div class="label-block">
                                                <label for="">E-mail <span>*</span></label>
                                                <input data-name="mail" <? if (isset($err['email_c'])) { ?> class="errors" <? } ?> type="email" id="mail" name="email" placeholder="">
                                                <? if (isset($err['email_c'])) { ?> <span class="error"><? echo $err['email_c']; ?></span> <? } ?>
                                                <span class="empty e-email">Введите email</span>
                                                <span class="empty e-mail">Введите email</span>
                                                <span class="empty e-mail-2">Извините, но аккаунт с данной email почтой находится на стадии подтверждения</span>
                                                <span class="empty e-mail-3">Данная email почта занята</span>
                                            </div>

                                            <div class="label-block">
                                                <label for="">Телефон <span>*</span></label>
                                                <input data-name="tel" <? if (isset($err['phone_c'])) { ?> class="errors" <? } ?> type="tel" id="tel" name="phone" placeholder="+7 (999) 999-99-99" value="<? echo $_POST['phone_c']; ?>">
                                                <? if (isset($err['phone_c'])) { ?> <span class="error"><? echo $err['phone_c']; ?></span> <? } ?>
                                                <span class="empty e-tel">Введите телефон</span>
                                            </div>

                                            <div class="label-block">
                                                <label for="address_c">Город <span>*</span></label>
                                                <div class="label-select-block">
                                                    <select data-name="address" <? if (isset($err['address_c'])) { ?> class="errors" <? } ?> name="address" id="address" placeholder="Выберите город">
                                                            <option value="">Выбрать</option>
                                                            <?php

                                                            if (isset($_POST['address_c'])) {
                                                                foreach ($city as $key) {
                                                                    if ($_POST['address_c'] == $key) {
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
                                                <span class="empty e-address">Выберите город</span>
                                                <? if (isset($err['address_c'])) { ?> <span class="error"><? echo $err['address_c']; ?></span> <? } ?>
                                            </div>

                                            <div class="label-block">
                                                <label for="">Пароль <span>*</span></label>
                                                <div class="label-password">
                                                    <input data-name="password" <? if (isset($err['password_c'])) { ?> class="errors" <? } ?> type="password" id="password" name="password" placeholder="Пароль должен быть не меньше 8 символов">

                                                    <i class="mdi mdi-eye-outline eye-password in-pass"></i>
                                                </div>


                                                <? if (isset($err['password_c'])) { ?> <span class="error"><? echo $err['password_c']; ?></span> <? } ?>
                                                <span class="empty e-password">Пароль должен быть не меньше 8 символов</span>
                                            </div>

                                            <div class="captcha">
                                                <div class="captcha__image-reload">
                                                    <img class="captcha__image" src="/scripts/captcha" width="132" alt="captcha">
                                                    <button type="button" class="captcha__refresh"><i class="mdi mdi-refresh"></i></button>
                                                </div>
                                                <div style="margin: 0 0 30px" class="captcha__group">
                                                    <label for="captcha">Код, изображенный на картинке <span>*</span></label>
                                                    <input data-name="captcha" style="height: 36px;font-size: 13px;padding: 8px 12px;" <? if (isset($err['captcha'])) { ?> class="errors" <? } ?> type="text" name="captcha" id="captcha">
                                                    <? if (isset($err['captcha'])) { ?> <span class="error"><? echo $err['captcha']; ?></span> <? } ?>
                                                    <span class="empty e-captcha">Код неверный или устарел</span>
                                                </div>
                                            </div>


                                            <div class="label-block label-b-info">
                                                Нажимая кнопку «Продолжить», Вы принимаете условия «<a target="_blank" href="http://stgau.ru/privacy/">Политики конфиденциальности</a>».
                                            </div>
                                        </div>
                                    </div>
                                    <div class="a-b-main">
                                        <div class="a-b-bth">
                                            <button name="reg-company" class="reg-company" type="button">Продолжить</button>
                                        </div>
                                        <div class="a-l-a">
                                            <a href="/login">У меня уже есть аккаунт</a>
                                            <a class="form-i-a" href="/login-admin"><i class="mdi mdi-shield-crown-outline"></i></a>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
        </section>

    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="/static/scripts/auth.js?v=<?= date('YmdHis') ?>"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js" integrity="sha512-d4KkQohk+HswGs6A1d6Gak6Bb9rMWtxjOa0IiY49Q3TeFd5xAzjWXDCBW9RS7m86FQ4RzM2BdHmdJnnKRYknxw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        (function($){const refreshCaptcha=(target)=>{const captchaImage=target.closest('.captcha__image-reload').querySelector('.captcha__image');captchaImage.src='/scripts/captcha?r='+new Date().getUTCMilliseconds()}
            if(document.querySelector('.captcha__refresh')){const captchaBtn=document.querySelector('.captcha__refresh');captchaBtn.addEventListener('click',(e)=>refreshCaptcha(e.target))}
            $(window).on('load',function(){$('#loader-site').delay(200).fadeOut(500)})
            $(document).ready(function(){$("#tel").mask("+7 (999) 999-99-99");$('#address').select2({placeholder:"Выберите город",maximumSelectionLength:2,language:"ru"})})})(jQuery,window,document)
    </script>


    </body>
    </html>
    <?php
} else {

    pQuery::notFound();
}
?>