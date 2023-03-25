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


    if (isset($_POST['reset'])) {
        $app->reset($_POST['lost_email']);
    }


    Head('Восстановление пароля');

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
                <span>Восстановление пароля</span>
            </div>
        </div>
        <section class="auth-section">
            <div class="auth-alert">
                <?php
                if (isset($_GET['error'])) {
                    ?>
                    <div class="alert-block" style="margin: 0">
                        <div>
                            <span>Что-то пошло не так.</span>
                        </div>
                        <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                    </div>
                    <?php
                }
                ?>
            </div>

            <div class="auth-content">
                <span>Восстановление пароля</span>
                <form method="post">
                    <div class="label-block">
                        <label for="">E-mail <span>*</span></label>
                        <input type="email" id="lost_email" name="lost_email" required value="<?php echo $_POST['email']; ?>">
                        <? if (isset($err['email'])) { ?> <span class="error"><? echo $err['email']; ?></span> <? } ?>
                    </div>

                    <input class="auth-button" name="reset" type="submit" value="Войти">
                </form>
            </div>
        </section>
        <section class="me-section">
            <div class="me-base-b">
                <div class="me-auth-block">
                    <span>Вспомнили пароль?</span>
                    <div class="ma-b">
                        <a href="/login">Войти</a>
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

