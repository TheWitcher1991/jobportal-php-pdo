<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $app->notFound();
    exit;
}

try {
    function getOptions()
    {
        $type = (isset($_POST['type'])) ? $_POST['type'] : null;
        $people = (isset($_POST['people'])) ? $_POST['people'] : null;
        $kard = (isset($_POST['kard'])) ? $_POST['kard'] : null;
        $vac = (isset($_POST['vac-non'])) ? $_POST['vac-non'] : null;
        $key = (isset($_POST['key'])) ? $_POST['key'] : null;
        $loc = (isset($_POST['loc'])) ? $_POST['loc'] : null;
        $page = (isset($_POST['page']) AND $_POST['page'] >= 1) ? (int)$_POST['page'] : 1;
        $limit = (isset($_POST['limit'])) ? (int)$_POST['limit'] : 25;

        return array(
            'type' => $type,
            'people' => $people,
            'kard' => $kard,
            'vac' => $vac,
            'key' => $key,
            'loc' => $loc,
            'page' => $page,
            'limit' => $limit
        );
    }

    function getData($options, $PDO, $app) {

        $options = getOptions();

        $type = $options['type'];
        $people = $options['people'];
        $kard = $options['kard'];
        $vac = $options['vac'];
        $key = trim($options['key']);
        $page = (int) $options['page'];
        $limit = (int) $options['limit'];
        $loc = trim($options['loc']);
        if ($page == 0) $page++;
        $start = ($page - 1) * $limit;

        if ($type != null) {
            foreach ($type as $val => $item) {
                if ($item == 1) $type[$val] = '"Частная"';
                if ($item == 2) $type[$val] = '"Государственная"';
                if ($item == 3) $type[$val] = '"Смешанная"';
            }
            $type = implode(', ', $type);
        }

        if ($people != null) {
            foreach ($people as $val => $item) {
                if ($item == 1) $people[$val] = '"10-50"';
                if ($item == 2) $people[$val] = '"50-100"';
                if ($item == 3) $people[$val] = '"100-200"';
                if ($item == 4) $people[$val] = '"200-400"';
                if ($item == 5) $people[$val] = '"400-500"';
                if ($item == 6) $people[$val] = '"500-1000"';
                if ($item == 7) $people[$val] = '"Более 1000"';
            }
            $people = implode(', ', $people);
        }

        $where = "";
        if ($key != null) $where = addWhere($where, "(`name` LIKE '%$key%' OR `about` LIKE '%$key%' OR `specialty` LIKE '%$key%')");
        if ($loc != null) $where = addWhere($where, "`address` LIKE '%$loc%'");
        if ($type != null) $where = addWhere($where, "`type` IN ($type)");
        if ($people != null) $where = addWhere($where, "`people` IN ($people)");
        if ($kard != null) $where = addWhere($where, "`type` != '%Кадровое агенство%'");
        if ($vac != null) $where = addWhere($where, "`job` > 0");

        $sql = "SELECT * FROM `company`";
        $sql2 = "SELECT * FROM `company`";
        if ($where) {
            $sql .= " WHERE $where";
            $sql2 .= " WHERE $where";
        }
        $sql .= " ORDER BY `id` DESC LIMIT $start, $limit";
        $sql2 .= " ORDER BY `id` DESC";
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

        for ($i = 1; $i <= $mid_size; $i++) {
            if ($page + $i <= $countPages) {
                $page_right .= '<div data-page="'.($page + $i).'"><a href>'.($page + $i).'</a></div>';
            }
        }

        $pagination = $start_page . $page_left . '<div class="page-active" data-page="'.$page.'"><a href>'.$page.'</a></div>' . $page_right . $last . $end_page . $forward;

        $html = "";

        if ($count > 0) {
            $arr_loss = [];

            while($r = $stmt->fetch()) {
                if (trim($r['name']) != '') {
                    $html .= '
    <li>
        <div class="company-ul-left">
            <div class="cu-title">
                <a target="_blank" href="/company?id='.$r['id'].'">' . (trim($r['name']) != '' ? $r['name'] : 'Без названия') . '</a>
                ' . (trim($r['specialty']) != '' ? '<a target="_blank" href="/company-list?key='.$r['specialty'].'">'.$r['specialty'].'</a>' : '<a></a>') . '
            </div>  
            <div class="cu-text">
                ' . (trim($r['about']) != '' ? mb_strimwidth($r['about'], 0, 250, "...") : '') . '
            </div>
            <div class="cu-tags">
                <ul>
                    <li>Вакансий '.$app->rowCount("SELECT * FROM `vacancy` WHERE `status` = 0 AND `company_id` = :ci", [':ci' => $r['id']]).'</li>
                    <li>
                        <i class="mdi mdi-crosshairs-gps"></i>
                        '.$r['address'].'
                    </li>
                </ul>
            </div>
        </div>
        <div class="company-ul-right">
            <div class="cu-img">
                <span>
                     ' . (trim($r['img']) != '' && $r['img'] != 'placeholder.png' ? '<img src="/static/image/company/'.$r['img'].'" alt="">' : '') . '
                </span>
            </div>
        </div>
    </li>
';
                } else {
                    $arr_loss[] = $r['id'];
                }
            }


        } else {
            $html .= '<span class="vac-none">Компании не найдены</span>';
        }

        if (count($arr_loss) > 0) {
            foreach ($arr_loss as $i) {
                $sql = "SELECT * FROM `company`";
                $sql .= " WHERE $where";
                $sql .= " ORDER BY `id` DESC";
                $stmt = $PDO->prepare($sql);
                $stmt->execute();

                while($r = $stmt->fetch()) {
                    if ($r['id'] == $i) {
                        $html .= '
    <li>
        <div class="company-ul-left">
            <div class="cu-title">
                <a target="_blank" href="/company?id='.$r['id'].'">' . (trim($r['name']) != '' ? $r['name'] : 'Без названия') . '</a>
                ' . (trim($r['specialty']) != '' ? '<a target="_blank" href="/company-list?key='.$r['specialty'].'">'.$r['specialty'].'</a>' : '<a></a>') . '
            </div>  
            <div class="cu-text">
                ' . (trim($r['about']) != '' ? mb_strimwidth($r['about'], 0, 250, "...") : '') . '
            </div>
            <div class="cu-tags">
                <ul>
                    <li>Вакансий '.$app->rowCount("SELECT * FROM `vacancy` WHERE `company_id` = :ci", [':ci' => $r['id']]).'</li>
                    <li>
                        <i class="mdi mdi-crosshairs-gps"></i>
                        '.$r['address'].'
                    </li>
                </ul>
            </div>
        </div>
        <div class="company-ul-right">
            <div class="cu-img">
                <span>
                
               ' . (trim($r['img']) != '' && $r['img'] != 'placeholder.png' ? '<img src="/static/image/company/'.$r['img'].'" alt="">' : '') . '
                
                    
                </span>
            </div>
        </div>
    </li>
';
                    }
                }
            }
        }

        return array (
            'list' => $html,
            'count' => $count,
            'countAll' => $countAll,
            'page' => $page,
            'limit' => $limit,
            'pagination' => $pagination,
            'options' => $options
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
