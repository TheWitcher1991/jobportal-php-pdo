<?php
namespace Work\plugin\lib;

/**
 * interface LoggerPQuery
 * Интерфейс класса PQuery
 *
 * @package Work\plugin\lib
 * @file source/vendor/MVC/lib/pQuery.php
 * @author StgauJob foundation
 */
interface LoggerPQuery {

    /**
     * Проверяем объект self
     *
     * @return object|PQuery
     */
    public static function instance();

    /**
     * Добавляет данные в новый массив
     *
     * @param array $items массив, который нужно обработать
     * @param callback $callback анонимная функия ($element)
     * @return array
     */
    public static function map($items, $callback);

    /**
     * Фильтрует данные и добавляет в новый массив
     *
     * @param array $items массив, который нужно обработать
     * @param callback $callback анонимная функия ($element)
     * @return array
     */
    public static function filter($items, $callback);

    /**
     * Экранирование HTML тегов
     *
     * @param string $input строка, которую нужно запарсить
     * @return string|string[]|null
     */
    public static function screening($input);

    /**
     * Проверяет и парсит строку, удаляя вредосносный код
     *
     * @param string $input строка, которую нужно запарсить
     * @return string
     */
    public static function sanitize($input);

    /**
     * Определить местонахождение по IP
     *
     * @param string $ip IP пользователя
     * @return string
     */
    public static function detectCity($ip);

    /**
     * Генерация пароля
     *
     * @param int $length длина пароля | default - 9
     * @param int $strength сила пароля | default - 8
     * @return string
     */
    public static function generatePassword($length = 9, $strength = 8);

    /**
     * Получаем размер изображения
     *
     * @param string $url путь до изображения
     * @return int|string
     */
    public static function fileSize($url);

    /**
     * Загрузка php классов
     */
    public static function autoLoadClass();

    /**
     * Редирект на страницу 404
     */
    public static function notFound();

    /**
     * Генерация ключа
     *
     * @param int $num длина ключа
     * @return false|string
     */
    public static function randomStr($num);

    /**
     * ОБработчик var_dump
     *
     * @param object|array|string $var переменная, которую нужно обработать
     */
    public static function debug($var);

    /**
     * Находит факториал числа
     * 
     * @param int $number число
     */
    public static function fact($number);

}

/**
 * Class jQuery
 *
 * Этот класс содержит в себе пользовательские методы, которые упрощают и укорачивают код
 *
 * @package Reensq\plugin\lib
 * @author Reensq foundation
 */
class pQuery implements LoggerPQuery {

    /**
     * Объект для класса self
     *
     * @var object
     */
    protected static $instance;

    public static function instance() {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public static function map($items, $callback) {
        $result = [];

        foreach ($items as $item) {
            $result[] = $callback($item);
        }

        return $result;
    }

    public static function filter($items, $callback) {
        $result = [];

        foreach ($items as $item) {
            if ($callback($item)) {
                $result = $item;
            }
        }

        return $result;
    }

    public static function screening($input) {
        $search = [
            '@<script[^>]*?>.*?</script>@si',   // Удаляем javascript
            '@<;[\/\!]*?[^<>]*?>@si',          // Удаляем HTML теги
            '@"@si', "@'@si",                 // Удаляем кавычки
            '@<style[^>]*?>.*?</style>@siU', // Удаляем теги style
            '@<[\/\!]*?[^<>]*?>@si',        // Удаляем HTML теги
            # '([\r\n])[\s]+',             // Удаляем пробельные символы
            '@<![\s\S]*?--[ \t\n\r]*>@'   // Удаляем многострочные комментарии

        ];

        $output = preg_replace($search, '', $input);
        return $output;
    }

    public static function sanitize($input) {
        $output = [];
        if (is_array($input)) {
            foreach($input as $var => $val) {
                $output[$var] = self::sanitize($val);
            }
        } else {
            if (get_magic_quotes_gpc()) {
                $input =  stripslashes($input);
            }

            $input = self::screening($input);
            $output = htmlspecialchars(stripslashes($input));
        }

        return $output;
    }

    public static function detectCity($ip) {
        $default = 'UNKNOWN';

        if (!is_string($ip) || strlen($ip) < 1 || $ip == '127.0.0.1' || $ip == 'localhost') {
            $ip = '8.8.8.8';
        }

        $curlopt_useragent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)';

        $url = 'http://ipinfodb.com/ip_locator.php?ip=' . urlencode($ip);
        $ch = curl_init();

        $curl_opt = array(
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_USERAGENT => $curlopt_useragent,
            CURLOPT_URL => $url,
            CURLOPT_TIMEOUT => 1,
            CURLOPT_REFERER => 'http://' . $_SERVER['HTTP_HOST']
        );

        curl_setopt_array($ch, $curl_opt);

        $content = curl_exec($ch);

        if (!is_null($curl_info)) {
            $curl_info = curl_getinfo($ch);
        }

        curl_close($ch);

        $city = '';
        $state = '';

        if (preg_match('{<li>City : ([^<]*)</li>}i', $content, $regs))  {
            $city = $regs[1];
        }

        if (preg_match('{<li>State/Province : ([^<]*)</li>}i', $content, $regs))  {
            $state = $regs[1];
        }

        if ($city != '' && $state != '') {
            $location = $city . ', ' . $state;
            return $location;
        } else {
            return $default;
        }
    }

    public static function generatePassword($length = 9, $strength = 8) {
        $vowels = 'aeuy';
        $consonants = 'bdghjmnpqrstvz';

        if ($strength >= 1) {
            $consonants .= 'BDGHJLMNPQRSTVWXZ';
        } elseif ($strength >= 2) {
            $vowels .= "AEUY";
        } elseif ($strength >= 4) {
            $consonants .= '23456789';
        } elseif ($strength >= 8 ) {
            $vowels .= '@#$%';
        }

        $password = '';
        $alt = time() % 2;

        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }

        return $password;
    }

    public static function fileSize($url) {
        $size = filesize($url);

        if ($size >= 1073741824) {
            $fileSize = round($size / 1024 /  1024 / 1024, 1) . 'GB';
        } elseif ($size >= 1048576) {
            $fileSize = round($size / 1024 / 1024, 1) . 'MB';
        } elseif ($size >= 1024) {
            $fileSize = round($size / 1024, 1) . 'KB';
        } else {
            $fileSize = $size . ' bytes';
        }

        return $fileSize;
    }

    public static function autoLoadClass() {
        spl_autoload_register(function ($class) {
            $path = str_replace('\\', '/', $class . '.php');
            if (file_exists($path)) {
                require_once $path;
            }
        });
    }

    public static function notFound() {
        exit(header('location: /404'));
    }

    public static function randomStr($num) {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxzyABCDEFGHIJKLMNOPQRSTUVWXZY'), 0, $num);
    }

    public static function debug($var) {
        return '<pre>' . print_r($var, false) . '</pre>';
    }

    public static function fact($number) {
        return $number * self::fact($number - 1);
    }

}