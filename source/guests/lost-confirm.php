<?php

use Work\plugin\lib\pQuery;

$email_get = $_GET['email'];
$code_get = $_GET['c'];


if (isset($_SESSION["$code_get-recovery"]) && empty($_SESSION['id']) && empty($_SESSION['password'])) {

    $email = $_SESSION["$code_get-recovery"]['email'];


    $ru = $app->fetch("SELECT * FROM `users` WHERE `email` = :email", [':email' => $email]);
    $rc = $app->fetch("SELECT * FROM `company` WHERE `email` = :email", [':email' => $email]);
    if (isset($ru['id']) && empty($rc['id'])) {
        if (isset($_POST['reset_password'])) {
            $err = array();
            if (strlen ($_POST['password']) < 8) $err['password'] = 'Пароль должен быть не меньше 8 символов';
            if ($_POST['password'] != $_POST['new_password']) $err['new_password'] = 'Пароли не совпадают';
            if (empty($err)) {
                $password = XSS_DEFENDER($_POST['password']);
                $code = md5(md5(random_str(25)));
                $new_pass = password_hash($password . $code, PASSWORD_BCRYPT, [
                    'cost' => 11
                ]);
                $app->execute("UPDATE `users` SET `password` = :password, `code` = :code WHERE `id` = :id", [
                    ':password' => $new_pass,
                    ':code' => $code,
                    ':id' => $ru['id']
                ]);
                $_SESSION['surname'] = $ru['surname'];
                $_SESSION['password'] = $ru['password'];
                $_SESSION['id'] = $ru['id'];
                $_SESSION['email'] = $ru['email'];
                $_SESSION['type'] = 'users';
                $_SESSION['token'] = hash('sha256', time() . random_str(25));
                $app->go('/profile');
            }
        }
    } else if (isset($rc['id']) && empty($ru['id'])) {
        if (isset($_POST['reset_password'])) {
            $err = array();
            if (strlen ($_POST['password']) < 8) $err['password'] = 'Пароль должен быть не меньше 8 символов';
            if ($_POST['password'] != $_POST['new_password']) $err['new_password'] = 'Пароли не совпадают';
            if (empty($err)) {
                $password = XSS_DEFENDER($_POST['password']);
                $code = md5(md5(random_str(25)));
                $new_pass = password_hash($password . $code, PASSWORD_BCRYPT, [
                    'cost' => 11
                ]);
                $app->execute("UPDATE `company` SET `password` = :password, `code` = :code WHERE `id` = :id", [
                    ':password' => $new_pass,
                    ':code' => $code,
                    ':id' => $rc['id']
                ]);
                $_SESSION['company'] = $rc['name'];
                $_SESSION['password'] = $rc['password'];
                $_SESSION['id'] = $rc['id'];
                $_SESSION['email'] = $rc['email'];
                $_SESSION['type'] = 'company';
                $_SESSION['token'] = hash('sha256', time() . random_str(25));
                $app->go('/profile');
            }
        }
    } else {
        $app->notFound();
    }



    if (isset($_POST['send'])) {
        if ($_POST['type'] == 1) {
            if (isset($_POST['text']) and trim($_POST['text']) != '') {
                exit(header('location: /job-list?key=' . $_POST['text'].'loc=stav'));
            } else {
                exit(header('location: /job-list?loc=stav'));
            }
        }
        if ($_POST['type'] == 2) {
            if (isset($_POST['text']) and trim($_POST['text']) != '') {
                exit(header('location: /resume-list?key=' . $_POST['text']));
            } else {
                exit(header('location: /resume-list'));
            }
        }
        if ($_POST['type'] == 3) {
            if (isset($_POST['text']) and trim($_POST['text']) != '') {
                exit(header('location: /company-list?key=' . $_POST['text']));
            } else {
                exit(header('location: /company-list'));
            }
        }
    }




    Head('Восстановление пароля');

    ?>
    <body>

    <?php require('template/base/nav.php'); ?>

    <header id="header-search">
        <?php require('template/base/navblock.php'); ?>
        <div class="header-search-container">
            <div class="container">
                <form action="" method="post">
                    <div class="hs-container">

                        <span class="hs-h">Поиск</span>
                        <div class="header-input-container">
                            <div class="hi-field">
                                <i class="mdi mdi-magnify"></i>
                                <input class="hi-title" name="text" type="text" placeholder="Ключевое слово">
                            </div>
                            <div class="hi-field">
                                <i class="mdi mdi-format-list-text"></i>
                                <select name="type">
                                    <option value="1">Вакансии</option>
                                    <option value="2">Резюме</option>
                                    <option value="3">Компании</option>
                                </select>
                            </div>
                            <input type="submit" class="hs-bth" name="send" value="Найти">
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </header>


    <main id="wrapper">
        <div class="container">
            <div class="section-nav">
                <span><a href="/">Главная</a></span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span>Восстановление пароля</span>
            </div>
        </div>
        <section class="auth-section">
            <div class="auth-alert">
                <?php
                if (isset($_GET['error'])) {
                    ?>
                    <div class="alert-block" style="margin: 0">
                        <div>
                            <span>Что-то пошло не так.</span>
                        </div>
                        <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                    </div>
                    <?php
                }
                ?>
            </div>

            <div class="auth-content">
                <span>Восстановление пароля</span>
                <form method="post">
                    <div class="label-block" style="margin-bottom: 20px">
                        <label for="">Ваша почта: <?php echo $email; ?></label>
                    </div>
                    <div class="label-block">
                        <label for="">Новый пароль <span>*</span></label>
                        <div class="label-password">
                            <input type="password" id="password" name="password" value="<?php echo $_POST['password']; ?>">
                            <i class="mdi mdi-eye-outline eye-password in-pass"></i>
                        </div>
                        <? if (isset($err['password'])) { ?> <span class="error"><? echo $err['password']; ?></span> <? } ?>
                    </div>

                    <div class="label-block" style="margin-bottom: 15px;">
                        <label for="">Повторите пароль <span>*</span></label>
                        <div class="label-password">
                            <input type="password" id="new_password" name="new_password" value="<?php echo $_POST['new_password']; ?>">
                            <i class="mdi mdi-eye-outline eye-password in-pass"></i>
                        </div>
                        <? if (isset($err['new_password'])) { ?> <span class="error"><? echo $err['new_password']; ?></span> <? } ?>
                    </div>

                    <input class="auth-button" name="reset_password" type="submit" value="Сброс">
                </form>
            </div>
        </section>
        <section class="me-section">
            <div class="me-base-b">
                <div class="me-auth-block">
                    <span>Вспомнили пароль?</span>
                    <div class="ma-b">
                        <a href="/login">Войти</a>
                    </div>
                </div>
            </div>

        </section>
    </main>


    <?php require('template/base/footer.php'); ?>

    </body>
    </html>
    <?php
} else {

    pQuery::notFound();
}
?>
