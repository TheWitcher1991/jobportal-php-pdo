<?php


if (isset($_SESSION['id'])) {

    if (!empty($r)) {


?>


        <?php if ($_SESSION['type'] == 'company') {

            $sth = $PDO->prepare("SELECT * FROM `review` WHERE `company_id` = ?");
            $sth->execute(array((int) $r['id']));
            $data = $sth->fetchAll(PDO::FETCH_ASSOC);
            $count = count($data);

            if ($count > 0) {
                $rating = 0;
                foreach ($data as $row) {
                    $rating += $row['rating'];
                }
                $rating = $rating / $count;
            } else {
                $rating = 0;
            }

            ?>


        <div class="profile-head-wrapper">

            <div class="phw-flex">

                <div class="phw-left">

                    <div class="phw-img">
                        <span><img src="/static/image/company/<?php echo $r['img'] ?>" alt=""></span>
                    </div>

                    <div class="phw-top">

                        <div class="phw-t-left">

                            <div>

                                <h1><?php if ($r['verified'] == 1) { ?> <i class="mdi mdi-check-circle-outline shiled-success"></i> <?php } ?> <?php

                                    if (trim($r['name']) != '') {
                                        echo $r['name'];
                                    } else {
                                        echo 'Без названия';
                                    }

                                    ?></h1>

                                <div class="phw-mini">
                                <span> <?php

                                    if (trim($r['specialty']) != '') {
                                        echo '<i class="mdi mdi-pound"></i> ' . $r['specialty'] . ' ';
                                    }



                                    ?> </span>
                                    <span><i class="mdi mdi-crosshairs-gps"></i> <?php echo $r['address'] ?></span>
                                    <span><i class="mdi mdi-account-multiple-outline"></i> Подписчиков       <?

                                        echo $app->rowCount("SELECT * FROM `sub` WHERE `company` = :id", [
                                            ':id' => $r['id'],
                                        ]);

                                        ?></span>
                                    <span><i class="mdi mdi-email-outline"></i> <?php echo $r['email'] ?></span>

                                </div>
                            </div>



                            <a class="phw-a" href="/company/?id=<?php echo $r['id']  ?>" target="_blank"><i class="mdi mdi-link-variant"></i> Показать меня</a>

                        </div>

                        <div class="phw-stat">

                            <div class="phw-s-item">

                                <span><i class="mdi mdi-database-check-outline"></i> <m class=""><?php echo $app->rowCount("SELECT * FROM `vacancy` WHERE `company_id` = :id", [':id' => $r['id']]) ?></m></span>

                                <p>Вакансии</p>

                            </div>

                            <div class="phw-s-item">

                                <span><i class="mdi mdi-school-outline"></i> <m class=""><?php echo $app->rowCount("SELECT * FROM `respond` WHERE `company_id` = :id", [':id' => $r['id']]) ?></m></span>

                                <p>Отклики</p>

                            </div>

                            <div class="phw-s-item">

                                <span><i class="mdi mdi-star-outline"></i> <m class=""><?php echo $rating ?></m></span>

                                <p>Рейтинг</p>

                            </div>

                            <div class="phw-s-item">

                                <span><i class="mdi mdi-message-star-outline"></i> <m class=""><?php echo $count ?></m></span>

                                <p>Отзывы</p>

                            </div>


                        </div>

                    </div>



                </div>


            </div>

            <div class="phw-menu">
                <ul class="phw-ul">
                    <li><a <?php if (explodeUrl() == '/profile' || explodeUrl() == '/profile/') { echo 'class="phw-active"'; }  ?> href="/profile">Настройки</a></li>
                    <li><a <?php if (explodeUrl() == '/me-sub' || explodeUrl() == '/me-sub/') { echo 'class="phw-active"'; }  ?> href="/me-sub">Подписчики</a></li>
                    <li><a <?php if (explodeUrl() == '/me-review' || explodeUrl() == '/me-review/') { echo 'class="phw-active"'; }  ?> href="/me-review">Отзывы</a></li>
                    <li><a <?php if (explodeUrl() == '/change-password' || explodeUrl() == '/change-password/') { echo 'class="phw-active"'; }  ?> href="/change-password">Сменить пароль</a></li>
                    <li><a <?php if (explodeUrl() == '/2fa' || explodeUrl() == '/2fa/') { echo 'class="phw-active"'; }  ?> href="/2fa">2FA</a></li>
                    <li><a <?php if (explodeUrl() == '/logs' || explodeUrl() == '/logs/') { echo 'class="phw-active"'; }  ?> href="/logs">Логи входов</a></li>
                </ul>
            </div>

        </div>

        <?php } ?>


        <?php if ($_SESSION['type'] == 'users') { ?>


            <div class="profile-head-wrapper">

                <div class="phw-flex">

                    <div class="phw-left">

                        <div class="phw-img">
                            <span><img src="/static/image/users/<?php echo $r['img'] ?>" alt=""></span>
                        </div>

                        <div class="phw-top">

                            <div class="phw-t-left">

                                <div>

                                    <h1><?php

                                        echo $r['name'] . ' ' . $r['surname'];

                                        ?></h1>

                                    <div class="phw-mini">

                                        <span><i class="mdi mdi-head-question-outline"></i> <?php echo $r['prof'] ?></span>
                                        <span><i class="mdi mdi-email-outline"></i> <?php echo $r['email'] ?></span>
                                        <span><i class="mdi mdi-phone-outline"></i> <?php echo $r['phone'] ?></span>


                                    </div>
                                </div>



                                <a class="phw-a" href="/resume/?id=<?php echo $r['id']  ?>" target="_blank"><i class="mdi mdi-link-variant"></i> Показать меня</a>

                            </div>

                            <div class="phw-stat">

                                <div class="phw-s-item">

                                    <span><i class="mdi mdi-database-eye-outline"></i> <m class=""><?php echo $r['view'] ?></m></span>

                                    <p>Просмотров</p>

                                </div>

                                <div class="phw-s-item">

                                    <span><i class="mdi mdi-briefcase-variant-outline"></i> <m class=""><?php echo $app->rowCount("SELECT * FROM `respond` WHERE `user_id` = :id", [':id' => $r['id']]) ?></m></span>

                                    <p>Откликов</p>

                                </div>

                                <div class="phw-s-item">

                                    <span><i class="mdi mdi-eye-outline"></i> <m class=""><?php echo $app->count("SELECT * FROM `online_resume` WHERE `users` = $r[id]") ?></m></span>

                                    <p>Вас смотрят</p>

                                </div>

                            </div>

                        </div>



                    </div>


                </div>

                <div class="phw-menu">
                    <ul class="phw-ul">
                        <li><a <?php if (explodeUrl() == '/profile' || explodeUrl() == '/profile/') { echo 'class="phw-active"'; }  ?> href="/profile">Резюме</a></li>
                        <li><a <?php if (explodeUrl() == '/views' || explodeUrl() == '/views/') { echo 'class="phw-active"'; }  ?> href="/views">Просмотры</a></li>
                        <li><a <?php if (explodeUrl() == '/add-exp' || explodeUrl() == '/add-exp/') { echo 'class="phw-active"'; }  ?> href="/add-exp">Опыт работы</a></li>
                        <li><a <?php if (explodeUrl() == '/add-achievement' || explodeUrl() == '/add-achievement/') { echo 'class="phw-active"'; }  ?> href="/add-achievement">Достижения</a></li>
                        <li><a <?php if (explodeUrl() == '/change-password' || explodeUrl() == '/change-password/') { echo 'class="phw-active"'; }  ?> href="/change-password">Сменить пароль</a></li>
                        <li><a <?php if (explodeUrl() == '/2fa' || explodeUrl() == '/2fa/') { echo 'class="phw-active"'; }  ?> href="/2fa">2FA</a></li>
                        <li><a <?php if (explodeUrl() == '/logs' || explodeUrl() == '/logs/') { echo 'class="phw-active"'; }  ?> href="/logs">Логи входов</a></li>
                    </ul>
                </div>

            </div>

        <?php } ?>

        <?php

    }

}


?>
