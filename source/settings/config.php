<?php

#error_reporting(E_ALL);
#ini_set('display_errors', 'On');
#ini_set('log_errors', 'On');
#ini_set('error_log', $_SERVER['DOCUMENT_ROOT'] . '/source/log/php-errors.log');

ini_set('allow_url_fopen', 1);

const CRYPT_KEY = '';

const METHOD_CRYPT = '';

const HASH_METHOD = '';

$config = [
    'title' => 'СтГАУ Агрокадры',
    'url' => 'http://stgaujob.ru/',
    'db' => [
        'host' => '',
        'user' => '',
        'password' => '',
        'dbname' => ''
    ]
];

const DIRECTION = [
    '36.03.02' => 'Зоотехния',
    '35.03.07' => 'Технология производства и переработки с.-х. продукции',
    '19.03.04' => 'Технология продукции и организация общественного питания',
    '36.04.02' => '«Магистр» Зоотехния',
    '19.03.03' => '«Магистр» Продукты питания животного происхождения',

    '35.03.06' => 'Агроинженерия',
    '23.03.03' => 'Эксплуатация транспортно-технологических машин и комплексов',
    '35.04.06' => '«Магистр» Агроинженерия',
    '23.04.03' => '«Магистр» Эксплуатация транспортно-технологических машин и комплексов',

    '35.03.04' => 'Агрономия',
    '21.03.02' => 'Землеустройство и кадастры',
    '19.03.02' => 'Продукты питания из растительного сырья',
    '35.03.05' => 'Садоводство',
    '35.04.04' => '«Магистр» Агрономия',
    '21.04.02' => '«Магистр» Землеустройство и кадастры',
    '19.04.02' => '«Магистр» Продукты питания из растительного сырья',

    '36.03.01' => 'Ветеринарно-санитарная экспертиза',
    '36.04.01' => '«Магистр» Ветеринарно-санитарная экспертиза',
    '36.05.01' => 'Ветеринария',

    '43.03.01' => 'Сервис',
    '43.03.02' => 'Туризм',
    '43.03.03' => 'Гостиничное дело',

    '09.02.07' => 'Информационные системы и программирование',
    '13.02.07' => 'Электроснабжение',
    '21.02.19' => 'Землеустройство',
    '35.02.05' => '«СПО» Агрономия',
    '35.02.08' => 'Электротехнические системы в агропромышленном комплексе',
    '35.02.12' => 'Садово-парковое и ландшафтное строительство',
    '35.02.16' => 'Экспуатация и ремонт сельскохозяйственной техники и оборудования',
    '36.02.01' => '«СПО» Ветеринария',
    '36.02.02' => '«СПО» Зоотехния',
    '38.02.01' => 'Экономика и бухгалтерский учет',
    '38.02.04' => 'Коммерация',
    '38.02.06' => 'Финансы',
    '38.02.07' => 'Банковское дело',
    '43.02.15' => 'Поварское и кондитерское дело',
    '43.02.16' => 'Туризм и гостеприимство',

    '05.03.16' => 'Экология и природоведение',
    '35.03.10' => 'Ландшафтная архитектура',

    '38.03.01' => 'Экономика',
    '38.04.02' => 'Менеджмент',
    '38.03.04' => 'Государственной и муниципальное управление',
    '38.03.05' => 'Бизнес-информатика',
    '09.03.02' => 'Информационные системы и технологии',

];


$routes = [
    'base' => [
        'home',
        'badbrowser',
        'faculty',
        'job-list',
        'company-list',
        'resume-list',
        'all',
        'job',
        'resume',
        'company',
        'students',
        'feedback',
        'terms',
        'help',
        'category',
        'applicants',
        'applicants-list',
        'employer',
        '404'
    ],
    'auth' => [
        'add-exp',
        'add-achievement',
        'add-education',
        'change-password',
        'me-respond',
        'responded',
        'profile',
        'create-job',
        'manage-job',
        'analysis-job',
        'views',
        'idea',
        'analytics',
        'invite-job',
        'settings',
        'messages',
        'notice',
        'logs',
        'edit-resume',
        'edit-job',
        'archive-job',
        'archive-responded',
        '2fa',
        'save',
        'me-review',
        'me-sub'
    ],
    'scripts' => [
        'feedback-js', 'respond-js', 'uploads-js', 'uploads-only-js', 'profile-js', 'save-js', 'notice-js', 'job-js', 'create-user-js',
        'filter-job', 'captcha', 'filter-company', 'filter-resume', 'filter-lk-company', 'chat', 'filter-chat', 'index-script'
    ],
    'guest' => [
        'logout',
        'login',
        'login-confirm',
        'create-success',
        'lost-password',
        'lost-success',
        'email-confirm-user',
        'lost-confirm',
        'email-confirm',
        'login-admin'
    ],
    'admin' => [
        'analysis', 'statistics', 'companys-list', 'companys-add', 'jobs-list', 'jobs-add', 'resumes-list', 'resumes-add',
        'students-list', 'students-add', 'jobs-close', 'logs', 'ip', 'info-students', 'info-jobs', 'info-companys', 'info-jobs',
        'edit-companys', 'edit-students', 'edit-jobs', 'respond-list'
    ],
    'admin-scripts' => ['admin-js', 'export-js'],
    'guest-module-confirm' => [
        'confirm-user',
        'confirm-company'
    ],
    'guest-module-create' => [
        'user',
        'employers'
    ]
];

# /^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i

# массив правил для полей ввода
$rules = [
    'email' => [
        'pattern' => "/@/",
        'message' => 'E-mail указан неверно'
    ],
    'name' => [
        'pattern' => "/^[а-яА-Я]{2}$/",
        'message' => 'Имя может состоять только из букв',
        'message_two' => "Имя должно быть не меньше 2-х"
    ],
    'surname' => [
        'pattern' => "/^[а-яА-Я]{2}$/",
        'message' => 'Фамилия может состоять только из букв',
        'message_two' => "Фамилия должно быть не меньше 2-х"
    ],
    'patronymic' => [
        'pattern' => "/^[а-яА-Я]{2}$/",
        'message' => 'Отчество может состоять только из букв',
        'message_two' => "Имя должно быть не меньше 2-х"
    ],
    'password' => [
        'message' => 'Пароль должен быть не меньше 8 символов'
    ],
];





function Head ($title) {
    echo '<!DOCTYPE html>
<!--[if lt IE 6 ]><html itemscope itemtype="https://schema.org/WebPage" class="ie ie6" lang="ru" prefix="og: http://ogp.me/ns#" dir="ltr"> <![endif]-->
<!--[if IE 7 ]><html itemscope itemtype="https://schema.org/WebPage" class="ie ie7" lang="ru" prefix="og: http://ogp.me/ns#" dir="ltr"> <![endif]-->
<!--[if IE 8 ]><html itemscope itemtype="https://schema.org/WebPage" class="ie ie8" lang="ru" prefix="og: http://ogp.me/ns#" dir="ltr"> <![endif]-->
<!--[if IE 9 ]><html itemscope itemtype="https://schema.org/WebPage" class="ie ie9" lang="ru" prefix="og: http://ogp.me/ns#" dir="ltr"> <![endif]-->
<!--[if IE 10 ]><html itemscope itemtype="https://schema.org/WebPage" class="ie ie10" lang="ru" prefix="og: http://ogp.me/ns#" dir="ltr"> <![endif]-->
<!--[if (gte IE 11)|!(IE)]><!-->
<html itemscope itemtype="https://schema.org/WebPage" lang="ru" prefix="og: http://ogp.me/ns#" dir="ltr">
<!--<![endif]-->
<head>

    <!--
     _    _   _   _
    | |  | | (_) | |
    | |__| | | | | |
    |  __  | | | |_|
    | |  | | | |  _
    |_|  |_| |_| |_|
    
    Welcome to code;)
    
    Developer: ashot.svazyan222@gmail.com
    Если Вы заметили какие-то проблемы, пожалуйста, напишите мне
    -->

    <meta charset="utf-8" />

    <!-- SEO -->
    <title itemprop="name">'.$title.'</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta name="description" content="stgaujob.ru - сервис, который помогает выпускникам Ставропольского ГАУ найти работу, а заинтересованным компаниям найти персонал." />
    <meta name="keywords" content="stgau, stgaujob, стгау, ставропольский гау, работа в ставрополе, стгау работа, Ставропольский ГАУ работа, стгау агрокадры" />
    <link rel="canonical" href="http://stgaujob.ru">  
    <meta property="og:title" content="'.$title.'" />
    <meta property="og:locale" content="ru_RU" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="stgaujob.ru - сервис, который помогает выпускникам Ставропольского ГАУ найти работу, а заинтересованным компаниям найти персонал." />
    <meta property="og:url" content="http://stgaujob.ru" />
    <meta property="og:site_name" content="СтГАУ Агрокадры" />
    <meta http-equiv="content-language" content="ru">
    <meta name="robots" content="index, follow">
    <meta http-equiv="x-dns-prefetch-control" content="on">
  
    <meta name="author" content="alikzoy@gmail.com">
    <meta name="copyright" content="Ставропольский государственный аграрный университет <aleksandrgunko@yandex.ru>">
    <meta name="reply-to" content="aleksandrgunko@yandex.ru">
    
    <meta name="theme-color" content="#FFFFFF" /> 
    <link rel="manifest" href="/manifest.json">
    <link rel="shortcut icon" href="/static/image/favicon.ico" type="image/x-icon" />
    <link rel="icon" href="/static/image/favicon.ico" type="image/x-icon">
    <!-- / SEO  -->
    
     <!-- Script for old browsers -->
    <script type="text/javascript">
        !function(){"use strict";function trackOldBrowserEvent(){var t=function createXmlHttpRequestObject(){var t;try{t=new XMLHttpRequest}catch(r){for(var e=new Array("MSXML2.XMLHHTP.11.0","MSXML2.XMLHHTP.10.0","MSXML2.XMLHHTP.9.0","MSXML2.XMLHHTP.8.0","MSXML2.XMLHHTP.7.0","MSXML2.XMLHHTP.6.0","MSXML2.XMLHHTP.5.0","MSXML2.XMLHHTP.4.0","MSXML2.XMLHHTP.3.0","MSXML2.XMLHHTP","Microsoft.XMLHHTP"),s=0;s<e.length&&!t;s++)try{t=new ActiveXObject(e[s])}catch(t){}}return null!=t?t:void 0}(),e=new Object;return e.open="/badbrowser?status="+(0!==t.status&&t.status),e.xhr=t.responseURL?t.responseURL:"/badbrowser?status="+(0!==t.status&&t.status),t.open("GET",e.open,!0),t.setRequestHeader("Content-Type","text/html"),t.setRequestHeader("X-Requested-With","XMLHttpRequest"),t.onreadystatechange=function(){if(4===t.readyState&&(t.status>=200&&t.status<300||304===t.status||0===t.status&&"file:"===protocol))try{location.replace(t.responseURL?t.responseURL:"/badbrowser?status="+t.status)}catch(t){}},t.send(e.xhr?e.xhr:null),t}!function checkOldBrowser(){if(document.body)try{"CSS"in window&&CSS.supports("display","flex")&&"undefined"!=typeof Symbol||trackOldBrowserEvent()}catch(t){}else setTimeout(checkOldBrowser,100)}()}();
    </script>
    <!-- / Script for old browsers -->

    <!-- HTMLREditor style -->
    <!--<link rel="stylesheet" href="/static/scripts/vendor/HTMLREditor/style/htmlreditor.bundle.css" />-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <!-- Include style web-site -->
    <style>
       
        #loader-site {
            background-color: #FFFFFF;
            position: fixed;
            z-index: 99999;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            display: flex;
            align-content: center;
            justify-content: center;
            align-items: center;
        }
        
        #loader-site div {
            font-family: "Poppins",-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
            color: #17171d;
            font-weight: 300;
        }
    </style>
  
    <link rel="stylesheet" href="/static/styles/css.php?v='.date('YmdHis').'" />
    <link rel="stylesheet" href="https://atuin.ru/demo/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="/static/scripts/vendor/chief/slider.min.css" />
    
    <!-- / Include style web-site -->
    
    <!-- Main Quill library -->
    <script src="http://cdn.quilljs.com/1.3.0/quill.min.js"></script>
    <link href="http://cdn.quilljs.com/1.3.0/quill.snow.css" rel="stylesheet">

    <!-- Include libs -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css" />
    <link
      rel="stylesheet"
      href="https://unpkg.com/swiper@8/swiper-bundle.min.css"
    />
    <!-- / Include libs -->

    <!-- Icons and fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css" integrity="sha512-QKC1UZ/ZHNgFzVKSAhV5v5j73eeL9EEN289eKAEFaAjgAiobVAnVv/AGuPbXsKl1dNoel3kNr6PYnSiTzVVBCw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@mdi/font@6.9.96/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.1/css/all.css" integrity="sha384-/frq1SRXYH/bSyou/HUp/hib7RVN1TawQYja658FEOodR/FQBKVqT9Ol+Oz3Olq5" crossorigin="anonymous"/>

    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    </head>
';
}





$loads = [
    'Ставропольский край' => [
        'Шпаковский муниципальный район' => [
            'город Михайловск' => [
                'stav_mixal',
                'stav_shpak',
                'Шпаковский муниципальный район',
                9
            ],
            'посёлок Верхнеегорлыксий' => [
                'stav_verxnegor',
                'stav_shpak',
                'Шпаковский муниципальный район',
                9
            ],
            'село Верхнерусское' => [
                'stav_verx',
                'stav_shpak',
                'Шпаковский муниципальный район',
                9
            ],
            'село Дубовка' => [
                'stav_dubov',
                'stav_shpak',
                'Шпаковский муниципальный район',
                9
            ],
            'село Казинка' => [
                'stav_kazin',
                'stav_shpak',
                'Шпаковский муниципальный район',
                9
            ],
            'село Калиновка' => [
                'stav_kalin',
                'stav_shpak',
                'Шпаковский муниципальный район',
                9
            ],
            'село Надежка' => [
                'stav_nadejd',
                'stav_shpak',
                'Шпаковский муниципальный район',
                9
            ],
            'станица Новомарьевская' => [
                'stav_novormar',
                'stav_shpak',
                'Шпаковский муниципальный район',
                9
            ],
            'посёлок Новый Бешпагир' => [
                'stav_newbesh',
                'stav_shpak',
                'Шпаковский муниципальный район',
                9
            ],
            'село Пелагиада' => [
                'stav_peliag',
                'stav_shpak',
                'Шпаковский муниципальный район',
                9
            ],
            'село Петропавловка' => [
                'stav_pertop',
                'stav_shpak',
                'Шпаковский муниципальный район',
                9
            ],
            'посёлок Приозёрный' => [
                'stav_mixal',
                'stav_shpak',
                'Шпаковский муниципальный район',
                9
            ],
            'посёлок Северный' => [
                'stav_sever',
                'stav_shpak',
                'Шпаковский муниципальный район',
                9
            ],
            'село Сенлилеевское' => [
                'stav_sengil',
                'stav_shpak',
                'Шпаковский муниципальный район',
                9
            ],
            'посёлок Степной' => [
                'stav_stepn',
                'stav_shpak',
                'Шпаковский муниципальный район',
                9
            ],
            'село Татарка' => [
                'stav_tatarka',
                'stav_shpak',
                'Шпаковский муниципальный район',
                9
            ],
            'станица Темнолесская' => [
                'stav_mixal',
                'stav_shpak',
                'Шпаковский муниципальный район',
                9
            ],
            'посёлок Цимлянский' => [
                'stav_chumlan',
                'stav_shpak',
                'Шпаковский муниципальный район',
                9
            ],
            'посёлок Ясный' => [
                'stav_yacn',
                'stav_shpak',
                'Шпаковский муниципальный район',
                9
            ]
        ],
        'Минераловодский городской округ' => [
            'город Минеральные Воды' => [
                'stav_minvod',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'посёлок Бородыновка' => [
                'stav_borodn',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'село Гражданское' => [
                'stav_grajdn',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'село Греческое' => [
                'stav_grechen',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'село Долина' => [
                'stav_dolin',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'село Дунаевка' => [
                'stav_dunaev',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'село Еруслановка' => [
                'stav_erusln',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'посёлок Загорский' => [
                'stav_zagor',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'посёлок Змейка' => [
                'stav_zmey',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'село Канглы' => [
                'stav_kangl',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'посёлок Кумагорск' => [
                'stav_kumagor',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'посёлок Кумской' => [
                'stav_kumsk',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'село Левокумка' => [
                'stav_levokum',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'посёлок Ленинский' => [
                'stav_leninsk',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'село Марьины Колодцы' => [
                'stav_marinkolod',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'село Нагутское' => [
                'stav_nagut',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'посёлок Нижнебалковский' => [
                'stav_nujebal',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'село Нижняя Александровка' => [
                'stav_nujealeks',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'посёлок Новотерский' => [
                'stav_novoter',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'посёлок Первомайский' => [
                'stav_pervom',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'село Побегайловка' => [
                'stav_pobegal',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'посёлок Привольный' => [
                'stav_privoln',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'село Прикумское' => [
                'stav_prikum',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'село Розовка' => [
                'stav_rozovk',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'село Сунжа' => [
                'stav_sunj',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'село Ульяновка' => [
                'stav_ulnyan',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'село Успеновка' => [
                'stav_uspen',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ],
            'посёлок Фруктовый' => [
                'stav_frukt',
                'stav_miner',
                'Минераловодский городской округ',
                14
            ]
        ],
        'Апанасенковский муниципальный округ' => [
            'село Дивное' => [
                'stav_divn',
                'stav_miner',
                'Апанасенковский муниципальный округ',
                15
            ],
            'село Апанасенковское' => [
                'stav_apansenk',
                'stav_miner',
                'Апанасенковский муниципальный округ',
                15
            ],
            'посёлок Айгурский' => [
                'stav_aygur',
                'stav_miner',
                'Апанасенковский муниципальный округ',
                15
            ],
            'посёлок Белые Копани' => [
                'stav_belkopany',
                'stav_miner',
                'Апанасенковский муниципальный округ',
                15
            ],
            'посёлок Вишнёвый' => [
                'stav_vish',
                'stav_miner',
                'Апанасенковский муниципальный округ',
                15
            ],
            'посёлок Водный' => [
                'stav_vodn',
                'stav_miner',
                'Апанасенковский муниципальный округ',
                15
            ],
            'село Воздвиженское' => [
                'stav_vozdvin',
                'stav_miner',
                'Апанасенковский муниципальный округ',
                15
            ],
            'село Вознесеновское' => [
                'stav_voznesen',
                'stav_miner',
                'Апанасенковский муниципальный округ',
                15
            ],
            'село Дербетовка' => [
                'stav_derbat',
                'stav_miner',
                'Апанасенковский муниципальный округ',
                15
            ],
            'село Киевка' => [
                'stav_kievka',
                'stav_miner',
                'Апанасенковский муниципальный округ',
                15
            ],
            'село Малая Джалга' => [
                'stav_maldza',
                'stav_miner',
                'Апанасенковский муниципальный округ',
                15
            ],
            'село Манычское' => [
                'stav_manych',
                'stav_miner',
                'Апанасенковский муниципальный округ',
                15
            ],
            'село Рагули' => [
                'stav_raguly',
                'stav_miner',
                'Апанасенковский муниципальный округ',
                15
            ],
            'посёлок Хлебный' => [
                'stav_xleb',
                'stav_miner',
                'Апанасенковский муниципальный округ',
                15
            ]
        ],
        'Советский городской округ' => [
            'город Зеленокумск' => [
                'stav_zelenodayz',
                'stav_sov',
                'Советский городской округ',
                16
            ],
            'посёлок Брусиловка' => [
                'stav_brus',
                'stav_sov',
                'Советский городской округ',
                16
            ],
            'село Горькая Балка' => [
                'stav_gorkbalka',
                'stav_sov',
                'Советский городской округ',
                16
            ],
            'посёлок Железнодорожный' => [
                'stav_jelezno',
                'stav_sov',
                'Советский городской округ',
                16
            ],
            'посёлок Колтуновский' => [
                'stav_zelenodayz',
                'stav_sov',
                'Советский городской округ',
                16
            ],
            'посёлок Михайловка' => [
                'stav_zelenodayz',
                'stav_sov',
                'Советский городской округ',
                16
            ],
            'село Отказное' => [
                'stav_otkaz',
                'stav_sov',
                'Советский городской округ',
                16
            ],
            'село Правокумское' => [
                'stav_pravokum',
                'stav_sov',
                'Советский городской округ',
                16
            ],
            'посёлок Селивановка' => [
                'stav_selivanov',
                'stav_sov',
                'Советский городской округ',
                16
            ],
            'село Солдато-Александровское' => [
                'stav_soldato',
                'stav_sov',
                'Советский городской округ',
                16
            ]
        ],
        'Труновский муниципальный район' => [
            'село Труновское' => [
                'stav_trun',
                'stav_turn',
                'Труновский муниципальный район',
                17
            ],
            'село Безопасное' => [
                'stav_bezop',
                'stav_turn',
                'Труновский муниципальный район',
                17
            ],
            'село Донское' => [
                'stav_donsk',
                'stav_turn',
                'Труновский муниципальный район',
                17
            ],
            'село Ключевское' => [
                'stav_kluch',
                'stav_turn',
                'Труновский муниципальный район',
                17
            ],
            'посёлок Нижняя Терновка' => [
                'stav_nujtern',
                'stav_turn',
                'Труновский муниципальный район',
                17
            ],
            'село Новая Кугульта' => [
                'stav_novkugult',
                'stav_turn',
                'Труновский муниципальный район',
                17
            ],
            'посёлок Новотерновский' => [
                'stav_novotern',
                'stav_turn',
                'Труновский муниципальный район',
                17
            ],
            'село Подлесное' => [
                'stav_podlesn',
                'stav_turn',
                'Труновский муниципальный район',
                17
            ],
            'посёлок имени Кирова' => [
                'stav_kirova',
                'stav_turn',
                'Труновский муниципальный район',
                17
            ],
            'посёлок Правоегорлыксий' => [
                'stav_pravogorl',
                'stav_turn',
                'Труновский муниципальный район',
                17
            ],
            'посёлок Сухой Лог' => [
                'stav_syxoylog',
                'stav_turn',
                'Труновский муниципальный район',
                17
            ],
            'село Егорлык' => [
                'stav_egorlk',
                'stav_turn',
                'Труновский муниципальный район',
                17
            ],
            'село Кофанов' => [
                'stav_kofanov',
                'stav_turn',
                'Труновский муниципальный район',
                17
            ],
            'село Невдахин' => [
                'stav_nevdaxin',
                'stav_turn',
                'Труновский муниципальный район',
                17
            ],
            'село Эммануэлевский' => [
                'stav_emmahuelevskiy',
                'stav_turn',
                'Труновский муниципальный район',
                17
            ]
        ],
        'Туркменский муниципальный район' => [
            'посёлок Берёзовский' => [
                'stav_berezv',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ],
            'посёлок Владимировка' => [
                'stav_vladimir',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ],
            'посёлок Голубиный' => [
                'stav_golub',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ],
            'село Казгулак' => [
                'stav_kazlug',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ],
            'село Камбулат' => [
                'stav_kambulat',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ],
            'село Кендже-Кулак' => [
                'stav_kendje',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ],
            'посёлок Красная Поляна' => [
                'stav_krasnaya',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ],
            'посёлок Красный Маныч' => [
                'stav_krasnman',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ],
            'село Кучерла' => [
                'stav_kucherla',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ],
            'село Летняя Ставка' => [
                'stav_letnyastavka',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ],
            'село Малые Ягуры' => [
                'stav_maleyag',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ],
            'посёлок Новокучерлинский' => [
                'stav_novokucherln',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ],
            'посёлок Новорагулинский' => [
                'stav_novoragul',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ],
            'село Овощи' => [
                'stav_ovohi',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ],
            'посёлок Отрадный' => [
                'stav_otragnyi',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ],
            'посёлок Поперечный' => [
                'stav_poperech',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ],
            'посёлок Прудовый' => [
                'stav_prudov',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ],
            'посёлок Таврический' => [
                'stav_tavrich',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ],
            'посёлок Троицкий' => [
                'stav_troych',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ],
            'посёлок Ясный' => [
                'stav_yacnyt',
                'stav_turk',
                'Туркменский муниципальный район',
                18
            ]
        ],
        'Степновский муниципальный район' => [
            'село Богдановка' => [
                'stav_troych',
                'stav_step',
                'Степновский муниципальный район',
                19
            ],
            'село Варениковское' => [
                'varenikov',
                'stav_step',
                'Степновский муниципальный район',
                19
            ],
            'посёлок Верхнестепной' => [
                'stav_verxnectep',
                'stav_step',
                'Степновский муниципальный район',
                19
            ],
            'село Степное' => [
                'stav_stepnoye',
                'stav_step',
                'Степновский муниципальный район',
                19
            ],
            'село Иргаклы' => [
                'stav_urgacl',
                'stav_step',
                'Степновский муниципальный район',
                19
            ],
            'село Соломенское' => [
                'stav_solomon',
                'stav_step',
                'Степновский муниципальный район',
                19
            ],
            'село Ольгино' => [
                'stav_olgino',
                'stav_step',
                'Степновский муниципальный район',
                19
            ],
            'село Зелёная Роща' => [
                'stav_zelenoroch',
                'stav_step',
                'Степновский муниципальный район',
                19
            ],
            'село Никольское' => [
                'stav_nikol',
                'stav_step',
                'Степновский муниципальный район',
                19
            ],
            'село Озёрное' => [
                'stav_ozerno',
                'stav_step',
                'Степновский муниципальный район',
                19
            ],
            'посёлок Новоиргаклинский' => [
                'stav_novourgalk',
                'stav_step',
                'Степновский муниципальный район',
                19
            ]
        ],
        'Петровский городской округ' => [
            'город Светлоград' => [
                'stav_svetlo',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'село Константиновское' => [
                'stav_konstan',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'село Гофицкое' => [
                'stav_gofi',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'село Благодатное' => [
                'stav_blagotn',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'село Сухая Буйвола' => [
                'stav_buyvola',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'село Николина Балка' => [
                'stav_nikola',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'село Высоцкое' => [
                'stav_vsochkoe',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'село Донская Балка' => [
                'stav_donskab',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'село Шведино' => [
                'stav_hvedino',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'село Ореховка' => [
                'stav_orexovka',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'село Просянка' => [
                'stav_procyanka',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'село Шангала' => [
                'stav_hangala',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'посёлок Прикалаусский' => [
                'stav_prikalausski',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'посёлок Горный' => [
                'stav_gorni',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'село Кугуты' => [
                'stav_kugut',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'посёлок Маяк' => [
                'stav_mayak',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'село Мартыновка' => [
                'stav_martnovka',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'посёлок Полевой' => [
                'stav_polevoy',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'посёлок Пшеничный' => [
                'stav_phenichn',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'посёлок Цветочный' => [
                'stav_chetoch',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
            'посёлок Рогатая Балка' => [
                'stav_rogatayabalka',
                'stav_petr',
                'Петровский городской округ',
                20
            ],
        ],
        'Новоселицкий муниципальный район' => [
            'село Новоселицкое' => [
                'stav_novoslch',
                'stav_novos',
                'Новоселицкий муниципальный район',
                24
            ],
            'село Чернолесское' => [
                'stav_chernoles',
                'stav_novos',
                'Новоселицкий муниципальный район',
                24
            ],
            'село Журавское' => [
                'stav_juravsk',
                'stav_novos',
                'Новоселицкий муниципальный район',
                24
            ],
            'село Китаевское' => [
                'stav_kitaevsk',
                'stav_novos',
                'Новоселицкий муниципальный район',
                24
            ],
            'село Долиновка' => [
                'stav_dolinka',
                'stav_novos',
                'Новоселицкий муниципальный район',
                24
            ],
            'село Падинское' => [
                'stav_padinsk',
                'stav_novos',
                'Новоселицкий муниципальный район',
                24
            ],
            'посёлок Новый Маяк' => [
                'stav_novomayak',
                'stav_novos',
                'Новоселицкий муниципальный район',
                24
            ],
            'посёлок Щелкан' => [
                'stav_chelkan',
                'stav_novos',
                'Новоселицкий муниципальный район',
                24
            ],
            'посёлок Артезианский' => [
                'stav_artezinsk',
                'stav_novos',
                'Новоселицкий муниципальный район',
                24
            ]
        ],
        'Новоалександровский городской округ' => [
            'город Новоалександровск' => [
                'stav_novoaleskandr',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Виноградный' => [
                'stav_vinogradn',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Восточный' => [
                'stav_vostochn',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Встречный' => [
                'stav_vscnrech',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Горьковский' => [
                'stav_gorkovsk',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Дружба' => [
                'stav_drujba',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Заречный' => [
                'stav_zarech',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Кармалиновский' => [
                'stav_karmalinovsk',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Краснозоринский' => [
                'stav_krasnozor',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Краснокубанский' => [
                'stav_krasnokuban',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Крутобалковский' => [
                'stav_krutobalk',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Курганный' => [
                'stav_kurgann',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Лиманный' => [
                'stav_limann',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Озёрный' => [
                'stav_ozernyy',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Присадовый' => [
                'stav_prisadovy',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Равнинный' => [
                'stav_ravnin',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Радуга' => [
                'stav_ragubanovoa',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Рассвет' => [
                'stav_rassvet',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Светлый' => [
                'stav_svetl',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Славенский' => [
                'stav_slavensk',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Темижбекский' => [
                'stav_temijbek',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Ударный' => [
                'stav_udarn',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'посёлок Южный' => [
                'stav_ujny',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'село Раздольное' => [
                'stav_razdoln',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'станица Воскресенская' => [
                'stav_voskresensk',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'станица Григорополисская' => [
                'stav_grigorop',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'станица Кармалиновская' => [
                'stav_karmalinovs',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ],
            'станица Расшеватская' => [
                'stav_rachevat',
                ' stav_novoa',
                'Новоалександровский городской округ',
                25
            ]
        ],
        'Нефтекумский городский округ' => [
            'город Нефтекумск' => [
                'stav_neftekum',
                'stav_nefte',
                'Нефтекумский городский округ',
                26
            ],
            'пгт Затеречный' => [
                'stav_zaterech',
                'stav_nefte',
                'Нефтекумский городский округ',
                26
            ],
            'село Ачикулак' => [
                'stav_achikulak',
                'stav_nefte',
                'Нефтекумский городский округ',
                26
            ],
            'село Каясула' => [
                'stav_kayasula',
                'stav_nefte',
                'Нефтекумский городский округ',
                26
            ],
            'село Кара-Тюбе' => [
                'stav_kara',
                'stav_nefte',
                'Нефтекумский городский округ',
                26
            ],
            'село Озек-Суат' => [
                'stav_ozek',
                'stav_nefte',
                'Нефтекумский городский округ',
                26
            ],
            'посёлок Зункарь' => [
                'stav_zunkar',
                'stav_nefte',
                'Нефтекумский городский округ',
                26
            ],
            'посёлок Зимняя Ставка' => [
                'stav_zumnstavka',
                'stav_nefte',
                'Нефтекумский городский округ',
                26
            ],
            'посёлок Левобалковский' => [
                'stav_levobalk',
                'stav_nefte',
                'Нефтекумский городский округ',
                26
            ]
        ],
        'Левокумский муниципальный округ' => [
            'село Лекокумское' => [
                'stav_levokumsk',
                'stav_levon',
                'Левокумский муниципальный округ',
                27
            ],
            'село Величаевское' => [
                'stav_velichaevsk',
                'stav_levon',
                'Левокумский муниципальный округ',
                27
            ],
            'село Правокумское' => [
                'stav_pravokumsk',
                'stav_levon',
                'Левокумский муниципальный округ',
                27
            ],
            'село Урожайное' => [
                'stav_urajnoe',
                'stav_levon',
                'Левокумский муниципальный округ',
                27
            ],
            'село Владимировка' => [
                'stav_vladimirovkal',
                'stav_levon',
                'Левокумский муниципальный округ',
                27
            ],
            'село Приозёрское' => [
                'stav_priozerskl',
                'stav_levon',
                'Левокумский муниципальный округ',
                27
            ],
            'село Турксад' => [
                'stav_turkcad',
                'stav_levon',
                'Левокумский муниципальный округ',
                27
            ],
            'посёлок Новокумский' => [
                'stav_novokusmk',
                'stav_levon',
                'Левокумский муниципальный округ',
                27
            ],
            'посёлок Заря' => [
                'stav_zarya',
                'stav_levon',
                'Левокумский муниципальный округ',
                27
            ],
            'село Николо-Александровское' => [
                'stav_nikoloalesk',
                'stav_levon',
                'Левокумский муниципальный округ',
                27
            ],
            'село Бургун-Маджары' => [
                'stav_burgun',
                'stav_levon',
                'Левокумский муниципальный округ',
                27
            ],
            'посёлок Кумская Долина' => [
                'stav_kumskdolina',
                'stav_levon',
                'Левокумский муниципальный округ',
                27
            ],
            'посёлок Ленинский' => [
                'stav_leninsk',
                'stav_levon',
                'Левокумский муниципальный округ',
                27
            ],
            'посёлок Малосадовый' => [
                'stav_malosadov',
                'stav_levon',
                'Левокумский муниципальный округ',
                27
            ],
            'посёлок Камышитовый' => [
                'stav_kamhitov',
                'stav_levon',
                'Левокумский муниципальный округ',
                27
            ],
            'посёлок Правокумский' => [
                'stav_pravokumskiy',
                'stav_levon',
                'Левокумский муниципальный округ',
                27
            ]
        ],
        'Курский муниципальный район' => [
            'станица Курская' => [
                'stav_kurskaya',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'село Эдиссия' => [
                'stav_edissia',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'село Русское' => [
                'stav_russkoe',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'станица Галюгаевская' => [
                'stav_galugaev',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'посёлок Мирный' => [
                'stav_mirmta',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'село Ростовановское' => [
                'stav_rostovansk',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'посёлок Балтийский' => [
                'stav_baltiy',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'село Полтавское' => [
                'stav_poltavsk',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'станица Стодеревская' => [
                'stav_stoderevsk',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'село Каново' => [
                'stav_kanovo',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'посёлок Ага-Батыр' => [
                'stav_agabatr',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'село Серноводское' => [
                'stav_sernovo',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'село Уваровское' => [
                'stav_uvarovsk',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'посёлок Рощино' => [
                'stav_rohino',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'посёлок Бурунный' => [
                'stav_burunny',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'посёлок Ровный' => [
                'stav_rovn',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'село Добровольное' => [
                'stav_dobrovl',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'посёлок Совхозный' => [
                'stav_sovzozn',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'посёлок Трудовой' => [
                'stav_trudovoy',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'посёлок Южанин' => [
                'stav_ujan',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'посёлок Правобережный' => [
                'stav_pravoberj',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'посёлок Песчаный' => [
                'stav_pechn',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'посёлок Новобалийский' => [
                'stav_novobalt',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ],
            'посёлок Ленпосёлок' => [
                'stav_lenposel',
                'stav_kursk',
                'Курский муниципальный район',
                28
            ]
        ],
        'Красногвардейский муниципальный район' => [
            'село Красногвардейское' => [
                'stav_krasnogvard',
                'stav_krasn',
                'Красногвардейский муниципальный район',
                29
            ],
            'село Ладовская Балка' => [
                'stav_ladovskbalka',
                'stav_krasn',
                'Красногвардейский муниципальный район',
                29
            ],
            'село Привольное' => [
                'stav_privolnoe',
                'stav_krasn',
                'Красногвардейский муниципальный район',
                29
            ],
            'село Преградное' => [
                'stav_pregradnoek',
                'stav_krasn',
                'Красногвардейский муниципальный район',
                29
            ],
            'село Дмитриевское' => [
                'stav_dmitrievsk',
                'stav_krasn',
                'Красногвардейский муниципальный район',
                29
            ],
            'село Родыки' => [
                'stav_rodki',
                'stav_krasn',
                'Красногвардейский муниципальный район',
                29
            ],
            'село Новомихайловское' => [
                'stav_novomichal',
                'stav_krasn',
                'Красногвардейский муниципальный район',
                29
            ],
            'посёлок Коммунар' => [
                'stav_kommunar',
                'stav_krasn',
                'Красногвардейский муниципальный район',
                29
            ],
            'село Покровское' => [
                'stav_pokrovsk',
                'stav_krasn',
                'Красногвардейский муниципальный район',
                29
            ],
            'посёлок Медвеженский' => [
                'stav_medvejensk',
                'stav_krasn',
                'Красногвардейский муниципальный район',
                29
            ],
            'посёлок Штурм' => [
                'stav_hturm',
                'stav_krasn',
                'Красногвардейский муниципальный район',
                29
            ],
            'посёлок Озерки' => [
                'stav_ozerkik',
                'stav_krasn',
                'Красногвардейский муниципальный район',
                29
            ],
            'посёлок Зеркальный' => [
                'stav_zerkaln',
                'stav_krasn',
                'Красногвардейский муниципальный район',
                29
            ],
            'посёлок Зерновой' => [
                'stav_zernovo',
                'stav_krasn',
                'Красногвардейский муниципальный район',
                29
            ],
            'посёлок Новомирненский' => [
                'stav_novomirn',
                'stav_krasn',
                'Красногвардейский муниципальный район',
                29
            ]
        ],
        'Кочубеевский муниципальный район' => [
            'село Кочубеевское' => [
                'stav_kochubeevsk',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ],
            'село Ивановское' => [
                'stav_ivanovsk',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ],
            'село Казьминское' => [
                'stav_kazminvsk',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ],
            'станица Барсуковская' => [
                'stav_barsukov',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ],
            'село Балахоновское' => [
                'stav_balaxonovsk',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ],
            'село Заветное' => [
                'stav_zavetnoe',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ],
            'станица Беломечётская' => [
                'stav_belomechetn',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ],
            'село Новая Деревня' => [
                'stav_derevn',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ],
            'село Весёлое' => [
                'stav_vesel',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ],
            'село Воронежское' => [
                'stav_voronejsk',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ],
            'посёлок Тоннельный' => [
                'stav_tonneln',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ],
            'станица Георгиевская' => [
                'stav_georgievsk',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ],
            'село Вревское' => [
                'stav_vrevsk',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ],
            'село Надзорное' => [
                'stav_nadzornoe',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ],
            'посёлок Рабочий' => [
                'stav_rabochiy',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ],
            'село Дворцовское' => [
                'stav_dvorchovoe',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ],
            'станица Новоекатериновская' => [
                'stav_novoekaterinovsk',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ],
            'село Галицино' => [
                'stav_galichino',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ],
            'посёлок Свистуха' => [
                'stav_svistuxa',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ],
            'станица Сунженская' => [
                'stav_sunjenskya',
                'stav_kochub',
                'Кочубеевский муниципальный район',
                30
            ]
        ],
        'Кировский городской округ' => [
            'город Новопавловск' => [
                'stav_ivanovsk',
                'stav_kirovsk',
                'Кировский городской округ',
                31
            ],
            'посёлок Грибной' => [
                'stav_gribnoy',
                'stav_kirovsk',
                'Кировский городской округ',
                31
            ],
            'посёлок Золка' => [
                'stav_zolka',
                'stav_kirovsk',
                'Кировский городской округ',
                31
            ],
            'посёлок Зольский Карьер' => [
                'stav_zolskar',
                'stav_kirovsk',
                'Кировский городской округ',
                31
            ],
            'посёлок Камышовый' => [
                'stav_kamihovo',
                'stav_kirovsk',
                'Кировский городской округ',
                31
            ],
            'посёлок Коммаяк' => [
                'stav_ivanovsk',
                'stav_kirovsk',
                'Кировский городской округ',
                31
            ],
            'посёлок Комсомолец' => [
                'stav_komsomol',
                'stav_kirovsk',
                'Кировский городской округ',
                31
            ],
            'посёлок Прогресс' => [
                'stav_progress',
                'stav_kirovsk',
                'Кировский городской округ',
                31
            ],
            'посёлок Фазанный' => [
                'stav_fazann',
                'stav_kirovsk',
                'Кировский городской округ',
                31
            ],
            'село Горнозаводское' => [
                'stav_gornozavodsk',
                'stav_kirovsk',
                'Кировский городской округ',
                31
            ],
            'село Новосредненское' => [
                'stav_novocrednsk',
                'stav_kirovsk',
                'Кировский городской округ',
                31
            ],
            'село Орловка' => [
                'stav_orlovka',
                'stav_kirovsk',
                'Кировский городской округ',
                31
            ],
            'станица Зольская' => [
                'stav_zolskaya',
                'stav_kirovsk',
                'Кировский городской округ',
                31
            ],
            'станица Марьинская' => [
                'stav_marinskaya',
                'stav_kirovsk',
                'Кировский городской округ',
                31
            ],
            'станица Советская' => [
                'stav_sovetskaya',
                'stav_kirovsk',
                'Кировский городской округ',
                31
            ],
            'станица Старопавловская' => [
                'stav_staropavlovsk',
                'stav_kirovsk',
                'Кировский городской округ',
                31
            ]
        ],
        'Ипатовский городской округ' => [
            'город Ипатово' => [
                'stav_ivanovsk',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'село Большая Джалга' => [
                'stav_biggerdjalga',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'посёлок Большевик' => [
                'stav_bolhevik',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'село Бурукшун' => [
                'stav_burukhun',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'посёлок Верхнетахтинский' => [
                'stav_verxnetaxtnsk',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'посёлок Винодельненский' => [
                'stav_vinodelsk',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'посёлок Горлинка' => [
                'stav_gorlinka',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'посёлок Двуречный' => [
                'stav_dvurech',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'село Добровольное' => [
                'stav_dobrovoln',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'посёлок Донцово' => [
                'stav_donchovo',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'посёлок Дружный' => [
                'stav_drujn',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'посёлок Залесный' => [
                'stav_zalecn',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'село Золотарёвка' => [
                'stav_zolotarevka',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'посёлок Калаусский' => [
                'stav_kalausskiy',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'село Кевсала' => [
                'stav_kevsala',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'село Красная Поляна' => [
                'stav_kracnyapolyana',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'посёлок Красочный' => [
                'stav_krasoch',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'село Крестьянское' => [
                'stav_krestyansk',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'село Лесная Дача' => [
                'stav_lesnayadacha',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'село Лиман' => [
                'stav_liman',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'посёлок Малоипатовский' => [
                'stav_maloipat',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'село Первомайское' => [
                'stav_pervomayskoei',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'село Октябрьское' => [
                'stav_oktyabrskoe',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'посёлок Правокугультинский' => [
                'stav_pravokugult',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'село Родники' => [
                'stav_rodniki',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'посёлок Советское Руно' => [
                'stav_sovetruno',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'село Софиевка' => [
                'stav_sofievka',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'посёлок Софиевский Городок' => [
                'stav_sofievkagorod',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ],
            'село Тахта' => [
                'stav_taxta',
                'stav_ipat',
                'Ипатовский городской округ',
                32
            ]
        ],
        'Изобильненский городской округ' => [
            'город Изобильный' => [
                'stav_izobln',
                'stav_izob',
                'Изобильненский городской округ',
                33
            ],
            'посёлок Солнечнодольск' => [
                'stav_solnchedolsk',
                'stav_izob',
                'Изобильненский городской округ',
                33
            ],
            'станица Новотроицкая' => [
                'stav_troichkaya',
                'stav_izob',
                'Изобильненский городской округ',
                33
            ],
            'посёлок Рыздвяный' => [
                'stav_rzdvya',
                'stav_izob',
                'Изобильненский городской округ',
                33
            ],
            'село Московское' => [
                'stav_moskov',
                'stav_izob',
                'Изобильненский городской округ',
                33
            ],
            'село Птичье' => [
                'stav_ptich',
                'stav_izob',
                'Изобильненский городской округ',
                33
            ],
            'посёлок Передовой' => [
                'stav_peredovoy',
                'stav_izob',
                'Изобильненский городской округ',
                33
            ],
            'посёлок село Тищенское' => [
                'stav_tuchenskoe',
                'stav_izob',
                'Изобильненский городской округ',
                33
            ],
            'станица Каменнобродская' => [
                'stav_kamennobrod',
                'stav_izob',
                'Изобильненский городской округ',
                33
            ],
            'станица Староизобильная' => [
                'stav_staroizob',
                'stav_izob',
                'Изобильненский городской округ',
                33
            ],
            'станица Рождественская' => [
                'stav_rojdstv',
                'stav_izob',
                'Изобильненский городской округ',
                33
            ],
            'село Подлужное' => [
                'stav_podlj',
                'stav_izob',
                'Изобильненский городской округ',
                33
            ],
            'посёлок Новоизобильный' => [
                'stav_novoizob',
                'stav_izob',
                'Изобильненский городской округ',
                33
            ],
            'станица Баклановская' => [
                'stav_baklanovsk',
                'stav_izob',
                'Изобильненский городской округ',
                33
            ]
        ],
        'Грачевский муниципальный округ' => [
            'село Грачёвка' => [
                'stav_grachevk',
                'stav_grach',
                'Грачевский муниципальный округ',
                34
            ],
            'село Старомарьевка' => [
                'stav_staromar',
                'stav_grach',
                'Грачевский муниципальный округ',
                34
            ],
            'село Кугульта' => [
                'stav_kugultal',
                'stav_grach',
                'Грачевский муниципальный округ',
                34
            ],
            'село Спицевка' => [
                'stav_cpicevka',
                'stav_grach',
                'Грачевский муниципальный округ',
                34
            ],
            'село Бешпагир' => [
                'stav_behpagir',
                'stav_grach',
                'Грачевский муниципальный округ',
                34
            ],
            'село Сергиевское' => [
                'stav_sergievsk',
                'stav_grach',
                'Грачевский муниципальный округ',
                34
            ],
            'село Красное' => [
                'stav_krasnkoegr',
                'stav_grach',
                'Грачевский муниципальный округ',
                34
            ],
            'село Тугулук' => [
                'stav_tuguluk',
                'stav_grach',
                'Грачевский муниципальный округ',
                34
            ],
            'посёлок Верхняя Кугульта' => [
                'stav_verxkugulta',
                'stav_grach',
                'Грачевский муниципальный округ',
                34
            ],
            'посёлок Новоспицевский' => [
                'stav_novocpichevsk',
                'stav_grach',
                'Грачевский муниципальный округ',
                34
            ],
            'посёлок Ямки' => [
                'stav_yamki',
                'stav_grach',
                'Грачевский муниципальный округ',
                34
            ]
        ],
        'Георгиевский городской округ' => [
            'станица Незлобная' => [
                'stav_nezlob',
                'stav_geord',
                'Георгиевский городской округ',
                35
            ],
            'село Краснокумское' => [
                'stav_krasnokumge',
                'stav_geord',
                'Георгиевский городской округ',
                35
            ],
            'станица Александрийская' => [
                'stav_aleskcandryge',
                'stav_geord',
                'Георгиевский городской округ',
                35
            ],
            'станица Лысогорская' => [
                'stav_lsogorsk',
                'stav_geord',
                'Георгиевский городской округ',
                35
            ],
            'село Обильное' => [
                'stav_obilnoe',
                'stav_geord',
                'Георгиевский городской округ',
                35
            ],
            'станица Геориевская' => [
                'stav_georguevskaya',
                'stav_geord',
                'Георгиевский городской округ',
                35
            ],
            'станица Подгорная' => [
                'stav_podgornaya',
                'stav_geord',
                'Георгиевский городской округ',
                35
            ],
            'село Новозаведенное' => [
                'stav_novozaved',
                'stav_geord',
                'Георгиевский городской округ',
                35
            ],
            'станица Урухская' => [
                'stav_uruxskaya',
                'stav_geord',
                'Георгиевский городской округ',
                35
            ],
            'посёлок Шаумянский' => [
                'stav_haumyanski',
                'stav_geord',
                'Георгиевский городской округ',
                35
            ],
            'посёлок Новый' => [
                'stav_new',
                'stav_geord',
                'Георгиевский городской округ',
                35
            ],
            'посёлок Новоульяновский' => [
                'stav_novoulyan',
                'stav_geord',
                'Георгиевский городской округ',
                35
            ],
            'посёлок Падинский' => [
                'stav_padinski',
                'stav_geord',
                'Георгиевский городской округ',
                35
            ],
            'посёлок Балковский' => [
                'stav_balkosvki',
                'stav_geord',
                'Георгиевский городской округ',
                35
            ]
        ],
        'Будённовский муниципальный округ' => [
            'город Будённовск' => [
                'stav_byden',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'село Прасковея' => [
                'stav_krasnokumge',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'село Покойное' => [
                'stav_pokoynik',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'село Стародубское' => [
                'stav_starodub',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'село Орловка' => [
                'stav_orlovkab',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'село Архангельское' => [
                'stav_arxangelsk',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'село Новая жизнь' => [
                'stav_newlive',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'село Томузловское' => [
                'stav_tomuzlosvkoe',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'село Преображенское' => [
                'stav_preobrajensk',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'посёлок Терский' => [
                'stav_tersk',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'село Толстово-Васюковское' => [
                'stav_tolstovo',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'село Архиповское' => [
                'stav_arxip',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'село Красный Октябрь' => [
                'stav_kransokbr',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'посёлок Доброжеланный' => [
                'stav_dobrojelan',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'посёлок Искра' => [
                'stav_iskra',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'посёлок Катасон' => [
                'stav_katason',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'посёлок Кудрявый' => [
                'stav_kudryav',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'посёлок Левобережный' => [
                'stav_levoberejn',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'посёлок Луговой' => [
                'stav_lugovoy',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'посёлок Плаксейка' => [
                'stav_plakseyka',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'посёлок Полыновский' => [
                'stav_polnovskiy',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'посёлок Правобережный' => [
                'stav_pravoberejny',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'посёлок Прогресс' => [
                'stav_progress',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'посёлок Строителей' => [
                'stav_stroiteley',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'посёлок Терек' => [
                'stav_terek',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'посёлок Тихий' => [
                'stav_tixiy',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'посёлок Херсонский' => [
                'stav_cherson',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'посёлок Целинный' => [
                'stav_celin',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
            'посёлок Чкаловский' => [
                'stav_chkalovskiy',
                'stav_buden',
                'Будённовский муниципальный округ',
                36
            ],
        ],
        'Благодарненский городской округ' => [
            'город Благодарный' => [
                'stav_blagodrn',
                'stav_blag',
                'Благодарненский городской округ',
                37
            ],
            'село Сотниковское' => [
                'stav_sotnikovsk',
                'stav_blag',
                'Благодарненский городской округ',
                37
            ],
            'село Александрия' => [
                'stav_aleksandr',
                'stav_blag',
                'Благодарненский городской округ',
                37
            ],
            'село Бурлацкое' => [
                'stav_burlachkoe',
                'stav_blag',
                'Благодарненский городской округ',
                37
            ],
            'село Елизаветинское' => [
                'stav_eluzavet',
                'stav_blag',
                'Благодарненский городской округ',
                37
            ],
            'село Спасское' => [
                'stav_spasskoe',
                'stav_blag',
                'Благодарненский городской округ',
                37
            ],
            'село Каменная Балка' => [
                'stav_kamennyabalka',
                'stav_blag',
                'Благодарненский городской округ',
                37
            ],
            'село Алексеевское' => [
                'stav_alekseevsk',
                'stav_blag',
                'Благодарненский городской округ',
                37
            ],
            'село Шишкино' => [
                'stav_hihkino',
                'stav_blag',
                'Благодарненский городской округ',
                37
            ],
            'село Мирное' => [
                'stav_mirnoe',
                'stav_blag',
                'Благодарненский городской округ',
                37
            ]
        ],
        'Арзгирский муниципальный округ' => [
            'село Арзгир' => [
                'stav_arzgir',
                'stav_arzg',
                'Арзгирский муниципальный округ',
                38
            ],
            'село Петропавловское' => [
                'stav_petropavsk',
                'stav_arzg',
                'Арзгирский муниципальный округ',
                38
            ],
            'село Серафимовское' => [
                'stav_serafimvsk',
                'stav_arzg',
                'Арзгирский муниципальный округ',
                38
            ],
            'село Новорромановское' => [
                'stav_novorroman',
                'stav_arzg',
                'Арзгирский муниципальный округ',
                38
            ],
            'посёлок Чограйский' => [
                'stav_chograyvsk',
                'stav_arzg',
                'Арзгирский муниципальный округ',
                38
            ],
            'село Садовое' => [
                'stav_sadovoe',
                'stav_arzg',
                'Арзгирский муниципальный округ',
                38
            ],
            'село Родниковское' => [
                'stav_rodnikovsk',
                'stav_arzg',
                'Арзгирский муниципальный округ',
                38
            ],
            'село Каменная Балка' => [
                'stav_kamenbalkarg',
                'stav_arzg',
                'Арзгирский муниципальный округ',
                38
            ],
            'посёлок Довсун' => [
                'stav_dovsun',
                'stav_arzg',
                'Арзгирский муниципальный округ',
                38
            ],
            'посёлок Степной' => [
                'stav_stepnoy',
                'stav_arzg',
                'Арзгирский муниципальный округ',
                38
            ],
            'посёлок Башанта' => [
                'stav_bahanta',
                'stav_arzg',
                'Арзгирский муниципальный округ',
                38
            ]
        ],
        'Андроповский муниципальный округ' => [
            'село Курсавка' => [
                'stav_kyrsavka',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'село Солуно-Дмитриевское' => [
                'stav_soluno',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'станица Воровсколесская' => [
                'stav_kyrsavka',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'село Крымгиреевское' => [
                'stav_krmgireevsk',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'село Султан' => [
                'stav_sultan',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'село Куршава' => [
                'stav_kurhava',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'село Водораздел' => [
                'stav_vodorazdel',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'село Казинка' => [
                'stav_kazinka',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'село Янкуль' => [
                'stav_yankul',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'посёлок Новый Янкуль' => [
                'stav_newyankil',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'село Красноярское' => [
                'stav_krasnoyarks',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'село Суркуль' => [
                'stav_surkul',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'село Кианкиз' => [
                'stav_kiankiz',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'село Алексеевское' => [
                'stav_alekseevskoean',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'посёлок Каскадный' => [
                'stav_kaskadn',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'село Дубовая Балка' => [
                'stav_dobovayabalka',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'посёлок Верхний Янкуль' => [
                'stav_vyankul',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'село Подгорное' => [
                'stav_podgornoean',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'посёлок Нижний Янкуль' => [
                'stav_nyankul',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'посёлок Овражный' => [
                'stav_ovrajnan',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'посёлок Киан' => [
                'stav_kian',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ],
            'село Киан-Подгорное' => [
                'stav_kianpodgorn',
                'stav_androp',
                'Андроповский муниципальный округ',
                39
            ]
        ],
        'Александровский муниципальный округ' => [
            'село Александровское' => [
                'stav_aleksandroeal',
                'stav_aleskandr',
                'Александровский муниципальный округ',
                40
            ],
            'село Круглолесское' => [
                'stav_kruglolessk',
                'stav_aleskandr',
                'Александровский муниципальный округ',
                40
            ],
            'село Калиновское' => [
                'stav_kalinovska',
                'stav_aleskandr',
                'Александровский муниципальный округ',
                40
            ],
            'село Северное' => [
                'stav_severnoea',
                'stav_aleskandr',
                'Александровский муниципальный округ',
                40
            ],
            'село Саблинское' => [
                'stav_sablinskoe',
                'stav_aleskandr',
                'Александровский муниципальный округ',
                40
            ],
            'село Грушевское' => [
                'stav_gruhevskoe',
                'stav_aleskandr',
                'Александровский муниципальный округ',
                40
            ],
            'посёлок Новокавказский' => [
                'stav_newkavkaz',
                'stav_aleskandr',
                'Александровский муниципальный округ',
                40
            ],
            'посёлок Дубовая Роща' => [
                'stav_dubovayaroha',
                'stav_aleskandr',
                'Александровский муниципальный округ',
                40
            ],
            'посёлок Лесная Поляна' => [
                'stav_lesnayapolyana',
                'stav_aleskandr',
                'Александровский муниципальный округ',
                40
            ],
            'посёлок Малостепновский' => [
                'stav_malostepnovskiy',
                'stav_aleskandr',
                'Александровский муниципальный округ',
                40
            ],
        ],
        'Предгорный муниципальный район' => [
            'станица Ессентукская' => [
                'stav_essentukska',
                'stav_pred',
                'Предгорный муниципальный район',
                41
            ],
            'станица Суворовская' => [
                'stav_suvorovsk',
                'stav_pred',
                'Предгорный муниципальный район',
                41
            ],
            'село Юца' => [
                'stav_ucha',
                'stav_pred',
                'Предгорный муниципальный район',
                41
            ],
            'село Винсады' => [
                'stav_vincad',
                'stav_pred',
                'Предгорный муниципальный район',
                41
            ],
            'посёлок Пятигорский' => [
                'stav_pyatigorskiy',
                'stav_pred',
                'Предгорный муниципальный район',
                41
            ],
            'село Этока' => [
                'stav_etoka',
                'stav_pred',
                'Предгорный муниципальный район',
                41
            ],
            'посёлок Санамер' => [
                'stav_sanamer',
                'stav_pred',
                'Предгорный муниципальный район',
                41
            ],
            'посёлок Ясная Поляна' => [
                'stav_yacnayapolyanap',
                'stav_pred',
                'Предгорный муниципальный район',
                41
            ],
            'посёлок Нежинский' => [
                'stav_nejnsk',
                'stav_pred',
                'Предгорный муниципальный район',
                41
            ],
            'село Новоблагодарное' => [
                'stav_novoblagp',
                'stav_pred',
                'Предгорный муниципальный район',
                41
            ],
            'станица Боргустанская' => [
                'stav_borgustanskp',
                'stav_pred',
                'Предгорный муниципальный район',
                41
            ],
            'посёлок Подкумок' => [
                'stav_pogkumok',
                'stav_pred',
                'Предгорный муниципальный район',
                41
            ],
            'посёлок Железноводский' => [
                'stav_jeleznovodsvkiy',
                'stav_pred',
                'Предгорный муниципальный район',
                41
            ],
            'станица Бекешевская' => [
                'stav_bekehevskayap',
                'stav_pred',
                'Предгорный муниципальный район',
                41
            ],
            'посёлок Мирный' => [
                'stav_mirnyp',
                'stav_pred',
                'Предгорный муниципальный район',
                41
            ]
        ],
    ]
];





# ОКРУГИ
$district = [
    'Северо-Западный федеральный округ' => [
        'Ненецкий автономный округ' => [
            'посёлок Искателей',
            'посёлок Красное',
            'село Несь',
            'посёлок Нельмин-Нос',
            'село Ома',
            'посёлок Хорей-Вер',
            'село Нижняя Пеша'
        ],
        'Мурманская область' => [
            'город Мурманск',
            'город Апатиты',
            'город Гаджиево',
            'город Заозёрск',
            'город Заполярный',
            'город Кандалакша',
            'город Кировск',
            'город Ковдор',
            'город Кола',
            'город Кола',
            'город Мончегорск',
            'город Оленегорск',
            'город Островной',
            'город Полярные Зори',
            'город Полярный',
            'город Североморск',
            'город Снежногорск',
            'пгт Мармаши',
            'пгт Никель',
            'пгт Ревда',
            'пгт Сафоново',
            'пгт Зеленоборский'
        ],
        'Псковская область' => [
            'город Псков',
            'город Невель',
            'город Опочка',
            'город Печоры',
            'город Порхов',
            'город Дно',
            'город Новосокольники',
            'город Пыталово',
            'город Себеж',
            'город Пустошка',
            'город Гдов',
            'город Новоржев',
            'пгт Дедовичи',
            'пгт Идрица',
            'пгт Пушкинские горы',
            'пгт Струги Красные',
            'пгт Красногородск'
        ],
        'Архангельская область' => [
            'город Архангельск',
            'город Северодвинск',
            'город Котлас',
            'город Новодвинск',
            'город Коражма',
            'город Мирный',
            'город Вельск',
            'город Няндома',
            'город Онега',
            'город Каргополь',
            'город Шенкурск',
            'город Мезень',
            'город Сольвычегодск',
            'пгт Вычегодский',
            'пгт Коноша',
            'пгт Плесецк',
            'пгт Октябрьский',
            'пгт Савинский',
            'пгт Кулой'
        ],
        'Калининградская область' => [
            'город Калининград',
            'город Советск',
            'город Черняховск',
            'город Балтийск',
            'город Гусев',
            'город Светлый',
            'город Гурьевск',
            'город Зеленоградск',
            'город Светлогорск',
            'город Грардейск',
            'город Пионерский',
            'город Неман',
            'город Мамоново',
            'город Полесск',
            'город Багратионовск',
            'город Правдинск',
            'город Славск',
            'город Нестеров',
            'город Ладушкин',
            'город Озёрск',
            'город Краснознаменск',
            'город Приморск',
            'пгт Янтарный'
        ],
        'Новгородская область' => [
            'город Великий Новгород',
            'город Боровичи',
            'город Старая Русса',
            'город Пестово',
            'город Валдай',
            'город Чудово',
            'город Малая Вишера',
            'город Окуловка',
            'город Сольцы',
            'город Холм',
            'пгт Панковка',
            'пгт Крестцы',
            'пгт Парфино',
            'пгт Хвойная',
            'пгт Пролетарий'
        ],
        'Вологодская область' => [
            'город Череповец',
            'город Вологда',
            'город Сокол',
            'город Великий Устюг',
            'город Грязовец',
            'город Бабаево',
            'город Вытегра',
            'город Тотьма',
            'город Харовск',
            'город Белозерск',
            'город Устюжна',
            'город Никольск',
            'город Кириллов',
            'город Красавино',
            'город Кадников',
            'пгт Шексна',
            'пгт Кадуй',
            'пгт Вожега',
            'пгт Чагода',
            'пгт Вохтога',
            'пгт Хохлово'
        ],
        'Республика Коми' => [
            'город Сыктывкар',
            'город Ухта',
            'город Воркута',
            'город Печора',
            'город Усинск',
            'город Сосногорск',
            'город Инта',
            'город Емва',
            'город Вуктыл',
            'город Микунь',
            'пгт Воргашор',
            'пгт Нижний Одес',
            'пгт Краснозатонский',
            'пгт Ярега',
            'пгт Жешарт',
            'пгт Троицко-Печорск',
            'пгт Водный',
            'пгт Усогорск',
            'пгт Верхняя Максаковка'
        ],
        'Ленинградская область' => [
            'город Санкт-Петербург',
            'город Мурино',
            'город Гатчина',
            'город Всеволожск',
            'город Выборг',
            'город Сосновый Бор',
            'город Сертолово',
            'город Тихвин',
            'город Кудрово',
            'город Кириши',
            'город Кингисепп',
            'город Волхов',
            'город Тосно',
            'город Луга',
            'город Сланцы',
            'город Кировск',
            'город Отрадное',
            'город Коммунар',
            'город Никольское',
            'город Пикалёво',
            'город Лодейное Поле',
            'город Приозёрск',
            'город Подпорожье',
            'город Светогорск',
            'город Шлиссельбург',
            'город Бокситогорск',
            'город Сясьстрой',
            'город Волосово',
            'город Ивангород',
            'город Новая Ладога',
            'город Каменногорск',
            'город Приморск',
            'город Любань',
            'город Высоцк',
            'пгт Янино-1',
            'пгт Рощино',
            'пгт имени Свердлова',
            'пгт Сиверский',
            'пгт Ульяновка',
            'пгт Вырица',
            'пгт Кузьмоловский',
            'пгт имени морозова',
            'пгт Мга',
            'пгт Дубровка',
            'пгт Новоселье',
            'пгт Советский',
            'пгт Форносово',
            'пгт Приладожский',
            'пгт Виллози'
        ],
        'Республика Карелия' => [
            'город Петрозаводск',
            'город Костомукша',
            'город Кондопога',
            'город Сегежа',
            'город Сортавала',
            'город Медвежьегорск',
            'город Кемь',
            'город Питкяранта',
            'город Беломорск',
            'город Пудож',
            'город Суоярви',
            'город Олонец',
            'город Лахденпохья',
            'пгт Надводницы',
            'пгт Пиндуши'
        ],
    ],
    'Центральный федеральный округ' => [
        'Смоленская область' => [
            'город Смоленск',
            'город Вязьма',
            'город Рославль',
            'город Ярцево',
            'город Сафоново',
            'город Гагарин',
            'город Десногорск',
            'город Рудня',
            'город Дорогобуж',
            'город Ельня',
            'город Сычёвка',
            'город Починок',
            'город Велиж',
            'город Демидов',
            'город Духовщина',
            'пгт Верхнедпнепровский',
            'пгт Озёрный',
            'пгт Кардымово'
        ],
        'Брянская область' => [
            'город Брянск',
            'город Клинцы',
            'город Новозыбков',
            'город Дятьково',
            'город Унеча',
            'города Стародуб',
            'город Карачаев',
            'город Жуковка',
            'город Почеп',
            'город Сельцо',
            'город Трубчевск',
            'город Фокино',
            'город Сураж',
            'город Мглин',
            'город Севск',
            'город Злынка',
            'пгт Навля',
            'пгт Климово',
            'пгт Клетня',
            'пгт Локоть',
            'пгт Суземка',
            'пгт Белые Берега',
            'пгт Погар',
            'пгт Комаричи',
            'пгт Дубровка',
            'пгт Красная гора',
            'пгт Ивот',
            'пгт Любохна',
            'пгт Большое Полпино',
            'пгт Белая Берёзка',
            'пгт Выгоничи'
        ],
        'Курская область' => [
            'город Курск',
            'город Железногорск',
            'город Курчатов',
            'город Льгов',
            'город Рыльск',
            'город Щигры',
            'город Обоянь',
            'город Дмитриев',
            'город Фатеж',
            'город Суджа',
            'пгт имени Карла Либкнехта',
            'пгт Кненский',
            'пгт Прямицыно',
            'пгт Горшечное',
            'пгт Коренево',
            'пгт Пристень'
        ],
        'Белгородская область' => [
            'город Белгород',
            'город Старый Оскол',
            'город Губкин',
            'город Шебекино',
            'город Алексеевка',
            'город Валуйки',
            'город Строитель',
            'город Новый Оскол',
            'город Бирюч',
            'город Грайворон',
            'город Короча',
            'пгт Разумное',
            'пгт Чернявка',
            'пгт Борисовка',
            'пгт Северный',
            'пгт Ровеньки',
            'пгт Ракитное',
            'пгт Волоконовка',
            'пгт Прохоровка',
            'пгт Пролетарский',
            'пгт Красная Яруга',
            'пгт Томаровка',
            'пгт Ивня',
            'пгт Уразово',
            'пгт Октябрьский',
            'пгт Вейделевка',
            'пгт Маслова Пристань'
        ],
        'Воронежская область' => [
            'город Воронеж',
            'город Россошь',
            'город Борисоглебск',
            'город Лиски',
            'город Острогожск',
            'город Нововоронеж',
            'город Семилуки',
            'город Павловск',
            'город Бутурлиновка',
            'город Бобров',
            'город Калач',
            'город Поворино',
            'город Богучар',
            'город Эртиль',
            'город Новохопёрск',
            'пгт Анна',
            'пгт Грибановский',
            'пгт Таловая',
            'пгт Кантемировка',
            'пгт Рамонь',
            'пгт Каменка',
            'пгт Новохопёрский',
            'пгт Хохольский',
            'пгт Латная',
            'пгт Панино',
            'пгт Подгоренский'
        ],
        'Калужская область' => [
            'город Калуга',
            'город Обнинск',
            'город Людиново',
            'город Киров',
            'город Малоярославец',
            'город Балабаново',
            'город Козельск',
            'город Сухиничи',
            'город Кондрово',
            'город Жуков',
            'город Белоусово',
            'город Ермолино',
            'город Сосенский',
            'город Боровск',
            'город Кремёнки',
            'город Таруса',
            'город Медынь',
            'город Юхнов',
            'город Жиздра',
            'город Мосальск',
            'город Спас-Деменск',
            'город Мещовск',
            'пгт Таварково',
            'пгт Воротынск',
            'пгт Думиничи',
            'пгт Полотняный Завод'
        ],
        'Тверская область' => [
            'город Тверь',
            'город Ржев',
            'город Вышний Волочёк',
            'город Торжок',
            'город Кимры',
            'город Конаково',
            'город Удомля',
            'город Бологое',
            'город Бежецк',
            'город Нелидово',
            'город Осташков',
            'город Кашин',
            'город Калязин',
            'город Торопец',
            'город Лихославль',
            'город Кувшиново',
            'город Западная Двина',
            'город Старица',
            'город Андреаполь',
            'город Зубцов',
            'город Весьегонск',
            'город Красный Холм',
            'город Белый',
            'пгт Озёрный',
            'пгт Редкино',
            'пгт Максатиха',
            'пгт Новозавидовский',
            'пгт Спирово',
            'пгт Селижарово',
            'пгт Оленино'
        ],
        'Московская область' => [
            'город Москва',
            'город Балашиха',
            'город Подольск',
            'город Мытищи',
            'город Химки',
            'город Королёв',
            'город Люберцы',
            'город Красногорск',
            'город Электросталь',
            'город Одинцово',
            'город Коломна',
            'город Домодедово',
            'город Щёлково',
            'город Серпухов',
            'город Раменское',
            'город Долгопрудный',
            'город Орехово-Зуево',
            'город Пушкино',
            'город Реутов',
            'город Жуковский',
            'город Ногинск',
            'город Сергиев Посад',
            'город Воскресенск',
            'город Лобня',
            'город Ивантеевка',
            'город Видное',
            'город Клин',
            'город Дубна',
            'город Егорьевск',
            'город Чехов',
            'город Наро-Фоминск',
            'город Дмитров',
            'город Ступино',
            'город Павловский Посад',
            'город Лыткарино',
            'город Фрязино',
            'город Котельники',
            'город Дзержинский',
            'город Солнечногорск',
            'город Кашира',
            'город Краснознаменск',
            'город Протвино',
            'город Апрелевка',
            'город Истра',
            'город Дедовск',
            'город Шатура',
            'город Луховицы',
            'город Можайск',
            'город Ликино-Дулёво',
            'город Красноармейск',
            'город Лосино-Петровский',
            'город Звенигород',
            'город Озёры',
            'город Старая Купавна',
            'город Зарайск',
            'город Электрогорск',
            'город Бронницы',
            'город Хотьково',
            'город Кубинка',
            'город Куровское',
            'город Электроугли',
            'город Пущино',
            'город Черноголовка',
            'город Рошаль',
            'город Волоколамск',
            'город Белоозёрский',
            'город Голицыно',
            'город Яхрома',
            'город Пересвет',
            'город Краснозаводск',
            'город Талдом',
            'город Руза',
            'город Дрезна',
            'города Высоковск',
            'город Верея',
            'пгт Нахабино',
            'пгт Томилино',
            'пгт Власиха',
            'пгт Калининец',
            'пгт Малаховка',
            'пгт Красково',
            'пгт Октябрьский',
            'пгт Монино',
            'пгт Тучково',
            'пгт Свердловский',
            'пгт Удельная',
            'пгт Дрожжино',
            'пгт Софрино',
            'пгт Селятино',
            'пгт Большие Вязёмы',
            'пгт Ильнский',
            'пгт Запрудня',
            'пгт Некрасовский',
            'пгт Быково',
            'пгт Михнево',
            'пгт Фряново',
            'пгт Андреевка',
            'пгт Шаховская',
            'пгт Правдинский',
            'пгт Обухово',
            'пгт Ашукино',
            'пгт Кратово',
            'пгт Лесной городок',
            'пгт Серебрянные Пруды',
            'пгт Болородское',
            'пгт Поварово',
            'пгт Лесная',
            'пгт Лопатино',
            'пгт Загорянский',
            'пгт Боброво',
            'пгт Менделеево',
            'пгт Вербилки',
            'пгт Скоропусковский',
            'пгт Бутово',
            'пгт Заречье',
            'пгт Деденево',
            'пгт Белоомут',
            'пгт имени Воровского',
            'пгт Родники',
            'пгт Звёздный городок',
            'пгт Столбовая'
        ],
        'Орловская область' => [
            'город Орёл',
            'город Ливны',
            'город Мценск',
            'город Болхов',
            'город Дмитровск',
            'город Малоархангельск',
            'город Новосиль',
            'пгт Знаменка',
            'пгт Нарышкино',
            'пгт Верховье',
            'пгт Кромы',
            'пгт Змиёвка',
            'пгт Колпна',
            'пгт Глазуновка'
        ],
        'Липецкая область' => [
            'город Липецк',
            'город Елец',
            'город Грязи',
            'город Усмань',
            'город Лебедянь',
            'город Данков',
            'город Чаплыгин',
            'город Задонск'
        ],
        'Тульская область' => [
            'город Тула',
            'город Новомосковск',
            'город Донской',
            'город Алексин',
            'город Щёкино',
            'город Узловая',
            'город Ефремов',
            'город Богородицк',
            'город Киреевск',
            'город Кимовск',
            'город Суворов',
            'город Плавск',
            'город Ясногорск',
            'город Венёв',
            'город Белёв',
            'город Болохово',
            'город Липки',
            'город Советск',
            'город Чекалин',
            'пгт Первомайский',
            'пгт Заокский',
            'пгт Чернь',
            'пгт Дубна',
            'пгт Одоев',
            'пгт Куркино'
        ],
        'Рязанская область' => [
            'город Рязань',
            'город Касимов',
            'город Скопин',
            'город Сасово',
            'город Рыбное',
            'город Ряжск',
            'город Новомичуринск',
            'город Кораблино',
            'город Михайлов',
            'город Спасск-Рязанский',
            'город Шацк',
            'город Спас-Клепики',
            'пгт Шилово',
            'пгт Лесной',
            'пгт Тума',
            'пгт Кадом',
            'пгт Октябрьский'
        ],
        'Тамбовская область' => [
            'город Тамбов',
            'город Мичуринск',
            'город Рассказово',
            'город Моршанск',
            'город Котовск',
            'город Уварово',
            'город Кирсанов',
            'город Жердевка',
            'пгт Первомайский',
            'пгт Сосновка',
            'пгт Инжавино',
            'пгт Дмитриевка',
            'пгт Токарёвка',
            'пгт Мучкапский',
            'пгт Мордово',
            'пгт Знаменка'
        ],
        'Ярославская область' => [
            'город Ярославль',
            'город Рыбинск',
            'город Тутаев',
            'город Переславль-Залесский',
            'город Углич',
            'город Ростов',
            'город Гаврилов-Ям',
            'город Данилов',
            'город Пошехонье',
            'город Мышкин',
            'город Любим',
            'пгт Семибратово',
            'пгт Некрасовское',
            'пгт Константиновский',
            'пгт Борисоглебский'
        ],
        'Костромская область' => [
            'город Кострома',
            'города Шарья',
            'город Буй',
            'город Нерехта',
            'город Галич',
            'город Волгореченск',
            'город Мантурово',
            'город Нея',
            'город Макарьев',
            'город Солигалич',
            'город Чухлома',
            'город Кологрив',
            'пгт Ветлужский',
            'пгт Красное-на-Волге',
            'пгт Судиславль'
        ],
        'Ивановская область' => [
            'город Иваново',
            'город Кинешма',
            'город Шуя',
            'город Вичуга',
            'город Фурманов',
            'город Тейково',
            'город Кохма',
            'город Родники',
            'город Приволжск',
            'город Южа',
            'город Заволжск',
            'город Наволоки',
            'город Комсомольск',
            'город Юрьевеч',
            'город Плёс',
            'пгт Лежнево'
        ],
        'Владимирская область' => [
            'город Владимир',
            'город Ковров',
            'город Муров',
            'город Александров',
            'город Гусь-Хрустальный',
            'город Кольчугино',
            'город Вязники',
            'город Киржач',
            'город Радужный',
            'город Юрьев-Польский',
            'город Собинка',
            'город Покров',
            'город Карабаново',
            'город Лякинск',
            'город Меленки',
            'город Струнино',
            'город Гороховеч',
            'город Петушки',
            'город Камешково',
            'город Судогда',
            'город Суздаль',
            'город Костерёво',
            'город Курлово',
            'пгт Балакирево',
            'пгт Красная-Горбатка',
            'пгт Ставрово',
            'пгт Мелехово',
            'пгт Вольгинский',
            'пгт Городищи'
        ]
    ],
    'Приволжский федеральный округ' => [
        'Оренбургская область' => [
            'город Абдулино',
            'город Бугуруслан',
            'город Бузулук',
            'город Гай',
            'город Кувандык',
            'город Медногорск',
            'город Новотроицк',
            'город Оренбург',
            'город Орск',
            'город Сорочинск',
            'город Соль-Илецк',
            'город Ясный'
        ],
        'Республика Мордовия' => [
            'город Саранск',
            'город Рузаевка',
            'город Ковылкино',
            'город Краснолободск',
            'город Ардатов',
            'город Инсар',
            'город Темников',
            'пгт Комсомольский',
            'пгт Зубова Поляна',
            'пгт Чамзинка',
            'пгт Торбеево',
            'пгт Луховка',
            'пгт Ялга',
            'пгт Явас',
            'пгт Атяшево'
        ],
        'Пензенская область' => [
            'город Пенза',
            'город Кузнецк',
            'город Заречный',
            'город Каменка',
            'город Сердобск',
            'город Нижний Ломов',
            'город Никольск',
            'город Городище',
            'город Белинский',
            'город Спасск',
            'город Сурск',
            'пгт Мокшан',
            'пгт Башмаково',
            'пгт Земетчино',
            'пгт Колышлей',
            'пгт Пачелма',
            'пгт Лунино',
            'пгт Чаадаевка',
            'пгт Шемышейка',
            'пгт Тамала',
            'пгт Беково',
            'пгт Сосновоборск'
        ],
        'Саратовская область' => [
            'город Саратов',
            'город Энгельс',
            'город Балаково',
            'город Балашов',
            'город Вольск',
            'город Пугачёв',
            'город Ртищево',
            'город Маркс',
            'город Петровск',
            'город Аткарск',
            'город Красноармейск',
            'город Ершов',
            'город Калининск',
            'город Новоузенск',
            'город Красный Кут',
            'город Хвалынск',
            'город Аркадак',
            'город Шиханы',
            'пгт Приволжский',
            'пгт Степное',
            'пгт Базарный Карабулак',
            'пгт Озинки',
            'пгт Дергачи',
            'пгт Татищево',
            'пгт Лысые Горы',
            'пгт Соколовый',
            'пгт Самойловка',
            'пгт Романовка',
            'пгт Сенной',
            'пгт Мокроус',
            'пгт Новые Бурасы',
            'пгт Екатериновка',
            'пгт Турки'
        ],
        'Ульяновская область' => [
            'город Ульяновск',
            'город Димитровград',
            'город Инза',
            'город Барыш',
            'город Новоульяновск',
            'город Сенгилей',
            'пгт Чердаклы',
            'пгт Ишеевка',
            'пгт Новоспасское',
            'пгт Кузоватово',
            'пгт Карсун',
            'пгт Сурское',
            'пгт Старая Майна',
            'пгт Майна',
            'пгт Николаевка',
            'пгт Вешкайма',
            'пгт Мулловка',
            'пгт Новая Майна',
            'пгт Павловка'
        ],
        'Самарская область' => [
            'город Самара',
            'город Тольятти',
            'город Сызрань',
            'город Новокуйбышевск',
            'город Чапаевск',
            'город Жигулёвск',
            'город Отрадный',
            'город Кинель',
            'город Похвистнево',
            'город Октябрьск',
            'город Нефтегорск',
            'пгт Безенчук',
            'пгт Стройкерамика',
            'пгт Суходол',
            'пгт Рощинский',
            'пгт Смышляевка',
            'пгт Усть-Кинельский',
            'пгт Алексеевка',
            'пгт Новосемейкино',
            'пгт Волжский',
            'пгт Петра Дубрава',
            'пгт Мирный'
        ],
        'Республика Башкортостан' => [
            'город Уфа',
            'город Стерлитамак',
            'город Салават',
            'город Нефтекамск',
            'город Октябрьский',
            'город Туймазы',
            'город Белорецк',
            'город Ишимбай',
            'город Сибай',
            'город Кумертау',
            'город Белебей',
            'город Мелеуз',
            'город Бирск',
            'город Учалы',
            'город Благовещенск',
            'город Дюртюли',
            'город Янаул',
            'город Давлеканово',
            'город Чишмы',
            'город Приютово',
            'город Баймак',
            'город Межгорье',
            'город Агидель'
        ],
        'Нижегородская область' => [
            'город Нижний Новгород',
            'город Дзержинск',
            'город Арзамас',
            'город Саров',
            'город Бор',
            'город Кстово',
            'город Павлово',
            'город Выкса',
            'город Балахна',
            'город Заволжье',
            'город Богородск',
            'город Кулебаки',
            'город Городец',
            'город Семёнов',
            'город Лысково',
            'город Сергач',
            'город Шахунья',
            'город Навашино',
            'город Лукоянов',
            'город Первомайск',
            'город Урень',
            'город Чкаловск',
            'город Ворсма',
            'город Володарск',
            'город Перевоз',
            'город Ветлуга',
            'город Княгинино',
            'город Горбатов',
            'пгт Шатки',
            'пгт Ардатов',
            'пгт Сосновское',
            'пгт Выездное',
            'пгт Гидроторф',
            'пгт Красные Баки',
            'пгт Ильиногорск',
            'пгт Ковернино',
            'пгт Большое Козино',
            'пгт Пильна',
            'пгт Шаранга',
            'пгт Тумботино',
            'пгт Решетиха',
            'пгт Бутурлино',
            'пгт Сокольское',
            'пгт Вознесенское',
            'пгт Воротынец',
            'пгт Воскресенское',
            'пгт Сухобезводное',
            'пгт Ветлужский',
            'пгт Досчатое',
            'пгт Вача'
        ],
        'Чувашская Республика' => [
            'город Чебоксары',
            'город Новочебоксарск',
            'город Канаш',
            'город Алатырь',
            'город Шумерля',
            'город Цивильск',
            'город Козловка',
            'город Мариинский Посад',
            'город Ядрин'
        ],
        'Кировская область' => [
            'город Киров',
            'город Кирово-Чепецк',
            'город Вятские Поляны',
            'город Слободской',
            'город Котельнич',
            'город Омутнинск',
            'город Яранск',
            'город Советск',
            'город Сосновка',
            'город Белая Холуница',
            'город Зуевка',
            'город Уржум',
            'город Луза',
            'город Нолинск',
            'город Кирс',
            'город Малмыж',
            'город Орлов',
            'город Мураши',
            'пгт Вахруши',
            'пгт Оричи',
            'пгт Мурыгино',
            'пгт Восточный',
            'пгт Даровской',
            'пгт Первомайский',
            'пгт Красная Поляна',
            'пгт Кильмезь',
            'пгт Юрья'
        ],
        'Республика Марий Эл' => [
            'город Йошкар-Ола',
            'город Волжск',
            'город Козьмодемьянск',
            'город Звенигово',
            'пгт Медведево',
            'пгт Советский',
            'пгт Морки',
            'пгт Сернур',
            'пгт Красногорский',
            'пгт Оршанка',
            'пгт Новый Торъял',
            'пгт Параньга'
        ],
        'Республика Татарстан' => [
            'город Агрыз',
            'город Азнакаево',
            'город Альметьевск',
            'город Арск',
            'город Бавлы',
            'город Болгар',
            'город Бугульма',
            'город Буинск',
            'город Елабуга',
            'город Заинск',
            'город Зеленодольск',
            'город Иннополис',
            'город Казань',
            'город Кукмор',
            'город Лаишево',
            'город Лениногорск',
            'город Мамадыш',
            'город Менделеевск',
            'город Мензелинск',
            'город Набережные Челны',
            'город Нижнекамск',
            'город Нурлат',
            'город Тетюши',
            'город Чистополь',
            'пгт Васильево',
            'пгт Камские Поляны',
            'пгт Джалиль',
            'пгт Алексеевское',
            'пгт Уруссу',
            'пгт Нижняя Мактама',
            'пгт Аксубаево',
            'пгт Богатые Сабы',
            'пгт Балтаси',
            'пгт Актюбинский',
            'пгт Рыбная Слобода',
            'пгт Нижние Вязовые',
            'пгт Апастово'
        ],
        'Удмуртская Республика' => [
            'город Воткинск',
            'город Глазов',
            'город Ижевск',
            'город Камбарка',
            'город Можга',
            'город Сарапул'
        ],
        'Пермский край' => [
            'город Александровск',
            'город Березники',
            'город Верещагино',
            'город Горнозаводск',
            'город Гремячинск',
            'город Губаха',
            'город Добрянка',
            'город Кизел',
            'город Красновишерск',
            'город Краснокамск',
            'город Кудымкар',
            'город Кунгур',
            'город Лысьва',
            'город Нытва',
            'город Оса',
            'город Оханск',
            'город Очёр',
            'город Пермь',
            'город Соликамск',
            'город Усолье',
            'город Чайковский',
            'город Чердынь',
            'город Чёрмоз',
            'город Чернушка',
            'город Чусовой',
            'пгт Полазна',
            'пгт Октябрьский',
            'пгт Яйва',
            'пгт Звёздный',
            'пгт Углеуральский',
            'пгт Суксун',
            'пгт Уральский',
            'пгт Оверята'
        ]
    ],
    'Южный федеральный округ' => [
        'Республика Крым' => [
            'город Севастополь',
            'город Алупка',
            'город Алушта',
            'город Армянск',
            'город Бахчисарай',
            'город Белогорск',
            'город Джанкой',
            'город Евпатория',
            'город Керчь',
            'город Красноперекопск',
            'город Саки',
            'город Симферополь',
            'город Старый Крым',
            'город Судак',
            'город Феодосия',
            'город Щёлкино',
            'город Ялта'
        ],
        'Краснодарский край' => [
            'город Абинск',
            'город Анапа',
            'город Апшеронск',
            'город Армавир',
            'город Белореченск',
            'город Геленджик',
            'город Горячий Ключ',
            'город Гулькевичи',
            'город Ейск',
            'город Кореновск',
            'город Краснодар',
            'город Кропоткин',
            'город Крымск',
            'город Курганинск',
            'город Лабинск',
            'город Новокубанск',
            'город Новороссийск',
            'город Приморско-Ахтарск',
            'город Славянск-на-Кубани',
            'город Сочи',
            'город Темрюк',
            'город Тимашёвск',
            'город Тихорецк',
            'город Туапсе',
            'город Усть-Лабинск',
            'город Хадыженск',
            'пгт Ильский',
            'пгт Мостовской',
            'пгт Афипский',
            'пгт Ахтырский',
            'пгт Сириус',
            'пгт Новомихайловский',
            'пгт Псебай',
            'пгт Черноморский',
            'пгт Красносельский',
            'пгт Гирей',
            'пгт Джубга'
        ],
        'Ростовская область' => [
            'город Азов',
            'город Аксай',
            'город Батайск',
            'город Белая Калитва',
            'город Волгодонск',
            'город Гуково',
            'город Донецк',
            'город Зверево',
            'город Зерноград',
            'город Каменск-Шахтинский',
            'город Константиновск',
            'город Миллерово',
            'город Морозовск',
            'город Новочеркасск',
            'город Новошахтинск',
            'город Пролетарск',
            'город Ростов-на-Дону',
            'город Сальск',
            'город Семикаракорск',
            'город Красный Сулин',
            'город Таганрог',
            'город Цимлянск',
            'город Шахты',
            'пгт Глубокий',
            'пгт Горный',
            'пгт Каменоломни',
            'пгт Углеродовский',
            'пгт Усть-Донецкий',
            'пгт Шолоховский'
        ],
        'Республика Адыгея' => [
            'город Адыгейск',
            'город Майкоп',
            'пгт Тлюстенхабль',
            'пгт Энем',
            'пгт Яблоновский'
        ],
        'Волгоградская область' => [
            'город Волгоград',
            'город Волжский',
            'город Дубовка',
            'город Жирновск',
            'город Калач-на-Дону',
            'город Камышин',
            'город Котельниково',
            'город Котово',
            'город Краснослободск',
            'город Ленинск',
            'город Михайловка',
            'город Николаевск',
            'город Новоаннинский',
            'город Палласовка',
            'город Петров Вал',
            'город Серафимович',
            'город Суровикино',
            'город Урюпинск',
            'город Фролово',
            'пгт Городище',
            'пгт Средняя Ахтуба',
            'пгт Елань',
            'пгт Светлый Яр',
            'пгт Иловля',
            'пгт Новониколаевский',
            'пгт Быково',
            'пгт Новый Рогачик',
            'пгт Ерзовка',
            'пгт Рудня',
            'пгт Красный Яр',
            'пгт Октябрьский',
            'пгт Линёво'
        ],
        'Республика Калмыкия' => [
            'город Городовиковск',
            'город Лагань',
            'город Элиста'
        ],
        'Астраханская область' => [
            'город Астрахань',
            'город Ахтубинск',
            'город Знаменск',
            'город Камызяк',
            'город Нариманов',
            'город Харабали',
            'пгт Лиман',
            'пгт Верхний Баскунчак',
            'пгт Красные Баррикады',
            'пгт Ильинка'
        ]
    ],
    'Северо-Кавказский федеральный округ' => [
        'Республика Дагестан' => [
            'город Буйнакск',
            'город Дагестанские Огни',
            'город Дербент',
            'город Избербаш',
            'город Каспийск',
            'город Кизилюрт',
            'город Кизляр',
            'город Махачкала',
            'город Хасавюрт',
            'город Южно-Сухокумск',
            'пгт Ленинкент',
            'пгт Тарки',
            'пгт Семендер',
            'пгт Альбурикент',
            'пгт Шамхал',
            'пгт Мамедкала',
            'пгт Белиджи',
            'пгт Новый Кяхулай',
            'пгт Сулак',
            'пгт Кяхулай',
            'пгт Тюбе',
            'пгт Манас',
            'пгт Дубки',
            'пгт Бавтугай'
        ],
        'Республика Ингушетия' => [
            'город Карабулак',
            'город Магас',
            'город Малгобек',
            'город Назрань',
            'город Сунжа'
        ],
        'Кабардино-Балкарская Республика' => [
            'город Баксан',
            'город Майский',
            'город Нальчик',
            'город Нарткала',
            'город Прохладный',
            'город Терек',
            'город Тырныауз',
            'город Чегем'
        ],
        'Республика Серверная Осетия - Алания' => [
            'город Алагир',
            'город Ардон',
            'город Беслан',
            'город Владикавказ',
            'город Дигора',
            'город Заводской',
            'город Моздок'
        ],
        'Чеченская Республика' => [
            'город Аргун',
            'город Грозный',
            'город Гудермес',
            'город Курчалой',
            'город Урус-Мартан',
            'город Шали'
        ],
        'Ставропольский край' => [
            'Шпаковский муниципальный район' => [
                'город Ставрополь',
                'город Михайловск',
                'посёлок Верхнеегорлыксий',
                'село Верхнерусское',
                'село Дубовка',
                'село Казинка',
                'село Калиновка',
                'село Надежка',
                'станица Новомарьевская',
                'посёлок Новый Бешпагир',
                'село Пелагиада',
                'село Петропавловка',
                'посёлок Приозёрный',
                'посёлок Северный',
                'село Сенлилеевское',
                'посёлок Степной',
                'село Татарка',
                'станица Темнолесская',
                'посёлок Цимлянский',
                'посёлок Ясный'
            ],
            'Минераловодский городской округ' => [
                'город Минеральные Воды',
                'посёлок Бородыновка',
                'село Гражданское',
                'село Греческое',
                'село Долина',
                'село Дунаевка',
                'село Еруслановка',
                'посёлок Загорский',
                'посёлок Змейка',
                'село Канглы',
                'посёлок Кумагорск',
                'посёлок Кумской',
                'село Левокумка',
                'посёлок Ленинский',
                'село Марьины Колодцы',
                'село Нагутское',
                'посёлок Нижнебалковский',
                'село Нижняя Александровка',
                'посёлок Новотерский',
                'посёлок Первомайский',
                'село Побегайловка',
                'посёлок Привольный',
                'село Прикумское',
                'село Розовка',
                'село Сунжа',
                'село Ульяновка',
                'село Успеновка',
                'посёлок Фруктовый'
            ],
            'Апанасенковский муниципальный округ' => [
                'село Дивное',
                'село Апанасенковское',
                'посёлок Айгурский',
                'посёлок Белые Копани',
                'посёлок Вишнёвый',
                'посёлок Водный',
                'село Воздвиженское',
                'село Вознесеновскре',
                'село Дербетовка',
                'село Киевка',
                'село Малая Джалга',
                'село Манычское',
                'село Рагули',
                'посёлок Хлебный'
            ],
            'Советский городской округ' => [
                'город Зеленокумск',
                'посёлок Брусиловка',
                'село Горькая Балка',
                'посёлок Железнодорожный',
                'посёлок Колтуновский',
                'посёлок Михайловка',
                'село Отказное',
                'село Правокумское',
                'посёлок Селивановка',
                'село Солдато-Александровское'
            ],
            'Труновский муниципальный район' => [
                'село Безопасное',
                'село Донское',
                'село Ключевское',
                'посёлок Нижняя Терновка',
                'село Новая Кугульта',
                'посёлок Новотерновский',
                'село Подлесное',
                'посёлок имени Кировка',
                'посёлок Правоегорлыксий',
                'посёлок Сухой Лог',
                'село Труновское'
            ],
            'Туркменский муниципальный район' => [
                'посёлок Берёзовский',
                'посёлок Владимировка',
                'посёлок Голубиный',
                'село Казгулак',
                'село Камбулат',
                'село Кендже-Кулак',
                'посёлок Красная Поляна',
                'посёлок Красный Маныч',
                'село Кучерла',
                'село Летняя Ставка',
                'село Малые Ягуры',
                'посёлок Новокучерлинский',
                'посёлок Новорагулинский',
                'село Овощи',
                'посёлок Отрадный',
                'посёлок Поперечный',
                'посёлок Прудовый',
                'посёлок Таврический',
                'посёлок Троицкий'
            ],
            'Степновский муниципальный район' => [
                'село Богдановка',
                'село Варениковское',
                'посёлок Верхнестепной',
                'село Степное',
                'село Иргаклы',
                'село Соломенское',
                'село Ольгино',
                'село Зелёная Роща',
                'село Никольское',
                'село Озёрное',
                'посёлок Новоиргаклинский'
            ],
            'Петровский городской округ' => [
                'город Светлоград',
                'село Константиновское',
                'село Гофицкое',
                'село Благодатное',
                'село Сухая Буйвола',
                'село Николина Балка',
                'село Высоцкое',
                'посёлок Рогатая Балка',
                'село Донская Балка',
                'село Шведино',
                'село Ореховка',
                'село Ореховка',
                'село Просянка',
                'село Шангала',
                'посёлок Прикалаусский',
                'посёлок Горный',
                'село Кугуты',
                'посёлок Маяк',
                'село Мартыновка',
                'посёлок Полевой',
                'посёлок Пшеничный',
                'посёлок Цветочный'
            ],
            'Новоселицкий муниципальный район' => [
                'село Новоселицкое',
                'село Чернолесское',
                'село Журавское',
                'село Китаевское',
                'село Долиновка',
                'село Падинское',
                'посёлок Новый Маяк',
                'посёлок Щелкан',
                'посёлок Артезианский'
            ],
            'Новоалександровский городской округ' => [
                'город Новоалександровск',
                'посёлок Виноградный',
                'посёлок Восточный',
                'посёлок Встречный',
                'посёлок Горьковский',
                'посёлок Дружба',
                'посёлок Заречный',
                'посёлок Кармалиновский',
                'посёлок Краснозоринский',
                'посёлок Краснокубанский',
                'посёлок Крутобалковский',
                'посёлок Курганный',
                'посёлок Лиманный',
                'посёлок Озёрный',
                'посёлок Присадовый',
                'посёлок Равнинный',
                'посёлок Радуга',
                'посёлок Рассвет',
                'посёлок Светлый',
                'посёлок Славенский',
                'посёлок Темижбекский',
                'посёлок Ударный',
                'посёлок Южный',
                'село Раздольное',
                'станица Воскресенская',
                'станица Григорополисская',
                'станица Кармалиновская',
                'станица Расшеватская'
            ],
            'Нефтекумский городский округ' => [
                'город Нефтекумск',
                'пгт Затеречный',
                'село Ачикулак',
                'село Каясула',
                'село Кара-Тюбе',
                'село Озек-Суат',
                'посёлок Зункарь',
                'посёлок Зимняя Ставка',
                'посёлок Левобалковский'
            ],
            'Левокумский муниципальный округ' => [
                'село Лекокумское',
                'село Величаевское',
                'село Правокумское',
                'село Урожайное',
                'село Владимировка',
                'село Приозёрское',
                'село Турксад',
                'посёлок Новокумский',
                'посёлок Заря',
                'село Николо-Александровское',
                'село Бургун-Маджары',
                'посёлок Кумская Долина',
                'посёлок Ленинский',
                'посёлок Малосадовый',
                'посёлок Камышитовый',
                'посёлок Правокумский'
            ],
            'Курский муниципальный район' => [
                'станица Курская',
                'село Эдиссия',
                'село Русское',
                'станица Галюгаевская',
                'посёлок Мирный',
                'село Ростовановское',
                'посёлок Балтийский',
                'село Полтавское',
                'станица Стодеревская',
                'село Каново',
                'посёлок Ага-Батыр',
                'село Серноводское',
                'село Уваровское',
                'посёлок Рощино',
                'посёлок Бурунный',
                'посёлок Ровный',
                'село Добровольное',
                'посёлок Совхозный',
                'посёлок Трудовой',
                'посёлок Южанин',
                'посёлок Правобережный',
                'посёлок Песчаный',
                'посёлок Новобалийский',
                'посёлок Ленпосёлок'
            ],
            'Красногвардейский муниципальный район' => [
                'село Красногвардейское',
                'село Ладовская Балка',
                'село Привольное',
                'село Преградное',
                'село Дмитриевское',
                'село Родыки',
                'село Новомихайловское',
                'посёлок Коммунар',
                'село Покровское',
                'посёлок Медвеженский',
                'посёлок Штурм',
                'посёлок Озерки',
                'посёлок Зеркальный',
                'посёлок Зерновой',
                'посёлок Новомирненский'
            ],
            'Кочубеевский муниципальный район' => [
                'село Кочубеевское',
                'село Ивановское',
                'село Казьминское',
                'станица Барсуковская',
                'село Балахоновское',
                'село Заветное',
                'станица Беломечётская',
                'село Новая Деревня',
                'село Весёлое',
                'село Воронежское',
                'посёлок Тоннельный',
                'станица Георгиевская',
                'село Вревское',
                'село Надзорное',
                'посёлок Рабочий',
                'село Дворцовское',
                'станица Новоекатериновская',
                'село Галицино',
                'посёлок Свистуха',
                'станица Сунженская'
            ],
            'Кировский городской округ' => [
                'город Новопавловск',
                'посёлок Грибной',
                'посёлок Золка',
                'посёлок Зольский Карьер',
                'посёлок Камышовый',
                'посёлок Коммаяк',
                'посёлок Комсомолец',
                'посёлок Прогресс',
                'посёлок Фазанный',
                'село Горнозаводское',
                'село Новосредненское',
                'село Орловка',
                'станица Зольская',
                'станица Марьинская',
                'станица Советская',
                'станица Старопавловская'
            ],
            'Ипатовский городской округ' => [
                'город Ипатово',
                'село Большая Джалга',
                'посёлок Большевик',
                'село Бурукшун',
                'посёлок Верхнетахтинский',
                'посёлок Винодельненский',
                'посёлок Горлинка',
                'посёлок Двуречный',
                'село Добровольное',
                'посёлок Донцово',
                'посёлок Дружный',
                'посёлок Залесный',
                'село Золотарёвка',
                'посёлок Калаусский',
                'село Кевсала',
                'село Красная Поляна',
                'посёлок Красочный',
                'село Крестьянское',
                'село Лесная Дача',
                'село Лиман',
                'посёлок Малоипатовский',
                'село Первомайское',
                'село Октябрьское',
                'посёлок Правокугультинский',
                'село Родники',
                'посёлок Советское Руно',
                'село Софиевка',
                'посёлок Софиевский Городок',
                'село Тахта'
            ],
            'Изобильненский городской округ' => [
                'город Изобильный',
                'посёлок Солнечнодольск',
                'станица Новотроицкая',
                'посёлок Рыздвяный',
                'село Московское',
                'село Птичье',
                'посёлок Передовой',
                'посёлок село Тищенское',
                'станица Каменнобродская',
                'станица Староизобильная',
                'станица Рождественская',
                'село Подлужное',
                'посёлок Новоизобильный',
                'станица Баклановская'
            ],
            'Грачевский муниципальный округ' => [
                'село Грачёвка',
                'село Старомарьевка',
                'село Кугульта',
                'село Спицевка',
                'село Бешпагир',
                'село Сергиевское',
                'село Красное',
                'село Тугулук'
            ],
            'Георгиевский городской округ' => [
                'станица Незлобная',
                'село Краснокумское',
                'станица Александрийская',
                'станица Лысогорская',
                'село Обильное',
                'станица Геориевская',
                'станица Подгорная',
                'село Новозаведенное',
                'станица Урухская',
                'посёлок Шаумянский',
                'посёлок Новый',
                'посёлок Новоульяновский',
                'посёлок Падинский',
                'посёлок Балковский'
            ],
            'Будённовский муниципальный округ' => [
                'город Будённовск',
                'село Прасковея',
                'село Покойное',
                'село Стародубское',
                'село Орловка',
                'село Архангельское',
                'село Новая жизнь',
                'село Томузловское',
                'село Преображенское',
                'посёлок Терский',
                'село Толстово-Васюковское',
                'село Архиповское',
                'село Красный Октябрь'
            ],
            'Благодарненский городской округ' => [
                'город Благодарный',
                'село Сотниковское',
                'село Александрия',
                'село Бурлацкое',
                'село Елизаветинское',
                'село Спасское',
                'село Каменная Балка',
                'село Алексеевское',
                'село Шишкино',
                'село Мирное'
            ],
            'Арзгирский муниципальный округ' => [
                'село Арзгир',
                'село Петропавловское',
                'село Серафимовское',
                'село Новорромановское',
                'посёлок Чограйский',
                'село Садовое',
                'село Родниковское',
                'село Каменная Балка'
            ],
            'Андроповский муниципальный округ' => [
                'село Курсавка',
                'село Солуно-Дмитриевское',
                'станица Воровсколесская',
                'село Крымгиреевское',
                'село Султан',
                'село Куршава',
                'село Водораздел',
                'село Казинка',
                'село Янкуль',
                'посёлок Новый Янкуль',
                'село Красноярское',
                'село Суркуль',
                'село Кианкиз',
                'село Алексеевское',
                'посёлок Каскадный',
                'село Дубовая Балка',
                'посёлок Верхний Янкуль',
                'село Подгорное',
                'посёлок Нижний Янкуль',
                'посёлок Овражный',
                'посёлок Киан',
                'село Киан-Подгорное'
            ],
            'Александровский муниципальный округ' => [
                'село Александровское',
                'село Круглолесское',
                'село Калиновское',
                'село Северное',
                'село Саблинское',
                'село Грушевское',
                'посёлок Новокавказский'
            ],
            'Предгорный муниципальный район' => [
                'станица Ессентукская',
                'станица Суворовская',
                'село Юца',
                'село Винсады',
                'посёлок Пятигорский',
                'село Этока',
                'посёлок Санамер',
                'посёлок Ясная Поляна',
                'посёлок Нежинский',
                'село Новоблагодарное',
                'станица Боргустанская',
                'посёлок Подкумок',
                'посёлок Железноводский',
                'станица Бекешевская',
                'посёлок Мирный'
            ],
        ],
        'Карачаево-Черкесская Республика' => [
            'город Черкесск',
            'город Усть-Джегута',
            'город Карачаевск',
            'город Теберда',
            'пгт Домбай',
            'пгт Медногорский',
            'пгт Новый Карачай',
            'пгт Орджоникидзевский',
            'пгт Правокубанский',
            'пгт Ударный',
            'пгт Эльбрусский',
            'станица Зеленчукская',
            'станица Сторожевая',
            'станица Кардоникская',
            'станица Преградная',
            'станица Исправная',
            'посёлок Мара-Аягъы',
            'посёлок Малокурганный',
            'посёлок Медногорский',
            'село Курджиново',
            'село Учкекен',
            'село Терезе',
            'село Первомайское',
            'село Красный Курган',
            'село Чапаевское'
        ]
    ],
    'Уральский федеральный округ' => [
        'Челябинская область' => [
            'город Аша',
            'город Бакал',
            'город Верхнеуральск',
            'город Верхний Уфалей',
            'город Еманжелинск',
            'город Златоуст',
            'город Карабаш',
            'город Карталы',
            'город Касли',
            'город Катав-Ивановск',
            'город Копейск',
            'город Коркино',
            'город Куса',
            'город Кыштым',
            'город Магнитогорск',
            'город Миасс',
            'город Миньяр',
            'город Нязепетровск',
            'город Озёрск',
            'город Пласт',
            'город Сатка',
            'город Сим',
            'город Снежинск',
            'город Трёхгорный',
            'город Троицк',
            'город Усть-Катав',
            'город Чебаркуль',
            'город Челябинск',
            'город Южноуральск',
            'город Юрюзань',
            'пгт Роза',
            'пгт Красногорский',
            'пгт Первомайский',
            'пгт Локомотивный',
            'пгт Зауральский',
            'пгт Межозёрный'
        ],
        'Ямало-Ненецкий автономный округ' => [
            'город Губкинский',
            'город Лабытнанги',
            'город Муравленко',
            'город Надым',
            'город Новый Уренгой',
            'город Ноябрьск',
            'город Салехард',
            'город Тарко-Сале',
            'пгт Пангоды',
            'пгт Уренгой',
            'пгт Харп'
        ],
        'Курганская область' => [
            'город Далматово',
            'город Катайск',
            'город Курган',
            'город Куртамыш',
            'город Макушино',
            'город Петухово',
            'город Шадринск',
            'город Шумиха',
            'город Щучье',
            'пгт Варгаши',
            'пгт Каргаполье',
            'пгт Юргамыш',
            'пгт Мишкино',
            'пгт Лебяжье'
        ],
        'Тюменская область' => [
            'город Заводоуковск',
            'город Ишим',
            'город Тобольск',
            'город Тюмень',
            'город Ялуторовск',
            'пгт Богандинский',
            'пгт Боровский',
            'пгт Винзили',
            'пгт Голышманово'
        ],
        'Свердловская область' => [
            'город Екатеринбург',
            'город Алапаевск',
            'город Арамиль',
            'город Артёмовский',
            'город Асбест',
            'город Берёзовский',
            'город Богданович',
            'город Верхний Тагил',
            'город Верхняя Пышма',
            'город Верхняя Салда',
            'город Верхняя Тура',
            'город Верхотурье',
            'город Волчанск',
            'город Дегтярск',
            'город Заречный',
            'город Ивдель',
            'город Ирбит',
            'город Каменск-Уральский',
            'город Камышлов',
            'город Карпинск',
            'город Качканар',
            'город Кировград',
            'город Краснотурьинск',
            'город Красноуральск',
            'город Красноуфимск',
            'город Кушва',
            'город Лесной',
            'город Михайловск',
            'город Невьянск',
            'город Нижние Серги',
            'город Нижний Тагил',
            'город Нижняя Салда',
            'город Нижняя Тура',
            'город Новая Ляля',
            'город Новоуральск',
            'город Первоуральск',
            'город Полевской',
            'город Ревда',
            'город Реж',
            'город Североуральск',
            'город Серов',
            'город Среднеуральск',
            'город Сухой Лог',
            'город Сысерть',
            'город Тавда',
            'город Талица',
            'город Туринск',
            'пгт Рефтинский',
            'пгт Арти',
            'пгт Белоярский',
            'пгт Свободный',
            'пгт Верхняя Синячиха',
            'пгт Бисерть',
            'пгт Пышма',
            'пгт Малышева',
            'пгт Сосьва',
            'пгт Шаля',
            'пгт Тугулым',
            'пгт Верхние Серги',
            'пгт Верхнее Дуброво'
        ],
        'Ханты-Мансийский автономный округ' => [
            'город Белоярский',
            'город Когалым',
            'город Лангепас',
            'город Лянтор',
            'город Мегион',
            'город Нефтеюганск',
            'город Нижневартовск',
            'город Нягань',
            'город Покачи',
            'город Пыть-Ях',
            'город Радужный',
            'город Советский',
            'город Сургут',
            'город Урай',
            'город Ханты-Мансийск',
            'город Югорск',
            'пгт Пойковский',
            'пгт Фёдоровский',
            'пгт Излучинск',
            'пгт Белый Яр',
            'пгт Междуреченский',
            'пгт Новоаганск',
            'пгт Игрим',
            'пгт Высокий',
            'пгт Берёзово',
            'пгт Приобье',
            'пгт Барсово'
        ]
    ],
    'Сибирский федеральный округ' => [
        'Омская область' => [
            'город Омск',
            'город Тара',
            'город Калачинск',
            'город Исилькуль',
            'город Называевск',
            'город Тюкалинск',
            'пгт Таврическое',
            'пгт Черлак',
            'пгт Большеречье',
            'пгт Любинский',
            'пгт Муромцево',
            'пгт Москаленки',
            'пгт Кормиловка',
            'пгт Марьяновка',
            'пгт Саргатское',
            'пгт Павлоградка',
            'пгт Тевриз',
            'пгт Крутинка',
            'пгт Полтавка',
            'пгт Шербакуль',
            'пгт Русская Поляна',
            'пгт Нововаршавка',
            'пгт Горьковское',
            'пгт Красный Яр',
            'пгт Оконешниково'
        ],
        'Новосибирская область' => [
            'город Новосибирск',
            'город Бердск',
            'город Искитим',
            'город Куйбышев',
            'город Обь',
            'город Барабинск',
            'город Карасук',
            'город Татарск',
            'город Тогучин',
            'город Черепаново',
            'город Болотное',
            'город Купино',
            'город Чулым',
            'город Каргат',
            'пгт Краснообск',
            'пгт Линёво',
            'пгт Кольцово',
            'пгт Коченёво',
            'пгт Сузун',
            'пгт Маслянино',
            'пгт Колывань',
            'пгт Ордынское',
            'пгт Мошково',
            'пгт Краснозёрское',
            'пгт Горный',
            'пгт Чаны',
            'пгт Чистоозёрное',
            'пгт Чик',
            'пгт Станционно-Ояшинский'
        ],
        'Алтайский край' => [
            'город Барнаул',
            'город Бийск',
            'город Рубцовск',
            'город Новоалтайск',
            'город Заринск',
            'город Камень-на-Оби',
            'город Славгород',
            'город Алейск',
            'город Яровое',
            'город Белокуриха',
            'город Горняк',
            'город Змеиногорск',
            'пгт Южный',
            'пгт Тальменка',
            'пгт Сибирский',
            'пгт Благовещенка',
            'пгт Степное Озеро',
            'пгт Малиновое Озеро'
        ],
        'Республика Алтай' => [
            'город Горно-Алтайск',
            'село Кош-Агач',
            'село Майма',
            'село Онгудай',
            'село Турочак'
        ],
        'Республика Тыва' => [
            'город Кызыл',
            'город Каа-Хем',
            'город Ак-Довурак',
            'город Шагонар',
            'город Чадан',
            'город Туран'
        ],
        'Иркутская область' => [
            'город Иркутск',
            'город Братск',
            'город Ангарск',
            'город Усть-Илимск',
            'город Усолье-Сибирское',
            'город Черемхово',
            'город Шелехов',
            'город Усть-Кут',
            'город Тулун',
            'город Саянск',
            'город Нижнеудинск',
            'город Тайшет',
            'город Зима',
            'город Железногорск-Илимский',
            'город Вихоревка',
            'город Слюдянка',
            'город Свирск',
            'город Байкальск',
            'город Бодайбо',
            'город Киренск',
            'город Бирюсинск',
            'город Алзамай',
            'пгт Маркова',
            'пгт Чунский',
            'пгт Залари',
            'пгт Новая Игирма'
        ],
        'Красноярский край' => [
            'город Красноярск',
            'город Норильск',
            'город Ачинск',
            'город Канск',
            'город Железногорск',
            'город Минусинск',
            'город Зеленогорск',
            'город Лесосибириск',
            'город Назарово',
            'город Сосновоборск',
            'город Шарыпово',
            'город Дивногорск',
            'город Дудинка',
            'город Боготол',
            'город Енисейск',
            'город Ужур',
            'город Кодинск',
            'город Иланский',
            'город Уяр',
            'город Заозёрный',
            'город Игарка',
            'город Артёмовск',
            'пгт Берёзовка',
            'пгт Шушенское',
            'пгт Емельяново',
            'пгт Курагино',
            'пгт Солнечный',
            'пгт Дубинино',
            'пгт Нижняя Пойма',
            'пгт Большая Мурта',
            'пгт Козулька',
            'пгт Нижний Ингаш',
            'пгт Балахта',
            'пгт Подгорный',
            'пгт Северо-Енисейский',
            'пгт Кедровый'
        ],
        'Томская область' => [
            'город Томск',
            'город Северск',
            'город Стрежевой',
            'город Асино',
            'город Колпашево',
            'пгт Белый Яр',
            'город Кедровый'
        ],
        'Кемеровская область' => [
            'город Кемерово',
            'город Новокузнецк',
            'город Прокопьевск',
            'город Междуреченск',
            'город Ленинск-Кузнецкий',
            'город Киселёвск',
            'город Юрга',
            'город Белово',
            'город Анжеро-Судженск',
            'город Берёзовский',
            'город Осинники',
            'город Мыски',
            'город Мариинск',
            'город Топки',
            'город Полысаево',
            'город Таштагол',
            'город Тайга',
            'город Гурьевск',
            'город Калтан',
            'город Салаир',
            'пгт Промышленная',
            'пгт Новый Городок',
            'пгт Бачатский',
            'пгт Яшкино',
            'пгт Грамотеино',
            'пгт Инской',
            'пгт Краснобродский',
            'пгт Яя',
            'пгт Шерегеш',
            'пгт Тяжинский',
            'пгт Тисуль',
            'пгт Крапивинский',
            'пгт Ижморский'
        ],
        'Республика Хакасия' => [
            'город Абакан',
            'город Черногорск',
            'город Саяногорск',
            'город Абаза',
            'город Сорск',
            'пгт Усть-Абакан',
            'пгт Черёмушки',
            'пгт Майна'
        ]
    ],
    'Дальневосточный федеральный округ' => [
        'Республика Бурятия' => [
            'город Улан-Удэ',
            'город Северобайкальск',
            'город Гусиноозёрск',
            'город Кяхта',
            'город Закаменск',
            'город Бабушкин',
            'пгт Селенгинск',
            'пгт Онохой',
            'пгт Таксимо',
            'пгт Усть-Баргузин',
            'пгт Каменск',
            'пгт Заиграево',
            'пгт Нижнеангарск',
            'пгт Новый Уоян'
        ],
        'Забайкальский край' => [
            'город Чита',
            'город Краснокаменск',
            'город Борзя',
            'город Петровск-Забайкальский',
            'город Нерчинск',
            'город Могоча',
            'город Шилка',
            'город Балей',
            'город Хилок',
            'город Сретенск',
            'пгт Агинское',
            'пгт Забайкальский',
            'пгт Чернышевск',
            'пгт Карымское',
            'пгт Шерловая Гора',
            'пгт Первомайский',
            'пгт Могойтуй',
            'пгт Атамановка',
            'пгт Новокручининский',
            'пгт Горный'
        ],
        'Амурская область' => [
            'город Белогорск',
            'город Благовещенск',
            'город Завитинск',
            'город Зея',
            'город Райчихинск',
            'город Свободный',
            'город Сковородино',
            'город Тында',
            'город Циолковский',
            'город Шимановск',
            'пгт Магдагачи',
            'пгт Серышево',
            'пгт Прогресс',
            'пгт Архара',
            'пгт Новобурейский'
        ],
        'Еврейская автономная область' => [
            'город Биробиджан',
            'город Облучье',
            'пгт Николаевка'
        ],
        'Приморский край' => [
            'город Арсеньев',
            'город Артём',
            'город Большой Камень',
            'город Владивосток',
            'город Дальнегорск',
            'город Дальнереченск',
            'город Лесозаводск',
            'город Находка',
            'город Партизанск',
            'город Спасск-Дальний',
            'город Уссурийск',
            'город Фокино',
            'пгт Лучегорск',
            'пгт Кавалерово',
            'пгт Славянка',
            'пгт Пограничный',
            'пгт Кировский',
            'пгт Ярославский',
            'пгт Сибирцево',
            'пгт Дунай',
            'пгт Преображение',
            'пгт Смоляниново',
            'пгт Новошахтинский',
            'пгт Липовцы'
        ],
        'Магаданская область' => [
            'город Магадан',
            'город Сусуман',
            'пгт Ола'
        ],
        'Сахалинская область' => [
            'город Александровск-Сахалинский',
            'город Анива',
            'город Долинск',
            'город Корсаков',
            'город Курильск',
            'город Макаров',
            'город Невельск',
            'город Оха',
            'город Поронайск',
            'город Северо-Курильск',
            'город Томари',
            'город Углегорск',
            'город Холмск',
            'город Южно-Сахалинск',
            'пгт Ноглики',
            'пгт Смирных',
            'пгт Южно-Курильск',
            'пгт Тымовское',
            'пгт Шахтёрск'
        ],
        'Камчатский край' => [
            'город Вилючинск',
            'город Елизово',
            'город Петропавловск-Камчатский',
            'пгт Вулканный',
            'пгт Палана'
        ],
        'Чукотский автономный округ' => [
            'город Анадырь',
            'город Билибино',
            'город Певек',
            'пгт Беринговский',
            'пгт Мыс Шмидта',
            'пгт Провидения',
            'пгт Угольные Копи',
            'пгт Эгвекинот'
        ],
        'Хабаровский край' => [
            'город Хабаровск',
            'город Амурск',
            'город Бикин',
            'город Вяземский',
            'город Комсомольск-на-Амуре',
            'город Николаевск-на-Амуре',
            'город Советская Гавань',
            'пгт Ванино',
            'пгт Солнечный',
            'пгт Чегдомын',
            'пгт Эльбан',
            'пгт Хор',
            'пгт Заветы Ильича',
            'пгт Переяславка',
            'пгт Новый Ургал',
            'пгт Корфовский',
            'пгт Октябрьский'
        ],
        'Республика Саха (Якутия)' => [
            'город Алдан',
            'город Верхоянск',
            'город Вилюйск',
            'город Ленск',
            'город Мирный',
            'город Нерюнгри',
            'город Нюрба',
            'город Олёкминск',
            'город Покровск',
            'город Среднеколымск',
            'город Томмот',
            'город Удачный',
            'город Якутск',
            'пгт Айхал',
            'пгт Жатай',
            'пгт Чульман',
            'пгт Мохсоголлох',
            'пгт Хандыга',
            'пгт Нижний Куранах'
        ]
    ]
];

$district_code = [
    'sevzap',
    'center',
    'privol',
    'ufo',
    'sevkav',
    'ural',
    'sibir',
    'daln'
];






$stav = [
    'Шпаковский муниципальный район' => [
        'stav_shpak',
        '<path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 194.00822,403.23256 0.0404,0.14035 -0.16321,0.18412 -0.0106,0.12621 0.17906,0.0104 -0.0106,0.15262 0.0651,0.0865 0.12963,0.0133 0.005,0.1158 -0.11321,0.1481 -0.002,0.0937 0.30189,0.17558 0.0351,0.4803 0.17774,0.0216 0.0998,0.14009 0.28302,0.14249 0.003,0.13208 -0.20755,0.13475 0.0215,0.0806 0.14811,0.0915 0.28302,0.10007 0.004,0.15583 -0.0564,0.12381 0.12925,0.16436 -0.16434,0.13742 -0.0108,0.23962 0.0592,0.0752 0.1266,0.0702 0.0432,0.0752 -0.0459,0.0728 -0.0162,0.19399 0.14283,0.19372 -0.18566,0.25322 0.13472,0.3202 -0.0126,0.1054 0.17264,0.29352 0.0843,0.3202 0.22642,0.29351 0.15905,0.11234 -0.0426,0.23428 0.28302,0.37356 -0.22641,0.11047 0.14226,0.26683 0.18868,0.23695 0.0159,0.42693 0.0841,0.0736 0.16849,-0.0315 0.11038,0.13662 -0.0209,0.18411 0.0947,0.0211 0.11057,0.22627 0.30188,-0.0179 0.0736,0.50698 0.1,0.12648 -0.0789,0.26309 0.26415,0.29352 0.0423,0.15796 0.33963,0.40025 0.37736,0.15476 0.13547,0.29352 0.20754,0.10513 0.22642,0.0632 0.12094,0.22094 0.18434,0.18411 0.0315,0.1054 0.20755,0.3202 -0.0611,0.48029 0.0789,0.2631 0.005,0.20546 0.22641,0.063 0.13321,0.12808 -0.13792,0.14276 0.18868,0.12194 -0.0423,0.2148 0.17698,0.26683 0.10944,0.0379 0.11377,0.29352 -0.0253,0.24015 0.26415,0.26683 -0.0253,0.29351 0.004,0.3202 0.0715,0.29352 0.002,0.40025 0.14415,0.22921 0.13472,0.34688 0.24528,0.0547 0.32076,0.26683 0.18528,0.29351 0.24528,-0.0253 0.24528,0.18544 0.08,0.202 -0.008,0.16837 0.13057,0.14329 0.33962,0.23161 0.17378,0.32019 10.17924,0.1014 12.51887,0.21347 14.57924,0.222 8.11698,-0.22761 0.0679,7.84487 -0.26415,2.48153 -0.67925,1.54763 1.39623,1.44089 2.03962,0.9606 2.9,3.26869 0.4151,6.21986 1.81132,0 0.32075,2.32144 3.53585,0.0454 4.35094,-0.37357 3.12642,2.95117 2.31132,1.09401 1.26415,-0.72045 1.32075,1.22743 4.30567,-4.81365 7.52264,5.40335 -1.71698,5.22457 2.6283,1.41421 1.16981,0 1.13207,-2.37481 1.39623,-0.82718 1.77359,2.9992 2.22075,1.36084 2.40189,0.90723 0.81132,0.72045 1.5849,4.77362 -0.13585,5.5928 3.1717,3.65827 1.99434,0.93391 3.11887,0.0363 0.24528,-3.12994 -0.35849,-0.93391 -1.09434,-2.10798 -0.24528,-1.46757 -2.32076,-2.10798 0.0362,-1.09401 1.18868,-0.10913 1.5283,0.69376 0.98113,1.52095 0.10868,1.97455 1.4151,2.18803 0.39622,3.89308 1.60378,0.77381 0.94339,0 4.96793,-3.85839 5.07547,0.25482 1.01887,1.22743 3.00943,5.64083 -0.71698,2.40149 9.20943,4.29599 5.65661,-8.88284 9.17358,0.4803 0.0364,4.58685 8.04905,0.72044 1.22642,0.72045 0.4717,-0.14569 0.10868,2.695 11.74717,-0.37356 12.69056,-0.37357 -1.37736,-23.18237 -0.54717,-32.73869 -21.78735,0.21266 -0.37736,-5.58212 2.23207,-3.45548 -4.83585,-6.53738 -2.49811,0.26549 -2.6566,0.9606 -5.31321,-6.95898 0.96226,-1.33416 -7.38679,-10.93478 -1.54717,-0.8005 -4.67736,0.37357 1.05661,-3.34341 1.1132,-0.42693 0,-2.08129 5.42076,-2.26807 -1.81132,-0.69377 -1.75472,-4.08253 -4.19811,1.54763 -0.053,-3.12727 4.3566,-1.92119 1.75472,0 2.17924,-1.49426 0.64151,-9.21905 1.22642,-0.90723 11.9566,2.16134 4.09246,-1.38753 2.6566,0 1.49057,-1.06732 1.16981,-0.26497 1.0566,-1.44089 2.6566,-0.10593 0.26415,-0.8005 -0.15943,-1.22743 0.4717,-2.16134 1.49056,-2.00124 0,-3.28203 5.57925,-0.4803 -2.28491,-6.24387 1.49057,-2.90847 -1.16981,-3.54353 -0.053,-6.5027 -3.66604,-0.3202 -0.26415,2.42818 -10.6283,0.26443 -0.73585,-6.02507 -10.57547,0.64039 -3.71887,-4.06918 -6.32453,0.56034 -3.8849,-5.57412 -8.49245,0.34688 -0.32076,11.22296 -5.48113,0.53366 -0.097,11.34037 -11.5434,0.58703 -0.43396,3.33273 -7.61509,1.12069 -0.24529,4.78164 -15.7132,0.72044 0.43396,8.84282 -13.8717,3.09525 -4.60755,-1.97456 -1.30188,-2.08129 -2.95849,2.75638 -2.42453,-0.9606 -7.3717,-4.64021 -2.03774,-0.37356 -1.93962,1.92119 -2.95849,-0.0483 -1.01887,4.64021 0.5283,4.40006 1.01887,0.90723 3.39434,0.29352 -0.28302,6.67613 -1.41509,-1.25411 -1.4151,-0.42693 0.0972,2.50822 -4.94717,0.14516 0.49057,6.63078 1.98868,0 0.24528,10.2677 -11.18113,0.56034 -0.33962,0.42693 -2.9434,-2.0546 -1.93962,-2.37481 -1.89057,-0.34688 -12.0283,0.19372 0,-1.94787 -14.30754,0.0483 0.18867,8.09035 -3.94905,0.23695" id="path9170"></path>'
    ],
    'город-курорт Пятигорск' => [
        'stav_pyati',
        '<path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 495.70557,664.13402 5.83019,-0.20653 -0.37736,0.53367 2.71133,2.13465 1.84905,-2.78306 1.84906,-0.26683 2.5717,0.74713 2.23585,2.78306 1.84905,1.86782 0.9434,0 0.008,3.80503 -1.64151,0.58703 0.26415,1.30748 3.0434,-0.4803 1.45283,3.67161 -1.69811,0.88055 -0.98114,1.5743 -4.12641,4.09321 -2.63019,0.42693 -0.62264,-3.82904 -11.60566,-0.77381 -0.10321,-2.10798 -0.86792,-1.20074 -3.35283,0 -4.69434,-2.45486 0.86792,-0.53366 0.77359,-2.16134 -1.84906,-0.0523 -0.50943,-2.21471 1.54717,-0.64039 1.03773,-1.25411 2.01132,-0.15717 0.77359,-1.84114 1.24528,-0.93391 2.23208,-0.53366" id="path8982"></path>'
    ],
    'город-курорт Ессентуки' => [
        'stav_essent',
        '     <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 459.59671,665.57571 3.80188,0 3.29812,0.29352 2.96415,-0.40025 6.87736,0.11367 4.75283,-0.45361 2.73962,1.65436 0.28302,2.61495 0.67924,4.26398 -4.47358,0.45361 -3.74717,3.18331 -3.85849,-2.67099 -3.01887,-0.0568 -2.6283,2.50822 -4.80943,1.70773 0.83018,2.32144 0.16774,1.76109 -1.90189,0.74713 -2.0132,0 -0.83019,-1.92119 -1.79246,1.20074 -1.84905,-1.92119 1.1132,-1.65436 -1.50943,-0.1705 -1.39623,0.40025 -1.28301,-0.34689 -0.39623,-2.90046 2.51698,-0.40025 2.90755,0.0568 1.67924,-0.29352 0.45283,-3.80769 -1.79245,-1.60099 2.23774,-4.65889" id="path9214"></path>
                   '
    ],
    'город-курорт Кисловодск' => [
        'stav_kislovodsk',
        '     <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 445.94935,695.36485 0.75472,0.82718 -2.44151,2.10797 0,1.28079 1.69811,-0.58703 1.0566,-0.77381 2.62831,11.47378 5.56981,3.1246 0,1.92119 -2.56604,1.33416 3.19245,3.89041 -5.06981,0.50699 -3.75472,4.97908 -5.44528,-3.31939 -4.19245,-0.25536 -1.05661,0.77382 -0.62264,1.65435 -3.00377,0.3202 0.0624,-3.25535 -2.56604,-1.60099 1.13208,-3.70096 -3.1283,-2.93515 2.44151,-0.69377 2.06604,-2.56159 1.75471,-3.18864 1.62264,-1.65436 0.67925,-4.26931 -1.37736,-0.77381 0.67925,-1.20075 1.56603,-0.77381 1.37736,-1.2808 4.19246,-0.50698 2.75283,-0.88054" id="path9212"></path>
                   '
    ],
    'город Невинномысск' => [
        'stav_nevin',
        '     <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 289.52822,497.1313 1.26415,1.44089 2.05472,1.06733 0.84906,1.01396 -0.20755,1.06733 0.24528,0.90723 0.86793,0.37356 1.88679,-0.23721 1.24528,0.29352 0.0338,1.52094 -0.39623,0.85386 2.59623,2.78039 -0.37736,2.08129 0.0674,1.17406 1.54717,1.04065 0.10113,2.45485 3.26981,1.46758 -1.24528,5.76891 2.42641,1.01396 -1.18868,2.95383 -2.0566,-0.45361 0.60377,2.75104 -4.01132,0.10166 -2.79811,1.12069 -3.50566,-0.50698 -0.67925,-1.25411 -2.56226,-0.0339 -0.84906,-1.38752 0.77359,-0.74713 -2.02265,-2.29476 0.0675,-2.34812 -0.4717,-1.36084 0.98114,-0.98728 -1.4151,-2.58827 2.36038,-3.12194 0.0676,-1.46758 -3.26982,-2.5349 -0.6415,-1.33416 -1.71699,-2.61495 0.73585,-2.24139 2.05661,-1.9212 3.2849,-3.78901" id="path9178"></path>
                   '
    ],
    'Минераловодский городской округ' => [
        'stav_miner',
        '      <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" fill="#e6735c" stroke="#f2f2f2" d="m 429.02841,605.1588 0.32075,-7.3619 16.62076,-0.26683 0.10622,-15.78579 0.84906,-1.60099 2.49623,-1.60099 -0.15925,-3.43413 2.01698,-0.26683 0.0532,-0.85387 -0.96227,-0.42693 -0.43396,-8.25845 1.96415,-0.21427 -0.10603,-8.94954 2.65471,-0.107 -0.32075,-6.48135 -1.81132,-0.3202 -0.52831,-16.80776 1.8868,0.98728 3.19622,2.10798 4.16415,1.38752 3.32265,0.37357 1.97735,1.22743 8.3717,2.75637 0.92453,-2.92448 1.67925,0.88055 0.54717,-1.1207 13.56792,5.72355 -1.41509,5.09116 13.06603,2.70567 -0.94339,3.55954 4.2,-1.41421 3.93018,0.0544 0.3585,-0.40025 0.50943,0.34688 3.07924,-0.23935 3.99623,-1.06733 0.88679,-3.28737 5.83774,1.70773 0.5849,14.16878 6.78302,0.53367 8.46604,-0.3202 -0.88679,26.37902 -14.38113,-0.11981 -0.35849,19.34265 2.01132,0.23962 1.60377,-0.0598 1.24528,0.4803 4.67547,-0.23988 0.0591,3.29537 -3.13585,0.29352 -0.41509,3.41812 3.19622,-0.06 0,1.44089 3.72831,-0.0598 0.30188,1.92119 -1,0.53367 -1.89434,2.58827 -0.41509,4.01849 0.11849,24.13496 -1.95283,0.96059 -2.19057,0.18012 -1.89434,5.64883 -1.30188,-1.97456 -0.24529,-1.20074 -2.95849,-3.0659 -2.54528,-1.57431 -2.24906,1.57431 -4.61509,-1.73441 -1.41509,1.49426 -2.54529,-0.85386 0.35849,-1.49426 -1.95283,-2.64164 -1.66037,-1.73441 -1.24529,-1.92119 -1.18868,-3.18331 -1.69811,-0.53366 -1.94151,-1.73441 -0.0474,-3.79435 -1.28302,-0.82718 -2.65094,-0.34688 -2.17736,1.68104 -5.30188,-1.38753 -0.52831,-2.687 0,-2.64163 -3.17169,-0.42693 -0.43397,-2.92715 -1.13207,-0.34688 -2.4151,-0.66708 -0.47169,1.20074 0.0947,4.84567 -3.59811,0.72045 -2.84151,0.14409 -1.09434,1.81445 -2.84151,1.30748 -2.03585,-1.25411 -6.10754,-5.42469 -4.11887,11.66589 -14.48679,-5.37933 0.24528,-4.32001 -1.32076,-0.29352 0.28302,-5.7102 1.03774,-0.0958 -0.0947,-3.26335 -16.38113,-0.29352 -0.0991,-15.17207" id="path9190"></path>
                  '
    ],
    'Апанасенковский муниципальный округ' => [
        'stav_apana',
        '     <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 439.55161,126.84337 1.18868,2.71635 -6.10377,3.15395 2.17924,2.94049 0.22642,1.86782 28.38906,46.76313 14.65849,-7.07906 1.5849,-5.84362 3.8151,3.80769 8.17358,-5.73689 2.45283,1.06733 0.1634,0.69376 1.64151,1.81446 0.16339,2.29476 0.49057,1.38752 1.03773,0.58704 1.35849,1.76109 0.49057,1.86782 8.2283,16.04728 -7.19245,4.77896 -0.0543,5.1045 1.84906,-0.0536 1.69811,0.53366 1.79245,1.76109 3.43208,0 1.84905,-1.65435 1.30189,0 -0.32075,0.58703 0.32075,0.90723 1.64151,-0.3202 1.09434,-1.601 1.4717,-0.26683 1.03773,2.00124 1.64151,1.49426 2.99623,0 1.03774,1.17406 2.39811,0.8005 2.23396,-1.01396 2.12453,-2.79373 -0.10906,-1.1207 0.49057,-1.17406 2.39811,-2.00124 3.05095,-0.37356 -0.10906,-1.86783 1.5849,0.0539 0.71699,-1.01396 1.90754,0.37356 3.05095,-0.85386 1.79245,-1.70772 2.23396,1.12069 2.12453,-2.21471 2.94151,0.10727 1.64151,-2.32144 0.86792,-0.10726 0.32076,1.28079 1.84905,0 0.37736,34.62013 -7.46415,0.64039 -1.09434,5.43804 2.72453,0.69376 2.12453,1.89451 6.10188,1.2808 0.10906,23.98553 -0.24528,8.48259 27.56396,0.13288 0.26415,-19.57746 2.59623,0.22147 1.30188,0.48029 0.0447,-3.9838 14.58679,-0.22147 0.67925,3.54086 38.79528,0.85386 0.26415,-24.54855 33.60453,0.61372 0.26415,-9.05895 2.23774,0.66708 1.07547,0.74713 1.03773,2.7377 1.66038,2.08129 0.9434,0.40024 3.13207,0.0443 1.07547,1.22743 1.03774,0.0443 3.13207,-2.48154 3.4,-3.9331 0.84906,-1.81446 3.49245,0.1102 -1.28302,-0.61371 -0.45283,-0.56035 -0.43396,-2.7457 -0.49056,-0.50698 -0.45283,-0.98728 -0.58491,-1.57431 -0.20755,-1.04065 -0.24528,-0.93391 0,-2.05461 -0.43396,-2.02792 -0.45283,-0.98728 0.0206,-0.26683 0.04,-0.53366 0.30189,-0.37357 0.15189,-0.69376 -0.0304,-0.77382 -0.39623,-0.37356 -1.43396,-0.61371 -1.81132,-0.17184 -0.5849,-0.4803 -0.39623,-1.1207 -0.0608,-0.64039 -0.49056,-0.37357 -0.58491,0.17157 -0.0909,0.56035 0,0.61372 -0.18208,0.29351 -0.33962,-0.34688 -0.88679,-1.14738 -0.58491,-0.77381 -0.50943,-0.85386 -0.9434,-0.90723 -0.39622,-1.14738 -0.50944,-1.20075 -0.45283,-1.92119 -0.39622,-1.33416 0.12151,-0.85386 0.39622,-1.49426 -0.64151,-0.69376 -0.54717,-0.77382 -0.20754,-1.06732 -0.39623,-0.77382 -1.73585,-2.40149 -2.85283,-2.61495 -1.64151,-1.12069 -0.96226,-0.4803 -0.96227,-0.93391 -0.45283,-0.043 -1.28302,0.34688 -0.75471,-0.37357 -0.9434,-0.29351 -1.30189,-0.34688 -1.30188,-0.21454 -1.09434,-0.29351 -1.33963,-0.42693 -0.64151,-0.29352 -1.09433,-0.82718 -1.09434,-0.6404 0.75471,-0.77381 0.84906,-0.61371 -1.9e-4,-0.6404 -0.45283,-1.62767 -0.35849,-2.26808 -0.45283,-0.82718 -0.75472,-0.77381 -0.0911,-1.12069 -0.33962,-0.6404 -0.0608,-1.92119 -0.54717,-0.42693 -1.28302,-0.0427 -0.33962,-0.0859 -0.66038,-0.34688 -0.43396,0.25723 -0.39622,0.17184 -0.39623,0.0856 -0.35849,0.29352 -0.30189,0.29351 -0.54717,-0.42693 -0.73585,-0.17157 -0.39622,-0.56035 -0.35849,-0.17157 -0.84906,0 -0.60377,0.12861 -0.24529,-0.0856 -0.60377,-0.61372 -1.24528,-0.69376 -1.75472,-0.56035 -1.35849,-0.37356 -0.18208,0.21453 -1.0566,-0.34688 -1.39623,0.0859 -0.84905,-0.043 -0.43397,0 -0.0909,-0.17157 -0.24528,-0.2148 -0.30189,0.25749 -0.18207,0.37356 -0.75472,0 -0.66038,-0.69376 -0.5849,0.4803 -0.24529,0.29351 -0.35849,-0.50698 -0.94339,-0.043 -0.84906,-0.50698 -0.96226,-0.21453 -0.73585,-0.77381 -0.43397,0.17157 -0.60377,-0.69377 -0.49057,-0.77381 -0.90566,-0.82718 -0.79245,-0.4803 -0.45283,0.34689 -0.73585,0.29351 -0.94339,-0.4803 -1.05661,-0.85386 -1.33962,-0.69376 -0.50943,0 -0.60378,0.0859 -0.81132,-0.2575 -1,0.34689 -0.81132,-0.34689 -1.03773,-0.82717 -1.05661,0 -1.09434,0.043 -1.20755,0.043 -1.1132,0.37356 -0.8868,0 -0.54716,0.42693 -0.60378,-0.34688 -0.64151,-0.21453 -0.84905,0.043 -0.66038,-0.56035 -0.33962,0.12888 -0.45283,0.25749 -0.45283,0 -0.45284,-0.29351 -0.45283,0 -0.73584,0.12861 -0.75472,0.29352 -0.64151,0.21453 -1.0566,0.043 -0.30189,-0.0857 -0.35849,-0.0859 0,0.25749 0,0.17157 -0.69811,-0.37356 -0.60378,0 0.18208,-0.82718 -0.45283,0.37356 -0.33963,0.043 0.0304,-0.77381 0.12132,-0.69376 -0.64151,0.29351 -0.50943,0.043 -0.18208,0.56035 -0.39622,0.043 -0.69812,-0.4803 -0.30188,-0.34688 0.33962,-0.50698 0.26415,-0.17158 -0.39623,-0.34688 -0.64151,0.17158 -0.30188,0.72044 -0.12151,0.56035 -0.39623,0.0856 -0.0607,0.72045 -1.43396,0.21453 0,0.29352 -0.0608,0.4803 -0.54717,0 -1,-2.10798 -0.81132,-0.56035 -0.58491,0.043 -0.30188,0.50699 0.0304,0.85386 -0.18207,0.37356 -0.88679,0.12862 -1.18868,0.0859 -1.45283,0.61371 -2.15472,-0.42693 -8.83019,-2.26807 -2.4283,-0.2575 -5.52264,0.34688 -4.03585,-2.34812 -3.61132,-2.40149 -4.61321,-2.7457 -4.91509,-2.56159 -1.13208,-0.56034 -2.45849,-1.14738 -2.7,-4.0345 -3.4283,-5.87831 -3.18679,-5.23525 -2.18491,-1.92119 -3.21698,-1.84114 -3.58113,-1.46758 -1,-0.25749 -7.37359,-0.4803 -1.35849,-0.37356 -1.18868,-0.72045 -2.30566,-0.29351 -2.85283,-1.84114 -2.48867,-1.14738 -2.9434,-0.82718 -6.34151,-2.10798 -8.52641,-3.1326 -6.91887,-3.26069 -4.36981,-1.36085 -1.58491,-0.12888 -4.36981,-3.51951 -3.1566,-3.732981 -3.58114,-6.694817 -2.09434,-3.86106 -0.94339,-0.121408 -2.45661,0.07872 -6.37169,7.938254 -0.43397,-0.506981 -0.33962,0.04296 0.1517,0.640397 -0.0302,0.373565 -0.24528,0 -0.60378,-0.613714 -0.26415,-0.128613 -0.18207,0.773813 -0.091,0.373565 -0.0911,0.04296 -0.20754,-0.373565 -0.58491,0.128613 -0.49057,0.720447 -0.35849,0.214533 -0.35849,0.506981 -0.26415,0.04296 -0.35849,-0.560348 -0.5849,-0.293515 -0.39623,0.480298 -0.1517,0.426931 -0.12132,0.720447 -0.20755,0.346881 -0.1517,0.560348 -1,0.426939 -0.12132,0.043 1.24529,0.42693 0.18207,0.0859 0.96227,0.85386 0.73585,0.77381 0,0.34689 -0.39623,0.25749 0.26415,0.61371 0.43396,0.2575 0.64151,-0.12862 0.12132,0.12862 -0.43396,0.42693 -1.64151,1.41421 -18.84339,18.62488 -2.7,2.24138 -4.91887,0.25189" id="path9200"></path>
                   '
    ],
    'Советский городской округ' => [
        'stav_sov',
        '     <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" fill="#e6735c" stroke="#f2f2f2" d="m 614.17236,546.80743 4.09057,-8.74943 -3.86981,-2.00124 6.8,-16.31411 13.54339,5.95569 0.71699,-1.49426 15.12641,6.67614 29.79641,15.01464 -0.94339,1.38753 -0.18868,1.57431 7.62075,-0.0496 0.73585,-2.82575 3.19623,-1.8945 2.16415,2.02792 0.9434,-1.20075 9.83396,4.70959 11.94717,9.17636 12.97736,11.35103 -0.0876,4.76562 2.62264,5.73956 -4.28302,2.82575 6.81698,11.75395 6.55472,-1.76109 4.54528,15.12138 -3.05849,1.33416 -4.54528,-1.14738 -1.22642,0.61371 3.14529,2.40149 -2.44717,3.62892 -3.58302,1.41421 -5.2434,-2.21471 -7.4283,0.8005 1.39623,2.83375 -1.39623,3.2767 1.54717,21.78684 -28.58698,-0.74713 0.12736,1.09401 -2.2717,1.65436 -2.58113,3.74365 0.0545,1.17407 0.67924,0.96059 -0.0181,1.76109 -1.50944,2.10798 -0.20754,1.54762 1.22641,2.82309 0.0181,0.93391 -2.01699,4.09854 -0.32075,1.52094 1.84906,3.43413 -5.48868,1.38753 -18.71698,-15.04666 2.32641,-3.89308 -4.72453,-4.37071 1.16981,-2.24139 -6.01509,-3.18865 -1.89057,2.48154 -5.17924,-3.35674 -4.3434,6.86025 -2.38113,-1.52094 -10.90755,-8.31716 -2.71509,3.42879 -4.80943,-3.2847 -1.71699,1.12069 -13.99999,-11.29767 0.47169,-2.94315 -1.09434,-1.68105 -1.81132,-0.58703 0.0953,-2.2147 14.66603,-0.048 3.47548,-1.1207 3.09433,-1.54762 1.81133,-1.25411 1.09433,-1.38753 0.84906,-1.97456 -1.66038,1.01396 -0.84905,-0.29351 -1.09434,-1.84114 -0.84906,-0.34688 -0.75472,0.48029 -0.33962,1.20075 -1.66038,-0.72045 0.18868,-19.22792 -5.8566,0.0483 -0.5283,-12.27694 1.37736,0.72044 1.15094,-0.24068 1.81132,-4.47477 -6.52453,-3.60757 3.47547,-8.80013 -11.66603,-5.28861 6.2566,-12.97604" id="path9194"></path>
                   '
    ],
    'Труновский муниципальный район' => [
        'stav_turn',
        '     <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 254.18294,242.46304 0.11679,19.07315 1.81132,0.20626 2.43208,0.4803 2.0849,1.38753 0.98114,1.86782 1.16981,0.88055 1.1132,0 0.39623,-0.26417 2.93396,0.044 3.37925,-1.44089 2.31132,-2.45486 1.20755,-2.18802 1.83019,-0.4803 -0.0445,2.9485 -1.33963,1.06733 -2.3566,4.49078 -1.11321,0.0881 -0.84905,1.01397 0.13339,1.14737 -0.5849,1.06733 -1.37736,0.4803 -2.40189,3.12727 -1.60377,0.40025 -0.26415,5.41936 0.92453,0 -0.0889,2.95383 2.97924,1.68104 0.58491,0.40025 1.86792,1.84114 6.80378,8.15706 0.0445,1.68104 -1.77358,3.1753 0.0443,3.61824 1.07547,3.75166 -0.79245,1.84114 -0.39623,3.22334 4.09057,1.36084 2.57924,4.6829 31.79132,0.66708 0.30189,5.03779 10.00377,0.61372 8.49246,-0.34689 0.39622,-9.85144 18.49623,-0.13235 16.09622,0.8005 -0.13339,-9.40583 10.76037,-0.66708 -1.47169,-27.64807 -0.18868,-9.25641 -1.49057,-0.85386 0,-1.68104 -1.81132,-2.32144 -0.20755,-2.42817 -2.1283,-1.46758 -2.55472,-2.84443 -7.76981,0.53367 -2.02264,1.04064 -3.3,-1.89451 -6.49245,-0.21053 0.96226,-8.52795 2.23397,0 0,-2.5349 -9.89812,-0.10514 -1.37736,-1.46757 -0.96226,-4.10121 -6.27924,0 -1.49057,-1.68104 -3.08679,0 -0.10642,-10.72398 9.04528,-0.3202 0.52831,-3.67695 1.69811,-0.21026 -0.64151,-4.9364 -1.91509,-1.14737 1.0566,-5.25126 5.00189,-0.93391 0,-7.55669 -14.79246,0 -0.43396,2.7297 -6.17358,-0.10487 -0.84906,-2.2147 -10.10943,-0.42694 -0.20755,-4.93105 -6.99434,0.0854 -0.18868,18.41409 -1.03773,0.82717 -1.71699,-0.0483 -2.45094,-2.32144 -1.13207,-0.19345 -0.83019,0.96059 -2.30378,-0.6404 -0.79245,1.1207 -2.00943,0.19345 -0.0489,1.54763 -2.40189,0.0483 -0.33962,1.601 -1.86793,0 -0.43396,2.13465 -4.06792,0.42694 -0.24529,8.85615 -28.18094,0.77381 0.14717,9.97686" id="path9188"></path>
                   '
    ],
    'Туркменский муниципальный район' => [
        'stav_turk',
        '    <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 486.18897,277.01806 40.21321,-1.1207 0.32075,-10.19832 16.45661,-0.3202 0.0543,-1.57431 7.24716,-0.0539 0.22642,1.94788 10.95283,-0.4803 -0.24528,8.48259 27.56396,0.13288 0.26415,-19.57747 2.59623,0.22147 1.30188,0.4803 0.0447,-3.9838 14.58679,-0.22147 0.67925,3.54086 38.79528,0.85386 0.26415,-24.54855 33.60453,0.61371 0.26415,-9.05894 2.23773,0.66708 1.07548,0.74713 1.03773,2.73769 1.66038,2.08129 0.94339,0.40025 3.13208,0.0443 1.07547,1.22742 1.03774,0.0443 3.13207,-2.48154 3.4,-3.93311 0.84906,-1.81445 3.49245,0.1102 0.79245,-0.2575 0.43397,0.98728 0.26415,6.73751 1.50943,3.69029 1.33962,2.61496 0.75472,1.12069 1.43396,1.62768 0.8868,1.14737 1.49056,2.91648 1.75472,2.32144 0.0304,0.29351 -0.0608,0.69377 1.84906,2.34812 0.88679,0.4803 0.43396,0.50698 1.94151,1.92119 0.43396,0.37356 0.0608,0.61372 1.15094,1.25411 0.60378,-0.043 0.73585,0.42693 0.73584,0.77381 0.90566,1.28079 1.28302,0.90723 0.9434,1.14738 2.79245,1.36085 4.73396,1.28079 0.18208,0.37356 0.64151,1.84115 0,0.37356 -0.18189,0.69376 -2.19245,0.37357 -4.64906,-2.16134 0.60378,2.89246 1.26415,3.22333 -0.39623,0.8005 -1.39622,0.26309 -2.4585,-1.12069 -1.79245,0.13155 -0.92453,-0.98728 -1.32075,0.3202 -1.79245,-1.25411 -2.65661,-0.93392 -6.64151,0.45362 -2.6566,-1.97456 -2.72264,-0.98728 -2.59057,-0.0659 -1.39622,-0.66708 -1.58491,0.13155 -5.24717,-2.76171 -2.05849,0 -1.26415,-0.90723 -7.83774,0.40025 -3.52075,1.17406 -6.97359,1.12069 -0.47169,49.58221 -5.1151,0.13208 0.13302,11.21762 -12.8849,0.53366 -0.33963,2.32144 -1.5283,0 -0.73585,6.13981 -3.65283,4.69091 1.39623,1.44089 -1.79245,1.57431 -2.65661,-1.92119 -2.6566,3.23667 -13.21698,-10.63593 -3.32076,2.8391 -5.18113,-3.16997 -1.13207,1.33416 0.5283,1.33416 -6.4434,7.86088 1.32076,1.52094 -11.15849,12.96003 -11.82265,-10.11827 -1.18867,0.66708 -4.58302,0 -0.60378,-8.9202 -17.93396,-0.40024 0.0664,9.8461 -30.7483,-0.26683 -2.27736,0 -0.10849,-28.41308 -17.2434,0.21533 -0.54717,16.33012 -2.22264,0.9606 -0.20755,2.3748 2.60189,0.1617 0,1.41421 -18.63208,0.0213 0,-22.63803 -5.36792,-0.58703 -0.22642,-8.82948 -6.12641,-0.53366 -0.66038,-28.57131" id="path9180"></path>
                    '
    ],
    'Степновский муниципальный район' => [
        'stav_step',
        '      <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 721.99727,643.33046 -1.54717,-21.78684 1.39622,-3.2767 -1.39622,-2.83376 7.4283,-0.80049 5.24339,2.2147 3.58302,-1.41421 2.44717,-3.62891 -3.14528,-2.40149 1.22642,-0.61371 4.54528,1.14737 3.05849,-1.33416 -4.54528,-15.12137 -6.55472,1.76109 -6.81698,-11.75395 4.28302,-2.82575 -2.62264,-5.73956 0.0875,-4.76562 6.03019,-7.23649 -2.09811,-1.68104 6.90377,-7.93558 5.76793,6.17182 10.57547,-0.2647 0.79245,-1.84114 2.79623,0.69377 6.03018,-4.58418 0.3585,-1.49426 6.99245,-0.17637 4.10754,-3.4368 1.39623,2.29475 2.44717,0.0883 4.54528,8.37585 5.33208,-1.84114 -2.62264,19.05982 3.93207,6.27055 5.15661,-3.53286 0.5283,-2.10797 3.75849,0.61372 -0.43396,-2.29476 6.73019,0.17638 0.26415,2.82575 24.29603,4.50412 0.52831,2.91648 18.87754,1.49426 0.35849,12.90666 -7.51698,1.94788 0,5.57412 7.69057,2.21471 3.40754,-2.29476 4.33019,2.16134 -1.95849,24.02289 -5.70943,-0.96059 0.30189,23.66 -25.55604,0 -0.64151,-1.4409 -0.79245,-3.80769 -16.23585,0.1705 -0.62264,5.8543 -16.01132,-1.44089 -2.15472,-0.4803 0.0558,-11.59119 -24.15642,-0.34688 0.084,10.14229 -2.43585,0 -2.23963,0.25562 -2.60377,1.49426 1.81132,14.87056 -17.13019,0.2276 0.16793,-2.45485 -2.7434,-0.0496 0.35849,-7.39392 -3.63962,-1.68104 -4.02453,-1.09401 -8.46792,-0.17771 0.24528,-6.46534 0.26415,-4.76563 -3.86792,-0.25215 -0.20755,-2.70034" id="path9196"></path>
                  '
    ],
    'Петровский городской округ' => [
        'stav_petr',
        '    <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 376.62558,268.92584 1.0566,-1.68104 2.66038,-0.3202 8.08868,-0.2108 0.5283,3.89842 8.83396,0.2108 0.5283,-7.27118 4.36415,0 0,-1.25411 8.40755,0 -0.20755,2.84443 2.66038,0.74713 0.5283,-1.68104 1.60378,-1.36085 8.83396,-0.21079 0.10641,-5.79293 3.3,0 0,-1.36084 16.28302,0.96059 0.20755,3.1593 1.49057,1.36084 14.68679,3.47682 -2.02264,13.06944 2.1283,0.64039 1.49056,-1.06732 -0.96226,-1.36085 1.49057,-2.00124 0.10641,-1.89451 0.84906,-0.42693 1.4717,-0.42693 0.71698,-2.5349 1.41509,-2.26808 -0.22641,-1.57431 1.64151,-3.39677 17.3283,11.70593 0.16339,4.15724 0.66038,28.57131 6.12642,0.53366 0.22641,8.82948 5.36792,0.58703 0,22.63803 18.63208,-0.0214 0,-1.41421 -2.60189,-0.1617 0.20755,-2.3748 2.22264,-0.9606 0.54717,-16.33012 17.2434,-0.21533 0.10849,28.41308 2.27736,0 -0.49057,12.36233 -10.73585,0.16196 0.22642,3.89041 -3.85095,0.10807 0.16264,2.05461 -1.89811,0.74713 0.16264,17.13862 -2.27736,0.0542 -0.26415,19.48674 2.43963,0 0.16264,7.1511 3.30754,0.3202 -0.0543,10.13695 -0.26416,2.37481 -25.59396,0.10833 -0.1083,4.9364 -5.36792,0 -0.60378,1.78777 -10.79056,0 -0.26415,2.37481 -14.81321,-0.29352 -0.37736,-6.32659 -3.66604,-0.3202 -0.4717,-7.28184 5.95095,-0.0531 -0.15944,-3.18865 -5.47358,0 0.15943,-4.77896 -4.25094,-1.70772 -4.62264,1.49426 -8.76793,-2.34813 -0.5283,-1.06732 -14.29434,-1.1207 -0.053,-10.50785 9.24717,-0.42693 0.15944,-13.84058 -9.72453,0.15903 -0.69811,-4.34669 -7.43963,0.15877 -0.43396,-2.26808 -13.6566,-0.0531 0.79245,-35.82594 -7.65283,0.15877 -0.26415,-15.63636 -5.47358,-5.85963 -0.43397,-1.62768 1.81132,-6.01439 0.20755,-10.33708 -4.99434,2.05461 -1.0566,-26.1282 -9.24717,-0.26309 -1.05661,-1.68105 -2.08867,-1.04064 -1.09434,-1.1207" id="path9220"></path>
                    '
    ],
    'город Лермонтов' => [
        'stav_lermon',
        '    <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 494.60105,655.29467 -0.67925,1.81446 -0.39623,-0.93391 -0.6415,-0.93391 -1.05661,-1.78778 0.28302,-1.62767 -0.84906,-0.69377 -0.90566,-0.42693 -0.86792,0.111 -1.79245,0.23455 0,1.12069 -4.45095,-0.29351 -0.98113,2.05461 -4.33396,-0.82718 -0.22642,1.17406 3.8717,3.69829 2.31132,-0.23481 0.11566,1.12069 2.10378,0.29352 1.75471,-0.8005 1.11321,0 1.0566,1.2808 -0.69811,1.7344 1.66038,0.23508 3.60566,0.18785 0.88679,0.8005 0.22642,1.54763 5.83018,-0.20653 0.0645,-0.88055 1.56604,-0.77381 0.28302,-2.00124 -1.22642,-1.46758 -0.50943,-1.86782 -1.45283,-0.29352 0.73585,-1.30748 -0.0558,-1.30747 -1,-0.74713 -2.12453,-0.50698 -1.79245,0.90723 -1.39623,1.60099" id="path9218"></path>
                    '
    ],
    'город-курорт Железноводск' => [
        'stav_jelezn',
        '    <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 494.60105,655.29467 1.39622,-1.60099 1.79246,-0.90723 2.12452,0.50698 1,0.74713 0.0559,1.30748 -0.73585,1.30748 1.45283,0.29351 0.50944,1.86783 1.22641,1.46757 -0.28302,2.00124 -1.56603,0.77382 -0.0645,0.88054 -0.37736,0.53367 2.71132,2.13465 1.84906,-2.78305 1.84905,-0.26684 2.5717,0.74713 2.23585,2.78306 1.84906,1.86783 0.94339,0 4.58491,-3.12461 4.24906,-2.32144 5.17169,-3.89574 -1.30188,-1.97456 -0.24529,-1.20075 -2.95849,-3.0659 -2.54528,-1.57431 -2.24906,1.57431 -4.61509,-1.73441 -1.4151,1.49426 -2.54528,-0.85386 0.35849,-1.49426 -1.95283,-2.64164 -1.66037,-1.7344 -1.24529,-1.92119 -1.18868,-3.18331 -1.69811,-0.53367 -1.94151,-1.7344 -2.35283,1.25411 -0.77358,2.95116 -1.67925,-0.45362 -3.07547,-1.92119 -3.1151,0.93392 -0.77358,0.80049 -0.79245,6.89761 4.24717,1.97456 -0.83019,1.14738 0.62264,1.52094 1.16981,1.20074" id="path9216"></path>
                    '
    ],
    'город Георгиевск' => [
        'stav_georgivsk',
        '     <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 573.82425,636.78293 1.43396,3.10059 -0.004,0.85386 1.73585,-0.0467 0.0826,0.66708 1.94717,0.0187 0.0368,0.80049 0.13773,0.14889 -2.44339,3.9251 0.22641,0.16758 -0.77358,1.38752 -0.24529,-0.0373 -1.03773,2.00124 1.69811,1.62767 0.35849,-0.37356 3.38113,2.29475 0.35849,0.10247 0.22642,-0.25189 0.24528,-0.0744 -0.32075,-0.58703 0.14698,-0.56035 0.39622,-0.23294 1.26415,0.61371 1.22642,-1.12069 -0.49057,-0.45362 -0.009,-0.45361 -0.28302,-0.58703 0.96226,-1.09401 0.50944,-0.93392 1.28302,-0.82718 0.62264,-1.14737 0.83019,-1.30748 0.50943,-0.6404 -0.10094,-0.40025 0.54717,-0.028 0.18377,-0.18625 -0.26415,-0.25189 0.26415,-0.74713 0.35849,-0.19559 0.4151,0.15823 0.0736,-0.4803 -0.33962,-0.34688 0.0459,-0.25162 -1.67925,0.0619 -0.0413,-0.21374 -2.06226,-0.66708 -0.32076,-0.48029 -1.64151,-1.01397 -0.24528,-0.34688 -0.30189,-0.0819 -0.0221,0.20867 -1.39623,-0.8005 -0.14698,0.21613 -1.96226,-1.04064 -0.67925,-2.58827 -2.98302,-0.9606 -0.20755,-0.0371 -0.69811,0.61372 -0.71698,2.0546 -0.0651,0.85387" id="path9210"></path>
                   '
    ],
    'Новоселицкий муниципальный район' => [
        'stav_novos',
        '    <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 541.70029,428.96024 20.35434,17.43748 13.00377,-16.13534 40.87849,33.9325 10.23396,-12.52776 4.19812,3.37809 1.37736,-0.93391 12.76981,9.53391 4.03585,-3.6049 9.95094,8.53862 -19.07227,24.75668 6.68868,4.50146 0.16585,5.05914 -0.60377,2.40148 -1.54717,-0.32019 -4.58868,8.28513 -4.09057,10.96146 -0.71698,1.49426 -13.54339,-5.95569 -6.8,16.31411 3.86981,2.00124 -4.09057,8.74943 -12.76981,-5.12851 2.37736,-5.06981 -21.44943,-9.52324 -9.50755,18.99577 -3.86981,-1.33416 -1.62264,3.83972 -6.36227,-1.81446 1.26415,-5.03779 -3.94339,-0.85386 1.4717,-2.86311 -5.52076,-2.48154 1.4717,-3.6556 -1.99811,-1.49426 1.20754,-4.13056 -1.26415,-1.70772 3.31321,-7.99429 -2.10377,-0.9606 3.15471,-6.50803 -3.99622,-1.52094 1.11321,-2.05461 -20.71887,-9.67533 -3.52264,-2.05461 -5.73208,-2.42817 1.62264,-4.54415 -8.15094,-3.90909 0.62264,-1.41421 -1.35849,-3.1166 2.99811,-1.22743 3.99623,-0.58703 1.32075,0.85386 5.20566,-1.52094 1.94529,-1.46757 6.1,-1.84115 -0.4151,-3.48215 -2.68113,-0.0528 -2.1566,-0.80049 -2.63019,-1.52095 -2.31321,1.73441 -8.7283,4.69625 -2.83962,-1.36085 -0.79246,-4.01048 -4.10188,0.85386 -4.15472,-9.07229 6.25849,-1.94787 11.09623,-14.43829 3.99622,2.21471 3.15472,-3.31939 -2.52453,-1.30748 7.4151,-8.73875 3.6566,-3.01787" id="path9204"></path>
                    '
    ],
    'Новоалександровский городской округ' => [
        'stav_novoa',
        '    <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 87.981624,232.54996 -0.377359,47.30852 0.245283,-0.005 0.603774,-0.0547 0.698113,0.0859 0.64151,-0.13235 0.528301,0.14809 0.566038,-0.2092 1.471698,0.24415 0.679245,0 1.396227,0.50698 1.622641,-0.24014 1.433963,-0.0763 1.037735,-0.26683 0.584906,0.10673 0.773585,-0.0456 2.252826,-0.0296 -0.0172,7.03369 -0.0381,5.69686 -0.074,5.88098 0.62264,0.0318 0.33962,-0.0587 0.24529,0.12701 0.45283,0.15557 0.0624,0.45361 0.1183,0.2052 0.35849,0.19532 0.0394,0.21506 0.24528,0.18572 0.14773,0.29351 0.60378,0.45362 0.18868,0.74713 0.67924,0.0512 0.64151,0.0536 0.43396,0.18092 0.20755,0.29351 0.01,0.37357 0.58491,-0.0195 0.56604,0.29351 0.20754,0.0977 0.60378,0.72045 1.09434,0.0456 0.75471,0.20012 0.20755,0.16437 0.0709,0.22681 0.62265,0.0704 0.39622,0.29352 0.37736,0.53366 0.0377,0.50698 -0.22642,0.82718 -0.10528,0.50698 0.0817,0.50698 -0.18132,0.34688 -0.26416,0.0312 -0.35849,0.11741 -0.0392,-0.69376 -0.24528,0.0483 0.008,0.74713 1.07547,1.20075 0.45283,1.33416 -1.11321,0.0699 0.37736,1.12069 -0.69811,1.36085 0.96226,0.56034 1.07547,-1.17406 0.8868,-0.214 1.09434,0.72045 -0.20755,0.93391 0.0317,1.76109 -0.56604,0.88055 -0.0787,0.61371 0.86792,-0.009 1.71699,-0.61372 0.45283,0.42694 0.007,1.30747 -1.43397,-0.58703 0.33963,1.04065 -0.0327,0.96059 -0.5283,0.18465 -1.20754,-0.002 -0.4717,0.90723 0.60377,0.45362 1.03774,-0.34689 0.43396,1.89451 0.84906,0.9606 0.41509,0.88054 -1.18868,0.77382 0.22642,0.88054 -0.43397,0.40025 -0.98113,0.3202 -0.0123,0.42693 0.77358,0.77381 0.86793,0.66708 -0.10095,1.01396 -0.92453,0.72045 -0.79245,1.14738 0.54717,0.50698 1.60378,-0.9606 0.35849,0.82718 -0.77359,0.50699 0.01,0.69376 0.71698,-0.0881 0.64151,-0.48029 0.92453,0.26683 0.0142,1.38753 0.22642,0.96059 1.1132,0.40025 0.30189,1.09401 -0.50943,0.56035 -0.17189,1.62767 -0.12811,0.12728 0.0689,0.29352 0.0296,0.82718 0.43396,-0.34688 0.35849,0.19372 -0.18868,0.74712 0.50944,-0.56034 0.32075,0.0878 0.0253,0.26683 -0.17792,0.50698 0.71698,1.28079 0.24528,0.15236 0.0606,0.3202 -0.16962,0.0883 -0.37736,-0.2212 -0.30189,0.0443 -0.28302,0.14116 -0.39622,0.0571 -0.67925,-0.34688 0.18566,0.29351 0.33962,0.24095 0.60378,0.0214 0.20754,0.17397 0.33963,-0.0611 0.45283,-0.13182 0.28302,-0.11927 0.28301,0.29352 0.063,0.26683 -0.22641,0.37356 -0.71698,0.34688 -0.54717,0.3202 -0.96227,-0.18731 -1.16981,-0.69377 -0.22641,-0.1142 -0.0757,0.17557 -0.54717,0.18198 0.0189,0.2132 0.47169,-0.0312 -0.0566,0.37357 -0.11981,0.24468 0.0377,0.37357 0.43397,0.21346 0.37735,-0.0752 0.0883,-0.3202 0.32075,-0.0299 0.39623,0.34689 0.24528,0.0315 0.10962,-0.23508 0.79246,0.20199 -0.0796,0.66708 0.0621,0.6404 -0.50944,0.61372 -0.18867,0.083 -0.33963,-0.3202 -0.30188,0.0691 -0.37736,0.3202 -0.32076,0.0955 0.17283,0.17717 -0.0615,0.53367 0,0.40024 0.13548,0.24522 0.37735,0.13475 0.32076,0.4803 0.56604,-0.4803 0.50943,0.0123 0.43396,-0.29352 0.26415,-0.0368 0.33963,0.14969 0.35849,0.01 0.64151,0.72044 -0.17246,0.34689 -0.074,0.53366 -0.35849,0.45361 0,0.50699 -0.58491,0.58703 -0.45283,0.74713 -0.33962,0.50698 -0.0728,0.66708 0.64151,1.17406 1.15094,1.41421 0.0836,0.3202 -0.0632,0.17317 -0.30188,0.53367 0.13792,0.0937 37.08943,0.34688 0.0325,-2.40148 4.78867,0.0405 0.051,-4.77629 1.18868,0.0192 0.053,-1.94787 2.60943,-1.60099 0.56604,1.25411 0.26415,0.34688 0,0.37356 0.16453,0.26684 0.41509,0.64039 0.43396,1.01396 -0.0164,1.01397 0.13151,0.29351 0.28302,0.25616 -0.0411,0.40025 -0.0617,0.37356 0.15434,0.6404 -0.0104,0.50698 0.62264,1.01396 -0.1083,0.34688 -0.0106,0.40025 0.0262,0.29352 0.32075,0.80049 0.4717,0.53367 10.49623,0.13475 -0.0225,2.13466 27.78963,0.32019 -1.20755,-0.45361 -0.79245,-0.9606 -1.4151,-2.08129 -0.50943,-4.99509 0.96226,-2.66832 -0.41509,-1.92119 0.33962,-1.25412 -0.66038,-1.33416 -3.30754,0.8005 -0.52831,-9.55259 -6.20566,0.0651 -0.39622,-25.0582 2.48302,-0.0648 -0.32076,-24.43381 6.07547,0.19425 -0.26415,-5.56878 -2.41698,-0.0648 -0.14755,-11.73528 -21.9566,0.14569 -2.20566,-18.48079 -2.05849,-1.20074 1.03774,-14.48632 -4.2151,-0.14515 0,-4.35737 1.07547,0.0969 2.54906,1.44089 0.88679,0 0.39623,-0.96059 -0.30189,-1.97456 1.32076,-1.41421 0.30188,-1.89451 -16.66415,-0.24201 -0.18868,-10.94812 -13.76226,-0.15477 -0.39623,22.73676 -19.60622,-0.15689 -1.92264,0.007 0.023,-4.83767 -4.23208,0.0101 -0.32075,-0.028 0.20754,-0.32019 0.50944,-0.4803 0.0538,-0.26683 -0.10509,-0.3202 -0.67925,-0.61372 -0.62264,-0.12941 -0.45283,-0.15956 -0.50944,-0.40025 -0.33962,-0.50698 -0.28302,-0.29352 -0.39622,-0.19158 -1,-0.10327 -0.12076,-0.37356 0.0728,-0.56035 -0.0485,-0.26683 -0.30188,-0.26683 -0.45283,-0.0328 -0.3585,0.15263 -0.26415,0.58703 -0.26415,0.16784 -0.28302,-0.016 -0.90566,-0.53366 -0.41509,-0.25696 -0.37736,-0.008 -0.39623,0.29352 -0.26415,-0.0688 -0.56603,-0.32019 -0.4151,-0.064 -0.45283,-0.0238 -0.69811,0.42693 -0.0889,0.37356 -0.28302,0.22361 -0.54717,0.2156 -0.56604,0.40025 -0.5283,0.0638 -0.22641,0.34688 -0.0798,3.26069 -9.69812,-0.0584 -12.013205,-0.072" id="path9184"></path>
                    '
    ],
    'Нефтекумский городский округ' => [
        'stav_nefte',
        '     <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 790.62104,557.29819 -2.62264,19.05982 3.93207,6.27055 5.15661,-3.53285 0.5283,-2.10798 3.75849,0.61372 -0.43396,-2.29476 6.73018,0.17638 0.26416,2.82575 24.29603,4.50412 0.5283,2.91648 18.87755,1.49426 0.35849,12.90667 -7.51698,1.94787 0,5.57412 7.69057,2.21471 3.40754,-2.29476 4.33019,2.16134 14.19245,6.91629 3.97548,-8.16239 10.91698,3.82637 8.20188,4.59218 15.13208,-2.70568 0.15,-1.84114 5.45849,-1.17406 11.62264,-1.97456 0,0.19132 11.94528,-2.18802 10.26227,-27.72919 0.60377,-9.26975 -5.91698,-2.00124 -2.08679,-4.21595 -2.62831,-0.66708 -2.70188,-2.67632 -24.84415,-0.77381 0.83019,-10.48117 6.36603,0.66708 0.1351,-1.65436 0.4717,-1.97455 -5.40566,-10.35843 0.49056,-0.40024 1.90755,-3.91176 1.60377,-4.37338 9.98491,-0.69376 4.05472,-1.22743 1.39622,0.77381 0.92453,-2.32144 6.94528,-1.22742 5.28491,3.37542 16.11887,-18.21662 4.5566,-4.52814 7.08679,-9.33913 18.12453,-23.8281 -6.74906,-16.31411 -1.18868,-2.45486 17.29059,-27.58456 0.717,-2.10798 -28.74306,-2.02792 0.11359,23.64933 -34.87528,1.41421 -0.56604,-20.7542 -3.57925,1.30747 -9.25849,-2.0546 -5.28302,4.82966 -2.27169,-0.40025 -1.13208,1.25411 -1.75472,2.78573 -5.79434,0.29351 -1.86792,2.10798 -2.15849,0.34688 -1.86793,-2.50822 -3.86226,1.86782 -0.79245,1.92119 -1.58491,1.20075 -4.09056,1.01396 -2.5,2.26807 -2.2151,4.21061 0.33962,4.38138 -0.45283,2.8471 -1.13207,1.41421 -2.66981,0.50698 -0.73585,2.45486 0.84905,6.49202 0.73585,2.10798 -0.62264,1.65435 0,2.10798 -5.73773,4.38938 -2.55661,0.8005 -1.86792,1.25411 -2.04528,-0.50698 -2.4434,0.85386 -3.46415,-1.25411 -2.66981,-1.86782 -2.55661,-0.45362 -0.73585,0.8005 -1.98867,4.90171 3.29433,0.34688 0.90567,2.40149 -0.28302,1.8945 -14.31321,13.63779 -7.89623,10.84939 -8.74717,9.37114 -1.35849,2.80174 -35.55679,-7.14576 -0.67924,2.34812 -5.99812,43.4472" id="path9160"></path>
                  '
    ],
    'Левокумский муниципальный округ' => [
        'stav_levon',
        '    <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 753.67047,445.32852 16.51132,-20.31926 0,-4.24263 9.59434,-22.82749 -9.00566,-3.90908 9.26793,-24.41514 25.06018,10.02221 23.82,-56.07529 8.02642,-10.95612 1.24528,-2.45486 3.97736,-5.53943 4.18491,3.1166 4.8849,2.40148 0.35849,4.29066 8.86038,4.33336 21.57453,9.9555 15.08113,7.42327 10.83207,5.921 26.12604,14.97729 3.2283,1.84114 21.59321,12.31963 23.82,13.04542 -0.69811,1.25412 1.43396,2.0546 12.38113,17.16531 10.65092,14.20347 -1.3396,2.83109 -28.74302,-2.02793 0.11359,23.64933 -34.87529,1.41421 -0.56603,-20.7542 -3.57925,1.30748 -9.25849,-2.05461 -5.28302,4.82966 -2.2717,-0.40024 -1.13207,1.25411 -1.75472,2.78572 -5.79434,0.29352 -1.86792,2.10797 -2.15849,0.34688 -1.86793,-2.50822 -3.86226,1.86783 -0.79245,1.92119 -1.58491,1.20074 -4.09056,1.01396 -2.5,2.26808 -2.2151,4.21061 0.33962,4.38138 -0.45283,2.8471 -1.13207,1.41421 -2.66981,0.50698 -0.73585,2.45485 0.84905,6.49203 0.73585,2.10797 -0.62264,1.65436 0,2.10797 -5.73773,4.38939 -2.55661,0.8005 -1.86792,1.25411 -2.04529,-0.50698 -2.44339,0.85386 -3.46415,-1.25411 -2.66981,-1.86783 -2.55661,-0.45361 -0.73585,0.8005 -1.98868,4.9017 3.29434,0.34688 0.90566,2.40149 -0.28301,1.89451 -14.31321,13.63779 -7.89623,10.84939 -8.74717,9.37114 -1.35849,2.80174 -35.55679,-7.14577 -0.67924,2.34813 -14.88114,-9.9982 -21.75433,-16.7277 0.84905,-1.41421 -5.79434,-4.67757 4.7151,-7.52733 -0.28302,-11.28433 -3.29434,-2.56159 5.50943,-7.17511 -8.01698,-7.14577" id="path9162"></path>
                    '
    ],
    'Курский муниципальный район' => [
        'stav_kursk',
        '     <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 704.185,692.52735 5.63963,-0.0269 0.11584,11.24698 15.36793,0.37356 0.0428,2.37481 2.44151,-0.12141 0.0428,0.37356 5.94339,-0.0304 -0.18868,-12.01811 9.4,-0.15984 0,-2.695 9.0717,-0.0608 0.43396,-8.39987 0.30189,-0.13315 0.71698,0.19372 1.05661,-0.24228 0.90566,-1.04065 0.77358,0.12114 0.77359,0 0.28302,0.0907 0.6415,-0.12115 0.28302,0.12115 0.62265,-0.29352 0.49056,-0.26683 0.66038,-0.0907 0.60377,-0.0606 0.0643,-0.72045 0.14981,-0.50698 -0.12849,-0.37357 1.16981,0.21187 -0.0853,18.93173 -14.00943,0.0913 -0.18868,11.0175 -1.13208,0.32019 -0.33962,0.1513 -1.39623,1.25411 -0.73585,0.66708 -0.6415,0.15156 -0.4151,0.24228 -1.16981,0.0985 -1.43396,0.45362 -1.11321,0.0606 -1.13208,-0.0302 -0.33962,21.5707 1.93396,0.58703 0.35849,0.0921 0.49057,-0.16517 1.32076,0.69376 1.62264,-0.15956 1.93207,0.11394 4.10755,-0.34689 0.016,-0.61371 0.67924,-0.4803 0.83019,-0.25082 3.14151,-0.56035 -0.016,3.32473 17.53962,0.22734 0.17717,-1.62767 6.73208,-0.1593 0,-1.70773 8.79434,0.13662 0.0645,-1.28079 1.93207,0.0227 2.7868,-0.85387 0.88679,-0.40024 2.31132,-1.68105 0.33962,0.091 0.37736,0.53367 0.66038,0.0683 0.0645,0.66708 0.8868,0.0683 1.5283,-0.023 0.32075,-0.50698 8.96227,-0.0913 -0.0162,-2.26807 6.92642,0.13662 -0.14491,4.58417 16.47547,0.0907 -0.0643,2.45486 2.57736,0.77381 0.28302,8.13571 -0.26415,14.68644 1.54717,1.33416 0.94339,0.37356 0.28302,0.26684 0.28302,1.22742 0.37736,0.74713 0.49057,0.4803 0.35849,-0.0227 0.30188,-0.22787 0.24529,-0.74713 0.35849,-0.25056 0.50943,-0.8005 0.49057,-0.25055 0.69811,0.023 0.30189,-0.42693 0.64151,0.0456 0.20754,0.11367 0.43397,0.61372 0.12886,0.66708 -0.18867,0.77381 -0.49057,0.66708 -0.81132,0.66708 -0.11283,0.53367 -0.0966,0.72044 -0.56603,1.1207 -1.62264,0.80049 -0.56604,0.53367 0.39622,0.66708 1.01887,0.40025 0.98113,0.42693 1.15095,-0.74713 1.16981,-1.73441 0.64151,-1.57431 1.07547,0.0539 0.41509,0.85386 -0.18868,2.48154 -1.56603,2.53491 0.26415,1.62767 0.88679,0.69376 2.78679,1.01397 2.00378,0.64039 1.60377,-0.37356 2.21509,-1.52094 0.92453,-0.74713 0.37736,-1.36085 -0.30189,-1.89451 0.52831,-0.53366 1.1132,0.21587 1.03774,0.85386 1.33962,1.25411 1.26415,0.3202 0.84906,-0.37357 1.41509,-0.90722 1.45283,-1.06733 1.11321,-4.21061 0.79245,-0.21614 1.52831,-0.21586 0.67924,-0.37357 0.11453,-1.89451 0.0762,-1.06733 0.33962,-0.64039 1.75472,-1.52095 2.44339,-1.12069 2.02453,-0.85386 0.92453,-0.10807 0.79245,0.37357 0.64151,1.06732 0.33962,0.85387 0.33963,0.16196 0.88679,-0.16196 0.56604,-0.4803 0.49056,0 0.30189,0.58703 -0.0381,0.85386 -0.26416,0.74713 0.11453,0.69377 0.22642,0.21613 0.75471,-0.21613 3.13963,-2.53491 0.50943,-45.14879 -2.34717,-0.24175 0.24528,-18.49146 27.73812,0.53367 -0.28302,21.37324 44.84962,0.17905 0.15226,-28.88884 0.49057,-6.89227 8.93962,0.0515 0.45283,-21.66142 -0.16528,-10.09693 2.67358,-0.1062 -0.13528,-12.49841 -3.40943,-0.4803 -4.65472,0.45361 -11.78679,-0.29351 -4.26415,-0.85386 -12.40378,-1.09401 -0.33962,0.74712 -3.68679,-0.19105 0,-0.42693 -19.07792,-1.49426 -5.56416,-0.72044 -6.46415,-0.29352 -3.8283,0.40025 3.01887,-7.61272 3.21698,-8.96289 -8.20189,-4.59218 -10.91698,-3.82637 -3.97547,8.16239 -14.19245,-6.91629 -1.95849,24.0229 -5.70943,-0.9606 0.30188,23.66 -25.55604,0 -0.6415,-1.44089 -0.79246,-3.8077 -16.23585,0.17051 -0.62264,5.85429 -16.01132,-1.44089 -2.15471,-0.4803 0.0558,-11.59118 -24.15641,-0.34688 0.084,10.14228 -2.43585,0 -2.23962,0.25563 -2.60377,1.49426 1.81132,14.87055 -17.13019,0.22761 0.16792,-2.45486 -2.74339,-0.0496 0.35849,-7.39392 -3.63962,-1.68104 -4.02453,-1.09401 -8.46793,-0.17771 0.24529,-6.46534 -7.41698,-0.29352 -0.28302,14.67577 3.4283,0.0358 -0.45283,6.96966 -19.20906,0.0358 0.35849,2.70301 2.62453,0 0,4.34136 -2.16981,-0.21347 -0.0349,3.38077 3.07925,0.42693 -1.54717,9.4085" id="path9198"></path>
                    '
    ],
    'Красногвардейский муниципальный район' => [
        'stav_krasn',
        '    <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 147.02577,163.84977 0.0526,19.17189 16.5717,-0.056 -0.0196,3.98647 0.22641,-0.0414 0.11755,-0.19372 -0.0725,-0.37356 -0.0155,-0.37357 0.10868,-0.19879 0.26415,-0.0763 0.32075,0.0304 0.24529,0.13768 0.10867,0.26497 -0.0157,0.26683 -0.18113,0.53366 0.12245,0.2036 0.49057,0.1166 0.22642,0.24175 0.0162,0.50698 0.18868,0.3202 0.26415,0.26683 0.18868,0.42694 -0.35849,0.42693 -1.28302,0.74713 -0.64151,0.90723 -0.20754,0.0907 -0.4717,0.12754 -0.49057,0.11154 -0.67924,0.11154 -0.28302,0.14328 -0.14547,0.17531 0.0889,0.3202 0.26415,0.24682 0.45283,0.42693 0.1217,0.3202 -0.10264,0.21213 -0.18604,0.22307 -0.43396,0.23909 -0.12924,0.17504 0.0241,0.19132 0.22641,0.40024 0.003,0.29352 -0.16491,0.18678 -0.81132,0.26683 -0.28302,0.26684 -0.0485,0.29351 0.28302,0.88055 0.58491,0.69376 0.22641,0.74713 0.26415,0.0966 0.45283,-0.12754 0.79246,0.15129 1.22641,0.72045 0.60378,0.42693 0.1132,0.22307 -0.15358,0.4803 -0.0177,0.25162 0.49057,0.74713 0.11113,0.53367 0,0.45361 -0.20755,0.40025 -0.22641,0.17931 0.0302,0.37356 0.4717,0.0219 -0.0253,2.50823 2.40566,0.0366 -0.1249,9.60062 -5.6283,-0.0632 0.18867,10.94812 16.66416,0.24202 -0.30189,1.8945 -1.32076,1.41421 0.30189,1.97456 -0.39623,0.9606 -0.88679,0 -2.54905,-1.4409 -1.07548,-0.0969 0,4.35737 4.2151,0.14516 -1.03774,14.48631 2.05849,1.20075 2.20566,18.48079 21.95661,-0.1457 0.43396,-3.97846 8.38113,-0.34688 0,4.56283 5.29245,0.58703 0,1.65435 8.08679,-0.19425 0.18868,-10.3851 17.05661,-0.0486 -0.0491,-18.90505 12.35094,-0.14542 -0.14717,-9.97685 28.18095,-0.77382 0.24528,-8.85615 4.06792,-0.42693 0.43397,-2.13466 1.86792,0 0.33962,-1.60099 2.40189,-0.0483 0.0489,-1.54763 2.00943,-0.19345 0.79245,-1.12069 2.30378,0.64039 0.83019,-0.96059 1.13207,0.19345 2.45095,2.32144 1.71698,0.0483 1.03773,-0.82718 0.18868,-18.41408 -0.30188,-6.37462 -5.73397,-0.88055 0,-0.82718 -3.08679,0 0,-7.91424 16.85849,-0.58703 0.64151,-16.20204 3.47925,0.72045 3.5283,2.02792 1.07547,0.6404 0.45283,-7.46596 0.0909,-1.84115 -15.53585,-1.28079 -5.79622,-0.34688 -8.58679,-0.6404 -4.15661,1.68104 -1.49056,-0.56034 -2.97359,-0.12862 -4.36981,-0.42693 -1.20755,0.21454 -2.79056,-0.82718 -2.88302,-0.29352 -1.79246,-0.61371 -2.09433,0.21453 -1.20755,0.25749 -2.12453,-0.64039 -1.33962,0 -1.81132,0 -1.91132,-0.56035 -1.35849,-0.25749 -2.85283,0.34688 -1.24529,-0.4803 -2.08868,-0.12808 -0.35849,0.12087 -0.56604,0.29352 -0.62264,0.26683 -0.84905,0.008 -0.39623,-0.24068 -0.33962,-0.37356 -0.83019,-0.22414 -0.5283,0.13555 -0.39623,0.50698 -0.39623,0.21934 -0.71698,-0.0977 -0.41509,0.031 -0.37736,0.1713 -0.4717,0.45362 -0.83019,0.53366 -0.43396,0.12968 -0.43396,0.0459 -0.56604,-0.16811 -0.33962,-0.19185 -0.16076,-0.0285 -0.35849,-0.53366 -0.13,-0.15877 -0.16302,-0.0152 -0.28301,0.0611 -0.24529,-0.0382 -0.22641,-0.084 -0.18076,-0.005 -0.14905,0.0731 -0.28302,0.0635 -0.24529,0.0635 -0.22641,0.0782 -0.18868,-0.0302 -0.20755,-0.14515 -0.30188,-0.13715 -0.20755,-0.107 -0.16415,0.0147 -0.26415,0.15316 -0.32076,0.04 -0.62264,-0.16704 -0.43396,0.024 -0.33962,0.1601 -0.24529,0.18331 -0.35849,0.18305 -0.22641,0.10993 -0.32076,0.0686 -0.37736,0.0427 -0.22641,-0.0915 -0.43396,-0.37357 -0.17151,-0.1174 -0.20755,-0.0704 -0.33962,0.0507 -0.12755,0.012 -0.17377,-0.0854 -0.33963,-0.0456 -0.16301,0.0993 -0.26416,-0.0688 -0.16301,-0.13715 -0.32076,-0.15263 -0.64151,0 -0.22641,0.055 -0.24529,-0.009 -0.22641,-0.0336 -0.26415,-0.12808 -0.35849,-0.21374 -0.32076,-0.0366 -0.32075,0.0854 -0.33963,0.0123 -0.26415,-0.0387 -0.75471,-0.22467 -0.9434,-0.24896 -0.41509,-0.003 -0.32076,0.0838 -0.81132,-0.0763 -0.71698,-0.20386 -0.60377,-0.064 -0.49057,0.0673 -0.4717,0.14115 -0.37736,0.0571 -0.35849,-0.0816 -0.5849,-0.29351 -0.92453,-0.16224 -0.73585,-0.0571 -0.98113,-0.0875 -0.18566,-0.0782 -0.18868,-0.12621 -0.39623,-0.25936 -0.79245,-0.37357 -0.67925,-0.2631 -0.35849,-0.15129 -0.30188,-0.19532 -0.20755,-0.0683 -0.18811,-0.0195 -0.33963,0.099 -0.45283,0.1054 -0.32075,0.17771 -0.16887,0.12701 -0.064,0.0363 -0.0785,0.0141 -0.0811,-0.0157 -0.0779,-0.0419 -0.16547,-0.0576 -0.15906,-0.01 -0.14924,-0.043 -0.13359,-0.0571 -0.16188,-0.0504 -0.15057,-0.0568 -0.18,-0.0504 -0.1483,-0.0195 -0.16264,0.0251 -0.15774,-0.007 -0.15283,-0.0301 -0.32075,-0.10246 -0.32076,-0.12088 -0.60377,-0.3202 -0.84906,-0.50698 0.20755,-0.53366 -0.0821,-0.11607 0.0666,-0.26683 0.0364,-2.02793 -4.67924,0.0552 -0.005,2.16134 -0.32075,-0.0878 -0.28302,-0.0635 -0.28302,-0.0416 -0.41509,-0.0678 -0.43397,0.0243 -0.77358,0.15823 -0.50943,0.14089 -0.50944,-0.005 -0.41509,-0.009 -0.4151,0.0731 -0.69811,-0.0915 -0.56604,0.0123 -0.22641,0.0141 -0.26415,-0.0101 -0.56604,-0.13021 -0.43396,-0.13422 -0.52831,-0.0611 -0.49056,-0.0109 -0.4717,-0.0499 -0.56604,0.0427 -0.49056,0.0792 -0.39623,0.214 -0.37736,0.11634 -0.50943,-0.0307 -0.66038,-0.18305 -0.54717,-0.13342 -0.4717,-0.0419 -0.43396,0.0686 -0.43396,0.16783 -0.43396,0.13742 -0.60378,0.10647 -0.0187,0.16677 -0.26415,0.21213 -0.002,0.61371 0.034,0.0299 0.0481,10.9241 -16.7132,0.007 -1.45283,0.11287 -7.44151,-0.02 -10.99434,-0.0181 -7.21132,0.0835" id="path9186"></path>
                    '
    ],
    'Кочубеевский муниципальный район' => [
        'stav_kochub',
        '     <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 207.05558,514.22296 -0.49056,-1.89451 -0.066,-0.4803 -0.28302,-0.24842 -0.41509,0 -1.01887,-0.58703 -0.13887,-0.0173 -0.22642,0.1697 -0.30188,0 -0.33962,-0.23241 -0.26416,-0.0139 -0.30188,0.12808 -0.33962,-0.0301 -0.24529,-0.8005 -1.4717,-0.9606 0.11585,-0.34688 -0.79245,-1.17406 -0.83019,-3.26069 -2.38679,-8.90952 18.18868,-4.9524 -0.20755,-0.45362 -0.56604,-0.53366 7.63397,-2.05461 -0.8868,-3.45814 2.19812,-0.61372 -0.56604,-2.13465 2.76604,1.17406 0.008,-0.16143 0.17,0.0269 1.28302,-3.90376 0.10208,-0.0299 0.22641,0.0528 0.0785,0.20092 0.28302,0.12675 0.0815,0.13528 0.17113,0.0326 0.35849,0.21293 0.0528,0.21293 0.15906,0.15556 -0.35849,-1.36084 -1.43396,-5.58479 5.73019,-1.52095 -1.81132,-6.92429 1.15094,-0.34688 -0.49057,-1.89451 1.37736,-0.4803 -0.0117,-0.80049 0.49057,-1.36085 -0.0828,-0.17877 0.45283,-1.04065 0.49057,0.40025 0.14641,0.23641 0.18868,0.1022 0.41509,0.006 0.26415,-0.23001 0.12114,-0.18518 0.54717,-1.70772 0.81132,-2.61496 0.41509,-0.14702 0.0196,-3.06857 0.14774,-7.9516 2.37736,0.0211 0.0177,-1.17406 0.32076,-20.42066 8.11698,-0.2276 0.0679,7.84486 -0.26415,2.48154 -0.67924,1.54762 1.39622,1.4409 2.03963,0.96059 2.9,3.2687 0.41509,6.21985 1.81132,0 0.32076,2.32144 3.53585,0.0454 4.35094,-0.37356 3.12641,2.95116 2.31133,1.09401 1.26415,-0.72045 1.32075,1.22743 4.30566,-4.81365 7.52264,5.40335 -1.71698,5.22457 2.6283,1.41421 1.16981,0 1.13208,-2.3748 1.39623,-0.82718 1.77358,2.99919 2.22076,1.36084 2.40188,0.90723 0.81132,0.72045 1.58491,4.77362 -0.13585,5.5928 3.1717,3.65827 1.99434,0.93391 3.11887,0.0363 0.24528,-3.12994 -0.35849,-0.93391 -1.09434,-2.10797 -0.24529,-1.46758 -2.32075,-2.10797 0.0362,-1.09401 1.18868,-0.10914 1.5283,0.69377 0.98113,1.52094 0.10868,1.97456 1.41509,2.18802 0.39623,3.89308 1.60377,0.77381 0.9434,0 4.96792,-3.85839 5.07548,0.25482 1.01886,1.22743 3.00944,5.64083 -0.71698,2.40149 9.20943,4.296 5.6566,-8.88284 9.17359,0.4803 0.0364,4.58684 8.04906,0.72045 1.22641,0.72044 0.4717,-0.14569 0.10868,2.69501 11.74717,-0.37357 0.16962,1.33416 -1.26415,7.75147 -6.10188,0.25563 0.30188,-1.62768 -4.02641,-0.25562 -1.18868,1.78777 -2.83962,-0.17024 -2.28868,0.17024 -2.58491,0.93391 -4.23773,-1.44089 -0.92453,1.73441 5.72075,1.70772 4.40755,-1.52094 1.5283,0.29352 -2.71321,8.608 -5.76415,-1.20074 -0.84905,1.33416 -2.66981,-1.41421 -2.20378,5.07247 1.05661,0.85387 -4.91699,11.68724 1.22642,0.6404 -2.33019,5.93167 -4.44906,-1.65435 -5.29811,9.3071 -0.64151,1.76109 2.16038,3.03388 2.37358,1.84114 -1.56603,6.32392 8.94151,2.42817 -0.16963,3.03655 4.32264,0.2567 0.30189,2.64163 14.66415,0.42693 0.4151,8.29848 7.33207,0.50698 1.99245,4.2373 -3.30566,4.36537 -2.11886,1.41421 -0.67925,0.98728 -5.51509,18.3447 -0.45283,-0.23881 -0.81132,-0.56035 -0.62265,-0.2655 -0.71698,-0.2132 -0.41509,-0.0432 -0.67925,-0.26684 -0.41509,-0.32019 -0.22642,-0.0336 -0.32075,0.0846 -0.37736,0.16063 -0.84906,-0.61371 -0.90566,-0.88055 -1.16981,-0.77381 -0.90566,-0.72045 -0.4717,-0.0656 -17.87735,-0.24148 -0.11642,-1.04064 -7.17358,-0.005 -6.28491,0.0155 -3.09623,0.0128 -0.43396,0.002 -0.1617,-0.45361 -0.20754,-0.18918 -0.56604,-0.25776 -0.12227,-0.25776 -0.0238,-0.21214 0.0655,-0.42693 0.006,-0.29351 -0.0204,-0.11394 -0.20755,-0.17237 0.0989,-0.40025 -0.0147,-0.40025 -0.12113,-0.22494 -0.39623,-0.82718 -0.41509,-0.80049 -0.35849,-0.29352 -0.56604,-0.0937 -0.43396,-0.0331 -0.32076,-0.13529 -0.54717,-0.4803 -0.88679,-0.53366 -0.71698,-0.34688 -0.56604,-0.3202 -0.37736,-0.0518 -0.39622,-0.48029 -0.18151,-0.0998 -0.22642,-0.0408 -0.30189,-0.202 -0.32075,-0.0619 -0.37736,0.006 -0.0838,-0.079 0.0423,-0.40024 -0.0608,-0.11234 -0.0828,-0.0544 -0.39623,-0.01 -0.28302,-0.0718 -0.17641,-0.40025 -0.28302,-0.1206 -0.49057,0.0515 -0.5849,-0.17477 -0.18868,-0.40025 -0.22642,-0.15529 -0.4717,10e-4 -0.62264,0.0563 -0.33962,-0.20012 -0.60377,-0.12461 -0.26415,-0.0232 -0.3585,-0.2655 -0.5283,-0.19318 -0.16754,-0.1577 -0.0228,-0.17958 0.10584,-0.20066 0.008,-0.22974 -0.11491,-0.0451 -0.32075,0.0288 -0.14906,-0.0928 -0.24528,-0.56035 -0.35849,-0.15023 -0.56604,-0.10966 -0.56604,-0.17505 -0.43396,0.14756 -0.24528,0.009 -0.15076,-0.14168 -0.17849,-0.45362 -0.30188,-0.25109 -0.58491,-0.40025 -0.35849,-0.003 -0.98113,-1.44089 0.24528,-0.98728 0.56604,-2.80974 0.33962,-3.88241 -0.66038,-1.25411 -0.43396,-3.39411 1.56604,-3.43679 -0.81132,-3.54353 0.26415,-1.84114 1.11321,-1.33416 -0.0194,-0.53367 -6.51132,0.0195 -6.42075,-0.19452 0.11547,2.61495 -10.93774,0.66708 -2.4415,2.18803 -0.32076,1.52094 -4.54906,-0.40025 -0.90566,0.10193 -0.5849,0.15423 -3.01887,-0.17371 -1.49057,-0.37356 -0.0774,-2.74837 -1.33963,-0.17157 -0.12339,0.18678 -1.09434,-0.61372 -1.64151,-0.56034 -2.00189,-0.45362 -0.69811,-2.66832 -9.18113,2.45486 -2.41321,-9.28576 -9.17547,2.45486 -7.12076,-27.27638 -4.62453,1.1207 0.79246,3.03121 -6.9283,1.84114 -0.37736,-1.62768 -0.86793,-3.23934 -0.41509,-1.92119 -1.33962,-4.67223" id="path9166"></path>
                    '
    ],
    'Кировский городской округ' => [
        'stav_kirovsk',
        '     <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" fill="#e6735c" stroke="#f2f2f2" d="m 539.17274,702.67391 6.78868,17.32274 7.99057,18.11523 2.82641,-2.78573 0.58491,-0.42693 0.77358,-0.40025 0.92453,-0.37356 0.88679,-0.45362 0.83019,-0.98728 0.96227,-1.28079 0.81132,-1.36084 1.54717,-0.93392 0.5283,-1.38752 2.39811,-0.72045 1,-0.72045 1.5283,-0.29351 0.37736,-0.93391 1.01887,-1.4409 0.75472,-1.09401 0.67924,-0.45361 1.77359,0.42693 1.84905,-1.14738 1.24529,-0.21213 1.22641,0.21213 0.84906,0.15129 1.83019,-0.74713 1.62264,-0.0606 0.66038,-0.15156 2.3132,0.8005 1.84906,0.37356 0.5283,-0.0304 1.09434,0.29352 1.4717,1.49426 1.77358,0.9606 0.83019,0.24228 2.4,0.85386 1.24529,1.04065 0.81132,0.0304 1.22641,-0.66709 1,-0.21213 1.09434,-0.21186 0.73585,-0.66708 0.81132,0 0.32076,0.21213 0.43396,0.24228 0.41509,0 0.5283,0.26684 0.45284,-0.0606 0.62264,-0.0304 0.67924,0.18171 0.67925,0.0606 0.64151,0.26683 0.49056,0.21187 0.4151,0.29351 0.35849,0.37357 0.43396,0.37356 0.28302,0.18171 0.45283,-0.37356 0.49056,0 0.79246,0.42693 0.79245,0.26683 0.49057,0.40025 1.16981,0.15129 0.66037,-0.18171 0.22642,0.21213 1.07547,0.18172 0.62264,0.42693 0.96227,0.3202 0.49056,0.26683 0.60378,-0.29352 0.33962,0.15156 0.64151,0.0302 1.24528,0.15156 1.9283,0.0606 0.58491,-0.21213 0.37736,0.72044 1.13207,0.29352 1,0 0.67925,-0.42693 0.26415,-0.21214 0.69811,0.37357 1.24529,-0.18171 0.69811,0.64039 1.01887,0.3202 0.0428,0.58703 0.37736,0.45362 0.94339,0.53366 0.58491,0.37357 0.26415,-0.21214 0.0857,-0.74713 0.0857,-0.26683 0.28302,0.18198 0.33962,0.26683 0.62264,0.29352 0.43396,-0.0606 0.14982,0.0606 -0.0213,0.42693 0.20755,0.37357 0.0487,-3.11927 1.43396,-1.86783 0.4151,-1.44089 -0.37736,-2.18802 -0.0213,-0.42693 0.88679,0.21186 0.5283,-2.16134 1.20755,-3.18064 0.77358,-0.90723 -0.0858,-8.68538 0.0643,-5.12051 1.32075,-0.37356 0.56604,-0.72045 0.32075,-1.38753 0.17132,-0.42693 0.33963,-0.53366 0.96226,-0.0301 0.79245,-0.72045 0.58491,-0.72045 0.35849,-0.37356 0.15,-0.42693 0.9434,-0.6404 0.81132,-0.69376 0.75471,-0.21213 0.79246,-0.9606 0.69811,-0.40025 4.34906,-0.15156 2.6566,-0.18171 -0.18868,-1.06733 0.30189,-1.70772 0.28302,-1.17407 0.67924,-0.50698 0.12849,-0.45361 -0.26415,-2.32144 0.49057,-0.18171 0.90566,-0.29352 0.64151,-0.50698 0.45283,-0.37356 0.17132,-0.21187 0.56603,-0.3202 0.56604,-0.58703 0.39623,-0.50698 0.22641,-0.40025 0.81132,-0.45361 0.66038,-0.72045 0.26415,-0.74713 0.12849,-0.40025 0.37736,-0.26683 0.58491,-0.0608 0.49056,0.12141 0.62265,-0.15156 0.35849,-0.53366 0.47169,-0.12114 0.45283,-0.3202 0.43397,-0.40025 0.0428,-0.42693 0.35849,0.0606 0.35849,-0.45361 0.5283,-0.12115 0.58491,0.3202 0.67924,-0.15049 0.11792,2.45485 2.54906,0.0302 0.26415,6.27055 7.86038,-0.12141 0.0857,4.30133 5.22641,-0.091 18.63019,-0.0891 1.54717,-9.4085 -3.07924,-0.42693 0.0349,-3.38076 2.16981,0.21347 0,-4.34136 -2.62452,0 -0.35849,-2.70301 19.20905,-0.0358 0.45283,-6.96965 -3.4283,-0.0358 0.28302,-14.67576 7.41698,0.29352 0.26415,-4.76563 -3.86792,-0.25215 -0.20755,-2.70034 -28.58698,-0.74713 0.12736,1.09401 -2.2717,1.65436 -2.58113,3.74365 0.0545,1.17406 0.67924,0.9606 -0.0181,1.76109 -1.50944,2.10797 -0.20754,1.54763 1.22641,2.82308 0.0181,0.93392 -2.01698,4.09854 -0.32075,1.52094 1.84906,3.43413 -5.48868,1.38752 -18.71698,-15.04666 2.32641,-3.89308 -4.72453,-4.37071 1.16981,-2.24138 -6.01509,-3.18865 -1.89057,2.48154 -5.17924,-3.35675 -4.3434,6.86026 -2.38113,-1.52095 -3.61698,3.50351 -10.59434,14.59571 -8.35849,-5.5928 -3.68868,5.35265 -1.33962,-1.12069 -1.20755,1.76109 -2.21698,0.20333 -2.61698,-0.9606 -4.17925,-3.765 -2.01698,2.82308 -1.4717,-1.28079 -1.41509,2.05461 -1.37736,-1.36085 -3.67924,4.87236 -2.80566,4.66956 -3.19812,4.36003 -1.24528,-1.01396 -2.44528,2.76705 -0.60378,1.22743 -1.75471,1.17406 -1.84906,0.85386 -4.95472,0.15743 6.83208,11.21762 -3.15094,4.03184 -1.86793,1.17406 -3.01509,3.13527 -3.54906,-12.98671 -32.65358,14.27818" id="path9182"></path>
                    '
    ],
    'Ипатовский городской округ' => [
        'stav_ipat',
        '     <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 304.07483,198.78129 6.99433,-0.0854 0.20755,4.93105 10.10944,0.42693 0.84905,2.21471 6.17359,0.10486 0.43396,-2.72969 14.79245,0 0,7.55669 -5.00189,0.93391 -1.0566,5.25125 1.9151,1.14738 0.6415,4.9364 -1.69811,0.21026 -0.5283,3.67694 -9.04528,0.3202 0.10641,10.72398 3.08679,0 1.49057,1.68105 6.27925,0 0.96226,4.1012 1.37736,1.46758 9.89811,0.10513 0,2.53491 -2.23396,0 -0.96227,8.52795 6.49246,0.21053 3.3,1.89451 2.02264,-1.04065 7.76981,-0.53366 2.55472,2.84443 2.1283,1.46758 0.20755,2.42817 1.81132,2.32144 0,1.68104 1.49056,0.85386 1.05661,-1.68104 2.66037,-0.3202 8.08868,-0.2108 0.5283,3.89842 8.83397,0.2108 0.5283,-7.27118 4.36415,0 0,-1.25411 8.40755,0 -0.20755,2.84443 2.66038,0.74713 0.5283,-1.68104 1.60377,-1.36084 8.83396,-0.2108 0.10642,-5.79292 3.3,0 0,-1.36085 16.28302,0.9606 0.20754,3.15929 1.49057,1.36084 14.68679,3.47682 -2.02264,13.06944 2.1283,0.6404 1.49057,-1.06733 -0.96227,-1.36085 1.49057,-2.00124 0.10642,-1.8945 0.84905,-0.42694 1.4717,-0.42693 0.71698,-2.5349 1.4151,-2.26807 -0.22642,-1.57431 1.64151,-3.39678 17.3283,11.70593 0.1634,4.15724 40.2132,-1.12069 0.32076,-10.19833 16.4566,-0.32019 0.0543,-1.57431 7.24717,-0.0539 0.22642,1.94787 10.95283,-0.4803 -0.10906,-23.98553 -6.10189,-1.2808 -2.12453,-1.8945 -2.72452,-0.69377 1.09434,-5.43803 7.46415,-0.6404 -0.37736,-34.62013 -1.84906,0 -0.32075,-1.28079 -0.86793,0.10726 -1.64151,2.32144 -2.94151,-0.10726 -2.12452,2.2147 -2.23397,-1.12069 -1.79245,1.70772 -3.05094,0.85387 -1.90755,-0.37357 -0.71698,1.01396 -1.58491,-0.0539 0.10906,1.86783 -3.05094,0.37356 -2.39812,2.00124 -0.49056,1.17406 0.10905,1.1207 -2.12452,2.79373 -2.23397,1.01396 -2.39811,-0.80049 -1.03774,-1.17406 -2.99622,0 -1.64151,-1.49426 -1.03774,-2.00124 -1.47169,0.26683 -1.09434,1.60099 -1.64151,0.3202 -0.32076,-0.90723 0.32076,-0.58703 -1.30189,0 -1.84906,1.65436 -3.43207,0 -1.79246,-1.76109 -1.69811,-0.53367 -1.84905,0.0536 0.0543,-5.1045 7.19246,-4.77896 -8.2283,-16.04729 -0.49057,-1.86782 -1.35849,-1.76109 -1.03774,-0.58703 -0.49056,-1.38753 -0.1634,-2.29475 -1.64151,-1.81446 -0.16339,-0.69377 -2.45283,-1.06732 -8.17359,5.73689 -3.81509,-3.8077 -1.58491,5.84362 -14.65849,7.07906 -28.38906,-46.76312 -0.22641,-1.86783 -2.17925,-2.94049 6.10378,-3.15395 -1.18868,-2.71635 -6.82453,0.34688 -1.45283,0.69376 -11.92453,12.44505 -9.34528,8.92553 -13.01698,2.70301 -18.41887,4.29066 -12.86604,3.13261 0.15151,-10.47049 -0.30188,-4.33335 0.0909,-4.72026 0.84906,-11.75929 1.0566,-13.21619 -2.82264,-0.0857 -11.40943,2.7884 -11.17925,2.50822 -4.53774,1.01396 -0.6415,11.19894 0.81132,0.12862 1.5849,-0.50698 -0.5849,6.56673 -0.12132,1.97456 -2.54906,0.0859 -0.75472,11.84468 -0.50943,3.73298 -0.60378,8.88284 -0.24528,1.49426 -9.89245,2.32144 -3.55094,0.61371 -1.07548,-0.6404 -3.5283,-2.02792 -3.47924,-0.72045 -0.64151,16.20204 -16.85849,0.58704 0,7.91423 3.08679,0 0,0.82718 5.73396,0.88055 0.30189,6.37462" id="path9202"></path>
                   '
    ],
    'Изобильненский городской округ' => [
        'stav_izob',
        '     <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 183.38219,360.41508 -0.0785,7.50599 2.40377,-8e-4 -0.0611,2.40149 -2.38302,0.008 -0.28302,23.0783 0.10604,0.0873 -0.0253,0.20999 0.0549,0.059 0.22642,-0.11767 0.13886,0.0798 -0.0506,0.10087 -0.13642,0.17931 0.0604,0.19372 0.0862,-0.0408 0.0604,-0.21747 0.10208,-0.0443 0.13075,0.17771 0.13151,-0.0515 0.0474,0.11607 0.11,0.028 0.0172,0.29352 0.12717,0.0755 0.15321,-0.0691 0.26415,-0.24308 0.14,-0.0352 0.10113,0.0624 -0.004,0.25216 0.10944,-0.0208 0.22641,-0.004 0.16,0.20172 0.15585,0.0504 0.26415,-0.14275 0.12962,0.004 0.087,0.0582 0.013,0.15716 0.15547,-0.0816 0.1234,0.0923 0.14736,0 0.20755,0.3202 0.26415,0.0315 0.1449,0.29352 0.24529,0.0806 0.10773,0.12915 0.15906,0.0109 0.17509,0.25562 0.16717,0.059 0.12396,0.12675 0.32076,-0.007 0.0894,0.0734 0.13151,0.34689 0.13095,-10e-4 0.1266,0.10486 0.16358,-0.0616 0.11057,0.26683 0.10528,0.11554 0.16321,0.0526 0.49057,-0.16543 0.12887,0.12194 0.0715,0.23134 0.08,0.0883 0.26416,-0.0547 0.39622,0.6404 0.26415,0.18091 0.0589,0.3202 0.24528,0.13875 0.008,0.34688 0.30189,0.12755 -0.013,0.37357 0.0485,0.0566 0.18868,-0.0672 0.12661,0.0406 0.10358,0.40025 0.16962,-0.12114 0.0476,0.0523 -0.0483,0.12594 0.15358,0.019 0.0793,0.1705 0.24528,0.0438 0.0377,0.29352 0.10358,0.0608 0.12397,0.007 0.14132,0.19158 0.20754,0.0523 0.24529,0.3202 -0.14019,0.0883 0.28302,0.56035 0.0126,0.37356 0.0685,0.17878 0.0894,0.0264 0.13679,-0.24202 0.18868,0.0526 0.20755,0.26683 -0.0315,0.19985 -0.18415,0.063 -0.18868,0.19452 -0.0209,0.12114 0.11056,0.13662 -0.10773,0.18091 3.94905,-0.23695 -0.18867,-8.09035 14.30754,-0.0483 0,1.94787 12.0283,-0.19372 1.89057,0.34688 1.93962,2.37481 2.9434,2.05461 0.33962,-0.42694 11.18113,-0.56034 -0.24528,-10.2677 -1.98868,0 -0.49057,-6.63078 4.94717,-0.14515 -0.0972,-2.50823 1.4151,0.42694 1.41509,1.25411 0.28302,-6.67614 -3.39434,-0.29352 -1.01887,-0.90723 -0.5283,-4.40006 1.01887,-4.64021 2.95849,0.0483 1.93962,-1.92119 2.03774,0.37356 7.3717,4.64021 2.42453,0.9606 2.95849,-2.75638 1.30188,2.08129 4.60755,1.97456 13.8717,-3.09525 -0.43396,-8.84282 15.7132,-0.72044 0.24529,-4.78163 7.61509,-1.1207 0.43396,-3.33273 11.5434,-0.58703 0.097,-11.34036 5.48113,-0.53367 0.32076,-11.22295 -10.00378,-0.61372 -0.30188,-5.03779 -31.79132,-0.66708 -2.57925,-4.6829 -4.09057,-1.36084 0.39623,-3.22334 0.79245,-1.84114 -1.07547,-3.75166 -0.0443,-3.61824 1.77359,-3.1753 -0.0445,-1.68104 -6.80377,-8.15706 -1.86793,-1.84114 -0.5849,-0.40025 -2.97925,-1.68104 0.0889,-2.95383 -0.92453,0 0.26415,-5.41936 1.60377,-0.40025 2.40189,-3.12727 1.37736,-0.4803 0.58491,-1.06733 -0.1334,-1.14737 0.84906,-1.01397 1.1132,-0.0881 2.35661,-4.49078 1.33962,-1.06733 0.0445,-2.9485 -1.83019,0.4803 -1.20755,2.18802 -2.31132,2.45486 -3.37924,1.44089 -2.93397,-0.044 -0.39622,0.26417 -1.11321,0 -1.16981,-0.88055 -0.98113,-1.86782 -2.08491,-1.38753 -2.43207,-0.4803 -1.81132,-0.20626 -0.1168,-19.07315 -12.35094,0.14542 0.0491,18.90505 -17.05661,0.0486 -0.18868,10.38511 -8.08679,0.19425 0,-1.65436 -5.29245,-0.58703 0,-4.56283 -8.38113,0.34689 -0.43397,3.97846 0.14755,11.73528 2.41698,0.0648 0.26415,5.56878 -6.07547,-0.19425 0.32076,24.43381 -2.48302,0.0648 0.39622,25.0582 6.20566,-0.0651 0.52831,9.55259 3.30754,-0.80049 0.66038,1.33416 -0.33962,1.25411 0.41509,1.92119 -0.96226,2.66832 0.50943,4.9951 1.4151,2.08129 0.79245,0.96059 1.20755,0.45362 -27.78963,-0.3202" id="path9172"></path>
                   '
    ],
    'Грачевский муниципальный округ' => [
        'stav_grach',
        '      <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 332.66916,325.08759 3.88491,5.57412 6.32453,-0.56035 3.71887,4.06919 10.57547,-0.6404 0.73585,6.02507 10.6283,-0.26443 0.26415,-2.42817 3.66604,0.3202 0.053,6.50269 1.16981,3.54353 -1.49057,2.90847 2.28491,6.24387 -5.57925,0.4803 0,3.28204 -1.49057,2.00124 -0.47169,2.16134 0.15943,1.22742 -0.26415,0.8005 -2.6566,0.10593 -1.05661,1.4409 -1.16981,0.26496 -1.49056,1.06733 -2.65661,0 -4.09245,1.38753 -11.9566,-2.16134 -1.22642,0.90722 -0.64151,9.21905 -2.17924,1.49426 -1.75472,0 -4.35661,1.92119 0.053,3.12727 4.19812,-1.54762 1.75471,4.08253 1.81132,0.69376 -5.42075,2.26808 0,2.08129 -1.11321,0.42693 -1.0566,3.3434 4.67736,-0.37356 1.54717,0.80049 7.38679,10.93478 -0.96227,1.33416 5.31321,6.95898 2.65661,-0.96059 2.49811,-0.2655 4.83585,6.53739 -2.23208,3.45547 0.37736,5.58213 21.78736,-0.21267 16.95094,-0.10646 0.10623,16.86912 17.00566,0.2663 0.43396,-2.61496 16.15472,-0.53366 0.64151,3.35408 9.24717,0.21293 0.26415,-1.76109 -0.5283,-3.14061 1.5849,-1.4409 3.50755,0.15984 1.28302,2.34812 3.66603,2.82041 -0.47169,-5.74756 6.90754,0.26603 0.15944,-3.30071 9.24717,-0.26603 0.43396,-7.50065 -0.37736,-6.32659 -3.66604,-0.3202 -0.4717,-7.28185 5.95095,-0.0531 -0.15944,-3.18864 -5.47358,0 0.15943,-4.77896 -4.25094,-1.70773 -4.62264,1.49426 -8.76793,-2.34812 -0.5283,-1.06733 -14.29434,-1.12069 -0.053,-10.50785 9.24717,-0.42693 0.15944,-13.84058 -9.72453,0.15903 -0.69811,-4.34669 -7.43963,0.15876 -0.43396,-2.26807 -13.6566,-0.0531 0.79245,-35.82594 -7.65283,0.15876 -0.26415,-15.63636 -5.47358,-5.85963 -0.43397,-1.62767 1.81132,-6.0144 0.20755,-10.33707 -4.99434,2.0546 -1.0566,-26.12819 -9.24717,-0.2631 -1.05661,-1.68104 -2.08867,-1.04065 -1.09434,-1.12069 0.18868,9.2564 1.47169,27.64808 -10.76037,0.66708 0.13339,9.40583 -16.09622,-0.8005 -18.49623,0.13235 -0.39623,9.85144" id="path9174"></path>
                  '
    ],
    'Георгиевский городской округ' => [
        'stav_geord',
        '     <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" fill="#e6735c" stroke="#f2f2f2" d="m 535.22255,652.78805 0.4717,2.18803 2.09434,1.30747 3.3151,2.40149 0.18868,1.09401 -0.90566,1.1207 -1.52831,-0.58703 -0.71698,13.16016 23.69434,-0.26684 0.0762,2.7884 4.99056,-0.61372 0.22642,1.38753 4.07547,-0.45361 0,4.18392 1.67925,2.32144 1.1132,4.14657 -0.75471,1.1207 -1.39623,0.3202 3.54906,12.98671 3.01509,-3.13527 1.86793,-1.17406 3.15094,-4.03184 -6.83208,-11.21762 4.95472,-0.15743 1.84906,-0.85386 1.75471,-1.17406 0.60378,-1.22743 2.44528,-2.76705 1.24528,1.01396 3.19812,-4.36003 2.80566,-4.66956 3.67924,-4.87236 1.37736,1.36085 1.41509,-2.05461 1.4717,1.28079 2.01698,-2.82308 4.17925,3.765 2.61698,0.9606 2.21698,-0.20333 1.20755,-1.76109 1.33962,1.12069 3.68868,-5.35265 8.35849,5.5928 10.59434,-14.59571 3.61698,-3.50351 -10.90755,-8.31715 -2.71509,3.42879 -4.80943,-3.2847 -1.71699,1.12069 -14,-11.29767 0.4717,-2.94316 -1.09434,-1.68104 -1.81132,-0.58703 0.0953,-2.21471 14.66603,-0.048 3.47547,-1.12069 3.09434,-1.54763 1.81132,-1.25411 1.09434,-1.38752 0.84906,-1.97456 -1.66038,1.01396 -0.84905,-0.29351 -1.09434,-1.84115 -0.84906,-0.34688 -0.75472,0.4803 -0.33962,1.20075 -1.66038,-0.72045 0.18868,-19.22792 -5.8566,0.0483 -0.5283,-12.27695 1.37736,0.72045 1.15094,-0.24068 1.81132,-4.47478 -6.52453,-3.60757 3.47547,-8.80012 -11.66603,-5.28861 6.2566,-12.97604 -12.76981,-5.12852 2.37736,-5.06981 -21.44944,-9.52323 -9.50754,18.99577 -3.86981,-1.33416 -1.62265,3.83972 -4.10188,8.91219 -22.50698,0.74713 0.0526,7.00701 -0.88679,26.37902 -14.38114,-0.11981 -0.35849,19.34266 2.01132,0.23961 1.60378,-0.0598 1.24528,0.4803 4.67547,-0.23988 0.0591,3.29537 -3.13585,0.29352 -0.41509,3.41812 3.19622,-0.06 0,1.44089 3.7283,-0.0598 0.30189,1.92119 -1,0.53367 -1.89434,2.58827 -0.41509,4.01849 0.11849,24.13496" id="path9192"></path>
                   '
    ],
    'Будённовский муниципальный округ' => [
        'stav_buden',
        '     <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" fill="#e6735c" stroke="#f2f2f2" d="m 626.17085,451.66605 4.19812,3.37809 1.37736,-0.93391 12.76981,9.53391 4.03585,-3.6049 9.95094,8.53863 -19.07227,24.75668 6.68868,4.50145 0.16585,5.05914 -0.60377,2.40149 -1.54717,-0.3202 -4.58868,8.28513 -4.09057,10.96147 15.12642,6.67613 29.79641,15.01464 -0.94339,1.38753 -0.18868,1.57431 7.62075,-0.0496 0.73585,-2.82575 3.19623,-1.89451 2.16415,2.02792 0.9434,-1.20074 9.83396,4.70959 11.94717,9.17635 12.97735,11.35104 6.03019,-7.23649 -2.09811,-1.68104 6.90377,-7.93559 5.76793,6.17183 10.57547,-0.2647 0.79245,-1.84114 2.79623,0.69376 6.03019,-4.58417 0.35849,-1.49426 6.99245,-0.17638 4.10755,-3.43679 1.39622,2.29475 2.44717,0.0883 4.54529,8.37586 5.33207,-1.84114 5.99811,-43.4472 -14.88113,-9.9982 -21.75434,-16.7277 0.84906,-1.41421 -5.79434,-4.67756 4.7151,-7.52734 -0.28302,-11.28432 -3.29434,-2.56159 5.50943,-7.17512 -8.01698,-7.14576 -31.25962,-27.17311 6.33019,-6.7215 0.32075,-4.10921 -13.63962,-10.56122 -29.30189,-19.99372 -8.67924,10.8734 14.01509,11.20428 -4.24151,5.50741 -2.96792,-1.49425 -19.85962,23.52925 -0.56604,1.54762 -1.54717,-0.2124 -0.77359,-1.12069 -1.39622,0.19799 -0.79246,-1.25411 -1.13207,-0.45362 -2.54528,0.45362 -8.93397,14.60105 -2.6,-1.52094 -1.86792,2.88712 -11.30755,-8.7174 -11.64717,13.41898 6.89812,5.43804" id="path9158"></path>
                   '
    ],
    'Благодарненский городской округ' => [
        'stav_blag',
        '     <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 524.08048,418.75125 0.0543,-10.13695 -3.30755,-0.3202 -0.16264,-7.1511 -2.43962,0 0.26415,-19.48675 2.27736,-0.0542 -0.16264,-17.13862 1.89811,-0.74713 -0.16264,-2.05461 3.85094,-0.10806 -0.22641,-3.89041 10.73584,-0.16197 0.49057,-12.36233 30.7483,0.26683 -0.0664,-9.8461 17.93396,0.40025 0.60377,8.92019 4.58302,0 1.18868,-0.66708 11.82264,10.11827 11.15849,-12.96003 -1.32075,-1.52094 6.44339,-7.86088 -0.5283,-1.33416 1.13208,-1.33416 5.18113,3.16997 3.32075,-2.83909 13.21698,10.63592 2.65661,-3.23667 2.6566,1.92119 1.79245,-1.57431 -1.39622,-1.44089 3.65283,-4.69091 0.73585,-6.13981 1.5283,0 0.33962,-2.32144 12.88491,-0.53366 -0.1851,2.24139 11.16038,0.25936 0.18868,13.43233 -1.62264,0.45361 -10.24529,12.7946 -3.71886,-2.40149 -4.76415,4.80831 -7.76604,-6.69214 -14.42264,18.97976 17.2283,15.68172 6.26415,-7.68209 17.88113,13.47768 14.01509,11.20428 -4.24151,5.50742 -2.96792,-1.49426 -19.85962,23.52925 -0.56604,1.54763 -1.54717,-0.2124 -0.77358,-1.1207 -1.39623,0.19799 -0.79245,-1.25411 -1.13208,-0.45361 -2.54528,0.45361 -8.93396,14.60105 -2.6,-1.52094 -1.86793,2.88712 -11.30754,-8.7174 -11.64717,13.41898 6.89811,5.43804 -10.23396,12.52777 -40.87849,-33.9325 -13.00378,16.13533 -20.35433,-17.43747 -0.22642,-3.84772 -8.53774,-4.24263 0,-2.16134 -8.85471,0.0296" id="path9222"></path>
                   '
    ],
    'Арзгирский муниципальный округ' => [
        'stav_arzg',
        '     <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 667.45066,322.28318 -0.18509,2.24139 11.16038,0.25936 0.18868,13.43233 -1.62265,0.45361 -10.24528,12.7946 -3.71887,-2.40149 -4.76415,4.80831 -7.76603,-6.69214 -14.42265,18.97976 17.22831,15.68172 6.26415,-7.68209 17.88113,13.47769 8.67924,-10.87341 29.30189,19.99373 13.63962,10.56121 -0.32075,4.10921 -6.33019,6.7215 31.25962,27.17311 16.51132,-20.31926 0,-4.24263 9.59434,-22.82748 -9.00566,-3.90909 9.26792,-24.41514 25.06019,10.02222 23.82,-56.0753 8.02642,-10.95612 1.24528,-2.45486 3.97736,-5.53943 -1.45283,-1.09401 -1.03774,-1.2808 -0.24528,-1.12069 -0.18208,-0.0856 -2.09434,0.90722 -1.18868,0.56035 -1.20754,0.21454 -0.79246,0.50698 -0.43396,0.72044 -0.45283,0.2575 -0.33962,-0.29352 -0.35849,-0.6404 -1,-0.25749 -1.64151,-0.043 -0.66038,-0.34688 -0.50943,0.12861 -1.39623,0.17184 -0.81132,-0.0859 -0.90566,-0.61371 -1.15094,-0.0859 -1.43396,-0.37357 -0.69812,-0.61371 -0.54717,-0.42693 -0.73585,-0.34688 -0.30188,-0.61372 -0.81132,-0.21453 -0.50944,-0.56035 -0.81132,0.0427 -0.5849,-0.12862 -0.54717,0.12888 -1.24529,-0.56035 -1.20754,-0.50698 -0.0911,-0.37356 -1.39622,-0.37357 -4.00566,-0.77381 -3.88302,-1.46758 -1.66038,-0.69376 -1.69811,-0.34688 -1.28302,-0.69376 -2.63962,-1.97456 -0.64151,-0.17157 -1.18868,-0.82718 -0.75472,-0.12862 -0.88679,-1.14737 -0.66038,-1.20075 -0.20755,-1.25411 -0.49056,-0.90723 -0.81132,-1.33416 -0.96227,-1.33416 -0.39622,-0.25749 -0.60378,-0.0859 -1.45283,0.93391 -1.0566,0.34688 -0.45283,0.0859 -0.35849,0.50698 -0.26415,0 -0.35849,-0.37356 -0.26415,-0.4803 -0.1517,-0.17157 -0.15189,0 0,0.56034 -0.50943,0.2575 -0.66038,0 -0.84906,0.34688 -0.50943,-0.0427 0.26415,-0.61372 0.12132,-0.4803 -0.43396,-0.48029 -0.90566,-0.34689 -1.84906,-0.50698 -0.88679,-0.64039 -0.39623,0.0427 -0.33962,0.4803 -2.45849,1.81446 -0.75472,-0.12862 -1.15094,0 -0.90566,0.17158 -1.33962,-0.37357 -0.90566,-0.0859 -0.50944,-0.25749 -1.0566,-0.29352 -1.15095,-0.34688 -0.88679,-0.0856 -1.15094,-0.93391 -0.88679,-0.4803 -0.45283,-0.42693 -0.84906,-0.17158 -0.75472,-0.64039 -0.33962,0.12888 -0.43396,-0.12888 -0.9434,-0.69377 -1.43396,-0.82718 -0.69811,-0.37356 -2.88302,-2.13466 -2.15472,-1.46757 -0.20755,-0.56035 -0.60377,0.043 -0.60377,-0.25749 -1.28302,-0.6404 -0.54717,-0.4803 -0.0304,-0.82718 0.0302,-0.77381 -0.30189,-0.34688 -1,-0.2575 -0.50943,0 -0.60378,-0.043 -0.88679,0.61372 -0.79245,0.17184 -0.88679,-0.0859 -0.90566,0.17184 -1.33963,-0.50698 -0.64151,-0.21454 -0.54717,0.043 -0.43396,0.29352 -0.5849,-0.37357 -0.26415,-0.72044 -1.84906,-1.89451 -0.75472,-1.06733 -0.64151,-0.72045 -1.91132,-0.82717 -1,0 -0.73585,-0.69377 -0.0304,-0.50698 -2.19246,0.37357 -4.64905,-2.16134 0.60377,2.89246 1.26415,3.22333 -0.39623,0.80049 -1.39622,0.2631 -2.45849,-1.12069 -1.79245,0.13154 -0.92453,-0.98728 -1.32076,0.3202 -1.79245,-1.25411 -2.6566,-0.93391 -6.64151,0.45361 -2.65661,-1.97455 -2.72264,-0.98728 -2.59056,-0.0659 -1.39623,-0.66708 -1.58491,0.13155 -5.24717,-2.76171 -2.05849,0 -1.26415,-0.90723 -7.83773,0.40025 -3.52076,1.17406 -6.97358,1.12069 -0.4717,49.5822 -5.11509,0.13209 0.13301,11.21762" id="path9156"></path>
                   '
    ],
    'Андроповский муниципальный округ' => [
        'stav_androp',
        '    <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 355.20313,596.48969 5.51509,-18.34471 0.67925,-0.98727 2.11886,-1.41421 3.30566,-4.36538 -1.99245,-4.23729 -7.33207,-0.50698 -0.4151,-8.29848 -14.66415,-0.42693 -0.30189,-2.64164 -4.32264,-0.25669 0.16962,-3.03655 -8.9415,-2.42817 1.56603,-6.32392 -2.37358,-1.84114 -2.16038,-3.03388 0.64151,-1.76109 5.29811,-9.30711 4.44906,1.65436 2.33019,-5.93168 -1.22642,-0.64039 4.91698,-11.68725 -1.0566,-0.85386 2.20377,-5.07248 2.66982,1.41421 0.84905,-1.33416 5.76415,1.20075 2.71321,-8.60801 -1.5283,-0.29351 -4.40755,1.52094 -5.72075,-1.70772 0.92453,-1.73441 4.23773,1.44089 2.58491,-0.93391 2.28868,-0.17024 2.83962,0.17024 1.18868,-1.78778 4.02641,0.25563 -0.30188,1.62767 6.10188,-0.25562 1.26415,-7.75147 -0.16962,-1.33416 12.69057,-0.37357 -1.37736,-23.18237 -0.54717,-32.73869 16.95094,-0.10647 0.10623,16.86913 17.00566,0.26629 0.43396,-2.61495 16.15472,-0.53366 0.64151,3.35408 9.24717,0.21293 -0.15567,1.8945 -1.1132,1.17407 -1.37736,4.312 0.84906,1.38753 -0.37736,2.34812 -0.64151,0.74713 -1.49057,0.21293 -1.28302,-1.12069 -0.69811,0.2132 -1.69811,2.18802 0.79245,1.60099 0.69811,2.98318 0.69812,1.1207 1.16981,0.53366 1.86792,-1.06732 1.22642,0.15956 0.96226,0.9606 0.4717,2.45485 -0.43396,3.14328 0.79245,2.56159 -0.90566,4.90437 0.4717,2.24139 -0.90566,1.4409 3.39811,2.08129 11.46981,2.72168 -0.69811,3.73565 -0.0532,2.66832 -0.96226,1.4409 -3.82265,-1.01396 -8.44339,-4.10922 -1.81132,3.57555 -0.96227,1.06733 -3.02641,-1.54763 -0.32076,1.22743 -3.50377,-0.8005 -1.28302,3.84239 4.08868,1.92119 -0.37736,1.22743 0.15944,2.24138 2.86792,1.2808 -1.96415,5.23524 4.46038,2.18803 -1.16981,5.87831 11.73584,6.09444 -2.44339,4.65355 1.54717,1.33416 3.71698,1.4409 0.5283,16.80775 1.81132,0.3202 0.32076,6.48135 -2.65472,0.107 0.10604,8.94955 -1.96415,0.21426 0.43396,8.25845 0.96226,0.42694 -0.0532,0.85386 -2.01699,0.26683 0.15925,3.43413 -2.49623,1.60099 -0.84905,1.60099 -0.10623,15.78579 -16.62075,0.26683 -0.32076,7.3619 -8.8566,-3.74899 -5.25661,-2.26808 -0.22641,-0.50698 0.12434,-3.4955 0.15377,-0.82718 0.0374,-0.93391 0.10396,-0.3202 -0.22641,-0.22253 -0.5283,-0.14836 -0.67925,-0.61372 -0.88679,-0.56034 -1.83019,-0.6404 -1.15094,-0.3202 -0.0358,-4.23729 -8.16981,-0.005 -0.60378,0.13368 -0.33962,0.10887 -0.75472,0.12168 -0.24528,0.13902 -0.22642,0.29351 -0.35849,0.0603 -0.37735,0.22493 -0.0906,0.21587 0.0315,0.50698 -0.13245,0.42693 -0.10019,0.42694 0.0936,0.42693 0.18868,0.37356 0.0559,0.24415 0.0451,0.42693 0.11962,0.74713 -0.10736,0.72045 -0.35849,0.17478 -0.0924,0.15049 0.089,0.26683 0.005,0.18038 -0.26415,0.18865 -0.64151,0.66708 -0.43396,0.77381 -0.30189,0.98728 0.0255,0.3202 0.12094,0.25856 0.0196,0.1142 -0.30188,0.12408 -0.0449,0.11607 0.0525,0.12968 -0.0126,0.11528 -0.14528,0.005 -0.0602,0.14943 0.0462,0.45361 -0.1617,0.53367 -0.67925,0.37356 -8.17358,-0.0376 -4.97736,-0.11981 -0.17962,3.56488 0.0321,1.04064 -3.2,-0.6404 -0.33962,0.14196 -0.30189,0.2228 -0.62264,-0.0619 -6.98679,-0.34688 -0.49057,-0.0987 -0.10094,-0.12781 -0.0551,-0.21133 -0.32076,0.34688 -0.16132,0.005 -0.0379,-0.17904 -0.0787,-0.42693 -0.26415,-0.29352 -0.92453,-0.40024 -1.20755,-0.3202 -1.0566,-0.56035 -2.20755,-1.36084 -1.09434,-0.4803 -0.54717,-0.37357 -0.60377,-0.1601 -0.62265,-0.0117 -0.37735,0.0125 -0.77359,0.29352 -0.37736,0.0787 -0.32075,0.0107 -1.4717,-0.26203 -2.56604,-0.72045" id="path9168"></path>
                    '
    ],
    'Александровский муниципальный округ' => [
        'stav_aleskandr',
        '      <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" stroke="#f2f2f2" fill="#e6735c" d="m 440.22954,447.62701 0.26415,-1.76109 -0.5283,-3.14061 1.5849,-1.4409 3.50755,0.15984 1.28302,2.34812 3.66604,2.82041 -0.4717,-5.74756 6.90755,0.26603 0.15943,-3.30071 9.24717,-0.26603 0.43396,-7.50065 14.81321,0.29351 0.26415,-2.3748 10.79057,0 0.60377,-1.78778 5.36792,0 0.1083,-4.93639 25.59397,-0.10833 0.26415,-2.37481 8.85471,-0.0296 0,2.16134 8.53774,4.24263 0.22641,3.84772 -3.6566,3.01787 -7.41509,8.73875 2.52453,1.30748 -3.15472,3.31939 -3.99623,-2.21471 -11.09622,14.43829 -6.25849,1.94787 4.15471,9.07229 4.10189,-0.85386 0.79245,4.01048 2.83962,1.36085 8.72831,-4.69625 2.3132,-1.7344 2.63019,1.52094 2.15661,0.80049 2.68113,0.0528 0.41509,3.48216 -6.1,1.84114 -1.94528,1.46757 -5.20566,1.52095 -1.32076,-0.85387 -3.99622,0.58703 -2.99811,1.22743 1.35849,3.1166 -0.62265,1.41421 8.15095,3.90909 -1.62264,4.54415 5.73207,2.42817 3.52264,2.05461 20.71887,9.67533 -1.11321,2.05461 3.99623,1.52094 -3.15472,6.50803 2.10378,0.9606 -3.31321,7.99429 1.26415,1.70772 -1.20755,4.13056 1.99811,1.49426 -1.47169,3.6556 5.52075,2.48154 -1.4717,2.86311 3.9434,0.85386 -1.26415,5.03779 6.36226,1.81446 -4.10188,8.91219 -22.50698,0.74713 0.0526,7.00701 -8.46604,0.3202 -6.78302,-0.53367 -0.58491,-14.16878 -5.83773,-1.70772 -0.88679,3.28737 -3.99623,1.06733 -3.07924,0.23934 -0.50944,-0.34688 -0.35849,0.40025 -3.93019,-0.0544 -4.2,1.41421 0.9434,-3.55954 -13.06604,-2.70568 1.4151,-5.09116 -13.56793,-5.72354 -0.54717,1.12069 -1.67924,-0.88055 -0.92453,2.92448 -8.3717,-2.75637 -1.97736,-1.22743 -3.32264,-0.37356 -4.16415,-1.38753 -3.19623,-2.10797 -1.88679,-0.98728 -3.71698,-1.4409 -1.54717,-1.33416 2.4434,-4.65355 -11.73585,-6.09444 1.16981,-5.87831 -4.46038,-2.18802 1.96415,-5.23525 -2.86792,-1.28079 -0.15944,-2.24139 0.37736,-1.22743 -4.08868,-1.92119 1.28302,-3.84238 3.50378,0.80049 0.32075,-1.22743 3.02642,1.54763 0.96226,-1.06733 1.81132,-3.57555 8.4434,4.10922 3.82264,1.01396 0.96226,-1.44089 0.0532,-2.66833 0.69811,-3.73564 -11.46981,-2.72169 -3.39811,-2.08129 0.90566,-1.44089 -0.4717,-2.24139 0.90566,-4.90438 -0.79245,-2.56159 0.43396,-3.14328 -0.4717,-2.45485 -0.96226,-0.9606 -1.22642,-0.15956 -1.86792,1.06733 -1.16981,-0.53367 -0.69812,-1.12069 -0.69811,-2.98319 -0.79245,-1.60099 1.69811,-2.18802 0.69811,-0.2132 1.28302,1.12069 1.49057,-0.21293 0.64151,-0.74713 0.37736,-2.34812 -0.84906,-1.38753 1.37736,-4.312 1.11321,-1.17406 0.15566,-1.89451" id="path9176"></path>
                  '
    ],
    'Предгорный муниципальный район' => [
        'stav_pred',
        '     <path style="fill: rgb(230, 115, 92); stroke: rgba(242, 242, 242, 0.95); stroke-width: 1px;" fill="#e6735c" stroke="#f2f2f2" d="m 529.18972,659.47967 -5.17924,3.99181 -4.24906,2.32143 -4.60754,3.14329 -0.014,3.8237 -1.64151,0.58703 0.26416,1.30748 3.04339,-0.4803 1.45283,3.67161 -1.69811,0.88055 -0.98113,1.5743 -4.12642,4.09321 -2.63019,0.42693 -0.62264,-3.82904 -11.60566,-0.77381 -0.10321,-2.10798 -0.86792,-1.20074 -3.35283,0 -4.69434,-2.45486 0.86792,-0.53366 0.77359,-2.16134 -1.84906,-0.0523 -0.50943,-2.21471 1.54717,-0.64039 1.03773,-1.25411 2.01132,-0.15717 0.77359,-1.84114 1.24528,-0.93391 2.23396,-0.53366 -0.22641,-1.54763 -0.88679,-0.8005 -3.60566,-0.18785 -1.66038,-0.23508 0.69811,-1.7344 -1.0566,-1.2808 -1.11321,0 -1.75472,0.8005 -2.10377,-0.29352 -0.11566,-1.12069 -2.31132,0.23481 -3.8717,-3.69829 0.22642,-1.17406 4.33396,0.82718 0.98113,-2.05461 4.45094,0.29351 0,-1.12069 1.79246,-0.23455 0.86792,-0.111 0.90566,0.42693 0.84906,0.69377 -0.28302,1.62767 1.0566,1.78778 0.64151,0.93391 0.39623,0.93391 0.69811,-1.81446 -1.15094,-1.20074 -0.62264,-1.52094 0.83019,-1.14738 -4.24717,-1.97456 0.79245,-6.89761 0.77358,-0.80049 3.1151,-0.93392 3.07547,1.9212 1.67925,0.45361 0.77358,-2.95116 2.35283,-1.25411 c -0.0159,-1.25411 -0.0315,-2.53491 -0.0474,-3.79436 -0.43396,-0.26683 -0.86792,-0.56034 -1.30188,-0.82718 -0.86793,-0.111 -1.75472,-0.22227 -2.63019,-0.32019 -0.71698,0.56034 -1.45283,1.12069 -2.17736,1.68104 -1.77359,-0.45362 -3.5283,-0.93391 -5.30189,-1.38753 -0.16981,-0.90723 -0.35849,-1.81446 -0.5283,-2.71902 0,-0.88054 0,-1.73441 0,-2.61495 -1.0566,-0.13342 -2.11509,-0.29352 -3.1717,-0.42693 -0.15094,-0.98728 -0.28302,-1.94788 -0.43396,-2.92715 -1.18868,-0.34688 -2.36226,-0.66708 -3.55094,-1.01396 -0.15095,0.40025 -0.33963,0.80049 -0.4717,1.22742 0.0311,1.601 0.0626,3.21533 0.0942,4.81632 -1.22642,0.24015 -2.43585,0.50698 -3.66226,0.72045 -0.92453,0.047 -1.84906,0.0939 -2.77548,0.14089 -0.35849,0.61371 -0.71698,1.22743 -1.09434,1.81446 -0.94339,0.42693 -1.89811,0.85386 -2.84151,1.30747 -0.69811,-0.42693 -1.39622,-0.82718 -2.07169,-1.28079 -2.02453,-1.78778 -4.04717,-3.6049 -6.0717,-5.39268 -1.37736,3.88775 -2.74151,7.77816 -4.11887,11.6659 -4.8283,-1.78777 -9.65849,-3.59156 -14.48679,-5.37933 0.0789,-1.4409 0.15792,-2.87912 0.24528,-4.32001 -0.43396,-0.0961 -0.88679,-0.19212 -1.32075,-0.29352 0.0947,-1.89451 0.18868,-3.8157 0.28302,-5.71021 0.33962,-0.032 0.69811,-0.0638 1.03773,-0.0958 -0.0315,-1.09401 -0.0632,-2.18802 -0.0947,-3.26336 -5.46037,-0.0958 -10.92075,-0.19185 -16.38113,-0.29351 -0.033,-5.05647 -0.066,-10.11294 -0.099,-15.17207 -2.95283,-1.25411 -5.90566,-2.50822 -8.85661,-3.74899 0.0381,1.94787 0.0923,3.88507 0.12038,5.80626 -0.0462,0.3202 -0.14528,0.6404 -0.15698,0.98728 0.08,1.52094 0.16019,3.03121 0.24528,4.52547 -3.55471,0.0299 -7.10943,0.06 -10.66226,0.0899 -0.0421,3.09792 -0.0698,6.19851 -0.14925,9.29643 -0.0202,0.93391 -0.0404,1.86782 -0.0606,2.79373 -1.37736,-0.0181 -2.75095,-0.0366 -4.1283,-0.0547 -0.20755,-0.0934 -0.4151,-0.23055 -0.62265,-0.18332 -1.26415,10e-4 -2.52452,0.0259 -3.78868,0.0123 -0.32075,-0.0248 -0.62264,-0.0494 -0.94339,-0.0739 -0.0594,0.88055 -0.11887,1.78778 -0.1783,2.66833 -0.9434,-0.0459 -1.89057,-0.0555 -2.83397,-0.12755 -0.41509,-0.095 -0.86792,-0.22467 -1.28301,0.0307 -0.22642,0.0801 -0.43397,0.26683 -0.54717,0.56034 -0.18868,0.42693 -0.33963,0.90723 -0.56604,1.30748 -0.20755,0.34688 -0.56604,0.42693 -0.83019,0.61371 -0.20755,0.21347 -0.32076,0.6404 -0.26415,0.98728 0.11207,0.26683 0.20755,0.56035 0.16622,0.85387 -0.0377,0.32019 0.28302,0.34688 0.33963,0.58703 0.0257,0.18678 -0.10623,0.42693 0.0126,0.58703 0.13207,0.18678 0.28302,0.34688 0.41509,0.53366 -0.43396,-0.21347 -0.84905,-0.45361 -1.28302,-0.6404 -0.62264,-0.1601 -1.26415,-0.3202 -1.88867,-0.45361 -0.4151,-0.0382 -0.81133,-0.0766 -1.22642,-0.11474 -0.22641,-0.26683 -0.45283,-0.56035 -0.69811,-0.8005 -0.30189,-0.18678 -0.62264,-0.34688 -0.92453,-0.53366 0.0706,2.99919 0.14056,5.99572 0.20755,8.99491 -3.93963,0.028 -7.87925,0.056 -11.82076,0.084 0.0189,0.90723 0.0904,1.84114 0.034,2.75371 -0.0134,0.37356 -0.0272,0.77381 -0.0406,1.14738 -2.73774,1.86782 -5.47547,3.73031 -8.21132,5.59813 1.03773,1.62768 2.06415,3.28737 3.10188,4.91505 -0.77358,0.6404 -1.54717,1.28079 -2.32075,1.92119 -0.43396,0.53367 -0.88679,1.01396 -1.33962,1.49426 -0.24529,0.24015 -0.49057,0.53366 -0.73585,0.77381 -0.20755,0.0862 -0.4151,0.17238 -0.62264,0.25856 -0.008,0.50698 0.16528,1.01397 0.0594,1.52095 -0.15094,0.45361 -0.32075,0.88054 -0.43396,1.33416 -0.0632,0.58703 -0.20755,1.20074 -0.15906,1.78777 0.0943,0.4803 0.18868,0.93391 0.30189,1.38753 -0.0389,0.34688 -0.094,0.69376 -0.20755,1.01396 -0.16981,0.53366 -0.30189,1.09401 -0.4717,1.60099 -0.20754,0.26684 -0.4717,0.45362 -0.71698,0.61372 -0.62264,0.42693 -1.28302,0.72044 -1.90566,1.12069 -0.41509,0.3202 -0.86792,0.58703 -1.26415,0.98728 -0.1566,0.1601 -0.17755,0.42693 -0.15585,0.66708 0.003,0.18678 0.0458,0.40025 -0.0685,0.56035 -0.0943,0.26683 -0.32075,0.34688 -0.4717,0.53366 -0.15509,0.10673 -0.13622,0.37357 -0.20754,0.58703 -0.11321,0.53367 -0.28302,1.01396 -0.33963,1.54763 0.0566,0.37356 0.28302,0.61371 0.43397,0.93391 0.28301,0.50698 0.60377,0.9606 0.92452,1.41421 0.22642,0.21347 0.45283,0.58703 0.75472,0.53366 0.43396,-0.0299 0.86792,-0.13154 1.30189,-0.22467 0.28302,-0.0728 0.56603,-0.20492 0.84905,-0.24041 0.15095,0.0104 0.26415,0.063 0.37736,0.21079 0.18868,0.13342 0.26415,0.45362 0.39623,0.69377 0.22641,0.22947 0.50943,0.40025 0.79245,0.37356 0.28302,0.0608 0.58491,-0.0678 0.86793,-0.12968 0.15094,-0.0704 0.33962,-0.23668 0.49056,-0.06 0.45283,0.29352 0.92453,0.61372 1.4151,0.85387 0.32075,-0.0326 0.66037,-0.0216 0.98113,-0.0811 0.24528,-0.24015 0.50943,-0.50698 0.71698,-0.82718 0.16981,-0.21346 0.32075,-0.4803 0.43396,-0.74713 0.10245,-0.18678 0.16566,-0.40025 0.17396,-0.61371 0.0394,-0.24015 0.063,-0.4803 0.008,-0.74713 -0.017,-0.1601 -0.0526,-0.45362 0.0417,-0.50698 0.47169,-0.079 0.94339,-0.15823 1.41509,-0.23722 0.50943,1.97456 1.0566,3.93311 1.5283,5.93435 0.24528,1.01396 0.49057,2.0546 0.75472,3.0659 0.0189,0.21773 -0.11189,0.3202 -0.22642,0.42693 -0.1366,0.13342 -0.33962,0.29352 -0.26415,0.56035 0.0377,0.15823 0.17755,0.26523 0.30189,0.26683 0.50943,0.18251 1.01887,0.3202 1.54717,0.3202 0.24528,0.0801 0.54717,0.0534 0.71698,0.37356 0.0189,0.22814 -0.16755,0.29352 -0.28302,0.3202 -0.12528,0.0267 -0.32075,0.075 -0.28302,0.3202 0.0377,0.34688 -0.18868,0.53366 -0.37736,0.6404 -0.32075,0.26683 -0.69811,0.40024 -1.07547,0.50698 -0.10981,0.0267 -0.30188,0.12941 -0.22641,0.34688 0.0377,0.21346 0.28302,0.24895 0.24528,0.4803 -0.0943,0.3202 -0.37736,0.40024 -0.54717,0.61371 -0.11924,0.11687 -0.0364,0.34688 0.0883,0.37357 0.11321,0.075 0.26415,0.051 0.32076,0.24975 0.0862,0.1601 0.16188,0.3202 0.11019,0.50698 -0.008,0.3202 -0.14302,0.66708 -0.003,0.9606 0.0755,0.26683 0.22641,0.45361 0.35849,0.64039 0.20754,0.21347 0.45283,0.40025 0.69811,0.56035 0.49057,0.0862 0.98113,0.0715 1.4717,0.0328 0.37736,-0.0734 0.77358,-0.19185 1.15094,-0.0846 0.4151,0.0464 0.84906,0.006 1.26415,-0.0777 0.22642,-0.0534 0.43397,-0.24629 0.62264,-0.42693 0.18868,-0.29352 0.39623,-0.58703 0.66038,-0.74713 0.28302,-0.19693 0.58491,-0.34689 0.88679,-0.40025 0.24529,0.003 0.49057,0.003 0.75472,-0.0259 0.16981,0.13341 0.24528,0.48029 0.4717,0.42693 0.20755,0.016 0.45283,-0.14436 0.64151,0.0315 0.11755,0.1601 0.22641,0.34688 0.28302,0.58703 0.13905,0.16411 0.20754,-0.0301 0.26415,-0.18278 0.0943,-0.20412 0.22641,-0.34688 0.39622,-0.45361 0.28302,-0.0958 0.60378,-0.0856 0.8868,0.0608 0.11113,0.13341 0.1166,0.37356 -0.0291,0.45361 -0.16981,0.20626 -0.43396,0.18758 -0.58491,0.42693 0,0.19692 0.20755,0.22174 0.32076,0.23748 0.35849,0.0899 0.73585,-0.0331 1.09434,0.0451 0.32075,-0.0245 0.69811,0.0534 0.96226,-0.26683 0.0942,-0.14383 0.24529,-0.14223 0.33963,-0.0192 0.20754,0.21347 0.37735,0.56035 0.64151,0.66708 0.12867,0.0267 0.28301,-0.0654 0.22641,-0.26683 -0.0968,-0.10673 -0.17887,-0.3202 -0.06,-0.4803 0.15094,-0.17717 0.35849,-0.17237 0.5283,-0.15636 0.20755,-0.0267 0.37736,0.18652 0.56604,0.3202 0.20755,0.3202 0.39623,0.66708 0.62264,0.96059 0.11321,0.11661 0.33962,-0.007 0.32076,-0.23027 -0.026,-0.24015 -0.14604,-0.42693 -0.12812,-0.66708 -0.0292,-0.26683 -0.0162,-0.58703 0.13321,-0.77381 0.13208,-0.12462 0.28302,0.0699 0.41509,0.10246 0.18868,0.0801 0.30189,0.34688 0.45284,0.50698 0.16981,0.24015 0.41509,0.34688 0.50943,0.66708 -0.0372,0.24015 -0.12491,0.53366 -0.0364,0.77381 0.11321,0.11047 0.24529,0.206 0.37736,0.14356 0.22642,-0.0534 0.50944,-0.10673 0.64151,-0.40025 0.0977,-0.13342 0.1334,-0.37356 0.0689,-0.56035 -0.0476,-0.29351 -0.14208,-0.58703 -0.16075,-0.88054 -0.0189,-0.20093 0.10962,-0.34688 0.24528,-0.34688 0.15094,-0.0291 0.28302,0.006 0.41509,0.1142 0.54717,0.34688 1.07547,0.66708 1.62264,0.98728 0.11378,0.18678 0.0855,0.42693 0.0838,0.6404 -0.0253,0.21346 -0.14906,0.48029 -0.0596,0.69376 0.0755,0.13502 0.22642,0.20946 0.33963,0.13662 0.18868,-0.17371 0.41509,-0.26684 0.62264,-0.34688 0.20755,-0.0254 0.43396,-0.0963 0.64151,0.0216 0.22641,0.0547 0.4717,0.23001 0.69811,0.13528 0.17396,-0.18678 0.26415,-0.50698 0.24528,-0.82718 -0.0189,-0.29351 0.1668,-0.48029 0.24529,-0.74713 0.16981,-0.3202 0.26415,-0.72044 0.35849,-1.09401 0.0438,-0.18678 0.0707,-0.37356 -0.0604,-0.50698 -0.0755,-0.19239 -0.26415,-0.0723 -0.37736,-0.11154 -0.4717,-0.0224 -0.96226,-0.007 -1.43396,-0.0536 -0.26415,-0.0672 -0.5283,-0.13528 -0.79245,-0.20306 -0.005,-0.21346 -0.0925,-0.37356 -0.18868,-0.50698 -0.15925,-0.18678 -0.11434,-0.50698 -0.16528,-0.74713 -0.0415,-0.29351 -0.0262,-0.61371 -0.17491,-0.85386 -0.14038,-0.3202 -0.30189,-0.66708 -0.28302,-1.06733 0.13208,-0.58703 0.35849,-1.12069 0.54717,-1.65436 0.0938,-0.58703 0.0351,-1.22743 0.0509,-1.81446 0.0277,-0.42693 -0.18339,-0.80049 -0.12302,-1.22742 -9.4e-4,-0.29352 0.0185,-0.58703 0.10321,-0.85387 0.0415,-0.21346 0.0862,-0.42693 0.22642,-0.53366 0.16981,-0.26683 0.41509,-0.34688 0.64151,-0.50698 0.30188,-0.18678 0.5849,-0.42693 0.90566,-0.50698 0.41509,-0.1601 0.84905,-0.29352 1.26415,-0.50698 0.30188,-0.1601 0.54717,-0.50698 0.81132,-0.77382 0.16981,-0.18678 0.30189,-0.45361 0.41509,-0.69376 1.35849,0.003 2.73963,0.0296 4.09812,0.0173 0.94339,-0.0539 1.9,-0.14062 2.84339,-0.17344 2.83962,0.0539 5.67736,0.1078 8.51698,0.1617 -0.22641,0.61372 -0.5283,1.14738 -0.79245,1.73441 -0.0645,0.21347 -0.0709,0.42693 -0.037,0.6404 0.0828,0.66708 0.0142,1.30748 0.01,1.97456 -0.024,0.72044 -0.0253,1.44089 -0.0634,2.16134 -0.15094,0.45361 -0.30188,0.88054 -0.43396,1.33416 -0.0121,1.52094 -0.0353,3.05522 -0.0408,4.57617 0.0685,0.48029 0.11245,0.98728 0.18868,1.46757 0.0755,0.17558 0.16905,0.3202 0.32075,0.37357 0.30189,0.17477 0.60377,0.29351 0.92453,0.40025 1.54717,-0.0235 3.11132,-0.028 4.65849,-0.0635 0.96226,-0.18678 1.91887,-0.34688 2.88113,-0.53366 0.15094,1.92119 0.28302,3.86372 0.43396,5.78492 -0.39622,-0.0867 -0.81132,-0.17318 -1.20754,-0.25963 -0.044,0.72044 -0.0881,1.44089 -0.13208,2.13465 0.54717,0.0264 1.09434,-0.0232 1.62264,0.22228 0.43396,0.18091 0.90566,0.29351 1.35849,0.29351 0.33963,0.0254 0.69812,0 0.98113,0.26683 0.24529,0.1641 0.49057,0.42693 0.77359,0.3202 0.26415,-0.0536 0.39623,0.34688 0.64151,0.42693 0.16981,0.12755 0.35849,0.18545 0.56604,0.19212 0.28302,0.0347 0.54717,0.26683 0.84905,0.20119 0.26415,-0.0304 0.52831,0.005 0.79246,0.0459 0.13471,0.26683 0.18377,0.56035 0.22641,0.88054 -0.0943,0.18679 -0.17887,0.37357 -0.33962,0.45362 -0.39623,0.3202 -0.79245,0.6404 -1.16981,0.98728 -0.15095,0.26683 -0.32076,0.53366 -0.4151,0.88054 -0.26415,0.8005 -0.50943,1.62768 -0.77358,2.42817 -0.43396,-0.12914 -0.88679,-0.24175 -1.32076,-0.32019 -0.0606,2.24139 -0.12113,4.45342 -0.18169,6.69481 -0.37736,0.1601 -0.75472,0.40025 -1.16982,0.45362 -0.30188,0.0766 -0.60377,-0.0304 -0.90566,-0.0352 -0.0602,0.0534 0.14076,0.29351 0.1851,0.40024 1.62264,2.9485 3.26792,5.89966 4.89056,8.84816 -0.41509,0.34688 -0.77358,0.80049 -1.15094,1.20074 -0.28302,0.3202 -0.58491,0.6404 -0.9434,0.74713 -0.15094,0.0536 -0.32075,0.0822 -0.41509,0.26176 -0.15094,0.13342 -0.24528,0.40025 -0.41509,0.4803 0.13207,0.37356 0.28301,0.74713 0.43396,1.12069 0.066,0.21347 0.14566,0.42694 0.10924,0.66708 -0.0345,0.1601 -0.11396,0.29352 -0.1649,0.45362 0.18868,0.34688 0.39622,0.66708 0.56604,1.04064 0.16056,0.50698 0.16754,1.09402 0.32075,1.601 0.0943,0.40024 0.32075,0.74713 0.54717,1.01396 0.33962,0.29351 0.69811,0.53366 0.98113,0.93391 0.35849,0.45361 0.75472,0.85386 1.09434,1.33416 0.13208,0.007 0.26415,0.0144 0.39623,0.0216 0.0377,-0.20065 0.17924,-0.23748 0.30188,-0.26683 0.16982,8e-4 0.33963,0.0488 0.49057,0.1633 0.35849,-0.0139 0.71698,-0.13448 1.07547,-0.032 0.16981,0.13342 0.35849,0.22681 0.45283,0.4803 0.20755,0.42693 0.43396,0.82718 0.69812,1.17406 0.26415,-0.12327 0.50943,-0.3202 0.77358,-0.3202 0.30189,-0.0261 0.62264,-0.067 0.90566,-0.19638 0.4717,-0.14436 0.9434,-0.37357 1.4151,-0.40025 0.26415,-0.044 0.5283,-0.0184 0.75471,-0.20626 0.24528,-0.12115 0.4717,-0.34689 0.71698,-0.29352 0.24529,-0.0333 0.49057,8e-4 0.71698,-0.075 0.62265,-0.29351 1.22642,-0.6404 1.84906,-0.90723 0.20755,0.0216 0.4151,-0.002 0.62264,0.0467 0.11321,0.107 0.20755,0.25055 0.33962,0.17451 0.4717,-0.075 0.92453,-0.10487 1.39623,-0.18625 0.22642,-0.0544 0.45283,-0.14916 0.66038,-0.17878 0.73585,0.29351 1.4717,0.6404 2.22453,0.93391 0.33962,0.10673 0.69811,0.18758 1.01886,0.42693 0.22642,0.12701 0.43397,0.29352 0.69812,0.29352 0.22641,0.0363 0.4717,0.0171 0.66038,0.18438 0.33962,0.18678 0.66037,0.40025 1.01886,0.4803 0.24529,0.14142 0.50944,0.006 0.77359,-0.0184 0.43396,-0.10007 0.86792,-0.0275 1.28302,-0.0203 0.45283,0.11527 0.88679,0.26683 1.33962,0.26683 0.15094,-0.007 0.30189,0.0315 0.43396,0.15583 0.24528,0.1601 0.49057,0.37356 0.75472,0.50698 0.5283,0.0723 1.07547,0.21106 1.60377,0.17504 0.22642,-0.0112 0.45283,0.0224 0.67925,-0.0168 0.11321,-0.13342 0.22641,-0.19826 0.35849,-0.14782 0.26415,-0.0267 0.45283,0.32019 0.73585,0.32019 0.26415,0.0595 0.54717,0.0865 0.81132,0.16571 0.28302,0.24015 0.56604,0.50698 0.84905,0.72044 0.26416,0.0979 0.54717,0.24842 0.81133,0.3202 0.30188,-0.0101 0.62264,-0.0598 0.92452,-0.0443 0.13208,0.0718 0.26415,0.23694 0.4151,0.25135 0.60377,-0.0907 1.18868,-0.24522 1.79245,-0.26496 0.11321,0.0598 0.22642,0.22334 0.35849,0.0798 0.11094,-0.0747 0.10359,-0.40025 0.26415,-0.3202 0.13208,0.0254 0.28302,-0.047 0.33962,0.17078 0.0566,0.19905 0.15906,0.29351 0.30189,0.21319 0.30189,-0.0456 0.62264,-0.11367 0.92453,-0.0675 0.20755,0.056 0.39623,0.13421 0.60377,0.0566 0.37736,-0.0667 0.73585,-0.13368 1.11321,-0.20039 0.0381,-0.56034 0.0983,-1.12069 0.12264,-1.65435 -0.0334,-0.18679 -0.11924,-0.40025 -0.0325,-0.58704 0.0598,-0.24014 0.13094,-0.48029 0.0923,-0.74713 -0.0824,-2.42817 -0.16471,-4.87235 -0.24528,-7.30052 0.5283,-0.24015 1.03774,-0.50698 1.56604,-0.6404 0.30189,-0.0937 0.60377,-0.14595 0.86792,-0.34688 0.16981,-0.13261 0.39623,-0.20626 0.54717,-0.37356 0.0943,-0.18679 0.24529,-0.37357 0.32076,-0.58703 5.6e-4,-0.42694 -0.0298,-0.85387 -0.01,-1.2808 0.12302,-0.1601 0.0781,-0.3202 -0.0315,-0.4803 -0.0942,-0.21346 -0.22642,-0.40024 -0.30189,-0.61371 -0.0249,-0.3202 0.0309,-0.6404 -0.1066,-0.90723 -0.0941,-0.3202 -0.32076,-0.4803 -0.45283,-0.74713 -0.0838,-0.40025 -0.16736,-0.8005 -0.24529,-1.20074 3.32076,0.18678 6.63963,0.37356 9.96038,0.58703 0.35849,-0.45362 0.69811,-0.98728 1.11321,-1.33416 0.18868,-0.17958 0.41509,-0.18545 0.62264,-0.29352 0.45283,-0.18678 0.90566,-0.34688 1.37736,-0.53366 0.18868,-0.26683 0.43396,-0.4803 0.54717,-0.82718 0.13207,-0.3202 0.28302,-0.66708 0.50943,-0.85386 0.32076,-0.18679 0.64151,-0.37357 0.92453,-0.66708 0.30189,-0.24015 0.5283,-0.6404 0.81132,-0.9606 0.30189,-0.37357 0.60377,-0.8005 0.92453,-1.14738 0.39623,-0.26683 0.79245,-0.61371 1.22641,-0.80049 0.49057,-0.21347 0.98114,-0.50699 1.4151,-0.90723 0.16981,-0.12888 0.32075,-0.34689 0.5283,-0.3202 0.66038,-0.0833 1.32076,-0.22387 1.99245,-0.29352 1.05661,0.10647 2.11321,0.23748 3.16981,0.3202 0.62265,-0.008 1.22642,0.0149 1.84906,-0.0117 0.64151,-0.1601 1.28302,-0.37356 1.9283,-0.50698 0.30189,-0.0107 0.60378,-0.0558 0.90566,-0.0454 0.37736,0.21346 0.73585,0.42693 1.11321,0.61371 0.32076,-0.0101 0.62264,-0.115 0.9434,0.0139 0.20754,0.0464 0.41509,0.15743 0.62264,0.0568 0.39623,-0.0928 0.77358,-0.19078 1.15094,-0.3202 0.30189,0.13342 0.58491,0.29352 0.88679,0.40025 0.45283,-0.10673 0.92453,-0.20279 1.37736,-0.40025 0.28302,-0.0969 0.54717,-0.24388 0.83019,-0.32019 0.58491,0.032 1.16981,0.0654 1.75472,0.0883 0.20755,0.21346 0.41509,0.45361 0.64151,0.64039 0.32075,8e-4 0.64151,-0.008 0.94339,0.12115 0.16982,-0.0614 0.33963,-0.17078 0.50944,-0.20386 0.13207,0.0619 0.24528,0.10833 0.37736,0.0221 0.26415,-0.0947 0.5283,-0.22494 0.79245,-0.18171 0.16981,0.0152 0.37736,-0.0656 0.50943,0.13182 0.13208,0.14569 0.28302,0.24948 0.45283,0.26683 0.37736,0.1166 0.77359,0.20919 1.16981,0.29351 0.18868,-0.0211 0.3585,0.0104 0.52831,0.12568 0.24528,0.15983 0.54717,0.0905 0.81132,0.13982 0.24528,2.7e-4 0.4717,-0.14355 0.71698,-0.20119 0.18868,-0.0512 0.37736,-0.20973 0.56604,-0.12808 0.16981,0.051 0.32075,0.0208 0.49056,-0.0592 0.22642,-0.1166 0.4717,0.0117 0.71698,0.028 0.54717,0.0878 1.07548,0.23268 1.62264,0.1625 0.26416,-0.0712 0.4717,0.3202 0.75472,0.22227 0.13208,-8e-4 0.28302,-0.003 0.37736,-0.14409 0.13208,-0.111 0.24528,-0.25669 0.41509,-0.2188 0.73585,-0.0374 1.49057,0.012 2.22831,0.0101 0.20754,0.08 0.0683,-0.21667 0.0538,-0.37356 -0.45283,-2.34813 -0.90566,-4.66423 -1.35849,-7.01235 0.0845,-0.1601 0.20755,-0.29352 0.18321,-0.50698 0.0211,-0.18678 0.002,-0.40025 0.0464,-0.56035 0.11321,-0.18678 0.32076,-0.3202 0.32076,-0.58703 0.0517,-0.1601 0.01,-0.42693 0.13264,-0.50698 0.33962,-0.24015 0.71698,-0.40025 1.07547,-0.61371 0.11321,-0.1601 0.28302,-0.26684 0.37736,-0.45362 0.0558,-0.1601 0.0785,-0.37356 0.15358,-0.50698 0.20755,-0.13715 0.39623,-0.26683 0.60378,-0.40025 -0.66038,-0.85386 -1.32076,-1.70772 -1.99246,-2.58827 0.006,-0.3202 -0.0453,-0.6404 3.8e-4,-0.96059 0.16981,-0.6404 0.32076,-1.30748 0.49057,-1.94788 1.83019,-0.0809 3.63207,-0.1617 5.46226,-0.24255 0.79245,0.34688 1.58491,0.69376 2.37736,1.06733 2.20566,-0.21347 4.41321,-0.42693 6.61887,-0.6404 0.24528,0.72045 0.45283,1.4409 0.71698,2.13466 0.39623,0.80049 0.81132,1.57431 1.20755,2.3748 0.32075,0.8005 0.62264,1.601 0.94339,2.40149 10.88491,-4.76028 21.76868,-9.52057 32.65359,-14.27818 0.47169,-0.10513 0.92452,-0.21027 1.39622,-0.3202 0.24529,-0.37356 0.50944,-0.74713 0.75472,-1.12069 -0.37736,-1.38753 -0.73585,-2.75905 -1.11321,-4.14657 -0.56604,-0.77382 -1.11321,-1.54763 -1.67924,-2.32144 0,-1.38753 0,-2.7964 0,-4.18393 -1.35849,0.1601 -2.71698,0.3202 -4.07547,0.45361 -0.076,-0.45361 -0.15246,-0.93391 -0.22642,-1.38752 -1.66038,0.21346 -3.33019,0.40025 -4.99057,0.61371 -0.0255,-0.90723 -0.0507,-1.84114 -0.076,-2.78839 -7.89812,0.0902 -15.79623,0.18064 -23.69434,0.26683 0.24528,-4.38672 0.49056,-8.77344 0.71698,-13.16016 0.50943,0.18678 1.01887,0.37356 1.5283,0.58703 0.30189,-0.37356 0.60377,-0.74713 0.90566,-1.12069 -0.0638,-0.37357 -0.12698,-0.72045 -0.18868,-1.09402 -1.15094,-0.82718 -2.28113,-1.65435 -3.43207,-2.48153 -0.66038,-0.42694 -1.32076,-0.82718 -1.97736,-1.25411 -0.15095,-0.72045 -0.32076,-1.46758 -0.4717,-2.18803 -0.66038,0.3202 -1.32075,0.66708 -1.97359,0.9606 -0.71698,0.0592 -1.45283,0.11874 -2.16792,0.17824 -0.62264,1.89451 -1.28302,3.85039 -1.90189,5.7449 z" id="path9164"></path>
                   '
    ],
];




# СУБЪЕКТЫ
$reod = [
    1 => 'Республика Адыгея',
    2 => 'Республика Алтай',
    3 => 'Республика Башкортостан',
    4 => 'Республика Бурятия',
    5 => 'Республика Дагестан',
    6 => 'Республика Ингушетия',
    7 => 'Кабардино-Балкарская Республика',
    8 => 'Республика Калмыкия',
    9 => 'Карачаево-Черкесская Республика',
    10 => 'Республика Карелия',
    11 => 'Республика Коми',
    12 => 'Республика Крым',
    13 => 'Республика Марий Эл',
    14 => 'Республика Мордовия',
    15 => 'Республика Саха (Якутия)',
    16 => 'Республика Северная Осетия — Алания',
    17 => 'Республика Татарстан',
    18 => 'Республика Тыва',
    19 => 'Удмуртская Республика',
    20 => 'Республика Хакасия',
    21 => 'Чеченская Республика',
    22 => 'Чувашская Республика — Чувашия',
    23 => 'Алтайский край',
    24 => 'Забайкальский край',
    25 => 'Камчатский край',
    26 => 'Краснодарский край',
    27 => 'Красноярский край',
    28 => 'Пермский край',
    29 => 'Приморский край',
    30 => 'Ставропольский край',
    31 => 'Хабаровский край',
    32 => 'Амурская область',
    33 => 'Архангельская область',
    34 => 'Астраханская область',
    35 => 'Белгородская область',
    36 => 'Брянская область',
    37 => 'Владимирская область',
    38 => 'Волгоградская область',
    39 => 'Вологодская область',
    40 => 'Воронежская область',
    41 => 'Ивановская область',
    42 => 'Иркутская область',
    43 => 'Калининградская область',
    44 => 'Калужская область',
    45 => 'Кемеровская область — Кузбасс',
    46 => 'Кировская область',
    47 => 'Костромская область',
    48 => 'Курганская область',
    49 => 'Курская область',
    50 => 'Ленинградская область',
    51 => 'Липецкая область',
    52 => 'Магаданская область',
    53 => 'Московская область',
    54 => 'Мурманская область',
    55 => 'Нижегородская область',
    56 => 'Новгородская область',
    57 => 'Новосибирская область',
    58 => 'Омская область',
    59 => 'Оренбургская область',
    60 => 'Орловская область',
    61 => 'Пензенская область',
    62 => 'Псковская область',
    63 => 'Ростовская область',
    64 => 'Рязанская область',
    65 => 'Самарская область',
    66 => 'Саратовская область',
    67 => 'Сахалинская область',
    68 => 'Свердловская область',
    69 => 'Смоленская область',
    70 => 'Тамбовская область',
    71 => 'Тверская область',
    72 => 'Томская область',
    73 => 'Тульская область',
    74 => 'Тюменская область',
    75 => 'Ульяновская область',
    76 => 'Челябинская область',
    77 => 'Ярославская область',
    78 => 'Москва',
    79 => 'Санкт-Петербург',
    80 => 'Севастополь',
    81 => 'Еврейская АО',
    82 => 'Ненецкий АО',
    83 => 'Ханты-Мансийский АО — Югра',
    84 => 'Чукотский АО',
    85 => 'Ямало-Ненецкий АО'
];

# РАЙОНЫ
$area = [

];


$city = array(
    1 => 'Абаза',
    2 => 'Абакан',
    3 => 'Абдулино',
    4 => 'Абинск',
    5 => 'Агидель',
    6 => 'Агрыз',
    7 => 'Адыгейск',
    8 => 'Азнакаево',
    9 => 'Азов',
    10 => 'Ак-Довурак',
    11 => 'Аксай',
    12 => 'Алагир',
    13 => 'Алапаевск',
    14 => 'Алатырь',
    15 => 'Алдан',
    16 => 'Алейск',
    17 => 'Александров',
    18 => 'Александровск',
    19 => 'Александровск-Сахалинский',
    20 => 'Алексеевка',
    21 => 'Алексин',
    22 => 'Алзамай',
    23 => 'Алупка',
    24 => 'Алушта',
    25 => 'Альметьевск',
    26 => 'Амурск',
    27 => 'Анадырь',
    28 => 'Анапа',
    29 => 'Ангарск',
    30 => 'Андреаполь',
    31 => 'Анжеро-Судженск',
    32 => 'Анива',
    33 => 'Апатиты',
    34 => 'Апрелевка',
    35 => 'Апшеронск',
    36 => 'Арамиль',
    37 => 'Аргун',
    38 => 'Ардатов',
    39 => 'Ардон',
    40 => 'Арзамас',
    41 => 'Аркадак',
    42 => 'Армавир',
    43 => 'Армянск',
    44 => 'Арсеньев',
    45 => 'Арск',
    46 => 'Артём',
    47 => 'Артёмовск',
    48 => 'Артёмовский',
    49 => 'Архангельск',
    50 => 'Асбест',
    51 => 'Асино',
    52 => 'Астрахань',
    53 => 'Аткарск',
    54 => 'Ахтубинск',
    55 => 'Ачинск',
    56 => 'Аша',
    57 => 'Бабаево',
    58 => 'Бабушкин',
    59 => 'Бавлы',
    60 => 'Багратионовск',
    61 => 'Байкальск',
    62 => 'Баймак',
    63 => 'Бакал',
    64 => 'Баксан',
    65 => 'Балабаново',
    66 => 'Балаково',
    67 => 'Балахна',
    68 => 'Балашиха',
    69 => 'Балашов',
    70 => 'Балей',
    71 => 'Балтийск',
    72 => 'Барабинск',
    73 => 'Барнаул',
    74 => 'Барыш',
    75 => 'Батайск',
    76 => 'Бахчисарай',
    77 => 'Бежецк',
    78 => 'Белая Калитва',
    79 => 'Белая Холуница',
    80 => 'Белгород',
    81 => 'Белебей',
    82 => 'Белёв',
    83 => 'Белинский',
    84 => 'Белово',
    85 => 'Белогорск',
    86 => 'Белогорск',
    87 => 'Белозерск',
    88 => 'Белокуриха',
    89 => 'Беломорск',
    90 => 'Белоозёрский',
    91 => 'Белорецк',
    92 => 'Белореченск',
    93 => 'Белоусово',
    94 => 'Белоярский',
    95 => 'Белый',
    96 => 'Бердск',
    97 => 'Березники',
    98 => 'Берёзовский',
    99 => 'Берёзовский',
    100 => 'Беслан',
    101 => 'Бийск',
    102 => 'Бикин',
    103 => 'Билибино',
    104 => 'Биробиджан',
    105 => 'Бирск',
    106 => 'Бирюсинск',
    107 => 'Бирюч',
    108 => 'Благовещенск',
    109 => 'Благовещенск',
    110 => 'Благодарный',
    111 => 'Бобров',
    112 => 'Богданович',
    113 => 'Богородицк',
    114 => 'Богородск',
    115 => 'Боготол',
    116 => 'Богучар',
    117 => 'Бодайбо',
    118 => 'Бокситогорск',
    119 => 'Болгар',
    120 => 'Бологое',
    121 => 'Болотное',
    122 => 'Болохово',
    123 => 'Болхов',
    124 => 'Большой Камень',
    125 => 'Бор',
    126 => 'Борзя',
    127 => 'Борисоглебск',
    128 => 'Боровичи',
    129 => 'Боровск',
    130 => 'Бородино',
    131 => 'Братск',
    132 => 'Бронницы',
    133 => 'Брянск',
    134 => 'Бугульма',
    135 => 'Бугуруслан',
    136 => 'Будённовск',
    137 => 'Бузулук',
    138 => 'Буинск',
    139 => 'Буй',
    140 => 'Буйнакск',
    141 => 'Бутурлиновка',
    142 => 'Валдай',
    143 => 'Валуйки',
    144 => 'Велиж',
    145 => 'Великие Луки',
    146 => 'Великий Новгород',
    147 => 'Великий Устюг',
    148 => 'Вельск',
    149 => 'Венёв',
    150 => 'Верещагино',
    151 => 'Верея',
    152 => 'Верхнеуральск',
    153 => 'Верхний Тагил',
    154 => 'Верхний Уфалей',
    155 => 'Верхняя Пышма',
    156 => 'Верхняя Салда',
    157 => 'Верхняя Тура',
    158 => 'Верхотурье',
    159 => 'Верхоянск',
    160 => 'Весьегонск',
    161 => 'Ветлуга',
    162 => 'Видное',
    163 => 'Вилюйск',
    164 => 'Вилючинск',
    165 => 'Вихоревка',
    166 => 'Вичуга',
    167 => 'Владивосток',
    168 => 'Владикавказ',
    169 => 'Владимир',
    170 => 'Волгоград',
    171 => 'Волгодонск',
    172 => 'Волгореченск',
    173 => 'Волжск',
    174 => 'Волжский',
    175 => 'Вологда',
    176 => 'Володарск',
    177 => 'Волоколамск',
    178 => 'Волосово',
    179 => 'Волхов',
    180 => 'Волчанск',
    181 => 'Вольск',
    182 => 'Воркута',
    183 => 'Воронеж',
    184 => 'Ворсма',
    185 => 'Воскресенск',
    186 => 'Воткинск',
    187 => 'Всеволожск',
    188 => 'Вуктыл',
    189 => 'Выборг',
    190 => 'Выкса',
    191 => 'Высоковск',
    192 => 'Высоцк',
    193 => 'Вытегра',
    194 => 'Вышний Волочёк',
    195 => 'Вяземский',
    196 => 'Вязники',
    197 => 'Вязьма',
    198 => 'Вятские Поляны',
    199 => 'Гаврилов Посад',
    200 => 'Гаврилов-Ям',
    201 => 'Гагарин',
    202 => 'Гаджиево',
    203 => 'Гай',
    204 => 'Галич',
    205 => 'Гатчина',
    206 => 'Гвардейск',
    207 => 'Гдов',
    208 => 'Геленджик',
    209 => 'Георгиевск',
    210 => 'Глазов',
    211 => 'Голицыно',
    212 => 'Горбатов',
    213 => 'Горно-Алтайск',
    214 => 'Горнозаводск',
    215 => 'Горняк',
    216 => 'Городец',
    217 => 'Городище',
    218 => 'Городовиковск',
    219 => 'Гороховец',
    220 => 'Горячий Ключ',
    221 => 'Грайворон',
    222 => 'Гремячинск',
    223 => 'Грозный',
    224 => 'Грязи',
    225 => 'Грязовец',
    226 => 'Губаха',
    227 => 'Губкин',
    228 => 'Губкинский',
    229 => 'Гудермес',
    230 => 'Гуково',
    231 => 'Гулькевичи',
    232 => 'Гурьевск',
    233 => 'Гурьевск',
    234 => 'Гусев',
    235 => 'Гусиноозёрск',
    236 => 'Гусь-Хрустальный',
    237 => 'Давлеканово',
    238 => 'Дагестанские Огни',
    239 => 'Далматово',
    240 => 'Дальнегорск',
    241 => 'Дальнереченск',
    242 => 'Данилов',
    243 => 'Данков',
    244 => 'Дегтярск',
    245 => 'Дедовск',
    246 => 'Демидов',
    247 => 'Дербент',
    248 => 'Десногорск',
    249 => 'Джанкой',
    250 => 'Дзержинск',
    251 => 'Дзержинский',
    252 => 'Дивногорск',
    253 => 'Дигора',
    254 => 'Димитровград',
    255 => 'Дмитриев',
    256 => 'Дмитров',
    257 => 'Дмитровск',
    258 => 'Дно',
    259 => 'Добрянка',
    260 => 'Долгопрудный',
    261 => 'Долинск',
    262 => 'Домодедово',
    263 => 'Донецк',
    264 => 'Донской',
    265 => 'Дорогобуж',
    266 => 'Дрезна',
    267 => 'Дубна',
    268 => 'Дубовка',
    269 => 'Дудинка',
    270 => 'Духовщина',
    271 => 'Дюртюли',
    272 => 'Дятьково',
    273 => 'Евпатория',
    274 => 'Егорьевск',
    275 => 'Ейск',
    276 => 'Екатеринбург',
    277 => 'Елабуга',
    278 => 'Елец',
    279 => 'Елизово',
    280 => 'Ельня',
    281 => 'Еманжелинск',
    282 => 'Емва',
    283 => 'Енисейск',
    284 => 'Ермолино',
    285 => 'Ершов',
    286 => 'Ессентуки',
    287 => 'Ефремов',
    288 => 'Железноводск',
    289 => 'Железногорск',
    290 => 'Железногорск',
    291 => 'Железногорск-Илимский',
    292 => 'Жердевка',
    293 => 'Жигулёвск',
    294 => 'Жиздра',
    295 => 'Жирновск',
    296 => 'Жуков',
    297 => 'Жуковка',
    298 => 'Жуковский',
    299 => 'Завитинск',
    300 => 'Заводоуковск',
    301 => 'Заволжск',
    302 => 'Заволжье',
    303 => 'Задонск',
    304 => 'Заинск',
    305 => 'Закаменск',
    306 => 'Заозёрный',
    307 => 'Заозёрск',
    308 => 'Западная Двина',
    309 => 'Заполярный',
    310 => 'Зарайск',
    311 => 'Заречный',
    312 => 'Заречный',
    313 => 'Заринск',
    314 => 'Звенигово',
    315 => 'Звенигород',
    316 => 'Зверево',
    317 => 'Зеленогорск',
    318 => 'Зеленоградск',
    319 => 'Зеленодольск',
    320 => 'Зеленокумск',
    321 => 'Зерноград',
    322 => 'Зея',
    323 => 'Зима',
    324 => 'Златоуст',
    325 => 'Злынка',
    326 => 'Змеиногорск',
    327 => 'Знаменск',
    328 => 'Зубцов',
    329 => 'Зуевка',
    330 => 'Ивангород',
    331 => 'Иваново',
    332 => 'Ивантеевка',
    333 => 'Ивдель',
    334 => 'Игарка',
    335 => 'Ижевск',
    336 => 'Избербаш',
    337 => 'Изобильный',
    338 => 'Иланский',
    339 => 'Инза',
    340 => 'Иннополис',
    341 => 'Инсар',
    342 => 'Инта',
    343 => 'Ипатово',
    344 => 'Ирбит',
    345 => 'Иркутск',
    346 => 'Исилькуль',
    347 => 'Искитим',
    348 => 'Истра',
    349 => 'Ишим',
    350 => 'Ишимбай',
    351 => 'Йошкар-Ола',
    352 => 'Кадников',
    353 => 'Казань',
    354 => 'Калач',
    355 => 'Калач-на-Дону',
    356 => 'Калачинск',
    357 => 'Калининград',
    358 => 'Калининск',
    359 => 'Калтан',
    360 => 'Калуга',
    361 => 'Калязин',
    362 => 'Камбарка',
    363 => 'Каменка',
    364 => 'Каменногорск',
    365 => 'Каменск-Уральский',
    366 => 'Каменск-Шахтинский',
    367 => 'Камень-на-Оби',
    368 => 'Камешково',
    369 => 'Камызяк',
    370 => 'Камышин',
    371 => 'Камышлов',
    372 => 'Канаш',
    373 => 'Кандалакша',
    374 => 'Канск',
    375 => 'Карабаново',
    376 => 'Карабаш',
    377 => 'Карабулак',
    378 => 'Карасук',
    379 => 'Карачаевск',
    380 => 'Карачев',
    381 => 'Каргат',
    382 => 'Каргополь',
    383 => 'Карпинск',
    384 => 'Карталы',
    385 => 'Касимов',
    386 => 'Касли',
    387 => 'Каспийск',
    388 => 'Катав-Ивановск',
    389 => 'Катайск',
    390 => 'Качканар',
    391 => 'Кашин',
    392 => 'Кашира',
    393 => 'Кедровый',
    394 => 'Кемерово',
    395 => 'Кемь',
    396 => 'Керчь',
    397 => 'Кизел',
    398 => 'Кизилюрт',
    399 => 'Кизляр',
    400 => 'Кимовск',
    401 => 'Кимры',
    402 => 'Кингисепп',
    403 => 'Кинель',
    404 => 'Кинешма',
    405 => 'Киреевск',
    406 => 'Киренск',
    407 => 'Киржач',
    408 => 'Кириллов',
    409 => 'Кириши',
    410 => 'Киров',
    411 => 'Киров',
    412 => 'Кировград',
    413 => 'Кирово-Чепецк',
    414 => 'Кировск',
    415 => 'Кировск',
    416 => 'Кирс',
    417 => 'Кирсанов',
    418 => 'Киселёвск',
    419 => 'Кисловодск',
    420 => 'Клин',
    421 => 'Клинцы',
    422 => 'Княгинино',
    423 => 'Ковдор',
    424 => 'Ковров',
    425 => 'Ковылкино',
    426 => 'Когалым',
    427 => 'Кодинск',
    428 => 'Козельск',
    429 => 'Козловка',
    430 => 'Козьмодемьянск',
    431 => 'Кола',
    432 => 'Кологрив',
    433 => 'Коломна',
    434 => 'Колпашево',
    435 => 'Кольчугино',
    436 => 'Коммунар',
    437 => 'Комсомольск',
    438 => 'Комсомольск-на-Амуре',
    439 => 'Конаково',
    440 => 'Кондопога',
    441 => 'Кондрово',
    442 => 'Константиновск',
    443 => 'Копейск',
    444 => 'Кораблино',
    445 => 'Кореновск',
    446 => 'Коркино',
    447 => 'Королёв',
    448 => 'Короча',
    449 => 'Корсаков',
    450 => 'Коряжма',
    451 => 'Костерёво',
    452 => 'Костомукша',
    453 => 'Кострома',
    454 => 'Котельники',
    455 => 'Котельниково',
    456 => 'Котельнич',
    457 => 'Котлас',
    458 => 'Котово',
    459 => 'Котовск',
    460 => 'Кохма',
    461 => 'Красавино',
    462 => 'Красноармейск',
    463 => 'Красноармейск',
    464 => 'Красновишерск',
    465 => 'Красногорск',
    466 => 'Краснодар',
    467 => 'Краснозаводск',
    468 => 'Краснознаменск',
    469 => 'Краснознаменск',
    470 => 'Краснокаменск',
    471 => 'Краснокамск',
    472 => 'Красноперекопск',
    473 => 'Краснослободск',
    474 => 'Краснослободск',
    475 => 'Краснотурьинск',
    476 => 'Красноуральск',
    477 => 'Красноуфимск',
    478 => 'Красноярск',
    479 => 'Красный Кут',
    480 => 'Красный Сулин',
    481 => 'Красный Холм',
    482 => 'Кремёнки',
    483 => 'Кропоткин',
    484 => 'Крымск',
    485 => 'Кстово',
    486 => 'Кубинка',
    487 => 'Кувандык',
    488 => 'Кувшиново',
    489 => 'Кудрово',
    490 => 'Кудымкар',
    491 => 'Кузнецк',
    492 => 'Куйбышев',
    493 => 'Кукмор',
    494 => 'Кулебаки',
    495 => 'Кумертау',
    496 => 'Кунгур',
    497 => 'Купино',
    498 => 'Курган',
    499 => 'Курганинск',
    500 => 'Курильск',
    501 => 'Курлово',
    502 => 'Куровское',
    503 => 'Курск',
    504 => 'Куртамыш',
    505 => 'Курчалой',
    506 => 'Курчатов',
    507 => 'Куса',
    508 => 'Кушва',
    509 => 'Кызыл',
    510 => 'Кыштым',
    511 => 'Кяхта',
    512 => 'Лабинск',
    513 => 'Лабытнанги',
    514 => 'Лагань',
    515 => 'Ладушкин',
    516 => 'Лаишево',
    517 => 'Лакинск',
    518 => 'Лангепас',
    519 => 'Лахденпохья',
    520 => 'Лебедянь',
    521 => 'Лениногорск',
    522 => 'Ленинск',
    523 => 'Ленинск-Кузнецкий',
    524 => 'Ленск',
    525 => 'Лермонтов',
    526 => 'Лесной',
    527 => 'Лесозаводск',
    528 => 'Лесосибирск',
    529 => 'Ливны',
    530 => 'Ликино-Дулёво',
    531 => 'Липецк',
    532 => 'Липки',
    533 => 'Лиски',
    534 => 'Лихославль',
    535 => 'Лобня',
    536 => 'Лодейное Поле',
    537 => 'Лосино-Петровский',
    538 => 'Луга',
    539 => 'Луза',
    540 => 'Лукоянов',
    541 => 'Луховицы',
    542 => 'Лысково',
    543 => 'Лысьва',
    544 => 'Лыткарино',
    545 => 'Льгов',
    546 => 'Любань',
    547 => 'Люберцы',
    548 => 'Любим',
    549 => 'Людиново',
    550 => 'Лянтор',
    551 => 'Магадан',
    552 => 'Магас',
    553 => 'Магнитогорск',
    554 => 'Майкоп',
    555 => 'Майский',
    556 => 'Макаров',
    557 => 'Макарьев',
    558 => 'Макушино',
    559 => 'Малая Вишера',
    560 => 'Малгобек',
    561 => 'Малмыж',
    562 => 'Малоархангельск',
    563 => 'Малоярославец',
    564 => 'Мамадыш',
    565 => 'Мамоново',
    566 => 'Мантурово',
    567 => 'Мариинск',
    568 => 'Мариинский Посад',
    569 => 'Маркс',
    570 => 'Махачкала',
    571 => 'Мглин',
    572 => 'Мегион',
    573 => 'Медвежьегорск',
    574 => 'Медногорск',
    575 => 'Медынь',
    576 => 'Межгорье',
    577 => 'Междуреченск',
    578 => 'Мезень',
    579 => 'Меленки',
    580 => 'Мелеуз',
    581 => 'Менделеевск',
    582 => 'Мензелинск',
    583 => 'Мещовск',
    584 => 'Миасс',
    585 => 'Микунь',
    586 => 'Миллерово',
    587 => 'Минеральные Воды',
    588 => 'Минусинск',
    589 => 'Миньяр',
    590 => 'Мирный',
    591 => 'Мирный',
    592 => 'Михайлов',
    593 => 'Михайловка',
    594 => 'Михайловск',
    595 => 'Михайловск',
    596 => 'Мичуринск',
    597 => 'Могоча',
    598 => 'Можайск',
    599 => 'Можга',
    600 => 'Моздок',
    601 => 'Мончегорск',
    602 => 'Морозовск',
    603 => 'Моршанск',
    604 => 'Мосальск',
    605 => 'Москва',
    606 => 'Муравленко',
    607 => 'Мураши',
    608 => 'Мурино',
    609 => 'Мурманск',
    610 => 'Муром',
    611 => 'Мценск',
    612 => 'Мыски',
    613 => 'Мытищи',
    614 => 'Мышкин',
    615 => 'Набережные Челны',
    616 => 'Навашино',
    617 => 'Наволоки',
    618 => 'Надым',
    619 => 'Назарово',
    620 => 'Назрань',
    621 => 'Называевск',
    622 => 'Нальчик',
    623 => 'Нариманов',
    624 => 'Наро-Фоминск',
    625 => 'Нарткала',
    626 => 'Нарьян-Мар',
    627 => 'Находка',
    628 => 'Невель',
    629 => 'Невельск',
    630 => 'Невинномысск',
    631 => 'Невьянск',
    632 => 'Нелидово',
    633 => 'Неман',
    634 => 'Нерехта',
    635 => 'Нерчинск',
    636 => 'Нерюнгри',
    637 => 'Нестеров',
    638 => 'Нефтегорск',
    639 => 'Нефтекамск',
    640 => 'Нефтекумск',
    641 => 'Нефтеюганск',
    642 => 'Нея',
    643 => 'Нижневартовск',
    644 => 'Нижнекамск',
    645 => 'Нижнеудинск',
    646 => 'Нижние Серги',
    647 => 'Нижний Ломов',
    648 => 'Нижний Новгород',
    649 => 'Нижний Тагил',
    650 => 'Нижняя Салда',
    651 => 'Нижняя Тура',
    652 => 'Николаевск',
    653 => 'Николаевск-на-Амуре',
    654 => 'Никольск',
    655 => 'Никольск',
    656 => 'Никольское',
    657 => 'Новая Ладога',
    658 => 'Новая Ляля',
    659 => 'Новоалександровск',
    660 => 'Новоалтайск',
    661 => 'Новоаннинский',
    662 => 'Нововоронеж',
    663 => 'Новодвинск',
    664 => 'Новозыбков',
    665 => 'Новокубанск',
    666 => 'Новокузнецк',
    667 => 'Новокуйбышевск',
    668 => 'Новомичуринск',
    669 => 'Новомосковск',
    670 => 'Новопавловск',
    671 => 'Новоржев',
    672 => 'Новороссийск',
    673 => 'Новосибирск',
    674 => 'Новосиль',
    675 => 'Новосокольники',
    676 => 'Новотроицк',
    677 => 'Новоузенск',
    678 => 'Новоульяновск',
    679 => 'Новоуральск',
    680 => 'Новохопёрск',
    681 => 'Новочебоксарск',
    682 => 'Новочеркасск',
    683 => 'Новошахтинск',
    684 => 'Новый Оскол',
    685 => 'Новый Уренгой',
    686 => 'Ногинск',
    687 => 'Нолинск',
    688 => 'Норильск',
    689 => 'Ноябрьск',
    690 => 'Нурлат',
    691 => 'Нытва',
    692 => 'Нюрба',
    693 => 'Нягань',
    694 => 'Нязепетровск',
    695 => 'Няндома',
    696 => 'Облучье',
    697 => 'Обнинск',
    698 => 'Обоянь',
    699 => 'Обь',
    700 => 'Одинцово',
    701 => 'Озёрск',
    702 => 'Озёрск',
    703 => 'Озёры',
    704 => 'Октябрьск',
    705 => 'Октябрьский',
    706 => 'Окуловка',
    707 => 'Олёкминск',
    708 => 'Оленегорск',
    709 => 'Олонец',
    710 => 'Омск',
    711 => 'Омутнинск',
    712 => 'Онега',
    713 => 'Опочка',
    714 => 'Орёл',
    715 => 'Оренбург',
    716 => 'Орехово-Зуево',
    717 => 'Орлов',
    718 => 'Орск',
    719 => 'Оса',
    720 => 'Осинники',
    721 => 'Осташков',
    722 => 'Остров',
    723 => 'Островной',
    724 => 'Острогожск',
    725 => 'Отрадное',
    726 => 'Отрадный',
    727 => 'Оха',
    728 => 'Оханск',
    729 => 'Очёр',
    730 => 'Павлово',
    731 => 'Павловск',
    732 => 'Павловский Посад',
    733 => 'Палласовка',
    734 => 'Партизанск',
    735 => 'Певек',
    736 => 'Пенза',
    737 => 'Первомайск',
    738 => 'Первоуральск',
    739 => 'Перевоз',
    740 => 'Пересвет',
    741 => 'Переславль-Залесский',
    742 => 'Пермь',
    743 => 'Пестово',
    744 => 'Петров Вал',
    745 => 'Петровск',
    746 => 'Петровск-Забайкальский',
    747 => 'Петрозаводск',
    748 => 'Петропавловск-Камчатский',
    749 => 'Петухово',
    750 => 'Петушки',
    751 => 'Печора',
    752 => 'Печоры',
    753 => 'Пикалёво',
    754 => 'Пионерский',
    755 => 'Питкяранта',
    756 => 'Плавск',
    757 => 'Пласт',
    758 => 'Плёс',
    759 => 'Поворино',
    760 => 'Подольск',
    761 => 'Подпорожье',
    762 => 'Покачи',
    763 => 'Покров',
    764 => 'Покровск',
    765 => 'Полевской',
    766 => 'Полесск',
    767 => 'Полысаево',
    768 => 'Полярные Зори',
    769 => 'Полярный',
    770 => 'Поронайск',
    771 => 'Порхов',
    772 => 'Похвистнево',
    773 => 'Почеп',
    774 => 'Починок',
    775 => 'Пошехонье',
    776 => 'Правдинск',
    777 => 'Приволжск',
    778 => 'Приморск',
    779 => 'Приморск',
    780 => 'Приморско-Ахтарск',
    781 => 'Приозерск',
    782 => 'Прокопьевск',
    783 => 'Пролетарск',
    784 => 'Протвино',
    785 => 'Прохладный',
    786 => 'Псков',
    787 => 'Пугачёв',
    788 => 'Пудож',
    789 => 'Пустошка',
    790 => 'Пучеж',
    791 => 'Пушкино',
    792 => 'Пущино',
    793 => 'Пыталово',
    794 => 'Пыть-Ях',
    795 => 'Пятигорск',
    796 => 'Радужный',
    797 => 'Радужный',
    798 => 'Райчихинск',
    799 => 'Раменское',
    800 => 'Рассказово',
    801 => 'Ревда',
    802 => 'Реж',
    803 => 'Реутов',
    804 => 'Ржев',
    805 => 'Родники',
    806 => 'Рославль',
    807 => 'Россошь',
    808 => 'Ростов',
    809 => 'Ростов-на-Дону',
    810 => 'Рошаль',
    811 => 'Ртищево',
    812 => 'Рубцовск',
    813 => 'Рудня',
    814 => 'Руза',
    815 => 'Рузаевка',
    816 => 'Рыбинск',
    817 => 'Рыбное',
    818 => 'Рыльск',
    819 => 'Ряжск',
    820 => 'Рязань',
    821 => 'Саки',
    822 => 'Салават',
    823 => 'Салаир',
    824 => 'Салехард',
    825 => 'Сальск',
    826 => 'Самара',
    827 => 'Санкт-Петербург',
    828 => 'Саранск',
    829 => 'Сарапул',
    830 => 'Саратов',
    831 => 'Саров',
    832 => 'Сасово',
    833 => 'Сатка',
    834 => 'Сафоново',
    835 => 'Саяногорск',
    836 => 'Саянск',
    837 => 'Светлогорск',
    838 => 'Светлоград',
    839 => 'Светлый',
    840 => 'Светогорск',
    841 => 'Свирск',
    842 => 'Свободный',
    843 => 'Себеж',
    844 => 'Севастополь',
    845 => 'Северо-Курильск',
    846 => 'Северобайкальск',
    847 => 'Северодвинск',
    848 => 'Североморск',
    849 => 'Североуральск',
    850 => 'Северск',
    851 => 'Севск',
    852 => 'Сегежа',
    853 => 'Сельцо',
    854 => 'Семёнов',
    855 => 'Семикаракорск',
    856 => 'Семилуки',
    857 => 'Сенгилей',
    858 => 'Серафимович',
    859 => 'Сергач',
    860 => 'Сергиев Посад',
    861 => 'Сердобск',
    862 => 'Серов',
    863 => 'Серпухов',
    864 => 'Сертолово',
    865 => 'Сибай',
    866 => 'Сим',
    867 => 'Симферополь',
    868 => 'Сковородино',
    869 => 'Скопин',
    870 => 'Славгород',
    871 => 'Славск',
    872 => 'Славянск-на-Кубани',
    873 => 'Сланцы',
    874 => 'Слободской',
    875 => 'Слюдянка',
    876 => 'Смоленск',
    877 => 'Снежинск',
    878 => 'Снежногорск',
    879 => 'Собинка',
    880 => 'Советск',
    881 => 'Советск',
    882 => 'Советск',
    883 => 'Советская Гавань',
    884 => 'Советский',
    885 => 'Сокол',
    886 => 'Солигалич',
    887 => 'Соликамск',
    888 => 'Солнечногорск',
    889 => 'Соль-Илецк',
    890 => 'Сольвычегодск',
    891 => 'Сольцы',
    892 => 'Сорочинск',
    893 => 'Сорск',
    894 => 'Сортавала',
    895 => 'Сосенский',
    896 => 'Сосновка',
    897 => 'Сосновоборск',
    898 => 'Сосновый Бор',
    899 => 'Сосногорск',
    900 => 'Сочи',
    901 => 'Спас-Деменск',
    902 => 'Спас-Клепики',
    903 => 'Спасск',
    904 => 'Спасск-Дальний',
    905 => 'Спасск-Рязанский',
    906 => 'Среднеколымск',
    907 => 'Среднеуральск',
    908 => 'Сретенск',
    909 => 'Ставрополь',
    910 => 'Старая Купавна',
    911 => 'Старая Русса',
    912 => 'Старица',
    913 => 'Стародуб',
    914 => 'Старый Крым',
    915 => 'Старый Оскол',
    916 => 'Стерлитамак',
    917 => 'Стрежевой',
    918 => 'Строитель',
    919 => 'Струнино',
    920 => 'Ступино',
    921 => 'Суворов',
    922 => 'Судак',
    923 => 'Суджа',
    924 => 'Судогда',
    925 => 'Суздаль',
    926 => 'Сунжа',
    927 => 'Суоярви',
    928 => 'Сураж',
    929 => 'Сургут',
    930 => 'Суровикино',
    931 => 'Сурск',
    932 => 'Сусуман',
    933 => 'Сухиничи',
    934 => 'Сухой Лог',
    935 => 'Сызрань',
    936 => 'Сыктывкар',
    937 => 'Сысерть',
    938 => 'Сычёвка',
    939 => 'Сясьстрой',
    940 => 'Тавда',
    941 => 'Таганрог',
    942 => 'Тайга',
    943 => 'Тайшет',
    944 => 'Талдом',
    945 => 'Талица',
    946 => 'Тамбов',
    947 => 'Тара',
    948 => 'Тарко-Сале',
    949 => 'Таруса',
    950 => 'Татарск',
    951 => 'Таштагол',
    952 => 'Тверь',
    953 => 'Теберда',
    954 => 'Тейково',
    955 => 'Темников',
    956 => 'Темрюк',
    957 => 'Терек',
    958 => 'Тетюши',
    959 => 'Тимашёвск',
    960 => 'Тихвин',
    961 => 'Тихорецк',
    962 => 'Тобольск',
    963 => 'Тогучин',
    964 => 'Тольятти',
    965 => 'Томари',
    966 => 'Томмот',
    967 => 'Томск',
    968 => 'Топки',
    969 => 'Торжок',
    970 => 'Торопец',
    971 => 'Тосно',
    972 => 'Тотьма',
    973 => 'Трёхгорный',
    974 => 'Троицк',
    975 => 'Трубчевск',
    976 => 'Туапсе',
    977 => 'Туймазы',
    978 => 'Тула',
    979 => 'Тулун',
    980 => 'Туран',
    981 => 'Туринск',
    982 => 'Тутаев',
    983 => 'Тында',
    984 => 'Тырныауз',
    985 => 'Тюкалинск',
    986 => 'Тюмень',
    987 => 'Уварово',
    988 => 'Углегорск',
    989 => 'Углич',
    990 => 'Удачный',
    991 => 'Удомля',
    992 => 'Ужур',
    993 => 'Узловая',
    994 => 'Улан-Удэ',
    995 => 'Ульяновск',
    996 => 'Унеча',
    997 => 'Урай',
    998 => 'Урень',
    999 => 'Уржум',
    1000 => 'Урус-Мартан',
    1001 => 'Урюпинск',
    1002 => 'Усинск',
    1003 => 'Усмань',
    1004 => 'Усолье',
    1005 => 'Усолье-Сибирское',
    1006 => 'Уссурийск',
    1007 => 'Усть-Джегута',
    1008 => 'Усть-Илимск',
    1009 => 'Усть-Катав',
    1010 => 'Усть-Кут',
    1011 => 'Усть-Лабинск',
    1012 => 'Устюжна',
    1013 => 'Уфа',
    1014 => 'Ухта',
    1015 => 'Учалы',
    1016 => 'Уяр',
    1017 => 'Фатеж',
    1018 => 'Феодосия',
    1019 => 'Фокино',
    1020 => 'Фокино',
    1021 => 'Фролово',
    1022 => 'Фрязино',
    1023 => 'Фурманов',
    1024 => 'Хабаровск',
    1025 => 'Хадыженск',
    1026 => 'Ханты-Мансийск',
    1027 => 'Харабали',
    1028 => 'Харовск',
    1029 => 'Хасавюрт',
    1030 => 'Хвалынск',
    1031 => 'Хилок',
    1032 => 'Химки',
    1033 => 'Холм',
    1034 => 'Холмск',
    1035 => 'Хотьково',
    1036 => 'Цивильск',
    1037 => 'Цимлянск',
    1038 => 'Циолковский',
    1039 => 'Чадан',
    1040 => 'Чайковский',
    1041 => 'Чапаевск',
    1042 => 'Чаплыгин',
    1043 => 'Чебаркуль',
    1044 => 'Чебоксары',
    1045 => 'Чегем',
    1046 => 'Чекалин',
    1047 => 'Челябинск',
    1048 => 'Чердынь',
    1049 => 'Черемхово',
    1050 => 'Черепаново',
    1051 => 'Череповец',
    1052 => 'Черкесск',
    1053 => 'Чёрмоз',
    1054 => 'Черноголовка',
    1055 => 'Черногорск',
    1056 => 'Чернушка',
    1057 => 'Черняховск',
    1058 => 'Чехов',
    1059 => 'Чистополь',
    1060 => 'Чита',
    1061 => 'Чкаловск',
    1062 => 'Чудово',
    1063 => 'Чулым',
    1064 => 'Чусовой',
    1065 => 'Чухлома',
    1066 => 'Шагонар',
    1067 => 'Шадринск',
    1068 => 'Шали',
    1069 => 'Шарыпово',
    1070 => 'Шарья',
    1071 => 'Шатура',
    1072 => 'Шахты',
    1073 => 'Шахунья',
    1074 => 'Шацк',
    1075 => 'Шебекино',
    1076 => 'Шелехов',
    1077 => 'Шенкурск',
    1078 => 'Шилка',
    1079 => 'Шимановск',
    1080 => 'Шиханы',
    1081 => 'Шлиссельбург',
    1082 => 'Шумерля',
    1083 => 'Шумиха',
    1084 => 'Шуя',
    1085 => 'Щёкино',
    1086 => 'Щёлкино',
    1087 => 'Щёлково',
    1088 => 'Щигры',
    1089 => 'Щучье',
    1090 => 'Электрогорск',
    1091 => 'Электросталь',
    1092 => 'Электроугли',
    1093 => 'Элиста',
    1094 => 'Энгельс',
    1095 => 'Эртиль',
    1096 => 'Югорск',
    1097 => 'Южа',
    1098 => 'Южно-Сахалинск',
    1099 => 'Южно-Сухокумск',
    1100 => 'Южноуральск',
    1101 => 'Юрга',
    1102 => 'Юрьев-Польский',
    1103 => 'Юрьевец',
    1104 => 'Юрюзань',
    1105 => 'Юхнов',
    1106 => 'Ядрин',
    1107 => 'Якутск',
    1108 => 'Ялта',
    1109 => 'Ялуторовск',
    1110 => 'Янаул',
    1111 => 'Яранск',
    1112 => 'Яровое',
    1113 => 'Ярославль',
    1114 => 'Ярцево',
    1115 => 'Ясногорск',
    1116 => 'Ясный',
    1117 => 'Яхрома',
    1118 => 'Островцы',
    1119 => 'Татарка (Ставропольский край)'
);


























?>