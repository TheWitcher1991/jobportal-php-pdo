<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $app->notFound();
    exit;
}

if (isset($_SESSION['id']) && $_SESSION['type'] == 'company') {

    try {

        if (isset($_POST['MODULE_CREATE_JOB']) && $_POST['MODULE_CREATE_JOB'] == 1) {

            $err = array();

            if (empty($_POST['date']) || ($_POST['date'] <= date('Y-m-d'))) $err['date'] = 'Дата указана неверно';
            if (empty($_POST['title']) || trim($_POST['title']) == '') $err['title'] = 'Введите название';
            if (empty($_POST['region']) || trim($_POST['region']) == '') $err['region'] = 'Укажите регион';
            if (
                ((isset($_POST['region']) || trim($_POST['region']) != '') && $_POST['region'] != 'Ставропольский край')
                && (empty($_POST['address']) || trim($_POST['address']) == '')
            ) $err['address'] = 'Выберите населённый пункт';
            if (
                ((isset($_POST['region']) || trim($_POST['region']) != '') && $_POST['region'] == 'Ставропольский край')
                && (empty($_POST['area']) || trim($_POST['area']) == '')
            ) $err['area'] = 'Выберите район';
            if (
                ((isset($_POST['region']) || trim($_POST['region']) != '') && $_POST['region'] == 'Ставропольский край')
                && (isset($_POST['area']) || trim($_POST['area']) != '')
                && (empty($_POST['address']) || trim($_POST['address']) == '')
            ) $err['address'] = 'Выберите населённый пункт';
            if (empty($_POST['email']) || trim($_POST['email']) == '') $err['email'] = 'Введите  email';
            if (empty($_POST['phone']) || trim($_POST['phone']) == '') $err['tel'] = 'Введите  телефон';
            if (empty(strip_tags($_POST['text'])) || trim(strip_tags($_POST['text'])) == '') $err['text'] = 'Введите текст';
            if (empty($_POST['exp']) || trim($_POST['exp']) == '') $err['exp'] = 'Укажите опыт работы';
            if (empty($_POST['time']) || trim($_POST['time']) == '') $err['time'] = 'Укажите график работы';
            if (empty($_POST['job_type']) || trim($_POST['job_type']) == '') $err['job_type'] = 'Укажите тип занятости';
            if (empty($_POST['category']) || trim($_POST['category']) == '') $err['category'] = 'Укажите сферу деятельности';


            if (empty($err)) {

                $r = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $_SESSION['id']]);


                if (isset($r['id'])) {
                    $title = preg_replace("'<script[^>]*?>.*?</script>'si", "", $_POST['title']);
                    $title = str_replace($xss, "", $title);
                    $text = preg_replace("'<script[^>]*?>.*?</script>'si", "", $_POST['text']);
                    $text = str_replace($xss, "", $text);
                    $category = XSS_DEFENDER($_POST['category']);
                    $del = XSS_DEFENDER($_POST['date']);
                    $username = XSS_DEFENDER($_POST['username']);
                    $phone = XSS_DEFENDER($_POST['phone']);
                    $email = XSS_DEFENDER($_POST['email']);
                    $region = XSS_DEFENDER($_POST['region']);
                    $address = XSS_DEFENDER($_POST['address']);
                    $salary = XSS_DEFENDER($_POST['salary']);
                    $salary_end = XSS_DEFENDER($_POST['salary_end']);
                    $time = XSS_DEFENDER($_POST['time']);
                    $exp = XSS_DEFENDER($_POST['exp']);
                    $job_type = XSS_DEFENDER($_POST['job_type']);
                    $dog = $_POST['salary_dog'];
                    if ($dog == 1) {
                        $salary = '';
                        $salary_end = '';
                    } else {
                        $salary = (int)XSS_DEFENDER($_POST['salary']);
                        $salary_end = (int)XSS_DEFENDER($_POST['salary_end']);
                    }
                    if ($_POST['urid']) {
                        $urid = $_POST['urid'];
                    } else {
                        $urid = '';
                    }
                    $degree = '';
                    if ($_POST['degree']) {
                        $degree = XSS_DEFENDER($_POST['degree']);
                    } else {
                        $degree = '';
                    }
                    $status = $_POST['invalid'];
                    if ($status == 1) {
                        $status = 1;
                    } else {
                        $status = 0;
                    }
                    $go = $_POST['per'];
                    if ($go == 1) {
                        $go = 1;
                    } else {
                        $go = 0;
                    }

                    $emaild = XSS_DEFENDER($_POST['email-d']);
                    if ($emaild == 1) {
                        $emaild = 1;
                    } else {
                        $emaild = 0;
                    }

                    if (isset($_POST['area'])) {
                        $area = $_POST['area'];
                        $ar = $reg = $app->fetch("SELECT * FROM `map_list` WHERE `name` = :d",
                            [
                                ':d' => $_POST['area']
                            ]
                        );
                        $app->execute("UPDATE `map_list` SET `job` = `job` + 1 WHERE `id` = :id", [
                            ':id' => $ar['id']
                        ]);
                    } else {
                        $area = '';
                    }

                    $city_add = $app->fetch("SELECT * FROM `map_list` WHERE `name` = :d", [':d' => $address]);
                    if ($city_add['id']) {
                        $app->execute("UPDATE `map_list` SET `job` = `job` + 1 WHERE `id` = :id", [
                            ':id' => $city_add['id']
                        ]);
                    }

                    $countS = (int)$_POST['countSkills'];

                    $hour = date("H:i");

                    $c = $app->fetch("SELECT * FROM `category` WHERE `name` = :n", [':n' => $_POST['category']]);

                    $reg = $app->fetch("SELECT * FROM `map_list` WHERE `name` = :d", [':d' => $_POST['region']]);

                    $app->execute("INSERT INTO `vacancy` (`email-d`, `go`, `times`, `timses`, `contact`, `salary_end`, `title`, `category_id`, `degree`, `area`, `type`, `invalid`, `company`, `task`, `text`, `date`, `time`, `region`, `district`, `address`, `phone`, `email`, `category`, `company_id`, `img`, `salary`, `exp`, `urid`)
            VALUES(:emd, :goo, NOW(), :tims, :contc, :saled, :t, :ccs, :deg, :ar, :jb, :inv, :cd, :tas, :cnt, :d, :tim, :reg, :dist, :addres, :phone, :email, :category, :c_i, :im, :sal, :exp, :urid)", [
                        ':emd' => $emaild,
                        ':goo' => $go,
                        ':tims' => $hour,
                        ':contc' => $username,
                        ':saled' => $salary_end,
                        ':t' => $title,
                        ':ccs' => $c['id'],
                        ':deg' => $degree,
                        ':ar' => $area,
                        ':jb' => $job_type,
                        ':inv' => $status,
                        ':cd' => $r['name'],
                        ':tas' => $del,
                        ':cnt' => $text,
                        ':d' => $Date,
                        ':tim' => $time,
                        ':reg' => $reg['name'],
                        ':dist' => $reg['map_name'],
                        ':addres' => $address,
                        ':phone' => $phone,
                        ':email' => $email,
                        ':category' => $category,
                        ':c_i' => $r['id'],
                        ':im' => $r['img'],
                        ':sal' => $salary,
                        ':exp' => $exp,
                        ':urid' => $urid
                    ]);

                    $app->execute("UPDATE `map_list` SET `job` = `job` + 1 WHERE `id` = :id", [
                        ':id' => $reg['id']
                    ]);

                    $app->execute("UPDATE `map` SET `job` = `job` + 1 WHERE `id` = :id", [
                        ':id' => $reg['map_id']
                    ]);

                    if ($countS > 0) {
                        $rrr = $app->fetch("SELECT * FROM `vacancy` WHERE `title` = :t AND `company_id` = :id AND `timses` = :h", [
                            ':t' => $title,
                            ':id' => $r['id'],
                            ':h' => $hour
                        ]);

                        $i = 1;
                        while ($i <= $countS) {
                            if (isset($_POST['skill-text-'.$i])) {
                                $title = $_POST['skill-text-'.$i];
                                $com_id = $r['id'];
                                $res_id = $rrr['id'];

                                $sql = "INSERT INTO `skills_job` (`company_id`, `job_id`, `text`)
                                            VALUES(:ui, :ri, :t)";
                                $stmt = $PDO->prepare($sql);
                                $stmt->execute([
                                    ':ui' => $com_id,
                                    ':ri' => $res_id,
                                    ':t' => $title
                                ]);
                            }
                            $i = $i + 1;
                        }
                    }

                    $app->execute("UPDATE `category` SET `job` = `job` + 1 WHERE `name` = :i", [
                        ':i' => $c['name']
                    ]);

                    $app->execute("UPDATE `company` SET `job` = `job` + 1 WHERE `id` = :i", [
                        ':i' => $r['id']
                    ]);

                    $sub = $app->rowCount("SELECT * FROM `sub` WHERE `company` = :id", [':id' => $r['id']]);

                    if ($sub > 0) {

                        $sql = $app->query("SELECT * FROM `sub` WHERE `company` = '$r[id]'");
                        while ($us = $sql->fetch()) {
                            $u = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $us['user']]);

                            if (!empty($u['id'])) {
                                SENDMAIL($mail, 'Новая вакансия', $u['email'], $u['name'] . ' ' . $u['surname'], '                     
Компания "<a href="http://stgaujob.ru/company/?id='.$r['id'].'">'.$r['name'].'</a>" разместила новую вакансию "'.$title.'"                   
                            ');
                            }


                        }
                    }



                    echo json_encode(array(
                        'code' => 'success',
                    ));

                } else {
                    echo json_encode(array(
                        'code' => 'error',
                    ));

                }
            } else {
                echo json_encode(array(
                    'error' => $err,
                    'code' => 'validate_error',
                ));

            }

        }


        if (isset($_POST['MODULE_EDIT_JOB']) && $_POST['MODULE_EDIT_JOB'] == 1) {

            $err = array();
            $captcha = $_SESSION['captcha'];
            unset($_SESSION['captcha']);
            session_write_close();
            $code = $_POST['captcha'];
            $code = crypt(trim($code), '$1$itchief$7');

            if (empty($_POST['date']) || ($_POST['date'] <= date('Y-m-d'))) $err['date'] = 'Дата указана неверно';
            if (empty($_POST['title']) || trim($_POST['title']) == '') $err['title'] = 'Введите название';
            if (empty($_POST['region']) || trim($_POST['region']) == '') $err['region'] = 'Укажите регион';
            if (
                ((isset($_POST['region']) || trim($_POST['region']) != '') && $_POST['region'] != 'Ставропольский край')
                && (empty($_POST['address']) || trim($_POST['address']) == '')
            ) $err['address'] = 'Выберите населённый пункт';
            if (
                ((isset($_POST['region']) || trim($_POST['region']) != '') && $_POST['region'] == 'Ставропольский край')
                && (empty($_POST['area']) || trim($_POST['area']) == '')
            ) $err['area'] = 'Выберите район';
            if (
                ((isset($_POST['region']) || trim($_POST['region']) != '') && $_POST['region'] == 'Ставропольский край')
                && (isset($_POST['area']) || trim($_POST['area']) != '')
                && (empty($_POST['address']) || trim($_POST['address']) == '')
            ) $err['address'] = 'Выберите населённый пункт';
            if (empty($_POST['email']) || trim($_POST['email']) == '') $err['email'] = 'Введите  email';
            if (empty($_POST['phone']) || trim($_POST['phone']) == '') $err['tel'] = 'Введите  телефон';
            if (empty(strip_tags($_POST['text'])) || trim(strip_tags($_POST['text'])) == '') $err['text'] = 'Введите текст';
            if (empty($_POST['exp']) || trim($_POST['exp']) == '') $err['exp'] = 'Укажите опыт работы';
            if (empty($_POST['time']) || trim($_POST['time']) == '') $err['time'] = 'Укажите график работы';
            if (empty($_POST['job_type']) || trim($_POST['job_type']) == '') $err['job_type'] = 'Укажите тип занятости';
            if (empty($_POST['category']) || trim($_POST['category']) == '') $err['category'] = 'Укажите сферу деятельности';
            if (empty($_POST['captcha']) or trim($_POST['captcha']) == '') $err['captcha'] = 'Пожалуйста введите код';
            else if ($captcha != $code)  $err['captcha'] = 'Введенный код не соответствует изображению!';

            if (empty($err)) {

                $r = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $_SESSION['id']]);

                $job = $app->fetch("SELECT * FROM `vacancy` WHERE `id` = :id AND `company_id` = :ci", [
                   ':id' => $_POST['job'],
                   ':ci' => $_SESSION['id']
                ]);

                if (isset($r['id']) && isset($job['id'])) {
                    $title = preg_replace("'<script[^>]*?>.*?</script>'si", "", $_POST['title']);
                    $title = str_replace($xss, "", $title);
                    $text = preg_replace("'<script[^>]*?>.*?</script>'si", "", $_POST['text']);
                    $text = str_replace($xss, "", $text);
                    $category = XSS_DEFENDER($_POST['category']);
                    $del = XSS_DEFENDER($_POST['date']);
                    $username = XSS_DEFENDER($_POST['username']);
                    $phone = XSS_DEFENDER($_POST['phone']);
                    $email = XSS_DEFENDER($_POST['email']);
                    $region = XSS_DEFENDER($_POST['region']);
                    $address = XSS_DEFENDER($_POST['address']);
                    $salary = XSS_DEFENDER($_POST['salary']);
                    $salary_end = XSS_DEFENDER($_POST['salary_end']);
                    $time = XSS_DEFENDER($_POST['time']);
                    $exp = XSS_DEFENDER($_POST['exp']);
                    $job_type = XSS_DEFENDER($_POST['job_type']);
                    $dog = $_POST['salary_dog'];
                    if ($dog == 1) {
                        $salary = '';
                        $salary_end = '';
                    } else {
                        $salary = (int)XSS_DEFENDER($_POST['salary']);
                        $salary_end = (int)XSS_DEFENDER($_POST['salary_end']);
                    }
                    if ($_POST['urid']) {
                        $urid = $_POST['urid'];
                    } else {
                        $urid = '';
                    }
                    $degree = '';
                    if ($_POST['degree']) {
                        $degree = XSS_DEFENDER($_POST['degree']);
                    } else {
                        $degree = '';
                    }
                    $status = $_POST['invalid'];
                    if ($status == 1) {
                        $status = 1;
                    } else {
                        $status = 0;
                    }
                    $go = $_POST['per'];
                    if ($go == 1) {
                        $go = 1;
                    } else {
                        $go = 0;
                    }

                    $emaild = XSS_DEFENDER($_POST['email-d']);
                    if ($emaild == 1) {
                        $emaild = 1;
                    } else {
                        $emaild = 0;
                    }

                    if (isset($_POST['area'])) {
                        $area = $_POST['area'];
                        $ar = $reg = $app->fetch("SELECT * FROM `map_list` WHERE `name` = :d",
                            [
                                ':d' => $_POST['area']
                            ]
                        );
                    } else {
                        $area = '';
                    }

                    $hour = date("H:i");



                    $c = $app->fetch("SELECT * FROM `category` WHERE `name` = :n", [':n' => $_POST['category']]);

                    $reg = $app->fetch("SELECT * FROM `map_list` WHERE `name` = :d", [':d' => $_POST['region']]);

                    $app->execute("UPDATE `vacancy` SET 
                                `title` = :title,
                                `address` = :city,
                                `salary` = :salary,
                                `salary_end` = :salary_end,     
                                `email` = :email,
                                `time` = :tim,
                                `text` = :text,
                                `category` = :category,  
                                `category_id` = :ci,
                                `phone` = :phone,
                                `district` = :district,
                                `region` = :region,
                                `area` = :area, 
                                `urid` = :urid,
                                `exp` = :exp,
                                `invalid` = :inl,
                                `degree` = :degr,
                                `task` = :task,
                                `type` = :typ,
                                `contact` = :contact,
                                `go` = :g,
                                `last_up` = :lastup,
                                `email-d` = :em_d
                                WHERE `id` = :id",
                        [
                            ':title' => $title,
                            ':city' => $address,
                            ':salary' => $salary,
                            ':salary_end' => $salary_end,
                            ':email' => $email,
                            ':tim' => $time,
                            ':text' => $text,
                            ':category' => $c['name'],
                            ':ci' => $c['id'],
                            ':phone' => $phone,
                            ':district' => $reg['map_name'],
                            ':region' => $reg['name'],
                            ':area' => $area,
                            ':urid' => $urid,
                            ':exp' => $exp,
                            ':inl' => $status,
                            ':degr' => $degree,
                            ':task' => $del,
                            ':typ' => $job_type,
                            ':contact' => $username,
                            ':g' => $go,
                            ':lastup' => $Date_ru . ' ' . date('H:i'),
                            ':em_d' => $emaild,
                            ':id' => $job['id']
                        ]
                    );


                    $app->execute("UPDATE `respond` SET `job` = :job WHERE `job_id` = :id", [
                        ':job' => $job['title'],
                        ':id' => $job['id']
                    ]);

                    $app->execute("UPDATE `respond_user` SET `job` = :job WHERE `job_id` = :id", [
                        ':job' => $job['title'],
                        ':id' => $job['id']
                    ]);

                    if (intval($_POST['countSkills'])> 0) {
                        $i = 1;
                        while ($i <= $_POST['countSkills']) {
                            if (isset($_POST['skill-text-'.$i])) {
                                $title = $_POST['skill-text-'.$i];
                                $com_id = $r['id'];
                                $res_id = $job['id'];

                                $sql = "INSERT INTO `skills_job` (`company_id`, `job_id`, `text`)
                                            VALUES(:ui, :ri, :t)";
                                $stmt = $PDO->prepare($sql);
                                $stmt->execute([
                                    ':ui' => $com_id,
                                    ':ri' => $res_id,
                                    ':t' => $title
                                ]);
                            }
                            $i = $i + 1;
                        }
                    }

                    echo json_encode(array(
                        'code' => 'success',
                    ));

                }

            } else {
                echo json_encode(array(
                    'error' => $err,
                    'code' => 'validate_error',
                ));
            }

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