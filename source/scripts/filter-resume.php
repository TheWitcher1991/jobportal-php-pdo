<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $app->notFound();
    exit;
}

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $app->notFound();
        exit;
    }

    function getOptions()
    {
        $salary = (isset($_POST['salary'])) ? (int) $_POST['salary'] : 0;
        $exp = (isset($_POST['exp'])) ? $_POST['exp'] : null;
        $time = (isset($_POST['time'])) ? $_POST['time'] : null;
        $type = (isset($_POST['type'])) ? $_POST['type'] : null;
        $degree = (isset($_POST['degree'])) ? $_POST['degree'] : null;
        $gender = (isset($_POST['gender'])) ? $_POST['gender'] : null;
        $drive = (isset($_POST['drive'])) ? $_POST['drive'] : null;
        $key = (isset($_POST['key'])) ? $_POST['key'] : null;
        $ageTo = (isset($_POST['ageTo'])) ?  (int) $_POST['ageTo'] : null;
        $ageFrom = (isset($_POST['ageFrom'])) ?  (int) $_POST['ageFrom'] : null;
        $faculty = (isset($_POST['faculty'])) ? $_POST['faculty'] : null;
        $sort = (isset($_POST['sort'])) ?  (int) $_POST['sort'] : null;
        $f = (isset($_POST['f'])) ?  (int) $_POST['f'] : null;
        $page = (isset($_POST['page'])) ? (int)$_POST['page'] : 1;
        $limit = (isset($_POST['limit'])) ? (int)$_POST['limit'] : 25;
        $token = (isset($_POST['token'])) ? $_POST['token'] : null;

        return array(
            'salary' => $salary,
            'exp' => $exp,
            'time' => $time,
            'token' => $token,
            'type' => $type,
            'degree' => $degree,
            'gender' => $gender,
            'drive' => $drive,
            'key' => $key,
            'ageTo' => $ageTo,
            'ageFrom' => $ageFrom,
            'faculty' => $faculty,
            'sort' => $sort,
            'f' => $f,
            'page' => $page,
            'limit' => $limit
        );
    }

    function getData($options, $PDO, $app, $Date) {
        $options = getOptions();

        $token = $options['token'];

        if ((empty($token) || trim($token) == '') || (empty($_SESSION["resume-$token"]) || $_SESSION["resume-$token"] != $token)) {
            $app->notFound();
            exit;
        }

        $salary = intval($options['salary']);
        $exp = $options['exp'];
        $time = $options['time'];
        $type = $options['type'];
        $degree = $options['degree'];
        $gender = $options['gender'];
        $drive = $options['drive'];
        $key = $options['key'];
        $ageTo = $options['ageTo'];
        $ageFrom = $options['ageFrom'];
        $page = (int) $options['page'];
        $faculty = $options['faculty'];
        $sort = $options['sort'];
        $f = $options['f'];
        if ($page == 0) $page++;
        $limit = (int) 25;

        $start = ($page - 1) * $limit;

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

        if ($f != null && $faculty == null) {
            $faculty = $f;
        }

        if ($time != null) {
            foreach ($time as $val => $item) {
                if ($item == 1) $time[$val] = 'Полный рабочий день';
                if ($item == 2) $time[$val] = 'Гибкий график';
                if ($item == 3) $time[$val] = 'Сменный график';
                if ($item == 4) $time[$val] = 'Ненормированный рабочий день';
                if ($item == 5) $time[$val] = 'Вахтовый метод';
            }
            $time = implode(', ', $time);
        }

        if ($type != null) {
            foreach ($type as $val => $item) {
                if ($item == 1) $type[$val] = 'Полная занятость';
                if ($item == 2) $type[$val] = 'Частичная занятость';
                if ($item == 3) $type[$val] = 'Проектная работа';
                if ($item == 4) $type[$val] = 'Стажировка';
                if ($item == 5) $type[$val] = 'Удаленная работа';
                if ($item == 6) $type[$val] = 'Волонтерство';
            }
            $type = implode(', ', $type);
        }

        if ($degree != null) {
            foreach ($degree as $val => $item) {
                if ($item == 1) $degree[$val] = '"Среднее профессиональное"';
                if ($item == 2) $degree[$val] = '"Высшее (Бакалавриат)"';
                if ($item == 3) $degree[$val] = '"Высшее (Специалитет)"';
                if ($item == 4) $degree[$val] = '"Высшее (Магистратура)"';
                if ($item == 5) $degree[$val] = '"Высшее (Аспирантура)"';
            }
            $degree = implode(', ', $degree);
        }

        if ($drive != null) {
            foreach ($drive as $val => $item) {
                if ($item == 1) $drive[$val] = '"A"';
                if ($item == 2) $drive[$val] = '"B"';
                if ($item == 3) $drive[$val] = '"C"';
                if ($item == 4) $drive[$val] = '"D"';
                if ($item == 5) $drive[$val] = '"E"';
            }
            $drive = implode(', ', $drive);
        }

        $where = "";

        if ($key != null) $where = addWhere($where, "(`prof` LIKE '%$key%' OR `date` LIKE '%$key%' OR `about` LIKE '%$key%')");
        if ($ageTo != null && $ageFrom == null) $where = addWhere($where, "`age` >= $ageTo");
        if ($ageTo == null && $ageFrom != null) $where = addWhere($where, "`age` <= $ageFrom");
        if ($ageTo != null && $ageFrom != null) $where = addWhere($where, "`age` >= $ageTo AND `age` <= $ageFrom");
        if ($salary > 0) $where = addWhere($where, "`salary` < $salary AND `salary` != ''");
        if ($salary == null) $where = addWhere($where, "`salary` = ''");
        if ($exp != null) $where = addWhere($where, "`exp` IN ($exp)");
        if ($time != null) $where = addWhere($where, "`time` LIKE '%$time%'");
        if ($type != null) $where = addWhere($where, "`type` LIKE '%$type%'");
        if ($degree != null) $where = addWhere($where, "`degree` IN ($degree)");
        if ($gender != null) $where = addWhere($where, "`gender` LIKE '%$gender%'");
        if ($drive != null) $where = addWhere($where, "`drive` IN ($drive)");
        if ($faculty != null) $where = addWhere($where, "`faculty` LIKE '%$faculty%'");
        $where = addWhere($where, "`ban` = 0");
        $sql = "SELECT * FROM `users`";
        $sql2 = "SELECT * FROM `users`";
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
                $sql .= " ORDER BY `salary` ASC LIMIT $start, $limit";
                $sql2 .= " ORDER BY `salary` ASC";
            }
            if ($sort == 3) {
                $sql .= " ORDER BY `id` DESC LIMIT $start, $limit";
                $sql2 .= " ORDER BY `id` DESC";
            }
        } else {
            $sql .= " ORDER BY `id` DESC LIMIT $start, $limit";
            $sql2 .= " ORDER BY `id` DESC";
        }


        $people = [];
        $online = [];

        $sql_2 = $app->query($sql);
        while ($r = $sql_2->fetch()) {
            $people[] = $app->count("SELECT * FROM `online_resume` WHERE `users` = $r[id]");
        }

        $sql_3 = $app->query($sql);
        while ($r = $sql_3->fetch()) {
            $onr = $app->count("SELECT * FROM `online` WHERE `id` = '$r[id]' AND `type` = 'users'");
            if ($onr > 0) {
                $online[$r['id']] = $r['id'];
            }
        }

        $stmt2 = $PDO->prepare($sql2);
        $stmt2->execute();
        $countAll = $stmt2->rowCount();

        $stmt = $PDO->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();

        $countPages = ceil($countAll / $limit);
        $mid_size = 2;

        if ($page > $mid_size + 1) {
            $start_page = '<div data-page="1"><a href><i class="fa-solid fa-angles-left"></i></a></div>';
        }

        if ($page < ($countPages - $mid_size)) {
            $end_page = '<div data-page="'.$countPages.'"><a href><!--<i class="fa-solid fa-angles-right"></i></a>-->'.$countPages.'</div>';
        }


        if ($page < (($countPages - $mid_size) - 1)) {
            $last = '<span>...</span>';
        }

        /*if ($page > 1) {
            $back = '<div data-page="'.($page - 1).'"><a href><i class="fa-solid fa-chevron-left"></i></a></div>';
        }*/

        if ($page < $countPages) {
            $forward = '<div data-page="'.($page + 1).'"><a href><i class="fa-solid fa-chevron-right"></i></a></div>';
        }

        $page_left = '';
        for ($i = $mid_size; $i > 0; $i--) {
            if ($page - $i > 0) {
                $page_left .= '<div data-page="'.($page - $i).'"><a href>'.($page - $i).'</a></div>';
            }
        }

        $page_right = '';
        for ($i = 1; $i <= $mid_size; $i++) {
            if ($page + $i <= $countPages) {
                $page_right .= '<div data-page="'.($page + $i).'"><a href>'.($page + $i).'</a></div>';
            }
        }


        $pagination = $start_page . $page_left . '<div class="page-active" data-page="'.$page.'"><a href>'.$page.'</a></div>' . $page_right . $last . $end_page . $forward;

        $list = "";

        $now = new DateTime($Date);
        $from = new DateTime($r['age']);

        $interval = $from->diff($now);

        $i = 0;

        if ($count > 0) {
            while($r = $stmt->fetch()) {
                $list .= ' 
                     <li class="resume-list">
                        <!--<form method="GET" role="form">
                            <button type="button" name="save" class="save-${r.id}"><i class="mdi mdi-heart-outline"></i></button>
                        </form>-->
                        <div class="res-top">
                            <div class="res-img">
                                <span class="' . (isset($_SESSION['id'], $_SESSION['password']) ? '' : 'res-lock-photo lock-photo') . '">  
                                    ' . (isset($_SESSION['id'], $_SESSION['password']) ? '' : '<m><i class="icon-lock"></i></m>') . '
                                    <img src="/static/image/users/' . (isset($_SESSION['id'], $_SESSION['password']) ? $r['img'] : 'placeholder.png') . '"
                                                            alt="">
                                </span>
                            </div>
                            <div class="res-ctx-1">
                                <div class="resume-stat-list">
                                    ' . ($people[$i] > 0 ? '<span class="resume-stat">Сейчас просматривают ' . $people[$i] . '</span>' : '') . '
                                    ' . ($online[$r['id']] == $r['id'] ? '<span class="resume-stat">Сейчас на сайте</span>' : '') . '
                                    ' . ((isset($r['stat']) && trim($r['stat']) != '') ? '<span class="resume-stat">' . $r['stat'] . '</span>' : '') . '
                                </div>
                                <a target="_blank" href="/resume?id=' . $r['id'] . '" class="res-prof">' . $r['prof'] . '</a>
                                <span class="res-name">' . (isset($_SESSION['id'], $_SESSION['password']) ? $r['name'] . ' ' . $r['surname'] : '*********') . ', ' . $r['date'] . '</span>
                            </div>
                        </div>
                        <div class="res-bottom">
                            <div class="res-ctx-2">
                                <ul class="res-tags">
                                    ' . ($r['city'] != '' ? '<li>' . $r['city'] . '</li>' : '') . '
                                    ' . (!empty($r['gender']) && trim($r['gender']) != '' && !empty($_SESSION['type']) ? '<li>' . $r['gender'] . '</li>' : '') . '
                                    ' . ((!empty($r['age']) && !empty($_SESSION['type'])) ? '<li>' . $r['age'] . ' ('.calculate_age($r['age']).')</li>' : '') . '
                                    ' . ($r['salary'] > 0 ? '<li><i class="mdi mdi-currency-rub"></i> ' . $r['salary'] . '</li>' : '<li><i class="mdi mdi-currency-rub"></i> По договорённости</li>') . '
                                    <li>' . $r['faculty'] . '</li>
                                </ul>
                            </div>
                            <div class="res-text">
                                ' . ($r['about'] != '' ? mb_strimwidth($r['about'], 0, 250, "...") : '') . '
                            </div>
                            ' . ($r['last_save'] != '' ? 'Обновлено ' . $r['last_save'] : '') . '
                        </div>
                    </li>
                    ';
                $i++;
            }
        } else {
            $list .= '<span class="vac-none">Резюме не найдены</span>';
        }

        return array (
            'list' => $list,
            'count' => $count,
            'people' => $people,
            'online' => $online,
            'countAll' => $countAll,
            'page' => $page,
            'sort' => $sort,
            'f' => $f,
            'limit' => $limit,
            'pagination' => $pagination,
            'options' => $options
        );
    }



    echo json_encode(array(
        'code' => 'success',
        'data' => getData(getOptions(), $PDO, $app, $Date)
    ));

} catch (Exception $e) {
    echo json_encode(array(
        'code' => 'error',
        'message' => $e->getMessage()
    ));


}

session_write_close();

exit;