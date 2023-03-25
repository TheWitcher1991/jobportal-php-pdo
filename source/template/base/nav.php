<?php

if (!isset($_SESSION['surname']) && !isset($_SESSION['password'])) {

    if (isset($_POST['login'])) {

        $app->login($_POST['email'], $_POST['password'], $_POST['log-1']);
    }

    if (isset($_POST['reset'])) {
        $app->reset($_POST['lost_email']);
    }

}
?>



<?php
if (!isset($_SESSION['id']) && !isset($_SESSION['password'])) {
?>
<!-- Auth -->
<div id="auth" class="auth-log">
    <div class="lost-wrapper">
        <div class="auth-container auth-log">
            <div class="auth-title">
                Восстановление пароля
                <i class="mdi mdi-close form-close"></i>
            </div>
            <div class="auth-form">
                <form class="form" action="" method="POST">
                    <div class="label-block label-b-info">
                        Пожалуйста укажите адрес E-mail который вы вводили при регистрации.
                        На указанный адрес будут высланы инструкции по восстановлению пароля.
                    </div>

                    <div class="label-block">
                        <label for="">E-mail <span>*</span></label>
                        <input type="email" id="lost_email" name="lost_email" required placeholder="">
                    </div>
                    <div class="a-bth" style="margin: 0">
                        <button name="reset" class="pulse-bth" type="submit">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="auth-wrapper">
        <div class="auth-container auth-log">
            <div class="auth-title">
                Войти
                <i class="mdi mdi-close form-close"></i>
            </div>
            <div class="auth-form">
                <form class="form" action="" method="POST">
                    <div class="label-block">
                        <label for="">E-mail <span>*</span></label>
                        <input type="text" id="email" name="email" required placeholder="">
                    </div>

                    <div class="label-block" style="margin: 0 0 16px 0;">
                        <label for="">Пароль <span>*</span></label>

                        <div class="label-password">
                            <input type="password" id=password" name="password" required placeholder="">
                            <i class="mdi mdi-eye-outline eye-password in-pass"></i>
                        </div>
                        <div class="lab-flex">
                            <div class="a-r">
                                <input type="checkbox" class="custom-checkbox" id="log-1" name="log-1" value="1">
                                <label for="log-1">запомнить</label>
                            </div>
                            <span style="margin: 0;" class="label-exp-a lost-pass-a">
                            Забыли пароль?
                        </span>
                        </div>
                    </div>


                    <div class="a-b-main" style="margin: 20px 0 0 0">
                        <div class="a-bth" style="margin: 0">
                            <button type="submit" name="login" class="pulse-bth">Войти в личный кабинет</button>
                        </div>
                        <div class="a-l-a a-p">
                            <a href="/create/user">Зарегистрироваться</a>
                            <a class="form-i-a" href="/login-admin"><i class="mdi mdi-shield-crown-outline"></i></a>
                        </div>

                    </div>

                </form>
            </div>
        </div> 
    </div>
</div>
<!-- / Auth -->
<?php } ?>