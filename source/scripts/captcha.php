<?php

$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz#@%!%?&';
$length = 6;
$code = substr(str_shuffle($chars), 0, $length);
$_SESSION['captcha'] =  crypt($code, '$1$itchief$7');
session_write_close();
$image = imagecreatefrompng(__DIR__ . '/assets/img/capt.png');
$size = 36;
$color = imagecolorallocate($image, 255, 255, 255);
$font = __DIR__ . '/assets/font//oswald.ttf';
$angle = rand(-10, 10);
$x = 56;
$y = 68;
imagefttext($image, $size, $angle, $x, $y, $color, $font, $code);
header('Cache-Control: no-store, must-revalidate');
header('Expires: 0');
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);