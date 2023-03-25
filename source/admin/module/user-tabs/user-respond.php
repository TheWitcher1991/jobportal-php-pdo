<div class="stat-wp">

    <span class="mp-span" style="padding: 0 0 20px 0;">Статусы откликов</span>

    <div class="block-status">




        <a>
            <i class="mdi mdi-alert-decagram-outline"></i>
            На рассмотрении (<?php echo $app->count("SELECT * FROM `respond` WHERE `status` = 0 AND `user_id` = '$_GET[id]'"); ?>)</a>

        <a>
            <i class="mdi mdi-phone-in-talk-outline"></i>
            Разговор по телефону (<?php echo $app->count("SELECT * FROM `respond` WHERE `status` = 2 AND `user_id` = '$_GET[id]'"); ?>)</a>

        <a>
            <i class="mdi mdi-head-question-outline"></i>
            Собеседование (<?php echo $app->count("SELECT * FROM `respond` WHERE `status` = 3 AND `user_id` = '$_GET[id]'"); ?>)</a>

        <a>
            <i class="mdi mdi-hand-wave-outline"></i>
            Принят на работу (<?php echo $app->count("SELECT * FROM `respond` WHERE `status` = 4 AND `user_id` = '$_GET[id]'"); ?>)</a>

        <a>
            <i class="mdi mdi-delete-variant"></i>
            Отказ (<?php echo $app->count("SELECT * FROM `respond` WHERE `status` = 5 AND `user_id` = '$_GET[id]'"); ?>)</a>


    </div>

</div>

<div class="manage-profile-block">
    <div class="block-table">
        <table class="default-table">
            <thead>
            <tr>
                <th><span><i class="mdi mdi-pound"></i> Заголовок</span></th>
                <th><span><i class="mdi mdi-clock-time-four-outline"></i> Дата отклика</span></th>
                <th><span><i class="mdi mdi-briefcase-variant-outline"></i> Компания</span></th>
                <th><span><i class="mdi mdi-account-check"></i> Статус</span></th>
                <th><span><i class="mdi mdi-crosshairs-gps"></i> Город</span></th>
                <th><span><i class="mdi mdi-button-pointer"></i> Действия</span></th>
            </tr>
            </thead>
            <tbody>
            <?php

            $results_per_page = 20;

            $number_of_results = (int)$app->count("SELECT * FROM `respond` WHERE `user_id` = $user[id]");

            $number_of_pages = ceil($number_of_results / $results_per_page);

            if (!isset($_GET['page'])) {
                $pag = 1;
            } else {
                $pag = $_GET['page'];
            }

            $this_page_first_result = ($pag - 1) * $results_per_page;


            $count = 0;
            $sql = $app->query("SELECT * FROM `respond` WHERE `user_id` = $user[id] ORDER BY `id` DESC LIMIT $this_page_first_result, $results_per_page");
            while ($rr = $sql->fetch()) {
                $count = $count + 1;

                $job = $app->fetch("SELECT * FROM `vacancy` WHERE `id` = :id", [':id' => $rr['job_id']]);


                if ($rr['status'] == 0 || $rr['status'] == 1) {
                    $st = 'На рассмотрении';
                } else if ($rr['status'] == 2) {
                    $st = 'Разговор по телефону';
                } else if ($rr['status'] == 3) {
                    $st = 'Назначена встреча';
                } else if ($rr['status'] == 4) {
                    $st = 'Принят на работу';
                } else if ($rr['status'] == 5) {
                    $st = 'Отказано';
                } else if ($rr['status'] == 6) {
                    $st = 'Приглашение';
                } else {
                    $st = ' Не определён';
                }

                $stext = '';

                if ($rr['status'] == 0 || $rr['status'] == 1 || $rr['status'] == 2 || $rr['status'] == 3 || $rr['status'] == 4) {
                    $stext = '<span class="status-yes">'.$st.'</span>';
                } else if ($rr['status'] == 5) {
                    $stext =  '<span class="status-none">'.$st.'</span>';
                } else if ($rr['status'] == 6) {
                    $stext = '<span class="status-yes">'.$st.'</span>';
                } else {
                    $stext = '<span class="status-unf">Не определён</span>';
                }

                $remsg = $app->fetch("SELECT * FROM `respond_message` WHERE `job` = :ji AND `user` = :ui AND `type` = :st",
                    [
                        ':ji' => $job['id'],
                        ':ui' => $user['id'],
                        ':st' => $rr['status']
                    ]);

                $linkmsg = $app->fetch("SELECT * FROM `respond_message` WHERE `company` = :ji AND `user` = :ui AND `type` = :st",
                    [
                        ':ji' => $rr['company'],
                        ':ui' => $user['id'],
                        ':st' => 6
                    ]);

                $pop = '';

                $c = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $rr['company']]);

                if (isset($remsg['id'])) {
                    $pop = '
                                        <div class="sp-stat">
                                            '.($rr['status'] == 2 ? $job['company'] . ' назначила телефонную беседу' : '').'
                                            '.($rr['status'] == 3 ? 'Поздравляем! ' . $job['company'] . ' назначила собеседование' : '').'
                                            '.($rr['status'] == 4 ? 'Поздравляем! ' . $job['company'] . ' готова принять студента на работу' : '').'
                                            '.($rr['status'] == 5 ? 'К сожалению, ' . $job['company'] . ' отказала в кандидатуре' : '').'
                                        </div>
                                        <div class="text-stat">
                                        '.(trim($remsg['text']) != '' ? $remsg['text'] : 'Компания не оставила сообщения').'
                                        </div>
                                        <div class="text-more-s">
                                        
                                        '.($rr['status'] == 2 ? '
                                            <span>День: <m>'.$remsg['text_day'].'</m></span>
                                            <span>Время: <m>'.$remsg['text_time'].'</m></span>
                                        ' : '').'
                                        
                                        '.($rr['status'] == 3 ? '
                                            <span>День: <m>'.$remsg['text_day'].'</m></span>
                                            <span>Время: <m>'.$remsg['text_time'].'</m></span>
                                            <span>Адрес: <m>'.$remsg['text_address'].'</m></span>
                                        ' : '').'
                                        
                                        </div>
                                        
                                        ';
                } else {
                    $pop = '
                                        <div class="sp-stat">
                                            На данный момент '.$job['company'].' не совершила с откликом никаких действий.
                                        </div>
                                        <div class="text-stat">
                                            Скорее всего компания сейчас рассматривает кандидатуру. (Данная система не отображает полноту картины — она является условной. Компания может не сортировать отклики и не отправлять сообщения через нашу системy)
                                        </div>
                                        ';
                }

                ?>

                <script>
                    function infoVac_<?php echo $rr['id'] ?>() {
                        document.querySelector("body").innerHTML += `

<div id="auth" style="display:flex">
    <div class="contact-wrapper" style="display:block">
        <div class="auth-respond auth-log" style="display:block">
             <div class="auth-title">
                Отклик
                <i class="mdi mdi-close" onclick="deleteForm()"></i>
             </div>
             <div class="auth-form">

                <?php if ($rr['status'] >= 0 && $rr['age'] != 1 && $rr['status'] <= 5) { ?>

                <span><i class="icon-user"></i> <?php echo $user['name'] . ' ' . $user['surname']; ?></span>
                <span><i class="icon-briefcase"></i> <?php echo $job['title']; ?></span>
                    <?php echo $pop; ?>
                <div class="re-flex">
                    <span class="re-300">Обновлено <?php echo $job['last_up']; ?>,</span>

                    <span class="re-300">Откликнулись <?php echo $rr['time']; ?></span>
                </div>
                <div style="margin:0" class="re-flex-2">
                     <span><i class="mdi mdi-phone"></i> <?php echo $job['phone']; ?></span>
                     <span><i class="mdi mdi-at"></i> <?php echo $job['email']; ?></span>
                     <span><i class="mdi mdi-account"></i> <?php echo $job['contact']; ?></span>
                </div>

                <?php } else if ($rr['status'] == 6) { ?>

                <span><i class="icon-user"></i> <?php echo $user['name'] . ' ' . $user['surname']; ?></span>
                <span><i class="icon-briefcase"></i> Приглашение от компании</span>

                     <div class="sp-stat">
                     <?php echo $c['name']; ?> пригласила студента к себе на работу
                     </div>

                    <div class="text-stat">
                          <?php
                        if (trim($linkmsg['text']) != '')  {
                            echo $linkmsg['text'];
                        } else {
                            echo "Компания не оставила сообщения";
                        }

                        ?>
                    </div>

                    <div class="re-flex">
                        <span class="re-300">Создано <?php echo $rr['date'] . ' ' . $rr['hour']; ?>
                    </span>

                </div>

                <?php } else { ?>


                    Что-то пошло не так!


                <?php } ?>
             </div>
        </div>
    </div>
</div>

    `;
                    }

                </script>

                <tr class="resume-<?php echo $count ?>">
                    <td class="tb-title"><a target="_blank" href="/job?id=<?php echo $rr['job_id'] ?>">
                            <?php
                            if ($rr['status'] != 6) {
                                echo  mb_strimwidth($rr['job'], 0, 30, "...");
                            } else {
                                echo "От " . $rr['company'];
                            }

                            ?>
                        </a></td>
                    <td class="tb-date"><?php echo $rr['date'] ?></td>
                    <td class="tb-cat"><a target="_blank" href="/company?id=<?php echo $job['company_id'] ?>"><?php echo $job['company'] ?></a></td>
                    <td class="tb-date"><?php echo $stext ?></td>
                    <td class="tb-cat"><a target="_blank" href="/job-list?loc=<?php echo $job['address'] ?>"><?php echo $job['address'] ?></a></td>
                    <td class="tb-form">
                        <form action="" method="post">
                            <div class="block-manage">

                                <button onclick="infoVac_<?php echo $rr['id'] ?>()" class="manage-bth-mini" type="button"><i class="icon-info"></i></button>


                            </div>
                        </form>
                    </td>
                </tr>

                <?php

            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="table-paginator">
        <div class="tp-1">
            <span class="tp-now"><?php echo $pag ?></span> из <span class="tp-total"><?php echo $number_of_pages ?></span>
        </div>
        <div class="tp-2">
            <?php
            echo $paginator->table($pag, $number_of_results, 15, '/admin/info-students?id='.$user['id'].'&t=4&page=');
            ?>
        </div>
    </div>
</div>