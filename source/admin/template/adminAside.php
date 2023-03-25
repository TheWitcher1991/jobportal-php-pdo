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
        </ul>
    </div>
</div>
<!-- / Profile menu -->


<!-- Admin aside -->

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

        <ul>
            <li>
                <a href="/">
                    <span><i class="mdi mdi-home-variant-outline"></i> Главная</span>
                </a>
            </li>
            <li>
                <a <?php if (explodeUrl() == '/admin/analysis/' || explodeUrl() == '/admin/analysis') { echo 'class="active-menuItem2"'; }  ?>  href="/admin/analysis">
                    <span><i class="mdi mdi-chart-timeline-variant-shimmer"></i> Дашборд</span>
                </a>
            </li>

            <li>
                <a <?php if (explodeUrl() == '/admin/statistics/' || explodeUrl() == '/admin/statistics') { echo 'class="active-menuItem2"'; }  ?>  href="/admin/statistics">
                    <span><i class="mdi mdi-chart-box-plus-outline"></i> Факультеты</span>
                </a>
            </li>

            <li>
                <a <?php if (explodeUrl() == '/admin/logs/' || explodeUrl() == '/admin/logs') { echo 'class="active-menuItem2"'; }  ?>  href="/admin/logs">
                    <span><i class="mdi mdi-login-variant"></i> Логи входов</span>
                </a>
            </li>
            <li>
                <a <?php if (explodeUrl() == '/admin/ip/' || explodeUrl() == '/admin/ip') { echo 'class="active-menuItem2"'; }  ?>  href="/admin/ip">
                    <span><i class="mdi mdi-database-marker-outline"></i> IP адреса</span>
                </a>
            </li>
            <li>
                <a <?php if (explodeUrl() == '/admin/respond-list/' || explodeUrl() == '/admin/respond-list') { echo 'class="active-menuItem2"'; }  ?>  href="/admin/respond-list">
                    <span><i class="mdi mdi-microsoft-access"></i> Отклики студентов</span>
                </a>
            </li>
            <li>
                <a <?php if (explodeUrl() == '/admin/students-list/' || explodeUrl() == '/admin/students-list'
                    || explodeUrl() == '/admin/students-add/' || explodeUrl() == '/admin/students-add'
                    || explodeUrl() == '/admin/edit-students/' || explodeUrl() == '/admin/edit-students'
                    || explodeUrl() == '/admin/info-students/' || explodeUrl() == '/admin/info-students') { echo 'class="active-menuItem2"'; }  ?> >
                    <span><i class="mdi mdi-school-outline"></i> Студенты</span>
                    <i class="mdi mdi-menu-down"></i>
                </a>
                <ul <?php if (explodeUrl() == '/admin/students-list/' || explodeUrl() == '/admin/students-list'
                    || explodeUrl() == '/admin/students-add/' || explodeUrl() == '/admin/students-add'
                    || explodeUrl() == '/admin/edit-students/' || explodeUrl() == '/admin/edit-students'
                    || explodeUrl() == '/admin/info-students/' || explodeUrl() == '/admin/info-students') { echo 'style="display:block"'; }  ?>  class="aside-pop">

                    <li><a href="/admin/students-list">Каталог студентов</a></li>
                    <li><a href="/admin/students-add">Добавить студентов</a></li>
                </ul>
            </li>
            <li>
                <a <?php if (explodeUrl() == '/admin/companys-list/' || explodeUrl() == '/admin/companys-list'
                    || explodeUrl() == '/admin/companys-add/' || explodeUrl() == '/admin/companys-add'
                    || explodeUrl() == '/admin/edit-companys/' || explodeUrl() == '/admin/edit-companys'
                    || explodeUrl() == '/admin/info-companys/' || explodeUrl() == '/admin/info-companys') { echo 'class="active-menuItem2"'; }  ?>  >
                    <span><i class="mdi mdi-briefcase-variant-outline"></i> Компании</span>
                    <i class="mdi mdi-menu-down"></i>
                </a>
                <ul <?php if (explodeUrl() == '/admin/companys-list/' || explodeUrl() == '/admin/companys-list'
                    || explodeUrl() == '/admin/companys-add/' || explodeUrl() == '/admin/companys-add'
                    || explodeUrl() == '/admin/edit-companys/' || explodeUrl() == '/admin/edit-companys'
                    || explodeUrl() == '/admin/info-companys/' || explodeUrl() == '/admin/info-companys') { echo 'style="display:block"'; }  ?> class="aside-pop">
                    <li><a href="/admin/companys-list">Каталог компаний</a></li>
                    <li><a href="/admin/companys-add">Добавить компанию</a></li>
                </ul>
            </li>
            <li>
                <a <?php if (explodeUrl() == '/admin/jobs-list/' || explodeUrl() == '/admin/jobs-list'
                    || explodeUrl() == '/admin/jobs-add/' || explodeUrl() == '/admin/jobs-add'
                    || explodeUrl() == '/admin/edit-jobs/' || explodeUrl() == '/admin/edit-jobs'
                    || explodeUrl() == '/admin/info-jobs/' || explodeUrl() == '/admin/info-jobs'
                    || explodeUrl() == '/admin/jobs-close/' || explodeUrl() == '/admin/jobs-close') { echo 'class="active-menuItem2"'; }  ?>>
                    <span><i class="mdi mdi-database-check-outline"></i> Вакансии</span>
                    <i class="mdi mdi-menu-down"></i>
                </a>
                <ul <?php if (explodeUrl() == '/admin/jobs-list/' || explodeUrl() == '/admin/jobs-list'
                    || explodeUrl() == '/admin/jobs-add/' || explodeUrl() == '/admin/jobs-add'
                    || explodeUrl() == '/admin/edit-jobs/' || explodeUrl() == '/admin/edit-jobs'
                    || explodeUrl() == '/admin/info-jobs/' || explodeUrl() == '/admin/info-jobs'
                    || explodeUrl() == '/admin/jobs-close/' || explodeUrl() == '/admin/jobs-close') { echo 'style="display:block"'; }  ?> class="aside-pop">
                    <li><a href="/admin/jobs-list">Каталог вакансий</a></li>
                    <li><a href="/admin/jobs-add">Добавить вакансию</a></li>
                    <li><a href="/admin/jobs-close">Закрытые вакансии</a></li>
                </ul>
            </li>
            <li>
                <a <?php if (explodeUrl() == '/admin/chat/' || explodeUrl() == '/admin/chat') { echo 'class="active-menuItem2"'; }  ?>  href="">
                    <span><i class="mdi mdi-chat-question-outline"></i> Чат с компаниями</span>
                </a>
            </li>
            <!-- <li>
                 <a>
                     <span><i class="icon-book-open"></i> Резюме</span>
                     <i class="icon-arrow-down"></i>
                 </a>
                 <ul class="aside-pop">
                     <li><a href="/admin/resumes-list">Каталог резюме</a></li>
                     <li><a href="/admin/resumes-add">Добавить резюме</a></li>
                 </ul>
             </li>-->
            <li><a class="p-log" href="/logout"><span><i class="mdi mdi-logout-variant"></i> Выход</a></span></li>
        </ul>
    </nav>
</div>



<!-- / Admin aside -->