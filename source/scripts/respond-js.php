<?php

use Core\App;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $app->notFound();
    exit;
}

if (isset($_SESSION['id']) && isset($_SESSION['password']) && $_SESSION['type'] == 'company') {

    $count_acc = $app->rowCount("SELECT * FROM `company` WHERE `id` = :id", [':id' => $_SESSION['id']]);

    if ($count_acc <= 0) {
        $app->notFound();
        exit;
    }

    try {

        if (isset($_POST['MODULE_ARCH']) && $_POST['MODULE_ARCH'] == 1) {
            $type = (int) XSS_DEFENDER($_POST['type']);
            $sth = $PDO->prepare("SELECT * FROM `respond` WHERE `id` = ? AND `company_id` = ?");
            $sth->execute([XSS_DEFENDER($_POST['id']), $_SESSION['id']]);
            if ($sth->rowCount() > 0) {
                $r = $sth->fetch();
                $app->execute("DELETE FROM `respond` WHERE `id` = :id", [':id' => XSS_DEFENDER($_POST['id'])]);
                $app->execute("INSERT INTO `archive-respond` (`job_id`, `user_id`, `date`, `company_id`, `job`, `status`, `time`) 
                                   VALUES (:ji, :ui, :d, :ci, :j, :s, NOW())", [
                    ':ji' => $r['job_id'],
                    ':ui' => $r['user_id'],
                    ':d' => $Date,
                    ':ci' => $_SESSION['id'],
                    ':j' => $r['job'],
                    ':s' => $r['status']
                ]);
                echo json_encode(array(
                    'code' => 'success',
                    'count' => $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' AND `status` = '$type'"),
                ));
            } else {
                echo json_encode(array(
                    'code' => 'error',
                ));
            }
        }

        if (isset($_POST['MODULE_INVITE']) && $_POST['MODULE_INVITE'] == 1) {
            $check = XSS_DEFENDER($_POST['notext']);
            if ($check == 1) {
                $text = preg_replace("'<script[^>]*?>.*?</script>'si", "", $_POST['text']);
                $text = str_replace($xss,"",$text);
                $err = [];
                if (trim($text) == '' || empty($text)) $err['text'] = 'Введите сообщение';
                if (empty($err)) {
                    $type = (int) XSS_DEFENDER($_POST['type']);
                    $sth = $PDO->prepare("SELECT * FROM `respond` WHERE `user_id` = ? AND `company_id` = ? AND `status` = 6");
                    $sth->execute([XSS_DEFENDER($_POST['user']), $_SESSION['id']]);
                    if ($sth->rowCount() > 0) {
                        echo json_encode(array(
                            'code' => 'error',
                        ));
                    } else {
                        $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => XSS_DEFENDER($_POST['id'])]);
                        if (count($user) > 0) {

                            $app->execute("INSERT INTO `respond` (`status`, `date_ru`, `user_id`, `date`, `company`, `company_id`, `time`, `prof`, `age`, `salary`, `exp`, `gender`, `faculty`) 
            VALUES(:st, :dater, :ui, :d, :co, :ci, NOW(), :prof, :age, :salary, :exp, :gender, :faculty)", [
                                ':st' => 6,
                                ':dater' => $Date_ru,
                                ':ui' => $_SESSION['id'],
                                ':d' => $Date,
                                ':co' => $_SESSION['company'],
                                ':ci' => $_SESSION['id'],
                                ':prof' => $user['prof'],
                                ':age' => $user['age'],
                                ':salary' => $user['salary'],
                                ':exp' => $user['exp'],
                                ':gender' => $user['gender'],
                                ':faculty' => $user['faculty']
                            ]);

                            $app->execute("INSERT INTO `respond_user` (`user_id`, `date`, `company`, `company_id`, `time`, `status`) 
            VALUES(:ui, :d, :co, :ci, NOW(), :st)", [
                                ':ui' => $user['id'],
                                ':d' => $Date,
                                ':co' => $_SESSION['company'],
                                ':ci' => $_SESSION['id'],
                                ':st' => 6
                            ]);

                            $resp = $app->fetch("SELECT * FROM `respond` WHERE `user_id` = :ui AND `company_id` = :id AND `status` = 6", [
                                ':ui' => $user['id'],
                                ':id' => $_SESSION['id']
                            ]);

                            SENDMAIL($mail, 'Компания отправила Вам приглашение', $user['email'], $user['name'] . ' ' . $user['surname'], '
'.$text.'   
<br>                       
Компания "'.$_SESSION['company'].'" отправила Вам приглашение                        
                            ');
                            $app->execute("INSERT INTO `respond_message` (`user`, `company`, `type`, `respond`, `text`, `time`, `date`, `hour`) 
                        VALUES (:ui, :ci, :t, :ri, :text, NOW(), :dat, :h)", [
                                ':ui' => $user['id'],
                                ':ci' => $_SESSION['id'],
                                ':t' => 6,
                                ':ri' => $resp['id'],
                                ':text' => $text,
                                ':dat' => $Date,
                                ':h' => date("H:i"),
                            ]);
                            $app->execute("INSERT INTO `notice` (`type`, `title`, `date`, `hour`, `time`, `user_id`, `company_id`, `who`, `reset_status`)
                    VALUES(:typ, :title, :dat, :h, NOW(), :ui, :ci, :wh, :rt)", [
                                ':typ' => 'invite',
                                ':title' => 'Вам отправили приглашение',
                                ':dat' => $Date,
                                ':h' => date("H:i"),
                                ':ui' => $resp['user_id'],
                                ':ci' => $resp['company_id'],
                                ':wh' => 2,
                                ':rt' => 6
                            ]);
                            echo json_encode(array(
                                'code' => 'success',
                            ));
                        } else {
                            echo json_encode(array(
                                'code' => 'error',
                            ));

                        }
                    }
                } else {
                    echo json_encode(array(
                        'code' => 'validate_error',
                        'array' => $err
                    ));

                }
            } else {
                $type = (int) XSS_DEFENDER($_POST['type']);
                $sth = $PDO->prepare("SELECT * FROM `respond` WHERE `user_id` = ? AND `company_id` = ? AND `status` = 6");
                $sth->execute([XSS_DEFENDER($_POST['user']), $_SESSION['id']]);
                if ($sth->rowCount() > 0) {
                    echo json_encode(array(
                        'code' => 'error',
                    ));
                } else {
                    $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => XSS_DEFENDER($_POST['id'])]);
                    if (count($user) > 0) {
                        $app->execute("INSERT INTO `respond` (`status`, `date_ru`, `user_id`, `date`, `company`, `company_id`, `time`, `prof`, `age`, `salary`, `exp`, `gender`, `faculty`) 
            VALUES(:st, :dater, :ui, :d, :co, :ci, NOW(), :prof, :age, :salary, :exp, :gender, :faculty)", [
                            ':st' => 6,
                            ':dater' => $Date_ru,
                            ':ui' => $_SESSION['id'],
                            ':d' => $Date,
                            ':co' => $_SESSION['company'],
                            ':ci' => $_SESSION['id'],
                            ':prof' => $user['prof'],
                            ':age' => $user['age'],
                            ':salary' => $user['salary'],
                            ':exp' => $user['exp'],
                            ':gender' => $user['gender'],
                            ':faculty' => $user['faculty']
                        ]);

                        $app->execute("INSERT INTO `respond_user` (`user_id`, `date`, `company`, `company_id`, `time`, `status`) 
            VALUES(:ui, :d, :co, :ci, NOW(), :st)", [
                            ':ui' => $_SESSION['id'],
                            ':d' => $Date,
                            ':co' => $_SESSION['company'],
                            ':ci' => $_SESSION['id'],
                            ':st' => 6
                        ]);

                        $resp = $app->fetch("SELECT * FROM `respond` WHERE `user_id` = :ui AND `company_id` = :id", [
                            ':ui' => $user['id'],
                            ':id' => $_SESSION['id']
                        ]);

                        $app->execute("INSERT INTO `notice` (`type`, `title`, `date`, `hour`, `time`, `user_id`, `company_id`, `who`, `reset_status`)
                    VALUES(:typ, :title, :dat, :h, NOW(), :ui, :ci, :wh, :rt)", [
                            ':typ' => 'invite',
                            ':title' => 'Вам отправили приглашение',
                            ':dat' => $Date,
                            ':h' => date("H:i"),
                            ':ui' => $resp['user_id'],
                            ':ci' => $resp['company_id'],
                            ':wh' => 2,
                            ':rt' => 6
                        ]);

                        SENDMAIL($mail, 'Компания отправила Вам приглашение', $user['email'], $user['name'] . ' ' . $user['surname'], '
<br>                       
Компания "'.$_SESSION['company'].'" отправила Вам приглашение                        
                            ');

                        echo json_encode(array(
                            'code' => 'success',
                        ));

                    } else {
                        echo json_encode(array(
                            'code' => 'error',
                        ));
                    }
                }


            }
        }

        if (isset($_POST['MODULE_REFUSE']) && $_POST['MODULE_REFUSE'] == 1) {
            $check = XSS_DEFENDER($_POST['notext']);
            if ($check == 1) {
                $text = preg_replace("'<script[^>]*?>.*?</script>'si", "", $_POST['text']);
                $text = str_replace($xss,"",$text);
                $err = [];
                if (trim($text) == '' || empty($text)) $err['text'] = 'Введите сообщение';
                if (empty($err)) {
                    $type = (int) XSS_DEFENDER($_POST['type']);
                    $sth = $PDO->prepare("SELECT * FROM `respond` WHERE `id` = ? AND `company_id` = ? AND `status` = ?");
                    $sth->execute([XSS_DEFENDER($_POST['id']), $_SESSION['id'], $type]);
                    if ($sth->rowCount() > 0) {
                        $resp = $sth->fetch();
                        $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => XSS_DEFENDER($_POST['user'])]);
                        if (count($user) > 0) {;
                            $app->execute("UPDATE `respond_user` SET `status` = 5, `new` = 1 WHERE `user_id` = :id AND `job_id` = :ji", [
                                ':id' => $resp['user_id'],
                                ':ji' => $resp['job_id']
                            ]);
                            $app->execute("UPDATE `respond` SET `status` = 5 WHERE `id` = :id", [':id' => XSS_DEFENDER($_POST['id'])]);
                            SENDMAIL($mail, 'Изменён статус отклика', $user['email'], $user['name'] . ' ' . $user['surname'], '
'.$text.'   
<br>                       
Статус Вашего отклика изменён на "Отказ", подробнее в Вашем личном кабинете в разделе "Мои отклики".                           
                            ');
                            $app->execute("INSERT INTO `respond_message` (`user`, `company`, `job`, `type`, `respond`, `text`, `time`, `date`, `hour`) 
                        VALUES (:ui, :ci, :ji, :t, :ri, :text, NOW(), :dat, :h)", [
                                ':ui' => $user['id'],
                                ':ci' => $_SESSION['id'],
                                ':ji' => $resp['job_id'],
                                ':t' => 5,
                                ':ri' => $resp['id'],
                                ':text' => $text,
                                ':dat' => $Date,
                                ':h' => date("H:i"),
                            ]);
                            $app->execute("INSERT INTO `notice` (`type`, `title`, `date`, `hour`, `time`, `user_id`, `company_id`, `job_id`, `who`, `reset_status`)
                    VALUES(:typ, :title, :dat, :h, NOW(), :ui, :ci, :ji, :wh, :rt)", [
                                ':typ' => 'reset_status',
                                ':title' => 'Изменён статус отклика',
                                ':dat' => $Date,
                                ':h' => date("H:i"),
                                ':ui' => $resp['user_id'],
                                ':ci' => $resp['company_id'],
                                ':ji' => $resp['job_id'],
                                ':wh' => 2,
                                ':rt' => 5
                            ]);
                            echo json_encode(array(
                                'code' => 'success',
                                'count' => $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' AND `status` = 5"),
                                'countOut' => $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' AND `status` = '$type'")
                            ));
                        } else {
                            echo json_encode(array(
                                'code' => 'error',
                            ));
                        }
                    } else {
                        echo json_encode(array(
                            'code' => 'error',
                        ));
                    }
                } else {
                    echo json_encode(array(
                        'code' => 'validate_error',
                        'array' => $err
                    ));
                }
            } else {
                $type = (int) XSS_DEFENDER($_POST['type']);
                $sth = $PDO->prepare("SELECT * FROM `respond` WHERE `id` = ? AND `company_id` = ? AND `status` = ?");
                $sth->execute([XSS_DEFENDER($_POST['id']), $_SESSION['id'], $type]);
                if ($sth->rowCount() > 0) {
                    $r = $sth->fetch();
                    $app->execute("UPDATE `respond_user` SET `status` = 5, `new` = 1 WHERE `user_id` = :id AND `job_id` = :ji", [
                        ':id' => $r['user_id'],
                        ':ji' => $r['job_id']
                    ]);
                    $app->execute("UPDATE `respond` SET `status` = 5 WHERE `id` = :id", [':id' => XSS_DEFENDER($_POST['id'])]);
                    $app->execute("INSERT INTO `notice` (`type`, `title`, `date`, `hour`, `time`, `user_id`, `company_id`, `job_id`, `who`, `reset_status`)
                    VALUES(:typ, :title, :dat, :h, NOW(), :ui, :ci, :ji, :wh, :rt)", [
                        ':typ' => 'reset_status',
                        ':title' => 'Изменён статус отклика',
                        ':dat' => $Date,
                        ':h' => date("H:i"),
                        ':ui' => $r['user_id'],
                        ':ci' => $r['company_id'],
                        ':ji' => $r['job_id'],
                        ':wh' => 2,
                        ':rt' => 5
                    ]);
                    echo json_encode(array(
                        'code' => 'success',
                        'count' => $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' AND `status` = 5"),
                        'countOut' => $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' AND `status` = '$type'")
                    ));
                    SENDMAIL($mail, 'Изменён статус отклика', $user['email'], $user['name'] . ' ' . $user['surname'], '
Вакансия: '.$r['job'].'  
<br>                       
Статус Вашего отклика изменён на "Отказ", подробнее в Вашем личном кабинете в разделе "Мои отклики".                           
                            ');
                }
            }
        }

        if (isset($_POST['MODULE_ACCEPT']) && $_POST['MODULE_ACCEPT'] == 1) {
            $check = XSS_DEFENDER($_POST['notext']);
            if ($check == 1) {
                $text = preg_replace("'<script[^>]*?>.*?</script>'si", "", $_POST['text']);
                $text = str_replace($xss,"",$text);
                $day = XSS_DEFENDER($_POST['day']);
                $time = XSS_DEFENDER($_POST['time']);
                $address = XSS_DEFENDER($_POST['address']);
                $err = [];
                if (trim($text) == '' || empty($text)) $err['text'] = 'Введите сообщение';
                if (empty($err)) {
                    $type = (int) XSS_DEFENDER($_POST['type']);
                    $sth = $PDO->prepare("SELECT * FROM `respond` WHERE `id` = ? AND `company_id` = ? AND `status` = ?");
                    $sth->execute([XSS_DEFENDER($_POST['id']), $_SESSION['id'], $type]);
                    if ($sth->rowCount() > 0) {
                        $resp = $sth->fetch();
                        $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => XSS_DEFENDER($_POST['user'])]);
                        if (count($user)) {
                            $app->execute("UPDATE `respond_user` SET `status` = 4, `new` = 1 WHERE `user_id` = :id AND `job_id` = :ji", [
                                ':id' => $resp['user_id'],
                                ':ji' => $resp['job_id']
                            ]);
                            $app->execute("UPDATE `respond` SET `status` = 4 WHERE `id` = :id", [':id' => XSS_DEFENDER($_POST['id'])]);
                            SENDMAIL($mail, 'Изменён статус отклика', $user['email'], $user['name'] . ' ' . $user['surname'], '
'.$text.'   
<br>                       
Статус Вашего отклика изменён на "Принят на работу", подробнее в Вашем личном кабинете в разделе "Мои отклики".                           
                            ');
                            $app->execute("INSERT INTO `respond_message` (`user`, `company`, `job`, `type`, `respond`, `text`, `text_day`, `text_time`, `time`, `date`, `hour`, `text_address`) 
                        VALUES (:ui, :ci, :ji, :t, :ri, :text, :td, :tt, NOW(), :dat, :h, :ad)", [
                                ':ui' => $user['id'],
                                ':ci' => $_SESSION['id'],
                                ':ji' => $resp['job_id'],
                                ':t' => 4,
                                ':ri' => $resp['id'],
                                ':text' => $text,
                                ':td' => $day,
                                ':tt' => $time,
                                ':dat' => $Date,
                                ':h' => date("H:i"),
                                ':ad' => $address
                            ]);
                            $app->execute("INSERT INTO `notice` (`type`, `title`, `date`, `hour`, `time`, `user_id`, `company_id`, `job_id`, `who`, `reset_status`)
                    VALUES(:typ, :title, :dat, :h, NOW(), :ui, :ci, :ji, :wh, :rt)", [
                                ':typ' => 'reset_status',
                                ':title' => 'Изменён статус отклика',
                                ':dat' => $Date,
                                ':h' => date("H:i"),
                                ':ui' => $resp['user_id'],
                                ':ci' => $resp['company_id'],
                                ':ji' => $resp['job_id'],
                                ':wh' => 2,
                                ':rt' => 4
                            ]);
                            echo json_encode(array(
                                'code' => 'success',
                                'count' => $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' AND `status` = 4"),
                                'countOut' => $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' AND `status` = '$type'")
                            ));
                        } else {
                            echo json_encode(array(
                                'code' => 'error',
                            ));
                        }
                    } else {
                        echo json_encode(array(
                            'code' => 'error',
                        ));
                    }
                } else {
                    echo json_encode(array(
                        'code' => 'validate_error',
                        'array' => $err
                    ));
                }
            } else {
                $type = (int) XSS_DEFENDER($_POST['type']);
                $sth = $PDO->prepare("SELECT * FROM `respond` WHERE `id` = ? AND `company_id` = ? AND `status` = ?");
                $sth->execute([XSS_DEFENDER($_POST['id']), $_SESSION['id'], $type]);
                if ($sth->rowCount() > 0) {
                    $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => XSS_DEFENDER($_POST['user'])]);
                    $r = $sth->fetch();
                    $app->execute("UPDATE `respond_user` SET `status` = 4, `new` = 1 WHERE `user_id` = :id AND `job_id` = :ji", [
                        ':id' => $r['user_id'],
                        ':ji' => $r['job_id']
                    ]);
                    $app->execute("UPDATE `respond` SET `status` = 4 WHERE `id` = :id", [':id' => XSS_DEFENDER($_POST['id'])]);
                    echo json_encode(array(
                        'code' => 'success',
                        'count' => $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' AND `status` = 4"),
                        'countOut' => $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' AND `status` = '$type'")
                    ));
                    $app->execute("INSERT INTO `notice` (`type`, `title`, `date`, `hour`, `time`, `user_id`, `company_id`, `job_id`, `who`, `reset_status`)
                    VALUES(:typ, :title, :dat, :h, NOW(), :ui, :ci, :ji, :wh, :rt)", [
                        ':typ' => 'reset_status',
                        ':title' => 'Изменён статус отклика',
                        ':dat' => $Date,
                        ':h' => date("H:i"),
                        ':ui' => $r['user_id'],
                        ':ci' => $r['company_id'],
                        ':ji' => $r['job_id'],
                        ':wh' => 2,
                        ':rt' => 4
                    ]);
                    SENDMAIL($mail, 'Изменён статус отклика', $user['email'], $user['name'] . ' ' . $user['surname'], '
Вакансия: '.$r['job'].'  
<br>                       
Статус Вашего отклика изменён на "Принят на работу", подробнее в Вашем личном кабинете в разделе "Мои отклики".                           
                            ');
                }
            }
        }

        if (isset($_POST['MODULE_MEETING']) && $_POST['MODULE_MEETING'] == 1) {
            $check = XSS_DEFENDER($_POST['notext']);
            if ($check == 1) {
                $text = preg_replace("'<script[^>]*?>.*?</script>'si", "", $_POST['text']);
                $text = str_replace($xss,"",$text);
                $day = XSS_DEFENDER($_POST['day']);
                $time = XSS_DEFENDER($_POST['time']);
                $address = XSS_DEFENDER($_POST['address']);

                $err = [];
                if (trim($text) == '' || empty($text)) $err['text'] = 'Введите сообщение';
                if (trim($day) == '' || empty($day)) $err['day'] = 'Введите день';
                if (trim($time) == '' || empty($time)) $err['time'] = 'Укажите время';
                if (trim($address) == '' || empty($address)) $err['address'] = 'Введите адресс';

                if (empty($err)) {
                    $type = (int) XSS_DEFENDER($_POST['type']);
                    $sth = $PDO->prepare("SELECT * FROM `respond` WHERE `id` = ? AND `company_id` = ? AND `status` = ?");
                    $sth->execute([XSS_DEFENDER($_POST['id']), $_SESSION['id'], $type]);
                    if ($sth->rowCount() > 0) {
                        $resp = $sth->fetch();

                        $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => XSS_DEFENDER($_POST['user'])]);

                        if (count($user)) {

                            $app->execute("UPDATE `respond_user` SET `status` = 3, `new` = 1 WHERE `user_id` = :id AND `job_id` = :ji", [
                                ':id' => $resp['user_id'],
                                ':ji' => $resp['job_id']
                            ]);

                            $app->execute("UPDATE `respond` SET `status` = 3 WHERE `id` = :id", [':id' => XSS_DEFENDER($_POST['id'])]);
                            SENDMAIL($mail, 'Изменён статус отклика', $user['email'], $user['name'] . ' ' . $user['surname'], '
'.$text.'   
<br>                       
Статус Вашего отклика изменён на "Собеседование", подробнее в Вашем личном кабинете в разделе "Мои отклики".                           
                            ');
                            $app->execute("INSERT INTO `respond_message` (`user`, `company`, `job`, `type`, `respond`, `text`, `text_day`, `text_time`, `time`, `date`, `hour`, `text_address`) 
                        VALUES (:ui, :ci, :ji, :t, :ri, :text, :td, :tt, NOW(), :dat, :h, :ad)", [
                                ':ui' => $user['id'],
                                ':ci' => $_SESSION['id'],
                                ':ji' => $resp['job_id'],
                                ':t' => 3,
                                ':ri' => $resp['id'],
                                ':text' => $text,
                                ':td' => $day,
                                ':tt' => $time,
                                ':dat' => $Date,
                                ':h' => date("H:i"),
                                ':ad' => $address
                            ]);

                            $app->execute("INSERT INTO `notice` (`type`, `title`, `date`, `hour`, `time`, `user_id`, `company_id`, `job_id`, `who`, `reset_status`)
                    VALUES(:typ, :title, :dat, :h, NOW(), :ui, :ci, :ji, :wh, :rt)", [
                                ':typ' => 'reset_status',
                                ':title' => 'Изменён статус отклика',
                                ':dat' => $Date,
                                ':h' => date("H:i"),
                                ':ui' => $resp['user_id'],
                                ':ci' => $resp['company_id'],
                                ':ji' => $resp['job_id'],
                                ':wh' => 2,
                                ':rt' => 3
                            ]);

                            echo json_encode(array(
                                'code' => 'success',
                                'count' => $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' AND `status` = 3"),
                                'countOut' => $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' AND `status` = '$type'")
                            ));
                        } else {
                            echo json_encode(array(
                                'code' => 'error',
                            ));
                        }
                    } else {
                        echo json_encode(array(
                            'code' => 'error',
                        ));
                    }
                } else {
                    echo json_encode(array(
                        'code' => 'validate_error',
                        'array' => $err
                    ));
                }
            } else {
                $type = (int) XSS_DEFENDER($_POST['type']);
                $sth = $PDO->prepare("SELECT * FROM `respond` WHERE `id` = ? AND `company_id` = ? AND `status` = ?");
                $sth->execute([XSS_DEFENDER($_POST['id']), $_SESSION['id'], $type]);
                if ($sth->rowCount() > 0) {
                    $r = $sth->fetch();
                    $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => XSS_DEFENDER($_POST['user'])]);
                    $app->execute("UPDATE `respond_user` SET `status` = 3, `new` = 1 WHERE `user_id` = :id AND `job_id` = :ji", [
                        ':id' => $r['user_id'],
                        ':ji' => $r['job_id']
                    ]);
                    $app->execute("UPDATE `respond` SET `status` = 3 WHERE `id` = :id", [':id' => XSS_DEFENDER($_POST['id'])]);
                    echo json_encode(array(
                        'code' => 'success',
                        'count' => $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' AND `status` = 3"),
                        'countOut' => $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' AND `status` = '$type'")
                    ));
                    $app->execute("INSERT INTO `notice` (`type`, `title`, `date`, `hour`, `time`, `user_id`, `company_id`, `job_id`, `who`, `reset_status`)
                    VALUES(:typ, :title, :dat, :h, NOW(), :ui, :ci, :ji, :wh, :rt)", [
                        ':typ' => 'reset_status',
                        ':title' => 'Изменён статус отклика',
                        ':dat' => $Date,
                        ':h' => date("H:i"),
                        ':ui' => $r['user_id'],
                        ':ci' => $r['company_id'],
                        ':ji' => $r['job_id'],
                        ':wh' => 2,
                        ':rt' => 3
                    ]);
                    SENDMAIL($mail, 'Изменён статус отклика', $user['email'], $user['name'] . ' ' . $user['surname'], '
Вакансия: '.$r['job'].'  
<br>                       
Статус Вашего отклика изменён на "Собеседование", подробнее в Вашем личном кабинете в разделе "Мои отклики".                           
                            ');
                }
            }
        }

        if (isset($_POST['MODULE_TALK']) && $_POST['MODULE_TALK'] == 1) {
            $check = XSS_DEFENDER($_POST['notext']);
            if ($check == 1) {
                $day = XSS_DEFENDER($_POST['day']);
                $time = XSS_DEFENDER($_POST['time']);
                $text = preg_replace("'<script[^>]*?>.*?</script>'si", "", $_POST['text']);
                $text = str_replace($xss,"",$text);

                $err = [];
                if (trim($text) == '' || empty($text)) $err['text'] = 'Введите сообщение';
                if (trim($day) == '' || empty($day)) $err['day'] = 'Введите день';
                if (trim($time) == '' || empty($time)) $err['time'] = 'Укажите время';

                if (empty($err)) {
                    $type = (int) XSS_DEFENDER($_POST['type']);
                    $sth = $PDO->prepare("SELECT * FROM `respond` WHERE `id` = ? AND `company_id` = ? AND `status` = ?");
                    $sth->execute([XSS_DEFENDER($_POST['id']), $_SESSION['id'], $type]);
                    if ($sth->rowCount() > 0) {
                        $resp = $sth->fetch();

                        $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => XSS_DEFENDER($_POST['user'])]);

                        if (count($user)) {
                            $app->execute("UPDATE `respond_user` SET `status` = 2, `new` = 1 WHERE `user_id` = :id AND `job_id` = :ji", [
                                ':id' => $resp['user_id'],
                                ':ji' => $resp['job_id']
                            ]);

                            $app->execute("UPDATE `respond` SET `status` = 2 WHERE `id` = :id", [':id' => XSS_DEFENDER($_POST['id'])]);

                            SENDMAIL($mail, 'Изменён статус отклика', $user['email'], $user['name'] . ' ' . $user['surname'], '
'.$text.'   
<br>                       
Статус Вашего отклика изменён на "Разговор по телефону", подробнее в Вашем личном кабинете в разделе "Мои отклики".                           
                            ');

                            $app->execute("INSERT INTO `respond_message` (`user`, `company`, `job`, `type`, `respond`, `text`, `text_day`, `text_time`, `time`, `date`, `hour`) 
                        VALUES (:ui, :ci, :ji, :t, :ri, :text, :td, :tt, NOW(), :dat, :h)", [
                                ':ui' => $user['id'],
                                ':ci' => $_SESSION['id'],
                                ':ji' => $resp['job_id'],
                                ':t' => 2,
                                ':ri' => $resp['id'],
                                ':text' => $text,
                                ':td' => $day,
                                ':tt' => $time,
                                ':dat' => $Date,
                                ':h' => date("H:i")
                            ]);

                            $app->execute("INSERT INTO `notice` (`type`, `title`, `date`, `hour`, `time`, `user_id`, `company_id`, `job_id`, `who`, `reset_status`)
                    VALUES(:typ, :title, :dat, :h, NOW(), :ui, :ci, :ji, :wh, :rt)", [
                                ':typ' => 'reset_status',
                                ':title' => 'Изменён статус отклика',
                                ':dat' => $Date,
                                ':h' => date("H:i"),
                                ':ui' => $resp['user_id'],
                                ':ci' => $resp['company_id'],
                                ':ji' => $resp['job_id'],
                                ':wh' => 2,
                                ':rt' => 2
                            ]);

                            echo json_encode(array(
                                'code' => 'success',
                                'count' => $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' AND `status` = 2"),
                                'countOut' => $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' AND `status` = '$type'")
                            ));
                        } else {
                            echo json_encode(array(
                                'code' => 'error',
                            ));
                        }
                    } else {
                        echo json_encode(array(
                            'code' => 'error',
                        ));
                    }

                } else {
                    echo json_encode(array(
                        'code' => 'validate_error',
                        'array' => $err
                    ));
                }
            } else {
                $type = (int) XSS_DEFENDER($_POST['type']);
                $sth = $PDO->prepare("SELECT * FROM `respond` WHERE `id` = ? AND `company_id` = ? AND `status` = ?");
                $sth->execute([XSS_DEFENDER($_POST['id']), $_SESSION['id'], $type]);
                if ($sth->rowCount() > 0) {
                    $r = $sth->fetch();
                    $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => XSS_DEFENDER($_POST['user'])]);
                    $app->execute("UPDATE `respond_user` SET `status` = 2, `new` = 1 WHERE `user_id` = :id AND `job_id` = :ji", [
                        ':id' => $r['user_id'],
                        ':ji' => $r['job_id']
                    ]);
                    $app->execute("UPDATE `respond` SET `status` = 2 WHERE `id` = :id", [':id' => XSS_DEFENDER($_POST['id'])]);
                    echo json_encode(array(
                        'code' => 'success',
                        'count' => $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' AND `status` = 2"),
                        'countOut' => $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' AND `status` = '$type'")
                    ));
                    $app->execute("INSERT INTO `notice` (`type`, `title`, `date`, `hour`, `time`, `user_id`, `company_id`, `job_id`, `who`, `reset_status`)
                    VALUES(:typ, :title, :dat, :h, NOW(), :ui, :ci, :ji, :wh, :rt)", [
                        ':typ' => 'reset_status',
                        ':title' => 'Изменён статус отклика',
                        ':dat' => $Date,
                        ':h' => date("H:i"),
                        ':ui' => $r['user_id'],
                        ':ci' => $r['company_id'],
                        ':ji' => $r['job_id'],
                        ':wh' => 2,
                        ':rt' => 2
                    ]);
                    SENDMAIL($mail, 'Изменён статус отклика', $user['email'], $user['name'] . ' ' . $user['surname'], '
Вакансия: '.$r['job'].'  
<br>                       
Статус Вашего отклика изменён на "Разговор по телефону", подробнее в Вашем личном кабинете в разделе "Мои отклики".                           
                            ');
                }
            }
        }

        if (isset($_POST['MODULE_THINK']) && $_POST['MODULE_THINK'] == 1) {
            $sth = $PDO->prepare("SELECT * FROM `respond` WHERE `id` = ? AND `company_id` = ? AND `status` = 0");
            $sth->execute([XSS_DEFENDER($_POST['id']), $_SESSION['id']]);
            if ($sth->rowCount() > 0) {
                $r = $sth->fetch();
                $app->execute("UPDATE `respond_user` SET `status` = 1, `new` = 1 WHERE `user_id` = :id AND `job_id` = :ji", [
                    ':id' => $r['user_id'],
                    ':ji' => $r['job_id']
                ]);
                $app->execute("UPDATE `respond` SET `status` = 1 WHERE `id` = :id", [':id' => XSS_DEFENDER($_POST['id'])]);
                echo json_encode(array(
                    'code' => 'success',
                    'count' => $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' AND `status` = 1"),
                    'countOut' => $app->count("SELECT * FROM `respond` WHERE `company_id` = '$_SESSION[id]' AND `status` = 0")
                ));
            }
        }

        if (isset($_POST['MODULE_GET_LIST']) && $_POST['MODULE_GET_LIST'] == 1) {
            function getOptions()
            {
                $salary = (isset($_POST['salary'])) ? (int) $_POST['salary'] : 0;
                $id = (isset($_POST['id'])) ? (int) $_POST['id'] : null;
                $exp = (isset($_POST['exp'])) ? $_POST['exp'] : null;
                $gender = (isset($_POST['gender'])) ? $_POST['gender'] : null;
                $key = (isset($_POST['key'])) ? $_POST['key'] : null;
                $loc = (isset($_POST['loc'])) ? (int) $_POST['loc'] : null;
                $ageTo = (isset($_POST['ageTo'])) ?  (int) $_POST['ageTo'] : null;
                $ageFrom = (isset($_POST['ageFrom'])) ?  (int) $_POST['ageFrom'] : null;
                $f = (isset($_POST['faculty'])) ? (int) $_POST['faculty'] : null;
                $sort = (isset($_POST['sort'])) ?  (int) $_POST['sort'] : null;
                $type = (isset($_POST['t'])) ? (int) $_POST['t'] : null;
                $page = (isset($_POST['page'])) ? (int) $_POST['page'] : null;

                return array(
                    'salary' => $salary,
                    'id' => $id,
                    'exp' => $exp,
                    'gender' => $gender,
                    'key' => $key,
                    'loc' => $loc,
                    'ageTo' => $ageTo,
                    'ageFrom' => $ageFrom,
                    'sort' => $sort,
                    'faculty' => $f,
                    'type' => $type,
                    'page' => $page,
                );
            }

            function getData($options, $PDO, $app) {

                $salary = intval($options['salary']);
                $id = intval($options['id']);
                $exp = $options['exp'];
                $gender = $options['gender'];
                $key = $options['key'];
                $loc = intval($options['loc']);
                $ageTo = $options['ageTo'];
                $ageFrom = $options['ageFrom'];
                $sort = $options['sort'];
                $f = $options['faculty'];
                $type = $options['type'];
                $page = (int) $options['page'];
                if ($page == 0) $page++;
                $limit = 15;

                $start = ($page - 1) * $limit;

                $list = "";
                $pagination = "";
                $countAll = 0;
                $count = 0;

                if ($exp != null) {
                    foreach ($exp as $val => $item) {
                        if ($item == 1) $exp[$val] = '"Без опыта"';
                        if ($item == 2) $exp[$val] = '"1-3 года"';
                        if ($item == 3) $exp[$val] = '"3-6 лет"';
                        if ($item == 4) $exp[$val] = '"Более 6 лет"';
                    }
                    $exp = implode(', ', $exp);
                }

                if ($gender == 1) $gender = 'Мужской';
                else if ($gender == 2) $gender = 'Женский';
                else $gender = null;

                if ($f == 1) $f = 'Факультет агробиологии и земельных ресурсов';
                else if ($f == 2) $f = 'Факультет экологии и ландшафтной архитектуры';
                else if ($f == 3) $f = 'Экономический факультет';
                else if ($f == 4) $f = 'Инженерно-технологический факультет';
                else if ($f == 5) $f = 'Биотехнологический факультет';
                else if ($f == 6) $f = 'Факультет социально-культурного сервиса и туризма';
                else if ($f == 7) $f = 'Электроэнергетический факультет';
                else if ($f == 8) $f = 'Учетно-финансовый факультет';
                else if ($f == 9) $f = 'Факультет ветеринарной медицины';
                else if ($f == 10) $f = 'Факультет среднего профессионального образования';
                else $f = null;

                if ($type == 0 || $type == 1 || $type == 2 || $type == 3 || $type == 4 || $type == 5 || $type == 6 || $type == 10) {
                    $where = "";

                    if ($key != null && $loc == 1) $where = addWhere($where, "`prof` LIKE '%$key%'");
                    if ($key != null && $loc == null) $where = addWhere($where, "`prof` LIKE '%$key%'");
                    if ($key != null && $loc == 2) $where = addWhere($where, "`job` LIKE '%$key%'");
                    if ($key != null && $type == 10) $where = addWhere($where, "`prof` LIKE '%$key%'");
                    if ($ageTo != null && $ageFrom == null) $where = addWhere($where, "`age` >= $ageTo");
                    if ($ageTo == null && $ageFrom != null) $where = addWhere($where, "`age` <= $ageFrom");
                    if ($ageTo != null && $ageFrom != null) $where = addWhere($where, "`age` >= $ageTo AND `age` <= $ageFrom");
                    if ($salary > 0) $where = addWhere($where, "`salary` < $salary AND `salary` != ''");
                    if ($salary == null) $where = addWhere($where, "`salary` = ''");
                    if ($salary == 0) $where = addWhere($where, "`salary` = 0");
                    if ($exp != null) $where = addWhere($where, "`exp` IN ($exp)");
                    if ($gender != null) $where = addWhere($where, "`gender` LIKE '%$gender%'");
                    if ($f != null) $where = addWhere($where, "`faculty` LIKE '%$f%'");
                    $where = addWhere($where, "`company_id` = $_SESSION[id]");
                    if ($type != 10) { $where = addWhere($where, "`status` = $type" );}
                    if ($id != null) { $where = addWhere($where, "`job_id` = $id" );}
                    $sql = "SELECT * FROM `respond`";
                    $sql2 = "SELECT * FROM `respond`";
                    if ($where) {
                        $sql .= " WHERE $where";
                        $sql2 .= " WHERE $where";
                    }

                    if ($sort != null) {
                        if ($sort == 1) {
                            $sql .= " ORDER BY `salary` DESC LIMIT $start, $limit";
                            $sql2 .= " ORDER BY `salary` DESC";
                        }
                        if ($sort == 2) {
                            $sql .= " ORDER BY `id` DESC LIMIT $start, $limit";
                            $sql2 .= " ORDER BY `id` DESC";
                        }
                    } else {
                        $sql .= " ORDER BY `id` DESC LIMIT $start, $limit";
                        $sql2 .= " ORDER BY `id` DESC";
                    }


                    $stmt2 = $PDO->prepare($sql2);
                    $stmt2->execute();
                    $countAll = $stmt2->rowCount();

                    $stmt = $PDO->prepare($sql);
                    $stmt->execute();
                    $count = $stmt->rowCount();

                    if ($count > 0) {
                        $list .= "<div class=\"respond-list\">";
                        while ($data = $stmt->fetch()) {
                            $job = $app->fetch("SELECT * FROM `vacancy` WHERE `id` = :id", [':id' => $data['job_id']]);
                            $sql = "SELECT * FROM `users` WHERE `id` = :id";
                            $sth_1 = $PDO->prepare($sql);
                            $sth_1->execute([intval($data['user_id'])]);
                            if ($sth_1->rowCount() > 0) {
                                $r = $sth_1->fetch();

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

                                $sqled = "SELECT * FROM `exp` WHERE `user_id` = :t";
                                $stmted = $PDO->prepare($sqled);
                                $stmted->bindValue(':t', $r['id']);
                                $stmted->execute();
                                $exp = '';
                                if ($stmted->rowCount() > 0) {
                                    $exp .= '<div class="re-detail">
                                        <span>Опыт работы</span>';
                                    while ($rx = $stmted->fetch()) {
                                        $date1_show = $arr_m[(DateTime::createFromFormat('m.Y', $rx['date_1'])->format('n'))] . ' ' .
                                            DateTime::createFromFormat('m.Y', $rx['date_1'])->format('Y') .  ' — ';
                                        $date2_show = '';
                                        if ($rx['present'] == 1) {
                                            $date2_show = 'по настоящее время';
                                        } else {
                                            $date2_show = $arr_m[(DateTime::createFromFormat('m.Y', $rx['date_2'])->format('n'))] . ' ' .
                                                DateTime::createFromFormat('m.Y', $rx['date_2'])->format('Y');
                                        }


                                        $exp .= '<div><span>'.$rx['title'].', </span> <m> '.$date1_show.$date2_show.' — '.$rx['prof'].'</m></div>';
                                    }
                                    $exp .= '</div>';
                                }

                                $sqled = "SELECT * FROM `education` WHERE `user_id` = :t";
                                $stmted = $PDO->prepare($sqled);
                                $stmted->bindValue(':t', $r['id']);
                                $stmted->execute();
                                if ($stmted->rowCount() > 0) {
                                    $exp .= '<div class="re-detail">
                                        <span>Образование</span>';
                                    while ($rx = $stmted->fetch()) {
                                        $exp .= '<div><span>'.$rx['title'].', </span> <m> '.$rx['date'].' — '.$rx['prof'].'</m></div>';
                                    }
                                    $exp .= '</div>';
                                }

                                $sqlsk = "SELECT * FROM `lang` WHERE `user` = :t ORDER BY `id` DESC";
                                $stmtsk = $PDO->prepare($sqlsk);
                                $stmtsk->bindValue(':t', (int) $r['id']);
                                $stmtsk->execute();
                                if ($stmtsk->rowCount() > 0) {
                                    $exp .= '<div class="re-detail">
                                        <span>Знание языков</span>';
                                    while ($re = $stmtsk->fetch()) {
                                        $exp .= '<div><m>'.$re['name'].' — '.$re['lvl'].'</m></div>';
                                    }
                                    $exp .= '</div>';
                                }

                                if (trim($r['vk']) != '' || trim($r['telegram']) != '' || trim($r['github']) != '' || trim($r['skype']) != '') {
                                    $exp .= '<div class="re-detail">
                                        <span>Ссылки</span>';

                                    if (trim($r['vk']) != '') {
                                        $exp .= '<div><m>VK — '.$r['vk'].'</m></div>';
                                    }

                                    if (trim($r['telegram']) != '') {
                                        $exp .= '<div><m>Telegram — '.$r['telegram'].'</m></div>';
                                    }

                                    if (trim($r['github']) != '') {
                                        $exp .= '<div><m>GitHub — '.$r['github'].'</m></div>';
                                    }

                                    if (trim($r['skype']) != '') {
                                        $exp .= '<div><m>Skype — '.$r['skype'].'</m></div>';
                                    }

                                    $exp .= '</div>';
                                }

                                $ctx = '';

                                if (!empty($r['exp'])) {
                                    $ctx .= '
                                        <li>
                                            <span>Опыт работы</span>
                                            <span>'.$r['exp'].'</span>
                                        </li> 
                                ';
                                }

                                if (!empty($r['degree'])) {
                                    $ctx .= '
                                        <li>
                                            <span>Образование</span>
                                            <span>'.$r['degree'].'</span>
                                        </li> 
                                ';
                                }

                                if (!empty($r['time'])) {
                                    $ctx .= '
                                        <li>
                                            <span>График работы</span>
                                            <span>'.$r['time'].'</span>
                                        </li> 
                                ';
                                }

                                if (!empty($r['type'])) {
                                    $ctx .= '
                                        <li>
                                            <span>Тип занятости</span>
                                            <span>'.$r['type'].'</span>
                                        </li> 
                                ';
                                }

                                if (!empty($r['drive'])) {
                                    $ctx .= '
                                        <li>
                                            <span>Водительские права</span>
                                            <span>'.$r['drive'].'</span>
                                        </li> 
                                ';
                                }

                                if (!empty($r['age']) && $r['age'] >= 10) {
                                    $ctx .= '
                                        <li>
                                            <span>Возраст</span>
                                            <span>'.$r['age'].'</span>
                                        </li> 
                                ';
                                }

                                if (!empty($r['gender'])) {
                                    $ctx .= '
                                        <li>
                                            <span>Пол</span>
                                            <span>'.$r['gender'].'</span>
                                        </li> 
                                ';
                                }


                                $chatCount = $app->rowCount("SELECT * FROM `chat` WHERE `user_id` = :ui AND `company_id` = :ci", [
                                    ':ui' => $r['id'],
                                    ':ci' => $job['company_id']
                                ]);

                                $chat = '';

                                if ($chatCount > 0) {

                                    $chats = $app->fetch("SELECT * FROM `chat` WHERE `user_id` = :ui AND `company_id` = :ci", [
                                        ':ui' => $r['id'],
                                        ':ci' => $job['company_id']
                                    ]);

                                    $chat = '<button type="button"><a target="_blank" href="/messages/?id='.$chats['id'].'">Перейти в чат</a></button>';
                                }

                                $button = '';

                                $jobs = "'$job[title]'";
                                $name = "'$r[name] $r[surname] - $r[prof]'";
                                $f = "'$r[name]'";

                                if ($type == 1 || $type == 0) {
                                    $button = '<button onclick="createRefuse('.$data['id'].', '.$r['id'].', '.$jobs.', '.$name.', '.$f.', '.$type.', '.$r['id'].')" type="button">Отказать</button>
                                     <button onclick="createTalk('.$data['id'].', '.$r['id'].', '.$jobs.', '.$name.', '.$f.', '.$type.', '.$r['id'].')" type="button">Разговор по телефону</button>';
                                } else if ($type == 2) {
                                    $button = '<button onclick="createRefuse('.$data['id'].', '.$r['id'].', '.$jobs.', '.$name.', '.$f.', '.$type.', '.$r['id'].')" type="button">Отказать</button>
                                     <button onclick="createMeeting('.$data['id'].', '.$r['id'].', '.$jobs.', '.$name.', '.$f.', '.$type.', '.$r['id'].')" type="button">Назначить собеседование</button>';
                                } else if ($type == 3) {
                                    $button = '<button onclick="createRefuse('.$data['id'].', '.$r['id'].', '.$jobs.', '.$name.', '.$f.', '.$type.', '.$r['id'].')" type="button">Отказать</button>
                                     <button onclick="createAccept('.$data['id'].', '.$r['id'].', '.$jobs.', '.$name.', '.$f.', '.$type.', '.$r['id'].')" type="button">Принять на работу</button>
                                     ';
                                } else if ($type == 4 || $type == 5 || $type == 6) {
                                    $button = '<button onclick="respondArch('.$data['id'].', '.$type.')" type="button">В архив</button>';
                                }

                                $letter_t = '';

                                if (trim($data['text']) != '') {
                                    $letter_t = '<div class="re-200-mini">Сопроводительное письмо: ' . $data['text'] . '</div>';
                                }


                                $click = "$('.item-$data[id]').slideToggle(100);$(this).toggleClass('resp-rotate');$('.respond-item-$data[id]').toggleClass('item-active')";
                                $list .= '
                            <div class="respond-item respond-item-'.$data['id'].'">
                                <div class="resp-top">
                                    <div class="re-name">
                                        <a target="_blank" href="/resume/?id='.$r['id'].'">'.$r['name'] . ' ' . $r['surname'].' - '.$r['prof'].' </a>
                                        <span onclick="'.$click.'"><i class="fa-solid fa-chevron-down"></i></span>
                                    </div>                    
                                    '. ($type != 10 && $type != 6 && $type != 7 ? '<div class="re-title"><a target="_blank" href="/job/?id='.$job['id'].'" target="_blank">Вакансия - '.$job['title'].'</a></div>' : '' ) . '
                                    <span class="re-200">
                                    '. (!empty($r['salary']) ? $r['salary'] . ' руб.' : 'По договорённости' ) . '
                                    </span>
                                    '.$letter_t.'
                                </div>
                                <div class="resp-content item-'.$data['id'].'">
                                    <ul class="re-ul">
                                        '.$ctx.'
                                    </ul>
                                    '.$exp.'
                                    <div class="re-about">
                                        <pre>'.$r['about'].'</pre>
                                    </div>
                                </div>
                                <div class="re-flex">
                                    <span class="re-300">Обновлено '.$r['last_save'].',</span>
                                   
                                    <span class="re-300">Откликнулся '.DateTime::createFromFormat('Y-m-d H:i:s', $data['time'])->format('d.m.Y H:i').'</span>
                                </div>
                                <div class="re-flex-2">
                                    <span><i class="mdi mdi-phone"></i> '.$r['phone'].'</span>
                                     <span><i class="mdi mdi-at"></i> '.$r['email'].'</span>
                                </div>
                                <div class="resp-bth">
                                     '.$button.'
                                     '.$chat.'
                                </div>
                                <span class="user-resp-img">
                                <img src="/static/image/users/'.$r['img'].'" alt="">
</span>
                            </div>
       
                            ';
                            }
                        }
                        $list .= "</div>";
                    } else {
                        $list = '<span class="vac-none">Отклики не найдены</span>';
                    }

                } else {
                    $list = '<span class="vac-none">Отклики не найдены</span>';
                }


                $countPages = ceil($countAll / $limit);
                $mid_size = 2;

                if ($countAll > $limit) {

                    if ($page > $mid_size + 1) {
                        $start_page = '<div data-page="1"><a href><i class="fa-solid fa-angles-left"></i></a></div>';
                    }

                    if ($page < ($countPages - $mid_size)) {
                        $end_page = '<div data-page="' . $countPages . '"><a href><!--<i class="fa-solid fa-angles-right"></i></a>-->' . $countPages . '</div>';
                    }


                    if ($page < (($countPages - $mid_size) - 1)) {
                        $last = '<span>...</span>';
                    }

                    /*if ($page > 1) {
                        $back = '<div data-page="'.($page - 1).'"><a href><i class="fa-solid fa-chevron-left"></i></a></div>';
                    }*/

                    if ($page < $countPages) {
                        $forward = '<div data-page="' . ($page + 1) . '"><a href><i class="fa-solid fa-chevron-right"></i></a></div>';
                    }

                    $page_left = '';
                    for ($i = $mid_size; $i > 0; $i--) {
                        if ($page - $i > 0) {
                            $page_left .= '<div data-page="' . ($page - $i) . '"><a href>' . ($page - $i) . '</a></div>';
                        }
                    }

                    $page_right = '';
                    for ($i = 1; $i <= $mid_size; $i++) {
                        if ($page + $i <= $countPages) {
                            $page_right .= '<div data-page="' . ($page + $i) . '"><a href>' . ($page + $i) . '</a></div>';
                        }
                    }


                    $pagination = $start_page . $page_left . '<div class="page-active" data-page="' . $page . '"><a href>' . $page . '</a></div>' . $page_right . $last . $end_page . $forward;

                } else {
                    $pagination = "";
                }


                return array (
                    'list' => $list,
                    'pagination' => $pagination,
                    'countText' => $count,
                    'count' => "Найдено $count откликов",
                    'type' => $type,
                );
            }

            $d = getOptions();

            echo json_encode(array(
                'code' => 'success',
                'data' => getData(getOptions(), $PDO, $app)
            ));
        }

    } catch (Exception $e) {
        echo json_encode(array(
            'code' => 'error',
            'message' => $e->getMessage()
        ));
    }

} else {
    $app->notFound();
}

session_write_close();

exit;

