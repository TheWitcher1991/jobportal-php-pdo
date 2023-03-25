<?php

if (isset($_SESSION['id']) && isset($_SESSION['password'])) {
    $app->notFound();
} else {
    $token = XSS_DEFENDER($_GET['api']);

    if (isset($_SESSION["login-$token"])) {

        $api = $_SESSION["login-$token"];

        if ($api['type'] == 'users') {
            $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id AND `email` = :email AND `2fa` = 1", [
                ':id' => $api['id'],
                ':email' => $api['email']
            ]);

            if (count($user) > 0) {


                if (isset($_POST['reset-login'])) {

                    $token_reset = md5(md5($user['email'].random_str(10).time()));

                    $code = random_number(6);

                    $client = clientInfo(getIp());

                    $_SESSION["login-$token_reset"] = [
                        'id' => $api['id'],
                        'email' => $api['email'],
                        'type' => $api['type'],
                        'check' => $api['check'],
                        'code' => $code
                    ];

                    SENDMAIL($mail, "Подтверждение входа", $user['email'], $user['name'] . ' ' . $user['surname'], '
Здравствуйте!
Чтобы завершить вход, введите проверочный код

Локация: '.$client['country'].', '.$client['city'].'
Код проверки: <b>'.$code.'</b>

Если это были не вы, пожалуйста, немедленно измените свой пароль с помощью формы восстановления пароля на сайте или в личном кабинете, чтобы обезопасить свою учетную запись
');

                    unset($_SESSION["login-$token"]);

                    $app->go('/login-confirm/?api='.$token_reset);
                }


                if (isset($_POST['login-user'])) {

                    $err = [];

                    if (empty($_POST['code']) or trim($_POST['code']) == '') $err['code'] = 'Введите код';
                    else if ($_POST['code'] != $api['code']) $err['code'] = 'Вы ввели не правильный код';

                    if (empty($err)) {

                        if ($api['check'] == 1) {
                            $password_cookie_token = md5(md5($company['name'] . md5(md5(random_str(20))) . time()));
                            $_SESSION['surname'] = $user['surname'];
                            $_SESSION['password'] = $user['password'];
                            $_SESSION['id'] = $user['id'];
                            $_SESSION['email'] = $user['email'];
                            $_SESSION['type'] = 'users';
                            $_SESSION['token'] = hash('sha256', time() . random_str(25));
                            $client = clientInfo(getIp());

                            $c = $app->rowCount("SELECT * FROM `log_users` WHERE `ip` = :ip AND `user_id` = :id", [
                                ':ip' => $client['query'],
                                ':id' => $user['id']
                            ]);
                            if ($c > 0) {
                                $app->execute("UPDATE `log_users` SET
                                `time` = NOW(),
                                `day` = :d,
                                `hour` = :h,
                                `counter` = `counter` + 1
                                WHERE `user_id` = :id AND `ip` = :ip", [
                                    ':d' => getDates(),
                                    ':h' => date("H:i"),
                                    ':id' => $user['id'],
                                    ':ip' => $client['query']
                                ]);
                            } else {
                                $app->execute("INSERT INTO `log_users` (`country`, `city`, `ip`, `time`, `day`, `hour`, `user`, `user_id`, `counter`)
                            VALUES (:coun, :cit, :ip, NOW(), :d, :h, :cn, :ci, :co)", [
                                    ':coun' => $client['country'],
                                    ':cit' => $client['city'],
                                    ':ip' => $client['query'],
                                    ':d' => getDates(),
                                    ':h' => date("H:i"),
                                    ':cn' => $user['name'] . ' ' . $user['surname'],
                                    ':ci' => $user['id'],
                                    ':co' => 1
                                ]);
                            }

                            $app->execute("UPDATE `users` SET `cookie_token` = :token, `last_ip` = :ip WHERE `id` = :id", [
                                ':token' => $password_cookie_token,
                                ':ip' => $client['query'],
                                ':id' => $user['id']
                            ]);

                            setcookie("cookie_token", $password_cookie_token, time() + (1000 * 60 * 60 * 24 * 30));

                            unset($_SESSION["login-$token"]);

                            $app->go('/profile');
                        } else {
                            $_SESSION['surname'] = $user['surname'];
                            $_SESSION['password'] = $user['password'];
                            $_SESSION['id'] = $user['id'];
                            $_SESSION['email'] = $user['email'];
                            $_SESSION['type'] = 'users';
                            $_SESSION['token'] = hash('sha256', time() . random_str(25));
                            $client = clientInfo(getIp());

                            $c = $app->rowCount("SELECT * FROM `log_users` WHERE `ip` = :ip AND `user_id` = :id", [
                                ':ip' => $client['query'],
                                ':id' => $user['id']
                            ]);
                            if ($c > 0) {
                                $app->execute("UPDATE `log_users` SET
                                `time` = NOW(),
                                `day` = :d,
                                `hour` = :h,
                                `counter` = `counter` + 1
                                WHERE `user_id` = :id AND `ip` = :ip", [
                                    ':d' => getDates(),
                                    ':h' => date("H:i"),
                                    ':id' => $user['id'],
                                    ':ip' => $client['query']
                                ]);
                            } else {
                                $app->execute("INSERT INTO `log_users` (`country`, `city`, `ip`, `time`, `day`, `hour`, `user`, `user_id`, `counter`)
                            VALUES (:coun, :cit, :ip, NOW(), :d, :h, :cn, :ci, :co)", [
                                    ':coun' => $client['country'],
                                    ':cit' => $client['city'],
                                    ':ip' => $client['query'],
                                    ':d' => getDates(),
                                    ':h' => date("H:i"),
                                    ':cn' => $user['name'] . ' ' . $user['surname'],
                                    ':ci' => $user['id'],
                                    ':co' => 1
                                ]);
                            }

                            if (isset($_COOKIE["cookie_token"])) {
                                $app->execute("UPDATE `users` SET `cookie_token` = '', `last_ip` = :ip WHERE `id` = :id", [
                                    ':id' => $user['id'],
                                    ':ip' => $client['query'],
                                ]);

                                setcookie("cookie_token", "", time() - 3600);
                            }

                            unset($_SESSION["login-$token"]);

                            $app->go('/profile');
                        }

                    }

                }

            } else {
                $app->notFound();
            }

        } else if ($api['type'] == 'company') {
            $company = $app->fetch("SELECT * FROM `company` WHERE `id` = :id AND `email` = :email AND `2fa` = 1", [
                ':id' => $api['id'],
                ':email' => $api['email']
            ]);

            if (count($company) > 0) {

                if (isset($_POST['reset-login'])) {

                    $token_reset = md5(md5($company['email'].random_str(10).time()));

                    $code = random_number(6);

                    $client = clientInfo(getIp());

                    $_SESSION["login-$token_reset"] = [
                        'id' => $api['id'],
                        'email' => $api['email'],
                        'type' => $api['type'],
                        'check' => $api['check'],
                        'code' => $code
                    ];

                    SENDMAIL($mail, "Подтверждение входа", $company['email'], $company['name'], '
Здравствуйте!
Чтобы завершить вход, введите проверочный код

Локация: '.$client['country'].', '.$client['city'].'
Код проверки: <b>'.$code.'</b>

Если это были не вы, пожалуйста, немедленно измените свой пароль с помощью формы восстановления пароля на сайте или в личном кабинете, чтобы обезопасить свою учетную запись
');

                    unset($_SESSION["login-$token"]);

                    $app->go('/login-confirm/?api='.$token_reset);
                }



                if (isset($_POST['login-user'])) {

                    $err = [];

                    if (empty($_POST['code']) or trim($_POST['code']) == '') $err['code'] = 'Введите код';
                    else if ($_POST['code'] != $api['code']) $err['code'] = 'Вы ввели не правильный код';

                    if (empty($err)) {
                        if ($api['check'] == 1) {
                            $password_cookie_token = md5(md5($company['name'] . md5(md5(random_str(20))) . time()));
                            session_regenerate_id();
                            $_SESSION['company'] = $company['name'];
                            $_SESSION['password'] = $company['password'];
                            $_SESSION['id'] = $company['id'];
                            $_SESSION['email'] = $company['email'];
                            $_SESSION['type'] = 'company';
                            $_SESSION['token'] = hash('sha256', time() . random_str(25));
                            $client = clientInfo(getIp());
                            $c = $app->rowCount("SELECT * FROM `log_company` WHERE `ip` = :ip AND `company_id` = :id", [
                                ':ip' => $client['query'],
                                ':id' => $company['id']
                            ]);
                            if ($c > 0) {
                                $app->execute("UPDATE `log_company` SET
                                `time` = NOW(),
                                `day` = :d,
                                `hour` = :h,
                                `counter` = `counter` + 1
                                WHERE `company_id` = :id AND `ip` = :ip", [
                                    ':d' => getDates(),
                                    ':h' => date("H:i"),
                                    ':id' => $company['id'],
                                    ':ip' => $client['query']
                                ]);
                            } else {
                                $app->execute("INSERT INTO `log_company` (`country`, `city`, `ip`, `time`, `day`, `hour`, `company`, `company_id`, `counter`)
                                VALUES (:coun, :cit, :ip, NOW(), :d, :h, :cn, :ci, :co)", [
                                    ':coun' => $client['country'],
                                    ':cit' => $client['city'],
                                    ':ip' => $client['query'],
                                    ':d' => getDates(),
                                    ':h' => date("H:i"),
                                    ':cn' => $company['name'],
                                    ':ci' => $company['id'],
                                    ':co' => 1
                                ]);
                            }

                            $app->execute("UPDATE `company` SET `cookie_token` = :token, `last_ip` = :ip WHERE `id` = :id", [
                                ':token' => $password_cookie_token,
                                ':ip' => $client['query'],
                                ':id' => $company['id']
                            ]);

                            setcookie("cookie_token", $password_cookie_token, time() + (1000 * 60 * 60 * 24 * 30));

                            unset($_SESSION["login-$token"]);

                            $app->go('/profile');
                        } else {
                            session_regenerate_id();
                            $_SESSION['company'] = $company['name'];
                            $_SESSION['password'] = $company['password'];
                            $_SESSION['id'] = $company['id'];
                            $_SESSION['email'] = $company['email'];
                            $_SESSION['type'] = 'company';
                            $_SESSION['token'] = hash('sha256', time() . random_str(25));
                            $client = clientInfo(getIp());
                            $c = $app->rowCount("SELECT * FROM `log_company` WHERE `ip` = :ip AND `company_id` = :id", [
                                ':ip' => $client['query'],
                                ':id' => $company['id']
                            ]);
                            if ($c > 0) {
                                $app->execute("UPDATE `log_company` SET
                                `time` = NOW(),
                                `day` = :d,
                                `hour` = :h,
                                `counter` = `counter` + 1
                                WHERE `company_id` = :id AND `ip` = :ip", [
                                    ':d' => getDates(),
                                    ':h' => date("H:i"),
                                    ':id' => $company['id'],
                                    ':ip' => $client['query']
                                ]);
                            } else {
                                $app->execute("INSERT INTO `log_company` (`country`, `city`, `ip`, `time`, `day`, `hour`, `company`, `company_id`, `counter`)
                                VALUES (:coun, :cit, :ip, NOW(), :d, :h, :cn, :ci, :co)", [
                                    ':coun' => $client['country'],
                                    ':cit' => $client['city'],
                                    ':ip' => $client['query'],
                                    ':d' => getDates(),
                                    ':h' => date("H:i"),
                                    ':cn' => $company['name'],
                                    ':ci' => $company['id'],
                                    ':co' => 1
                                ]);
                            }

                            if (isset($_COOKIE["cookie_token"])) {
                                $app->execute("UPDATE `company` SET `cookie_token` = '', `last_ip` = :ip WHERE `id` = :id", [
                                    ':id' => $company['id'],
                                    ':ip' => $client['query'],
                                ]);

                                setcookie("cookie_token", "", time() - 3600);
                            }

                            unset($_SESSION["login-$token"]);

                            $app->go('/profile');
                        }
                    }
                }

            } else {
                $app->notFound();
            }


        } else if ($api['type'] == 'admin') {
            $admin = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id AND `email` = :email", [
                ':id' => $api['id'],
                ':email' => $api['email']
            ]);

            if (count($admin) > 0) {


                if (isset($_POST['reset-login'])) {

                    $token_reset = md5(md5($admin['email'].random_str(10).time().$admin['id']));

                    $code = random_number(6);

                    $client = clientInfo(getIp());

                    $_SESSION["login-$token_reset"] = [
                        'id' => $api['id'],
                        'email' => $api['email'],
                        'type' => $api['type'],
                        'check' => $api['check'],
                        'code' => $code
                    ];

                    SENDMAIL($mail, "Подтверждение входа", $admin['email'], $admin['email'], '
Здравствуйте! 
Попытка входа с нового IP, пожалуйста, подтвердите, что это вы.
Чтобы завершить вход, введите проверочный код

Локация: '.$client['country'].', '.$client['city'].' — '.$client['query'].'
Код проверки: <b>'.$code.'</b>

Если это были не вы, пожалуйста, немедленно обратитесь к разработчикам
');

                    unset($_SESSION["login-$token"]);

                    $app->go('/login-confirm/?api='.$token_reset);
                }



                if (isset($_POST['login-user'])) {

                    $err = [];

                    if (empty($_POST['code']) or trim($_POST['code']) == '') $err['code'] = 'Введите код';
                    else if ($_POST['code'] != $api['code']) $err['code'] = 'Вы ввели не правильный код';

                    if (empty($err)) {

                        $client = clientInfo(getIp());

                        $session_token = hash('sha256', md5(time() . random_str(10) . $admin['id']));

                        session_regenerate_id();
                        $_SESSION['admin'] = $admin['name'];
                        $_SESSION['password'] = $admin['password'];
                        $_SESSION['id'] = $admin['id'];
                        $_SESSION['email'] = $admin['email'];
                        $_SESSION['type'] = 'admin';
                        $_SESSION['token'] = $session_token;

                        $app->execute("UPDATE `admin` SET
                                `session_token` = :st,
                                `last_ip` = :li
                            WHERE `id` = :id", [
                            ':st' => $session_token,
                            ':li' => $client['query'],
                            ':id' => $admin['id']
                        ]);

                        $c = $app->rowCount("SELECT * FROM `log_admin` WHERE `ip` = :ip AND `admin_id` = :id", [
                            ':ip' => $client['query'],
                            ':id' => $admin['id']
                        ]);
                        if ($c > 0) {
                            $app->execute("UPDATE `log_admin` SET
                                `time` = NOW(),
                                `day` = :d,
                                `hour` = :h,
                                `counter` = `counter` + 1
                                WHERE `admin_id` = :id AND `ip` = :ip", [
                                ':d' => getDates(),
                                ':h' => date("H:i"),
                                ':id' => $admin['id'],
                                ':ip' => $client['query']
                            ]);
                        } else {
                            $app->execute("INSERT INTO `log_admin` (`country`, `city`, `ip`, `time`, `day`, `hour`, `admin`, `admin_id`, `counter`)
                            VALUES (:coun, :cit, :ip, NOW(), :d, :h, :cn, :ci, :co)", [
                                ':coun' => $client['country'],
                                ':cit' => $client['city'],
                                ':ip' => $client['query'],
                                ':d' => getDates(),
                                ':h' => date("H:i"),
                                ':cn' => $admin['name'],
                                ':ci' => $admin['id'],
                                ':co' => 1
                            ]);
                        }

                        $app->go('/admin/analysis');
                    }
                }
            } else {
                $app->notFound();
            }

        } else {
            $app->notFound();
        }

        Head('Подтверждение входа');

?>

<body class="body-auth">

    <main id="wrapper" class="wrapper wrapper-auth">
        <section class="auth-section auth-section-center">
            <div class="auth-container-aut auth-container-aut-two">
                <a href="/" class="auth-span-a"><i class="mdi mdi-close"></i></a>
                <div class="auth-form">
                    <div>
                        <h1>Подтверждение входа</h1>

                        <span>Чтобы завершить вход, введите <b>6-ти значный</b> проверочный код, который был отправлен на вашу электронную почту</span>

                        <form role="form" class="form-login-user" method="post">

                            <div class="label-block" style="margin: 20px 0 35px 0;">
                                <label for="">Проверочный код <span>*</span></label>
                                <input required <? if (isset($err['code'])) { ?> class="errors" <? } ?>  class="field-user" type="text" id="code" name="code" placeholder="" value="<? echo $_POST['code']; ?>">
                                <? if (isset($err['code'])) { ?> <span class="error"><? echo $err['code']; ?></span> <? } ?>
                            </div>

                            <div class="a-b-main">
                                <div class="a-b-bth">
                                    <button class="login-button" name="login-user" type="submit">Войти</button>
                                </div>
                            </div>


                        </form>
                        <form role="form" method="post">
                            <div class="code-rep">
                                <button name="reset-login" type="submit">Запросить код повторно</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="/static/scripts/auth.js?v=<?= date('YmdHis') ?>"></script>


</body>

<?php

    } else {
        $app->notFound();
    }
 }


?>