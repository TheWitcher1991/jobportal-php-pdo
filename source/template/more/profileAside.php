<!-- Profile menu  -->
<div class="profile-mobile">
    <div class="pm-left pm-open-mobile">
        <i class="mdi mdi-menu"></i>
    </div>
    <div class="pm-right">
        <ul>
            <li>
                <a class="not" href="/employer"><i class="mdi mdi-help-circle-outline"></i></a>
            </li>
            <li>
                <a class="not" href="/feedback"><i class="mdi mdi-handshake-outline"></i></a>
            </li>
            <li>
                <a class="not" href="/notice"><i class="mdi mdi-bell-outline"></i></a>
            </li>
            <?php if ($_SESSION['type'] != 'admin') { ?>
            <li>

                <span class="pi-img">
                            <?php if ($_SESSION['type'] == 'users') { ?>
                                <img src="/static/image/users/<?php echo $r['img'] ?>" alt="">
                            <?php } ?>
                    <?php if ($_SESSION['type'] == 'company') { ?>
                        <img src="/static/image/company/<?php echo $r['img'] ?>" alt="">
                    <?php } ?>
                        </span>

            </li>
            <?php } ?>
        </ul>
    </div>
</div>
<!-- / Profile menu -->

<!-- Profile aside -->
<div class="profile-aside">
    <div class="profile-mob-exit">
        <i class="flaticon-close-1"></i>
    </div>
    <div class="profile-logo">  
        <ul>
            <li class="pf-apk">
                <span>
                    <img src="/static/image/logo/newlogo1.png" alt="">
                </span>
                <p><m>СтГАУ</m> АПК</p>
            </li>
        </ul>
    </div>
    <nav class="profile-aside-nav">

        <ul
            <?php if ($_SESSION['type'] == 'users') { ?>
                class="pa-ul-user"
            <?php } ?>
            <?php if ($_SESSION['type'] == 'company') { ?>
                class="pa-ul-company"
            <?php } ?>
        >
            <?php if ($_SESSION['type'] == 'users') { ?>
                <li><a href="/"><span><i class="mdi mdi-home-variant-outline"></i> Главная</span></a></li>
                <li><a href="/profile"><span><i class="mdi mdi-account-outline"></i> Профиль</span></a></li>
                <?php
                $ot = $app->count("SELECT * FROM `respond_user` WHERE `new` = 1 AND `user_id` = '$_SESSION[id]'");
                $vi = $app->count("SELECT * FROM `online_resume` WHERE `users` = '$_SESSION[id]'");
                ?>
                <li><a href="/views"><span><i class="mdi mdi-eye-outline"></i> Просмотры <?php if ($vi > 0) { echo "<m>$vi</m>"; }  ?> </span></a></li>
                <li>
                    <a>
                        <span><i class="mdi mdi-lock-outline"></i> Безопасность</span>
                        <i class="mdi mdi-menu-down"></i>
                    </a>
                    <ul class="aside-pop" <?php if (explodeUrl() == '/change-password' || explodeUrl() == '/logs'
                        || explodeUrl() == '/change-password/' || explodeUrl() == '/logs/'
                        || explodeUrl() == '/2fa' || explodeUrl() == '/2fa/') { echo 'style="display:block"'; }  ?>>
                        <li><a href="/change-password">Сменить пароль</a></li>
                        <li><a href="/logs">Логи входов</a></li>
                        <li><a href="/2fa">2FA</a></li>
                    </ul>
                </li>
                <li>
                    <a class="pop-p-af">
                        <span><i class="mdi mdi-trophy-award"></i> Портфолио</span>
                        <i class="mdi mdi-menu-down"></i>
                    </a>
                    <ul class="aside-pop"
                        <?php if (explodeUrl() == '/add-education' || explodeUrl() == '/add-exp'
                            || explodeUrl() == '/add-education/' || explodeUrl() == '/add-exp/'
                            || explodeUrl() == '/add-achievement/' || explodeUrl() == '/add-achievement') { echo 'style="display:block"'; }  ?>
                    >
                        <li><a href="/add-education">Образование</a></li>
                        <li><a href="/add-exp">Опыт работы</a></li>
                        <li><a href="/add-achievement">Достижения</a></li>
                    </ul>
                </li>
                <li><a <?php if (explodeUrl() == '/me-respond/' || explodeUrl() == '/me-respond') { echo 'class="active-menuItem2"'; }  ?> href="/me-respond"><span><i class="mdi mdi-briefcase-variant-outline"></i> Мои отклики <?php if ($ot > 0) { echo "<m>$ot</m>"; }  ?> </span></a></li>

                <!--<li><a href="/create-resume"><span><i class="icon-note"></i> Добавить резюме</span></a></li>
                <li><a href="/manage-resume"><span><i class="icon-layers"></i> Мои резюме</span></a></li>-->
                <li><a <?php if (explodeUrl() == '/messages/' || explodeUrl() == '/messages') { echo 'class="active-menuItem2"'; }  ?>  href="/messages"><span><i class="mdi mdi-chat-outline"></i> Чат</span></a></li>
                <li><a <?php if (explodeUrl() == '/notice/' || explodeUrl() == '/notice') { echo 'class="active-menuItem2"'; }  ?> href="/notice"><span><i class="mdi mdi-bell-ring-outline"></i> Уведомления</span></a></li>
                <li>
                    <a>
                        <span><i class="mdi mdi-pin-outline"></i> Прочее</span>
                        <i class="mdi mdi-menu-down"></i>
                    </a>
                    <ul class="aside-pop" <?php if (explodeUrl() == '/me-sub' || explodeUrl() == '/me-sub/'
                        || explodeUrl() == '/me-review/' || explodeUrl() == '/me-review'
                        || explodeUrl() == '/save' || explodeUrl() == '/save/') { echo 'style="display:block"'; }  ?>>
                        <li><a href="/me-review">Мои отзывы</a></li>
                        <li><a href="/me-sub">Мои подписки</a></li>
                        <li><a href="/save">Избранное</a></li>
                    </ul>
                </li>
                <li><a  class="p-log" href="/logout"><span><i class="mdi mdi-logout-variant"></i> Выход</span></a></li>
            <?php } ?>

            <?php if ($_SESSION['type'] == 'company') { ?>
                <li><a href="/"><span><i class="mdi mdi-home-variant-outline"></i> Главная</span></a></li>
               <!--<li><a href="/analytics"><span><i class="icon-graph"></i> Аналитика</span></a></li>-->
                <li><a href="/profile"><span><i class="mdi mdi-account-outline"></i> Профиль</span></a></li>
                <li>
                    <a <?php if (explodeUrl() == '/change-password' || explodeUrl() == '/logs' || explodeUrl() == '/logs/' || explodeUrl() == '/change-password/'
                        || explodeUrl() == '/2fa/' || explodeUrl() == '/2fa') { echo 'class="active-menuItem2"'; }  ?>>
                        <span><i class="mdi mdi-lock-outline"></i> Безопасность</span>
                        <i class="mdi mdi-menu-down"></i>
                    </a>
                    <ul class="aside-pop" <?php if (explodeUrl() == '/change-password' || explodeUrl() == '/logs' || explodeUrl() == '/logs/' || explodeUrl() == '/change-password/'
                        || explodeUrl() == '/2fa/' || explodeUrl() == '/2fa') { echo 'style="display:block"'; }  ?>>
                        <li><a href="/change-password">Сменить пароль</a></li>
                        <li><a href="/logs">Логи входов</a></li>
                        <li><a href="/2fa">2FA</a></li>
                    </ul>
                </li>

                <!--<li><a href="/save"><span><i class="icon-heart"></i> Избранное</a></li>-->
                <li><a href="/create-job"><span><i class="mdi mdi-database-plus-outline"></i> Добавить вакансию</span></a></li>
                <?php
                $ot = $app->count("SELECT * FROM `respond` WHERE `status` = 0 AND `company_id` = '$_SESSION[id]'");
                ?>
                <li><a
                        <?php if (explodeUrl() == '/responded/' || explodeUrl() == '/responded' || explodeUrl() == '/invite-job/' || explodeUrl() == '/invite-job') { echo 'class="active-menuItem2"'; }  ?>
                            href="/responded"><span><i class="mdi mdi-school-outline"></i> Отклики <?php if ($ot > 0) { echo "<m>$ot</m>"; }  ?></span></a></li>
                <li><a
                        <?php if (explodeUrl() == '/edit-job' || explodeUrl() == '/edit-job/' || explodeUrl() == '/analysis-job' || explodeUrl() == '/analysis-job/') { echo 'class="active-menuItem2"'; }  ?>
                            href="/manage-job"><span><i class="mdi mdi-database-outline"></i> Мои вакансии</span></a></li>
                <li><a <?php if (explodeUrl() == '/messages/' || explodeUrl() == '/messages') { echo 'class="active-menuItem2"'; }  ?> href="/messages"><span><i class="mdi mdi-chat-outline"></i> Чат</span></a></li>
                <li>
                    <a <?php if (explodeUrl() == '/archive-job' || explodeUrl() == '/archive-responded' || explodeUrl() == '/archive-job/' || explodeUrl() == '/archive-responded/') { echo 'class="active-menuItem2"'; }  ?>>
                        <span><i class="mdi mdi-archive-outline"></i> Архив</span>
                        <i class="mdi mdi-menu-down"></i>
                    </a>
                    <ul class="aside-pop" <?php if (explodeUrl() == '/archive-job' || explodeUrl() == '/archive-responded' || explodeUrl() == '/archive-job/' || explodeUrl() == '/archive-responded/') { echo 'style="display:block"'; }  ?>>
                        <li><a href="/archive-job">Вакансии (<? echo $app->rowCount("SELECT * FROM `vacancy` WHERE `status` = 1 AND `company_id` = :id", [':id' => $_SESSION['id']]); ?>)</a></li>
                        <li><a href="/archive-responded">Отклики (<? echo $app->rowCount("SELECT * FROM `archive-respond` WHERE `company_id` = :id", [':id' => $_SESSION['id']]); ?>)</a></li>
                    </ul>
                </li>
                <li><a <?php if (explodeUrl() == '/notice/' || explodeUrl() == '/notice') { echo 'class="active-menuItem2"'; }  ?>  href="/notice"><span><i class="mdi mdi-bell-ring-outline"></i> Уведомления</span></a></li>
                <!--<li><a <?php if (explodeUrl() == '/idea/' || explodeUrl() == '/idea') { echo 'class="active-menuItem2"'; }  ?>><span><i class="icon-bulb"></i> Есть идея (Скоро)</span></a>-->
                <li>
                    <a>
                        <span><i class="mdi mdi-pin-outline"></i> Прочее</span>
                        <i class="mdi mdi-menu-down"></i>
                    </a>
                    <ul class="aside-pop" <?php if (explodeUrl() == '/me-sub' || explodeUrl() == '/me-review' || explodeUrl() == '/me-sub/' || explodeUrl() == '/me-review/') { echo 'style="display:block"'; }  ?>>
                        <li><a href="/me-review">Мои отзывы</a></li>
                        <li><a href="/me-sub">Мои подписки</a></li>
                    </ul>
                </li>
                <li><a class="p-log" href="/logout"><span><i class="mdi mdi-logout-variant"></i> Выход</span></a></li>
            <?php } ?>
        </ul>
    </nav>
</div>
<!-- / Profile aside -->
