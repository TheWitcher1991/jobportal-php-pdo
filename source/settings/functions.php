<?php

function calculate_age($birthday) {
    $birthday_timestamp = strtotime($birthday);
    $age = date('Y') - date('Y', $birthday_timestamp);
    if (date('md', $birthday_timestamp) > date('md')) {
        $age--;
    }
    return $age;
}

function getPeriod($date1,$date2){
    $interval = date_diff($date1, $date2);
    $y='';
    $m='';

    if ($interval->y>0) {
        if ($interval->y>4)
            $y .=$interval->y . ' лет';
        else if ($interval->y == 1)
            $y .=$interval->y . ' год';
        else
            $y .=$interval->y . ' года';
        $y .= ' ';
    }

    if ($interval->m>0) {
        if ($interval->m>4)
            $m .= $interval->m . ' месяцев';
        else if ($interval->m>1)
            $m .= $interval->m . ' месяца';
        else
            $m .= $interval->m . ' месяц';
    }

    return $y . $m;
}

function phone_format($phone)
{
    $phone = trim($phone);

    $res = preg_replace(
        array(
            '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{3})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
            '/[\+]?([7|8])[-|\s]?(\d{3})[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
            '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
            '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
            '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{3})/',
            '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{3})[-|\s]?(\d{3})/',
        ),
        array(
            '+7 $2 $3-$4-$5',
            '+7 $2 $3-$4-$5',
            '+7 $2 $3-$4-$5',
            '+7 $2 $3-$4-$5',
            '+7 $2 $3-$4',
            '+7 $2 $3-$4',
        ),
        $phone
    );

    return $res;
}

function phone_format2($phone)
{
    $phone = trim($phone);

    $res = preg_replace(
        array(
            '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{3})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
            '/[\+]?([7|8])[-|\s]?(\d{3})[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
            '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
            '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
            '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{3})/',
            '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{3})[-|\s]?(\d{3})/',
        ),
        array(
            '7$2$3$4$5',
            '7$2$3$4$5',
            '7$2$3$4$5',
            '7$2$3$4$5',
            '7$2$3$4',
            '7$2$3$4',
        ),
        $phone
    );

    return $res;
}

$denimg = array(
    'phtml', 'php', 'php3', 'php4', 'php5', 'php6', 'php7', 'phps', 'cgi', 'pl', 'asp',
    'aspx', 'shtml', 'shtm', 'htaccess', 'htpasswd', 'ini', 'log', 'sh', 'js', 'html',
    'htm', 'css', 'sql', 'spl', 'scgi', 'fcgi'
);

$converter = array(
    'а' => 'a',   'б' => 'b',   'в' => 'v',    'г' => 'g',   'д' => 'd',   'е' => 'e',
    'ё' => 'e',   'ж' => 'zh',  'з' => 'z',    'и' => 'i',   'й' => 'y',   'к' => 'k',
    'л' => 'l',   'м' => 'm',   'н' => 'n',    'о' => 'o',   'п' => 'p',   'р' => 'r',
    'с' => 's',   'т' => 't',   'у' => 'u',    'ф' => 'f',   'х' => 'h',   'ц' => 'c',
    'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',  'ь' => '',    'ы' => 'y',   'ъ' => '',
    'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

    'А' => 'A',   'Б' => 'B',   'В' => 'V',    'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
    'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',    'И' => 'I',   'Й' => 'Y',   'К' => 'K',
    'Л' => 'L',   'М' => 'M',   'Н' => 'N',    'О' => 'O',   'П' => 'P',   'Р' => 'R',
    'С' => 'S',   'Т' => 'T',   'У' => 'U',    'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
    'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',  'Ь' => '',    'Ы' => 'Y',   'Ъ' => '',
    'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
);

function generate_password($number)
{
    $arr = array('a','b','c','d','e','f',
        'g','h','i','j','k','l',
        'm','n','o','p','r','s',
        't','u','v','x','y','z',
        'A','B','C','D','E','F',
        'G','H','I','J','K','L',
        'M','N','O','P','R','S',
        'T','U','V','X','Y','Z',
        '1','2','3','4','5','6',
        '7','8','9','0','.',',',
        '(',')','[',']','!','?',
        '&','^','%','@','*','$',
        '<','>','/','|','+','-',
        '{','}','`','~');
    // Генерируем пароль
    $pass = "";
    for($i = 0; $i < $number; $i++)
    {
        $index = rand(0, count($arr) - 1);
        $pass .= $arr[$index];
    }
    return $pass;
}

$monthes = [
    1 => '01',
    2 => '02',
    3 => '03',
    4 => '04',
    5 => '05',
    6 => '06',
    7 => '07',
    8 => '08',
    9 => '09',
    10 => '10',
    11 => '11',
    12 => '12'
];

$monthes_ru = [
    1 => 'января',
    2 => 'февраля',
    3 => 'марта',
    4 => 'апреля',
    5 => 'мая',
    6 => 'июня',
    7 => 'июля',
    8 => 'августа',
    9 => 'сентября',
    10 => 'октября',
    11 => 'ноября',
    12 => 'декабря'
];

$arr_m = [
    1 => 'январь',
    2 => 'февраль',
    3 => 'март',
    4 => 'апрель',
    5 => 'май',
    6 => 'июнь',
    7 => 'июль',
    8 => 'август',
    9 => 'сентябрь',
    10 => 'октябрь',
    11 => 'ноябрь',
    12 => 'декабрь'
];

$Date = date('d') . '.' . $monthes[(date('n'))] . '.' . date('Y');

$Date_ru = date('d') . ' ' . $monthes_ru[(date('n'))];

function getDates() {
    $monthes = [
        1 => 'января',
        2 => 'февраля',
        3 => 'марта',
        4 => 'апреля',
        5 => 'мая',
        6 => 'июня',
        7 => 'июля',
        8 => 'августа',
        9 => 'сентября',
        10 => 'октября',
        11 => 'ноября',
        12 => 'декабря'
    ];
    return date('d') . ' ' . $monthes[(date('n'))] . ' ' . date('Y');
}

function get_minification_array($text) {
    $text = stripslashes($text);
    $text = html_entity_decode($text);
    $text = htmlspecialchars_decode($text, ENT_QUOTES);
    $text = strip_tags($text);
    $text = mb_strtolower($text);
    $text = str_ireplace('ё', 'е', $text);
    $text = mb_eregi_replace("[^a-zа-яй0-9 ]", ' ', $text);
    $text = mb_ereg_replace('[ ]+', ' ', $text);
    $words = explode(' ', $text);
    $words = array_unique($words);
    $array = array(
        'без',  'близ',  'в',     'во',     'вместо', 'вне',   'для',    'до',
        'за',   'и',     'из',    'изо',    'из',     'за',    'под',    'к',
        'ко',   'кроме', 'между', 'на',     'над',    'о',     'об',     'обо',
        'от',   'ото',   'перед', 'передо', 'пред',   'предо', 'по',     'под',
        'подо', 'при',   'про',   'ради',   'с',      'со',    'сквозь', 'среди',
        'у',    'через', 'но',    'или',    'по'
    );
    $words = array_diff($words, $array);
    $words = array_diff($words, array(''));
    return $words;
}

function getUrl() {
    $url = $_SERVER['REQUEST_URI'];
    return $url;
}

function explodeUrl() {
    $url = $_SERVER['REQUEST_URI'];
    $url = explode('?', $url);
    return $url[0];
}

function is_bot()
{
    if (!empty($_SERVER['HTTP_USER_AGENT'])) {
        $options = array(
            'YandexBot', 'YandexAccessibilityBot', 'YandexMobileBot','YandexDirectDyn',
            'YandexScreenshotBot', 'YandexImages', 'YandexVideo', 'YandexVideoParser',
            'YandexMedia', 'YandexBlogs', 'YandexFavicons', 'YandexWebmaster',
            'YandexPagechecker', 'YandexImageResizer','YandexAdNet', 'YandexDirect',
            'YaDirectFetcher', 'YandexCalendar', 'YandexSitelinks', 'YandexMetrika',
            'YandexNews', 'YandexNewslinks', 'YandexCatalog', 'YandexAntivirus',
            'YandexMarket', 'YandexVertis', 'YandexForDomain', 'YandexSpravBot',
            'YandexSearchShop', 'YandexMedianaBot', 'YandexOntoDB', 'YandexOntoDBAPI',
            'Googlebot', 'Googlebot-Image', 'Mediapartners-Google', 'AdsBot-Google',
            'Mail.RU_Bot', 'bingbot', 'Accoona', 'ia_archiver', 'Ask Jeeves', 'Y!J-ASR',
            'OmniExplorer_Bot', 'W3C_Validator', 'WebAlta', 'YahooFeedSeeker', 'Yahoo!',
            'Ezooms', '', 'Tourlentabot', 'MJ12bot', 'AhrefsBot', 'SearchBot', 'SiteStatus',
            'Nigma.ru', 'Baiduspider', 'Statsbot', 'SISTRIX', 'AcoonBot', 'findlinks',
            'proximic', 'OpenindexSpider','statdom.ru', 'Exabot', 'Spider', 'SeznamBot',
            'oBot', 'C-T bot', 'Updownerbot', 'Snoopy', 'heritrix', 'Yeti', 'WellKnownBot',
            'DomainVader', 'DCPbot', 'PaperLiBot', 'CNCat', 'DeuSu', 'DotBot', 'linkdexbot',
            'meanpathbot', 'SemrushBot', 'WebArtexBot', 'Slurp', 'MSNBot', 'Teoma', 'Scooter',
            'Lycos', 'StackRambler', 'Aport', 'WebAlta Crawler/2.0', 'SeopultContentAnalyzer',
            'BLEXBot', 'DataForSeoBot', 'Barkrowler', 'Serendeputy', 'netEstate NE Crawler', 'CCBot',
            'MegaIndex.ru', 'Serpstatbot', 'ZoominfoBot', 'Linkfluence', 'NetcraftSurveyAgent', 'weborama',
            'Screaming Frog SEO Spider', 'PR-CY.RU', 'paloaltonetworks', 'Scrapy', 'Nuclei', 'rogerbot'
        );

        foreach($options as $row) {
            if (stripos($_SERVER['HTTP_USER_AGENT'], $row) !== false) {
                return 1;
            }
        }
    }

    return 0;
}

function getIp() {
    $keys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'REMOTE_ADDR'
    ];
    foreach ($keys as $key) {
        if (!empty($_SERVER[$key])) {
            $array = explode(',', $_SERVER[$key]);
            $ip = trim(end($array));
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }
}

function clientInfo ($ip) {
    $ch = curl_init('http://ip-api.com/json/' . $ip . '?lang=ru');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}

function clear($dt) {
    $dt = stripslashes($dt);
    $dt = strip_tags($dt);
    return trim($dt);
}

function get_params() {
    $url = $_SERVER['REQUEST_URI'];
    $url = explode('?', $url);
    $uri = $url[0];
    if (isset($url[1]) && $url[1] != '') {
        $uri .= '?';
        $params = explode('&', $url[1]);
        foreach ($params as $param) {
            if (!preg_match("#page=#", $param)) {
                $uri .= "{$param}&";
            }
        }
    }
    return $uri;
}

function random_str ($num) {
    return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxzyABCDEFGHIJKLMNOPQRSTUVWXZY!?@#$%^&*()_-'), 0, $num);
}

function random_number($length = 6): string
{
    $arr = array(
        '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
    );
    $res = '';
    for ($i = 0; $i < $length; $i++) {
        $res .= $arr[random_int(0, count($arr) - 1)];
    }
    return $res;
}

function debug($data) {
    echo "<pre>" . print_r($data) . "</pre>";
}

$xss = "ASC,DESC,asc,desc,onabort,oncanplay,oncanplaythrough,ondurationchange,onemptied,onended,onerror,onloadeddata,onloadedmetadata,onloadstart,onpause,onplay,
onplaying,onprogress,onratechange,onseeked,onseeking,onstalled,onsuspend,ontimeupdate,onvolumechange,onwaiting,oncopy,oncut,onpaste,ondrag,
ondragend,ondragenter,ondragleave,ondragover,ondragstart,ondrop,onblur,onfocus,onfocusin,onfocusout,onchange,oninput,oninvalid,onreset,onsearch,
onselect,onsubmit,onabort,onbeforeunload,onerror,onhashchange,onload,onpageshow,onpagehide,onresize,onscroll,onunload,onkeydown,onkeypress,onkeyup,
altKey,ctrlKey,shiftKey,metaKey,key,keyCode,which,charCode,location,onclick,ondblclick,oncontextmenu,onmouseover,onmouseenter,onmouseout,
onmouseleave,onmouseup,onmousemove,onwheel,altKey,ctrlKey,shiftKey,metaKey,button,buttons,which,clientX,clientY,detail,relatedTarget,screenX,
screenY,deltaX,deltaY,deltaZ,deltaMode,animationstart,animationend,animationiteration,animationName,elapsedTime,propertyName,elapsedTime,
transitionend,onerror,onmessage,onopen,ononline,onoffline,onstorage,onshow,ontoggle,onpopstate,ontouchstart,ontouchmove,ontouchend,ontouchcancel,persisted,javascript";
$xss = explode(",", trim($xss));

function XSS_DEFENDER($data) {
    $xss = "ASC,DESC,asc,desc,onabort,oncanplay,oncanplaythrough,ondurationchange,onemptied,onended,onerror,onloadeddata,onloadedmetadata,onloadstart,onpause,onplay,
    onplaying,onprogress,onratechange,onseeked,onseeking,onstalled,onsuspend,ontimeupdate,onvolumechange,onwaiting,oncopy,oncut,onpaste,ondrag,
    ondragend,ondragenter,ondragleave,ondragover,ondragstart,ondrop,onblur,onfocus,onfocusin,onfocusout,onchange,oninput,oninvalid,onreset,onsearch,
    onselect,onsubmit,onabort,onbeforeunload,onerror,onhashchange,onload,onpageshow,onpagehide,onresize,onscroll,onunload,onkeydown,onkeypress,onkeyup,
    altKey,ctrlKey,shiftKey,metaKey,key,keyCode,which,charCode,location,onclick,ondblclick,oncontextmenu,onmouseover,onmouseenter,onmouseout,
    onmouseleave,onmouseup,onmousemove,onwheel,altKey,ctrlKey,shiftKey,metaKey,button,buttons,which,clientX,clientY,detail,relatedTarget,screenX,
    screenY,deltaX,deltaY,deltaZ,deltaMode,animationstart,animationend,animationiteration,animationName,elapsedTime,propertyName,elapsedTime,
    transitionend,onerror,onmessage,onopen,ononline,onoffline,onstorage,onshow,ontoggle,onpopstate,ontouchstart,ontouchmove,ontouchend,ontouchcancel,persisted,javascript";
    $xss = explode(",", trim($xss));
    $v = preg_replace ( "'<script[^>]*?>.*?</script>'si", "", $data);
    $v = str_replace($xss,"",$v);
    $v = str_replace (array("*","\\"), "", $v);
    $v = strip_tags($v);
    $v = htmlentities($v, ENT_QUOTES, "UTF-8");
    return htmlspecialchars($v, ENT_QUOTES);
}



function addWhere($where, $add, $and = true) {
    if ($where) {
        if ($add) $where .= " AND $add";
        else $where .= " OR $add";
    }
    else $where = $add;
    return $where;
}


function SENDMAIL($mail, $subject, $email, $name, $content) {
    $mail->setFrom('admin@stgaujob.ru', 'Администратор СтГАУ Агрокадры');
    $mail->addAddress($email, $name);
    $mail->CharSet = "utf-8";
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = '
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <style>
    .go-bth {
            margin: 16px 0 0 0;
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
            display: inline-block;
        }
    </style>
</head>
<body style="width: 100%;
            max-width: 100%;
            display: block;
            height: 100%;
            margin: 0;
            padding: 20px;
            background: #fafafa;
            color: #333;
            line-height: 1.4;
            
            font: normal 16px -apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Ubuntu,Helvetica Neue,Oxygen,Cantarell,Arial,sans-serif;">
    <main id="wrapper" style="margin: 0;
            padding: 30px 0;
            max-width: 600px;
            display: flex;
            width: 100%;
            flex-direction: column;
            justify-content: center;
            align-items: center;">
        <div class="logo" style="margin: 20px auto;display: flex;align-items: center;justify-content: center;text-align: center;width: 100%;">   
           
        
                <a style="font-size: 24px;
                color: #111;
                display: block;
                font-weight: 700;
                width: 100%;
                text-align: center;
                text-decoration: none;" target="_blank" href="http://stgaujob.ru/">СтГАУ Агрокадры</a>
            
        </div>
        <div class="content" style="background: #fff;
            padding: 40px;
            max-width: 520px;
            margin: 20px auto;
            border-radius: 4px;
            border: 1px solid #dddddd;">
            <h1 style=" font-size: 19px;
            margin: 0 0 16px 0;
            padding: 0;">'.$subject.'</h1>
            <pre style="word-break: break-all;
            white-space: break-spaces;
            font-size: 14px;
            font-family: -apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Ubuntu,Helvetica Neue,Oxygen,Cantarell,Arial,sans-serif;
            line-height: 26px;
            color: #202124;">'.$content.'</pre>
            <div class="info" style="margin: 0 0 0 0;
            padding: 20px 0 0 0;
            border-top: 1px solid #e1e4e8;
            color: #959da5;
            font-size: 13px;">
                <span style="">С уважением, администратор <a target="_blank" href="http://stgaujob.ru/">СтГАУ Агрокадры</a>.</span> 
                <p style="margin-bottom: 0;">Вы получили это письмо потому, что ваш email-адрес указан в качестве email-адреса клиента регистратора СтГАУ Агрокадры.</p>
            </div>
        </div>
</main>
</body>
</html>
';
    return $mail->send();
}




function MAILSs($subject, $email, $content) {
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= 'From: Администратор stgaujob.ru' . "\r\n";



    $text = "<!DOCTYPE html>
    <html lang='ru'>
    <head>
        <title>$subject</title>
        <meta charset='UTF-8'>
        <link href='https://fonts.googleapis.com/css?family=Nunito:400,600,600i,700,700i,800,800i,900,900i&display=swap&subset=latin-ext,vietnamese' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i,900,900i&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese' rel='stylesheet'>
        <style>
            * {
                box-sizing: border-box;
            }
            body {
                background: #ebeef2;
                font-size: 15px;
                font-weight: normal;
                color: #222;
                margin: 0;
                padding: 0;
                font-family: 'Nunito', sans-serif;
            }
            #wrapper {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                background: #ebeef2;
            }
            .title {
                margin: 0;
                background: #fff;
                color: #1967d2;
                width: 100%;
            }
            .title > h1 {
                margin: 0;
                font-weight: 800;
                padding: 15px 10px;
                font-family: 'Roboto', sans-serif;
                font-size: 30px;
            }
            .container {
                max-width: 560px;
                background: #fff;
                margin: 30px auto;
                padding: 10px 15px;
                border: 1px solid #cdd0d5;
                border-radius: 3px;
            }
            .info {
                background: #fff;
                padding: 15px;
                text-align: center;
                color: #1967d2;
                width: 100%;
            }
            .info > a {
                color: #1967d2;
                font-size: 18px;
                text-align: center;
            }
            .md-t {
                text-align: left;
            }
            .con-title {
                font-size: 22px;
                color: #1967d2;
            }
            .md-t > p {
                font-size: 18px;
                color: #222;
            }
            .md-t > pre {
                font-size: 16px;
                color: #222;
                font-family: 'Roboto', sans-serif;
                line-height: 26px;
                word-break: break-all;
                white-space: break-spaces;
            }
        </style>
    </head>
    <body style='background: #ebeef2;'>
        <main id='wrapper'>
            <header class='title'>
                <h1>СтГАУ Агрокадры</h1>
            </header>
            <div class='container'>
                <div class='md-t'>
                    <pre> 
                        $content
                    </pre>
                    </br />
                    <p style='font-size: 16px;margin-top: 10px;'>
                        Если Вы не запрашивали это письмо, то можете спокойно его проигнорировать.
                    </p>
                </div>
            </div>
            <footer class='info'>
                <a href='http://stgaujob.ru/'>Наш сайт</a>
            </footer>
        </main>
    </body>
    </html>";

    mail($email, $subject, $text, $headers);

}


function send_mail($email, $title, $h1, $p, $text, $sub, $rel) {

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= 'From: Администратор stgaujob.ru' . "\r\n";

    mail($email, $title, "<!DOCTYPE html>
    <html lang='ru'>
    <head>
        <title>$title</title>
        <meta charset='UTF-8'>
        <link href='https://fonts.googleapis.com/css?family=Nunito:400,600,600i,700,700i,800,800i,900,900i&display=swap&subset=latin-ext,vietnamese' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i,900,900i&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese' rel='stylesheet'>
        <style>
            * {
                box-sizing: border-box;
            }
            body {
                background: #17191f;
                font-size: 15px;
                font-weight: normal;
                color: #333;
                margin: 0;
                padding: 0;
                font-family: 'Nunito', sans-serif;
            }
            #wrapper {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                background: rgb(37, 47, 57)
            }
            .title {
                margin: 0;
                background: rgb(37, 47, 57);
                color: rgb(120,187,230);
                width: 100%;
            }
            .title > h1 {
                margin: 0;
                font-weight: 800;
                padding: 15px 10px;
                font-family: 'Roboto', sans-serif;
                font-size: 30px;
            }
            .container {
                max-width: 560px;
                background: rgb(37, 47, 57);
                margin: 30px auto;
                padding: 10px 15px;
                box-shadow: 0 4px 15px 0 rgba(0,0,0,0.2);
                border-radius: 3px;
            }
            .info {
                background: rgb(37, 47, 57);
                padding: 15px;
                text-align: center;
                color: rgb(120,187,230);
                width: 100%;
            }
            .info > a {
                color: rgb(120, 187, 230);
                font-size: 18px;
                text-align: center;
            }
            .md-t {
                text-align: left;
            }
            .con-title {
                font-size: 22px;
                color: rgb(184, 196, 224);
            }
            .md-t > p {
                font-size: 18px;
                color: rgb(184, 196, 224);
            }
        </style>
    </head>
    <body style='background: rgb(28, 38, 47)'>
        <main id='wrapper'>
            <header class='title'>
                <h1>СтГАУ Агрокадры</h1>
            </header>
            <div class='container'>
                <div class='md-t'>
                    <h1 class='con-title'>Приветствую, $h1</h1>
                    <p>
                        $p
                        <br />
                        $text
                    </p>
                    <a style='color:#fff;max-width: 160px;margin: 0 auto;box-sizing: content-box;font-size: 15px;background: linear-gradient(rgb(117,172,208),rgb(58,129,175));padding: 10px;
                    display: block;
                    text-decoration: none;
                    border-radius: 3px;box-shadow: 0 4px 15px 0 rgba(0,0,0,0.2);text-align: center;' class='reld' href='".$rel."'>$sub</a>
                    </br />
                    <p style='font-size: 16px;margin-top: 10px;'>
                        Если Вы не запрашивали это письмо, то можете спокойно его проигнорировать.
                    </p>
                </div>
            </div>
            <footer class='info'>
                <a href='http://stgaujob.ru/'>Наш сайт</a>
            </footer>
        </main>
    </body>
    </html>", $headers);
}