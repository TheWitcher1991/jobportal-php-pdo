<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $app->notFound();
    exit;
}

if (isset($_SESSION['id']) && isset($_SESSION['password'])) {
    try {



        $tmp_path = $_SERVER['DOCUMENT_ROOT'] . '/static/tmp/';
        $path = $_SERVER['DOCUMENT_ROOT'] . '/static/image/chat/';

        function getOptions()
        {
            $act = (isset($_POST['act'])) ? (int) $_POST['act'] : null;
            $id = (isset($_POST['id'])) ? (int) $_POST['id'] : null;
            $text = (isset($_POST['text'])) ? $_POST['text'] : null;


            return array(
                'act' => $act,
                'id' => $id,
                'text' => $text,
            );
        }

        function send($options, $PDO, $app, $Date, $Date_ru) {
            $options = getOptions();

            $id = intval($options['id']);
            $text = XSS_DEFENDER($options['text']);

            if ($_SESSION['type'] == 'users') {
                $sql = "SELECT * FROM `users` WHERE `id` = :id";
                $stmt = $PDO->prepare($sql);
                $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
                $stmt->execute();
                $r = $stmt->fetch();
            }

            if ($_SESSION['type'] == 'company') {
                $sql = "SELECT * FROM `company` WHERE `id` = :id";
                $stmt = $PDO->prepare($sql);
                $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
                $stmt->execute();
                $r = $stmt->fetch();
            }

            $stmt = $PDO->prepare("SELECT * FROM `chat` WHERE `id` = ?");
            $stmt->execute([$id]);
            if ($stmt->rowCount() > 0) {
                if ($_SESSION['type'] == 'company') {
                    $name = $r['name'];
                } else if ($_SESSION['type'] = 'users') {
                    $name = $r['name'] . $r['surname'];
                }
                if (trim($text) != '') {
                    $app->execute("INSERT INTO `msg` (`time`, `date`, `day`, `user_id`, `user_name`, `user_type`, `text`, `chat_id`, `year`) 
            VALUES(:t, :d, :dy, :ui, :u, :ut, :text, :ci, :y)", [
                        ':t' => date("H:i"),
                        ':d' => $Date,
                        'dy' => $Date_ru,
                        ':ui' => $_SESSION['id'],
                        ':u' => $name,
                        ':ut' => $_SESSION['type'],
                        ':text' => $text,
                        ':ci' => $id,
                        ':y' => date('Y')
                    ]);


                    $cht = $stmt->fetch();

                    $app->execute("UPDATE `chat` SET 
                        `last` = :l, 
                        `last_c` = :lc,
                        `last_u` = :lu,
                        `last_m` = :lm WHERE `id` = :id", [
                        ':l' => date("H:i"),
                        ':lm' => $text,
                        ':lc' => ($_SESSION['type'] == 'company' ? $text : $cht['last_c']),
                        ':lu' => ($_SESSION['type'] == 'users' ? $text : $cht['last_u']),
                        ':id' => $id
                    ]);

                    if ($_SESSION['type'] == 'company') {
                        $app->execute("INSERT INTO `notice` (`type`, `title`, `date`, `hour`, `time`, `user_id`, `company_id`, `who`, `chat_id`)
                    VALUES(:typ, :title, :dat, :h, NOW(), :ui, :ci, :wh, :ch)", [
                            ':typ' => 'chat_message',
                            ':title' => 'У Новое сообщение!',
                            ':dat' => $Date,
                            ':h' => date("H:i"),
                            ':ui' => $cht['user_id'],
                            ':ci' => $cht['company_id'],
                            ':wh' => 2,
                            ':ch' => $cht['id']
                        ]);
                    }
                    if ($_SESSION['type'] == 'users') {
                        $app->execute("INSERT INTO `notice` (`type`, `title`, `date`, `hour`, `time`, `user_id`, `company_id`, `who`, `chat_id`)
                    VALUES(:typ, :title, :dat, :h, NOW(), :ui, :ci, :wh, :ch)", [
                            ':typ' => 'chat_message',
                            ':title' => 'У Новое сообщение!',
                            ':dat' => $Date,
                            ':h' => date("H:i"),
                            ':ui' => $cht['user_id'],
                            ':ci' => $cht['company_id'],
                            ':wh' => 1,
                            ':ch' => $cht['id']
                        ]);
                    }



                    $li = "";
                    $sth = $PDO->prepare("SELECT * FROM `msg` WHERE `chat_id` = ? ORDER BY `id` DESC");
                    $sth->execute([$cht['id']]);
                    if ($sth->rowCount() > 0) {
                        $count = $sth->rowCount();
                        $data = [];
                        while ($r = $sth->fetch()) {
                            $data[$r['date']][] = $r;
                        }

                        $monthes_ru = [
                            1 => 'января',
                            2 => 'февраля',
                            3 => 'марта',
                            4 => 'апреля',
                            5 => 'мая',
                            6 => 'июня',
                            7 => 'июля',
                            8 => 'августа',
                            9 => 'сентября',
                            10 => 'октября',
                            11 => 'ноября',
                            12 => 'декабря'
                        ];

                        foreach ($data as $home => $datum) {
                            $new_ru = DateTime::createFromFormat('d.m.Y', $home)->format('d') . ' ' . $monthes_ru[(DateTime::createFromFormat('d.m.Y', $home)->format('n'))];
                            $y = DateTime::createFromFormat('d.m.Y', $home)->format('Y');
                            if ($y == date('Y')) {
                                $li .= '<li class="chat-date-item"><span>'.$new_ru.'</li>';
                            } else {
                                $li .= '<li class="chat-date-item"><span>'.$new_ru.' '.$y.'</li>';
                            }
                            foreach ($datum as $key => $r) {
                                foreach ($r as $k => $v) {
                                    if ($r['user_id'] == $_SESSION['id'] && $r['user_type'] == $_SESSION['type']) {
                                        $li .= '<li class="me-block chat-item">
                                <div class="ch-b">
                                    <div class="text-box">' . $r['text'] . '</div>
                                    <div class="time-box">' . $r['time'] . '</div>
                                </div>    
                            </li>';
                                        break;
                                    } else {
                                        $li .= '<li class="for-block chat-item"><div class="ch-b"><div class="text-box">' . $r['text'] . '</div><div class="time-box">' . $r['time'] . '</div></div></li>';
                                        break;
                                    }
                                }
                            }
                        }
                    } else {
                        $li = '<li class="me-block chat-item"><div class="ch-b"><div class="text-box">Нет сообщений</div>';
                        $count = 0;
                    }

                    return array(
                        'list' => $li,
                        'count' => $count
                    );
                }
            }
        }

        function load($options, $PDO, $app) {
            $options = getOptions();

            $id = intval($options['id']);

            $stmt = $PDO->prepare("SELECT * FROM `chat` WHERE `id` = ?");
            $stmt->execute([$id]);
            if ($stmt->rowCount() > 0) {
                $chat = $stmt->fetch();
                $stmt = $PDO->prepare("SELECT * FROM `msg` WHERE `chat_id` = ? ORDER BY `id` DESC");
                $stmt->execute([$chat['id']]);
                if ($stmt->rowCount() > 0) {
                    $count = $stmt->rowCount();
                    $li = "";
                    $data = [];
                    while ($r = $stmt->fetch()) {

                        $data[$r['date']][] = $r;

                        /*if ($r['user_id'] == $_SESSION['id']) {
                            $li .= '<li class="me-block chat-item">
                                <div class="ch-b">
                                    <div class="text-box">' . $r['text'] . '</div>
                                    <div class="time-box">' . $r['time'] . ', ' . $r['day'] . '</div>
                                </div>    
                            </li>';
                        } else {
                            $li .= '<li class="for-block chat-item"><div class="ch-b"><div class="text-box">' . $r['text'] . '</div><div class="time-box">' . $r['time'] . ', ' . $r['day'] . '</div></div></li>';
                        }*/
                    }

                    $monthes_ru = [
                        1 => 'января',
                        2 => 'февраля',
                        3 => 'марта',
                        4 => 'апреля',
                        5 => 'мая',
                        6 => 'июня',
                        7 => 'июля',
                        8 => 'августа',
                        9 => 'сентября',
                        10 => 'октября',
                        11 => 'ноября',
                        12 => 'декабря'
                    ];




                    foreach ($data as $home => $datum) {
                        $new_ru = DateTime::createFromFormat('d.m.Y', $home)->format('d') . ' ' . $monthes_ru[(DateTime::createFromFormat('d.m.Y', $home)->format('n'))];
                        $y = DateTime::createFromFormat('d.m.Y', $home)->format('Y');
                        if ($y == date('Y')) {
                            $li .= '<li class="chat-date-item"><span>'.$new_ru.'</li>';
                        } else {
                            $li .= '<li class="chat-date-item"><span>'.$new_ru.' '.$y.'</li>';
                        }
                        foreach ($datum as $key => $r) {
                            foreach ($r as $k => $v) {
                                if ($r['user_id'] == $_SESSION['id'] && $r['user_type'] == $_SESSION['type']) {
                                    $li .= '<li class="me-block chat-item">
                                <!--<div class="edit-block"><button><i class="mdi mdi-pencil"></i></button><button><i class="mdi mdi-delete"></i></button></div>-->
                                <div class="ch-b">
                                    <div class="text-box">' . $r['text'] . '</div>
                                    <div class="time-box">' . $r['time'] . '</div>
                                </div>    
                            </li>';
                                    break;
                                } else {
                                    $li .= '<li class="for-block chat-item"><div class="ch-b"><div class="text-box">' . $r['text'] . '</div><div class="time-box">' . $r['time'] . '</div></div></li>';
                                    break;
                                }
                            }
                        }
                    }

                } else {
                    $li = '<li class="me-block chat-item"><div class="ch-b"><div class="text-box">Нет сообщений</div>';
                    $count = 0;
                }
            } else {
                $li = '<li class="me-block chat-item"><div class="ch-b"><div class="text-box">Произошла ошибка</div>';
                $count = 0;
            }

            return array(
                'list' => $li,
                'count' => $count
            );
        }

        function getStatus($options, $PDO, $app) {
            $status = 'Не в сети';
            $text = XSS_DEFENDER($options['text']);

            $id = intval($options['id']);

            $stmt = $PDO->prepare("SELECT * FROM `chat` WHERE `id` = ?");
            $stmt->execute([$id]);
            if ($stmt->rowCount() > 0) {
                $chat = $stmt->fetch();
                if ($_SESSION['type'] == 'company') {
                    $nc = $app->count("SELECT * FROM `online` WHERE `id` = $chat[user_id] AND `type` = 'users'");
                    if ($nc > 0) {
                        $status = 'В сети';
                    }
                }
                if ($_SESSION['type'] == 'users') {
                    $nc = $app->count("SELECT * FROM `online` WHERE `id` = $chat[company_id] AND `type` = 'company'");
                    if ($nc > 0) {
                        $status = 'В сети';
                    }
                }
            }

            return $status;
        }

        $options = getOptions();

        $act = (int) $options['act'];

        switch ($act) {
            case 1:
                $echo = send(getOptions(), $PDO, $app, $Date, $Date_ru);
                break;
            case 2:
                $echo = load(getOptions(), $PDO, $app);
                break;
            case 3:
                $status = getStatus(getOptions(), $PDO, $app);
                break;
        }



        echo json_encode(array(
            'code' => 'success',
            'status' => $status,
            'data' => $echo
        ));

        session_write_close();

        exit;
    } catch (Exception $e) {
        echo json_encode(array(
            'code' => 'error',
            'message' => $e->getMessage()
        ));
        session_write_close();

        exit;
    }

} else {
    $app->notFound();
}

