<?php

$email_get = $_GET['email'];
$code_get = $_GET['code'];

if (isset($_SESSION['id']) && $_SESSION['type'] == 'users') {

    $tmp = $app->fetch("SELECT * FROM `temp_email_u` WHERE `email` = :email AND `code` = :code LIMIT 1", [
        ':email' => $email_get,
        ':code' => $code_get
    ]);

    if (!empty($tmp['id'])) {

        $u = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $tmp['token']]);

        if (!empty($u['id'])) {
            $code = md5(md5(random_str(25)));

            $new_pass = password_hash($tmp['vac_token'] . $code, PASSWORD_BCRYPT, [
                'cost' => 11
            ]);

            $app->execute("UPDATE `users` SET `email` = :email, `code` = :code, `password` = :password WHERE `id` = :id", [
                ':email' => XSS_DEFENDER($email_get),
                ':code' => $code,
                ':password' => $new_pass,
                ':id' => $u['id']
            ]);

            $app->execute("DELETE FROM `temp_email_u` WHERE `email` = :email", [
                ':email' => $email_get
            ]);

            $_SESSION['email'] = $email_get;
            $_SESSION['password'] = $new_pass;

            $app->go('/profile');
            exit;
        } else {
            $app->notFound();
            exit;
        }

    } else {
        $app->notFound();
        exit;
    }


} else {
    $app->notFound();
    exit;
}