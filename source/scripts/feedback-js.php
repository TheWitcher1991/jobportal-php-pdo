<?php

if (isset($_SESSION['id']) && isset($_SESSION['password'])) {

    try {

        if (isset($_POST['act']) && $_POST['act'] == 1) {

            $err = array();
            $captcha = $_SESSION['captcha'];
            unset($_SESSION['captcha']);
            session_write_close();
            $code = $_POST['captcha'];
            $code = crypt(trim($code), '$1$itchief$7');

            if (empty($_POST['text']) || trim($_POST['text']) == '') $err['text'] = 'Введите сообщение';
            if (empty($_POST['captcha']) or trim($_POST['captcha']) == '') $err['captcha'] = 'Пожалуйста введите код';
            else if ($captcha != $code)  $err['captcha'] = 'Введенный код не соответствует изображению!';

            if (empty($err)) {
                $text = preg_replace ( "'<script[^>]*?>.*?</script>'si", "", $_POST['text']);
                $text = str_replace($xss,"",$text);

                $email = 'alikzoy@gmail.com';

                $name = 'UNDEFINED';

                if ($_SESSION['type'] == 'users') {
                    $u = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']]);
                    $name = $u['name'] . ' ' . $u['surname'];
                } else if ($_SESSION['type'] == 'company') {
                    $u = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $_SESSION['id']]);
                    $name = $u['name'];
                }


                SENDMAIL($mail, "Feedback - Агрокадры", $email, "admin", "
От: $name
<br/>   
$text");

                SENDMAIL($mail, "Feedback - Агрокадры",'admin@stgaujob.ru', "admin", "
От: $name
<br/>   
$text");

                echo json_encode(array(
                    'code' => 'success',
                ));

                session_write_close();

                exit;
            } else {
                echo json_encode(array(
                    'code' => 'validate_error',
                    'array' => $err
                ));

                session_write_close();

                exit;
            }

        }

    } catch (Exception $e) {
        echo json_encode(array(
            'code' => 'error',
            'message' => $e->getMessage()
        ));
    }





} else {


    try {

        if (isset($_POST['act']) && $_POST['act'] == 1) {

            $err = array();
            $captcha = $_SESSION['captcha'];
            unset($_SESSION['captcha']);
            session_write_close();
            $code = $_POST['captcha'];
            $code = crypt(trim($code), '$1$itchief$7');

            if (empty($_POST['text']) || trim($_POST['text']) == '') $err['text'] = 'Введите сообщение';
            if (empty($_POST['captcha']) or trim($_POST['captcha']) == '') $err['captcha'] = 'Пожалуйста введите код';
            else if ($captcha != $code)  $err['captcha'] = 'Введенный код не соответствует изображению!';

            if (empty($err)) {
                $text = preg_replace("'<script[^>]*?>.*?</script>'si", "", $_POST['text']);
                $text = str_replace($xss, "", $text);

                $email = 'alikzoy@gmail.com';

                $name = 'guest';


                SENDMAIL($mail, "Feedback", $email, "admin", "
От: $name
<br/>   
$text");

                echo json_encode(array(
                    'code' => 'success',
                ));
            } else {
                    echo json_encode(array(
                        'code' => 'validate_error',
                        'array' => $err
                    ));
            }
        }

    } catch (Exception $e) {
        echo json_encode(array(
            'code' => 'error',
            'message' => $e->getMessage()
        ));
    }

}

session_write_close();

exit;