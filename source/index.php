<?php

/**
 *
 * ПЕРЕНЕСТИ ВСЁ НА MVC - ЖЕЛАТЕЛЬНО
 *
 * @TODO
 *      @admin
 *          — правка вакансий
 *          — правка компаний и студентов
 *          — модерация на сайте
 *          — чат с компаниями
 *          — СТАТИСТИКА - СБОР ИНФОРМАЦИИ
 *      @company
 *          — "есть идея"
 *          — настройки
 *          — black list
 *      @user
 *          — доработать страницу резюме
 *          — настройки
 *          — black list
 *      В ближайшем будущем добавить роли @moder и @office
 */




/**
 * ЭТО - ТОЧКА ВХОДА
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use core\Singleton;

use Core\App;
use Core\Login;
use Core\Crypto;
use Core\Session;
use Core\Router;
use Core\View;
use Core\Pagination;

use Work\plugin\lib\pQuery;

# Конфигурации
require_once 'settings/config.php';
require_once 'settings/functions.php';

# Дополнительный функционал
require_once 'vendor/PHPMailer/src/PHPMailer.php';
require_once 'vendor/PHPMailer/src/Exception.php';
require_once 'vendor/Mobile-Detect/Mobile_Detect.php';
require_once 'classes/Singleton.php';
require_once 'classes/App.php';
require_once 'classes/Login.php';
require_once 'classes/Crypto.php';
require_once 'classes/Session.php';
require_once 'classes/Router.php';
require_once 'classes/View.php';
require_once 'classes/Pagination.php';
require_once 'classes/pQuery.php';

Session::instance()->start();

ob_start();

$mail = new PHPMailer();

$app = new App('mysql:host='.$config['db']['host'].';dbname='.$config['db']['dbname'], $config['db']['user'], $config['db']['password']);

$view = new View();

$paginator = new Pagination();

Router::instance()->autoLoadClass();

$detect = new Mobile_Detect;

# ! Подключение PDO - УБРАТЬ

#$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    global $PDO;
    $PDO = new PDO('mysql:host='.$config['db']['host'].';dbname='.$config['db']['dbname'], $config['db']['user'], $config['db']['password'], $opt);
} catch (PDOException $e) {
    die($e->getMessage());
}



# Проверка BLACK LIST IP
$client = clientInfo(getIp());

$c = $app->rowCount("SELECT * FROM `black_list` WHERE `ip` = :ip", [
    ':ip' => $client['query'],
]);

if ($c) {
    exit("<div>
<h1>403 Forbidden</h1>
<span>Доступ запрещён администратором</span>

</div>");
}


$TIMER_JOB = 16;


$WORK_PROCCESS = 0;

if ($WORK_PROCCESS == 1) {
    if (trim($client['query']) == trim('31.180.197.61')) {

    } else {

        exit('<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <title>ТЕХНИЧЕСКИЙ ПЕРЕРЫВ</title>
    <link rel="icon" href="/static/image/favicon.ico" type="image/x-icon">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f5f5f5;
            color: #333333;
        }
        main {
            font-family: "Poppins", -apple-system, BlinkMacSystemFont, "Segoe UI", "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            max-width: 70%;
            margin: 100px auto 0 auto;
            padding: 20px;
            font-size: 20px;         
        }
        h1, p {
            margin: 0;
            padding: 0;
        }
        p {
            margin: 3px 0 0 0;
            font-size: 17px;
        }
        .ico-cnt {
            display: flex;
            align-items: center;
            margin: 0 0 22px 0;
        }
        .ico-cnt span {
            display: block;
        }
        
        .ic-le {
            width: 55px;
            height: 55px;
        }
        .ic-le img {
            width: 100%;
        }
        .ic-ri {
            font-size: 29px;
            font-weight: 800;
            color: #2d2d2d;
            margin: 0 0 0 10px;
            transition: all 0.2s linear;
        }
        .ic-ri m {
            font-weight: 400;
            font-size: 27px;
        }
        .ic-ri:hover {
            color: #1967D2;
        }
    </style>
</head>
<body>
    <main>
        <div class="ico-cnt">
                <span class="ic-le">
                    <img src="/static/image/ico/logo.png" alt="">
                </span>
                <a target="_blank" href="http://www.stgau.ru/cstv/" class="ic-ri">
                    СтГАУ <m>Агрокадры</m>
                </a>
        </div>
        <h1>ТЕХНИЧЕСКИЙ ПЕРЕРЫВ</h1>
        <p>Приносим извинения за неудобства. В настоящий момент на сайте ведутся технические работы.</p>
    </main>
</body>
</html>');
    }
}



if(isset($_COOKIE["cookie_token"]) && !empty($_COOKIE["cookie_token"])) {
    $company = $app->fetch("SELECT * FROM `company` WHERE `cookie_token` = :token AND `last_ip` = :ip",
        [
            ':token' => $_COOKIE["cookie_token"],
            ':ip' => $client['query']
        ]);
    $user = $app->fetch("SELECT * FROM `users` WHERE `cookie_token` = :token AND `last_ip` = :ip",
        [
            ':token' => $_COOKIE["cookie_token"],
            ':ip' => $client['query']
        ]);
    if (isset($company['id']) && empty($user['id'])) {
        $_SESSION['company'] = $company['name'];
        $_SESSION['password'] = $company['password'];
        $_SESSION['id'] = $company['id'];
        $_SESSION['email'] = $company['email'];
        $_SESSION['type'] = 'company';
        $_SESSION['token'] = hash('sha256', time() . random_str(25));
    }

    if (empty($company['id']) && isset($user['id'])) {
        $_SESSION['surname'] = $user['surname'];
        $_SESSION['password'] = $user['password'];
        $_SESSION['id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['type'] = 'users';
        $_SESSION['token'] = hash('sha256', time() . random_str(25));
    }

}

if ($_SERVER['REQUEST_URI'] === '/') {
    $Page = 'home';
    $Module = 'home';
} else {
    $URL_Path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $URL_Parts = explode('/', trim($URL_Path, ' /'));

    $Page = array_shift($URL_Parts);
    $Module = array_shift($URL_Parts);

    if (!empty($Module)) {
        $Param = array();

        foreach ($URL_Parts as $i => $iValue) {
            $Param[$iValue] = $URL_Parts[++$i];
        }
    } else {
        $Module = '';
    }
}

if (in_array($Page, [
    'sitemap',
    'sitemap.xml',
])) {
    include 'sitemap.php';
}




# МАРШУТИЗАТОР
if (in_array($Page, $routes['base'])) {
    include 'layout/' . $Page . '.php';
} else if (in_array($Page, $routes['auth'])) {
    include 'auth/' . $Page . '.php';
} else if ($Page == 'scripts' && in_array($Module, $routes['scripts'])) {
    include 'scripts/' . $Module . '.php';
} else if (in_array($Page, $routes['guest'])) {
    include 'guests/' . $Page . '.php';
} else if ($Page == 'admin' && in_array($Module, $routes['admin']) && $_SESSION['type'] == 'admin') {
    include 'admin/' . $Module . '.php';
} else if ($Page == 'admin' && in_array($Module, $routes['admin-scripts']) && $_SESSION['type'] == 'admin') {
    include 'admin/proc/' . $Module . '.php';
} else if ($Page == 'registers' && in_array($Module, $routes['guest-module-confirm'])) {
    include 'guests/registers/' . $Module . '.php';
} else if ($Page == 'create' && in_array($Module, $routes['guest-module-create'])) {
    include 'guests/create/' . $Module . '.php';
} else {
    $app->notFound();
}



/**
 * ЗАЩИТА GET ПАРАМЕТРОВ
 */
foreach ($_GET as $k => $v) {
    if (is_array($v)) {
        foreach ($v as $Kk => $Vv) {
            $Vv = preg_replace ( "'<script[^>]*?>.*?</script>'si", "", $Vv);
            $Vv = str_replace($xss,"",$Vv);
            $Vv = str_replace (array("*","\\"), "", $Vv );
            $Vv = strip_tags($Vv);
            $Vv = htmlentities($Vv, ENT_QUOTES, "UTF-8");
            $Vv = htmlspecialchars($Vv, ENT_QUOTES);
            $_GET[$k][$Kk] = $Vv;
        }
    } else {
        $v = preg_replace ( "'<script[^>]*?>.*?</script>'si", "", $v );
        $v = str_replace($xss,"",$v);
        $v = str_replace (array("*","\\"), "", $v );
        $v = strip_tags($v);
        $v = htmlentities($v, ENT_QUOTES, "UTF-8");
        $v = htmlspecialchars($v, ENT_QUOTES);
        $_GET[$k] = $v;
    }
}




$countIp = $app->rowCount("SELECT * FROM `ip` WHERE `ip` = :ip", [':ip' => $client['query']]);

if ($countIp > 0) {
    $countIpTime = $app->rowCount("SELECT * FROM `ip` WHERE `ip` = :ip AND `time` < SUBTIME(NOW(), '0 0:10:0')", [':ip' => $client['query']]);
    if ($countIpTime > 0) {
        $app->execute("UPDATE `ip` SET 
                        `time` = NOW(),
                        `counter` = `counter` + 1,
                        `date` = :dat,
                        `hour` = :h WHERE `ip` = :ip",
            [
                ':dat' => getDates(),
                ':h' => date("H:i"),
                ':ip' => $client['query']
            ]);
    }
} else {
    if (is_bot() == 1) {
        $app->execute("INSERT INTO `ip` (`ip`, `country`, `city`, `time`, `date`, `hour`, `counter`) VALUES (:ip, :coun, :city, NOW(), :dat, :h, :co)",
            [
                ':ip' => $client['query'],
                ':coun' => $client['country'],
                ':city' => $client['city'],
                ':dat' => getDates(),
                ':h' => date("H:i"),
                ':co' => 1
            ]
        );
    }
}



if (isset($_SESSION['id'])) {
    $user = $_SESSION['id'];
} else {
    $user = 'guest';
}

if (isset($_SESSION['id'])) {
    if ($_SESSION['type'] == 'company') {
        $stmt2 = $PDO->prepare("SELECT * FROM `visits` WHERE `name` = ? AND `type` = 'company' AND `day` = ? AND `year` = ?");
        $stmt2->execute([$_SESSION['id'], $Date_ru, date("Y")]);
        if ($stmt2->rowCount() > 0) {
            $stmt = $PDO->prepare("SELECT * FROM `visits` WHERE `name` = ? AND `type` = 'company' AND `day` = ? AND `year` = ? AND `time` < SUBTIME(NOW(), '0 0:5:0')");
            $stmt->execute([$_SESSION['id'], $Date_ru, date("Y")]);
            if ($stmt->rowCount() > 0) {
                $app->execute("UPDATE `visits` SET
                    `counter` = `counter` + 1,
                    `hour` = :h,
                    `time` = NOW(),
                    `ip` = :ip
            WHERE `name` = :n AND `type` = 'company' AND `day` = :d AND `year` = :yr", [
                    ':h' => date("H:i"),
                    ':ip' => getIp(),
                    ':n' => $_SESSION['id'],
                    ':d' => $Date_ru,
                    ':yr' => date("Y"),
                ]);
            }
        } else {
            $app->execute("INSERT INTO `visits` (`day`, `hour`, `time`, `counter`, `type`, `ip`, `name`, `year`) 
        VALUES(:dat, :h, NOW(), :counts, :typ, :ip, :n, :yr)", [
                ':dat' => $Date_ru,
                ':h' => date("H:i"),
                ':counts' => 1,
                ':typ' => $_SESSION['type'],
                ':ip' => getIp(),
                ':n' => $_SESSION['id'],
                ':yr' => date("Y"),
            ]);
        }
    }
    if ($_SESSION['type'] == 'users') {
        $stmt2 = $PDO->prepare("SELECT * FROM `visits` WHERE `name` = ? AND `type` = 'users' AND `day` = ? AND `year` = ?");
        $stmt2->execute([$_SESSION['id'], $Date_ru, date("Y")]);
        if ($stmt2->rowCount() > 0) {
            $stmt = $PDO->prepare("SELECT * FROM `visits` WHERE `name` = ? AND `type` = 'users' AND `day` = ? AND `year` = ? AND `time` < SUBTIME(NOW(), '0 0:5:0')");
            $stmt->execute([$_SESSION['id'], $Date_ru, date("Y")]);
            if ($stmt->rowCount() > 0) {
                $app->execute("UPDATE `visits` SET
                    `counter` = `counter` + 1,
                    `hour` = :h,
                    `time` = NOW(),
                    `ip` = :ip
            WHERE `name` = :n AND `type` = 'users' AND `day` = :d AND `year` = :yr", [
                    ':h' => date("H:i"),
                    ':ip' => getIp(),
                    ':n' => $_SESSION['id'],
                    ':d' => $Date_ru,
                    ':yr' => date("Y"),
                ]);
            }
        } else {
            $app->execute("INSERT INTO `visits` (`day`, `hour`, `time`, `counter`, `type`, `ip`, `name`, `year`) 
        VALUES(:dat, :h, NOW(), :counts, :typ, :ip, :n, :yr)", [
                ':dat' => $Date_ru,
                ':h' => date("H:i"),
                ':counts' => 1,
                ':typ' => $_SESSION['type'],
                ':ip' => getIp(),
                ':n' => $_SESSION['id'],
                ':yr' => date("Y"),
            ]);
        }
    }
} else {
    if (is_bot() == 1) {
        $stmt2 = $PDO->prepare("SELECT * FROM `visits` WHERE `ip` = ? AND `type` = 'guest' AND `day` = ? AND `year` = ?");
        $stmt2->execute([getIp(), $Date_ru, date("Y")]);
        if ($stmt2->rowCount() > 0) {
            $stmt = $PDO->prepare("SELECT * FROM `visits` WHERE `ip` = ? AND `type` = 'guest' AND `day` = ? AND `year` = ? AND `time` < SUBTIME(NOW(), '0 0:5:0')");
            $stmt->execute([getIp(), $Date_ru, date("Y")]);
            if ($stmt->rowCount() > 0) {
                $app->execute("UPDATE `visits` SET
                    `counter` = `counter` + 1,
                    `hour` = :h,
                    `time` = NOW()
            WHERE `ip` = :ip AND `type` = 'guest' AND `day` = :d AND `year` = :yr", [
                    ':h' => date("H:i"),
                    ':ip' => getIp(),
                    ':d' => $Date_ru,
                    ':yr' => date("Y"),
                ]);
            }
        } else {
            $app->execute("INSERT INTO `visits` (`day`, `hour`, `time`, `counter`, `type`, `ip`, `year`) 
        VALUES(:dat, :h, NOW(), :counts, :typ, :ip, :yr)", [
                ':dat' => $Date_ru,
                ':h' => date("H:i"),
                ':counts' => 1,
                ':typ' => 'guest',
                ':ip' => getIp(),
                ':yr' => date("Y"),
            ]);
        }
    }
}


if ($user !== 'guest' || isset($_SESSION['id'])) {
    $online = $app->fetch("SELECT * FROM `online` WHERE `id` = :id AND `type` = :typ", [
        ':id' => $user,
        ':typ' => $_SESSION['type']
    ]);
    if (isset($online['id'])) {
        $app->execute("UPDATE `online` SET `times` = NOW(), `url` = :url WHERE `id` = :id AND `type` = :typ", [
            ':id' => $user,
            ':url' => getUrl(),
            ':typ' => $_SESSION['type']
        ]);
    } else {
        $app->execute("INSERT INTO `online` (`ip`, `id`, `times`, `type`, `url`) VALUES(:ip, :id, NOW(), :typ, :url)", [
            ':ip' => getIp(),
            ':id' => $user,
            ':typ' => $_SESSION['type'],
            ':url' => getUrl(),
        ]);
    }
} else {
    if (is_bot() == 1) {
        $online = $app->fetch("SELECT * FROM `online` WHERE `ip` = :ip AND `type` = 'guest'", [
            ':ip' => getIp()
        ]);
        if (isset($online['ip'])) {
            $app->execute("UPDATE `online` SET `times` = NOW(), `url` = :url WHERE `ip` = :ip AND `type` = 'guest'", [
                ':ip' => getIp(),
                ':url' => getUrl(),
            ]);
        } else {
            $app->execute("INSERT INTO `online` (`ip`, `id`, `times`, `type`, `url`) VALUES(:ip, :id, NOW(), :typ, :url)", [
                ':ip' => getIp(),
                ':id' => $user,
                ':typ' => 'guest',
                ':url' => getUrl(),
            ]);
        }
    }
}

