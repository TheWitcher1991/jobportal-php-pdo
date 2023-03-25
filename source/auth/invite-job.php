<?php


if (isset($_SESSION['id']) && isset($_SESSION['password']) && $_SESSION['type'] == 'company') {

    $r = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $_SESSION['id']]);

    if (empty($r['id'])) {
        $app->notFound();
    }

    $uid = (int) $_GET['id'];

    $user = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $uid]);

    if (empty($user['id'])) {
        $app->notFound();
    }

    Head('Пригласить студента — ' . $user['name'] . ' ' . $user['surname']);

?>
<body class="profile-body">



<main class="wrapper wrapper-profile" id="wrapper">

    <?php require('template/more/profileAside.php'); ?>



    <section class="profile-base">

        <?php require('template/more/profileHeader.php'); ?>


        <div class="profile-content create-resume">

            <div class="section-nav-profile">
                <span><a href="/profile">Профиль</a></span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span><a href="/invite-job">Пригласить студента — <?php echo $user['name'] . ' ' . $user['surname'] ?></a></span>
            </div>


            <div class="errors-block">

            </div>

            <div class="errors-block-fix">

            </div>


            <div class="create-resume-data profile-data">

                <div class="user-block">

                    <?php

                    $sqled = "SELECT * FROM `exp` WHERE `user_id` = :t";
                    $stmted = $PDO->prepare($sqled);
                    $stmted->bindValue(':t', $user['id']);
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
                    $stmted->bindValue(':t', $user['id']);
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
                    $stmtsk->bindValue(':t', (int) $user['id']);
                    $stmtsk->execute();
                    if ($stmtsk->rowCount() > 0) {
                        $exp .= '<div class="re-detail">
                                        <span>Знание языков</span>';
                        while ($re = $stmtsk->fetch()) {
                            $exp .= '<div><m>'.$re['name'].' — '.$re['lvl'].'</m></div>';
                        }
                        $exp .= '</div>';
                    }

                    if (trim($user['vk']) != '' || trim($user['telegram']) != '' || trim($user['github']) != '' || trim($user['skype']) != '') {
                        $exp .= '<div class="re-detail">
                                        <span>Ссылки</span>';

                        if (trim($user['vk']) != '') {
                            $exp .= '<div><m>VK — '.$user['vk'].'</m></div>';
                        }

                        if (trim($user['telegram']) != '') {
                            $exp .= '<div><m>Telegram — '.$user['telegram'].'</m></div>';
                        }

                        if (trim($user['github']) != '') {
                            $exp .= '<div><m>GitHub — '.$user['github'].'</m></div>';
                        }

                        if (trim($user['skype']) != '') {
                            $exp .= '<div><m>Skype — '.$user['skype'].'</m></div>';
                        }

                        $exp .= '</div>';
                    }

                    $ctx = '';

                    if (!empty($user['exp'])) {
                        $ctx .= '
                                        <li>
                                            <span>Опыт работы</span>
                                            <span>'.$user['exp'].'</span>
                                        </li>
                                ';
                    }

                    if (!empty($user['degree'])) {
                        $ctx .= '
                                        <li>
                                            <span>Образование</span>
                                            <span>'.$user['degree'].'</span>
                                        </li>
                                ';
                    }

                    if (!empty($user['time'])) {
                        $ctx .= '
                                        <li>
                                            <span>График работы</span>
                                            <span>'.$user['time'].'</span>
                                        </li>
                                ';
                    }

                    if (!empty($user['type'])) {
                        $ctx .= '
                                        <li>
                                            <span>Тип занятости</span>
                                            <span>'.$user['type'].'</span>
                                        </li>
                                ';
                    }

                    if (!empty($user['drive'])) {
                        $ctx .= '
                                        <li>
                                            <span>Водительские права</span>
                                            <span>'.$user['drive'].'</span>
                                        </li>
                                ';
                    }

                    if (!empty($user['age']) && $user['age'] >= 10) {
                        $ctx .= '
                                        <li>
                                            <span>Возраст</span>
                                            <span>'.$user['age'].'</span>
                                        </li>
                                ';
                    }

                    if (!empty($user['gender'])) {
                        $ctx .= '
                                        <li>
                                            <span>Пол</span>
                                            <span>'.$user['gender'].'</span>
                                        </li>
                                ';
                    }

                    $click = "$('.item-lock').slideToggle(100);$(this).toggleClass('resp-rotate');$('.info-item').toggleClass('item-active')";

                    $list = '
                            <div class="respond-item info-item">
                                <div class="resp-top">
                                    <div class="re-name">
                                        <a target="_blank" href="/resume/?id='.$user['id'].'">'.$user['name'] . ' ' . $user['surname'].' - '.$user['prof'].' </a>
                                        <span onclick="'.$click.'"><i class="fa-solid fa-chevron-down"></i></span>
                                    </div>
                                    <span class="re-200">
                                    '. (!empty($user['salary']) ? $user['salary'] . ' руб.' : 'По договорённости' ) . '
                                    </span>
                                </div>
                                <div class="resp-content item-lock">
                                    <ul class="re-ul">
                                        '.$ctx.'
                                    </ul>
                                    '.$exp.'
                                    <div class="re-about">
                                        <pre>'.$user['about'].'</pre>
                                    </div>
                                </div>
                                <div class="re-flex">
                                    <span class="re-300">Обновлено '.$user['last_save'].',</span>
                                  <span class="re-300">Создано '.DateTime::createFromFormat('d.m.Y', $user['date'])->format('d') . ' ' . $monthes_ru[(DateTime::createFromFormat('d.m.Y', $user['date'])->format('n'))]. ' ' . DateTime::createFromFormat('d.m.Y', $user['date'])->format('Y').'</span>
                                </div>
                                <div style="margin: 0;" class="re-flex-2">
                                    <span><i class="mdi mdi-phone"></i> '.$user['phone'].'</span>
                                     <span><i class="mdi mdi-at"></i> '.$user['email'].'</span>
                                </div>
                                <span class="user-resp-img">
                                <img src="/static/image/users/'.$user['img'].'" alt="">
</span>
                            </div>

                            ';


                    echo $list;

                    ?>




                </div>

                <div class="job-block">

                    <div style="margin: 0 0 10px 0;" class="label-b-check">
                        <input onclick="
    let c = document.querySelector('#q2')
                    if (c.checked) {
                        $('.text').removeAttr('disabled')
                    } else {
                        $('.text').val('')
                        $('.text').attr('disabled', 'true')
                        $('.form-respond input, .form-respond textarea').removeClass('errors')
                        $('span.error').hide()
                    }
    " checked type="checkbox" class="custom-checkbox" id="q2" name="notext" value="1">
                        <label for="q2">
                            отправить сообщение
                        </label>
                    </div>
                    <div style="margin: 0 0 10px 0;" class="label-block">
                        <label for="">Сообщение <span>*<span></label>
                        <textarea name="text" class="text" id="text" cols="30" rows="10" style="height:95px;">
Здравствуйте, <?php echo $rr['name'] ?>!
Ваше резюме показалось нам очень интересным...
    </textarea>
                        <span class="error e-text" style="display: none">Введите сообщение</span>
                    </div>


                    <div style="margin: 0 0 10px 0;" class="label-b-check">
                        <input onclick="" checked type="checkbox" class="custom-checkbox" id="q4" name="chaty" value="1">
                        <label for="q4">
                            создать новую ветку чата со студентом по этой вакансии
                        </label>
                    </div>

                    <div class="detail-list-flex-b" style="margin: 0;">
                        <div class="detail list-b-1">
                            <div class="detail-list-vacancy dl-vac">

                                <div class="dl-input-block">
                                    <form role="form" method="GET" class="form-company-vac">
                                        <input class="company-vacancy" type="text" name="key" placeholder="Должность">
                                        <input type="button" class="search-lk" name="search-lk" value="Найти">
                                    </form>
                                </div>
                                <ul style="margin: 20px 0 0 0;" class="vac-list-ul">
                                    <div id="placeholder-main">
                                        <div class="placeholder">
                                            <div style="width: 100%;">
                                                <div class="placeholder-item jx-nav"></div>
                                                <div class="placeholder-item jx-title"></div>
                                                <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                                <div class="mx-flex" style="margin: 0;">
                                                    <div class="placeholder-item mx-flit"></div>
                                                    <div class="placeholder-item mx-flit"></div>
                                                    <div class="placeholder-item mx-flit"></div>
                                                </div>
                                                <div  style="margin: 16px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                                <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                            </div>
                                        </div>
                                        <div class="placeholder">
                                            <div style="width: 100%;">
                                                <div class="placeholder-item jx-nav"></div>
                                                <div class="placeholder-item jx-title"></div>
                                                <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                                <div class="mx-flex" style="margin: 0;">
                                                    <div class="placeholder-item mx-flit"></div>
                                                    <div class="placeholder-item mx-flit"></div>
                                                    <div class="placeholder-item mx-flit"></div>
                                                </div>
                                                <div  style="margin: 16px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                                <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                            </div>
                                        </div>
                                        <div class="placeholder">
                                            <div style="width: 100%;">
                                                <div class="placeholder-item jx-nav"></div>
                                                <div class="placeholder-item jx-title"></div>
                                                <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                                <div class="mx-flex" style="margin: 0;">
                                                    <div class="placeholder-item mx-flit"></div>
                                                    <div class="placeholder-item mx-flit"></div>
                                                    <div class="placeholder-item mx-flit"></div>
                                                </div>
                                                <div  style="margin: 16px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                                <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                            </div>
                                        </div>
                                        <div class="placeholder">
                                            <div style="width: 100%;">
                                                <div class="placeholder-item jx-nav"></div>
                                                <div class="placeholder-item jx-title"></div>
                                                <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                                <div class="mx-flex" style="margin: 0;">
                                                    <div class="placeholder-item mx-flit"></div>
                                                    <div class="placeholder-item mx-flit"></div>
                                                    <div class="placeholder-item mx-flit"></div>
                                                </div>
                                                <div  style="margin: 16px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                                <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                            </div>
                                        </div><div class="placeholder">
                                            <div style="width: 100%;">
                                                <div class="placeholder-item jx-nav"></div>
                                                <div class="placeholder-item jx-title"></div>
                                                <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                                <div class="mx-flex" style="margin: 0;">
                                                    <div class="placeholder-item mx-flit"></div>
                                                    <div class="placeholder-item mx-flit"></div>
                                                    <div class="placeholder-item mx-flit"></div>
                                                </div>
                                                <div  style="margin: 16px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                                <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                            </div>
                                        </div><div class="placeholder">
                                            <div style="width: 100%;">
                                                <div class="placeholder-item jx-nav"></div>
                                                <div class="placeholder-item jx-title"></div>
                                                <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                                <div class="mx-flex" style="margin: 0;">
                                                    <div class="placeholder-item mx-flit"></div>
                                                    <div class="placeholder-item mx-flit"></div>
                                                    <div class="placeholder-item mx-flit"></div>
                                                </div>
                                                <div  style="margin: 16px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                                <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                            </div>
                                        </div>


                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>


            </div>

        </div>

    </section>

</main>

<?php require('template/more/profileFooter.php'); ?>


</body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>
