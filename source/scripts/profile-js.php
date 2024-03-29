<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $app->notFound();
    exit;
}

if (isset($_SESSION['id']) && $_SESSION['type'] == 'users') {

    try {

        $count_acc = $app->rowCount("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if ($count_acc <= 0) {
            $app->notFound();
            exit;
        }

        if (isset($_POST['MODULE_SETTING_MAIL']) && $_POST['MODULE_SETTING_MAIL'] == 1) {
            echo json_encode(array('code' => 'success'));
            exit;
        }

        if (isset($_POST['MODULE_SAVE_LOGO']) && $_POST['MODULE_SAVE_LOGO'] == 1) {

            if (trim($_POST['img']) == '') {
                echo json_encode(array(
                    'code' => 'error',
                ));
                exit;
            } else {
                $r = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']]);

                if (count($r) > 0) {

                    $filename = preg_replace("/[^a-z0-9\.-]/i", '', $_POST['img']);

                    $tmp_path = $_SERVER['DOCUMENT_ROOT'] . '/static/temp/';
                    $path = $_SERVER['DOCUMENT_ROOT'] . '/static/image/users/';

                    $app->execute("UPDATE `users` SET `img` = :img WHERE `id` = :id", [
                        ':img' => $filename,
                        ':id' => $_SESSION['id']
                    ]);

                    if ($app->execute("UPDATE `chat` SET `img` = :img WHERE `user_id` = :id", [
                        ':img' => $filename,
                        ':id' => $_SESSION['id']
                    ])) {

                    }



                    rename($tmp_path . $filename, $path . $filename);

                    $file_name = pathinfo($filename, PATHINFO_FILENAME);
                    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $thumb = $file_name . '-thumb.' . $file_ext;
                    rename($tmp_path . $thumb, $path . $thumb);

                    echo json_encode(array('code' => 'success'));
                    exit;
                } else {
                    echo json_encode(array(
                        'code' => 'error',
                    ));
                    exit;
                }
            }

        }

        if (isset($_POST['MODULE_CREATE_2FA']) && $_POST['MODULE_CREATE_2FA'] == 1) {

            $r = $app->fetch("SELECT * FROM `users` WHERE `id` = :id AND `2fa` = 0", [':id' => $_SESSION['id']]);

            if (count($r) > 0) {
                $err = [];

                $password = $_POST['password'];

                if (empty($password) or trim($password) == '') $err['password'] = 'Введите пароль';
                else if ((md5(md5($_POST['password'] . $r['code'] . $r['name'])) != $_SESSION['password'])
                    && (md5(md5($_POST['password'] . $r['code'] . $r['email'])) != $_SESSION['password'])) $err['password'] = 'Вы ввели неверный пароль';

                if (empty($err)) {

                    $app->execute("UPDATE `users` SET `2fa` = 1 WHERE `id` = :id", [':id' => $r['id']]);

                    echo json_encode(array('code' => 'success'));
                    exit;
                } else {
                    echo json_encode(array(
                        'error' => $err,
                        'code' => 'validate_error',
                    ));
                    exit;
                }
            }

        }

        if (isset($_POST['MODULE_DELETE_2FA']) && $_POST['MODULE_DELETE_2FA'] == 1) {

            $r = $app->fetch("SELECT * FROM `users` WHERE `id` = :id AND `2fa` = 1", [':id' => $_SESSION['id']]);

            if (count($r) > 0) {
                $err = [];

                $password = $_POST['password'];

                if (empty($password) or trim($password) == '') $err['password'] = 'Введите пароль';
                else if ((md5(md5($_POST['password'] . $r['code'] . $r['name'])) != $_SESSION['password'])
                    && (md5(md5($_POST['password'] . $r['code'] . $r['email'])) != $_SESSION['password'])) $err['password'] = 'Вы ввели неверный пароль';

                if (empty($err)) {

                    $app->execute("UPDATE `users` SET `2fa` = 0 WHERE `id` = :id", [':id' => $r['id']]);

                    echo json_encode(array('code' => 'success'));
                    exit;
                } else {
                    echo json_encode(array(
                        'error' => $err,
                        'code' => 'validate_error',
                    ));
                    exit;
                }
            }

        }

        if (isset($_POST['MODULE_MARK_J0B']) && $_POST['MODULE_MARK_J0B'] == 1) {

            if (isset($_POST['id']) && $_POST['id'] > 0) {

                $r = $app->rowCount("SELECT * FROM `vacancy` WHERE `id` = :id", [':id' => intval($_POST['id'])]);

                if ($r > 0) {

                    $b = $app->rowCount("SELECT * FROM `bookmark-job` WHERE `job` = :id AND `user` = :ui", [
                        ':id' => intval($_POST['id']),
                        ':ui' => $_SESSION['id'],
                    ]);

                    if ($b <= 0) {
                        $app->execute("INSERT INTO `bookmark-job` (`user`, `job`, `time`, `day`, `year`, `hour`) VALUES (:ui, :ji, NOW(), :d, :y, :h)", [
                            ':ui' => $_SESSION['id'],
                            ':ji' => intval($_POST['id']),
                            ':d' => $Date_ru,
                            ':y' => date("Y"),
                            ':h' => date("H:i")
                        ]);

                        echo json_encode(array(
                            'code' => 'success',
                        ));
                        exit;
                    }
                }

            }


        }

        if (isset($_POST['MODULE_UNMARK_J0B']) && $_POST['MODULE_UNMARK_J0B'] == 1) {
            if (isset($_POST['id']) && $_POST['id'] > 0) {

                $r = $app->rowCount("SELECT * FROM `vacancy` WHERE `id` = :id", [':id' => intval($_POST['id'])]);

                if ($r > 0) {

                    $b = $app->rowCount("SELECT * FROM `bookmark-job` WHERE `job` = :id AND `user` = :ui", [
                        ':id' => intval($_POST['id']),
                        ':ui' => $_SESSION['id'],
                    ]);

                    if ($b > 0) {
                        $app->execute("DELETE FROM `bookmark-job` WHERE `job` = :id AND `user` = :ui", [
                            ':id' => intval($_POST['id']),
                            ':ui' => $_SESSION['id'],
                        ]);

                        $count = $app->rowCount("SELECT * FROM `bookmark-job` WHERE `user` = :ui", [
                            ':ui' => $_SESSION['id'],
                        ]);

                        echo json_encode(array(
                            'code' => 'success',
                            'count' => $count
                        ));
                        exit;
                    }
                }

            }
        }

        if (isset($_POST['MODULE_EDIT_REVIEW']) && $_POST['MODULE_EDIT_REVIEW'] == 1) {

            $err = [];

            $r = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']]);

            if (count($r) > 0) {

                if (empty($_POST['me']) || trim($_POST['me']) == '') $err['me'] = 'Это поле не должно быть пустым';
                if (empty($_POST['prof']) || trim($_POST['prof']) == '') $err['prof'] = 'Введите профессию';
                if ($_POST['rating'] < 0 || $_POST['rating'] > 5) $err['rating'] = 'Рейтинг указан неверно';

                if (empty($err)) {

                    $count = $app->fetch("SELECT * FROM `review` WHERE `user_id` = :ui AND `id` = :id", [
                        ':ui' => $_SESSION['id'],
                        ':id' => intval($_POST['id'])
                    ]);

                    if (count($count) > 0) {

                        $rating = (int) $_POST['rating'];
                        $prof = XSS_DEFENDER($_POST['prof']);
                        $me = XSS_DEFENDER($_POST['me']);
                        $text = XSS_DEFENDER($_POST['text']);

                        $app->execute("UPDATE `review` SET 
                                `rating` = :rating, 
                                `prof` = :prof,
                                `me` = :me,
                                `text` = :text WHERE `id` = :id AND `user_id` = :ui",
                            [
                                ':rating' => $rating,
                                ':prof' => $prof,
                                ':me' => $me,
                                ':text' => $text,
                                ':ui' => $_SESSION['id'],
                                ':id' => intval($_POST['id'])
                            ]
                        );

                        echo json_encode(array(
                            'code' => 'success',
                        ));
                        exit;
                    }
                } else {
                    echo json_encode(array(
                        'error' => $err,
                        'code' => 'validate_error',
                    ));
                    exit;
                }

            }

        }

        if (isset($_POST['MODULE_DELETE_FILE']) && $_POST['MODULE_DELETE_FILE'] == 1) {

            if (isset($_POST['id']) && isset($_POST['file']) && $_POST['id'] > 0 && trim($_POST['file']) != '') {

                $count = $app->fetch("SELECT * FROM `achievement_images` WHERE `id` = :id AND `filename` = :fl AND `user_id` = :ui", [
                    ':id' => intval($_POST['id']),
                    ':fl' => XSS_DEFENDER($_POST['file']),
                    ':ui' => $_SESSION['id']
                ]);

                if (count($count) > 0) {

                    $path = $_SERVER['DOCUMENT_ROOT'] . '/static/file/users_file/';

                    unlink($path . $count['filename']);

                    $app->execute("DELETE FROM `achievement_images` WHERE `id` = :id AND `filename` = :fl AND `user_id` = :ui", [
                        ':id' => intval($_POST['id']),
                        ':fl' => XSS_DEFENDER($_POST['file']),
                        ':ui' => $_SESSION['id']
                    ]);

                    echo json_encode(array(
                        'code' => 'success',
                    ));
                    exit;
                }

            }

        }

        if (isset($_POST['MODULE_RESTORE_RESPOND']) && $_POST['MODULE_RESTORE_RESPOND'] == 1) {

            if (isset($_POST['id']) && $_POST['id'] >= 1) {

                $count = $app->rowCount("SELECT * FROM `respond_user` WHERE `id` = :id AND `user_id` = :ui", [
                    ':id' => intval($_POST['id']),
                    ':ui' => $_SESSION['id']
                ]);

                if ($count > 0) {

                    $app->execute("UPDATE `respond_user` SET `new` = 0 WHERE `id` = :id AND `user_id` = :ui", [
                        ':id' => intval($_POST['id']),
                        ':ui' => $_SESSION['id']
                    ]);

                }

            }

        }

        if (isset($_POST['MODULE_GET_LIST_USER']) && $_POST['MODULE_GET_LIST_USER'] == 1) {
            function getOptions()
            {
                $exp = (isset($_POST['exp'])) ? $_POST['exp'] : null;
                $time = (isset($_POST['time'])) ? $_POST['time'] : null;
                $type = (isset($_POST['type'])) ? $_POST['type'] : null;
                $more1 = (isset($_POST['more1'])) ? $_POST['more1'] : null;
                $more2 = (isset($_POST['more2'])) ? $_POST['more2'] : null;
                $more3 = (isset($_POST['more3'])) ? $_POST['more3'] : null;
                $key = (isset($_POST['key'])) ? $_POST['key'] : null;
                $loc = (isset($_POST['loc'])) ? $_POST['loc'] : null;
                $company = (isset($_POST['company'])) ? implode(', ', $_POST['company']) : null;
                $sort = (isset($_POST['sort'])) ?  (int) $_POST['sort'] : null;
                $status = (isset($_POST['t'])) ? (int) $_POST['t'] : null;
                $page = (isset($_POST['page'])) ? (int)$_POST['page'] : 1;

                return array(
                    'exp' => $exp,
                    'time' => $time,
                    'type' => $type,
                    'more1' => $more1,
                    'more2' => $more2,
                    'more3' => $more3,
                    'key' => $key,
                    'loc' => $loc,
                    'company' => $company,
                    'sort' => $sort,
                    'status' => $status,
                    'page' => $page,
                );
            }

            function getData($options, $PDO, $app) {
                $exp = $options['exp'];
                $time = $options['time'];
                $type = $options['type'];
                $more1 = $options['more1'];
                $more2 = $options['more2'];
                $more3 = $options['more3'];
                $key = $options['key'];
                $loc = $options['loc'];
                $company = $options['company'];
                $sort = $options['sort'];
                $status = $options['status'];
                $page = (int) $options['page'];
                if ($page == 0) $page++;
                $limit = 15;

                $start = ($page - 1) * $limit;

                $list = "";
                $pagination = "";
                $countAll = 0;
                $count = 0;

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

                $where = "";
                $where = addWhere($where, "`user_id` = $_SESSION[id]");
                if ($status == 6) $where = addWhere($where, "`status` = $status");
                $sql = "SELECT * FROM `respond_user`";
                $sql2 = "SELECT * FROM `respond_user`";

                if ($where) {
                    $sql .= " WHERE $where";
                    $sql2 .= " WHERE $where";
                }

                if ($sort != null) {
                    if ($sort == 1) {
                        $sql .= " ORDER BY `status`, `new` DESC LIMIT $start, $limit";
                        $sql2 .= " ORDER BY `status`, `new` DESC";
                    }
                    if ($sort == 2) {
                        $sql .= " ORDER BY `id`, `new` DESC LIMIT $start, $limit";
                        $sql2 .= " ORDER BY `id`, `new` DESC";
                    }
                } else {
                    $sql .= " ORDER BY `id`, `new` DESC LIMIT $start, $limit";
                    $sql2 .= " ORDER BY `id`, `new` DESC";
                }

                $stmt2 = $PDO->prepare($sql2);
                $stmt2->execute();
                $countAll = $stmt2->rowCount();

                $stmt = $PDO->prepare($sql);
                $stmt->execute();
                $count = $stmt->rowCount();

                if ($count > 0) {

                    $count = 0;
                    while ($data = $stmt->fetch()) {

                        if ($status != 6) {
                            $job = $app->fetch("SELECT * FROM `vacancy` WHERE `id` = :id", [':id' => $data['job_id']]);
                            $sql = "SELECT * FROM `users` WHERE `id` = :id";
                            $sth_1 = $PDO->prepare($sql);
                            $sth_1->execute([intval($data['user_id'])]);

                            $where = "";

                            if ($key != null) $where = addWhere($where, "`title` LIKE '%$key%'");
                            if ($loc != null) $where = addWhere($where, "`address` LIKE '%$loc%'");
                            if ($exp != null) $where = addWhere($where, "`exp` LIKE '%$exp%'");
                            if ($time != null) $where = addWhere($where, "`time` IN ($time)");
                            if ($type != null) $where = addWhere($where, "`type` IN ($type)");
                            if ($company != null) $where = addWhere($where, "`company_id` IN ($company)");
                            if ($more1 != null) $where = addWhere($where, "`go` = 1");
                            if ($more2 != null) $where = addWhere($where, "`urid` != ''");
                            if ($more3 != null) $where = addWhere($where, "`invalid` = 1");
                            $where = addWhere($where, "id = $data[job_id]");
                            $sqlv = "SELECT * FROM `vacancy`";
                            if ($where) {
                                $sqlv .= " WHERE $where";
                            }

                            $sth = $PDO->prepare($sqlv);
                            $sth->execute();

                            if ($sth->rowCount() > 0) {
                                $r = $sth->fetch();
                                if ($r['id'] == $data['job_id'] && ($status == $data['status'] || $status == -1)) {

                                    $ctx = '';

                                    if (!empty($r['exp'])) {
                                        $ctx .= '
                                        <li>
                                            <span>Опыт работы</span>
                                            <span>'.$r['exp'].'</span>
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

                                    if (!empty($r['degree'])) {
                                        $ctx .= '
                                        <li>
                                            <span>Образование</span>
                                            <span>'.$r['degree'].'</span>
                                        </li> 
                                ';
                                    }



                                    $chatCount = $app->rowCount("SELECT * FROM `chat` WHERE `user_id` = :ui AND `company_id` = :ci", [
                                        ':ui' => $_SESSION['id'],
                                        ':ci' => $r['company_id']
                                    ]);

                                    $chat = '';



                                    if ($chatCount > 0) {

                                        $chats = $app->fetch("SELECT * FROM `chat` WHERE `user_id` = :ui AND `company_id` = :ci", [
                                            ':ui' => $_SESSION['id'],
                                            ':ci' => $r['company_id']
                                        ]);
                                        #$chat = '<a data-chat="'.$chats['id'].'" class="man-a chat-'.$chats['id'].'" onclick="openChat('.$chats['id'].')"><i class="mdi mdi-chat-outline"></i></a>';
                                        $chat = '<a class="man-a" target="_blank" href="/messages/?id='.$chats['id'].'"><i class="mdi mdi-chat-outline"></i></a>';
                                    }

                                    if ($data['new'] == 1) {
                                        $button = '<button class="man-bth man-red bth-respond-open" data-id="'.$data['id'].'" onclick="createWin_'.$data['id'].'();" type="button">Подробно</button>';
                                    } else {
                                        $button = '<button class="man-bth" onclick="createWin_'.$data['id'].'()" type="button">Подробно</button>';
                                    }




                                    if ($data['status'] == 0 || $data['status'] == 1) {
                                        $st = 'На рассмотрении';
                                    } else if ($data['status'] == 2) {
                                        $st = 'Разговор по телефону';
                                    } else if ($data['status'] == 3) {
                                        $st = 'Назначена встреча';
                                    } else if ($data['status'] == 4) {
                                        $st = 'Принят на работу';
                                    } else if ($data['status'] == 5) {
                                        $st = 'Отказано';
                                    }

                                    $stext = '';

                                    if ($data['status'] == 0 || $data['status'] == 1 || $data['status'] == 2 || $data['status'] == 3 || $data['status'] == 4) {
                                        $stext = '<span class="status-yes">'.$st.'</span>';
                                    } else if ($data['status'] == 5) {
                                        $stext =  '<span class="status-none">'.$st.'</span>';
                                    } else {
                                        $stext = '<span class="status-unf">Не определён</span>';
                                    }

                                    $remsg = $app->fetch("SELECT * FROM `respond_message` WHERE `job` = :ji AND `user` = :ui AND `type` = :st",
                                    [
                                        ':ji' => $r['id'],
                                        ':ui' => $_SESSION['id'],
                                        ':st' => $data['status']
                                    ]);

                                    $pop = '';

                                    if (isset($remsg['id'])) {
                                        $pop = '
                                        <div class="sp-stat">
                                            '.($data['status'] == 2 ? $r['company'] . ' назначила Вам телефонную беседу' : '').'
                                            '.($data['status'] == 3 ? 'Поздравляем! ' . $r['company'] . ' назначила Вам собеседование!' : '').'
                                            '.($data['status'] == 4 ? 'Поздравляем! ' . $r['company'] . ' готова принять Вас на работу!' : '').'
                                            '.($data['status'] == 5 ? 'К сожалению, ' . $r['company'] . ' отказала в Вашей кандидатуре' : '').'
                                        </div>
                                        <div class="text-stat">
                                        '.(trim($remsg['text']) != '' ? $remsg['text'] : 'Компания не оставила Вам сообщения').'
                                        </div>
                                        <div class="text-more-s">
                                        
                                        '.($data['status'] == 2 ? '
                                            <span>День: <m>'.$remsg['text_day'].'</m></span>
                                            <span>Время: <m>'.$remsg['text_time'].'</m></span>
                                        ' : '').'
                                        
                                        '.($data['status'] == 3 ? '
                                            <span>День: <m>'.$remsg['text_day'].'</m></span>
                                            <span>Время: <m>'.$remsg['text_time'].'</m></span>
                                            <span>Адрес: <m>'.$remsg['text_address'].'</m></span>
                                        ' : '').'
                                        
                                        </div>
                                        
                                        ';
                                    } else {

                                        if ($data['status'] == 0) {
                                            $pop = '
                                        <div class="sp-stat">
                                            На данный момент '.$r['company'].' не совершила с Вашим откликом никаких действий.
                                        </div>
                                        <div class="text-stat">
                                            Скорее всего компания сейчас рассматривает Вашу кандидатуру. (Данная система не отображает полноту картины — она является условной. Компания может не сортировать отклики и не отправлять Вам сообщения через нашу системy)
                                        </div>
                                        ';
                                        } else if ($data['status'] != 0) {
                                            $pop = '
                                           
                                               <div class="sp-stat">
                                            '.$r['company'].' сменила статус Вашего отклика, но не оставила сообщение
                                        </div>
                                            ';
                                        }


                                    }

                                    $letter_t = '';

                                    if (trim($data['text']) != '') {
                                        $letter_t = '<br /> <div style="font-weight: 600">Ваше сопроводительное письмо:</div> ' . $data['text'];
                                    }



                                    $click = "$('.item-$data[id]').slideToggle(100);$(this).toggleClass('resp-rotate');$('.respond-item-$data[id]').toggleClass('item-active')";

                                    $list .= '
<script>
function createWin_'.$data['id'].'() {
    document.querySelector(".profile-body").innerHTML += `
    
<div id="auth" style="display:flex">
    <div class="contact-wrapper" style="display:block">
        <div class="auth-respond auth-log" style="display:block">
             <div class="auth-title">
                Отклик            
                <i class="mdi mdi-close restore-ajax" onclick="location.reload()"></i>
             </div>
             <div class="auth-form">
                <span><i class="icon-briefcase"></i> '.$r['title'].'</span>
                    '.$pop.'
                    '.$letter_t.'
                <div class="re-flex">
                    <span class="re-300">Откликнулись '.DateTime::createFromFormat('Y-m-d H:i:s', $data['time'])->format('d.m.Y H:i').'</span>
                </div>
                <div style="margin:0" class="re-flex-2">
                     <span><i class="mdi mdi-phone"></i> '.$r['phone'].'</span>
                     <span><i class="mdi mdi-at"></i> '.$r['email'].'</span>
                     <span><i class="mdi mdi-account"></i> '.$r['contact'].'</span>
                </div>
             </div>
        </div>
    </div>
</div>
    
    `;
}
</script>

            <li class="respond-item-'.$data['id'].'" '. ($data['new'] == 1 ? 'style="border:2px solid #d32e2e"' : '') .'>
                   
                     <div class="vac-name">
                     
              
                        <a target="_blank" href="/job/?id=' . $r['id'] . '">' . $r['title'] . '</a>
                        <span>'. (!empty($r['salary']) ? $r['salary'] . ' руб.' : 'По договорённости' ) . ' </span>
                         <ul class="re-ul">
                            <li>
                                <span>Место работы</span>
                                <span>' . $r['address'] . '</span>
                            </li>
                 
                            <li>
                                <span>Период</span>
                                <span>' . $r['date'] . ' — '. DateTime::createFromFormat('Y-m-d', $r['task'])->format('d.m.Y') .'</span>
                            </li>
                            <li>
                                <span>Опыт работы</span>
                                <span>' . $r['exp'] . '</span>
                            </li>
                            <li>
                                <span>График работы</span>
                                <span>' . $r['time'] . '</span>
                            </li>
                            <li>
                                <span>Тип занятости</span>
                                <span>' . $r['type'] . '</span>
                            </li>
                            <li>
                                <span>Образование</span>
                                <span>' . $r['degree'] . '</span>
                            </li>
                        </ul> 
                        <div class="manag-addi">
                        
                            ' . ($r['invalid'] == 1 ? '<span><i class="mdi mdi-wheelchair"></i> Доступна людям с инвалидностью</span>' : '') . '
                            ' . ($r['go'] == 1 ? '<span><i class="mdi mdi-plane-car"></i> Поможем с переездом</span>' : '') . '
                             
                        </div>
                     </div>
                     <div class="vac-analis">
                        <div class="va-top" >
                            <span>Статус <m>'.$stext.'</m></span>
                            <span>Телефон <m>' . $r['phone'] . '</m></span>
                            <span>Email  <m>' . $r['email'] . '</m></span>
                              '. (trim($r['contact']) != '' ? ' <span>Контактное лицо <m>' . $r['contact'] . '</m></span>' : '') .' 
                       
                            <span>Откликнулись <m>'.DateTime::createFromFormat('Y-m-d H:i:s', $data['time'])->format('d.m.Y H:i').'</m></span>
                        </div>
                        <div class="va-bot" style="margin: 10px 0 0 0;">
                            '.$button.'
                            '.$chat.'
                            <!--<button class="man-bth-mini" onclick="" type="button"><i class="mdi mdi-close"></i></button>-->
                        </div>
                    </div>
                 </li>


                                    ';
                                    $count++;
                                }
                            }
                        } else if ($status == 6) {

                            $r = $app->fetch("SELECT * FROM `respond_message` WHERE `company` = :ji AND `user` = :ui AND `type` = :st",
                                [
                                    ':ji' => $data['company_id'],
                                    ':ui' => $_SESSION['id'],
                                    ':st' => $data['status']
                                ]);

                            $c = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $r['company']]);

                            $chats = $app->fetch("SELECT * FROM `chat` WHERE `user_id` = :ui AND `company_id` = :ci", [
                                ':ui' => $_SESSION['id'],
                                ':ci' => $c['id']
                            ]);

                            $chat = '';

                            if (count($chats) > 0) {
                                $chat = '<button type="button"><a target="_blank" href="/messages/?id='.$chats['id'].'">Перейти в чат</a></button>';
                            }

                            $list .= '

<div class="respond-item respond-item-'.$data['id'].'">
    <div class="resp-top">
        <div class="re-name">
            <div><a href="/company/?id='.$c['id'].'">'.$c['name'].' пригласила Вас к себе на работу</a></div>
           
        </div>  
        <div style="display: block" class="resp-content item-'.$data['id'].'">
            <div class="re-about">
                <pre style="white-space: initial">'.strip_tags($r['text']).'</pre>
            </div>
        </div>
    
        <div class="re-flex">
              <span class="re-300">Создано '.$r['date'].', '.$r['hour'].'</span>
                                   
        </div>
        <div class="re-flex-2">
             <span><i class="mdi mdi-phone"></i> '.$c['phone'].'</span>
             <span><i class="mdi mdi-at"></i> '.$c['email'].'</span>
             '. (trim($r['username']) != '' ? '<span><i class="mdi mdi-account"></i> '.$r['username'].'</span>' : '') .' 
        </div>
        <div class="resp-bth">
            '.$chat.'
        </div>
    </div>
</div>
                                    ';

                            $count ++;


                        }

                    }


                    if ($count <= 0) {
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
                    'type' => $status,
                );
            }

            echo json_encode(array(
                'code' => 'success',
                'data' => getData(getOptions(), $PDO, $app)
            ));
        }

        if (isset($_POST['MODULE_GET_LIST_SAVE']) && $_POST['MODULE_GET_LIST_SAVE'] == 1) {
            function getOptions()
            {
                $exp = (isset($_POST['exp'])) ? $_POST['exp'] : null;
                $time = (isset($_POST['time'])) ? $_POST['time'] : null;
                $type = (isset($_POST['type'])) ? $_POST['type'] : null;
                $more1 = (isset($_POST['more1'])) ? $_POST['more1'] : null;
                $more2 = (isset($_POST['more2'])) ? $_POST['more2'] : null;
                $more3 = (isset($_POST['more3'])) ? $_POST['more3'] : null;
                $key = (isset($_POST['key'])) ? $_POST['key'] : null;
                $loc = (isset($_POST['loc'])) ? $_POST['loc'] : null;
                $company = (isset($_POST['company'])) ? implode(', ', $_POST['company']) : null;
                $page = (isset($_POST['page'])) ? (int)$_POST['page'] : 1;

                return array(
                    'exp' => $exp,
                    'time' => $time,
                    'type' => $type,
                    'more1' => $more1,
                    'more2' => $more2,
                    'more3' => $more3,
                    'key' => $key,
                    'loc' => $loc,
                    'company' => $company,
                    'page' => $page,
                );
            }

            function getData($options, $PDO, $app) {
                $exp = $options['exp'];
                $time = $options['time'];
                $type = $options['type'];
                $more1 = $options['more1'];
                $more2 = $options['more2'];
                $more3 = $options['more3'];
                $key = $options['key'];
                $loc = $options['loc'];
                $company = $options['company'];
                $page = (int) $options['page'];
                if ($page == 0) $page++;
                $limit = 15;

                $start = ($page - 1) * $limit;

                $list = "";
                $pagination = "";
                $countAll = 0;
                $count = 0;

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

                $where = "";
                $where = addWhere($where, "`user` = $_SESSION[id]");
                $sql = "SELECT * FROM `bookmark-job`";
                $sql2 = "SELECT * FROM `bookmark-job`";

                if ($where) {
                    $sql .= " WHERE $where";
                    $sql2 .= " WHERE $where";
                }

                $sql .= " ORDER BY `id` DESC";
                $sql2 .= " ORDER BY `id` DESC";

                $stmt2 = $PDO->prepare($sql2);
                $stmt2->execute();
                $countAll = $stmt2->rowCount();

                $stmt = $PDO->prepare($sql);
                $stmt->execute();
                $count = $stmt->rowCount();



                if ($count > 0) {
                    $list .= "<div class=\"respond-list\">";
                    $count = 0;
                    while ($data = $stmt->fetch()) {

                        $job = $app->fetch("SELECT * FROM `vacancy` WHERE `id` = :id", [':id' => $data['job']]);
                        $sql = "SELECT * FROM `users` WHERE `id` = :id";
                        $sth_1 = $PDO->prepare($sql);
                        $sth_1->execute([intval($data['user'])]);


                        $where = "";

                        if ($key != null) $where = addWhere($where, "`title` LIKE '%$key%'");
                        if ($loc != null) $where = addWhere($where, "`address` LIKE '%$loc%'");
                        if ($exp != null) $where = addWhere($where, "`exp` LIKE '%$exp%'");
                        if ($time != null) $where = addWhere($where, "`time` IN ($time)");
                        if ($type != null) $where = addWhere($where, "`type` IN ($type)");
                        if ($company != null) $where = addWhere($where, "`company_id` IN ($company)");
                        if ($more1 != null) $where = addWhere($where, "`go` = 1");
                        if ($more2 != null) $where = addWhere($where, "`urid` != ''");
                        if ($more3 != null) $where = addWhere($where, "`invalid` = 1");
                        $where = addWhere($where, "id = $data[job]");
                        $sqlv = "SELECT * FROM `vacancy`";
                        if ($where) {
                            $sqlv .= " WHERE $where";
                        }


                        $sth = $PDO->prepare($sqlv);
                        $sth->execute();



                        if ($sth->rowCount() > 0) {
                            $r = $sth->fetch();


                            if ($r['id'] == $data['job']) {


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



                                $chats = $app->fetch("SELECT * FROM `chat` WHERE `user_id` = :ui AND `company_id` = :ci", [
                                    ':ui' => $_SESSION['id'],
                                    ':ci' => $r['company_id']
                                ]);

                                $chat = '';



                                if (!empty($chats['id'])) {
                                    $chat = '<button type="button"><a target="_blank" href="/messages/?id='.$chats['id'].'">Перейти в чат</a></button>';
                                }



                                if ($r['salary'] > 0 && $r['salary_end'] > 0) {
                                    $salary = 'от ' . $r['salary'] . ' до ' . $r['salary_end'];
                                } else if ($r['salary'] > 0 && ($r['salary_end'] != '' || $r['salary_end'] <= 0)) {
                                    $salary = 'от ' . $r['salary'];
                                } else if (($r['salary'] != '' || $r['salary'] <= 0) && $r['salary_end'] > 0) {
                                    $salary = 'до ' . $r['salary_end'];
                                } else {
                                    $salary = 'по договоренности';
                                }


                                $list .= '

<div class="new-block new-block-'.$data['job'].'">
    <div class="new-block-title">
        <div class="n-left">
            <a target="_blank" href="/company/?id='.$r['company_id'].'"><img src="/static/image/company/'.$r['img'].'" alt=""></a>
            <div>
                <a target="_blank" href="/job/?id='.$r['id'].'" class="nl-title">'.$r['title'].'</a>
                <div class="new-temp">
                    <a target="_blank" href="/company/?id='.$r['company_id'].'">'.$r['company'].'</a>
                    <span><i class="mdi mdi-map-marker-outline"></i> '. str_replace('город', '', $r['address']) .'</span>
                    <span><i class="mdi mdi-briefcase-variant-outline"></i> '.$r['time'].'</span>
                    <span><i class="mdi mdi-clock-time-eight-outline"></i> ' . $r['date'] . '</span>
                </div>
            </div>
        </div>
        <div class="n-right"><span>'.$salary.'</span></div>
    </div>
    <div class="new-block-text">
        <span>' . ($r['text'] != '' ? mb_strimwidth(strip_tags($r['text']), 0, 240, "...") : '') . '</span>
    </div>
    <div class="new-block-footer">
        <div class="nf-left">
           '. $dop .'
        </div>
        <div class="nf-right">
            <button class="del-mark" onclick="removeJob('.$data['job'].')" type="button" data-id="'.$data['job'].'"><i class="mdi mdi-trash-can-outline"></i></button>   
        </div>
    </div>
</div>



                                    ';
                                $count++;
                            }
                        }

                    }
                    $list .= "</div>";

                    if ($count <= 0) {
                        $list = '<span class="vac-none">Вакансии не найдены</span>';
                    }
                } else {
                    $list = '<span class="vac-none">Вакансии не найдены</span>';
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
                    'count' => "Найдено $count вакансий",
                );

            }

            echo json_encode(array(
                'code' => 'success',
                'data' => getData(getOptions(), $PDO, $app)
            ));
        }

        if (isset($_POST['MODULE_ADD_EDUCATION']) && $_POST['MODULE_ADD_EDUCATION'] == 1) {
            $err = [];

            $r = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']]);

            if (count($r) > 0) {

                if (empty($_POST['ed-title']) or trim($_POST['ed-title']) == '') $err['ed-title'] = 'Введите заведение';
                if (empty($_POST['ed-prof']) or trim($_POST['ed-prof']) == '') $err['ed-prof'] = 'Введите специальность';
                if (empty($_POST['ed-date']) or $_POST['ed-date'] < 1900) $err['ed-date'] = 'Некорректная дата';

                if (empty($err)) {

                    $title = XSS_DEFENDER($_POST['ed-title']);
                    $text = XSS_DEFENDER($_POST['ed-text']);
                    $dates = XSS_DEFENDER($_POST['ed-date']);
                    $prof = XSS_DEFENDER($_POST['ed-prof']);

                    $hash = md5(md5(random_str(20) . $title . time()));

                    $app->execute("INSERT INTO `education` (`user_id`, `date`, `title`, `text`, `prof`, `hash`)  VALUES(:ui, :d, :title, :t, :pf, :hash)", [
                        ':ui' => $_SESSION['id'],
                        ':d' => $dates,
                        ':title' => $title,
                        ':t' => $text,
                        ':pf' => $prof,
                        ':hash' => $hash
                    ]);

                    $e = $app->fetch("SELECT * FROM `education` WHERE `user_id` = :id AND `hash` = :hash", [
                        ':id' => $_SESSION['id'],
                        ':hash' => $hash
                    ]);

                    $count = $app->rowCount("SELECT * FROM `education` WHERE `user_id` = :id AND `hash` = :hash", [
                        ':id' => $_SESSION['id'],
                        ':hash' => $hash
                    ]);

                    echo json_encode(array(
                        'list' => '<li class="education-'.$e['id'].'">
                                            <div class="de-time">
                                                '.$e['date'].'     
                                                                                       </div>
                                            <div class="de-content">
                                                <span class="dle-t">'.$e['title'].'</span>
                                                <span class="dle-p">'.$e['prof'].' </span>
                                                <div class="dle-text">
                                                    <p>'.$e['text'].'</p>
                                                </div>
                                            </div>
                                            <button type="button" class="del-detatil" onclick="deleteDetail('.$e['id'].')"><i class="mdi mdi-trash-can-outline"></i></button>
                                        </li>',
                        'count' => $count,
                        'code' => 'success',
                    ));
                    exit;
                } else {
                    echo json_encode(array(
                        'error' => $err,
                        'code' => 'validate_error',
                    ));
                    exit;
                }
            } else {
                echo json_encode(array(
                    'code' => 'error',
                ));
                exit;
            }
        }

        if (isset($_POST['MODULE_ADD_EXP']) && $_POST['MODULE_ADD_EXP'] == 1) {
            $err = [];

            $r = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']]);

            if (count($r) > 0) {

                if (empty($_POST['exp-title']) or trim($_POST['exp-title']) == '') $err['exp-title'] = 'Введите организацию';
                if (empty($_POST['exp-prof']) or trim($_POST['exp-prof']) == '') $err['exp-prof'] = 'Введите профессию';

                if (empty($_POST['date-n-1']) || intval($_POST['date-n-1']) <= 0
                    || (intval($_POST['date-n-1']) > intval(date('m')) && intval($_POST['date-n-2']) >= intval(date('Y')))
                    || intval($_POST['date-n-1']) > 12) $err['date-1'] = 'Некорректная дата';
                if (empty($_POST['date-n-2']) || $_POST['date-n-2'] < 1900 || intval($_POST['date-n-2']) > intval(date('Y'))) $err['date-2'] = 'Некорректная дата';

                if ($_POST['no-rb'] != 1) {
                    if (empty($_POST['date-k-1']) || intval($_POST['date-k-1']) <= 0
                        || (intval($_POST['date-k-1']) > intval(date('m')) && intval($_POST['date-k-2']) >= intval(date('Y')))
                        || intval($_POST['date-k-1']) > 12) $err['date-3'] = 'Некорректная дата';
                    if (empty($_POST['date-k-2']) || $_POST['date-k-2'] < 1900 || intval($_POST['date-k-2']) > intval(date('Y'))) $err['date-4'] = 'Некорректная дата';
                }

                if (empty($err)) {

                    $title = XSS_DEFENDER($_POST['exp-title']);
                    $text = XSS_DEFENDER($_POST['exp-text']);
                    $date_n_1 = XSS_DEFENDER($_POST['date-n-1']);
                    $date_n_2 = XSS_DEFENDER($_POST['date-n-2']);
                    $date_k_1 = XSS_DEFENDER($_POST['date-k-1']);
                    $date_k_2 = XSS_DEFENDER($_POST['date-k-2']);
                    $present = intval($_POST['no-rb']);
                    $prof = XSS_DEFENDER($_POST['exp-prof']);

                    if ($present == 1) {
                        $date_k_1 = '';
                        $date_k_2 = '';
                    }

                    if ($present != 0 && $present != 1) {
                        $present = 1;
                    }

                    $hash = md5(md5(random_str(20) . $title . time()));

                    $date = $date_n_1 . '.' .$date_n_2 . ' - ' . $date_k_1 . '.' .$date_k_2;
                    $date1 = $date_n_1 . '.' .$date_n_2;
                    $date2 = $date_k_1 . '.' .$date_k_2;

                    $app->execute("INSERT INTO `exp` (`user_id`, `date`, `title`, `text`, `prof`, `hash`, `present`, `date_1`, `date_2`)  VALUES(:ui, :d, :title, :t, :pf, :hash, :ps, :dt1, :dt2)", [
                        ':ui' => $_SESSION['id'],
                        ':d' => $date,
                        ':title' => $title,
                        ':t' => $text,
                        ':pf' => $prof,
                        ':hash' => $hash,
                        ':ps' => $present,
                        ':dt1' => $date1,
                        ':dt2' => $date2
                    ]);

                    $e = $app->fetch("SELECT * FROM `exp` WHERE `user_id` = :id AND `hash` = :hash", [
                        ':id' => $_SESSION['id'],
                        ':hash' => $hash
                    ]);

                    $count = $app->rowCount("SELECT * FROM `exp` WHERE `user_id` = :id AND `hash` = :hash", [
                        ':id' => $_SESSION['id'],
                        ':hash' => $hash
                    ]);

                    echo json_encode(array(
                        'list' => '<li class="education-'.$e['id'].'">
                                            <div class="de-time">
                                                '.$e['date'].'     
                                                                                       </div>
                                            <div class="de-content">
                                                <span class="dle-t">'.$e['title'].'</span>
                                                <span class="dle-p">'.$e['prof'].' </span>
                                                <div class="dle-text">
                                                    <p>'.$e['text'].'</p>
                                                </div>
                                            </div>
                                            <button type="button" class="del-detatil" onclick="deleteDetail('.$e['id'].')"><i class="mdi mdi-trash-can-outline"></i></button>
                                        </li>',
                        'count' => $count,
                        'code' => 'success',
                    ));
                    exit;
                } else {
                    echo json_encode(array(
                        'error' => $err,
                        'code' => 'validate_error',
                    ));
                    exit;
                }
            } else {
                echo json_encode(array(
                    'code' => 'error',
                ));
                exit;
            }
        }

        if (isset($_POST['MODULE_ADD_ACHIEVEMENT']) && $_POST['MODULE_ADD_ACHIEVEMENT'] == 1) {
            $err = [];

            $captcha = $_SESSION['captcha'];
            unset($_SESSION['captcha']);
            session_write_close();
            $code = $_POST['captcha'];
            $code = crypt(trim($code), '$1$itchief$7');

            if (empty($_POST['type']) or trim($_POST['type']) == '') $err['type'] = 'Выберите тип';
            if (empty($_POST['title']) or trim($_POST['title']) == '') $err['title'] = 'Введите название';

            if (empty($err)) {

                $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']]);

                if (count($user) > 0) {

                    $type = XSS_DEFENDER($_POST['type']);
                    $title = XSS_DEFENDER($_POST['title']);
                    $text = XSS_DEFENDER($_POST['text']);

                    $hash = md5(md5(random_str(20) . $title . time()));

                    $app->fetch("INSERT INTO `achievement` (`name`, `type`, `text`, `user`, `hash`)
                                            VALUES(:n, :typ, :t, :u, :h)", [
                        ':n' => $title,
                        ':typ' => $type,
                        ':t' => $text,
                        ':u' => $user['id'],
                        ':h' => $hash
                    ]);

                    $tmp_path = $_SERVER['DOCUMENT_ROOT'] . '/static/temp/';

                    $path = $_SERVER['DOCUMENT_ROOT'] . '/static/file/users_file/';

                    $r = $app->fetch("SELECT * FROM `achievement` WHERE `hash` = :h", [':h' => $hash]);

                    if (!empty($_POST['images'])) {
                        foreach ($_POST['images'] as $row) {
                            $filename = preg_replace("/[^a-z0-9\.-]/i", '', $row);
                            if (!empty($filename) && is_file($tmp_path . $filename)) {

                                $app->fetch("INSERT INTO `achievement_images` (`token`, `user_id`, `filename`, `hash`) VALUE (:tok, :ui, :fn, :hash)", [
                                    ':tok' => $r['id'],
                                    ':ui' => $user['id'],
                                    ':fn' => $filename,
                                    ':hash' => $hash
                                ]);

                                rename($tmp_path . $filename, $path . $filename);

                                $file_name = pathinfo($filename, PATHINFO_FILENAME);
                                $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
                                $thumb = $file_name . '-thumb.' . $file_ext;
                                rename($tmp_path . $thumb, $path . $thumb);
                            }
                        }
                    }

                    echo json_encode(array(
                        'code' => 'success',
                    ));
                    exit;
                } else {
                    echo json_encode(array(
                        'code' => 'error',
                    ));
                    exit;
                }

            } else {
                echo json_encode(array(
                    'error' => $err,
                    'code' => 'validate_error',
                ));
                exit;
            }
        }

        if (isset($_POST['MODULE_SAVE_PASS']) && $_POST['MODULE_SAVE_PASS'] == 1) {
            $err = [];

            $captcha = $_SESSION['captcha'];
            unset($_SESSION['captcha']);
            session_write_close();
            $code = $_POST['captcha'];
            $code = crypt(trim($code), '$1$itchief$7');

            $r = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']]);

            if (count($r) > 0) {
                if (empty($_POST['password']) or trim($_POST['password']) == '') $err['password'] = 'Введите пароль';
                else if ((md5(md5($_POST['password'] . $r['code'] . $r['name'])) != $_SESSION['password'])
                        && (md5(md5($_POST['password'] . $r['code'] . $r['email'])) != $_SESSION['password'])) $err['password'] = 'Вы ввели неверный пароль';
                if (empty($_POST['new_password']) or trim($_POST['new_password']) == '') $err['new_password'] = 'Введите новый пароль';
                if (empty($_POST['lost_password']) or (trim($_POST['new_password']) != trim($_POST['lost_password']))) $err['lost_password'] = 'Пароли не совпадают';
                if (empty($_POST['captcha']) or trim($_POST['captcha']) == '') $err['captcha'] = 'Пожалуйста введите код';
                else if ($captcha != $code)  $err['captcha'] = 'Введенный код не соответствует изображению!';

                if (empty($err)) {

                    $password = XSS_DEFENDER($_POST['password']);
                    $new_password = XSS_DEFENDER($_POST['new_password']);

                    $pass_code = md5(md5(random_str(10).time()));

                    //$new_pass = md5(md5($new_password . $pass_code . $r['email']));

                    $new_pass = password_hash($new_password . $pass_code, PASSWORD_BCRYPT, [
                        'cost' => 11
                    ]);

                    $app->execute("UPDATE `users` SET `password` = :pas, `code` = :code WHERE `id` = :id", [
                        ':pas' => $new_pass,
                        ':code' => $pass_code,
                        ':id' => $_SESSION['id']
                    ]);

                    $_SESSION['password'] = $new_pass;

                    SENDMAIL($mail, "Изменён пароль", $r['email'], $r['name'] . ' ' . $r['surname'], '
Здравствуйте! Ваш пароль был успешно изменен.

Если это были не вы, пожалуйста, немедленно измените свой пароль с помощью формы восстановления пароля на сайте, чтобы обезопасить свою учетную запись.
            ');

                    echo json_encode(array(
                        'code' => 'success',
                    ));
                    exit;

                } else {
                    echo json_encode(array(
                        'error' => $err,
                        'code' => 'validate_error',
                    ));
                    exit;
                }
            } else {
                echo json_encode(array(
                    'code' => 'error',
                ));
                exit;
            }

        }

        if (isset($_POST['MODULE_CREATE_SUB']) && $_POST['MODULE_CREATE_SUB'] == 1) {
            if (!empty($_POST['id']) && $_POST['id'] > 0) {

                $c = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => intval($_POST['id'])]);

                if (!empty($c['id'])) {

                    $s = $app->fetch("SELECT * FROM `sub` WHERE `company` = :id AND `user` = :ui", [
                        ':id' => $c['id'],
                        ':ui' => $_SESSION['id']
                    ]);

                    if (!isset($s['id'])) {

                        $app->execute("INSERT INTO `sub` (`company`, `user`) VALUES(:id, :ui)", [
                            ':id' => $c['id'],
                            ':ui' => $_SESSION['id']
                        ]);

                        echo json_encode(array(
                            'code' => 'success',
                        ));
                        exit;
                    }
                }

            }
        }

        if (isset($_POST['MODULE_DELETE_SUB']) && $_POST['MODULE_DELETE_SUB'] == 1) {
            if (!empty($_POST['id']) && $_POST['id'] > 0) {

                $c = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => intval($_POST['id'])]);

                if (!empty($c['id'])) {

                    $app->execute("DELETE FROM `sub` WHERE `company` = :id AND `user` = :ui", [
                        ':id' => $c['id'],
                        ':ui' => $_SESSION['id']
                    ]);

                    echo json_encode(array(
                        'code' => 'success',
                    ));
                    exit;
                }

            }
        }

        if (isset($_POST['MODULE_CREATE_RESPOND']) && $_POST['MODULE_CREATE_RESPOND'] == 1) {
            $err = [];

            $captcha = $_SESSION['captcha'];
            unset($_SESSION['captcha']);
            session_write_close();
            $code = $_POST['captcha'];
            $code = crypt(trim($code), '$1$itchief$7');

            if (empty($_POST['captcha']) or trim($_POST['captcha']) == '') $err['captcha'] = 'Введите код';
            else if ($captcha != $code)  $err['captcha'] = 'Введенный код не соответствует изображению!';

            if (empty($err)) {

                if (isset($_POST['id'])) {

                    $count = $app->rowCount("SELECT * FROM `respond` WHERE `job_id` = :id AND `user_id` = :ui", [
                        ':id' => intval($_POST['id']),
                        ':ui' => $_SESSION['id']
                    ]);

                    if ($count > 0) {
                        echo json_encode(array(
                            'code' => 'error',
                        ));
                        exit;
                    } else {
                        $rv = $app->fetch("SELECT * FROM `vacancy` WHERE `id` = :id AND `status` = 0", [':id' => intval($_POST['id'])]);

                        if (!empty($rv['id'])) {

                            $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']]);

                            if (count($user) > 0) {

                                $text = preg_replace("'<script[^>]*?>.*?</script>'si", "", $_POST['letter']);
                                $text = str_replace($xss, "", $text);

                                $app->execute("INSERT INTO `respond` (`date_ru`, `job`, `job_id`, `user_id`, `date`, `company`, `company_id`, `time`, `prof`, `age`, `salary`, `exp`, `gender`, `faculty`, `text`) 
            VALUES(:dater, :j, :ji, :ui, :d, :co, :ci, NOW(), :prof, :age, :salary, :exp, :gender, :faculty, :cnt)", [
                                    ':dater' => $Date_ru,
                                    ':j' => $rv['title'],
                                    ':ji' => $rv['id'],
                                    ':ui' => $_SESSION['id'],
                                    ':d' => $Date,
                                    ':co' => $rv['company'],
                                    ':ci' => $rv['company_id'],
                                    ':prof' => $user['prof'],
                                    ':age' => $user['age'],
                                    ':salary' => $user['salary'],
                                    ':exp' => $user['exp'],
                                    ':gender' => $user['gender'],
                                    ':faculty' => $user['faculty'],
                                    ':cnt' => $text
                                ]);

                                $app->execute("INSERT INTO `respond_user` (`job`, `job_id`, `user_id`, `date`, `company`, `company_id`, `time`, `new`, `text`) 
            VALUES(:j, :ji, :ui, :d, :co, :ci, NOW(), :ne, :cnt)", [
                                    ':j' => $rv['title'],
                                    ':ji' => $rv['id'],
                                    ':ui' => $_SESSION['id'],
                                    ':d' => $Date,
                                    ':co' => $rv['company'],
                                    ':ci' => $rv['company_id'],
                                    ':ne' => 1,
                                    ':cnt' => $text
                                ]);

                                $app->execute("INSERT INTO `notice` (`type`, `title`, `date`, `hour`, `time`, `user_id`, `company_id`, `job_id`, `who`)
                    VALUES(:typ, :title, :dat, :h, NOW(), :ui, :ci, :ji, :wh)", [
                                    ':typ' => 'company_respond',
                                    ':title' => 'У Вас новый отклик!',
                                    ':dat' => $Date,
                                    ':h' => date("H:i"),
                                    ':ui' => $_SESSION['id'],
                                    ':ci' => $rv['company_id'],
                                    ':ji' => $rv['id'],
                                    ':wh' => 1
                                ]);

                                if ($rv['email-d'] == 1) {
                                    SENDMAIL($mail, "Новый отклик", $rv['email'], $rv['company'], '
Здравствуйте, у Вас новый отклик по вакансии "'.$rv['title'].'":
<a target="_blank" href="http://stgaujob.ru/resume/?id='.$user['id'].'">'.$user['name'].' '.$user['surname'].' — '.$user['prof'].'</a>  
<a target="_blank" href="http://stgaujob.ru/responded">Посмотреть отклики</a>  
                    ');
                                }

                                echo json_encode(array(
                                    'code' => 'success',
                                ));
                                exit;
                            } else {
                                echo json_encode(array(
                                    'code' => 'error',
                                ));
                                exit;
                            }


                        } else {
                            echo json_encode(array(
                                'code' => 'error',
                            ));
                            exit;
                        }
                    }
                } else {
                    echo json_encode(array(
                        'code' => 'error',
                    ));
                    exit;
                }
            } else {
                echo json_encode(array(
                    'error' => $err,
                    'code' => 'validate_error',
                ));
                exit;
            }
        }

        if (isset($_POST['MODULE_CREATE_WANNA']) && $_POST['MODULE_CREATE_WANNA'] == 1) {
            $err = [];

            $captcha = $_SESSION['captcha'];
            unset($_SESSION['captcha']);
            session_write_close();
            $code = $_POST['captcha'];
            $code = crypt(trim($code), '$1$itchief$7');

            if (empty($_POST['captcha']) or trim($_POST['captcha']) == '') $err['captcha'] = 'Введите код';
            else if ($captcha != $code)  $err['captcha'] = 'Введенный код не соответствует изображению!';

            if (empty($err)) {

                if (isset($_POST['id'])) {

                    $count = $app->rowCount("SELECT * FROM `respond` WHERE `company_id` = :id AND `user_id` = :ui AND `status` = 7", [
                        ':id' => intval($_POST['id']),
                        ':ui' => $_SESSION['id']
                    ]);

                    if ($count > 0) {
                        echo json_encode(array(
                            'code' => 'error',
                        ));
                        exit;
                    } else {
                        $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']]);

                        if (count($user) > 0) {

                            $c = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => intval($_POST['id'])]);

                            if (count($c) > 0) {

                                $app->execute("INSERT INTO `respond` (`status`, `date_ru`, `user_id`, `date`, `company`, `company_id`, `time`, `prof`, `age`, `salary`, `exp`, `gender`, `faculty`) 
            VALUES(:st, :dater, :ui, :d, :co, :ci, NOW(), :prof, :age, :salary, :exp, :gender, :faculty)", [
                                    ':st' => 7,
                                    ':dater' => $Date_ru,
                                    ':ui' => $_SESSION['id'],
                                    ':d' => $Date,
                                    ':co' => $c['company'],
                                    ':ci' => $c['id'],
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
                                    ':co' => $c['company'],
                                    ':ci' => $c['id'],
                                    ':st' => 7
                                ]);

                                $app->execute("INSERT INTO `notice` (`type`, `title`, `date`, `hour`, `time`, `user_id`, `company_id`, `who`, `reset_status`)
                    VALUES(:typ, :title, :dat, :h, NOW(), :ui, :ci, :wh, :rt)", [
                                    ':typ' => 'wanna',
                                    ':title' => 'У вас хотят работать',
                                    ':dat' => $Date,
                                    ':h' => date("H:i"),
                                    ':ui' => $_SESSION['id'],
                                    ':ci' => $c['id'],
                                    ':wh' => 1,
                                    ':rt' => 7
                                ]);

                                echo json_encode(array(
                                    'code' => 'success',
                                ));
                                exit;
                            }
                        } else {
                            echo json_encode(array(
                                'code' => 'error',
                            ));
                            exit;
                        }
                    }
                } else {
                    echo json_encode(array(
                        'code' => 'error',
                    ));
                    exit;
                }
            } else {
                echo json_encode(array(
                    'error' => $err,
                    'code' => 'validate_error',
                ));
                exit;
            }
        }

        if (isset($_POST['MODULE_ADD_LANG']) && $_POST['MODULE_ADD_LANG'] == 1) {

            if ((trim($_POST['lang']) != '' && isset($_POST['lang'])) && (trim($_POST['lvl']) != '' && isset($_POST['lvl']))) {

                $hash = random_str(20);

                $app->execute("INSERT INTO `lang` (`name`, `lvl`, `user`, `hash`, `time`) VALUES(:nm, :lvl, :ui, :hash, NOW())",
                    [
                        ':nm' => XSS_DEFENDER($_POST['lang']),
                        ':lvl' => XSS_DEFENDER($_POST['lvl']),
                        ':ui' => $_SESSION['id'],
                        ':hash' => $hash
                    ]);

                $sk = $app->fetch("SELECT * FROM `lang` WHERE `hash` = :hash", [':hash' => $hash]);

                $html = '
                <li class="lang-'.$sk['id'].'">
                    <span>'.XSS_DEFENDER($_POST['lang']).' - '.XSS_DEFENDER($_POST['lvl']).'</span>
                    <button type="submit" name="lang-del-'.$sk['id'].'"><i class="mdi mdi-delete"></i></button>
                </li>
                ';

                echo json_encode(array(
                    'html' => $html,
                    'code' => 'success',));

            }

        }

        if (isset($_POST['MODULE_ADD_SKILL']) && $_POST['MODULE_ADD_SKILL'] == 1) {

            if (trim($_POST['text']) != '' && isset($_POST['text'])) {

                $hash = random_str(20);

                $app->execute("INSERT INTO `skills_resume` (`text`, `user_id`, `hash`, `time`) VALUES(:cnt, :ui, :hash, NOW())",
                    [
                        ':cnt' => XSS_DEFENDER($_POST['text']),
                        ':ui' => $_SESSION['id'],
                        ':hash' => $hash
                    ]);

                $sk = $app->fetch("SELECT * FROM `skills_resume` WHERE `hash` = :hash", [':hash' => $hash]);

                $html = '
                <li class="skill-'.$sk['id'].' wow fadeIn">
                    <span>'.XSS_DEFENDER($_POST['text']).'</span>
                    <button type="submit" name="skill-del-'.$sk['id'].'"><i class="mdi mdi-delete"></i></button>
                </li>
                ';

                echo json_encode(array(
                    'html' => $html,
                    'code' => 'success',));

            }

        }

        if (isset($_POST['MODULE_DELETE_EDUCATION']) && $_POST['MODULE_DELETE_EDUCATION'] == 1) {

            if (isset($_POST['id']) && $_POST['id'] > 0) {

                $app->execute("DELETE FROM `education` WHERE `id` = :id AND `user_id` = :ui", [
                    ':id' => XSS_DEFENDER($_POST['id']),
                    ':ui' => $_SESSION['id']
                ]);

                echo json_encode(array(
                    'code' => 'success',
                ));
                exit;
            }

        }

        if (isset($_POST['MODULE_DELETE_EXP']) && $_POST['MODULE_DELETE_EXP'] == 1) {

            if (isset($_POST['id']) && $_POST['id'] > 0) {

                $app->execute("DELETE FROM `exp` WHERE `id` = :id AND `user_id` = :ui", [
                    ':id' => XSS_DEFENDER($_POST['id']),
                    ':ui' => $_SESSION['id']
                ]);

                echo json_encode(array(
                    'code' => 'success',
                ));
            }

        }

        if (isset($_POST['MODULE_DELETE_ACHIEVEMENT']) && $_POST['MODULE_DELETE_ACHIEVEMENT'] == 1) {

            if (isset($_POST['id']) && $_POST['id'] > 0) {

                $app->execute("DELETE FROM `achievement` WHERE `id` = :id AND `user` = :ui", [
                    ':id' => XSS_DEFENDER($_POST['id']),
                    ':ui' => $_SESSION['id']
                ]);

                $app->fetch("DELETE FROM `achievement_images` WHERE `id` = :id AND `user_id` = :ui", [
                    ':id' => XSS_DEFENDER($_POST['id']),
                    ':ui' => $_SESSION['id']
                ]);

                echo json_encode(array(
                    'code' => 'success',
                ));
                exit;
            }

        }

        if (isset($_POST['MODULE_DELETE_LANG']) && $_POST['MODULE_DELETE_LANG'] == 1) {

            if (isset($_POST['id']) && $_POST['id'] > 0) {

                $app->execute("DELETE FROM `lang` WHERE `id` = :id AND `user` = :ui", [
                    ':id' => XSS_DEFENDER($_POST['id']),
                    ':ui' => $_SESSION['id']
                ]);

                echo json_encode(array(
                    'code' => 'success',
                ));
            }

        }

        if (isset($_POST['MODULE_DELETE_SKILLS']) && $_POST['MODULE_DELETE_SKILLS'] == 1) {

            if (isset($_POST['id']) && $_POST['id'] > 0) {

                $app->execute("DELETE FROM `skills_resume` WHERE `id` = :id AND `user_id` = :ui", [
                    ':id' => XSS_DEFENDER($_POST['id']),
                    ':ui' => $_SESSION['id']
                ]);

                echo json_encode(array(
                    'code' => 'success',
                ));
            }

        }

        if (isset($_POST['MODULE_DELETE_REVIEW']) && $_POST['MODULE_DELETE_REVIEW'] == 1) {

            if (isset($_POST['id']) && $_POST['id'] > 0) {

                $app->execute("DELETE FROM `review` WHERE `id` = :id AND `user_id` = :ui", [
                    ':id' => XSS_DEFENDER($_POST['id']),
                    ':ui' => $_SESSION['id']
                ]);

                echo json_encode(array(
                    'code' => 'success',
                ));
            }

        }

        if (isset($_POST['MODULE_CHAT_LOCK']) && $_POST['MODULE_CHAT_LOCK'] == 1) {

            if (isset($_POST['id']) && $_POST['id'] > 0) {

                $app->execute("UPDATE `chat` SET `lock_user` = 1 WHERE `id` = :id", [
                    ':id' => XSS_DEFENDER($_POST['id'])
                ]);

                echo json_encode(array(
                    'code' => 'success',
                ));
            }

        }

        if (isset($_POST['MODULE_CHAT_UNLOCK']) && $_POST['MODULE_CHAT_UNLOCK'] == 1) {

            if (isset($_POST['id']) && $_POST['id'] > 0) {
                $stmt = $PDO->prepare("SELECT * FROM `chat` WHERE `id` = ?");
                $stmt->execute([XSS_DEFENDER($_POST['id'])]);

                if ($stmt->rowCount() > 0) {
                    $app->execute("UPDATE `chat` SET `lock_user` = 0 WHERE `id` = :id", [
                        ':id' => XSS_DEFENDER($_POST['id'])
                    ]);

                    echo json_encode(array(
                        'code' => 'success',
                    ));
                }

            }

        }

        if (isset($_POST['MODULE_SAVE_EDUCATION']) && $_POST['MODULE_SAVE_EDUCATION'] == 1) {
            $err = [];

            if (empty($_POST['faculty']) || trim($_POST['faculty']) == '') $err['faculty'] = 'Это поле не должно быть пустым';
            if (empty($_POST['financing']) || trim($_POST['financing']) == '') $err['financing'] = 'Это поле не должно быть пустым';
            if (empty($_POST['form_education']) || trim($_POST['form_education']) == '') $err['form_education'] = 'Это поле не должно быть пустым';
            if (empty($_POST['direction']) || trim($_POST['direction']) == '') $err['direction'] = 'Это поле не должно быть пустым';
            if (empty($_POST['degree']) || trim($_POST['degree']) == '') $err['degree'] = 'Это поле не должно быть пустым';
            if (empty($_POST['course']) || trim($_POST['course']) == '') $err['course'] = 'Это поле не должно быть пустым';
            if (empty($_POST['snils']) || trim($_POST['snils']) == '') $err['snils'] = 'Это поле не должно быть пустым';
            else if (strlen($_POST['snils']) < 11) $err['snils'] = 'Данные указаны неверно';

            if (empty($err)) {

                $faculty = XSS_DEFENDER($_POST['faculty']);
                $direction = XSS_DEFENDER($_POST['direction']);
                $degree = XSS_DEFENDER($_POST['degree']);
                $form_education = XSS_DEFENDER($_POST['form_education']);
                $financing = XSS_DEFENDER($_POST['financing']);
                $snils = $_POST['snils'];
                $inn = XSS_DEFENDER($_POST['inn']);
                $course = XSS_DEFENDER($_POST['course']);

                $app->execute("UPDATE `users` SET
                   `faculty` = :fac,
                   `direction` = :dir,
                   `degree` = :deg,
                   `form_education` = :fe,
                   `financing` = :fin,
                   `snils` = :snils,
                   `inn` = :inn,
                   `course` = :cor
                WHERE `id` = :id", [
                    ':fac' => $faculty,
                    ':dir' => $direction,
                    ':deg' => $degree,
                    ':fe' => $form_education,
                    ':fin' => $financing,
                    ':snils' => $snils,
                    ':inn' => $inn,
                    ':cor' => $course,
                    ':id' => intval($_SESSION['id'])
                ]);

                echo json_encode(array(
                    'code' => 'success',
                ));
                exit;
            } else {
                echo json_encode(array(
                    'error' => $err,
                    'code' => 'validate_error',
                ));
                exit;
            }
        }

        if (isset($_POST['MODULE_SAVE']) && $_POST['MODULE_SAVE'] == 1) {

            $err = [];


            if (empty($_POST['prof']) || trim($_POST['prof']) == '') $err['prof'] = 'Это поле не должно быть пустым';
            if (empty($_POST['name']) || trim($_POST['name']) == '') $err['name'] = 'Это поле не должно быть пустым';
            if (empty($_POST['surname']) || trim($_POST['surname']) == '') $err['surname'] = 'Это поле не должно быть пустым';
            if (empty($_POST['patronymic']) || trim($_POST['patronymic']) == '') $err['patronymic'] = 'Это поле не должно быть пустым';
            if (empty($_POST['date-1']) || intval($_POST['date-1']) <= 0 || intval($_POST['date-1']) > 31) $err['date-1'] = 'Некорректная дата';
            if (empty($_POST['date-2']) || intval($_POST['date-2']) <= 0 || intval($_POST['date-2']) > 12) $err['date-2'] = 'Некорректная дата';
            if (empty($_POST['date-3']) || $_POST['date-3'] < 1900 || intval($_POST['date-3']) > intval(date('Y'))) $err['date-3'] = 'Некорректная дата';
            if (empty($_POST['gender']) || trim($_POST['gender']) == '') $err['gender'] = 'Это поле не должно быть пустым';
            if (empty($_POST['nationality']) || trim($_POST['nationality']) == '') $err['nationality'] = 'Это поле не должно быть пустым';

            if (empty($err)) {

                $name = XSS_DEFENDER($_POST['name']);
                $surname = XSS_DEFENDER($_POST['surname']);
                $patronymic = XSS_DEFENDER($_POST['patronymic']);
                $nationality = XSS_DEFENDER($_POST['nationality']);
                $phone = XSS_DEFENDER($_POST['phone']);
                $phone = phone_format($phone);
                $about = preg_replace ( "'<script[^>]*?>.*?</script>'si", "", $_POST['about']);
                $about = str_replace($xss,"",$about);
                $age = $_POST['date-1'] . '.' . $_POST['date-2'] . '.' . $_POST['date-3'];
                $gender = XSS_DEFENDER($_POST['gender']);
                $exp = XSS_DEFENDER($_POST['exp']);
                $time = $_POST['time'];
                $category = XSS_DEFENDER($_POST['category']);
                $prof = XSS_DEFENDER($_POST['prof']);
                $salary = XSS_DEFENDER($_POST['salary']);
                $drive = XSS_DEFENDER($_POST['drive']);
                $type = $_POST['type'];
                $stat = XSS_DEFENDER($_POST['stat']);
                $car = XSS_DEFENDER($_POST['car']);
                $go = XSS_DEFENDER($_POST['go']);
                $inv = XSS_DEFENDER($_POST['inv']);
                $vk = XSS_DEFENDER($_POST['vk']);
                $telegram = XSS_DEFENDER($_POST['telegram']);
                $github = XSS_DEFENDER($_POST['github']);
                $skype = XSS_DEFENDER($_POST['skype']);
                if ($car == 1) $car = 1;
                else $car = 0;
                if ($go == 1) $go = 1;
                else $go = 0;
                if ($inv == 1) $inv = 1;
                else $inv = 0;

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

                if ($time != null) {
                    foreach ($time as $val => $item) {
                        if ($item == 1) $time[$val] = 'Полный рабочий день';
                        if ($item == 2) $time[$val] = 'Сменный график';
                        if ($item == 3) $time[$val] = 'Гибкий график';
                        if ($item == 4) $time[$val] = 'Вахтовый метод';
                        if ($item == 5) $time[$val] = 'Ненормированный рабочий день';
                    }
                    $time = implode(', ', $time);
                }

                $ch = $app->rowCount("SELECT * FROM `chat` WHERE `user_id` = :id", [':id' => $_SESSION['id']]);

                if ($ch > 0) {
                    $app->execute("UPDATE `chat` SET `user` = :nm WHERE `user_id` = :id", [
                        ':nm' => $name . ' ' . $surname,
                        ':id' => $_SESSION['id']
                    ]);
                }

                $app->execute("UPDATE `users` SET 
                `about` = :about,
                `stat` = :stat,
                `type` = :typ,
                `name` = :nam,
                `surname` = :surname,
                `patronymic` = :patronymic,
                `phone` = :phone,
                `age` = :age,
                `gender` = :gender,
                `exp` = :exp,
                `time` = :ti,
                `category` = :category,
                `prof` = :prof,
                `salary` = :salary,
                `car` = :car,
                `drive` = :drive,
                `go` = :g,
                `inv` = :inv,
                `last_save` = :lastsave,
                `vk` = :vk, 
                `telegram` = :telegram,
                `github` = :github, 
                `skype` = :skype,
                `nationality` = :nat WHERE `id` = :id", [
                    ':about' => $about,
                    ':stat' => $stat,
                    ':typ' => $type,
                    ':nam' => $name,
                    ':surname' => $surname,
                    ':patronymic' => $patronymic,
                    ':phone' => $phone,
                    ':age' => $age,
                    ':gender' => $gender,
                    ':exp' => $exp,
                    ':ti' => $time,
                    ':category' => $category,
                    ':prof' => $prof,
                    ':salary' => $salary,
                    ':car' => $car,
                    ':drive' => $drive,
                    ':g' => $go,
                    ':inv' => $inv,
                    ':lastsave' => $Date_ru . ' ' . date('H:i'),
                    ':vk' => $vk,
                    ':telegram' => $telegram,
                    ':github' => $github,
                    ':skype' => $skype,
                    ':nat' => $nationality,
                    ':id' => $_SESSION['id']
                ]);

                echo json_encode(array(
                    'code' => 'success',
                ));
                exit;

            } else {
                echo json_encode(array(
                    'error' => $err,
                    'code' => 'validate_error',
                ));
                exit;
            }

        }

        if (isset($_POST['MODULE_EDIT_MAIL']) && $_POST['MODULE_EDIT_MAIL'] == 1) {
            if (empty($_POST['mail']) || trim($_POST['mail']) == '') {
                echo json_encode(array(
                    'code' => 'validate_error',
                ));
                exit;
            } else {
                $email = XSS_DEFENDER($_POST['mail']);

                $code = md5(random_str(25) . $_SESSION['surname'] . time());

                $pass = generate_password(16);

                if (SENDMAIL($mail, "Изменить email", $email, $_SESSION['name'] . ' ' . $_SESSION['surname'], '
Здравствуйте! Для смены email почты пройдите по нижеследующей ссылке (действует 6 часов).

Ваш новый email: '.$email.'
Ваш НОВЫЙ пароль: <b>'.$pass.'</b>
(действует после подтверждения)
<a class="go-bth" href="http://stgaujob.ru/email-confirm-user/?code='.$code.'&email='.$email.'">
Сменить</a>

Примечание: чтобы почта сменилась Вы должны быть авторизированным на сайте.
            ')) {

                    $app->execute("INSERT INTO `temp_email_u` (`token`, `code`, `time`, `vac_token`, `email`) 
                                    VALUES(:token, :code, NOW(), :vt, :email)", [
                        ':token' => $_SESSION['id'],
                        ':code' => $code,
                        ':vt' => $pass,
                        ':email' => $email
                    ]);

                    echo json_encode(array(
                        'code' => 'success',
                    ));

                    exit;
                } else {
                    echo json_encode(array(
                        'code' => 'error',
                    ));
                    exit;
                }
            }
        }

    } catch (Exception $e) {
        echo json_encode(array(
            'code' => 'error',
            'message' => $e->getMessage()
        ));
    }

} else if (isset($_SESSION['id']) && $_SESSION['type'] == 'company') {

    $count_acc = $app->rowCount("SELECT * FROM `company` WHERE `id` = :id", [':id' => $_SESSION['id']]);

    if ($count_acc <= 0) {
        $app->notFound();
        exit;
    }

    try {

        if (isset($_POST['MODULE_GET_ARCHIVE_JOB_LIST']) && $_POST['MODULE_GET_ARCHIVE_JOB_LIST'] == 1) {

            function getOptions() {
                $key = (isset($_POST['key'])) ? $_POST['key'] : null;
                $page = (isset($_POST['page'])) ? (int)$_POST['page'] : 1;
                $col = (isset($_POST['col'])) ? (int)$_POST['col'] : 1;
                $type = (isset($_POST['type'])) ? (int)$_POST['type'] : 1;
                $limit = (isset($_POST['limit'])) ? (int)$_POST['limit'] : 20;

                return array(
                    'key' => $key,
                    'col' => $col,
                    'type' => $type,
                    'page' => $page,
                    'limit' => $limit
                );
            }

            function getData($options, $PDO, $app, $paginator) {
                $options = getOptions();

                $key = $options['key'];
                $col = $options['col'];
                $type = $options['type'];
                $page = (int) $options['page'];
                if ($page == 0) $page++;
                $limit = (int) $options['limit'];
                $start = ($page - 1) * $limit;

                if ($type == 2) $type = "ASC";
                else $type = "DESC";

                if ($col == 2) $col = "`title`";
                else if ($col == 3) $col = "`company`";
                else if ($col == 4) $col = "`views`";
                else if ($col == 5) $col = "`address`";
                else $col = "`id`";

                $where = "";

                if ($key != null) $where = addWhere($where, "
                    `title` LIKE '%$key%' OR 
                    `company` LIKE '%$key%' OR 
                    `address` LIKE '%$key%' OR 
                    `id` LIKE '%$key%' OR 
                    `category` LIKE '%$key%' OR 
                    `email` LIKE '%$key%' OR
                    `region` LIKE '%$key%' OR
                    `district` LIKE '%$key%' OR
                    `area` LIKE '%$key%' OR
                    `type` LIKE '%$key%'
                ");
                $where = addWhere($where, "`company_id` = $_SESSION[id]");
                $where = addWhere($where, "`status` = 1");
                $sql = "SELECT * FROM `vacancy`";
                $sql2 = "SELECT * FROM `vacancy`";
                if ($where) {
                    $sql .= " WHERE $where";
                    $sql2 .= " WHERE $where";
                }

                $sql .= " ORDER BY $col $type LIMIT $start, $limit";
                $sql2 .= " ORDER BY $col $type";

                $stmt2 = $PDO->prepare($sql2);
                $stmt2->execute();
                $countAll = $stmt2->rowCount();

                $stmt = $PDO->prepare($sql);
                $stmt->execute();
                $count = $stmt->rowCount();

                $pagination = $paginator->table_ajax($page, $countAll, $limit);

                $countPages = ceil($countAll / $limit);

                $html = "";

                if ($count > 0) {

                    while($r = $stmt->fetch()) {

                        $html .= '
                        <div class="table-tr">
                            <div class="table-td-exp"><span>'.$r['id'].'</span></div>
                            <div><a class="table-td-a" target="_blank" href="/admin/info-jobs/?id='.$r['id'].'">'.mb_strimwidth($r['title'], 0, 35, "...").'</a></div>
                            <div class="table-td-exp"><span>'.$r['views'].'</span></div>
                            <div class="table-td-exp"><span>'.$app->rowCount("SELECT * FROM `respond` WHERE `job_id` = :id", [':id' => $r['id']]).'</span></div>
                            <div class="table-td-exp"><span> '.$r['trash'].'</span></div>
                            <div class="table-td-exp"><span>'.$r['date'].'</span></div>
                            <div class="table-td-title"> <form action="" method="post">
                                                 <div class="block-manage">
                     
                  
                                          <a title="Статистика" target="_blank" class="manage-bth-mini" target="_blank" href="/admin/info-jobs?id='.$r['id'].'"><i class="icon-pie-chart"></i></a>

                                          <button title="Закрыть" name="" class="manage-bth-mini" type="button"><i class="icon-trash"></i></button>

                                    
                                    </div>
                                    
                                    
                                    </form></div>
                        </div>
                        ';

                    }

                } else {
                    $html .= '<span>Вакансии не найдены</span>';
                }

                return array (
                    'list' => $html,
                    'count' => $count,
                    'countAll' => $countAll,
                    'countPages' =>  $countPages,
                    'page' => $page,
                    'date' => date("d.m.Y H:i:s"),
                    'limit' => $limit,
                    'pagination' => $pagination,
                    'options' => $options
                );
            }

            echo json_encode(array(
                'code' => 'success',
                'data' => getData(getOptions(), $PDO, $app, $paginator)
            ));

        }

        if (isset($_POST['MODULE_SETTING_MAIL']) && $_POST['MODULE_SETTING_MAIL'] == 1) {
            echo json_encode(array('code' => 'success'));
            exit;
        }

        if (isset($_POST['MODULE_SAVE_LOGO']) && $_POST['MODULE_SAVE_LOGO'] == 1) {

            if (trim($_POST['img']) == '') {
                echo json_encode(array(
                    'code' => 'error',
                ));
                exit;
            } else {
                $filename = preg_replace("/[^a-z0-9\.-]/i", '', $_POST['img']);

                $tmp_path = $_SERVER['DOCUMENT_ROOT'] . '/static/temp/';
                $path = $_SERVER['DOCUMENT_ROOT'] . '/static/image/company/';

                $app->execute("UPDATE `company` SET `img` = :img WHERE `id` = :id", [
                    ':img' => $filename,
                    ':id' => $_SESSION['id']
                ]);

                $app->execute("UPDATE `vacancy` SET `img` = :img WHERE `company_id` = :id", [
                    ':img' => $filename,
                    ':id' => $_SESSION['id']
                ]);

                if ($app->execute("UPDATE `chat` SET `com_img` = :img WHERE `company_id` = :id", [
                    ':img' => $filename,
                    ':id' => $_SESSION['id']
                ])) {

                }



                rename($tmp_path . $filename, $path . $filename);

                $file_name = pathinfo($filename, PATHINFO_FILENAME);
                $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
                $thumb = $file_name . '-thumb.' . $file_ext;
                rename($tmp_path . $thumb, $path . $thumb);

                echo json_encode(array('code' => 'success'));
                exit;
            }

        }

        if (isset($_POST['MODULE_CREATE_2FA']) && $_POST['MODULE_CREATE_2FA'] == 1) {

            $r = $app->fetch("SELECT * FROM `company` WHERE `id` = :id AND `2fa` = 0", [':id' => $_SESSION['id']]);

            if (count($r) > 0) {
                $err = [];

                $password = $_POST['password'];

                if (empty($password) or trim($password) == '') $err['password'] = 'Введите пароль';
                else if ((md5(md5($_POST['password'] . $r['code'] . $r['name'])) != $_SESSION['password'])
                    && (md5(md5($_POST['password'] . $r['code'] . $r['email'])) != $_SESSION['password'])) $err['password'] = 'Вы ввели неверный пароль';

                if (empty($err)) {

                    $app->execute("UPDATE `company` SET `2fa` = 1 WHERE `id` = :id", [':id' => $r['id']]);

                    echo json_encode(array('code' => 'success'));
                    exit;
                } else {
                    echo json_encode(array(
                        'error' => $err,
                        'code' => 'validate_error',
                    ));
                    exit;
                }
            }

        }

        if (isset($_POST['MODULE_DELETE_2FA']) && $_POST['MODULE_DELETE_2FA'] == 1) {

            $r = $app->fetch("SELECT * FROM `company` WHERE `id` = :id AND `2fa` = 1", [':id' => $_SESSION['id']]);

            if (count($r) > 0) {
                $err = [];

                $password = $_POST['password'];

                if (empty($password) or trim($password) == '') $err['password'] = 'Введите пароль';
                else if (md5(md5($_POST['password'] . $r['code'] . $r['email'])) != $_SESSION['password']) $err['password'] = 'Вы ввели неверный пароль';

                if (empty($err)) {

                    $app->execute("UPDATE `company` SET `2fa` = 0 WHERE `id` = :id", [':id' => $r['id']]);

                    echo json_encode(array('code' => 'success'));
                    exit;
                } else {
                    echo json_encode(array(
                        'error' => $err,
                        'code' => 'validate_error',
                    ));
                    exit;
                }
            }

        }

        if (isset($_POST['MODULE_SAVE']) && $_POST['MODULE_SAVE'] == 1) {

            $err = [];


            if (empty($_POST['tel']) || trim($_POST['tel']) == '') $err['tel'] = 'Это поле не должно быть пустым';
            if (empty($_POST['inn']) || trim($_POST['inn']) == '') $err['inn'] = 'Это поле не должно быть пустым';
            if (empty($_POST['type']) || trim($_POST['type']) == '') $err['type'] = 'Это поле не должно быть пустым';
            if (empty($_POST['address']) || trim($_POST['address']) == '') $err['address'] = 'Это поле не должно быть пустым';

            if (empty($err)) {

                $username = XSS_DEFENDER($_POST['username']);
                $inn = XSS_DEFENDER($_POST['inn']);
                $about = preg_replace ( "'<script[^>]*?>.*?</script>'si", "", $_POST['about']);
                $about = str_replace($xss,"",$about);
                $phone = XSS_DEFENDER($_POST['tel']);
                $phone = phone_format($phone);
                $addres = XSS_DEFENDER($_POST['address']);
                $people = XSS_DEFENDER($_POST['people']);
                $specialty = XSS_DEFENDER($_POST['specialty']);
                $website = XSS_DEFENDER($_POST['website']);
                $middle = XSS_DEFENDER($_POST['middle']);
                $type = XSS_DEFENDER($_POST['type']);

                $app->execute("UPDATE `company` SET 
                `inn` = :inn,
                `username` = :usern,
                `about` = :about, 
                `phone` = :phone,
                `address` = :addres, 
                `people` = :people,
                `specialty` = :specialty,
                `website` = :website,
                `middle` = :mid,
                 `type` = :tp WHERE `id` = :id", [
                    ':inn' => $inn,
                    ':usern' => $username,
                    ':about' => $about,
                    ':phone' => $phone,
                    ':addres' => $addres,
                    ':people' => $people,
                    ':specialty' => $specialty,
                    ':website' => $website,
                    ':mid' => $middle,
                    ':tp' => $type,
                    ':id' => $_SESSION['id']
                ]);

                echo json_encode(array(
                    'code' => 'success',
                ));

            } else {
                echo json_encode(array(
                    'error' => $err,
                    'code' => 'validate_error',
                ));
            }

        }

        if (isset($_POST['MODULE_CHAT_LOCK']) && $_POST['MODULE_CHAT_LOCK'] == 1) {

            if (isset($_POST['id']) && $_POST['id'] > 0) {

                $app->execute("UPDATE `chat` SET `lock_company` = 1 WHERE `id` = :id", [
                    ':id' => XSS_DEFENDER($_POST['id'])
                ]);

                echo json_encode(array(
                    'code' => 'success',
                ));
            }

        }

        if (isset($_POST['MODULE_CHAT_UNLOCK']) && $_POST['MODULE_CHAT_UNLOCK'] == 1) {

            if (isset($_POST['id']) && $_POST['id'] > 0) {

                $stmt = $PDO->prepare("SELECT * FROM `chat` WHERE `id` = ?");
                $stmt->execute([XSS_DEFENDER($_POST['id'])]);

                if ($stmt->rowCount() > 0) {
                    $app->execute("UPDATE `chat` SET `lock_company` = 0 WHERE `id` = :id", [
                        ':id' => XSS_DEFENDER($_POST['id'])
                    ]);

                    echo json_encode(array(
                        'code' => 'success',
                    ));
                }

            }

        }

        if (isset($_POST['MODULE_MANAGE_JOB']) && $_POST['MODULE_MANAGE_JOB'] == 1) {
            $exp = (isset($_POST['exp'])) ? $_POST['exp'] : null;
            $time = (isset($_POST['time'])) ? $_POST['time'] : null;
            $type = (isset($_POST['type'])) ? $_POST['type'] : null;
            $key = (isset($_POST['key'])) ? $_POST['key'] : null;
            $loc = (isset($_POST['loc'])) ? $_POST['loc'] : null;
            $sort = (isset($_POST['sort'])) ?  (int) $_POST['sort'] : null;
            $page = (isset($_POST['page'])) ? (int)$_POST['page'] : 1;
            $limit = (isset($_POST['limit'])) ? (int)$_POST['limit'] : 10;
            if ($page == 0) $page++;
            $limit = intval($limit);
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

            $where = "";
            if ($key != null) $where = addWhere($where, "`title` LIKE '%$key%'");
            if ($loc != null) $where = addWhere($where, "`address` LIKE '%$loc%'");
            if ($exp != null) $where = addWhere($where, "`exp` LIKE '%$exp%'");
            if ($time != null) $where = addWhere($where, "`time` IN ($time)");
            if ($type != null) $where = addWhere($where, "`type` IN ($type)");
            $where = addWhere($where, "`company_id` = $_SESSION[id]");
            $sql = "SELECT * FROM `vacancy`";
            $sql2 = "SELECT * FROM `vacancy`";
            if ($where) {
                $sql .= " WHERE $where";
                $sql2 .= " WHERE $where";
            }

            if ($sort != null) {
                if ($sort == 1) {
                    if ($sql == "SELECT * FROM `vacancy`") {
                        $sql .= " WHERE `status` = 0 ORDER BY `id` DESC LIMIT $start, $limit";
                        $sql2 .= " WHERE `status` = 0 ORDER BY `id` DESC";
                    } else {
                        $sql .= " AND `status` = 0 ORDER BY `id` DESC LIMIT $start, $limit";
                        $sql2 .= " AND `status` = 0 ORDER BY `id` DESC";
                    }
                }
                if ($sort == 2) {
                    if ($sql == "SELECT * FROM `vacancy`") {
                        $sql .= " WHERE `status` = 0 ORDER BY `views` DESC LIMIT $start, $limit";
                        $sql2 .= " WHERE `status` = 0 ORDER BY `views` DESC";
                    } else {
                        $sql .= " AND `status` = 0 ORDER BY `views` DESC LIMIT $start, $limit";
                        $sql2 .= " AND `status` = 0 ORDER BY `views` DESC";
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


            $sql_2 = $app->query($sql);
            while ($r = $sql_2->fetch()) {
                $people[] = $app->count("SELECT * FROM `online_job` WHERE `job` = $r[id]");
            }



            $stmt2 = $PDO->prepare($sql2);
            $stmt2->execute();
            $countAll = $stmt2->rowCount();

            $stmt = $PDO->prepare($sql);
            $stmt->execute();
            $count = $stmt->rowCount();

            $countPages = ceil($countAll / $limit);
            $mid_size = 2;

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
                    $earlier = new DateTime($Date);
                    $later = new DateTime($r['task']);
                    $list .= '
                 <li class="">
                   
                     <div class="vac-name">
                     
                     <button onclick="deleteVac('.$r['id'].', '."'$r[title]'".')" type="button" class="lock-vacancy"><i class="mdi mdi-delete"></i></button>
                     
                    
                       <div class="vac-stat-list">
                      ' . ($people[$i] > 0 ? '<span class="resume-stat">Сейчас просматривают ' . $people[$i] . '</span>' : '') . '
                  </div>
                  
                        <a target="_blank" href="/job/?id=' . $r['id'] . '">' . $r['title'] . '</a>
                        <span>' . $salary . ' <i class="mdi mdi-currency-rub"></i></span>
                         <ul class="re-ul">
                            <li>
                                <span>Место работы</span>
                                <span>' . $r['address'] . '</span>
                            </li>
                            '. (trim($r['contact']) != '' ? '<li>
                                <span>Контактное лицо</span>
                                <span>' . $r['contact'] . '</span>
                            </li>' : '') .'
                            
                            <li>
                                <span>Период</span>
                                <span>' . $r['date'] . ' — '. DateTime::createFromFormat('Y-m-d', $r['task'])->format('d.m.Y') .'</span>
                            </li>
                            <li>
                                <span>Опыт работы</span>
                                <span>' . $r['exp'] . '</span>
                            </li>
                            <li>
                                <span>График работы</span>
                                <span>' . $r['time'] . '</span>
                            </li>
                            <li>
                                <span>Тип занятости</span>
                                <span>' . $r['type'] . '</span>
                            </li>
                            <li>
                                <span>Образование</span>
                                <span>' . $r['degree'] . '</span>
                            </li>
                        </ul> 
                        <div class="manag-addi">
                        
                            ' . ($r['invalid'] == 1 ? '<span><i class="mdi mdi-wheelchair"></i> Доступна людям с инвалидностью</span>' : '') . '
                            ' . ($r['go'] == 1 ? '<span><i class="mdi mdi-plane-car"></i> Поможем с переездом</span>' : '') . '
                             
                        </div>
                     </div>
                     <div class="vac-analis">
                        <div class="va-top">
                            <span>Просмотров <m>' . $r['views'] . '</m></span>
                            <span>Откликов <m>' . $app->rowCount("SELECT * FROM `respond` WHERE `job_id` = :id", [':id' => $r['id']]) . '</m></span>
                            <span>Осталось <m>' . $later->diff($earlier)->format("%a") . ' дней</m></span>
                            ' . (isset($r['last_up']) ? "<span>Обновлено <m>$r[last_up]</m></span>" : '') . '
                        </div>
                        <div class="va-bot">
                            <a target="_blank" href="/analysis-job/?id='.$r['id'].'"><i class="mdi mdi-finance"></i> Статистика</a>
                            <a target="_blank" href="/edit-job/?id='.$r['id'].'&act='.$r['company_id'].'"><i class="mdi mdi-pencil"></i> Изменить</a>
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
                $list .= '<span class="no-file">
<svg width="224" viewBox="0 0 306 262" fill="none" xmlns="http://www.w3.org/2000/svg" class="e-notification__sign"><path d="M156.615 210.474c47.95 0 86.921-38.971 86.921-86.921 0-47.95-38.971-86.921-86.921-86.921-48.129 0-86.92 38.791-86.92 86.921 0 47.95 38.791 86.921 86.92 86.921Z" fill="#EDEDED"></path><path d="M101.923 99.791h105.07c3.936 0 7.477 3.345 7.477 7.477v66.308c0 3.935-3.345 7.477-7.477 7.477h-105.07c-3.935 0-7.477-3.345-7.477-7.477v-66.308c0-4.132 3.542-7.477 7.477-7.477Z" fill="url(#a)"></path><path d="M257.724 101.822c2.694-2.514 2.873-6.645.359-9.338-2.514-2.694-6.645-2.874-9.339-.36-2.694 2.515-2.873 6.645-.359 9.339 2.335 2.514 6.645 2.873 9.339.359ZM258.084 72.19c1.078-1.078 1.257-2.874.18-3.951-1.078-1.078-2.874-1.258-3.951-.18-1.078 1.077-1.257 2.873-.18 3.95 1.078 1.258 2.874 1.258 3.951.18ZM187.507 31.424c.718-.719.898-1.976.179-2.694-.718-.719-1.975-.898-2.694-.18-.718.718-.898 1.976-.179 2.694.718.718 1.975.898 2.694.18Z" fill="#EDEDED"></path><g filter="url(#b)"><path d="m252.642 64.768-26.169 46.633c-.984 1.574-2.952 2.164-4.329 1.18l-44.861-26.169c-1.574-.984-2.165-2.951-1.181-4.329l34.433-59.421c.984-1.575 2.952-2.165 4.329-1.181l32.465 18.889 5.313 24.398Z" fill="#F8F8F8"></path></g><path d="m247.33 40.37-7.477 12.593c-.984 1.967-.394 3.935 1.377 5.116l11.216 6.493" fill="#DDD"></path><path d="M216.438 52.569c.787-.197 1.574-.197 2.165-.197h2.361c.787.197 1.771.394 2.558.59.983.394 1.77.787 2.557 1.18a8.71 8.71 0 0 1 2.952 2.362c.787.787 1.377 1.77 1.771 2.952.393.983.393 2.164.393 3.148-.197 1.18-.59 2.36-1.18 3.345-.591.983-1.181 1.77-1.968 2.557-.787.59-1.377.984-2.361 1.378-.787.393-1.574.59-2.361.59l-2.165.197c-.59 0-1.18.197-1.967.393-.59.197-.984.394-1.377.787l-2.165 2.755-3.542-1.968 1.575-3.541c.196-.59.787-1.18 1.18-1.574.59-.394 1.181-.59 1.771-.787.787-.197 1.377-.197 2.164-.394.787 0 1.574-.197 2.361-.393.787-.197 1.378-.394 2.165-.787.787-.394 1.18-.984 1.574-1.771.197-.394.393-.984.59-1.574 0-.59 0-.984-.197-1.378-.196-.59-.393-.983-.787-1.377-.393-.394-.787-.787-1.377-1.18-.59-.394-1.377-.788-2.164-.984-.591-.197-1.181-.197-1.771-.197h-1.377c-.197 0-.591 0-.788-.197-.393-.197-.787-.787-.787-1.18l.197-2.755ZM206.403 78.54c.197-.393.591-.787.984-1.18.394-.197.787-.59 1.181-.59.984-.197 1.967-.197 2.754.393.394.197.787.59 1.181.984l.59 1.18c.591 1.968-.59 3.739-2.558 4.329-.983.197-1.967 0-2.754-.394-.394-.196-.787-.59-1.181-.983-.197-.394-.59-.787-.59-1.18-.197-.394-.197-.985 0-1.378 0-.394.197-.787.393-1.18Z" fill="#E0E0E0"></path><g filter="url(#c)"><path d="m84.412 44.503 29.908 31.285c.983 1.18.983 2.754-.197 3.738L83.625 108.45c-1.18.984-2.755.984-3.739-.197L41.715 67.917c-.984-1.18-.984-2.754.197-3.738l22.234-20.857 20.266 1.18Z" fill="#F8F8F8"></path></g><path d="m63.95 42.928 8.264 8.657c1.18 1.18 3.148 1.18 4.329 0l7.673-7.28" fill="#DDD"></path><path d="M66.31 69.884c0-.59.197-1.18.394-1.77l.59-1.772c.197-.59.59-1.18.984-1.77.394-.59.984-1.181 1.574-1.771.787-.788 1.574-1.378 2.558-1.771.787-.394 1.771-.59 2.558-.59.787 0 1.77.196 2.558.393.787.394 1.574.984 2.361 1.574.59.59 1.18 1.377 1.377 2.164.197.59.394 1.378.59 2.165v1.967c-.196.59-.196 1.181-.393 1.771 0 .59-.197.984-.197 1.574 0 .394 0 .787.394 1.18l1.574 2.362-2.361 2.164-2.361-2.164c-.394-.394-.787-.787-.984-1.377-.197-.59-.197-.984-.197-1.574 0-.59.197-1.181.197-1.771.197-.59.197-1.18.197-1.771 0-.59 0-1.18-.197-1.77-.197-.591-.59-1.181-.984-1.772-.197-.393-.59-.59-.984-.787-.393-.197-.787-.197-1.18-.197-.394 0-.787.197-1.18.394-.394.197-.788.394-1.181.787-.394.394-.787.984-1.181 1.377-.197.394-.394.787-.59 1.378-.197.393-.197.787-.197.983 0 .197-.197.394-.394.59-.196.394-.787.394-1.18.198l-2.164-.394Zm18.102 13.773c-.196-.197-.393-.59-.59-.984-.197-.393-.197-.787-.197-1.18 0-.787.394-1.574.984-2.164.197-.197.59-.394.984-.59.394-.198.787-.198 1.18-.198 1.181 0 2.362.788 2.755 1.968.197.394.197.787.197 1.18 0 .394-.197.788-.197 1.181-.197.394-.393.59-.787.984-.197.197-.59.59-.984.59-.787.197-1.574.197-2.164 0-.59-.197-.984-.393-1.18-.787Z" fill="#E0E0E0"></path><g filter="url(#d)"><path d="m162.524 93.692-11.608 41.516c-.394 1.378-1.968 2.362-3.345 1.771l-40.336-11.805c-1.378-.394-2.361-1.968-1.771-3.345l15.741-53.52c.393-1.376 1.967-2.36 3.345-1.77l29.317 8.657 8.657 18.496Z" fill="#F8F8F8"></path></g><path d="m153.873 75.27-3.742 11.732c-.394 1.574.59 3.345 2.164 3.739l10.378 2.932" fill="#DDD"></path><path d="m131.634 91.134 1.77-.59c.591-.197 1.181-.394 1.968-.394h2.164c.787 0 1.574.197 2.361.394.984.197 1.968.787 2.755 1.377a9.349 9.349 0 0 1 1.968 1.968c.393.787.787 1.574.984 2.361.196.984 0 1.968-.197 2.755-.197.787-.591 1.574-1.181 2.361a5.996 5.996 0 0 1-1.574 1.574c-.59.393-1.18.787-1.771.984l-1.771.59c-.393.197-.983.393-1.377.59-.393.197-.787.59-.787.984l-1.181 2.558-3.148-1.377.591-3.149c0-.59.393-.983.787-1.377.393-.393.787-.787 1.377-.984.59-.196 1.181-.393 1.574-.59.59-.197 1.181-.394 1.771-.787.59-.197.984-.59 1.574-.984.394-.393.787-.984.984-1.77v-.984c0-.394-.197-.788-.394-1.181-.196-.394-.59-.59-.984-.984a9.586 9.586 0 0 0-1.377-.59c-.59-.197-1.18-.197-1.967-.197-.394 0-.984 0-1.378.197-.393 0-.787.197-.984.197-.196 0-.393.196-.787 0-.393 0-.787-.394-.787-.787l-.983-2.165Zm-2.952 22.628c.197-.394.197-.787.59-.984.197-.394.591-.59.787-.787.787-.394 1.575-.394 2.165-.197.393.197.787.394.984.59l.787.787c.787 1.378.196 3.149-1.181 3.739-.787.393-1.574.393-2.164.197-.394-.197-.787-.197-.984-.591-.394-.196-.59-.59-.787-.787-.197-.393-.197-.59-.394-.984.197-.196.197-.59.197-.983Z" fill="#E0E0E0"></path><g filter="url(#e)"><path d="m257.364 164.723-38.171 20.66c-1.181.59-2.951.197-3.542-1.181l-19.086-37.187c-.59-1.181-.196-2.952 1.181-3.542l49.584-26.169c1.18-.591 2.951-.197 3.541 1.18l13.774 26.956-7.281 19.283Z" fill="#F8F8F8"></path></g><path d="m264.448 145.834-10.625 5.509c-1.377.787-1.968 2.755-1.377 4.132l4.722 9.445" fill="#DDD"></path><path d="M238.082 140.718c.59.197.984.59 1.574.787.59.197.984.59 1.574 1.18.59.591.984.984 1.377 1.574.591.591.984 1.181 1.378 1.968.59.787.787 1.968.787 2.755.196.984 0 1.771 0 2.754-.197.787-.591 1.574-.984 2.362-.59.787-1.377 1.377-2.164 1.77-.591.394-1.575.591-2.362.787-.59.197-1.574.197-2.164 0-.59-.196-1.377-.196-1.968-.59l-1.574-.787c-.393-.197-.983-.393-1.377-.59-.393-.197-.984-.197-1.181.197l-2.557.983-1.378-2.951 2.558-1.771c.394-.393.984-.393 1.574-.393.591 0 .984 0 1.574.196.591.197.984.591 1.378.787.59.197.983.591 1.771.787.59.197.983.197 1.77.394.591 0 1.181-.197 1.968-.59.59-.394 1.377-.984 1.377-1.968.197-.393 0-.787 0-1.377-.196-.394-.196-.787-.59-1.378-.197-.59-.59-.983-.984-1.574-.197-.196-.59-.59-.984-.787-.196-.196-.59-.393-.787-.59-.196-.197-.393-.197-.59-.59-.197-.197-.197-.787 0-.984l.984-2.361Zm-18.299 13.576c.394-.197.59-.393 1.181-.196.393-.197.787 0 .984 0 .787.196 1.377.787 1.574 1.377.196.393.196.787.196 1.18v.984c-.196.59-.787 1.378-1.377 1.574-.394.197-.787.197-1.181.197h-.983c-.787-.197-1.378-.787-1.574-1.377-.197-.394-.197-.787-.197-1.181-.197-.393 0-.787 0-.984.197-.393.393-.59.393-.983.197-.197.787-.197.984-.591Z" fill="#E0E0E0"></path><path d="M216.438 142.489v32.662c0 4.132-3.541 7.674-7.673 7.674H100.743c-4.132 0-7.674-3.542-7.674-7.674v-35.417" stroke="#5F6865" stroke-width="5.575" stroke-linecap="round" stroke-linejoin="round"></path><path d="M212.308 121.436h-36.991c-3.542 0-7.083 1.18-9.838 3.541l-9.838 7.871c-2.755 2.164-6.296 3.541-9.838 3.541h-42.107c-4.132 0-7.674 3.345-7.674 7.674 0 .394 0 .787.197 1.181l7.674 40.336c.59 3.738 3.935 6.689 7.674 6.689h89.919c3.935 0 7.084-2.754 7.674-6.493l10.822-55.486c.59-4.132-2.165-8.067-6.493-8.658-.394-.196-.788-.196-1.181-.196Z" fill="#fff"></path><g filter="url(#f)"><path d="M222.538 114.155h-44.074c-4.132 0-8.461 1.574-11.609 4.132l-11.806 9.642c-3.345 2.754-7.477 4.131-11.609 4.131H92.873c-4.92 0-9.248 3.936-9.248 9.248 0 .394 0 .984.197 1.378l9.248 48.993c.787 4.525 4.525 8.067 9.247 8.067h107.235c4.525 0 8.46-3.345 9.248-7.87l12.789-67.096c.787-4.919-2.558-9.838-7.674-10.625h-1.377Z" fill="url(#g)"></path></g><path d="M137.536 165.707c2.558 0 4.722-2.164 4.722-4.722 0-2.558-2.164-4.722-4.722-4.722-2.558 0-4.723 2.164-4.723 4.722 0 2.558 2.165 4.722 4.723 4.722ZM174.331 164.919c2.558 0 4.722-2.164 4.722-4.722 0-2.558-2.164-4.722-4.722-4.722-2.558 0-4.723 2.164-4.723 4.722 0 2.558 2.165 4.722 4.723 4.722ZM165.872 172.79h-2.558c-2.164-4.329-7.477-6.1-11.608-3.738-1.771.787-3.149 2.361-3.739 3.738h-2.558c2.165-5.706 8.658-8.657 14.167-6.493 2.951 1.18 5.116 3.542 6.296 6.493Z" fill="#CCC"></path><path d="M240.443 215.683c-2.164 0-1.377.197-18.102-16.528-16.134 12.003-38.565.394-38.565-19.282 0-13.183 10.822-24.005 24.005-24.005 19.086 0 30.892 21.447 19.676 37.778l15.544 15.544a3.708 3.708 0 0 1-2.558 6.493Zm-32.465-52.141c-9.051 0-16.528 7.28-16.528 16.528 0 9.247 7.28 16.528 16.528 16.528.984 0 1.968 0 2.951-.197.984-.197 1.968-.394 2.755-.787.984-.394 1.771-.787 2.558-1.181.984-.59 1.771-1.18 2.558-1.967l1.967-1.968c.591-.787 1.181-1.574 1.574-2.361.394-.787.787-1.771 1.181-2.755s.59-1.967.59-2.951c0-.787.197-1.377.197-2.165.197-9.444-7.28-16.724-16.331-16.724Z" fill="#BCBCBC"></path><path d="m125.93 152.917 10.625-5.706M183.58 150.163l-10.625-5.903" stroke="#CCC" stroke-width="2.787" stroke-miterlimit="10"></path><defs><filter id="b" x="134.738" y=".559" width="158.787" height="173.828" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood><feColorMatrix in="SourceAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix><feOffset dy="20.442"></feOffset><feGaussianBlur stdDeviation="20.442"></feGaussianBlur><feColorMatrix values="0 0 0 0 0.397708 0 0 0 0 0.47749 0 0 0 0 0.575 0 0 0 0.27 0"></feColorMatrix><feBlend in2="BackgroundImageFix" result="effect1_dropShadow"></feBlend><feBlend in="SourceGraphic" in2="effect1_dropShadow" result="shape"></feBlend></filter><filter id="c" x=".117" y="22.881" width="155.8" height="147.609" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood><feColorMatrix in="SourceAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix><feOffset dy="20.442"></feOffset><feGaussianBlur stdDeviation="20.442"></feGaussianBlur><feColorMatrix values="0 0 0 0 0.397708 0 0 0 0 0.47749 0 0 0 0 0.575 0 0 0 0.27 0"></feColorMatrix><feBlend in2="BackgroundImageFix" result="effect1_dropShadow"></feBlend><feBlend in="SourceGraphic" in2="effect1_dropShadow" result="shape"></feBlend></filter><filter id="d" x="64.406" y="45.923" width="139.001" height="152.556" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood><feColorMatrix in="SourceAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix><feOffset dy="20.442"></feOffset><feGaussianBlur stdDeviation="20.442"></feGaussianBlur><feColorMatrix values="0 0 0 0 0.397708 0 0 0 0 0.47749 0 0 0 0 0.575 0 0 0 0.27 0"></feColorMatrix><feBlend in2="BackgroundImageFix" result="effect1_dropShadow"></feBlend><feBlend in="SourceGraphic" in2="effect1_dropShadow" result="shape"></feBlend></filter><filter id="e" x="155.417" y="96.597" width="150.111" height="150.376" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood><feColorMatrix in="SourceAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix><feOffset dy="20.442"></feOffset><feGaussianBlur stdDeviation="20.442"></feGaussianBlur><feColorMatrix values="0 0 0 0 0.397708 0 0 0 0 0.47749 0 0 0 0 0.575 0 0 0 0.27 0"></feColorMatrix><feBlend in2="BackgroundImageFix" result="effect1_dropShadow"></feBlend><feBlend in="SourceGraphic" in2="effect1_dropShadow" result="shape"></feBlend></filter><filter id="f" x="42.742" y="93.714" width="229.844" height="167.357" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood><feColorMatrix in="SourceAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix><feOffset dy="20.442"></feOffset><feGaussianBlur stdDeviation="20.442"></feGaussianBlur><feColorMatrix values="0 0 0 0 0.397708 0 0 0 0 0.47749 0 0 0 0 0.575 0 0 0 0.27 0"></feColorMatrix><feBlend in2="BackgroundImageFix" result="effect1_dropShadow"></feBlend><feBlend in="SourceGraphic" in2="effect1_dropShadow" result="shape"></feBlend></filter><linearGradient id="a" x1="154.458" y1="105.765" x2="154.458" y2="136.483" gradientUnits="userSpaceOnUse"><stop stop-color="#BEBEBE"></stop><stop offset="1" stop-color="#8C8C8C"></stop></linearGradient><linearGradient id="g" x1="157.616" y1="112.175" x2="157.616" y2="200.669" gradientUnits="userSpaceOnUse"><stop stop-color="#FFFDFD"></stop><stop offset=".996" stop-color="#F1F1F1"></stop></linearGradient></defs></svg>
Активные вакансии не найдены</span>';
                if ($key != null) {
                    $text .= 'Найдено 0 вакансии, по запросу ' . $key;
                } else {
                    $text .= 'Найдено 0 вакансии';
                }
            }


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

            echo json_encode(array(
                'code' => 'success',
                'data' => array(
                    'list' => $list,
                    'countText' => $text,
                    'count' => $count,
                    'pagination' => $pagination,
                    'countAll' => $countAll,
                    'people' => $people,
                    'online' => $online,
                    'page' => $page,
                    'limit' => $limit,
                    'http' => $_SERVER['HTTP_REFERER']
                )
            ));
            exit;
        }

        if (isset($_POST['MODULE_EDIT_NAME']) && $_POST['MODULE_EDIT_NAME'] == 1) {
            if (empty($_POST['name']) || trim($_POST['name']) == '') {
                echo json_encode(array(
                    'code' => 'validate_error',
                ));
                exit;
            } else {

                $name = preg_replace("'<script[^>]*?>.*?</script>'si", "", $_POST['name']);
                $name = str_replace($xss, "", $name);

                $app->execute("UPDATE `company` SET `name` = :n WHERE `id` = :id", [
                    ':n' => $name,
                    ':id' => (int) $_SESSION['id']
                ]);

                $app->execute("UPDATE `vacancy` SET `company` = :n WHERE `company_id` = :id", [
                    ':n' => $name,
                    ':id' => (int) $_SESSION['id']
                ]);

                $app->execute("UPDATE `respond` SET `company` = :n WHERE `company_id` = :id", [
                    ':n' => $name,
                    ':id' => (int) $_SESSION['id']
                ]);

                $app->execute("UPDATE `respond_company` SET `company` = :n WHERE `company_id` = :id", [
                    ':n' => $name,
                    ':id' => (int) $_SESSION['id']
                ]);

                echo json_encode(array(
                    'code' => 'success',
                ));

                exit;
            }
        }

        if (isset($_POST['MODULE_EDIT_MAIL']) && $_POST['MODULE_EDIT_MAIL'] == 1) {
            if (empty($_POST['mail']) || trim($_POST['mail']) == '') {
                echo json_encode(array(
                    'code' => 'validate_error',
                ));
                exit;
            } else {
                $email = XSS_DEFENDER($_POST['mail']);

                $code = md5(random_str(25) . $_SESSION['company'] . time());

                $pass = generate_password(16);

                if (SENDMAIL($mail, "Изменить email", $email, $_SESSION['company'], '
Здравствуйте! Для смены email почты пройдите по нижеследующей ссылке (действует 6 часов).

Ваш новый email: '.$email.'
Ваш НОВЫЙ пароль: <b>'.$pass.'</b>
(действует после подтверждения)
<a class="go-bth" href="http://stgaujob.ru/email-confirm/?code='.$code.'&email='.$email.'">
Сменить</a>

Примечание: чтобы почта сменилась Вы должны быть авторизированным на сайте.
            ')) {

                    $app->execute("INSERT INTO `temp_email_c` (`token`, `code`, `time`, `vac_token`, `email`) 
                                    VALUES(:token, :code, NOW(), :vt, :email)", [
                        ':token' => $_SESSION['id'],
                        ':code' => $code,
                        ':vt' => $pass,
                        ':email' => $email
                    ]);

                    echo json_encode(array(
                        'code' => 'success',
                    ));

                    exit;
                } else {
                    echo json_encode(array(
                        'code' => 'error',
                    ));
                    exit;
                }
            }
        }

        if (isset($_POST['MODULE_SAVE_PASS']) && $_POST['MODULE_SAVE_PASS'] == 1) {
            $err = [];

            $captcha = $_SESSION['captcha'];
            unset($_SESSION['captcha']);
            session_write_close();
            $code = $_POST['captcha'];
            $code = crypt(trim($code), '$1$itchief$7');

            $r = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $_SESSION['id']]);

            if (count($r) > 0) {
                if (empty($_POST['password']) or trim($_POST['password']) == '') $err['password'] = 'Введите пароль';
                else if (md5(md5($_POST['password'] . $r['code'] . $r['email'])) != $_SESSION['password']) $err['password'] = 'Вы ввели неверный пароль';
                if (empty($_POST['new_password']) or trim($_POST['new_password']) == '') $err['new_password'] = 'Введите новый пароль';
                if (empty($_POST['lost_password']) or (trim($_POST['new_password']) != trim($_POST['lost_password']))) $err['lost_password'] = 'Пароли не совпадают';
                if (empty($_POST['captcha']) or trim($_POST['captcha']) == '') $err['captcha'] = 'Пожалуйста введите код';
                else if ($captcha != $code)  $err['captcha'] = 'Введенный код не соответствует изображению!';

                if (empty($err)) {

                    $password = XSS_DEFENDER($_POST['password']);
                    $new_password = XSS_DEFENDER($_POST['new_password']);

                    //$pass_code = md5(md5(random_str(25)));
                    //$new_pass = md5(md5($new_password . $pass_code . $r['email']));

                    $pass_code = md5(md5(random_str(10).time()));

                    $new_pass = password_hash($new_password . $pass_code, PASSWORD_BCRYPT, [
                        'cost' => 11
                    ]);

                    $app->execute("UPDATE `company` SET `password` = :pas, `code` = :code WHERE `id` = :id", [
                        ':pas' => $new_pass,
                        ':code' => $pass_code,
                        ':id' => $_SESSION['id']
                    ]);

                    $_SESSION['password'] = $new_pass;

                    SENDMAIL($mail, "Изменён пароль", $r['email'], $_SESSION['company'], '
Здравствуйте! Ваш пароль был успешно изменен.

Если это были не вы, пожалуйста, немедленно измените свой пароль с помощью формы восстановления пароля на сайте, чтобы обезопасить свою учетную запись.
            ');

                    echo json_encode(array(
                        'code' => 'success',
                    ));
                    exit;

                } else {
                    echo json_encode(array(
                        'error' => $err,
                        'code' => 'validate_error',
                    ));
                    exit;
                }
            } else {
                echo json_encode(array(
                    'code' => 'error',
                ));
                exit;
            }

        }

        if (isset($_POST['MODULE_DELETE_JOB']) && $_POST['MODULE_DELETE_JOB'] == 1) {

            if (isset($_POST['id']) && $_POST['id'] > 0) {

                $count = $app->rowCount("SELECT * FROM `vacancy` WHERE `id` = :id AND `company_id` = :ci AND `status` = 0", [
                    ':id' => intval($_POST['id']),
                    ':ci' => $_SESSION['id']
                ]);

                if ($count > 0) {

                    $r = $app->fetch("SELECT * FROM `vacancy` WHERE `id` = :id AND `company_id` = :ci AND `status` = 0", [
                        ':id' => intval($_POST['id']),
                        ':ci' => $_SESSION['id']
                    ]);

                    $app->execute('UPDATE `vacancy` SET `status` = :st, `trash` = :task WHERE `id` = :id', [
                        ':st' => 1,
                        ':id' => $r['id'],
                        ':task' => $Date
                    ]);

                    $app->execute("UPDATE `company` SET `job` = `job` - 1 WHERE `id` = :id", [':id' => $r['company_id']]);

                    $app->execute('UPDATE `category` SET `job` = `job` - 1 WHERE `id` = :id', [
                        ':id' => $r['category_id']
                    ]);

                    echo json_encode(array(
                        'code' => 'success',
                    ));
                }

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




