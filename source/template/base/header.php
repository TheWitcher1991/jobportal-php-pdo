

<!-- Header -->
<header id="header">
    <?php require('template/base/navblock.php'); ?>
    <div class="header-container wow fadeIn">
        <div class="container">

            <div class="abs-container left-header-block">
                <div class="header-lb wow fadeIn" data-wow-delay="600ms">
                    <div class="header-logo">
                    <a target="_blank" href="http://www.stgau.ru/cstv/" class="logo-s">
                        <img src="/static/image/logo/newlogo1.png" alt="">
                    </a>
                        <span class="txt-s">
                        <a target="_blank" href="http://www.stgau.ru/cstv/" class="vu-t">Ставропольский ГАУ <br /> Агрокадры</a>

                    </span>
                    </div>
                    <h1>Найдите возможность трудоустройства среди <m><? echo $app->count("SELECT * FROM `vacancy` WHERE `status` = 0"); ?></m> вакансий!</h1>
                </div>
                <div class="header-search">

                    <form class="wow fadeIn" action="" method="post" data-wow-delay="600ms">
                        <div>
                            <i class="mdi mdi-magnify"></i>
                            <input type="text" name="text" placeholder="Должность или ключевое слово">
                        </div>
                        <div>
                            <i class="mdi mdi-crosshairs-gps"></i>
                            <input type="text" name="loc" placeholder="Город или регион" value="Ставропольский край">
                        </div>
                        <button type="submit" name="send">
                            Найти
                        </button>
                    </form>
                    <a  data-wow-delay="600ms" class="header-gl-a wow fadeIn" href="/resume-list">Я ищу сотрудника</a>
                </div>

                <!--<div class="header-tags wow fadeIn" data-wow-delay="900ms">
                    <div class="ht-1">Популярные запросы</div>
                    <div class="ht-2">
                        <? # НАДО ТУТ ЧТО-ТО СДЕЛАТЬ!!! ?>
                        <a href="">Работа из дома</a>
                        <a href="">Строитель</a>
                        <a href="">Менеджер</a>
                        <a href="">Юрист</a>
                        <a href="">Курьер</a>
                        <a href="">Программист</a>
                        <a href="">Дизайнер</a>
                        <a href="">Секретарь</a>
                        <a href="">Сварщик</a>
                        <a href="">Специалист</a>
                        <a href="">Экономист</a>
                        <a href="">Администратор</a>
                        <a href="">Операто</a>
                        <a href="">Инженер</a>
                        <a href="">Директор</a>
                        <a href="">Системный администратор</a>
                        <a href="">Руководитель</a>
                        <a href="">Бухгалтер</a>
                        <a href="">Мерчендайзер</a>
                    </div>
                </div>-->

                <?php

                if (empty($_SESSION['id'])) {
                ?>
                <div class="header-button wow fadeIn" data-wow-delay="900ms">
                    <div class="hb-1">Хотите трудоустроится или найти работника?</div>
                    <div class="hb-2">
                        <a href="/create/user">Создать резюме</a>
                        <a href="/create/employers">Разместить вакансию</a>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>

            <div class="right-header-block">

                <div class="pxp-img-boxed wow fadeIn parallax-bg-1" data-wow-delay="1500ms">

                </div>

                <div class="card-outline card-outline-1 parallax-bg-2 wow fadeIn" data-wow-delay="1800ms">
                    <div class="card-icon coi-1"><i class="mdi mdi-card-bulleted-outline"></i></div>
                    <div class="card-text">
                        <span class="ct-1 counter"><? echo $app->count("SELECT * FROM `vacancy` WHERE `status` = 0") ?></span>
                        <span class="ct-2">Вакансий</span>
                    </div>
                </div>
                <div class="card-outline card-outline-2 parallax-bg-3 wow fadeIn" data-wow-delay="2100ms">
                    <div class="card-icon coi-2"><i class="mdi mdi-briefcase-variant-outline"></i></div>
                    <div class="card-text">
                        <span class="ct-1 counter"><? echo $app->count("SELECT * FROM `company` WHERE `ban` = 0") ?></span>
                        <span class="ct-2">Компаний</span>
                    </div>
                </div>
                <div class="card-outline card-outline-3 parallax-bg-4 wow fadeIn" data-wow-delay="2400ms">
                    <div class="card-icon coi-3"><i class="mdi mdi-account-school-outline"></i></div>
                    <div class="card-text">
                        <span class="ct-1 counter"><? echo $app->count("SELECT * FROM `users`") ?></span>
                        <span class="ct-2">Резюме</span>
                    </div>
                </div>
            </div>


        </div>
    </div>
</header>
<!-- / Header -->