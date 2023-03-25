<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $app->notFound();
    exit;
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

                if ($col == 2) $col = "`job`";
                else if ($col == 3) $col = "`user_id`";
                else if ($col == 4) $col = "`time`";
                else if ($col == 5) $col = "`status`";
                else $col = "`id`";

                $where = "";

                if ($key != null) $where = addWhere($where, "
                    `job` LIKE '%$key%' OR 
                    `company` LIKE '%$key%' OR
                    `status` LIKE '%$key%'
                ");
                $sql = "SELECT * FROM `respond`";
                $sql2 = "SELECT * FROM `respond`";
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

                        if ($r['status'] == 0 || $r['status'] == 1) {
                            $st = 'На рассмотрении';
                        } else if ($r['status'] == 2) {
                            $st = 'Разговор по телефону';
                        } else if ($r['status'] == 3) {
                            $st = 'Назначено собеседование';
                        } else if ($r['status'] == 4) {
                            $st = 'Принят на работу';
                        } else if ($r['status'] == 5) {
                            $st = 'Отказано';
                        } else if ($r['status'] == 6) {
                            $st = 'Приглашение';
                        } else {
                            $st = ' Не определён';
                        }

                        $stext = '';

                        if ($r['status'] == 0) {
                            $stext = '<span style="background:#6fc3ff;color: #fff;border: 0" class="status-yes">'.$st.'</span>';
                        } else if ($r['status'] == 1 || $r['status'] == 2) {
                            $stext = '<span style="background:#4c83ff;color: #fff;border: 0" class="status-yes">'.$st.'</span>';
                        } else if ($r['status'] == 3) {
                            $stext = '<span style="background:#FD6585;color: #fff;border: 0" class="status-yes">'.$st.'</span>';
                        } else if ($r['status'] == 4) {
                            $stext = '<span style="background:#3dc77d;color: #fff;border: 0" class="status-yes">'.$st.'</span>';
                        } else if ($r['status'] == 5) {
                            $stext =  '<span style="background: #f1416c;color: #fff;border: 0" class="status-none">'.$st.'</span>';
                        } else if ($r['status'] == 5) {
                            $stext = '<span style="background:#6fc3ff;color: #fff;border: 0" class="status-yes">'.$st.'</span>';
                        } else {
                            $stext = '<span class="status-unf">Не определён</span>';
                        }

                        $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $r['user_id']]);
                        $jo = $app->fetch("SELECT * FROM `vacancy` WHERE `id` = :id", [':id' => $r['job_id']]);

                        $remsg = $app->fetch("SELECT * FROM `respond_message` WHERE `job` = :ji AND `user` = :ui AND `type` = :st",
                            [
                                ':ji' => $jo['id'],
                                ':ui' => $user['id'],
                                ':st' => $r['status']
                            ]);

                        $linkmsg = $app->fetch("SELECT * FROM `respond_message` WHERE `company` = :ji AND `user` = :ui AND `type` = :st",
                            [
                                ':ji' => $r['company'],
                                ':ui' => $user['id'],
                                ':st' => 6
                            ]);

                        $pop = '';

                        $c = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $r['company']]);

                        if (isset($remsg['id'])) {
                            $pop = '
                                        <div class="sp-stat">
                                            '.($r['status'] == 2 ? $jo['company'] . ' назначила телефонную беседу' : '').'
                                            '.($r['status'] == 3 ? 'Поздравляем! ' . $jo['company'] . ' назначила собеседование' : '').'
                                            '.($r['status'] == 4 ? 'Поздравляем! ' . $jo['company'] . ' готова принять студента на работу' : '').'
                                            '.($r['status'] == 5 ? 'К сожалению, ' . $jo['company'] . ' отказала в кандидатуре' : '').'
                                        </div>
                                        <div class="text-stat">
                                        '.(trim($remsg['text']) != '' ? $remsg['text'] : 'Компания не оставила сообщения').'
                                        </div>
                                        <div class="text-more-s">
                                        
                                        '.($r['status'] == 2 ? '
                                            <span>День: <m>'.$remsg['text_day'].'</m></span>
                                            <span>Время: <m>'.$remsg['text_time'].'</m></span>
                                        ' : '').'
                                        
                                        '.($r['status'] == 3 ? '
                                            <span>День: <m>'.$remsg['text_day'].'</m></span>
                                            <span>Время: <m>'.$remsg['text_time'].'</m></span>
                                            <span>Адрес: <m>'.$remsg['text_address'].'</m></span>
                                        ' : '').'
                                        
                                        </div>
                                        
                                        ';
                        } else {
                            if ($r['status'] == 0) {
                                $pop = '
                                        <div class="sp-stat">
                                            На данный момент '.$r['company'].' не совершила с откликом никаких действий.
                                        </div>
                                        <div class="text-stat">
                                            Скорее всего компания сейчас рассматривает кандидатуру студента
                                        </div>
                                        ';
                            } else if ($r['status'] != 0) {
                                $pop = '
                                           
                                               <div class="sp-stat">
                                            '.$r['company'].' сменила статус отклика, но не оставила сообщение
                                        </div>
                                            ';
                            }
                        }

                        $letter_t = '';

                        if (trim($r['text']) != '') {
                            $letter_t = '<br /> <div style="font-weight: 600">Сопроводительное письмо студента:</div> ' . $r['text'];
                        }

                        $content = '';

                        if ($r['status'] >= 0 && $r['age'] != 1 && $r['status'] <= 65) {

                            $content .= '<span><i class="icon-user"></i> '. $user['name'] . ' ' . $user['surname'] .'</span>';
                            $content .= '<span><i class="icon-briefcase"></i>'. $jo['title'] . '</span>';
                            $content .= $pop;
                            $content .= $letter_t;
                            $content .= '
                            <div class="re-flex">
                                <span class="re-300">Обновлено '. $jo['last_up'] .',</span>
            
                                <span class="re-300">Откликнулись '. $r['time'] .'</span>
                            </div>
                            ';
                            $content .= '
                            <div style="margin:0" class="re-flex-2">
                                 <span><i class="mdi mdi-phone"></i> '. $jo['phone'] .'</span>
                                 <span><i class="mdi mdi-at"></i> '. $jo['email'] .'</span>
                                 <span><i class="mdi mdi-account"></i> '. $jo['contact'] .'</span>
                            </div>';

                        } else if ($r['status'] == 6) {

                        } else {

                            $content = 'Что-то пошло не так!';

                        }

                        $html .= '
                        <div class="table-tr">
                            <div class="table-td-exp"><span>'.$r['id'].'</span></div>
                            <div><a class="table-td-a" target="_blank" href="/admin/info-jobs/?id='.$r['id'].'">'.mb_strimwidth($r['job'], 0, 35, "...").'</a></div>
                            <div><a class="table-td-a" target="_blank" href="/admin/info-students/?id='.$r['user_id'].'">'.mb_strimwidth($user['name'] . ' ' . $user['surname'], 0, 35, "...").'</a></div>
                            <div class="table-td-exp"><span>'.$r['date'].'</span></div>
                            <div class="table-td-exp"><span>'.$stext.'</span></div>
                            <div class="table-td-exp"><span>'.$jo['address'].'</span></div>
                            <div class="table-td-title"> <form action="" method="post">
                            
                           
                                                 <div class="block-manage">
                     
                  

                                          <button onclick="infoVac_'.$r['id'].'()" title="Что там?" name="" class="manage-bth-mini" type="button"><i class="icon-info"></i></button>


                                    <script >
                                     function infoVac_'.$r['id'].'() {
                                        document.querySelector("body").innerHTML += `
 <div id="auth" style="display:flex">
    <div class="contact-wrapper" style="display:block">
        <div class="auth-respond auth-log" style="display:block">
             <div class="auth-title">
                Отклик
                <i class="mdi mdi-close" onclick="deleteForm()"></i>
             </div>
             <div class="auth-form">                                      
                      '.$content.'              
              </div>
        </div>
    </div>
</div>
                                           `;
                                        }
                                    
                                    </script>

                                    
                                    </div>
                                    
                                    
                                    </form></div>
                            </div>
                        ';

                    }

                } else {
                    $html .= '<span>Отклики не найдены</span>';
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

        if (isset($_POST['MODULE_GET_IP_LIST']) && $_POST['MODULE_GET_IP_LIST'] == 1) {

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

                if ($col == 2) $col = "`time`";
                else if ($col == 3) $col = "`ip`";
                else if ($col == 4) $col = "`city`";
                else $col = "`id`";

                $where = "";

                if ($key != null) $where = addWhere($where, "`name` LIKE '%$key%' OR `username` LIKE '%$key%' OR `id` LIKE '%$key%' OR `id` LIKE '%$key%' OR `specialty` LIKE '%$key%'");
                $sql = "SELECT * FROM `ip`";
                $sql2 = "SELECT * FROM `ip`";
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

                $bth = "";



                if ($count > 0) {

                    while($r = $stmt->fetch()) {

                        $count = $count + 1;
                        $ipc = $app->rowCount("SELECT * FROM `black_list` WHERE `ip` = :ip", [':ip' => $r['ip']]);

                        if ($r['ip'] != getIp()) {

                            if ($ipc > 0) {
                                $bth = "<button onclick=\"removeBlackList('$r[ip]', $count)\" class='manage-bth success-list' type='button'><i class='icon-check'></i> Разблокировать</button>";
                            } else {
                                $bth = "<button onclick=\"addBlackList('$r[ip]', $count)\" class='manage-bth success-list' type='button'><i class='icon-ban'></i> Заблокировать</button>";
                            }

                        }


                        $html .= '
                        <div class="table-tr tr-'.$count.'">
                            <div class="table-td-exp"><span>'.$r['id'].'</span></div>
                            <div class="table-td-title">'.$r['date'].' '.$r['hour'].'</div>
                            <div class="table-td-exp"><span>'.$r['ip'].'</span></div>
                            <div class="table-td-exp"><span>'.$r['country'].', '.$r['city'].'</span></div>
                            <div class="table-td-exp"><span>'.$r['counter'].'</span></div>
                            <div class="table-td-title"> <form action="" method="post">
                                                 <div class="block-manage">
                     '.$bth.'
                          
                            
                                    </div>
                                    
                                    
                                    </form></div>
                        </div>
                        ';

                    }

                } else {
                    $html .= '<span>Компании не найдены</span>';
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

        if (isset($_POST['MODULE_GET_JOB_CLOSE_LIST']) && $_POST['MODULE_GET_JOB_CLOSE_LIST'] == 1) {

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
                            <div><a class="table-td-a" target="_blank" href="/admin/info-companys/?id='.$r['company_id'].'">'.mb_strimwidth($r['company'], 0, 35, "...").'</a></div>
                            <div class="table-td-exp"><span>'.$r['views'].'</span></div>
                            <div class="table-td-exp"><span>'.$app->rowCount("SELECT * FROM `respond` WHERE `job_id` = :id", [':id' => $r['id']]).'</span></div>
                            <div class="table-td-exp"><span>'.$r['trash'].'</span></div>
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

        if (isset($_POST['MODULE_GET_JOB_LIST']) && $_POST['MODULE_GET_JOB_LIST'] == 1) {

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
                $where = addWhere($where, "`status` = 0");
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
                            <div><a class="table-td-a" target="_blank" href="/admin/info-companys/?id='.$r['company_id'].'">'.mb_strimwidth($r['company'], 0, 35, "...").'</a></div>
                            <div class="table-td-exp"><span>'.$r['views'].'</span></div>
                            <div class="table-td-exp"><span>'.$app->rowCount("SELECT * FROM `respond` WHERE `job_id` = :id", [':id' => $r['id']]).'</span></div>
                            <div class="table-td-exp"><span>'.$r['address'].'</span></div>
                            <div class="table-td-title"> <form action="" method="post">
                                                 <div class="block-manage">
                     
                  
                                          <a title="Статистика" target="_blank" class="manage-bth-mini" target="_blank" href="/admin/info-jobs?id='.$r['id'].'"><i class="icon-pie-chart"></i></a>

                                          <a title="Изменить" target="_blank" class="manage-bth-mini" href="/admin/edit-jobs?id='.$r['id'].'&act='.$r['company_id'].'"><i class="icon-pencil"></i></a>

                                          <button title="Закрыть" name="" class="manage-bth-mini" type="button"><i class="icon-ban"></i></button>

                                    
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

        if (isset($_POST['MODULE_GET_STUDENT_LIST']) && $_POST['MODULE_GET_STUDENT_LIST'] == 1) {

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

                if ($col == 2) $col = "`surname`";
                else if ($col == 3) $col = "`faculty`";
                else $col = "`id`";

                $where = "";

                if ($key != null) $where = addWhere($where, "
                    `name` LIKE '%$key%' OR 
                    `surname` LIKE '%$key%' OR 
                    `email` LIKE '%$key%' OR 
                    `id` LIKE '%$key%' OR 
                    `category` LIKE '%$key%' OR 
                    `prof` LIKE '%$key%' OR
                    `faculty` LIKE '%$key%' OR
                    `direction` LIKE '%$key%'
                ");
                $sql = "SELECT * FROM `users`";
                $sql2 = "SELECT * FROM `users`";
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
                            <div><a class="table-td-a" target="_blank" href="/admin/info-students?id='.$r['id'].'">'.$r['surname'].' '.$r['name'].'</a></div>
                            <div class="table-td-exp"><span>'.mb_strimwidth($r['faculty'], 0, 40, "...").'</span></div>
                            <div class="table-td-exp"><span>'.mb_strimwidth($r['prof'], 0, 40, "...").'</span></div>
                            <div class="table-td-exp"><span>'.$r['phone'].'</span></div>
                            <div class="table-td-exp"><span>'.$app->rowCount("SELECT * FROM `respond` WHERE `user_id` = :id", [':id' => $r['id']]).'</span></div>
                            <div class="table-td-title"> <form action="" method="post">
                                                 <div class="block-manage">
                     
                                    <a title="Найстройки" target="_blank" class="manage-bth-mini" target="_blank" href="/admin/info-students?id='.$r['id'].'"><i class="icon-settings"></i></a>
                                    
                                    
                                    <button title="Забанить" onclick="" class="manage-bth-mini" type="button"><i class="icon-ban"></i></button>
                                    
                                    
                                    </div>
                                    
                                    
                                    </form></div>
                        </div>
                        ';

                    }

                } else {
                    $html .= '<span>Студенты не найдены</span>';
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

        if (isset($_POST['MODULE_GET_COMPANY_LIST']) && $_POST['MODULE_GET_COMPANY_LIST'] == 1) {

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

                if ($col == 2) $col = "`name`";
                else if ($col == 3) $col = "`job`";
                else $col = "`id`";

                $where = "";

                if ($key != null) $where = addWhere($where, "`name` LIKE '%$key%' OR `username` LIKE '%$key%' OR `id` LIKE '%$key%' OR `id` LIKE '%$key%' OR `specialty` LIKE '%$key%'");
                $sql = "SELECT * FROM `company`";
                $sql2 = "SELECT * FROM `company`";
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
                            <div><a class="table-td-a" target="_blank" href="/admin/info-companys/?id='.$r['id'].'">'.mb_strimwidth($r['name'], 0, 26, "...").'</a></div>
                            <div class="table-td-exp"><span>'.$r['username'].'</span></div>
                            <div class="table-td-exp"><span>'.$r['phone'].'</span></div>
                            <div class="table-td-exp"><span>'.$app->rowCount("SELECT * FROM `vacancy` WHERE `company_id` = :id", [':id' => $r['id']]).'</span></div>
                            <div class="table-td-exp"><span>'.$app->rowCount("SELECT * FROM `respond` WHERE `company_id` = :id", [':id' => $r['id']]).'</span></div>
                            <div class="table-td-title"> <form action="" method="post">
                                                 <div class="block-manage">
                     
                                    <a title="Найстройки" target="_blank" class="manage-bth-mini" target="_blank" href="/admin/info-companys?id='.$r['id'].'"><i class="icon-settings"></i></a>
                                    
                                    
                                    <button title="Забанить" onclick="" class="manage-bth-mini" type="button"><i class="icon-ban"></i></button>
                                    
                                    
                                    </div>
                                    
                                    
                                    </form></div>
                        </div>
                        ';

                    }

                } else {
                    $html .= '<span>Компании не найдены</span>';
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

        if (isset($_POST['MODULE_CREATE_COMPANY']) && $_POST['MODULE_CREATE_COMPANY'] == 1) {
            $err = [];

            if (empty($_POST['inn']) or trim($_POST['inn']) == '') $err['inn'] = 'Введите ИНН';
            //if (empty($_POST['username']) or trim($_POST['username']) == '') $err['username'] = 'Введите контактное лицо';
            if (empty($_POST['type']) or trim($_POST['type']) == '') $err['type'] = 'Укажите тип компании';
            if (empty($_POST['name']) or trim($_POST['name']) == '') $err['name'] = 'Введите название компании';
            if (empty($_POST['phone']) or trim($_POST['phone']) == '') $err['tel'] = 'Введите телефон';
            if (empty($_POST['email']) or trim($_POST['email']) == '') $err['mail'] = 'Введите email';
            if (empty($_POST['address']) or trim($_POST['address']) == '') $err['address'] = 'Введите город';
            if (strlen ($_POST['password']) < 8) $err[] = $err['password'] = 'Пароль должен быть не меньше 8 символов';

            if (empty($err)) {
                $inn = XSS_DEFENDER($_POST['inn']);
                $type = XSS_DEFENDER($_POST['type']);
                $username = XSS_DEFENDER($_POST['username']);
                $name = preg_replace("'<script[^>]*?>.*?</script>'si", "", $_POST['name']);
                $name = str_replace($xss, "", $name);
                $phone = XSS_DEFENDER($_POST['phone']);
                $email = XSS_DEFENDER($_POST['email']);
                $address = XSS_DEFENDER($_POST['address']);
                $password = XSS_DEFENDER($_POST['password']);

                $r = $app->fetch("SELECT * FROM `company` WHERE `email` = :email", [':email' => $email]);
                $r2 = $app->fetch("SELECT * FROM `users` WHERE `email` = :email", [':email' => $email]);

                if (!empty($r['id']) || !empty($r2['id'])) {
                    $err[] = 'Данная E-mail почта занята';
                } else {

                    $pass_code = md5(md5(random_str(10).time()));

                    //$new_pass = md5(md5($password . $pass_code . $email));

                    $new_pass = password_hash($password . $pass_code, PASSWORD_BCRYPT, [
                        'cost' => 11
                    ]);


                    $app->execute("INSERT INTO `company` (`username`, `inn`, `verified`, `code`, `type`, `name`, `phone`, `email`, `password`, `date`, `address`) 
                                                VALUES(:unm, :inn, :ver, :code, :typ, :uname, :phone, :email, :passwor, :d, :ad)", [
                        ':unm' => $username,
                        ':inn' => $inn,
                        ':ver' => 1,
                        ':code' => $code,
                        ':typ' => $type,
                        ':uname' => $name,
                        ':phone' => $phone,
                        ':email' => $email,
                        ':passwor' => $new_pass,
                        ':d' => $Date,
                        ':ad' => $address
                    ]);


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

        if (isset($_POST['MODULE_CREATE_STUDENT']) && $_POST['MODULE_CREATE_STUDENT'] == 1) {

            $err = [];

            if (empty($_POST['name']) or trim($_POST['name']) == '') $err['name'] = 'Введите имя';
            if (empty($_POST['surname']) or trim($_POST['surname']) == '') $err['surname'] = 'Введите фамилию';
            if (empty($_POST['patronymic']) or trim($_POST['patronymic']) == '') $err['patronymic'] = 'Введите отчество';
            if (empty($_POST['prof']) or trim($_POST['prof']) == '') $err['prof'] = 'Введите профессию';
            if (empty($_POST['email']) or trim($_POST['email']) == '') $err['email'] = 'Введите email';
            if (empty($_POST['phone']) or trim($_POST['phone']) == '') $err['tel'] = 'Введите телефон';
            if (empty($_POST['faculty']) or trim($_POST['faculty']) == '') $err['faculty'] = 'Укажите факультет';
            if (empty($_POST['direction']) or trim($_POST['direction']) == '') $err['direction'] = 'Укажите направление';
            if (empty($_POST['degree']) or trim($_POST['degree']) == '') $err['degree'] = 'Укажите текущее образование';
            if (strlen ($_POST['password']) < 8) $err[] = $err['password'] = 'Пароль должен быть не меньше 8 символов';

            if (empty($err)) {
                $name = XSS_DEFENDER($_POST['name']);
                $surname = XSS_DEFENDER($_POST['surname']);
                $patronymic = XSS_DEFENDER($_POST['patronymic']);
                $email = XSS_DEFENDER($_POST['email']);
                $phone = XSS_DEFENDER($_POST['phone']);
                $phone = phone_format($phone);
                $password = XSS_DEFENDER($_POST['password']);
                $faculty = XSS_DEFENDER($_POST['faculty']);
                $direction = XSS_DEFENDER($_POST['direction']);
                $degree = XSS_DEFENDER($_POST['degree']);
                $prof = XSS_DEFENDER($_POST['prof']);

                $r = $app->fetch("SELECT * FROM `users` WHERE `email` = :email", [':email' => $email]);
                $r2 = $app->fetch("SELECT * FROM `company` WHERE `email` = :email", [':email' => $email]);

                if (!empty($r['id']) || !empty($r2['id'])) {
                    $err['email'] = 'Данная email почта занята';
                    echo json_encode(array(
                        'error' => $err,
                        'code' => 'validate_error',
                    ));
                } else {

                    $p = $app->fetch("SELECT * FROM `users` WHERE `phone` = :phone", [':phone' => $phone]);


                    if (!empty($p['id'])) {
                        $err['phone'] = 'Данный номер телефона занят';
                        echo json_encode(array(
                            'error' => $err,
                            'code' => 'validate_error',
                        ));
                    } else {

                        $pass_code = md5(md5(random_str(10).time()));

                        //$new_pass = md5(md5($password . $pass_code . $name));

                        $new_pass = password_hash($password . $pass_code, PASSWORD_BCRYPT, [
                            'cost' => 11
                        ]);

                        $app->execute("INSERT INTO `users` (`prof`, `phone`, `name`, `surname`, `email`, `password`, `faculty`, `direction`, `date`, `degree`, `code`, `patronymic`) 
                        VALUES(:prof, :tel, :uname, :surname, :email, :password, :faculty, :direction, :d, :degre, :cod, :pat)", [
                            ':prof' => $prof,
                            ':tel' => $phone,
                            ':uname' => $name,
                            ':surname' => $surname,
                            ':email' => $email,
                            ':password' => $new_pass,
                            ':faculty' => $faculty,
                            ':direction' => $direction,
                            ':d' => $Date,
                            ':degre' => $degree,
                            ':cod' => $pass_code,
                            ':pat' => $patronymic
                        ]);

                        SENDMAIL($mail, "Регистрация", $email, $name . ' ' . $surname, '
Здравствуйте! Ставропольский ГАУ зарегистрировал Вас на платформе <a target="_blank" href="stgaujob.ru">СтГАУ Агрокадры</a>
Платформа Вам найти подходящую работу и трудоустроиться
Данные от Вашего аккаунта:
Ваш логин: ' . $email . '
Ваш пароль: ' . $password . '
<a style="margin: 16px 0 0 0;
font-size: 14px;font-weight: 400;cursor: pointer;padding: 6px 21px;border: 0;
border-radius: 3px;transition: all 0.2s linear;outline: none;color: #fff;box-shadow: 0 4px 20px rgb(0 0 0 / 10%);
background-color: #1967D2;
background-clip: padding-box;border-color: #1967D2;position: relative;text-decoration: none;
display: inline-block;"
 class="go-bth" href="http://stgaujob.ru/">
Платформа</a>    
                        ');

                        echo json_encode(array('code' => 'success'));
                    }

                }

            } else {
                echo json_encode(array(
                    'error' => $err,
                    'code' => 'validate_error',
                ));
            }
        }

        if (isset($_POST['MODULE_CREATE_JOB']) && $_POST['MODULE_CREATE_JOB'] == 1) {



            $err = [];

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
            //if (empty($_POST['username']) || trim($_POST['username']) == '') $err['username'] = 'Введите контактное лицо';
            if (empty($_POST['email']) || trim($_POST['email']) == '') $err['email'] = 'Введите  email';
            if (empty($_POST['phone']) || trim($_POST['phone']) == '') $err['tel'] = 'Введите  телефон';
            if (empty(strip_tags($_POST['text'])) || trim(strip_tags($_POST['text'])) == '') $err['text'] = 'Введите текст';
            if (empty($_POST['exp']) || trim($_POST['exp']) == '') $err['exp'] = 'Укажите опыт работы';
            if (empty($_POST['time']) || trim($_POST['time']) == '') $err['time'] = 'Укажите график работы';
            if (empty($_POST['job_type']) || trim($_POST['job_type']) == '') $err['job_type'] = 'Укажите тип занятости';
            if (empty($_POST['category']) || trim($_POST['category']) == '') $err['category'] = 'Укажите сферу деятельности';


            if (empty($err)) {


                $r = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);


                if (!empty($r['id'])) {


                    $title = XSS_DEFENDER($_POST['title']);
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

                    $company = '';

                    if (($_POST['name_2'] > 0 && !isset($_POST['name_1']) || trim($_POST['name_1']) == '')) {
                        $company = $_POST['name_2'];
                        $r = $app->fetch("SELECT * FROM `company` WHERE `id` = :n", [':n' => intval($company)]);
                        $app->execute("UPDATE `company` SET `job` = `job` + 1 WHERE `id` = :i", [
                            ':i' => $r['id']
                        ]);
                        $id = $r['id'];
                    } else {
                        preg_replace("'<script[^>]*?>.*?</script>'si", "", $_POST['name_1']);
                        $company  = str_replace($xss, "", $company );
                        $id = 0;
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

                    $hour = date("H:i");

                    $c = $app->fetch("SELECT * FROM `category` WHERE `name` = :n", [':n' => $_POST['category']]);

                    $reg = $app->fetch("SELECT * FROM `map_list` WHERE `name` = :d", [':d' => $_POST['region']]);

                    $app->execute("INSERT INTO `vacancy` (`go`, `times`, `timses`, `contact`, 
                       `salary_end`, `title`, `category_id`, `degree`, `area`, `type`, `invalid`, 
                       `company`, `task`, `text`, `date`, `time`, `region`, `district`, `address`, 
                       `phone`, `email`, `category`, `company_id`, `img`, `salary`, `exp`, `urid`, `admin`)
            VALUES(:goo, NOW(), :tims, :contc, :saled, :t, :ccs, :deg, :ar, :jb, :inv, :cd, :tas, :cnt, :d, 
                   :tim, :reg, :dist, :addres, :phone, :email, :category, :c_i, :im, :sal, :exp, :urid, :adm)", [
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
                        ':cd' => $company,
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
                        ':c_i' => $id,
                        ':im' => 'placeholder.png',
                        ':sal' => $salary,
                        ':exp' => $exp,
                        ':urid' => $urid,
                        ':adm' => 1
                    ]);

                    $app->execute("UPDATE `map_list` SET `job` = `job` + 1 WHERE `id` = :id", [
                        ':id' => $reg['id']
                    ]);

                    $app->execute("UPDATE `map` SET `job` = `job` + 1 WHERE `id` = :id", [
                        ':id' => $reg['map_id']
                    ]);

                    $app->execute("UPDATE `category` SET `job` = `job` + 1 WHERE `name` = :i", [
                        ':i' => $c['name']
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
            } else {
                echo json_encode(array(
                    'error' => $err,
                    'code' => 'validate_error',
                ));
                exit;
            }

        }

        if (isset($_POST['ip']) && $_POST['MODULE_ADD_BLACK'] == 1) {
            if (trim($_POST['ip']) != '') {

                $app->execute("INSERT INTO `black_list` (`ip`, `time`) VALUES(:ip, NOW())", [
                    ':ip' => XSS_DEFENDER(trim($_POST['ip']))
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

        if (isset($_POST['ip']) && $_POST['MODULE_REMOVE_BLACK'] == 1) {
            if (trim($_POST['ip']) != '') {

                $app->execute("DELETE FROM `black_list` WHERE `ip` = :ip", [
                    ':ip' => XSS_DEFENDER(trim($_POST['ip']))
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

        if (isset($_POST['id']) && $_POST['MODULE_CHECKED'] == 1) {
            if (intval($_POST['id']) > 0) {

                $app->execute("UPDATE `company` SET `verified` = 1 WHERE `id` = :id", [
                    ':id' => intval($_POST['id'])
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

        if (isset($_POST['MODULE_GET_COMPANY_STUDENT']) && $_POST['MODULE_GET_COMPANY_STUDENT'] == 1) {
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
                $companyId = (isset($_POST['cid'])) ? (int) $_POST['cid'] : null;

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
                    'cid' => $companyId
                );
            }

            function getData($options, $PDO, $app) {

                $salary = intval($options['salary']);
                $id = intval($options['id']);
                $exp = $options['exp'];
                $gender = $options['gender'];
                $key = $options['key'];
                $loc = intval($options['loc']);
                $companyId = (int) $options['cid'];
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
                    $where = addWhere($where, "`company_id` = $companyId");
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




                                if (trim($data['text']) != '') {
                                    $letter_t = '<div class="re-200-mini">Сопроводительное письмо: ' . $data['text'] . '</div>';
                                }


                                $click = "$('.item-$data[id]').slideToggle(100);$(this).toggleClass('resp-rotate');$('.respond-item-$data[id]').toggleClass('item-active')";
                                $list .= '
                            <div class="respond-item respond-item-'.$data['id'].'">
                                <div class="resp-top">
                                    <div class="re-name">
                                        <a target="_blank" href="/admin/info-students?id='.$r['id'].'">'.$r['name'] . ' ' . $r['surname'].' - '.$r['prof'].' </a>
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

        if (isset($_POST['MODULE_GET_COMPANY_JOB']) && $_POST['MODULE_GET_COMPANY_JOB'] == 1)  {
            $exp = (isset($_POST['exp'])) ? $_POST['exp'] : null;
            $cid = (isset($_POST['cid'])) ? $_POST['cid'] : null;
            $time = (isset($_POST['time'])) ? $_POST['time'] : null;
            $type = (isset($_POST['type'])) ? $_POST['type'] : null;
            $alive = (isset($_POST['alive'])) ? (int) $_POST['alive'] : 0;
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
            $where = addWhere($where, "`company_id` = $cid");
            $sql = "SELECT * FROM `vacancy`";
            $sql2 = "SELECT * FROM `vacancy`";
            if ($where) {
                $sql .= " WHERE $where";
                $sql2 .= " WHERE $where";
            }

            if ($sort != null) {
                if ($sort == 1) {
                    if ($sql == "SELECT * FROM `vacancy`") {
                        $sql .= " WHERE `status` = $alive ORDER BY `id` DESC LIMIT $start, $limit";
                        $sql2 .= " WHERE `status` = $alive ORDER BY `id` DESC";
                    } else {
                        $sql .= " AND `status` = $alive ORDER BY `id` DESC LIMIT $start, $limit";
                        $sql2 .= " AND `status` = $alive ORDER BY `id` DESC";
                    }
                }
                if ($sort == 2) {
                    if ($sql == "SELECT * FROM `vacancy`") {
                        $sql .= " WHERE `status` = $alive ORDER BY `views` DESC LIMIT $start, $limit";
                        $sql2 .= " WHERE `status` = $alive ORDER BY `views` DESC";
                    } else {
                        $sql .= " AND `status` = $alive ORDER BY `views` DESC LIMIT $start, $limit";
                        $sql2 .= " AND `status` = $alive ORDER BY `views` DESC";
                    }
                }
            } else {
                if ($sql == "SELECT * FROM `vacancy`") {
                    $sql .= " WHERE `status` = $alive ORDER BY `id` DESC LIMIT $start, $limit";
                    $sql2 .= " WHERE `status` = $alive ORDER BY `id` DESC";
                } else {
                    $sql .= " AND `status` = $alive ORDER BY `id` DESC LIMIT $start, $limit";
                    $sql2 .= " AND `status` = $alive ORDER BY `id` DESC";
                }
            }

            $people = [];


            $sql_2 = $app->query($sql);
            while ($r = $sql_2->fetch()) {
                $people[] = $app->count("SELECT * FROM `online_job` WHERE `job` = $cid");
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

                    $button = '';

                    if ($alive == 0) {
                        $button = ' <button onclick="deleteVac('.$r['id'].', '."'$r[title]'".')" type="button" class="lock-vacancy"><i class="mdi mdi-delete"></i></button>';
                    }

                    $arc = '';
                    if ($alive == 1) {
                        $arc = "<span class='re-trash'>Вакансия в архиве с " . $r['trash'] . "</span>";
                    }

                    $earlier = new DateTime($Date);
                    $later = new DateTime($r['task']);
                    $list .= '
                 <li class="">
                   
                     <div class="vac-name">
                     
                    '.$button.'
                     
                     
                      ' . ($people[$i] > 0 ? '<span class="resume-stat">Сейчас просматривают ' . $people[$i] . '</span>' : '') . '
                  
                        <a target="_blank" href="/job/?id=' . $r['id'] . '">' . $r['title'] . '</a>
                        '.$arc.'
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
                            <a target="_blank" href="/admin/info-jobs/?id='.$r['id'].'"><i class="mdi mdi-finance"></i> Статистика</a>
                            <a target="_blank" href="/admin/edit-jobs/?id='.$r['id'].'&act='.$r['company_id'].'"><i class="mdi mdi-pencil"></i> Изменить</a>
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
                    'sql' => $sql,
                    'limit' => $limit,
                    'http' => $_SERVER['HTTP_REFERER']
                )
            ));
            exit;
        }

        if (isset($_POST['MODULE_SAVE_COMPANY']) && $_POST['MODULE_SAVE_COMPANY'] == 1) {

            $id = (int) $_POST['cid'];

            $row = $app->rowCount("SELECT * FROM `company` WHERE `id` = :id", [':id' => $id]);

            if ($row > 0) {
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
                        ':id' => $id
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
            } else {
                echo json_encode(array(
                    'code' => 'none_error',
                ));
            }


        }

        if (isset($_POST['MODULE_SAVE_STUDENT']) && $_POST['MODULE_SAVE_STUDENT'] == 1) {

            $id = (int) $_POST['uid'];

            $row = $app->rowCount("SELECT * FROM `users` WHERE `id` = :id", [':id' => $id]);

            if ($row > 0) {

                $err = [];


                if (empty($_POST['prof']) || trim($_POST['prof']) == '') $err['prof'] = 'Это поле не должно быть пустым';
                if (empty($_POST['name']) || trim($_POST['name']) == '') $err['name'] = 'Это поле не должно быть пустым';
                if (empty($_POST['surname']) || trim($_POST['surname']) == '') $err['surname'] = 'Это поле не должно быть пустым';
                if (empty($_POST['patronymic']) || trim($_POST['patronymic']) == '') $err['patronymic'] = 'Это поле не должно быть пустым';
                if (empty($_POST['date-1']) || intval($_POST['date-1']) <= 0 || intval($_POST['date-1']) > 31) $err['date-1'] = 'Некорректная дата';
                if (empty($_POST['date-2']) || intval($_POST['date-2']) <= 0 || intval($_POST['date-2']) > 12) $err['date-2'] = 'Некорректная дата';
                if (empty($_POST['date-3']) || $_POST['date-3'] < 1900 || intval($_POST['date-3']) > intval(date('Y'))) $err['date-3'] = 'Некорректная дата';
                if (empty($_POST['gender']) || trim($_POST['gender']) == '') $err['gender'] = 'Это поле не должно быть пустым';
                if (empty($_POST['faculty']) || trim($_POST['faculty']) == '') $err['faculty'] = 'Это поле не должно быть пустым';
                if (empty($_POST['direction']) || trim($_POST['direction']) == '') $err['direction'] = 'Это поле не должно быть пустым';
                if (empty($_POST['degree']) || trim($_POST['degree']) == '') $err['degree'] = 'Это поле не должно быть пустым';

                if (empty($err)) {

                    $name = XSS_DEFENDER($_POST['name']);
                    $surname = XSS_DEFENDER($_POST['surname']);
                    $patronymic = XSS_DEFENDER($_POST['patronymic']);
                    $faculty = XSS_DEFENDER($_POST['faculty']);
                    $direction = XSS_DEFENDER($_POST['direction']);
                    $degree = XSS_DEFENDER($_POST['degree']);
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

                    $ch = $app->rowCount("SELECT * FROM `chat` WHERE `user_id` = :id", [':id' => $id]);

                    if ($ch > 0) {
                        $app->execute("UPDATE `chat` SET `user` = :nm WHERE `user_id` = :id", [
                            ':nm' => $name . ' ' . $surname,
                            ':id' => $id
                        ]);
                    }

                    $app->execute("UPDATE `users` SET 
                `about` = :about,
                `stat` = :stat,
                `type` = :typ,
                `name` = :nam,
                `surname` = :surname,
                `patronymic` = :patronymic,
                `faculty` = :faculty,
                `direction` = :direction,
                `degree` = :degree,
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
                `skype` = :skype WHERE `id` = :id", [
                        ':about' => $about,
                        ':stat' => $stat,
                        ':typ' => $type,
                        ':nam' => $name,
                        ':surname' => $surname,
                        ':patronymic' => $patronymic,
                        ':faculty' => $faculty,
                        ':direction' => $direction,
                        ':degree' => $degree,
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
                        ':id' => $id
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

            } else {
                echo json_encode(array(
                    'code' => 'none_error',
                ));
                exit;
            }



        }

        if (isset($_POST['MODULE_EDIT_JOB']) && $_POST['MODULE_EDIT_JOB'] == 1) {

            $id = (int) $_POST['job'];
            $cid = (int) $_POST['cid'];

            $row = $app->rowCount("SELECT * FROM `vacancy` WHERE `id` = :id", [':id' => $id]);

            if ($row > 0) {
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



                if (empty($err)) {

                    $r = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $cid]);

                    $job = $app->fetch("SELECT * FROM `vacancy` WHERE `id` = :id AND `company_id` = :ci", [
                        ':id' => $id,
                        ':ci' => $cid
                    ]);

                    if (!empty($r['id']) && !empty($job['id'])) {
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

            } else {
                echo json_encode(array(
                    'code' => 'none_error',
                ));
                exit;
            }





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