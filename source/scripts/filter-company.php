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
        $token = (isset($_POST['token'])) ? $_POST['token'] : null;

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

        $token = $options['token'];



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

        $pagination = '';

        if ($countAll > $limit) {
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

        }

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
            $html .= '<span class="no-file">
<svg width="224" viewBox="0 0 306 262" fill="none" xmlns="http://www.w3.org/2000/svg" class="e-notification__sign"><path d="M156.615 210.474c47.95 0 86.921-38.971 86.921-86.921 0-47.95-38.971-86.921-86.921-86.921-48.129 0-86.92 38.791-86.92 86.921 0 47.95 38.791 86.921 86.92 86.921Z" fill="#EDEDED"></path><path d="M101.923 99.791h105.07c3.936 0 7.477 3.345 7.477 7.477v66.308c0 3.935-3.345 7.477-7.477 7.477h-105.07c-3.935 0-7.477-3.345-7.477-7.477v-66.308c0-4.132 3.542-7.477 7.477-7.477Z" fill="url(#a)"></path><path d="M257.724 101.822c2.694-2.514 2.873-6.645.359-9.338-2.514-2.694-6.645-2.874-9.339-.36-2.694 2.515-2.873 6.645-.359 9.339 2.335 2.514 6.645 2.873 9.339.359ZM258.084 72.19c1.078-1.078 1.257-2.874.18-3.951-1.078-1.078-2.874-1.258-3.951-.18-1.078 1.077-1.257 2.873-.18 3.95 1.078 1.258 2.874 1.258 3.951.18ZM187.507 31.424c.718-.719.898-1.976.179-2.694-.718-.719-1.975-.898-2.694-.18-.718.718-.898 1.976-.179 2.694.718.718 1.975.898 2.694.18Z" fill="#EDEDED"></path><g filter="url(#b)"><path d="m252.642 64.768-26.169 46.633c-.984 1.574-2.952 2.164-4.329 1.18l-44.861-26.169c-1.574-.984-2.165-2.951-1.181-4.329l34.433-59.421c.984-1.575 2.952-2.165 4.329-1.181l32.465 18.889 5.313 24.398Z" fill="#F8F8F8"></path></g><path d="m247.33 40.37-7.477 12.593c-.984 1.967-.394 3.935 1.377 5.116l11.216 6.493" fill="#DDD"></path><path d="M216.438 52.569c.787-.197 1.574-.197 2.165-.197h2.361c.787.197 1.771.394 2.558.59.983.394 1.77.787 2.557 1.18a8.71 8.71 0 0 1 2.952 2.362c.787.787 1.377 1.77 1.771 2.952.393.983.393 2.164.393 3.148-.197 1.18-.59 2.36-1.18 3.345-.591.983-1.181 1.77-1.968 2.557-.787.59-1.377.984-2.361 1.378-.787.393-1.574.59-2.361.59l-2.165.197c-.59 0-1.18.197-1.967.393-.59.197-.984.394-1.377.787l-2.165 2.755-3.542-1.968 1.575-3.541c.196-.59.787-1.18 1.18-1.574.59-.394 1.181-.59 1.771-.787.787-.197 1.377-.197 2.164-.394.787 0 1.574-.197 2.361-.393.787-.197 1.378-.394 2.165-.787.787-.394 1.18-.984 1.574-1.771.197-.394.393-.984.59-1.574 0-.59 0-.984-.197-1.378-.196-.59-.393-.983-.787-1.377-.393-.394-.787-.787-1.377-1.18-.59-.394-1.377-.788-2.164-.984-.591-.197-1.181-.197-1.771-.197h-1.377c-.197 0-.591 0-.788-.197-.393-.197-.787-.787-.787-1.18l.197-2.755ZM206.403 78.54c.197-.393.591-.787.984-1.18.394-.197.787-.59 1.181-.59.984-.197 1.967-.197 2.754.393.394.197.787.59 1.181.984l.59 1.18c.591 1.968-.59 3.739-2.558 4.329-.983.197-1.967 0-2.754-.394-.394-.196-.787-.59-1.181-.983-.197-.394-.59-.787-.59-1.18-.197-.394-.197-.985 0-1.378 0-.394.197-.787.393-1.18Z" fill="#E0E0E0"></path><g filter="url(#c)"><path d="m84.412 44.503 29.908 31.285c.983 1.18.983 2.754-.197 3.738L83.625 108.45c-1.18.984-2.755.984-3.739-.197L41.715 67.917c-.984-1.18-.984-2.754.197-3.738l22.234-20.857 20.266 1.18Z" fill="#F8F8F8"></path></g><path d="m63.95 42.928 8.264 8.657c1.18 1.18 3.148 1.18 4.329 0l7.673-7.28" fill="#DDD"></path><path d="M66.31 69.884c0-.59.197-1.18.394-1.77l.59-1.772c.197-.59.59-1.18.984-1.77.394-.59.984-1.181 1.574-1.771.787-.788 1.574-1.378 2.558-1.771.787-.394 1.771-.59 2.558-.59.787 0 1.77.196 2.558.393.787.394 1.574.984 2.361 1.574.59.59 1.18 1.377 1.377 2.164.197.59.394 1.378.59 2.165v1.967c-.196.59-.196 1.181-.393 1.771 0 .59-.197.984-.197 1.574 0 .394 0 .787.394 1.18l1.574 2.362-2.361 2.164-2.361-2.164c-.394-.394-.787-.787-.984-1.377-.197-.59-.197-.984-.197-1.574 0-.59.197-1.181.197-1.771.197-.59.197-1.18.197-1.771 0-.59 0-1.18-.197-1.77-.197-.591-.59-1.181-.984-1.772-.197-.393-.59-.59-.984-.787-.393-.197-.787-.197-1.18-.197-.394 0-.787.197-1.18.394-.394.197-.788.394-1.181.787-.394.394-.787.984-1.181 1.377-.197.394-.394.787-.59 1.378-.197.393-.197.787-.197.983 0 .197-.197.394-.394.59-.196.394-.787.394-1.18.198l-2.164-.394Zm18.102 13.773c-.196-.197-.393-.59-.59-.984-.197-.393-.197-.787-.197-1.18 0-.787.394-1.574.984-2.164.197-.197.59-.394.984-.59.394-.198.787-.198 1.18-.198 1.181 0 2.362.788 2.755 1.968.197.394.197.787.197 1.18 0 .394-.197.788-.197 1.181-.197.394-.393.59-.787.984-.197.197-.59.59-.984.59-.787.197-1.574.197-2.164 0-.59-.197-.984-.393-1.18-.787Z" fill="#E0E0E0"></path><g filter="url(#d)"><path d="m162.524 93.692-11.608 41.516c-.394 1.378-1.968 2.362-3.345 1.771l-40.336-11.805c-1.378-.394-2.361-1.968-1.771-3.345l15.741-53.52c.393-1.376 1.967-2.36 3.345-1.77l29.317 8.657 8.657 18.496Z" fill="#F8F8F8"></path></g><path d="m153.873 75.27-3.742 11.732c-.394 1.574.59 3.345 2.164 3.739l10.378 2.932" fill="#DDD"></path><path d="m131.634 91.134 1.77-.59c.591-.197 1.181-.394 1.968-.394h2.164c.787 0 1.574.197 2.361.394.984.197 1.968.787 2.755 1.377a9.349 9.349 0 0 1 1.968 1.968c.393.787.787 1.574.984 2.361.196.984 0 1.968-.197 2.755-.197.787-.591 1.574-1.181 2.361a5.996 5.996 0 0 1-1.574 1.574c-.59.393-1.18.787-1.771.984l-1.771.59c-.393.197-.983.393-1.377.59-.393.197-.787.59-.787.984l-1.181 2.558-3.148-1.377.591-3.149c0-.59.393-.983.787-1.377.393-.393.787-.787 1.377-.984.59-.196 1.181-.393 1.574-.59.59-.197 1.181-.394 1.771-.787.59-.197.984-.59 1.574-.984.394-.393.787-.984.984-1.77v-.984c0-.394-.197-.788-.394-1.181-.196-.394-.59-.59-.984-.984a9.586 9.586 0 0 0-1.377-.59c-.59-.197-1.18-.197-1.967-.197-.394 0-.984 0-1.378.197-.393 0-.787.197-.984.197-.196 0-.393.196-.787 0-.393 0-.787-.394-.787-.787l-.983-2.165Zm-2.952 22.628c.197-.394.197-.787.59-.984.197-.394.591-.59.787-.787.787-.394 1.575-.394 2.165-.197.393.197.787.394.984.59l.787.787c.787 1.378.196 3.149-1.181 3.739-.787.393-1.574.393-2.164.197-.394-.197-.787-.197-.984-.591-.394-.196-.59-.59-.787-.787-.197-.393-.197-.59-.394-.984.197-.196.197-.59.197-.983Z" fill="#E0E0E0"></path><g filter="url(#e)"><path d="m257.364 164.723-38.171 20.66c-1.181.59-2.951.197-3.542-1.181l-19.086-37.187c-.59-1.181-.196-2.952 1.181-3.542l49.584-26.169c1.18-.591 2.951-.197 3.541 1.18l13.774 26.956-7.281 19.283Z" fill="#F8F8F8"></path></g><path d="m264.448 145.834-10.625 5.509c-1.377.787-1.968 2.755-1.377 4.132l4.722 9.445" fill="#DDD"></path><path d="M238.082 140.718c.59.197.984.59 1.574.787.59.197.984.59 1.574 1.18.59.591.984.984 1.377 1.574.591.591.984 1.181 1.378 1.968.59.787.787 1.968.787 2.755.196.984 0 1.771 0 2.754-.197.787-.591 1.574-.984 2.362-.59.787-1.377 1.377-2.164 1.77-.591.394-1.575.591-2.362.787-.59.197-1.574.197-2.164 0-.59-.196-1.377-.196-1.968-.59l-1.574-.787c-.393-.197-.983-.393-1.377-.59-.393-.197-.984-.197-1.181.197l-2.557.983-1.378-2.951 2.558-1.771c.394-.393.984-.393 1.574-.393.591 0 .984 0 1.574.196.591.197.984.591 1.378.787.59.197.983.591 1.771.787.59.197.983.197 1.77.394.591 0 1.181-.197 1.968-.59.59-.394 1.377-.984 1.377-1.968.197-.393 0-.787 0-1.377-.196-.394-.196-.787-.59-1.378-.197-.59-.59-.983-.984-1.574-.197-.196-.59-.59-.984-.787-.196-.196-.59-.393-.787-.59-.196-.197-.393-.197-.59-.59-.197-.197-.197-.787 0-.984l.984-2.361Zm-18.299 13.576c.394-.197.59-.393 1.181-.196.393-.197.787 0 .984 0 .787.196 1.377.787 1.574 1.377.196.393.196.787.196 1.18v.984c-.196.59-.787 1.378-1.377 1.574-.394.197-.787.197-1.181.197h-.983c-.787-.197-1.378-.787-1.574-1.377-.197-.394-.197-.787-.197-1.181-.197-.393 0-.787 0-.984.197-.393.393-.59.393-.983.197-.197.787-.197.984-.591Z" fill="#E0E0E0"></path><path d="M216.438 142.489v32.662c0 4.132-3.541 7.674-7.673 7.674H100.743c-4.132 0-7.674-3.542-7.674-7.674v-35.417" stroke="#5F6865" stroke-width="5.575" stroke-linecap="round" stroke-linejoin="round"></path><path d="M212.308 121.436h-36.991c-3.542 0-7.083 1.18-9.838 3.541l-9.838 7.871c-2.755 2.164-6.296 3.541-9.838 3.541h-42.107c-4.132 0-7.674 3.345-7.674 7.674 0 .394 0 .787.197 1.181l7.674 40.336c.59 3.738 3.935 6.689 7.674 6.689h89.919c3.935 0 7.084-2.754 7.674-6.493l10.822-55.486c.59-4.132-2.165-8.067-6.493-8.658-.394-.196-.788-.196-1.181-.196Z" fill="#fff"></path><g filter="url(#f)"><path d="M222.538 114.155h-44.074c-4.132 0-8.461 1.574-11.609 4.132l-11.806 9.642c-3.345 2.754-7.477 4.131-11.609 4.131H92.873c-4.92 0-9.248 3.936-9.248 9.248 0 .394 0 .984.197 1.378l9.248 48.993c.787 4.525 4.525 8.067 9.247 8.067h107.235c4.525 0 8.46-3.345 9.248-7.87l12.789-67.096c.787-4.919-2.558-9.838-7.674-10.625h-1.377Z" fill="url(#g)"></path></g><path d="M137.536 165.707c2.558 0 4.722-2.164 4.722-4.722 0-2.558-2.164-4.722-4.722-4.722-2.558 0-4.723 2.164-4.723 4.722 0 2.558 2.165 4.722 4.723 4.722ZM174.331 164.919c2.558 0 4.722-2.164 4.722-4.722 0-2.558-2.164-4.722-4.722-4.722-2.558 0-4.723 2.164-4.723 4.722 0 2.558 2.165 4.722 4.723 4.722ZM165.872 172.79h-2.558c-2.164-4.329-7.477-6.1-11.608-3.738-1.771.787-3.149 2.361-3.739 3.738h-2.558c2.165-5.706 8.658-8.657 14.167-6.493 2.951 1.18 5.116 3.542 6.296 6.493Z" fill="#CCC"></path><path d="M240.443 215.683c-2.164 0-1.377.197-18.102-16.528-16.134 12.003-38.565.394-38.565-19.282 0-13.183 10.822-24.005 24.005-24.005 19.086 0 30.892 21.447 19.676 37.778l15.544 15.544a3.708 3.708 0 0 1-2.558 6.493Zm-32.465-52.141c-9.051 0-16.528 7.28-16.528 16.528 0 9.247 7.28 16.528 16.528 16.528.984 0 1.968 0 2.951-.197.984-.197 1.968-.394 2.755-.787.984-.394 1.771-.787 2.558-1.181.984-.59 1.771-1.18 2.558-1.967l1.967-1.968c.591-.787 1.181-1.574 1.574-2.361.394-.787.787-1.771 1.181-2.755s.59-1.967.59-2.951c0-.787.197-1.377.197-2.165.197-9.444-7.28-16.724-16.331-16.724Z" fill="#BCBCBC"></path><path d="m125.93 152.917 10.625-5.706M183.58 150.163l-10.625-5.903" stroke="#CCC" stroke-width="2.787" stroke-miterlimit="10"></path><defs><filter id="b" x="134.738" y=".559" width="158.787" height="173.828" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood><feColorMatrix in="SourceAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix><feOffset dy="20.442"></feOffset><feGaussianBlur stdDeviation="20.442"></feGaussianBlur><feColorMatrix values="0 0 0 0 0.397708 0 0 0 0 0.47749 0 0 0 0 0.575 0 0 0 0.27 0"></feColorMatrix><feBlend in2="BackgroundImageFix" result="effect1_dropShadow"></feBlend><feBlend in="SourceGraphic" in2="effect1_dropShadow" result="shape"></feBlend></filter><filter id="c" x=".117" y="22.881" width="155.8" height="147.609" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood><feColorMatrix in="SourceAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix><feOffset dy="20.442"></feOffset><feGaussianBlur stdDeviation="20.442"></feGaussianBlur><feColorMatrix values="0 0 0 0 0.397708 0 0 0 0 0.47749 0 0 0 0 0.575 0 0 0 0.27 0"></feColorMatrix><feBlend in2="BackgroundImageFix" result="effect1_dropShadow"></feBlend><feBlend in="SourceGraphic" in2="effect1_dropShadow" result="shape"></feBlend></filter><filter id="d" x="64.406" y="45.923" width="139.001" height="152.556" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood><feColorMatrix in="SourceAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix><feOffset dy="20.442"></feOffset><feGaussianBlur stdDeviation="20.442"></feGaussianBlur><feColorMatrix values="0 0 0 0 0.397708 0 0 0 0 0.47749 0 0 0 0 0.575 0 0 0 0.27 0"></feColorMatrix><feBlend in2="BackgroundImageFix" result="effect1_dropShadow"></feBlend><feBlend in="SourceGraphic" in2="effect1_dropShadow" result="shape"></feBlend></filter><filter id="e" x="155.417" y="96.597" width="150.111" height="150.376" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood><feColorMatrix in="SourceAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix><feOffset dy="20.442"></feOffset><feGaussianBlur stdDeviation="20.442"></feGaussianBlur><feColorMatrix values="0 0 0 0 0.397708 0 0 0 0 0.47749 0 0 0 0 0.575 0 0 0 0.27 0"></feColorMatrix><feBlend in2="BackgroundImageFix" result="effect1_dropShadow"></feBlend><feBlend in="SourceGraphic" in2="effect1_dropShadow" result="shape"></feBlend></filter><filter id="f" x="42.742" y="93.714" width="229.844" height="167.357" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood><feColorMatrix in="SourceAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix><feOffset dy="20.442"></feOffset><feGaussianBlur stdDeviation="20.442"></feGaussianBlur><feColorMatrix values="0 0 0 0 0.397708 0 0 0 0 0.47749 0 0 0 0 0.575 0 0 0 0.27 0"></feColorMatrix><feBlend in2="BackgroundImageFix" result="effect1_dropShadow"></feBlend><feBlend in="SourceGraphic" in2="effect1_dropShadow" result="shape"></feBlend></filter><linearGradient id="a" x1="154.458" y1="105.765" x2="154.458" y2="136.483" gradientUnits="userSpaceOnUse"><stop stop-color="#BEBEBE"></stop><stop offset="1" stop-color="#8C8C8C"></stop></linearGradient><linearGradient id="g" x1="157.616" y1="112.175" x2="157.616" y2="200.669" gradientUnits="userSpaceOnUse"><stop stop-color="#FFFDFD"></stop><stop offset=".996" stop-color="#F1F1F1"></stop></linearGradient></defs></svg>
Компании не найдены</span>';
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
