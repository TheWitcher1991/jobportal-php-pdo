<!-- nav -->
<?php

if ($_SESSION['type'] == 'users') {
    $sql = "SELECT * FROM `users` WHERE `id` = :id";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
    $stmt->execute();

    $r = $stmt->fetch();
}

if ($_SESSION['type'] == 'company') {
    $sql = "SELECT * FROM `company` WHERE `id` = :id";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
    $stmt->execute();

    $r = $stmt->fetch();
}

?>

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



                <!--<li>
                    <a class="not" href="/settings"><i class="mdi mdi-cog-outline"></i></a>
                </li>-->

                <?php if ($_SESSION['type'] == 'company') { ?>
                    <li>
                    <a class="not" target="_blank" href="/employer"><i class="mdi mdi-help-circle-outline"></i></a>
                    </li>
                <?php } ?>

                <li>
                    <a class="not" target="_blank" href="/feedback"><i class="mdi mdi-handshake-outline"></i></a>
                </li>
                <li class="notice-prof-icon">
                    <span class="not">
                        <i class="mdi mdi-bell-ring-outline"></i>

                            <?php
                     if ($_SESSION['type'] == 'company') {
                    $r = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $_SESSION['id']])
                    ?>

                         <?php
                         $noc = $app->count("SELECT * FROM `notice` WHERE `company_id` = '$_SESSION[id]' AND `status` = 0 AND `who` = 1");

                         if ($noc > 0) {
                             ?>
                             <span class="notice-nav">   <?php echo $noc ?></span>
                             <?php
                         }

                         ?>

                         <?php
                     }

                            ?>

                           <?php
                    if ($_SESSION['type'] == 'users') {
                    $r = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']])
                    ?>


                        <?php
                        $noc = $app->count("SELECT * FROM `notice` WHERE `user_id` = '$_SESSION[id]' AND `status` = 0 AND `who` = 2");

                        if ($noc > 0) {
                            ?>
                            <span class="notice-nav">   <?php echo $noc ?></span>
                            <?php
                        }

                        ?>

                        <?php
                    }

                           ?>
                    </span>
                    <?php
                    if ($_SESSION['type'] == 'users') {
                    $r = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']])
                    ?>
                        <div style="padding-top: 23px;left: -395px" class="nav-popup nav-notice">
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

                        <?php
                    }

                    ?>

                    <?php
                    if ($_SESSION['type'] == 'company') {
                    $r = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $_SESSION['id']])
                    ?>
                        <div style="padding-top: 23px;left: -395px" class="nav-popup nav-notice">
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


                        <?php
                    }

                    ?>
                </li>
                <li class="p-img-block">
                    <?php if ($_SESSION['type'] == 'users') { ?>
                        <a style="margin: 0;" class="nav-logo-ico">  <?php
                            echo mb_substr($r['name'], 0, 1).mb_substr($r['surname'], 0, 1);
                            ?></a>
                    <?php } ?>
                    <?php if ($_SESSION['type'] == 'company') { ?>
                        <a style="margin: 0;" class="nav-logo-ico">  <?php
                            echo mb_substr($r['name'], 0, 1);
                            ?></a>
                    <?php } ?>


                    <div class="nav-popup-pr" style="right: 0%;">
                        <ul>

                            <?php
                            if ($_SESSION['type'] == 'users') {
                                $r = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']])
                                ?>
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
                                <?php
                            }

                            ?>


                            <?php
                            if ($_SESSION['type'] == 'company') {
                            $r = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $_SESSION['id']])
                            ?>
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
                                <?php
                            }

                            ?>

                            <li><a href="/"><i class="mdi mdi-home-variant-outline"></i> Главная</a></li>
                            <li><a href="/job-list"><i class="mdi mdi-database-outline"></i> Каталог вакансий</a></li>
                            <li><a href="/company-list"><i class="mdi mdi-briefcase-outline"></i> Каталог компаний</a></li>
                            <li><a href="/resume-list"><i class="mdi mdi-school-outline"></i> Каталог резюме</a></li>
                            <li><a href="/faculty"><i class="mdi mdi-home-city-outline"></i> Факультеты</a></li>
                            <li><a href="/employer"><i class="mdi mdi-help-circle-outline"></i> Контакты</a></li>
                            <li><a href="/logout"><i class="mdi mdi-logout-variant"></i> Выход</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- / nav -->