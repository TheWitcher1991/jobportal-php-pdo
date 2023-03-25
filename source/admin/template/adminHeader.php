<!-- admin nav -->
<nav class="nav-profile">
    <div class="nav-md-s">
        <div class="n-i-b">
            <span>
                <i class="mdi mdi-arrow-collapse-left back-menu"></i>
            </span>
        </div>
    </div>
    <div class="profile-name">
        <div>
            <ul class="pn-ul">
                <li class="p-img-block">
                    <div class="p-img">
                        <span class="pi-text">
                            Администратор
                        </span>
                    </div>
                    <div class="nav-popup-pr" style="top:18px">
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
                            <li><a href="/admin/statistics"><i class="mdi mdi-finance"></i> Факультеты</a></li>
                            <li><a href="/admin/companys-add"><i class="mdi mdi-briefcase-plus-outline"></i> Добавить компанию</a></li>
                            <li><a href="/admin/jobs-add"><i class="mdi mdi-folder-plus-outline"></i> Добавить вакансию</a></li>
                            <li><a href="/admin/students-add"><i class="mdi mdi-account-plus-outline"></i> Добавить студента</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- / admin nav -->