<?php

$email_get = $_GET['email'];
$code_get = $_GET['code'];

if (isset($_SESSION['id'])) {
    $app->notFound();
    exit;
} else {

    $c = $app->fetch("SELECT * FROM `company` WHERE `email` = :email LIMIT 1", [':email' => $email_get]);

    if (empty($c['id'])) {
        $tmp = $app->fetch("SELECT * FROM `temp_company` WHERE `email` = :email AND `code` = :code LIMIT 1", [
            ':email' => $email_get,
            ':code' => $code_get
        ]);

        if (isset($tmp['id'])) {
            $app->execute("INSERT INTO `company` (`username`, `inn`, `type`, `name`, `phone`, `email`, `password`, `date`, `address`, `code`) 
                                                VALUES(:un, :inn, :typ, :uname, :phone, :email, :passwor, :d, :ad, :cod)", [
                ':un' => $tmp['username'],
                ':inn' => $tmp['inn'],
                ':typ' => $tmp['type'],
                ':uname' => $tmp['name'],
                ':phone' => $tmp['phone'],
                ':email' => $tmp['email'],
                ':passwor' => $tmp['password'],
                ':d' => $Date,
                ':ad' => $tmp['city'],
                ':cod' => $tmp['password_hash']
            ]);

            $r = $app->fetch("SELECT * FROM `company` WHERE `email` = :email", [':email' => $tmp['email']]);

            $_SESSION['company'] = $r['name'];
            $_SESSION['password'] = $r['password'];
            $_SESSION['id'] = $r['id'];
            $_SESSION['email'] = $r['email'];
            $_SESSION['type'] = 'company';
            $_SESSION['token'] = hash('sha256', time() . random_str(25));

            $app->execute("DELETE FROM `temp_company` WHERE `email` = :email", [
                ':email' => $email_get,
            ]);
            unset($_SESSION["$email_get-confirm-company"]);
            $app->go('/');
        } else {
            $app->notFound();
        }
    } else {
        $app->notFound();
    }

}


?>

