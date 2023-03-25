<?php
header("Access-Control-Allow-Origin: *");

$status = (int) $_GET['status'];

if (($status >= 200 && $status < 300) || $status == 304) {
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">

    <head>

        <meta http-equiv="content-type" content="text/html; utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />

        <title itemprop="name">СтГАУ Агрокадры</title>
    </head>

    <body>

    <h1>Ваш браузер устарел.</h1>
    <p><i>Из-за этого Сайт может работать медленно и с ошибками</i></p>
    <p><i>Пожалуйста, обновите ваш браузер до последней версии.</i></p>

    </body>
    </html>
    <?php
} else {
    include("404.php");
}
?>