<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $app->notFound();
    exit;
}

try {

    function getOptions()
    {
        $area = (isset($_POST['area'])) ? implode(', ', $_POST['area']) : null;
        $district = (isset($_POST['district'])) ? implode(', ', $_POST['district']) : null;
        $salary_me = (isset($_POST['salary_me'])) ? $_POST['salary_me'] : null;
        $salary = (isset($_POST['salaryTo'])) ? (int) $_POST['salaryTo'] : 0;
        $salary_end = (isset($_POST['salaryFrom'])) ? (int) $_POST['salaryFrom'] : 0;
        $exp = (isset($_POST['exp'])) ? $_POST['exp'] : null;
        $time = (isset($_POST['time'])) ? $_POST['time'] : null;
        $type = (isset($_POST['type'])) ? $_POST['type'] : null;
        $more1 = (isset($_POST['more1'])) ? $_POST['more1'] : null;
        $more2 = (isset($_POST['more2'])) ? $_POST['more2'] : null;
        $more3 = (isset($_POST['more3'])) ? $_POST['more3'] : null;
        $key = (isset($_POST['key'])) ? $_POST['key'] : null;
        $loc = (isset($_POST['loc'])) ? $_POST['loc'] : null;
        $category_only = (isset($_POST['category_only'])) ? (int) $_POST['category_only'] : null;
        $sort = (isset($_POST['sort'])) ?  (int) $_POST['sort'] : null;
        $company = (isset($_POST['company'])) ? implode(', ', $_POST['company']) : null;
        $category = (isset($_POST['category'])) ? implode(', ', $_POST['category']) : null;
        $page = (isset($_POST['page'])) ? (int)$_POST['page'] : 1;
        $limit = (isset($_POST['limit'])) ? (int)$_POST['limit'] : 25;
        $token = (isset($_POST['token'])) ? $_POST['token'] : null;

        return array(
            'area' => $area,
            'district' => $district,
            'salary_me' => $salary_me,
            'salary' => $salary,
            'salary_end' => $salary_end,
            'token' => $token,
            'exp' => $exp,
            'time' => $time,
            'type' => $type,
            'more1' => $more1,
            'more2' => $more2,
            'more3' => $more3,
            'key' => $key,
            'loc' => $loc,
            'category_only' => $category_only,
            'sort' => $sort,
            'company' => $company,
            'category' => $category,
            'page' => $page,
            'limit' => $limit
        );
    }

    function getData($options, $PDO, $app) {
        $options = getOptions();

        $token = $options['token'];

        if ((empty($token) || trim($token) == '') || (empty($_SESSION["job-$token"]) || $_SESSION["job-$token"] != $token)) {
            $app->notFound();
        }

        $salary_me = intval($options['salary_me']);
        $salary_end = intval($options['salary_end']);
        $salary = intval($options['salary']);
        $exp = $options['exp'];
        $time = $options['time'];
        $type = $options['type'];
        $company = $options['company'];
        $category = $options['category'];
        $more1 = $options['more1'];
        $more2 = $options['more2'];
        $more3 = $options['more3'];
        $key = $options['key'];
        $loc = $options['loc'];
        $sort = $options['sort'];
        $category_only = $options['category_only'];
        $page = (int) $options['page'];
        if ($page == 0) $page++;
        $limit = (int) $options['limit'];
        $start = ($page - 1) * $limit;

        if ($exp == 1) $exp = 'Без опыта';
        else if ($exp == 2) $exp = '1-3 года';
        else if ($exp == 3) $exp = '3-6 лет';
        else if ($exp == 4) $exp = 'Более 6 лет';
        else $exp = null;

        if ($time != null) {
            foreach ($time as $val => $item) {
                if ($item == 1) $time[$val] = '"Полный рабочий день"';
                if ($item == 2) $time[$val] = '"Гибкий график"';
                if ($item == 3) $time[$val] = '"Сменный график"';
                if ($item == 4) $time[$val] = '"Ненормированный рабочий день"';
                if ($item == 5) $time[$val] = '"Вахтовый метод"';
                if ($item == 6) $time[$val] = '"Неполный рабочий день"';
            }
            $time = implode(', ', $time);
        }

        if ($type != null) {
            foreach ($type as $val => $item) {
                if ($item == 1) $type[$val] = '"Полная занятость"';
                if ($item == 2) $type[$val] = '"Частичная занятость"';
                if ($item == 3) $type[$val] = '"Временная"';
                if ($item == 4) $type[$val] = '"Стажировка"';
                if ($item == 5) $type[$val] = '"Сезонная"';
                if ($item == 6) $type[$val] = '"Удаленная"';
            }
            $type = implode(', ', $type);
        }

        if ($options['area'] != null) {
            $sql_a = "SELECT `id`, `name` FROM `map_list` WHERE `id` IN (?) GROUP BY `name`";
            $stmt_a = $PDO->prepare($sql_a);
            $stmt_a->execute([$options['area']]);
            if ($stmt_a->rowCount() > 0) $area = $stmt_a->fetchAll();
            else $area = null;

            if ($area != null) {
                $temp = [];
                foreach ($area as $k1 => $v1) {
                    foreach ($v1 as $k2 => $item) {
                        if ($k2 == 'name') {
                            $temp[] = '"'.$item.'"';
                        }
                    }
                }

            }

            $address = implode(', ', $temp);
        }



        if ($loc != null) {
            $sql = "SELECT * FROM `map` WHERE `code` = ?";
            $sql2 = "SELECT * FROM `map_list` WHERE `code` = ?";
            $stmt = $PDO->prepare($sql);
            $stmt->execute([$loc]);
            $stmt2 = $PDO->prepare($sql2);
            $stmt2->execute([$loc]);
            if ($stmt->rowCount() > 0) {
                $temp = $stmt->fetch();
                $loc = $temp['text'];
            } else if ($stmt2->rowCount() > 0) {
                $temp = $stmt2->fetch();
                $loc = $temp['name'];
            }
        }

        $where = "";



        if ($key != null) $where = addWhere($where, "`title` LIKE '%$key%'");
        if ($options['area'] == null and $loc != null) $where = addWhere($where, "(`region` LIKE '%$loc%' OR `district` LIKE '%$loc%' OR `area` LIKE '%$loc%' OR `address` LIKE '%$loc%')");
        if ($options['area'] != null and $loc == null) $where = addWhere($where, "(`region` IN ($address) OR `district` IN ($address) OR `area` IN ($address) OR `address` IN ($address))");
        if ($options['area'] != null and $loc != null) $where = addWhere($where, "(`region` IN ($address) OR `district` IN ($address) OR `area` IN ($address) OR `address` IN ($address))");
        if ($salary_me == 2) $where = addWhere($where, "`salary` = '' AND `salary_end` = ''");
        if ($salary_me == 3 && $salary != null && $salary_end != null) $where = addWhere($where, "`salary` <= $salary AND `salary_end` <= $salary_end");
        if ($salary_me == 3 && $salary != null && $salary_end == 0) $where = addWhere($where, "`salary` <= $salary AND `salary_end` = 0");
        if ($salary_me == 3 && $salary == 0 && $salary_end != null) $where = addWhere($where, "`salary` = 0 AND `salary_end` <= $salary_end");
        if ($exp != null) $where = addWhere($where, "`exp` LIKE '%$exp%'");
        if ($time != null) $where = addWhere($where, "`time` IN ($time)");
        if ($type != null) $where = addWhere($where, "`type` IN ($type)");
        if ($company != null) $where = addWhere($where, "`company_id` IN ($company)");
        if ($category_only != null && $category == null) $where = addWhere($where, "`category_id` = $category_only");
        if ($category != null && $category_only == null) $where = addWhere($where, "`category_id` IN ($category)");
        if ($more1 != null) $where = addWhere($where, "`go` = 1");
        if ($more2 != null) $where = addWhere($where, "`urid` != ''");
        if ($more3 != null) $where = addWhere($where, "`invalid` = 1");
        $sql = "SELECT * FROM `vacancy`";
        $sql2 = "SELECT * FROM `vacancy`";
        if ($where) {
            $sql .= " WHERE $where";
            $sql2 .= " WHERE $where";
        }


        if ($sort != null) {
            if ($sort == 1) {
                if ($sql == "SELECT * FROM `vacancy`") {
                    $sql .= " WHERE `status` = 0 ORDER BY `salary` ASC, `salary_end` DESC LIMIT $start, $limit";
                    $sql2 .= " WHERE `status` = 0 ORDER BY `salary` ASC, `salary_end` DESC";
                } else {
                    $sql .= " AND `status` = 0 ORDER BY `salary` ASC, `salary_end` DESC LIMIT $start, $limit";
                    $sql2 .= " AND `status` = 0 ORDER BY `salary` ASC, `salary_end` DESC";
                }
            }
            if ($sort == 2) {
                if ($sql == "SELECT * FROM `vacancy`") {
                    $sql .= " WHERE `status` = 0 ORDER BY `salary_end` DESC, `salary` ASC LIMIT $start, $limit";
                    $sql2 .= " WHERE `status` = 0 ORDER BY `salary_end` DESC, `salary` ASC";
                } else {
                    $sql .= " AND `status` = 0 ORDER BY `salary_end` DESC, `salary` ASC LIMIT $start, $limit";
                    $sql2 .= " AND `status` = 0 ORDER BY `salary_end` DESC, `salary` ASC";
                }
            }
            if ($sort == 3) {
                if ($sql == "SELECT * FROM `vacancy`") {
                    $sql .= " WHERE `status` = 0 ORDER BY `id` DESC LIMIT $start, $limit";
                    $sql2 .= " WHERE `status` = 0 ORDER BY `id` DESC";
                } else {
                    $sql .= " AND `status` = 0 ORDER BY `id` DESC LIMIT $start, $limit";
                    $sql2 .= " AND `status` = 0 ORDER BY `id` DESC";
                }
            }
        } else {
            if ($sql == "SELECT * FROM `vacancy`") {
                $sql .= " WHERE `status` = 0 ORDER BY `id` DESC LIMIT $start, $limit";
                $sql2 .= " WHERE `status` = 0 ORDER BY `id` DESC";
            } else {
                $sql .= " AND `status` = 0 ORDER BY `id` DESC LIMIT $start, $limit";
                $sql2 .= " AND `status` = 0 ORDER BY `id` DESC";
            }
        }

        $people = [];
        $online = [];

        $sql_2 = $app->query($sql);
        while ($r = $sql_2->fetch()) {
            $people[] = $app->count("SELECT * FROM `online_job` WHERE `job` = $r[id]");
        }



        $sql_3 = $app->query("SELECT * FROM `vacancy` WHERE `admin` = 0");
        while ($r = $sql_3->fetch()) {
            $onc = $app->count("SELECT * FROM `online` WHERE `id` = '$r[company_id]' AND `type` = 'company'");
            if ($onc > 0) {
                $online[$r['company_id']] = $r['company_id'];
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

        $list = '';
        $text = '';
        $i = 0;

        if ($count > 0) {
             while ($r = $stmt->fetch()) {
                 $rc = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $r['company_id']]);
                 if ($r['salary'] > 0 && $r['salary_end'] > 0) {

                     if ($r['salary'] == $r['salary_end']) {
                         $salary = $r['salary'];
                     } else {
                         $salary = 'от ' . $r['salary'] . ' до ' . $r['salary_end'];
                     }

                 } else if ($r['salary'] > 0 && ($r['salary_end'] != '' || $r['salary_end'] <= 0)) {
                     $salary = 'от ' . $r['salary'];
                 } else if (($r['salary'] != '' || $r['salary'] <= 0) && $r['salary_end'] > 0) {
                     $salary = 'до ' . $r['salary_end'];
                 } else {
                     $salary = 'по договоренности';
                 }

                 $dop = '';

                 if ($r['invalid'] == 1 || $r['type'] == 'Удалённая' || $r['type'] == 'Стажировка') {
                     $dop .= '<ul class="vip-b-tag">';
                     if ($r['type'] == 'Удаленная') {
                         $dop .= '<li><i class="mdi mdi-home"></i> Удалённая работа</li>';
                     }
                     if ($r['type'] == 'Стажировка') {
                         $dop .= '<li><i class="mdi mdi-account-school"></i> Стажировка</li>';
                     }
                     if ($r['invalid'] == 1) {
                         $dop .= '<li><i class="mdi mdi-wheelchair"></i> Люди с инвалидностью</li>';
                     }
                     $dop .= '</ul>';
                 }

                 $bookmark = '';

                 if (isset($_SESSION['id']) && isset($_SESSION['password']) && $_SESSION['type'] == 'users') {

                     $bs = $app->rowCount("SELECT * FROM `bookmark-job` WHERE `job` = :id AND `user` = :ui", [
                         ':id' => $r['id'],
                         ':ui' => $_SESSION['id'],
                     ]);

                     if ($bs <= 0) {
                         $bookmark .= '<div data-jd="' . $r['id'] . '" class="bookmark-wrap bookmark-li bookmark-' . $r['id'] . '">
                                                    <button type="button" onclick="saveJob(' . $r['id'] . ')"><i class="mdi mdi-bookmark-outline"></i></button>
</div>';
                     } else {
                        $bookmark .= '<div data-jd="' . $r['id'] . '" class="bookmark-wrap bookmark-li bookmark-' . $r['id'] . '">
<button type="button" class="active-book" onclick="removeJob(' . $r['id'] . ')"><i class="mdi mdi-bookmark"></i></button>
</div>';
                     }


                 }

                 $list .= '
                 <li class="">
                     ' . ($people[$i] > 0 ? '<span class="resume-stat">Сейчас просматривают ' . $people[$i] . '</span>' : '') . '
                     ' . ($online[$r['company_id']] == $r['company_id'] && $r['admin'] == 0 ? '<span class="resume-stat">Работодатель сейчас онлайн</span>' : '') . '
                     <div class="vac-name">
                        <div class="vac-name-a">
                            <a target="_blank" href="/job/?id=' . $r['id'] . '">' . $r['title'] . '</a>
                            ' . $bookmark . '
                        </div>
                        <span>' . $salary . ' <i class="mdi mdi-currency-rub"></i></span>
                        <ul class="vl-b-tag">
                            <li title="Адрес"><i class="mdi mdi-crosshairs-gps"></i> ' . $r['address'] . '</li>
                            <li title="Опыт работы"><i class="mdi mdi-briefcase-variant-outline"></i> ' . $r['exp'] . '</li>
                            <li title="График работы"><i class="mdi mdi-calendar-month-outline"></i> ' . $r['time'] . '</li>
                        </ul>
                        '. $dop .'
                     </div>
                     <div class="vac-text">
                        <span>' . ($r['text'] != '' ? mb_strimwidth(strip_tags($r['text']), 0, 240, "...") : '') . '</span>
                    </div>
                    <div class="vac-comp">
                        <div class="left">
                            <span>' . $r['date'] . ', ' . $r['timses'] . '</span>
                            ' . ($r['admin'] == 0 ? ' 
                            
                            <div ' . ($rc['verified'] == 1 ? 'class="shield-hover"' : '') . '>
                          
                          ' . ($rc['verified'] == 1 ? '<div class="shield-wrap">
                                                        <i class="mdi mdi-check-circle-outline shiled-success"></i>
                                                        <div class="shield-block">Компания прошла проверку на сайте.</div>
                                                    </div>' : '') . '
                            
                            <a target="_blank" href="/company/?id=' . $r['company_id'] . '">    ' . ($r['company'] != '' ? mb_strimwidth(strip_tags($r['company']), 0, 20, "...") : '') . '</a>
                            
                            </div>
                            
                            ' : '') . ' 
                            
                            
                            ' . ($r['admin'] != 0 ? ' 
 
                             <div class="shield-hover">
                          
                                <div class="shield-wrap">
                                                        <i class="mdi mdi-alert-circle-outline shiled-success shiled-admin"></i>
                                                        <div class="shield-block">Вакансия выложена администатором</div>
                                                    </div>
                            
                            <a>    ' . ($r['company'] != '' ? mb_strimwidth(strip_tags($r['company']), 0, 20, "...") : '') . '</a>
                            
                            </div>
 
 
                              ' : '') . ' 
                            
                        </div>
                        <div class="right">
                            ' . ($r['admin'] == 0 && $r['img'] != 'placeholder.png' ? ' <a target="_blank" href="/company/?id=' . $r['company_id'] . '">
                                <img src="/static/image/company/' . $r['img'] . '" alt="">
                            </a>         ' : '') . '       
                        </div>
                    </div>
                 </li>
                 ';
                 $i++;
             }
             if ($key != null) {
                 $text .= 'Найдено ' . $countAll . ' вакансии, по запросу ' . $key;
             } else {
                 $text .= 'Найдено ' . $countAll . ' вакансии';
             }

        } else {
            $list .= '<span class="vac-none">Вакансии не найдены</span>';
            if ($key != null) {
                $text .= 'Найдено 0 вакансии, по запросу ' . $key;
            } else {
                $text .= 'Найдено 0 вакансии';
            }
        }


        return array (
            'list' => $list,
            'countText' => $text,
            'count' => $count,
            'countAll' => $countAll,
            'people' => $people,
            'online' => $online,
            'page' => $page,
            'limit' => $limit,
            'pagination' => $pagination,
        );
    }



    echo json_encode(array(
        'code' => 'success',
        'data' => getData(getOptions(), $PDO, $app)
    ));

} catch (Exception $e) {
    echo json_encode(array(
        'code' => 'error',
        'message' => $e->getMessage()
    ));

}

session_write_close();

exit;


/*$areaWhere =
        ($area !== null)
            ? " (`address` IN ($area) OR `region` IN ($area) OR `district` IN ($area) OR `area` IN ($area)) AND "
            : '';
    $salaryWhere =
        ($salary !== 0)
            ? " `salary` > $salary' AND "
            : " `salary` > 0 AND ";
    $expWhere =
        ($exp !== null)
            ? " `exp` LIKE '%$exp%' "
            : '';
    $timeWhere =
        ($time !== null)
            ? " `time` IN ($time) AND "
            : '';
    $typeWhere =
        ($type !== null)
            ? " `type` IN ($type) AND "
            : '';
    $companyWhere =
        ($company !== null)
            ? " `company_id` IN ($company) AND "
            : '';
    $categoryWhere =
        ($category !== null)
            ? " `category_id` IN ($category) AND "
            : '';*/