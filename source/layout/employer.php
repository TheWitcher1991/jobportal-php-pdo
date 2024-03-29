<?php
Head('Контакты');

?>
<body>

<?php require('template/base/nav.php'); ?>

<header id="header-search">
    <?php require('template/base/navblock.php'); ?>
    <div class="header-search-container header-image">
        <div class="container">
            <div class="contact">
                <div class="info-me">
                    <h2>Контакты</h2>
                    <ul>
                        <li>
                            <span>Адрес офиса</span>
                            <p>г. Ставрополь, пер. Зоотехнический 12, каб №49</p>
                        </li>
                        <li>
                            <span>Руководитель платформы</span>
                            <p style="margin: 5px 0 0 0">Гунько Александр Юрьевич</p>
                            <p style="margin: 5px 0 8px 0">+7 (918) 774-42-68</p>
                            <p>aleksandrgunko@yandex.ru</p>
                        </li>
                        <li>
                            <span>Обратная связь</span>
                            <p>admin@stgaujob.ru</p>
                        </li>
                    </ul>
                </div>
                <div class="iframe-block">
                    <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A03c03fa3c9f4f12ef95b379e4e86b3d9c35dab8192a3d543313b4d2abeaa4fae&amp;source=constructor" width="100%" height="250" frameborder="0"></iframe>
                </div>
            </div>

        </div>
    </div>
</header>

<main id="wrapper" class="wrapper">

    <section class="employer">
        <div class="container">
            <div class="section-nav">
                <span><a href="/">Главная</a></span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span>Работодателям</span>
            </div>
            <div class="section-header empinf">
                <span class="empl-title">Центр трудоустройства и развития карьеры «Ставропольский ГАУ Агрокадры»</span>
                <ul class="emp-ul">
                    <li>
                        <div class="emp-t">
                            <span class="emp-i"><img src="/static/image/contact/About us page-rafiki.svg" alt=""></span>
                            <span class="emp-a">О нас</span>
                        </div>
                        <div class="emp-c">
                            Центр трудоустройства и развития карьеры выпускников ФГБОУ ВО Ставропольского государственного аграрного университета это надежный источник квалифицированных кадров, специалистов для самых разных отраслей. Вы подбираете временный персонал или хотите точечно закрыть вакансию компетентным специалистом?
                            Надежную репутацию выпускников и студентов ФГБОУ ВО «Ставропольского Государственного аграрного университета» на рынке труда подтверждают многолетние партнерские отношения с крупнейшими компаниями — работодателями, предоставляющими свои вакансии выпускникам вуза.
                        </div>
                    </li>
                    <li>
                        <div class="emp-t">
                            <span class="emp-i"><img src="/static/image/contact/Thinking face-bro.svg" alt=""></span>
                            <span class="emp-a">Что мы предлагаем?</span>
                        </div>
                        <div class="emp-c">
                                Размещение вакансий на сайте ФГБОУ ВО «Ставропольского государственного аграрного университета Агрокадры» абсолютно бесплатно.

                                Организацию специальных мероприятий: ярмарки вакансий, конференции, форумы, мастер-классы, семинары, тренинги и круглые столы.

                                Подбор персонала на открытые вакансии.

                                Организацию и сопровождение программ стажировок и производственной практики студентов.

                                Проведение презентаций ваших компаний в ФГБОУ ВО «Ставропольского государственного аграрного университета».
                        </div>
                    </li>
                    <li>
                        <div class="emp-t">
                            <span class="emp-i"><img src="/static/image/contact/Application programming interface-amico.svg" alt=""></span>
                            <span class="emp-a">Размещение информации о вакансиях </span>
                        </div>
                        <div class="emp-c">
                            Официальный сайт и другие веб-ресурсы ФГБОУ ВО «Ставропольского государственного аграрного университета» — это место притяжения тысяч студентов не только Ставропольского края,
                            но и со всей России. Среди постоянных посетителей нашего сайта: студенты, абитуриенты, родители, аспиранты, молодые специалисты.
                            Если Вы хотите привлечь внимание к вакансии вашей компании среди молодежной аудитории — это один из самых действенных способов.

                            Для размещения информации о вакансиях на сайте необходимо создать аккаунт.
                        </div>
                    </li>
                    <li>
                        <div class="emp-t">
                            <span class="emp-i"><img src="/static/image/contact/Seminar-bro.svg" alt=""></span>
                            <span class="emp-a">Проведение презентаций вашей компании для студентов</span>
                        </div>
                        <div class="emp-c">
                            Хотите рассказать потенциальным работникам о вашей компании и привлечь новые перспективные кадры? Сотрудники Центра трудоустройства организуют презентацию вашей компании для студентов ФГБОУ ВО «Ставропольского государственного аграрного университета».

                            Вы получите возможность рассказать о работе в своей компании аудитории от 20 до 250 человек с использованием современных технических средств.
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>

</main>

<?php require('template/base/footer.php'); ?>

</body>
</html>