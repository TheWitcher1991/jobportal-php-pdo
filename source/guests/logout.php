<?php

if (isset($_COOKIE["cookie_token"]) && !empty($_COOKIE["cookie_token"])) {
    if (isset($_SESSION['id']) && $_SESSION['type'] == 'company') {
        $app->execute("UPDATE `company` SET `cookie_token` = '' WHERE `id` = :id", [
            ':id' => $_SESSION['id']
        ]);
        setcookie("cookie_token", "", time() - 3600);
        unset($_COOKIE['cookie_token']);
        session_unset();
        session_destroy();
    }
    if (isset($_SESSION['id']) && $_SESSION['type'] == 'users') {
        $app->execute("UPDATE `users` SET `cookie_token` = '' WHERE `id` = :id", [
            ':id' => $_SESSION['id']
        ]);
        setcookie("cookie_token", "", time() - 3600);
        unset($_COOKIE['cookie_token']);
        session_unset();
        session_destroy();
    }
} else {
    session_unset();
    session_destroy();
}

$app->go('/');