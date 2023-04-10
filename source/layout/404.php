<?php

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

Head('Ошибка 404');
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

<main id="wrapper" class="wrapper">

    <div class="container">
        <div class="container">
            <div class="section-nav">
                <span><a href="/">Главная</a></span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span>Ошибка 404</span>
            </div>
        </div>
    </div>

    <div class="block-404">
        <div class="flex-404">
            <div class="f-1">
                <div>
                    <p>ошибка 404</p>
                    <span>Упс, Вы попали не туда :(</span>
                </div>
                <span>
                    К сожалению, страница не найдена
                </span>
                <span>Такой страницы не существует, либо она была удалена</span>
            </div>
            <div class="f-2">
                <span>
                    <img src="/static/image/404_2.svg" alt="">
                </span>

            </div>
        </div>
    </div>


</main>

<?php require('template/base/footer.php'); ?>


</body>
</html>