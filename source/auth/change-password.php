<?php

use Work\plugin\lib\pQuery;

if (isset($_SESSION['id']) && isset($_SESSION['password'])) {

    if ($_SESSION['type'] == 'users') {
        $r = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($r['id'])) {
            $app->notFound();
        }
    } else if ($_SESSION['type'] == 'company') {
        $r = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($r['id'])) {
            $app->notFound();
        }
    } else {
        $app->notFound();
    }

    Head('Сменить пароль');



    /*if (isset($_POST["save-pass-user"])) {
        $err = [];

        $captcha = $_SESSION['captcha'];
        unset($_SESSION['captcha']);
        session_write_close();
        $code = $_POST['captcha'];
        $code = crypt(trim($code), '$1$itchief$7');

        if (empty($_POST['password']) or trim($_POST['password']) == '') $err['password'] = 'Введите свой пароль';
        else if (md5(md5($_POST['password'] . $r['code'] . $r['name'])) != $_SESSION['password']) $err['password'] = 'Вы ввели неверный пароль';
        if (empty($_POST['new_password']) or trim($_POST['new_password']) == '') $err['new_password'] = 'Введите новый пароль';
        if (empty($_POST['lost_password']) or (trim($_POST['new_password']) != trim($_POST['lost_password']))) $err['lost_password'] = 'Пароли не совпадают';
        if (empty($_POST['captcha']) or trim($_POST['captcha']) == '') $err['captcha'] = 'Пожалуйста введите код';
        else if ($captcha != $code)  $err['captcha'] = 'Введенный код не соответствует изображению!';

        if (empty($err)) {

            $password = $_POST['password'];
            $new_password = $_POST['new_password'];
            $captcha = $_POST['captcha'];

            $pass_code = md5(md5(random_str(25)));

            $new_pass = md5(md5($new_password . $pass_code . $r['name']));

            $app->execute("UPDATE `users` SET `password` = :pas AND `code` = :code WHERE `id` = :id", [
                ':pas' => $new_pass,
                ':code' => $pass_code,
                ':id' => $_SESSION['id']
            ]);

            $_SESSION['password'] = $new_pass;

            $success = "Пароль успешно изменен";

        }



    }*/

    /*if (isset($_POST["save-pass-comp"])) {
        $err = [];

        $captcha = $_SESSION['captcha'];
        unset($_SESSION['captcha']);
        session_write_close();
        $code = $_POST['captcha'];
        $code = crypt(trim($code), '$1$itchief$7');

        if (empty($_POST['password']) or trim($_POST['password']) == '') $err['password'] = 'Введите свой пароль';
        else if (md5(md5($_POST['password'] . $r['code'] . $r['name'])) != $_SESSION['password']) $err['password'] = 'Вы ввели неверный пароль';
        if (empty($_POST['new_password']) or trim($_POST['new_password']) == '') $err['new_password'] = 'Введите новый пароль';
        if (empty($_POST['lost_password']) or (trim($_POST['new_password']) != trim($_POST['lost_password']))) $err['lost_password'] = 'Пароли не совпадают';
        if (empty($_POST['captcha']) or trim($_POST['captcha']) == '') $err['captcha'] = 'Пожалуйста введите код';
        else if ($captcha != $code)  $err['captcha'] = 'Введенный код не соответствует изображению!';


            if (empty($err)) {

                $password = $_POST['password'];
                $new_password = $_POST['new_password'];
                $captcha = $_POST['captcha'];


                $pass_code = md5(md5(random_str(25)));

                $new_pass = md5(md5($new_password . $pass_code . $r['email']));

                $app->execute("UPDATE `company` SET `password` = :pas AND `code` = :code WHERE `id` = :id", [
                    ':pas' => $new_pass,
                    ':code' => $pass_code,
                    ':id' => $_SESSION['id']
                ]);

                $_SESSION['password'] = $new_pass;

                $success = "Пароль успешно изменен";
            }
    }*/


    ?>

    <body class="profile-body">

    <main class="wrapper wrapper-profile" id="wrapper">


        <?php require('template/more/profileAside.php'); ?>

        <section class="profile-base">

            <?php require('template/more/profileHeader.php'); ?>


            <div class="profile-content profile">

                <div class="section-nav-profile">
                    <span><a href="/profile">Профиль</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span>Безопасность</span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span>Сменить пароль</span>
                </div>

                <div class="errors-block-fix"></div>

                <?php if (isset($success)) { ?>
                    <div class="alert-block">
                        <div>
                            <span><?php echo $success; ?></span>
                        </div>
                        <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                    </div>
                <?php } ?>
                <div class="profile-data">

                    <? include 'template/more/profileHead.php'; ?>

                    <div class="pr-pass-block block-p bl-2">
                        <span>Сменить пароль</span>
                        <?php if ($_SESSION['type'] == 'users') { ?>
                            <form method="post" id="form" class="form-password" role="form">

                                <?php
                                if ($r['2fa'] == 0) {
                                    ?>
                                    <div class="section-no-info" style="margin: 0 0 26px 0;">
                                        <div class="sn-left" style="margin: 0 16px 0 0;">
                                            <i class="mdi mdi-shield-check-outline"></i>
                                            <div>
                                                <span>Защитите Ваш аккаунт</span>
                                                <p>Двухфакторная аутентификация добавляет дополнительный уровень безопасности вашей учетной записи. Для входа в систему дополнительно потребуется ввести 6-значный код.</p>
                                            </div>
                                        </div>
                                        <a href="/2fa" style="width: 95px;height: 43px">Включить</a>
                                    </div>
                                    <?php
                                }
                                ?>

                                <div class="label-block">
                                    <label for="">Действующий пароль <span>*</span></label>

                                    <div class="label-password-2">
                                        <input <? if (isset($err['password'])) { ?> class="errors" <? } ?>  type="password" id="password" name="password" placeholder="" value="<? echo $_POST['password']; ?>">
                                        <i class="mdi mdi-eye-outline eye-password in-pass"></i>
                                    </div>


                                    <? if (isset($err['password'])) { ?> <span class="error"><? echo $err['password']; ?></span> <? } ?>
                                    <span class="empty e-password"></span>
                                </div>
                                <div class="label-block">
                                    <label for="">Новый пароль <span>*</span></label>
                                    <div class="label-password-2">
                                        <input <? if (isset($err['new_password'])) { ?> class="errors" <? } ?> type="password" id="new_password" name="new_password" placeholder="Пароль должен быть не меньше 8 символов" value="<? echo $_POST['new_password']; ?>">
                                        <i class="mdi mdi-eye-outline eye-password in-pass"></i>
                                    </div>
                                    <? if (isset($err['new_password'])) { ?> <span class="error"><? echo $err['new_password']; ?></span> <? } ?>
                                    <span class="empty e-new_password"></span>
                                </div>
                                <div class="label-block">
                                    <label for="">Повторите новый пароль <span>*</span></label>
                                    <div class="label-password-2">
                                        <input <? if (isset($err['lost_password'])) { ?> class="errors" <? } ?> type="password" id="lost_password" name="lost_password" placeholder="" value="<? echo $_POST['lost_password']; ?>">
                                        <i class="mdi mdi-eye-outline eye-password in-pass"></i>
                                    </div>
                                    <? if (isset($err['lost_password'])) { ?> <span class="error"><? echo $err['lost_password']; ?></span> <? } ?>
                                    <span class="empty e-lost_password"></span>
                                </div>
                                <div class="captcha" style="margin-bottom: 35px;">
                                    <div class="captcha__image-reload">
                                        <img class="captcha__image" src="/scripts/captcha" width="132" alt="captcha">
                                        <button type="button" class="captcha__refresh"><i class="mdi mdi-refresh"></i></button>
                                    </div>
                                    <div class="captcha__group">
                                        <label for="captcha">Код, изображенный на картинке <span>*</span></label>
                                        <input <? if (isset($err['captcha'])) { ?> class="errors" <? } ?> type="text" name="captcha" id="captcha">
                                        <? if (isset($err['captcha'])) { ?> <span class="error"><? echo $err['captcha']; ?></span> <? } ?>
                                        <span class="empty e-captcha"></span>
                                    </div>
                                </div>
                                <div class="pf-bth">
                                    <button class="bth save-pass" type="button">Изменить</button>
                                </div>
                            </form>
                        <?php } ?>
                        <?php if ($_SESSION['type'] == 'company') { ?>
                            <form method="post" id="form" class="form-password" role="form">

                                <?php
                                if ($r['2fa'] == 0) {
                                    ?>
                                    <div class="section-no-info" style="margin: 0 0 26px 0;">
                                        <div class="sn-left" style="margin: 0 16px 0 0;">
                                            <i class="mdi mdi-shield-check-outline"></i>
                                            <div>
                                                <span>Защитите Ваш аккаунт</span>
                                                <p>Двухфакторная аутентификация добавляет дополнительный уровень безопасности вашей учетной записи. Для входа в систему дополнительно потребуется ввести 6-значный код.</p>
                                            </div>
                                        </div>
                                        <a href="/2fa" style="width: 95px;height: 43px">Включить</a>
                                    </div>
                                    <?php
                                }
                                ?>

                                <div class="label-block">
                                    <label for="">Действующий пароль <span>*</span></label>
                                    <div class="label-password-2">
                                        <input <? if (isset($err['password'])) { ?> class="errors" <? } ?>  type="password" id="password" name="password" placeholder="" value="<? echo $_POST['password']; ?>">
                                        <i class="mdi mdi-eye-outline eye-password in-pass"></i>
                                    </div>
                                   <? if (isset($err['password'])) { ?> <span class="error"><? echo $err['password']; ?></span> <? } ?>
                                    <span class="empty e-password"></span>
                                </div>
                                <div class="label-block">
                                    <label for="">Новый пароль <span>*</span></label>
                                    <div class="label-password-2">
                                        <input <? if (isset($err['new_password'])) { ?> class="errors" <? } ?> type="password" id="new_password" name="new_password" placeholder="Пароль должен быть не меньше 8 символов" value="<? echo $_POST['new_password']; ?>">
                                        <i class="mdi mdi-eye-outline eye-password in-pass"></i>
                                    </div>
                                   <? if (isset($err['new_password'])) { ?> <span class="error"><? echo $err['new_password']; ?></span> <? } ?>
                                    <span class="empty e-new_password"></span>
                                </div>
                                <div class="label-block">
                                    <label for="">Повторите новый пароль <span>*</span></label>
                                    <div class="label-password-2">
                                        <input <? if (isset($err['lost_password'])) { ?> class="errors" <? } ?> type="password" id="lost_password" name="lost_password" placeholder="" value="<? echo $_POST['lost_password']; ?>">
                                        <i class="mdi mdi-eye-outline eye-password in-pass"></i>
                                    </div>
                                    <? if (isset($err['lost_password'])) { ?> <span class="error"><? echo $err['lost_password']; ?></span> <? } ?>
                                    <span class="empty e-lost_password"></span>
                                </div>
                                <div class="captcha" style="margin-bottom: 35px;">
                                    <div class="captcha__image-reload">
                                        <img class="captcha__image" src="/scripts/captcha" width="132" alt="captcha">
                                        <button type="button" class="captcha__refresh"><i class="mdi mdi-refresh"></i></button>
                                    </div>
                                    <div class="captcha__group">
                                        <label for="captcha">Код, изображенный на картинке <span>*</span></label>
                                        <input <? if (isset($err['captcha'])) { ?> class="errors" <? } ?> type="text" name="captcha" id="captcha">
                                        <? if (isset($err['captcha'])) { ?> <span class="error"><? echo $err['captcha']; ?></span> <? } ?>
                                        <span class="empty e-captcha"></span>
                                    </div>
                                </div>
                                <div class="pf-bth">
                                    <button class="bth save-pass" type="button">Изменить</button>
                                </div>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>

    </main>


    <?php require('template/more/profileFooter.php'); ?>

    <script language="JavaScript" src="/static/scripts/profile.js?v=<?= date('YmdHis') ?>"></script>

    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>