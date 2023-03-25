<?php

$email_get = $_GET['email'];
$code_get = $_GET['code'];


if (isset($_SESSION['id'])) {
    $app->notFound();
} else {

    $u = $app->fetch("SELECT * FROM `users` WHERE `email` = :email", [':email' => $email_get]);


    if (empty($u['id'])) {
        $tmp = $app->fetch("SELECT * FROM `temp_users` WHERE `email` = :email AND `code` = :code", [
            ':email' => $email_get,
            ':code' => $code_get
        ]);


        if (isset($tmp['id'])) {


            $app->execute("INSERT INTO `users` (`prof`, `phone`, `name`, `surname`, `email`, `password`, `faculty`, `direction`, `date`, `degree`, `code`) 
                        VALUES(:prof, :tel, :uname, :surname, :email, :password, :faculty, :direction, :d, :degre, :cod)", [
                ':prof' => $tmp['prof'],
                ':tel' => $tmp['phone'],
                ':uname' => $tmp['name'],
                ':surname' => $tmp['surname'],
                ':email' => $tmp['email'],
                ':password' => $tmp['password'],
                ':faculty' => $tmp['faculty'],
                ':direction' => $tmp['direction'],
                ':d' => $Date,
                ':degre' => $tmp['degree'],
                ':cod' => $tmp['password_hash']
            ]);

            $r = $app->fetch("SELECT * FROM `users` WHERE `email` = :email", [':email' => $tmp['email']]);

            $_SESSION['surname'] = $r['surname'];
            $_SESSION['password'] = $r['password'];
            $_SESSION['id'] = $r['id'];
            $_SESSION['email'] = $r['email'];
            $_SESSION['type'] = 'users';
            $_SESSION['token'] = hash('sha256', time() . random_str(25));

            $app->execute("DELETE FROM `temp_users` WHERE `email` = :email", [
                ':email' => $email_get
            ]);
            unset($_SESSION["$email_get-confirm-user"]);
            $app->go('/');
        } else {
            $app->notFound();
        }
    } else {
        $app->notFound();
    }

}

