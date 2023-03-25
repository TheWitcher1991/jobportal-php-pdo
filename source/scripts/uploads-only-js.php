<?php

$input_name = 'file';

$allow = [
    'png'
];

$deny = [
    'phtml', 'php', 'php3', 'php4', 'php5', 'php6', 'php7', 'phps', 'cgi', 'pl', 'asp',
    'aspx', 'shtml', 'shtm', 'htaccess', 'htpasswd', 'ini', 'log', 'sh', 'js', 'html',
    'htm', 'css', 'sql', 'spl', 'scgi', 'fcgi', 'exe', 'gif', 'svg', 'jpeg', 'jpg'
];

$url_path = '/static/temp/';

$path = $_SERVER['DOCUMENT_ROOT'] . $url_path;

$error = $success = '';
if (!isset($_FILES[$input_name])) {
    $error = 'Файл не загружен';
} else {
    $file = $_FILES[$input_name];

    if (!empty($file['error']) || empty($file['tmp_name'])) {
        $error = 'Не удалось загрузить файл';
    } elseif ($file['tmp_name'] == 'none' || !is_uploaded_file($file['tmp_name'])) {
        $error = 'Не удалось загрузить файл';
    } else {
        $pattern = "[^a-zа-яё0-9,~!@#%^-_\$\?\(\)\{\}\[\]\.]";
        $name = mb_eregi_replace($pattern, '-', $file['name']);
        $name = mb_ereg_replace('[-]+', '-', $name);
        $parts = pathinfo($name);

        if (empty($name) || empty($parts['extension'])) {
            $error = 'Недопустимый тип файла';
        } elseif (!empty($allow) && !in_array(strtolower($parts['extension']), $allow)) {
            $error = 'Недопустимый тип файла';
        } elseif (!empty($deny) && in_array(strtolower($parts['extension']), $deny)) {
            $error = 'Недопустимый тип файла';
        } else {

            $info = @getimagesize($file['tmp_name']);

            $ext = mb_strtolower(mb_substr(mb_strrchr(@$file['name'], '.'), 1));

            $name = time() . '-' . mt_rand(1, 9999999999);

            $src = $path . $name . '.' . $ext;

            $thumb = $path . $name . '-thumb.' . $ext;



            if (move_uploaded_file($file['tmp_name'], $src)) {

                if ($ext == 'png') {

                    switch ($info[2]) {

                        case 1:

                            $im = imageCreateFromGif($src);

                            imageSaveAlpha($im, true);

                            break;

                        case 2:

                            $im = imageCreateFromJpeg($src);

                            break;

                        case 3:

                            $im = imageCreateFromPng($src);

                            imageSaveAlpha($im, true);

                            break;

                    }


                    $width = $info[0];

                    $height = $info[1];


                    // Высота превью 100px, ширина рассчитывается автоматически.

                    $h = 100;

                    $w = ($h > $height) ? $width : ceil($h / ($height / $width));

                    $tw = ceil($h / ($height / $width));

                    $th = ceil($w / ($width / $height));


                    $new_im = imageCreateTrueColor($w, $h);

                    if ($info[2] == 1 || $info[2] == 3) {

                        imagealphablending($new_im, true);

                        imageSaveAlpha($new_im, true);

                        $transparent = imagecolorallocatealpha($new_im, 0, 0, 0, 127);

                        imagefill($new_im, 0, 0, $transparent);

                        imagecolortransparent($new_im, $transparent);

                    }


                    if ($w >= $width && $h >= $height) {

                        $xy = array(ceil(($w - $width) / 2), ceil(($h - $height) / 2), $width, $height);

                    } elseif ($w >= $width) {

                        $xy = array(ceil(($w - $tw) / 2), 0, ceil($h / ($height / $width)), $h);

                    } elseif ($h >= $height) {

                        $xy = array(0, ceil(($h - $th) / 2), $w, ceil($w / ($width / $height)));

                    } elseif ($tw < $w) {

                        $xy = array(ceil(($w - $tw) / 2), ceil(($h - $h) / 2), $tw, $h);

                    } else {

                        $xy = array(0, ceil(($h - $th) / 2), $w, $th);

                    }


                    imageCopyResampled($new_im, $im, $xy[0], $xy[1], 0, 0, $xy[2], $xy[3], $width, $height);


                    // Сохранение.

                    switch ($info[2]) {

                        case 1:
                            imageGif($new_im, $thumb);
                            break;

                        case 2:
                            imageJpeg($new_im, $thumb);
                            break;

                        case 3:
                            imagePng($new_im, $thumb);
                            break;

                    }


                    imagedestroy($im);

                    imagedestroy($new_im);


                }


                $success = '

				<div class="img-item">
				
				    <header>
				        <a herf="#" onclick="$(this).parent().parent().remove();$(\'.uploadButton-file-name\').html(\'\');$(\'.img-form\')[0].reset(); return false;"><i class="mdi mdi-close"></i></a>
                    </header>

					<img src="' . $url_path . $name . '-thumb.' . $ext . '">
					
					<span>' . $name . '.' . $ext . '</span>

					<input type="hidden" name="image-file" value="' . $name . '.' . $ext . '">

				</div>';
            } else {
                $error = 'Не удалось загрузить файл.';
            }
        }

    }
}

if (!empty($error)) {
    $error = '<p style="color: red">' . $error . '</p>';
}

$data = array(
    'error'   => $error,
    'success' => $success,
);

header('Content-Type: application/json');
echo json_encode($data, JSON_UNESCAPED_UNICODE);
session_write_close();

exit;












