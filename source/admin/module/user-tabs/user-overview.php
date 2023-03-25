<?php
if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

    if ($_SESSION['type'] == 'admin') {
        $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($a['id'])) {
            $app->notFound();
        }
    }

    ?>



<?php if(count($res) > 0) { ?>
    <div class="analysis-manage-flex">
        <div class="block-result">
            <span>Просмотры за месяц <i class="fa-solid fa-minus"></i></span>
            <div class="chart">
                <div id="visits" style="height: 250px"></div>
            </div>
        </div>

        <div class="block-result">
            <span>Просмотры компаний за месяц <i class="fa-solid fa-minus"></i></span>
            <div class="chart">
                <div id="views" style="height: 250px"></div>
            </div>
        </div>
    </div>
<?php } ?>


    <div class="resume-d-right resume-d" style=" background: #fff;
    box-shadow: 0 15px 50px 0 rgb(160 163 189 / 10%);
    padding: 26px;border-radius: 10px;border:0">



        <div class="" style="margin: 0 0 10px 0;">

            <?php
            $onr = $app->count("SELECT * FROM `online` WHERE `id` = '$user[id]' AND `type` = 'users'");
            if ($onr > 0) {
                echo '<span class="resume-stat">Сейчас на сайте</span>';
            }
            ?>
            <?php
            $peo = $app->count("SELECT * FROM `online_resume` WHERE `users` = $user[id]");
            if ($peo > 0) {
                echo '<span class="resume-stat">Сейчас просматривают ' . $peo . '</span>';
            }
            ?>
            <span class="resume-stat"><?php echo $user['stat'] ?></span>
        </div>


        <div class="job-d-tags">
            <ul style="flex-wrap: wrap">
                <li>
                    <div class="ji-l"><i class="mdi mdi-currency-rub"></i></div>
                    <div class="ji-r">
                        <span>Зарплата</span>
                        <span><?php if(!empty($rr['salary'])) { echo $user['salary']; } else {echo "По договорённости"; } ?></span>
                    </div>
                </li>
                <?php if (!empty($user['exp'])) { ?>
                    <li>
                        <div class="ji-l"><i class="mdi mdi-briefcase-variant-outline"></i></div>
                        <div class="ji-r">
                            <span>Опыт работы</span>
                            <span><?php echo $user['exp']; ?></span>
                        </div>
                    </li>
                <?php } ?>
                <?php if (!empty($user['drive'])) { ?>

                    <li>
                        <div class="ji-l"><i class="mdi mdi-car"></i></div>
                        <div class="ji-r">
                            <span>Водительские права</span>
                            <span><?php echo $user['drive']; ?></span>
                        </div>
                    </li>
                <?php } ?>
                <?php if (!empty($user['age'])) { ?>

                    <li>
                        <div class="ji-l"><i class="mdi mdi-baby-face-outline"></i></div>
                        <div class="ji-r">
                            <span>Возраст</span>
                            <span><?php echo calculate_age($user['age']); ?></span>
                        </div>
                    </li>
                <?php } ?>
                <?php if (!empty($user['time'])) { ?>
                <li>
                    <div class="ji-l"><i class="mdi mdi-calendar-month-outline"></i></div>
                    <div class="ji-r">
                        <span>График работы</span>
                        <span><?php echo $user['time']; ?></span>
                    </div>
                </li>
                <?php } ?>
                <?php if (!empty($user['type'])) { ?>
                <li>
                    <div class="ji-l"><i class="mdi mdi-clock-time-four-outline"></i></div>
                    <div class="ji-r">
                        <span>Тип занятости</span>
                        <span><?php echo $user['type']; ?></span>
                    </div>
                </li>
                <?php } ?>

            </ul>
        </div>




        <div class="resume-d-about res-bag">
            <span><m><i class="mdi mdi-information-outline"></i></m> Обо мне</span>
            <p>
                <?php
                if (!empty($user['about'])) {
                    echo '<pre class="text-content-job">' . $user['about'] . '</pre>' ;
                } else {
                    echo 'Нет информации';
                }
                ?>
            </p>
        </div>



        <?php


        $sqled = "SELECT * FROM `exp` WHERE `user_id` = :t";
        $stmted = $PDO->prepare($sqled);
        $stmted->bindValue(':t', $user['id']);
        $stmted->execute();
        if ($stmted->rowCount() > 0) {
            ?>
            <div class="resume-d-exp res-bag">
                            <span><m><i class="mdi mdi-briefcase-variant-outline"></i></m> Опыт работы


                            </span>
                <div class="db-text">
                    <ul class="dl-exp">
                        <?php
                        while ($rx = $stmted->fetch()) {
                            ?>
                            <li>
                                <div class="de-time">
                                    <?php
                                    echo $arr_m[(DateTime::createFromFormat('m.Y', $rx['date_1'])->format('n'))] . ' ' .
                                        DateTime::createFromFormat('m.Y', $rx['date_1'])->format('Y') .  ' — <br />';

                                    $date1 = DateTime::createFromFormat('m.Y', $rx['date_1'])->format('Y-m').'-1';
                                    $date1 = new DateTime($date1);

                                    $date2 = '';

                                    if ($rx['present'] == 1) {
                                        $date2 = date('Y.m.d');
                                        $date2 = DateTime::createFromFormat('Y.m.d', $date2)->format('Y-m-d');
                                        $date2 = new DateTime($date2);
                                        echo 'по настоящее время';
                                    } else {
                                        $date2 = DateTime::createFromFormat('m.Y', $rx['date_2'])->format('Y-m-d');
                                        $date2 = new DateTime($date2);
                                        echo $arr_m[(DateTime::createFromFormat('m.Y', $rx['date_2'])->format('n'))] . ' ' .
                                            DateTime::createFromFormat('m.Y', $rx['date_2'])->format('Y');
                                    }


                                    $period = getPeriod($date1,$date2);

                                    ?>
                                    <p> <?php echo $period; ?></p>
                                </div>
                                <div class="de-content">
                                    <span class="dle-t"><?php echo $rx['title']; ?></span>
                                    <span class="dle-p"><?php echo $rx['prof']; ?></span>
                                    <div class="dle-text">
                                        <p>
                                            <?php echo $rx['text']; ?>
                                        </p>
                                    </div>
                                </div>

                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
        }
        ?>

        <?php
        $sqled = "SELECT * FROM `education` WHERE `user_id` = :t";
        $stmted = $PDO->prepare($sqled);
        $stmted->bindValue(':t', $user['id']);
        $stmted->execute();
        if ($stmted->rowCount() > 0) {
            ?>
            <div class="resume-d-education res-bag">
                            <span><m><i class="mdi mdi-school-outline"></i></m> Образование



                            </span>
                <div class="db-text">
                    <ul class="dl-exp">
                        <?php
                        while ($re = $stmted->fetch()) {
                            ?>
                            <li>
                                <div class="de-time">
                                    <?php echo $re['date']; ?>
                                </div>
                                <div class="de-content">
                                    <span class="dle-t"><?php echo $re['title']; ?></span>
                                    <span class="dle-p"><?php echo $re['prof']; ?></span>
                                    <div class="dle-text">
                                        <p>
                                            <?php echo $re['text']; ?>
                                        </p>
                                    </div>
                                </div>

                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
        }

        ?>

        <?php


        $sqled = "SELECT * FROM `achievement` WHERE `user` = :t";
        $stmted = $PDO->prepare($sqled);
        $stmted->bindValue(':t', $user['id']);
        $stmted->execute();
        if ($stmted->rowCount() > 0) {
            ?>
            <div class="resume-d-exp res-bag">
                                <span><m><i class="mdi mdi-trophy-variant-outline"></i></m> Достижения
                                    <?php


                                    ?>
                                </span>
                <div class="db-text">
                    <ul class="dds-exp">
                        <?php
                        while ($rx = $stmted->fetch()) {
                            ?>
                            <li>
                                <div class="dle-title">
                                    <span class="dle-t"><?php echo $rx['name']; ?></span>
                                    <span class="dle-time"><?php echo $rx['type']; ?></span>
                                </div>
                                <div class="dle-text">
                                    <p> <?php echo $rx['text']; ?></p>
                                </div>
                                <?php




                                    $sqlei = "SELECT * FROM `achievement_images` WHERE `user_id` = :ui AND `hash` = :hash ORDER BY `id` DESC";
                                    $stmtei = $PDO->prepare($sqlei);
                                    $stmtei->bindValue(':ui', $user['id']);
                                    $stmtei->bindValue(':hash', $rx['hash']);
                                    $stmtei->execute();

                                    if ($stmtei->rowCount() > 0) {


                                        ?>
                                        <div class="dle-img">
                                            <?php while ($i = $stmtei->fetch()) {

                                                $ext = mb_strtolower(mb_substr(mb_strrchr(@$i['filename'], '.'), 1));


                                                ?>
                                                <a class="none" href="/static/file/users_file/<?php echo $i['filename'] ?>" download=""><i class="icon-cloud-download"></i> .<?php echo $ext ?></a>


                                            <?php } ?>


                                        </div>
                                    <?php }

                                ?>
                            </li>

                            <?php

                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
        }
        ?>

        <div class="addi">
            <?php if ($user['inv'] == 1) {
                ?>
                <span><i class="mdi mdi-wheelchair"></i> Есть инвалидность</span>
                <?php
            } ?>
            <?php if ($user['go'] == 1) {
                ?>
                <span><i class="mdi mdi-plane-car"></i> Готов к переезду</span>
                <?php
            } ?>
        </div>

        <?php
        $sqlsk = "SELECT * FROM `skills_resume` WHERE `user_id` = :t ORDER BY `id` DESC";
        $stmtsk = $PDO->prepare($sqlsk);
        $stmtsk->bindValue(':t', (int) $user['id']);
        $stmtsk->execute();
        if ($stmtsk->rowCount() > 0) {
            ?>

            <div class="resume-d-skills res-bag">
                <span><m><i class="mdi mdi-brain"></i></m> Ключевые навыки</span>
                <div class="res-tags">
                    <?php
                    while ($rs = $stmtsk->fetch()) {
                        ?>
                        <div>
                            - <?php echo $rs['text'] ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>

        <?php
        $sqlsk = "SELECT * FROM `lang` WHERE `user` = :t ORDER BY `id` DESC";
        $stmtsk = $PDO->prepare($sqlsk);
        $stmtsk->bindValue(':t', (int) $user['id']);
        $stmtsk->execute();
        if ($stmtsk->rowCount() > 0) {
            ?>

            <div class="resume-d-lang res-bag">
                <span><m><i class="mdi mdi-translate"></i></m> Знание языков</span>
                <div class="res-tags">
                    <?php
                    while ($rs = $stmtsk->fetch()) {
                        ?>
                        <div>
                            <?php echo $rs['name'] ?> - <?php echo $rs['lvl'] ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>



    </div>



    <?php
} else {
    $app->notFound();
}
?>
