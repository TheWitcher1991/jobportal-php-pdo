<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $app->notFound();
    exit;
}

if (empty($_SESSION['id']) && empty($_SESSION['password']) && empty($_SESSION['type'])) {

    try {

        if (isset($_POST['MODULE_USER']) && $_POST['MODULE_USER'] == 1) {
            $err = array();

            $captcha = $_SESSION['captcha'];
            unset($_SESSION['captcha']);
            $code = $_POST['captcha'];
            $code = crypt(trim($code), '$1$itchief$7');

            if (empty($_POST['name']) or trim($_POST['name']) == '') $err['name'] = 'Введите имя';
            if (empty($_POST['surname']) or trim($_POST['surname']) == '') $err['surname'] = 'Введите фамилию';
            if (empty($_POST['prof']) or trim($_POST['prof']) == '') $err['prof'] = 'Введите профессию';
            if (empty($_POST['email']) or trim($_POST['email']) == '') $err['email'] = 'Введите email';
            if (empty($_POST['phone']) or trim($_POST['phone']) == '') $err['tel'] = 'Введите телефон';
            if (empty($_POST['faculty']) or trim($_POST['faculty']) == '') $err['faculty'] = 'Укажите факультет';
            if (empty($_POST['direction']) or trim($_POST['direction']) == '') $err['direction'] = 'Укажите направление';
            if (empty($_POST['degree']) or trim($_POST['degree']) == '') $err['degree'] = 'Укажите текущее образование';
            if (strlen ($_POST['password']) < 8) $err[] = $err['password'] = 'Пароль должен быть не меньше 8 символов';
            if (empty($_POST['captcha']) or trim($_POST['captcha']) == '') $err['captcha'] = 'Код неверный';
            else if ($captcha != $code)  $err['captcha'] = 'Код неверный';

            if (empty($err)) {

                $ers = $app->fetch("SELECT * FROM `temp_users` WHERE `email` = :email", [':email' => XSS_DEFENDER($_POST['email'])]);
                $ers2 = $app->fetch("SELECT * FROM `temp_company` WHERE `email` = :email", [':email' => XSS_DEFENDER($_POST['email'])]);

                if (isset($ers['id']) || isset($ers2['id'])) {
                    $err['mail-2'] = 'Извините, но аккаунт с данной email почтой находится на стадии подтверждения.';
                    echo json_encode(array(
                        'error' => $err,
                        'code' => 'validate_error',
                    ));
                } else {
                    $name = XSS_DEFENDER($_POST['name']);
                    $surname = XSS_DEFENDER($_POST['surname']);
                    $email = XSS_DEFENDER($_POST['email']);
                    $phone = XSS_DEFENDER($_POST['phone']);
                    $phone = phone_format($phone);
                    $password = XSS_DEFENDER($_POST['password']);
                    $faculty = XSS_DEFENDER($_POST['faculty']);
                    $direction = XSS_DEFENDER($_POST['direction']);
                    $degree = XSS_DEFENDER($_POST['degree']);
                    $prof = XSS_DEFENDER($_POST['prof']);

                    $r = $app->fetch("SELECT * FROM `users` WHERE `email` = :email", [':email' => $email]);
                    $r2 = $app->fetch("SELECT * FROM `company` WHERE `email` = :email", [':email' => $email]);

                    if (!empty($r['id']) || !empty($r2['id'])) {
                        $err['mail-3'] = 'Данная email почта занята';
                        echo json_encode(array(
                            'error' => $err,
                            'code' => 'validate_error',
                        ));
                    } else {

                        $p = $app->fetch("SELECT * FROM `users` WHERE `phone` = :phone", [':phone' => $phone]);
                        $p2 = $app->fetch("SELECT * FROM `company` WHERE `phone` = :phone", [':phone' => $phone]);

                        if (!empty($p['id']) || !empty($p2['id'])) {
                            $err['tel-2'] = 'Данный номер телефона занят';
                            echo json_encode(array(
                                'error' => $err,
                                'code' => 'validate_error',
                            ));
                            exit;
                        } else {

                            $code = md5(md5(random_str(25)));

                            $pass_code = md5(md5(random_str(10).time()));

                            //$new_pass = md5(md5($password . $pass_code . $name));

                            $new_pass = password_hash($password . $pass_code, PASSWORD_BCRYPT, [
                                'cost' => 11
                            ]);

                            $_SESSION["$email-confirm-user"] = [
                                'email' => $email,
                                'code' => $code,
                                'msg' => 'На Вашу почту был отправлен запрос на подтверждения Вашего аккаунта. Пожалуйста, следуйте инструкциям в письме.'
                            ];

                            if (SENDMAIL($mail, "Подтверждение почты", $email, $name . ' ' . $surname, '
Здравствуйте! Для подтверждения почты и окончательной регистрации на сайте <a target="_blank" href="stgaujob.ru">СтГАУ Агрокадры</a>
пройдите по нижеследующей ссылке. Ссылка действует 24 часа.
Ваш логин: ' . $email . '
Ваш пароль: ' . $password . '
<a style="margin: 16px 0 0 0;
font-size: 14px;font-weight: 400;cursor: pointer;padding: 6px 21px;border: 0;
border-radius: 3px;transition: all 0.2s linear;outline: none;color: #fff;box-shadow: 0 4px 20px rgb(0 0 0 / 10%);
background-color: #1967D2;
background-clip: padding-box;border-color: #1967D2;position: relative;text-decoration: none;
display: inline-block;"
 class="go-bth" href="http://stgaujob.ru/registers/confirm-user?email=' . $email . '&code=' . $code . '">
Подтвердить</a>    
                    ')) {

                                $app->execute("INSERT INTO `temp_users` (`name`, `surname`, `prof`, `phone`, `email`, `password`, `password_hash`, `degree`, `faculty`, `direction`, `code`, `time`)
                        VALUES (:nm, :sn, :prof, :tel, :email, :password, :hash, :deg, :faculty, :direction, :code, NOW())", [
                                    ':nm' => $name,
                                    ':sn' => $surname,
                                    ':prof' => $prof,
                                    ':tel' => $phone,
                                    ':email' => $email,
                                    ':password' => $new_pass,
                                    ':hash' => $pass_code,
                                    ':deg' => $degree,
                                    ':faculty' => $faculty,
                                    ':direction' => $direction,
                                    ':code' => $code
                                ]);

                                echo json_encode(array(
                                    'link' => "/create-success/?c=$email&code=$code",
                                    'code' => 'success',
                                ));

                            } else {
                                echo json_encode(array(
                                    'code' => 'error',
                                ));
                            }

                        }
                    }
                }

            } else {
                echo json_encode(array(
                    'error' => $err,
                    'code' => 'validate_error',
                ));
            }
        }




        if (isset($_POST['MODULE_COMPANY']) && $_POST['MODULE_COMPANY'] == 1) {
            $err = array();

            $captcha = $_SESSION['captcha'];
            unset($_SESSION['captcha']);
            $code = $_POST['captcha'];
            $code = crypt(trim($code), '$1$itchief$7');

            if (empty($_POST['inn']) or trim($_POST['inn']) == '') $err['inn'] = 'Введите ИНН';
            if (empty($_POST['username']) or trim($_POST['username']) == '') $err['username'] = 'Введите имя';
            if (empty($_POST['type']) or trim($_POST['type']) == '') $err['type'] = 'Выберите тип компании';
            if (empty($_POST['name']) or trim($_POST['name']) == '') $err['name'] = 'Введите название компании';
            if (empty($_POST['phone']) or trim($_POST['phone']) == '') $err['tel'] = 'Введите телефон';
            if (empty($_POST['email']) or trim($_POST['email']) == '') $err['mail'] = 'Введите email';
            if (empty($_POST['address']) or trim($_POST['address']) == '') $err['address'] = 'Выберите город';
            if (strlen ($_POST['password']) < 8) $err[] = $err['password'] = 'Пароль должен быть не меньше 8 символов';
            if (empty($_POST['captcha']) or trim($_POST['captcha']) == '') $err['captcha'] = 'Код неверный';
            else if ($captcha != $code)  $err['captcha'] = 'Код неверный';

            if (empty($err)) {

                $ers = $app->fetch("SELECT * FROM `temp_users` WHERE `email` = :email", [':email' => XSS_DEFENDER($_POST['email'])]);
                $ers2 = $app->fetch("SELECT * FROM `temp_company` WHERE `email` = :email", [':email' => XSS_DEFENDER($_POST['email'])]);

                if (isset($ers['id']) || isset($ers2['id'])) {
                    $err['mail-2'] = 'Извините, но аккаунт с данной email почтой находится на стадии подтверждения.';
                    echo json_encode(array(
                        'error' => $err,
                        'code' => 'validate_error',
                    ));

                } else {
                    $inn = XSS_DEFENDER($_POST['inn']);
                    $username = XSS_DEFENDER($_POST['username']);
                    $type = XSS_DEFENDER($_POST['type']);
                    $name = $_POST['name'];
                    $name = preg_replace("'<script[^>]*?>.*?</script>'si", "", $_POST['name']);
                    $name = str_replace($xss, "", $name);
                    $phone = XSS_DEFENDER($_POST['phone']);
                    $phone = phone_format($phone);
                    $email = XSS_DEFENDER($_POST['email']);
                    $address = XSS_DEFENDER($_POST['address']);
                    $password = XSS_DEFENDER($_POST['password']);

                    $r = $app->fetch("SELECT * FROM `users` WHERE `email` = :email", [':email' => $email]);
                    $r2 = $app->fetch("SELECT * FROM `company` WHERE `email` = :email", [':email' => $email]);

                    if (!empty($r['id']) || !empty($r2['id'])) {
                        $err['mail-3'] = 'Данная email почта занята';
                        echo json_encode(array(
                            'error' => $err,
                            'code' => 'validate_error',
                        ));

                    } else {
                        $code = md5(md5(random_str(25)));
                        $pass_code = md5(md5(random_str(10).time()));

                        //$new_pass = md5(md5($password . $pass_code . $email));

                        $new_pass = password_hash($password . $pass_code, PASSWORD_BCRYPT, [
                            'cost' => 11
                        ]);

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


                            echo json_encode(array(
                                'link' => "/create-success/?c=$email&code=$code",
                                'code' => 'success',
                            ));

                        } else {
                            echo json_encode(array(
                                'code' => 'error',
                            ));

                        }

                    }

                }

            } else {
                echo json_encode(array(
                    'error' => $err,
                    'code' => 'validate_error',
                ));

            }
        }


    } catch (Exception $e) {
        echo json_encode(array(
            'code' => 'error',
            'message' => $e->getMessage()
        ));

    }


} else {
    $app->notFound();
}


session_write_close();

exit;

