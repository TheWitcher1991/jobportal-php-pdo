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




    Head('Обратная связь');

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
                <span>Обратная связь</span>
            </div>
        </div>
        <div class="container">

            <div class="message-block">
</div>


            <div class="feedback-main">
                <span>Форма обратной связи</span>
                <p>Если Вы заметили какую-то недоработку, баг или Вас что-то не устраивает в работе сайта, пожалуйста, опишите проблему. Если на сайте по-вашему мнению чего-то не хватает, пожалуйста, сообщите нам.</p>

                <form method="POST" role="form" class="feedback-form">

                    <div class="label-block">
                        <label for="">Сообщение <span>*</span></label>
                        <textarea class="text" name="text" id="text" cols="30" rows="5" placeholder="Опишите проблему..."></textarea>
                        <span class="error e-text" style="display: none"></span>
                    </div>

                    <div class="captcha">
                        <div class="captcha__image-reload">
                            <img class="captcha__image" src="/scripts/captcha" alt="captcha" width="132">
                            <button type="button" class="captcha__refresh"><i class="mdi mdi-refresh"></i></button>
                        </div>
                        <div class="captcha__group">
                            <label for="captcha">Код, изображенный на картинке <span>*</span></label>
                            <input class="captcha" type="text" name="captcha" id="captcha">
                            <span class="error e-captcha" style="display: none"></span>
                        </div>
                    </div>

                    <div class="pf-bth" style="margin: 35px 0 0 0;">
                        <button class="bth bth-feedback" type="button" name="feedback">Отправить</button>
                    </div>

                </form>


            </div>
        </div>
    </main>


    <?php require('template/base/footer.php'); ?>

    <script>
        const refreshCaptcha=(target)=>{const captchaImage=target.closest('.captcha__image-reload').querySelector('.captcha__image');captchaImage.src='/scripts/captcha?r='+new Date().getUTCMilliseconds()}
        const captchaBtn=document.querySelector('.captcha__refresh');captchaBtn.addEventListener('click',(e)=>refreshCaptcha(e.target))
    </script>

    <script language="JavaScript" src="/static/scripts/feedback.js?v=<?= date('YmdHis') ?>"></script>

    </body>
    </html>
