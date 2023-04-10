
<div class="mobile-menu">
    <div class="mobile-container">
        <div class="mm-exit">
            <span class="flaticon-close-1"></span>
        </div>

        <?php

        if (!isset($_SESSION['id']) && !isset($_SESSION['password'])) {
        ?>
            <div class="mm-title">
                <span class="open-auth">Войти</span>
            </div>
            <?php
        } else {
        ?>
            <div class="mm-title">
                <a href="/profile">Личный кабинет</a>
            </div>
            <?php
        }
        ?>



        <div class="mm-list">
            <ul>
                <li><a href="/"><i class="mdi mdi-home-variant-outline"></i> Главная <i></i></a></li>
                <li><a href="/job-list/?loc=stav"><i class="mdi mdi-database-outline"></i> Вакансии в Ставропольском крае <i></i></a></li>
                <li><a href="/job-list/"><i class="mdi mdi-earth"></i> Вакансии по России <i></i></a></li>
                <li><a href="/company-list"><i class="mdi mdi-briefcase-outline"></i> Компании <i></i></a></li>
                <li><a href="/resume-list"><i class="mdi mdi-school-outline"></i> Резюме студентов <i></i></a></li>
                <li><a href="/faculty"><i class="mdi mdi-home-city-outline"></i> Факультеты <i></i></a></li>
                <li><a href="/employer"><i class="mdi mdi-help-circle-outline"></i> Контакты <i></i></a></li>
            </ul>
        </div>
    </div>
</div>



<div id="arrow__up">
    <i class="mdi mdi-chevron-up"></i>
</div>

<!-- Footer -->
<footer id="footer">
    <div class="footer-container footer-info container">
        <div class="block-info">
            <div class="ico-cnt">
                <span class="ic-le">
                    <img src="/static/image/ico/logo.png" alt="">
                </span>
                <span class="ic-ri">
                    СтГАУ <m>Агрокадры</m>
                </span>
            </div>
            <div class="block-ab">
                <ul>
                    <li><i class="icon-user"></i> Гунько Александр Юрьевич</li>
                    <li><i class="icon-phone"></i> +7 (918) 774-42-68</li>
                    <li><i class="icon-envelope"></i> aleksandrgunko@yandex.ru</li>
                </ul>
            </div>
            <div class="block-social-f">
                <a target="_blank" href="https://vk.com/agrarian_university1930"><i class="icon-social-vkontakte"></i></a>
                <a target="_blank" href="https://t.me/agrarian_university1930"><i class="icon-paper-plane"></i></a>
                <a target="_blank" href="http://www.youtube.com/user/stgau26"><i class="icon-social-youtube"></i></a>
            </div>
        </div>
        <div class="block-info">
            <h6>Информация</h6>
            <div class="block-i-cnt">
                <ul>
                    <li><a target="_blank" href="http://stgau.ru/privacy/">Политика конфиденциальности</a></li>
                    <!--<li><a href="/terms">Условия использования сайтом</a></li>-->
                    <li><a href="/employer">Контакты</a></li>
                    <li><a href="/feedback">Обратная связь</a></li>
                </ul>
            </div>
        </div>
        <div class="block-info">
            <h6>Студентам</h6>
            <div class="block-i-cnt">
                <ul>
                    <li><a href="http://stgaujob.ru/job-list?loc=stav">Вакансии на Ставрополье</a></li>
                    <li><a href="/job-list">Каталог вакансий</a></li>
                    <li><a href="/company-list">Каталог компаний</a></li>
                </ul>
            </div>
        </div>
        <div class="block-info">
            <h6>Работодателям</h6>
            <div class="block-i-cnt">
                <ul>
                    <li><a href="/create/employers">Добавить вакансию</a></li>
                    <li><a href="/resume-list">Каталог резюме</a></li>
                    <li><a href="/faculty">Факультеты</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-container footer-copy container">
        <span>
            © <?php echo date('Y'); ?> ФГБОУ ВО «Ставропольский государственный аграрный университет». <span> Разработчик: ashot.svazyan222@gmail.com</span>
        </span>


        <span title="Посетителей">
            <i class="icon-eye"></i> <?php echo $app->count("SELECT * FROM `online`") ?>
        </span>

    </div>
</footer>
<!-- / Footer -->


<section id="loader-site">
    <div class="sk-circle-bounce">
        <div class="loading-chat">
            <svg class="spinner" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>
        </div>
    </div>
</section>

<div class="cookie-block">
    <div class="container">
        <div>
            <span>
                Этот сайт использует файлы cookies и сервисы сбора технических данных посетителей (данные об IP-адресе, местоположении и др.)
                для обеспечения работоспособности и улучшения качества обслуживания. Продолжая использовать наш сайт,
                вы автоматически соглашаетесь с использованием данных технологий. Более подробная информация доступна в <a href="http://stgau.ru/privacy/">«Политике конфиденциальности»</a>
            </span>
            <div class="cookie-bth">
                <a id="cookie_close">Согласиться</a>
            </div>
        </div>
    </div>
</div>

<!-- Include JS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="/static/scripts/vendor/spincrement/jquery.spincrement.min.js?v=<?= date('YmdHis') ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js" integrity="sha512-d4KkQohk+HswGs6A1d6Gak6Bb9rMWtxjOa0IiY49Q3TeFd5xAzjWXDCBW9RS7m86FQ4RzM2BdHmdJnnKRYknxw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="/static/scripts/vendor/owl/owl.js"></script>

<script language="JavaScript" src="/static/scripts/region.js?v=<?= date('YmdHis') ?>"></script>


<script language="JavaScript" src="/static/scripts/bin/index.module.js?v=<?= date('YmdHis') ?>"></script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" integrity="sha512-Eak/29OTpb36LLo2r47IpVzPBLXnAMPAVypbSZiZ4Qkf8p/7S/XRG5xp7OKWPPYfJT6metI+IORkR5G8F900+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>

    function getCookie(o){let e=document.cookie.match(new RegExp("(?:^|; )"+o.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g,"\\$1")+"=([^;]*)"));return e?decodeURIComponent(e[1]):void 0}let cookiecook=getCookie("cookiecook"),cookiewin=document.querySelector(".cookie-block");"no"!==cookiecook&&(cookiewin.style.display="block",document.querySelector("#cookie_close").addEventListener("click",(function(){cookiewin.style.display="none";let o=new Date;o.setDate(o.getDate()+30),document.cookie="cookiecook=no; path=/; expires="+o.toUTCString()})));
</script>


<script>

    function getRandomInt(max) {
        return Math.floor(Math.random() * max);
    }


    function MessageBox(text) {
        let id = getRandomInt(100);
        $('.errors-block-fix').html(`
                            <div class="alert-block alert-${id}">
                                <div>
                                    <span>${text}</span>
                                    </br />
                                </div>
                                <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                            </div>
                            `)
        $('.errors-block-fix > div').css('display', 'flex')
        setTimeout (() => {
            $(`.alert-${id}`).remove();
        }, 3000)
    }


</script>

<?php

    if (isset($_SESSION['id']) && isset($_SESSION['password'])) {

?>

<script>

    function noticeAjax(type, id, stat = 1) {
        $.ajax({
            url: '/scripts/notice-js',
            data: `id=${id}&type=${type}&status=${stat}`,
            type: 'POST',
            cache: false,
            dataType: 'json',
            error: (response) => console.log(response),
            success: function (responce) {
                if (responce.code === 'success') {
                    $(`.notice-${Number(id)}`).remove()
                    if (responce.count > 0 && (responce.count !== null || responce.count !== undefined)) {
                        $('.notice-nav').html(responce.count)
                    } else {
                        $('.notice-nav').remove();
                        $('.nav-notice ul').html('<li><span class="none-tic">У Вас новых уведомлений</span></li>')
                    }
                } else {
                    MessageBox('Произошла ошибка. Повторите')
                }
            }
        })
    }


</script>


<?php
    }


?>



<?php

if (isset($_SESSION['id']) && isset($_SESSION['password']) && $_SESSION['type'] == 'users') {

?>


    <script>

        function saveJob(id) {
            $.ajax({
                url: '/scripts/profile-js',
                data: `id=${Number(id)}&MODULE_MARK_J0B=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => console.log(response),
                success: function (responce) {
                    if (responce.code === 'success') {
                        $(`.bookmark-${Number(id)} button`).remove()
                        $(`.bookmark-${Number(id)}`).html(`
                            <button type="button" class="active-book" onclick="removeJob(${id})"><i class="mdi mdi-bookmark"></i></button>
                        <span class="tooltip-mili tool-mark">Убрать из избранного</span>
`)
                    } else {
                        MessageBox('Произошла ошибка. Повторите')
                    }
                }
            })
        }


    </script>


    <script>

        function removeJob(id) {
            $.ajax({
                url: '/scripts/profile-js',
                data: `id=${Number(id)}&MODULE_UNMARK_J0B=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => console.log(response),
                success: function (responce) {
                    if (responce.code === 'success') {
                        $(`.bookmark-${Number(id)} button`).remove()
                        $(`.bookmark-${Number(id)}`).html(`
                            <button type="button" onclick="saveJob(${id})"><i class="mdi mdi-bookmark-outline"></i></button>\
                            <span class="tooltip-mili tool-mark">В избранное</span>
                        `)
                    } else {
                        MessageBox('Произошла ошибка. Повторите')
                    }
                }
            })
        }


    </script>


    <?php
}


?>


<script>

    !function(e){e(".owl-carousel")&&e(".owl-carousel").owlCarousel({loop:!1,margin:20,nav:!1,items:3,smartSpeed:500,autoplay:!0,autoplayTimeout:1e4,autoplayHoverPause:!0,responsive:{0:{items:1},480:{items:1},600:{items:2},1e3:{items:3},1250:{items:3},1400:{items:3}}}),(new WOW).init()}(jQuery,window,document);

</script>


<!-- / Include JS -->