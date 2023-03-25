<?php



use Work\plugin\lib\pQuery;



if (!isset($_SESSION['id']) && !isset($_SESSION['password'])) {

if (isset($_POST['send'])) {
    if ($_POST['type'] == 1) {
        if (isset($_POST['text']) and trim($_POST['text']) != '') {
            exit(header('location: /job-list?key=' . $_POST['text'].'loc=stav'));
        } else {
            exit(header('location: /job-list?loc=stav'));
        }
    }
    if ($_POST['type'] == 2) {
        if (isset($_POST['text']) and trim($_POST['text']) != '') {
            exit(header('location: /resume-list?key=' . $_POST['text']));
        } else {
            exit(header('location: /resume-list'));
        }
    }
    if ($_POST['type'] == 3) {
        if (isset($_POST['text']) and trim($_POST['text']) != '') {
            exit(header('location: /company-list?key=' . $_POST['text']));
        } else {
            exit(header('location: /company-list'));
        }
    }
}



if (isset($_POST['login2'])) {
    $err = [];

    if (empty($_POST['email2']) or trim($_POST['email2']) == '') $err['email2'] = 'Введите e-mail';
    if (strlen ($_POST['password2']) < 8) $err['password2'] = 'Пароль должен быть не меньше 8 символов';

    if (empty($err)) {

        $app->login($_POST['email2'], $_POST['password2'], $_POST['log-2']);
    }
}


    Head('Вход в личный кабинет');

?>
    <body>

<?php require('template/base/nav.php'); ?>

<header id="header-search">
    <?php require('template/base/navblock.php'); ?>
    <div class="header-search-container">
        <div class="container">
            <form action="" method="post">
                <div class="hs-container">

                        <span class="hs-h">Поиск</span>
                        <div class="header-input-container">
                            <div class="hi-field">
                                <i class="mdi mdi-magnify"></i>
                                <input class="hi-title" name="text" type="text" placeholder="Ключевое слово">
                            </div>
                            <div class="hi-field">
                                <i class="mdi mdi-format-list-text"></i>
                                <select name="type">
                                    <option value="1">Вакансии</option>
                                    <option value="2">Резюме</option>
                                    <option value="3">Компании</option>
                                </select>
                            </div>
                            <input type="submit" class="hs-bth" name="send" value="Найти">
                        </div>

                </div>
            </form>
        </div>
    </div>
</header>


<main id="wrapper">
    <div class="container">
        <div class="section-nav">
            <span><a href="/">Главная</a></span>
            <span><i class="fa-solid fa-chevron-right"></i></span>
            <span>Вход в личный кабинет</span>
        </div>
    </div>
    <section class="auth-section">
        <div class="auth-alert">
            <?php
            if (isset($_GET['error'])) {
                ?>
                <div class="alert-block" style="margin: 0">
                    <div>
                        <span>Введённые Вами email или пароль неверны.</span>
                    </div>
                    <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                </div>
                <?php
            }
            ?>
        </div>

        <div class="auth-content">
            <span>Вход в личный кабинет</span>
            <form method="post">
                <div class="label-block">
                    <label for="">E-mail <span>*</span></label>
                    <input type="text" id="email" name="email2" required value="<?php echo $_POST['email2']; ?>">
                    <? if (isset($err['email'])) { ?> <span class="error"><? echo $err['email']; ?></span> <? } ?>
                </div>

                <div class="label-block" style="margin-bottom: 0px;">
                    <label for="">Пароль <span>*</span></label>
                    <div class="label-password">
                        <input type="password" id="password" name="password2" required placeholder="">
                        <i class="mdi mdi-eye-outline eye-password in-pass"></i>
                    </div>
                    <? if (isset($err['password'])) { ?> <span class="error"><? echo $err['password']; ?></span> <? } ?>
                    <div class="lab-flex">
                        <div class="a-r">
                            <input type="checkbox" class="custom-checkbox" id="log-2" name="log-2" value="1">
                            <label for="log-2">запомнить</label>
                        </div>
                         <span style="margin: 0;" class="label-exp-a lost-pass-a-2">
                            Забыли пароль?
                        </span>
                    </div>

                </div>

                <button class="auth-button pulse-bth" name="login2" type="submit">Войти в личный кабинет</button>
            </form>
        </div>
    </section>
    <section class="me-section">
        <div class="me-base-b">
            <div class="me-auth-block">
                <span>У вас нет аккаунта?</span>
                <p>Поможем Вам трудоустроиться или найти подходящего работника</p>
                <div class="ma-b">
                    <a href="/create/user">Я студент</a>
                    <a href="/create/employers">Я работодатель</a>
                </div>
            </div>
        </div>

    </section>
</main>


<?php require('template/base/footer.php'); ?>

    </body>
</html>
    <?php
} else {

    pQuery::notFound();
}
?>