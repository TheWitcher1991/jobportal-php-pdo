<!-- Menu -->
<nav id="nav">
    <div class="nav-container container">
        <div class="flex">
            <ul class="left">
                <li><a href="/">Главная</a></li>
                <li><a
                        <?php
                        $sqlar = $app->query("SELECT * FROM `map_list` WHERE `map_code` = 'stav'");
                        parse_str($_SERVER['QUERY_STRING'], $get);
                        while ($rs = $sqlar->fetch()) {
                            if ($get['loc'] == $rs['code']) {
                                echo 'class="active-menuItem"';
                            }
                        }
                        if ($get['loc'] == 'Ставропольский край') {
                            echo 'class="active-menuItem"';
                        }
                        ?>
                            href="/job-list?loc=stav"
                    >Вакансии в Ставропольском крае</a></li>
                <li><a
                        <?php if (explodeUrl() == '/company' || explodeUrl() == '/company/') { echo 'class="active-menuItem"'; }  ?>
                            href="/company-list">Компании</a></li>
                <li><a
                        <?php if (explodeUrl() == '/resume' || explodeUrl() == '/resume/') { echo 'class="active-menuItem"'; }  ?>
                            href="/resume-list">Резюме студентов</a></li>
                <li><a
                        <?php if (explodeUrl() == '/students' || explodeUrl() == '/students/') { echo 'class="active-menuItem"'; }  ?>
                            href="/faculty">Факультеты</a></li>
                <li><a href="/employer">Контакты</a></li>
            </ul class="right">
            <ul class="right">
                <?php
                if (!isset($_SESSION['surname']) && !isset($_SESSION['password'])) {
                    ?>

                    <li><a class="auth_bth open-auth"> <i class="mdi mdi-login-variant"></i> Войти</a></li>
                    <li><a class="auth_bth reg-home-bth" href="/create/user"> <i class="mdi mdi-account-plus-outline"></i> Регистрация</a></li>
                    <?php
                } else if ($_SESSION['type'] == 'users') {
                    $r = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']])
                    ?>
                    <li>
                        <a class="prof-icon" href="/feedback"><i class="mdi mdi-handshake-outline""></i></a>
                    </li>
                    <li>
                        <a class="prof-icon" href="/save"><i class="mdi mdi-bookmark-outline"></i></a>
                    </li>
                        <li>
                            <a class="prof-icon"><i class="mdi mdi-bell-ring-outline"></i>
                                <?php
                                $noc = $app->count("SELECT * FROM `notice` WHERE `user_id` = '$_SESSION[id]' AND `status` = 0 AND `who` = 2");

                                if ($noc > 0) {
                                    ?>
                                    <span class="notice-nav">   <?php echo $noc ?></span>
                                    <?php
                                }

                                ?>
                            </a>

                            <div class="nav-popup nav-notice">
                                <div class="div-notice">
                                    <ul class="ul-notice">
                                        <?php

                                        if ($noc > 0) {
                                            echo $app->notice('users', $_SESSION['id']);
                                        } else {
                                            ?>
                                            <li><span class="none-tic">Нет новых уведомлений</span></li>
                                            <?php
                                        }

                                        ?>
                                    </ul>
                                    <div><a href="/notice">Показать всё</a></div>
                                </div>
                            </div>
                        </li>
                    <li>

                        <a class="nav-logo-ico">  <?php
                            echo mb_substr($r['name'], 0, 1).mb_substr($r['surname'], 0, 1);
                            ?></a>
                        <div style="left: -260px;" class="nav-popup">
                            <ul>
                                <li>
                                    <div>
                                        <a href="/profile">
                                            <span>

                    <?php
                            echo $r['name'] . ' ' . $r['surname'];
                    ?>

                                            </span>
                                            <span>

                                                   <?php
                                                   echo $r['email'];
                                                   ?>

                                            </span>
                                        </a>
                                    </div>
                                </li>
                                <li><a href="/views"><i class="mdi mdi-eye-outline"></i> Просмотры</a></li>
                                <li><a href="/me-respond"><i class="mdi mdi-briefcase-outline"></i> Мои отклики</a></li>
                                <li><a href="/me-review"><i class="mdi mdi-star-outline"></i> Мои отзывы</a></li>
                                <li><a href="/messages"><i class="mdi mdi-chat-outline"></i> Чат</a></li>
                                <li><a href="/notice"><i class="mdi mdi-bell-ring-outline"></i> Уведомления</a></li>
                                <!--<li><a href="/settings"><i class="mdi mdi-cog-outline"></i> Настройки</a></li>-->
                                <li><a href="/logout"><i class="mdi mdi-logout-variant"></i> Выход</a></li>
                            </ul>
                        </div>
                    </li>



                    <?php
                } else if ($_SESSION['type'] == 'company') {
                    $r = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $_SESSION['id']])
                    ?>

                        <li>
                            <a class="prof-icon" href="/feedback"><i class="mdi mdi-handshake-outline"></i></a>
                        </li>

                    <li>
                        <a class="prof-icon"><i class="mdi mdi-bell-ring-outline"></i>

                            <?php
                            $noc = $app->count("SELECT * FROM `notice` WHERE `company_id` = '$_SESSION[id]' AND `status` = 0 AND `who` = 1");

                            if ($noc > 0) {
                                ?>
                                <span class="notice-nav">   <?php echo $noc ?></span>
                                <?php
                            }

                            ?>
                        </a>


                        <div class="nav-popup nav-notice">
                            <div class="div-notice">
                                <ul class="ul-notice">
                                        <?php

                                        if ($noc > 0) {
                                            echo $app->notice('company', $_SESSION['id']);
                                        } else {
                                            ?>
                                            <li><span class="none-tic">Нет новых уведомлений</span></li>
                                            <?php
                                        }

                                        ?>
                                    </ul>
                                    <div><a href="/notice">Показать всё</a></div>
                                </div>
                            </div>


                    </li>
                    <li>
                    <li>
                        <a class="nav-logo-ico">  <?php
                            echo mb_substr($r['name'], 0, 1);
                            ?></a>
                        <div style="left: -260px" class="nav-popup">
                            <ul>
                                <li>
                                    <div>
                                        <a href="/profile">
                                            <span>

                    <?php



                    echo $r['name'];
                    ?>

                                            </span>
                                            <span>

                                                   <?php
                                                   echo $r['email'];
                                                   ?>

                                            </span>
                                        </a>
                                    </div>
                                </li>
                                <li><a href="/create-job"><i class="mdi mdi-database-plus-outline"></i> Добавить вакансию</a></li>
                                <li><a href="/responded"><i class="mdi mdi-school-outline"></i> Отклики</a></li>
                                <li><a href="/manage-job"><i class="mdi mdi-database-outline"></i> Мои вакансии</a></li>
                                <li><a href="/messages"><i class="mdi mdi-chat-outline"></i> Чат</a></li>
                                <li><a href="/notice"><i class="mdi mdi-bell-ring-outline"></i> Уведомления</a></li>
                                <!--<li><a href="/settings"><i class="mdi mdi-cog-outline"></i> Настройки</a></li>-->
                                <li><a href="/logout"><i class="mdi mdi-logout-variant"></i> Выход</a></li>
                            </ul>
                        </div>
                    </li>
                    <?php
                } else if ($_SESSION['type'] == 'admin') {
                    ?>
                    <li>
                        <a class="prof-icon" href="/feedback"><i class="mdi mdi-handshake-outline"></i></a>
                    </li>

                    <li>
                        <a class="prof-icon"><i class="mdi mdi-bell-ring-outline"></i>

                        </a>


                        <div class="nav-popup nav-notice">
                            <div class="div-notice">
                                <ul class="ul-notice">
                                    <li><span class="none-tic">Нет новых уведомлений</span></li>
                                </ul>
                                <div><a href="/notice">Показать всё</a></div>
                            </div>
                        </div>


                    </li>
                <li>
                    <a class="nav-logo-ico">A</a>
                    <div style="left: -260px" class="nav-popup">
                        <ul>
                            <li>
                                <div>
                                    <a href="/admin/analysis">
                                            <span>

                    <?php

                    $r = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

                    echo $r['name'];
                    ?>

                                            </span>
                                        <span>

                                                   <?php
                                                   echo $r['email'];
                                                   ?>

                                            </span>
                                    </a>
                                </div>
                            </li>
                            <li><a href="/admin/analysis"><i class="mdi mdi-account-circle-outline"></i> Кабинет</a></li>
                            <li><a href="/admin/statistics"><i class="mdi mdi-finance"></i> Факультеты</a></li>
                            <li><a href="/admin/companys-add"><i class="mdi mdi-briefcase-plus-outline"></i> Добавить компанию</a></li>
                            <li><a href="/admin/jobs-add"><i class="mdi mdi-folder-plus-outline"></i> Добавить вакансию</a></li>
                            <li><a href="/admin/students-add"><i class="mdi mdi-account-plus-outline"></i> Добавить студента</a></li>
                            <li><a href="/logout"><i class="mdi mdi-logout-variant"></i> Выход</a></li>

                        </ul>
                    </div>
                </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
<!-- / Menu -->


<nav class="nav-mobile">
    <div class="nav-m-container container">
        <div class="flex">
            <div class="nav-m-block-1">
                <span class="open-menu"><i class="mdi mdi-menu"></i></span>
                <div class="nav-m-logo">
                    <span>
                        <img src="/static/image/ico/logo.png" alt="">
                    </span>
                </div>
            </div>

            <div class="nav-m-menu">
                <ul>
                    <?php
                    if (!isset($_SESSION['id']) && !isset($_SESSION['password'])) {
                    ?>

                        <li>
                            <a href="/feedback"><i class="mdi mdi-handshake-outline"></i></a>
                        </li>
                        <?php
                    }
                    ?>

                    <?php
                    if (isset($_SESSION['id']) && isset($_SESSION['password'])) {
                        ?>

                        <li>
                            <a href="/save"><i class="mdi mdi-bookmark-outline"></i></a>
                        </li>
                        <?php
                    }
                    ?>


                    <?php
                    if (!isset($_SESSION['id']) && !isset($_SESSION['password'])) {
                        ?>
                        <li>
                            <a href="/employer"><i class="mdi mdi-phone-alert-outline"></i></a>
                        </li>
                        <?php
                    }
                    ?>

                    <?php
                    if (isset($_SESSION['id']) && isset($_SESSION['password']) && $_SESSION['type'] != 'admin') {
                    ?>
                        <li>
                            <a href="/notice"><i class="mdi mdi-bell-ring-outline"></i></a>
                        </li>
                        <?php
                    }
                    ?>

                    <?php
                    if (!isset($_SESSION['id']) && !isset($_SESSION['password'])) {
                        ?>
                        <li class="profile-data open-auth">
                            <a href="javascript:void(0)"><i class="mdi mdi-login-variant"></i></a>
                        </li>
                        <?php
                    }
                    ?>

                    <?php
                    if (isset($_SESSION['id']) && isset($_SESSION['password']) && $_SESSION['type'] != 'admin') {
                        ?>
                        <li class="profile-data"><a href="/profile"><i class="mdi mdi-account-outline"></i></a></li>
                        <?php
                    }
                    ?>

                    <?php
                    if (isset($_SESSION['id']) && isset($_SESSION['password']) && $_SESSION['type'] == 'admin') {
                        ?>
                        <li class="profile-data"><a href="/admin/analysis"><i class="mdi mdi-account-outline"></i></a></li>
                        <?php
                    }
                    ?>


                    <?php
                    if (isset($_SESSION['id']) && isset($_SESSION['password'])) {
                        ?>
                        <li>
                            <a href="/logout"><i class="mdi mdi-logout"></i></a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</nav>

















