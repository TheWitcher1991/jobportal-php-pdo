<?php

namespace Core;

use InvalidArgumentException;
use PDO;
use PDOException;
use Core\Session;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class App {

    private PDO $connection;

    public function __construct(string $dsn, string $username, string $password) {
        try {
            $this->connection = new PDO($dsn, $username, $password);
        } catch (PDOException $exception) {
            throw new InvalidArgumentException('Database error:' . $exception->getMessage());
        }
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public function notFound() {
        exit(header('location: /404'));
    }

    public function quote($data) {
        return $this->db()->quote($data);
    }

    public function db(): PDO {
        return $this->connection;
    }

    public function query($sql) {
        return $this->db()->query($sql);
    }

    public function prepare($sql) {
        return $this->db()->prepare($sql);
    }

    public function queryFetch($sql) {
        $statement = $this->db()->query($sql);
        return $statement->fetch();
    }

    public function queryExecute($sql) {
        $statement = $this->db()->query($sql);
        $statement->execute();
    }

    public function count($sql) {
        $statement = $this->db()->query($sql);
        return $statement->rowCount();
    }

    public function rowCount($sql, array $data) {
        $statement = $this->db()->prepare($sql);

        if (!empty($data)) {
            foreach ($data as $key => $val) {
                $statement->bindValue($key, $val);
            }
        }

        $statement->execute();
        return $statement->rowCount();
    }

    public function execute($sql, array $data) {
        $statement = $this->db()->prepare($sql);

        if (!empty($data)) {
            foreach ($data as $key => $val) {
                $statement->bindValue($key, $val);
            }
        }

        $statement->execute();
    }

    public function fetch($sql, array $data) {
        $statement = $this->db()->prepare($sql);

        if (!empty($data)) {
            foreach ($data as $key => $val) {
                $statement->bindValue($key, $val);
            }
        }

        $statement->execute();
        return $statement->fetch(); 
    }

    public function fetchAll($sql, array $data) {
        $statement = $this->db()->prepare($sql);

        if (!empty($data)) {
            foreach ($data as $key => $val) {
                $statement->bindValue($key, $val);
            }
        }

        $statement->execute();
        return $statement->fetchAll();
    }

    public function go($data) {
        exit("<meta http-equiv='refresh' content='0; url=" . $data . "'>");
    }

    public function reset($data) {
        if (trim($data) == '') {
            $this->go('/lost-password/?error=1');
        } else {
            $data = XSS_DEFENDER($data);

            $user = $this->rowCount("SELECT * FROM `users` WHERE `email` = :email", [':email' => $data]);
            $company = $this->rowCount("SELECT * FROM `company` WHERE `email` = :email", [':email' => $data]);

            if ($user > 0 || $company > 0) {
                $code = random_str(25);


                $_SESSION["$code-recovery"] = [
                    'email' => $data,
                    'code' => $code,
                    'msg' => "На Вашу электронную почту был отправлен запрос на сброс пароля. Пожалуйста, следуйте инструкциям в письме."
                ];

                $mail = new PHPMailer();


                if (SENDMAIL($mail, "Восстановление пароля", $data, "Пользователь", '
Для сброса Вашего пароля на сайте <a target="_blank" href="http://stgaujob.ru/">СтГАУ АГРОКАДРЫ</a>, пройдите по нижеследующей ссылке. Это позволит Вам установить новый пароль.    
<br />
<a href="http://stgaujob.ru/lost-confirm/?email='.$data.'&c='.$code.'">Сбросить пароль</a>     
            ')) {
                    $this->go("/lost-success?c=$code");
                } else {
                    $this->go('/lost-password/?error=1');
                }



            } else {
                $code = random_str(25);
                $_SESSION["$code-recovery"] = [
                    'email' => $data,
                    'code' => $code,
                    'msg' => "На Вашу электронную почту был отправлен запрос на сброс пароля. Пожалуйста, следуйте инструкциям в письме."
                ];
                $this->go("/lost-success?c=$code");
            }


        }
    }

    public function countLog($ip, $id, $type) {
        if ($type === 1) {
            return $this->rowCount("SELECT * FROM `log_company` WHERE `ip` = :ip AND `company_id` = :id", [
                ':ip' => $ip,
                ':id' => $id
            ]);
        }
    }

    public function loginAdmin($data, $password, $check) {
        if (trim($data) == '')  {
            $this->go('/login/?error=1');
        } else if (trim($password) == '') {
            $this->go('/login/?error=1');
        } else {
            $data = XSS_DEFENDER($data);
            $password = XSS_DEFENDER($password);
            if ($data == 'admin' || $data == 'admin_2') {
                $admin = $this->fetch("SELECT * FROM `admin` WHERE `name` = :n", [':n' => $data]);
                if ($admin) {
                    if (isset($admin['id'])) {
                        if (md5(md5($password . $admin['code'] . $admin['name'])) == $admin['password']) {

                            $client = clientInfo(getIp());

                            if (trim($client['query']) == trim($admin['last_ip'])) {
                                $session_token = hash('sha256', md5(time() . random_str(10) . $admin['id']));
                                session_regenerate_id();
                                $_SESSION['admin'] = $admin['name'];
                                $_SESSION['password'] = $admin['password'];
                                $_SESSION['id'] = $admin['id'];
                                $_SESSION['email'] = $admin['email'];
                                $_SESSION['type'] = 'admin';
                                $_SESSION['token'] = $session_token;

                                $this->execute("UPDATE `admin` SET
                                `session_token` = :st,
                                `last_ip` = :li
                            WHERE `id` = :id", [
                                    ':st' => $session_token,
                                    ':li' => $client['query'],
                                    ':id' => $admin['id']
                                ]);

                                $c = $this->rowCount("SELECT * FROM `log_admin` WHERE `ip` = :ip AND `admin_id` = :id", [
                                    ':ip' => $client['query'],
                                    ':id' => $admin['id']
                                ]);
                                if ($c > 0) {
                                    $this->execute("UPDATE `log_admin` SET
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
                                    $this->execute("INSERT INTO `log_admin` (`country`, `city`, `ip`, `time`, `day`, `hour`, `admin`, `admin_id`, `counter`)
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

                                $this->go('/admin/analysis');
                            } else {
                                $token = md5(md5($admin['email'].random_str(10).time().$admin['id']));

                                $code = random_number(6);

                                $client = clientInfo(getIp());

                                $_SESSION["login-$token"] = [
                                    'id' => $admin['id'],
                                    'email' => $admin['email'],
                                    'type' => 'admin',
                                    'check' => 0,
                                    'code' => $code
                                ];

                                $mail = new PHPMailer();


                                SENDMAIL($mail, "Подтверждение входа", $admin['email'], $admin['email'], '
Здравствуйте! 
Попытка входа с нового IP, пожалуйста, подтвердите, что это вы.
Чтобы завершить вход, введите проверочный код

Локация: '.$client['country'].', '.$client['city'].' — '.$client['query'].'
Код проверки: <b>'.$code.'</b>

Если это были не вы, пожалуйста, немедленно обратитесь к разработчикам
');

                                $this->go('/login-confirm/?api='.$token);
                            }
                        } else {$this->go('/login-admin/?error=1');}
                    } else {$this->go('/login-admin/?error=1');}
                } else {$this->go('/login-admin/?error=1');}
            }
        }
    }

    public function login($data, $password, $check) {
        if (trim($data) == '')  {
            $this->go('/login/?error=1');
        } else if (trim($password) == '') {
            $this->go('/login/?error=1');
        } else {
            $data = XSS_DEFENDER($data);
            $password = XSS_DEFENDER($password);
            if ($data) {
                $user = $this->fetch("SELECT * FROM `users` WHERE `email` = :email", [':email' => $data]);
                $company = $this->fetch("SELECT * FROM `company` WHERE `email` = :email", [':email' => $data]);
                if ($company) {
                    if (isset($company['email'])) {
                        if (
                            (md5(md5($password . $company['code'] . $company['email'])) == $company['password']) ||
                            (password_verify($password . $company['code'], $company['password']))
                        ) {
                            if ($company['2fa'] == 0) {
                                if ($check == 1) {
                                    $password_cookie_token = md5(md5($company['name'] . md5(md5(random_str(20))) . time()));

                                    Session::instance()->generateId();

                                    Session::instance()->set([
                                        'id' => $company['id'],
                                        'company' => $company['name'],
                                        'password' => $company['password'],
                                        'email' => $company['email'],
                                        'type' => 'company',
                                        'token' => hash('sha256', time() . random_str(25))
                                    ]);

                                    $client = clientInfo(getIp());

                                    $c = $this->countLog($client['query'], $company['id'], 1);

                                    if ($c > 0) {
                                        $this->execute("UPDATE `log_company` SET
                                `time` = NOW(),
                                `day` = :d,
                                `hour` = :h,
                                `counter` = `counter` + 1
                                WHERE `company_id` = :id AND `ip` = :ip AND `type` = 0", [
                                            ':d' => getDates(),
                                            ':h' => date("H:i"),
                                            ':id' => $company['id'],
                                            ':ip' => $client['query']
                                        ]);
                                    } else {
                                        $this->execute("INSERT INTO `log_company` (`country`, `city`, `ip`, `time`, `day`, `hour`, `company`, `company_id`, `counter`)
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

                                    $this->execute("UPDATE `company` SET `cookie_token` = :token, `last_ip` = :ip WHERE `id` = :id", [
                                        ':token' => $password_cookie_token,
                                        ':ip' => $client['query'],
                                        ':id' => $company['id']
                                    ]);

                                    Session::instance()->setCookie("cookie_token", $password_cookie_token, time() + (3600 * 24 * 30));

                                    $this->go('/profile');
                                } else {
                                    Session::instance()->generateId();

                                    Session::instance()->set([
                                        'id' => $company['id'],
                                        'company' => $company['name'],
                                        'password' => $company['password'],
                                        'email' => $company['email'],
                                        'type' => 'company',
                                        'token' => hash('sha256', time() . random_str(25))
                                    ]);

                                    $client = clientInfo(getIp());
                                    $c = $this->rowCount("SELECT * FROM `log_company` WHERE `ip` = :ip AND `company_id` = :id AND `type` = 0", [
                                        ':ip' => $client['query'],
                                        ':id' => $company['id']
                                    ]);
                                    if ($c > 0) {
                                        $this->execute("UPDATE `log_company` SET
                                `time` = NOW(),
                                `day` = :d,
                                `hour` = :h,
                                `counter` = `counter` + 1
                                WHERE `company_id` = :id AND `ip` = :ip AND `type` = 0", [
                                            ':d' => getDates(),
                                            ':h' => date("H:i"),
                                            ':id' => $company['id'],
                                            ':ip' => $client['query']
                                        ]);
                                    } else {
                                        $this->execute("INSERT INTO `log_company` (`country`, `city`, `ip`, `time`, `day`, `hour`, `company`, `company_id`, `counter`)
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
                                        $this->execute("UPDATE `company` SET `cookie_token` = '', `last_ip` = :ip WHERE `id` = :id", [
                                            ':id' => $company['id'],
                                            ':ip' => $client['query'],
                                        ]);

                                        Session::instance()->setCookie("cookie_token", "", time() - 3600);

                                    }

                                    $this->go('/profile');
                                }
                            } else {

                                $token = md5(md5($company['email'].random_str(10).time()));

                                $code = random_number(6);

                                $client = clientInfo(getIp());

                                Session::instance()->generateId();

                                Session::instance()->set([
                                    "login-$token" => [
                                        'id' => $company['id'],
                                        'email' => $company['email'],
                                        'type' => 'company',
                                        'check' => $check,
                                        'code' => $code
                                    ]
                                ]);

                                $mail = new PHPMailer();

                                SENDMAIL($mail, "Подтверждение входа", $company['email'], $company['name'], '
Здравствуйте!
Чтобы завершить вход, введите проверочный код

Локация: '.$client['country'].', '.$client['city'].'
Код проверки: <b>'.$code.'</b>

Если это были не вы, пожалуйста, немедленно измените свой пароль с помощью формы восстановления пароля на сайте или в личном кабинете, чтобы обезопасить свою учетную запись
');

                                $this->go('/login-confirm/?api='.$token);
                            }
                        } else {
                            $this->go('/login/?error=1');

                            $client = clientInfo(getIp());

                            $c = $this->rowCount("SELECT * FROM `log_company` WHERE `ip` = :ip AND `company_id` = :id AND `type` = 1", [
                                ':ip' => $client['query'],
                                ':id' => $company['id']
                            ]);
                            if ($c > 0) {
                                $this->execute("UPDATE `log_company` SET
                                `time` = NOW(),
                                `day` = :d,
                                `hour` = :h,
                                `counter` = `counter` + 1
                                WHERE `company_id` = :id AND `ip` = :ip AND `type` = 1", [
                                    ':d' => getDates(),
                                    ':h' => date("H:i"),
                                    ':id' => $company['id'],
                                    ':ip' => $client['query']
                                ]);
                            } else {

                                $this->execute("INSERT INTO `log_company` (`country`, `city`, `ip`, `time`, `day`, `hour`, `company`, `company_id`, `type`, `counter`)
                            VALUES (:coun, :cit, :ip, NOW(), :d, :h, :cn, :ci, :typ, :co)", [
                                    ':coun' => $client['country'],
                                    ':cit' => $client['city'],
                                    ':ip' => $client['query'],
                                    ':d' => getDates(),
                                    ':h' => date("H:i"),
                                    ':cn' => $company['name'],
                                    ':ci' => $company['id'],
                                    ':typ' => 1,
                                    ':co' => 1
                                ]);
                            }
                        }
                    } else {$this->go('/login/?error=1');}
                } else if ($user) {
                    if (isset($user['email'])) {
                        if (
                            (md5(md5($password . $user['code'] . $user['name'])) == $user['password']) ||
                            (md5(md5($password . $user['code'] . $user['email'])) == $user['password']) ||
                            (password_verify($password . $user['code'], $user['password']))
                        ) {
                            if ($user['2fa'] == 0) {
                                if ($check == 1) {
                                    $password_cookie_token = md5(md5($user['name'] . md5(md5(random_str(20))) . time()));

                                    Session::instance()->generateId();

                                    Session::instance()->set([
                                        'surname' => $user['surname'],
                                        'password' => $user['password'],
                                        'id' => $user['id'],
                                        'email' => $user['email'],
                                        'type' => 'users',
                                        'token' => hash('sha256', time() . random_str(25))
                                    ]);

                                    $client = clientInfo(getIp());

                                    $c = $this->rowCount("SELECT * FROM `log_users` WHERE `ip` = :ip AND `user_id` = :id AND `type` = 0", [
                                        ':ip' => $client['query'],
                                        ':id' => $user['id']
                                    ]);
                                    if ($c > 0) {
                                        $this->execute("UPDATE `log_users` SET
                                `time` = NOW(),
                                `day` = :d,
                                `hour` = :h,
                                `counter` = `counter` + 1
                                WHERE `user_id` = :id AND `ip` = :ip AND `type` = 0", [
                                            ':d' => getDates(),
                                            ':h' => date("H:i"),
                                            ':id' => $user['id'],
                                            ':ip' => $client['query']
                                        ]);
                                    } else {
                                        $this->execute("INSERT INTO `log_users` (`country`, `city`, `ip`, `time`, `day`, `hour`, `user`, `user_id`, `counter`)
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

                                    $this->execute("UPDATE `users` SET `cookie_token` = :token, `last_ip` = :ip WHERE `id` = :id", [
                                        ':token' => $password_cookie_token,
                                        ':ip' => $client['query'],
                                        ':id' => $user['id']
                                    ]);

                                    setcookie("cookie_token", $password_cookie_token, time() + (3600 * 24 * 30));

                                    $this->go('/profile');
                                } else {

                                    session_regenerate_id();
                                    $_SESSION['surname'] = $user['surname'];
                                    $_SESSION['password'] = $user['password'];
                                    $_SESSION['id'] = $user['id'];
                                    $_SESSION['email'] = $user['email'];
                                    $_SESSION['type'] = 'users';
                                    $_SESSION['token'] = hash('sha256', time() . random_str(25));
                                    $client = clientInfo(getIp());

                                    $c = $this->rowCount("SELECT * FROM `log_users` WHERE `ip` = :ip AND `user_id` = :id AND `type` = 0", [
                                        ':ip' => $client['query'],
                                        ':id' => $user['id']
                                    ]);
                                    if ($c > 0) {
                                        $this->execute("UPDATE `log_users` SET
                                `time` = NOW(),
                                `day` = :d,
                                `hour` = :h,
                                `counter` = `counter` + 1
                                WHERE `user_id` = :id AND `ip` = :ip AND `type` = 0", [
                                            ':d' => getDates(),
                                            ':h' => date("H:i"),
                                            ':id' => $user['id'],
                                            ':ip' => $client['query']
                                        ]);
                                    } else {
                                        $this->execute("INSERT INTO `log_users` (`country`, `city`, `ip`, `time`, `day`, `hour`, `user`, `user_id`, `counter`)
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
                                        $this->execute("UPDATE `users` SET `cookie_token` = '', `last_ip` = :ip WHERE `id` = :id", [
                                            ':id' => $user['id'],
                                            ':ip' => $client['query'],
                                        ]);

                                        setcookie("cookie_token", "", time() - 3600);
                                    }

                                    $this->go('/profile');
                                }
                            } else {

                                $token = md5(md5($user['email'].random_str(10).time()));

                                $code = random_number(6);

                                $client = clientInfo(getIp());

                                $_SESSION["login-$token"] = [
                                    'id' => $user['id'],
                                    'email' => $user['email'],
                                    'type' => 'users',
                                    'check' => $check,
                                    'code' => $code
                                ];

                                $mail = new PHPMailer();


                                SENDMAIL($mail, "Подтверждение входа", $user['email'], $user['name'] . ' ' . $user['surname'], '
Здравствуйте!
Чтобы завершить вход, введите проверочный код

Локация: '.$client['country'].', '.$client['city'].'
Код проверки: <b>'.$code.'</b>

Если это были не вы, пожалуйста, немедленно измените свой пароль с помощью формы восстановления пароля на сайте или в личном кабинете, чтобы обезопасить свою учетную запись
');

                                $this->go('/login-confirm/?api='.$token);
                            }
                        } else {

                            $client = clientInfo(getIp());


                            $c = $this->rowCount("SELECT * FROM `log_users` WHERE `ip` = :ip AND `user_id` = :id AND `type` = 1", [
                                ':ip' => $client['query'],
                                ':id' => $user['id']
                            ]);
                            if ($c > 0) {
                                $this->execute("UPDATE `log_users` SET
                                `time` = NOW(),
                                `day` = :d,
                                `hour` = :h,
                                `counter` = `counter` + 1
                                WHERE `user_id` = :id AND `ip` = :ip AND `type` = 1", [
                                    ':d' => getDates(),
                                    ':h' => date("H:i"),
                                    ':id' => $user['id'],
                                    ':ip' => $client['query']
                                ]);
                            } else {

                                $this->execute("INSERT INTO `log_users` (`country`, `city`, `ip`, `time`, `day`, `hour`, `user`, `user_id`, `type`, `counter`)
                            VALUES (:coun, :cit, :ip, NOW(), :d, :h, :cn, :ci, :typ, :co)", [
                                    ':coun' => $client['country'],
                                    ':cit' => $client['city'],
                                    ':ip' => $client['query'],
                                    ':d' => getDates(),
                                    ':h' => date("H:i"),
                                    ':cn' => $user['name'] . ' ' . $user['surname'],
                                    ':ci' => $user['id'],
                                    ':typ' => 1,
                                    ':co' => 1
                                ]);
                            }

                            $this->go('/login/?error=1');
                        }
                    } else {$this->go('/login/?error=1');}
                } else {$this->go('/login/?error=1');}
            }
        }
    }

    public function notice($type, $id) {
        if ($type == 'company') {
            $stmt = $this->query("SELECT * FROM `notice` WHERE `company_id` = '$id' AND `status` = 0 AND `who` = 1 ORDER BY `id` DESC");
            $result = '';
            while ($n = $stmt->fetch()) {
                if ($n['type'] == 'company_respond') {
                    $stud = $this->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $n['user_id']]);
                    $job = $this->fetch("SELECT * FROM `vacancy` WHERE `id` = :id", [':id' => $n['job_id']]);
                    $result .= "<li class=\"notice notice-$n[id]\">
                                <form role=\"form\" method=\"GET\">
                                <div class=\"notice-wrap\">
                                    <span>У Вас новый отклик <m>$n[hour]</m></span>
                                    <p>Студент <a href=\"resume/?id=$stud[id]\">$stud[name] $stud[surname]</a>, откликнулся на вакансию - <a href=\"job/?id=$job[id]\">$job[title]</a></p>
                                    <div><a href=\"/responded\">Перейти</a><button onClick=\"noticeAjax('1', '$n[id]');return false;\" type=\"button\">ОК</button></div>
                                </div>
                                </form>
                            </li>";
                }
                if ($n['type'] == 'company_review') {
                    $stud = $this->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $n['user_id']]);
                    $result .= "<li class=\"notice notice-$n[id]\">
                                <form role=\"form\" method=\"GET\">
                                <div class=\"notice-wrap\">
                                    <span>У Вас новый отзыв <m>$n[hour]</m></span>
                                    <p>Студент <a href=\"resume/?id=$stud[id]\">$stud[name] $stud[surname]</a>, оставил отзыв о Вас</p>
                                    <div><a href=\"/company/?id=$n[company_id]\">Перейти</a><button onClick=\"noticeAjax('1', '$n[id]');return false;\" type=\"button\">ОК</button></div>
                                </div>
                                </form>
                            </li>";
                }
                if ($n['type'] == 'company_vacancy') {
                    $job = $this->fetch("SELECT * FROM `vacancy` WHERE `id` = :id AND `status` = 1", [':id' => $n['job_id']]);
                    $result .= "<li class=\"notice notice-$n[id]\">
                                <form role=\"form\" method=\"GET\">
                                <div class=\"notice-wrap\">
                                    <span>Вакансия закрылась <m>$n[hour]</m></span>
                                    <p>Вакансия - $job[title] закрылась, так как прошёл срок активности</p>
                                    <div><a></a><button onClick=\"noticeAjax('1', '$n[id]');return false;\" type=\"button\">ОК</button></div>
                                </div>
                                </form>
                            </li>";
                }
                if ($n['type'] == 'chat_message') {
                    $user = $this->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $n['user_id']]);
                    $chat = $this->fetch("SELECT * FROM `chat` WHERE `id` = :id", [':id' => $n['chat_id']]);
                    $result .= "<li class=\"notice notice-$n[id]\">
                                <form role=\"form\" method=\"GET\">
                                <div class=\"notice-wrap\">
                                    <span>У Вас новое сообщение <m>$n[hour]</m></span>
                                    <p>$chat[last_u] ($chat[last])  - <a href=\"resume/?id=$user[id]\">$user[name] $user[surname]</a></p>
                                    <div><a href=\"/messages/?id=$chat[id]\">Перейти</a><button onClick=\"noticeAjax('2', '$n[id]');return false;\" type=\"button\">ОК</button></div>
                                </div>
                                </form>
                            </li>";
                }
            }
            return $result;
        }
        if ($type == 'users') {
            $stmt = $this->query("SELECT * FROM `notice` WHERE `user_id` = '$id' AND `status` = 0 AND `who` = 2 ORDER BY `id` DESC");
            $result = '';
            while ($n = $stmt->fetch()) {
                if ($n['type'] == 'invite') {
                    $company = $this->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $n['company_id']]);
                    $result .= "<li class=\"notice notice-$n[id]\">
                                <form role=\"form\" method=\"GET\">
                                <div class=\"notice-wrap\">
                                    <span>У Вас приглашение <m>$n[hour]</m></span>
                                    <p>Компания <a href=\"company/?id=$company[id]\">$company[name]</a> пригласила Вас на работу к себе</p>
                                    <div><a href=\"/me-respond\">Перейти</a><button onClick=\"noticeAjax('2', '$n[id]');return false;\" type=\"button\">ОК</button></div>
                                </div>
                                </form>
                            </li>";
                }
                if ($n['type'] == 'reset_status') {
                    $company = $this->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $n['company_id']]);
                    $result .= "<li class=\"notice notice-$n[id]\">
                                <form role=\"form\" method=\"GET\">
                                <div class=\"notice-wrap\">
                                    <span>Изменён статус отклика <m>$n[hour]</m></span>
                                    <p>Компания <a href=\"company/?id=$company[id]\">$company[name]</a> изменила статус Вашего на отклика</p>
                                    <div><a href=\"/me-respond\">Перейти</a><button onClick=\"noticeAjax('2', '$n[id]');return false;\" type=\"button\">ОК</button></div>
                                </div>
                                </form>
                            </li>";
                }
                if ($n['type'] == 'user_chat') {
                    $company = $this->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $n['company_id']]);
                    $result .= "<li class=\"notice notice-$n[id]\">
                                <form role=\"form\" method=\"GET\">
                                <div class=\"notice-wrap\">
                                    <span>С Вами начали чат <m>$n[hour]</m></span>
                                    <p>Компания <a href=\"company/?id=$company[id]\">$company[name]</a>, начала с Вами чат</p>
                                    <div><a href=\"/messages\">Перейти</a><button onClick=\"noticeAjax('2', '$n[id]');return false;\" type=\"button\">ОК</button></div>
                                </div>
                                </form>
                            </li>";
                }
                if ($n['type'] == 'chat_message') {
                    $company = $this->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $n['company_id']]);
                    $chat = $this->fetch("SELECT * FROM `chat` WHERE `id` = :id", [':id' => $n['chat_id']]);
                    $result .= "<li class=\"notice notice-$n[id]\">
                                <form role=\"form\" method=\"GET\">
                                <div class=\"notice-wrap\">
                                    <span>У Вас новое сообщение <m>$n[hour]</m></span>
                                    <p>$chat[last_c] ($chat[last])  - <a href=\"company/?id=$company[id]\">$company[name]</a></p>
                                    <div><a href=\"/messages/?id=$chat[id]\">Перейти</a><button onClick=\"noticeAjax('2', '$n[id]');return false;\" type=\"button\">ОК</button></div>
                                </div>
                                </form>
                            </li>";
                }
            }
            return $result;
        }
    }
}


















