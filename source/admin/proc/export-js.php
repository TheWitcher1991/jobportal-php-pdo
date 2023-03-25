<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $app->notFound();
}

if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

    $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id AND `last_ip` = :ip", [
        ':id' => $_SESSION['id'],
        ':ip' => $client['query']
    ]);

    if (empty($a['id'])) {
        $app->notFound();
    }

    try {

        if (isset($_POST['MODULE_GET_RESPOND_LIST']) && $_POST['MODULE_GET_RESPOND_LIST'] == 1) {

            header('Content-Type: application/vnd.ms-excel; charset=utf-8');
            header("Content-Disposition: attachment;respond_agro=".date("d-m-Y")."-export.xls");
            header("Content-Transfer-Encoding: binary ");

            echo '
               <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
               <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
                <head>
                    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                    <meta name="author" content="stgaujob.ru" />
                    <title>СтГАУ Агрокадры - отклики студентов</title>
                </head>
                <body>
            ';

            echo '
              <table border="1" cellpadding="15">
                <tr>
                    <th>ID</th>
                    <th>Дата отклика</th>
                    <th>ID студента</th>
                    <th>Ф.И.О студента</th>
                     <th>Профессия студента</th>
                    <th>ID Вакансии</th>
                    <th>Вакансия</th>
                    <th>ID Компании</th>
                    <th>Компания</th>
                    <th>Статус отклика</th>
                    <th>Сообщение от компании</th>
                    <th>Сопроводительное письмо студента</th>
                </tr>
            ';

            $stmt = $PDO->prepare("SELECT * FROM `respond` ORDER BY `id` ASC");
            $stmt->execute();

            while($r = $stmt->fetch()) {

                $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $r['user_id']]);
                $job = $app->fetch("SELECT * FROM `vacancy` WHERE `id` = :id", [':id' => $r['job_id']]);
                $com = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $r['company_id']]);

                if ($r['status'] == 0 || $r['status'] == 1 || $r['status'] == 6) {
                    $st = 'На рассмотрении';
                } else if ($r['status'] == 2) {
                    $st = 'Разговор по телефону';
                } else if ($r['status'] == 3) {
                    $st = 'Назначено собеседование';
                } else if ($r['status'] == 4) {
                    $st = 'Принят на работу';
                } else if ($r['status'] == 5) {
                    $st = 'Отказано';
                } else {
                    $st = ' Не определён';
                }

                $msg = $app->fetch("SELECT * FROM `respond_message` WHERE `job` = :ji AND `user` = :ui AND `type` = :st",
                    [
                        ':ji' => $job['id'],
                        ':ui' => $user['id'],
                        ':st' => $r['status']
                    ]);

                echo '<tr>
                    <td>'.$r['id'].'</td>
                    <td>'.$r['date'].'</td>
                    <td>'.$user['id'].'</td>
                    <td>'.$user['name'].' '.$user['surname'].' '.$user['patronymic'].'</td>
                    <td>'.$user['prof'].'</td>
                    <td>'.$job['id'].'</td>
                    <td>'.$job['title'].'</td>
                    <td>'.$com['id'].'</td>
                    <td>'.$com['name'].'</td>
                    <td>'.$st.'</td>
                    <td>'.$msg['text'].'</td>
                    <td>'.$r['text'].'</td>

                </tr>';
            }

            echo '</table border="1" cellpadding="15"> ';
            echo '</body></html>';
        }

        if (isset($_POST['MODULE_GET_USERS_LIST']) && $_POST['MODULE_GET_USERS_LIST'] == 1) {

            header('Content-Type: application/vnd.ms-excel; charset=utf-8');
            header("Content-Disposition: attachment;students_agro=".date("d-m-Y")."-export.xls");
            header("Content-Transfer-Encoding: binary ");

            echo '
               <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
               <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
                <head>
                    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                    <meta name="author" content="stgaujob.ru" />
                    <title>СтГАУ Агрокадры - студенты</title>
                </head>
                <body>
            ';

            echo '
              <table border="1" cellpadding="15">
                <tr>
                    <th>ID</th>
                    <th>Регистрация</th>
                    <th>Ф.И.О</th>
                    <th>Дата рождения</th>
                    <th>Возраст</th>
                    <th>Профессия</th>
                    <th>Зарплата</th>
                    <th>Есть инвалидность</th>
                    <th>Образование</th>
                    <th>Курс</th>
                    <th>Факультет</th>
                    <th>Направление</th>
                    <th>Телефон</th>
                    <th>Email</th>
                    <th>! Кол-во откликов</th>
                    <th>! Сфера деятельности</th>
                    <th>Статус поиска работы</th>
                    <th>Гражданство</th>
                    <th>СНИЛС</th>
                    <th>ИНН</th>
                    <th>Форма обучения</th>
                    <th>Тип финансирования</th>
                    <th>Опыт работы</th>
                    <th>График работы</th>
                    <th>Тип занятости</th>
                    <th>Водительские права</th>
                </tr>
            ';

            $stmt = $PDO->prepare("SELECT * FROM `users` ORDER BY `id` ASC");
            $stmt->execute();

            while($r = $stmt->fetch()) {
                echo '<tr>
                    <td>'.$r['id'].'</td>
                    <td>'.$r['date'].'</td>
                    <td>'.$r['name'].' '.$r['surname'].' '.$r['patronymic'].'</td>
                    <td>'.(!empty($r['age']) ? $r['age'] : '').'</td>
                    <td>'.(!empty($r['age']) ? calculate_age($r['age']) : '').'</td>
                    <td>'.$r['prof'].'</td>
                    <td>'.($r['salary'] > 0 ? $r['salary'] : 'По договорённости').'</td>
                    <td>'.($r['inv'] > 0 ? 'Да' : 'Нет').'</td>
                     <td>'.$r['degree'].'</td>
                    <td>'. (trim($r['course']) == '' || strlen((string) $r['course']) <= 0 || $r['course'] == 0 ? '' : $r['course']) .'</td>
                    <td>'.$r['faculty'].'</td>
                    <td>'.$r['direction'].'</td>
                    <td>'.$r['phone'].'</td>
                    <td>'.$r['email'].'</td>
                    <td>'.$app->rowCount("SELECT * FROM `respond` WHERE `user_id` = :id", [':id' => $r['id']]).'</td>
                    <td>'.$r['category'].'</td>
                    <td>'. (trim($r['stat']) == '' ? '' : $r['stat']) .'</td>
                    <td>'. (trim($r['nationality']) == '' || strlen((string) $r['nationality']) <= 0 || $r['nationality'] == 0 ? '' : $r['nationality']) .'</td>
                    <td>'. (trim($r['snils']) == ''|| strlen((string) $r['snils']) <= 0 || $r['snils'] == 0 ? '' : $r['snils']) .'</td>
                    <td>'. (trim($r['inn']) == '' || strlen((string) $r['inn']) <= 0 || $r['inn'] == 0 ? '' : $r['inn']) .'</td>
                    <td>'. (trim($r['form_education']) == '' ? '' : $r['form_education']) .'</td>
                    <td>'. (trim($r['financing']) == '' ? '' : $r['financing']) .'</td>
                    <td>'. (trim($r['exp']) == '' ? '' : $r['exp']) .'</td>
                    <td>'. (trim($r['time']) == '' ? '' : $r['time']) .'</td>
                    <td>'. (trim($r['type']) == '' ? '' : $r['type']) .'</td>
                    <td>'. (trim($r['drive']) == '' ? '' : $r['drive']) .'</td>
                </tr>';
            }

            echo '</table border="1" cellpadding="15"> ';
            echo '</body></html>';
        }

        if (isset($_POST['MODULE_GET_COMPANY_LIST']) && $_POST['MODULE_GET_COMPANY_LIST'] == 1) {

            header('Content-Type: application/vnd.ms-excel; charset=utf-8');
            header("Content-Disposition: attachment;company_agro=".date("d-m-Y")."-export.xls");
            header("Content-Transfer-Encoding: binary ");

            echo '
               <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
               <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
                <head>
                    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                    <meta name="author" content="stgaujob.ru" />
                    <title>СтГАУ Агрокадры - компании</title>
                </head>
                <body>
            ';

            echo '
              <table border="1" cellpadding="15">
                <tr>
                    <th>ID</th>
                    <th>Регистрация</th>
                    <th>Название</th>
                    <th>Контактное лицо</th>
                    <th>Город</th>
                    <th>Телефон</th>
                    <th>Email</th>
                    <th>Подтверждена</th>
                    <th>! Кол-во вакансий</th>
                    <th>! Кол-во откликов</th>
                    <th>! Кол-во просмотров</th>
                    <th>Тип</th>
                    <th>ИНН</th>
                    <th>Специализация</th>
                    <th>Штат</th>
                    <th>Сайт</th>
                </tr>
            ';

            $stmt = $PDO->prepare("SELECT * FROM `company` ORDER BY `id` ASC");
            $stmt->execute();

            while($r = $stmt->fetch()) {
                echo '<tr>
                    <td>'.$r['id'].'</td>
                    <td>'.$r['date'].'</td>
                    <td>'.$r['name'].'</td>
                    <td>'.$r['username'].'</td>
                    <td>'.$r['address'].'</td>
                    <td>'.$r['phone'].'</td>
                    <td>'.$r['email'].'</td>
                    <td>'.(!empty($r['verified']) == 1 ? 'Да' : 'Нет').'</td>
                    <td>'.$app->rowCount("SELECT * FROM `vacancy` WHERE `company_id` = :id", [':id' => $r['id']]).'</td>
                    <td>'.$app->rowCount("SELECT * FROM `respond` WHERE `company_id` = :id", [':id' => $r['id']]).'</td>
                    <td>'.$r['views'].'</td>
                    <td>'.$r['type'].'</td>
                    <td>'.$r['inn'].'</td>
                    <td>'.(!empty($r['specialty']) ? $r['specialty'] : '').'</td>
                    <td>'.(!empty($r['people']) ? $r['people'] : '').'</td>
                    <td>'.(!empty($r['website']) ? $r['website'] : '').'</td>
                </tr>';
            }

            echo '</table border="1" cellpadding="15"> ';
            echo '</body></html>';
        }

        if (isset($_POST['MODULE_GET_JOB_ACTIVE_LIST']) && $_POST['MODULE_GET_JOB_ACTIVE_LIST'] == 1) {

            header('Content-Type: application/vnd.ms-excel; charset=utf-8');
            header("Content-Disposition: attachment;job_active_agro=".date("d-m-Y")."-export.xls");
            header("Content-Transfer-Encoding: binary ");

            echo '
               <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
               <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
                <head>
                    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                    <meta name="author" content="stgaujob.ru" />
                    <title>СтГАУ Агрокадры - активные вакансии</title>
                </head>
                <body>
            ';

            echo '
              <table border="1" cellpadding="15">
                <tr>
                    <th>ID</th>
                    <th>Дата публикации</th>
                    <th>Дата закрытия</th>
                    <th>Заголовок</th>
                    <th>ID Компании</th>
                    <th>Компания</th>
                    <th>Зарплата</th>
                    <th>Регион</th>
                    <th>Город</th>
                    <th>Юридический адрес</th>
                    <th>Контактное лицо</th>
                    <th>Email</th>
                    <th>Телефон</th>
                    <th>Просмотров</th>
                    <th>! Кол-во откликов</th>
                    <th>График работы</th>
                    <th>Тип занятости</th>
                    <th>Опыт работы</th>
                    <th>Образование</th>
                </tr>
            ';

            $stmt = $PDO->prepare("SELECT * FROM `vacancy` WHERE `status` = 0 ORDER BY `id` ASC");
            $stmt->execute();

            while($r = $stmt->fetch()) {

                $salary = '';

                if ($r['salary'] > 0 && $r['salary_end'] > 0) {
                    if ($r['salary'] == $r['salary_end']) {
                        $salary = $r['salary'];
                    } else {
                        $salary = 'от ' . $r['salary'] . ' до ' . $r['salary_end'];
                    }
                } else if ($r['salary'] > 0 && ($r['salary_end'] <= 0 || trim($r['salary_end']) == '')) {
                    $salary = 'от ' . $r['salary'];
                } else if (($r['salary'] <= 0 || trim($r['salary']) == '') && $r['salary_end'] > 0) {
                    $salary = 'до ' . $r['salary_end'];
                } else {
                    $salary = 'по договоренности';
                }

                echo '<tr>
                    <td>'.$r['id'].'</td>
                    <td>'.$r['date'].' '.$r['timses'].'</td>
                    <td>'.DateTime::createFromFormat('Y-m-d', $r['task'])->format('d.m.Y').'</td>
                    <td>'.$r['title'].'</td>
                    <td>'.$r['company_id'].'</td>
                    <td>'.$r['company'].'</td>
                    <td>'.$salary.'</td>
                    <td>'.$r['region'].'</td>
                    <td>'.$r['address'].'</td>
                    <td>'.$r['urid'].'</td>
                    <td>'.(!empty($r['contact']) ? $r['contact'] : '').'</td>
                    <td>'.$r['email'].'</td>
                    <td>'.$r['phone'].'</td>
                    <td>'.$r['views'].'</td>
                    <td>'.$app->rowCount("SELECT * FROM `respond` WHERE `job_id` = :id", [':id' => $r['id']]).'</td>
                    <td>'.$r['time'].'</td>
                    <td>'.$r['type'].'</td>
                    <td>'.$r['exp'].'</td>
                    <td>'.(!empty($r['degree']) ? $r['degree'] : '').'</td>
                </tr>';
            }

            echo '</table border="1" cellpadding="15"> ';
            echo '</body></html>';
        }

    } catch (Exception $e) {
        echo json_encode(array(
            'code' => 'error',
            'message' => $e->getMessage()
        ));
    }

}

session_write_close();

exit;