<? if (empty($_GET['loc'])) { ?>
    <div class="map">
        <div class="left-menu">
            <ul>

    <?php
    $sql = $app->query("SELECT * FROM `map` WHERE `status` = 1 ORDER BY `id`");
    while ($r = $sql->fetch()) {
        ?>
        <li>
            <a data-name="<?php echo $r['text'] ?>" data-job="<?php echo $app->count("SELECT * FROM `vacancy` WHERE `district` = '$r[text]' AND `status` = 0"); ?>" href="/job-list?loc=<?php echo $r['code'] ?>" class="okrug-<?php echo $r['id'] ?> map-tab-link" data-color="<?php echo $r['color'] ?>">
                <div class="caption"><?php echo $r['text'] ?></div>
                <div class="label">Вакансий <?php echo $app->count("SELECT * FROM `vacancy` WHERE `district` = '$r[text]' AND `status` = 0"); ?></div>
            </a>
        </li>
        <?php
    }
    ?>
            </ul>
        </div>
        <div class="map-tooltip">
            <span class="tol-caption"></span>
        </div>
        <svg id="svg2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1073.05 603.37">
                <defs></defs>
                <g>

                    <?php
                    $sql = $app->query("SELECT * FROM `map` WHERE `status` = 1 ORDER BY `id`");
                    while ($r = $sql->fetch()) {
                        ?>

                        <a data-name="<?php echo $r['text'] ?>" data-job="<?php echo $app->count("SELECT * FROM `vacancy` WHERE `district` = '$r[text]' AND `status` = 0"); ?>" href="/job-list?loc=<?php echo $r['code'] ?>" class="okrug-<?php echo $r['id'] ?> map-tab-link" data-color="<?php echo $r['color'] ?>">
                            <?php echo $r['g'] ?>
                        </a>

                        <?php
                    }
                    ?>

                </g>

        </svg>
    </div>
<? } ?>


<?php if (isset($_GET['loc'])) { ?>



    <?php





        $countLoc = $app->count("SELECT * FROM `map_list` WHERE `map_code` = '$_GET[loc]' OR `map_name` LIKE '$_GET[loc]'");
        $countLoc2 = $app->count("SELECT * FROM `map_list` WHERE `code` = '$_GET[loc]' OR `name` LIKE '$_GET[loc]'");

        if ($countLoc > 0) {
    ?>

    <?php if ($loc == 'stav' || $loc == 'Ставропольский край') { ?>

                <?php
        if ($loc == 'Ставропольский край') {

                ?>
            <div class="map">
            <div class="left-menu" style="width: 80%;">
            <?php
                $sql = $app->query("SELECT * FROM `map_list` WHERE `map_code` = 'stav' ORDER BY `id`");
                $sql2 = $app->query("SELECT * FROM `map_list` WHERE `map_code` = 'stav' ORDER BY `id`");
                $rrd = $sql2->fetch();
                $gg = $app->fetch("SELECT * FROM `map` WHERE `id` = :code", [':code' => (int) $rrd['map_id']]);

                ?>
                <a class="reset-okr" href="/job-list"><i class="mdi mdi-arrow-left"></i> Обзор России</a>
                <ul>

                    <?php

                    while ($r = $sql->fetch()) {
                        ?>
                        <li>
                            <a data-name="<?php echo $r['name'] ?>" data-job="<?php echo $app->count("SELECT * FROM `vacancy` WHERE (`region` = '$r[name]' OR `area` = '$r[name]' OR `address` = '$r[name]') AND `status` = 0"); ?>" href="/job-list?loc=<?php echo $r['code'] ?>" class="okrug-<?php echo $r['id'] ?> map-tab-link" data-color="<?php echo $r['color'] ?>">
                                <div class="caption"><?php echo $r['name'] ?></div>
                                <div class="label">Вакансий <?php echo $app->count("SELECT * FROM `vacancy` WHERE (`region` = '$r[name]' OR `area` = '$r[name]' OR `address` = '$r[name]') AND `status` = 0"); ?></div>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                </div>
                <div class="map-tooltip">
                    <span class="tol-caption"></span>
                </div>
                <svg id="svg2" xmlns="http://www.w3.org/2000/svg" viewBox="<?php echo $gg['view']; ?>">
                    <defs></defs>
                    <g>

                        <?php
                        $sql = $app->query("SELECT * FROM `map_list` WHERE `map_code` = 'stav' ORDER BY `name` DESC");
                        while ($r = $sql->fetch()) {
                            ?>

                            <a data-name="<?php echo $r['name'] ?>" data-job="<?php echo $app->count("SELECT * FROM `vacancy` WHERE (`region` = '$r[name]' OR `area` = '$r[name]' OR `address` = '$r[name]') AND `status` = 0"); ?>" href="/job-list?loc=<?php echo $r['code'] ?>" class="okrug-<?php echo $r['id'] ?> map-tab-link" data-color="<?php echo $r['color'] ?>">
                                <?php echo $r['g'] ?>
                            </a>

                            <?php
                        }
                        ?>

                    </g>

                </svg>
                </div>
                <?php
            } else {

                ?>
                <div class="map">
                    <div class="left-menu" style="width: 80%;">
                        <?php
                        $sql = $app->query("SELECT * FROM `map_list` WHERE `map_code` = '$_GET[loc]' ORDER BY `id`");
                        $sql2 = $app->query("SELECT * FROM `map_list` WHERE `map_code` = '$_GET[loc]' ORDER BY `id`");
                        $rrd = $sql2->fetch();
                        $gg = $app->fetch("SELECT * FROM `map` WHERE `id` = :code", [':code' => (int) $rrd['map_id']]);

                        ?>
                        <a class="reset-okr" href="/job-list"><i class="mdi mdi-arrow-left"></i> Обзор России</a>
                        <ul>

                            <?php

                            while ($r = $sql->fetch()) {
                                ?>
                                <li>
                                    <a data-name="<?php echo $r['name'] ?>" data-job="<?php echo $app->count("SELECT * FROM `vacancy` WHERE (`region` = '$r[name]' OR `area` = '$r[name]' OR `address` = '$r[name]') AND `status` = 0"); ?>" href="/job-list?loc=<?php echo $r['code'] ?>" class="okrug-<?php echo $r['id'] ?> map-tab-link" data-color="<?php echo $r['color'] ?>">
                                        <div class="caption"><?php echo $r['name'] ?></div>
                                        <div class="label">Вакансий <?php echo $app->count("SELECT * FROM `vacancy` WHERE (`region` = '$r[name]' OR `area` = '$r[name]' OR `address` = '$r[name]') AND `status` = 0"); ?></div>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="map-tooltip">
                        <span class="tol-caption"></span>
                    </div>
                    <svg id="svg2" xmlns="http://www.w3.org/2000/svg" viewBox="<?php echo $gg['view']; ?>">
                        <defs></defs>
                        <g>

                            <?php
                            $sql = $app->query("SELECT * FROM `map_list` WHERE `map_code` = '$_GET[loc]' ORDER BY `name` DESC");
                            while ($r = $sql->fetch()) {
                                ?>

                                <a data-name="<?php echo $r['name'] ?>" data-job="<?php echo $app->count("SELECT * FROM `vacancy` WHERE (`region` = '$r[name]' OR `area` = '$r[name]' OR `address` = '$r[name]') AND `status` = 0"); ?>" href="/job-list?loc=<?php echo $r['code'] ?>" class="okrug-<?php echo $r['id'] ?> map-tab-link" data-color="<?php echo $r['color'] ?>">
                                    <?php echo $r['g'] ?>
                                </a>

                                <?php
                            }
                            ?>

                        </g>

                    </svg>
                </div>
                <?php
            }

                ?>



    <?php } else {


        ?>


        <div class="map">
            <div class="left-menu" style="width: 80%;">
                <?php
                $sql = $app->query("SELECT * FROM `map_list` WHERE `map_code` = '$_GET[loc]' OR `map_name` LIKE '%$_GET[loc]%' ORDER BY `id`");
                $sql2 = $app->query("SELECT * FROM `map_list` WHERE `map_code` = '$_GET[loc]' OR `map_name` LIKE '%$_GET[loc]%' ORDER BY `id`");
                $rrd = $sql2->fetch();
                $gg = $app->fetch("SELECT * FROM `map` WHERE `id` = :code", [':code' => (int) $rrd['map_id']]);
                ?>
                <a class="reset-okr" href="/job-list"><i class="mdi mdi-arrow-left"></i> Обзор России</a>
                <ul>

                    <?php

                    while ($r = $sql->fetch()) {
                        ?>
                        <li>
                            <a data-name="<?php echo $r['name'] ?>" data-job="<?php echo $app->count("SELECT * FROM `vacancy` WHERE (`region` = '$r[name]' OR `area` = '$r[name]' OR `address` = '$r[name]') AND `status` = 0"); ?>" href="/job-list?loc=<?php echo $r['code'] ?>" class="okrug-<?php echo $r['id'] ?> map-tab-link" data-color="<?php echo $r['color'] ?>">
                                <div class="caption"><?php echo $r['name'] ?></div>
                                <div class="label">Вакансий <?php echo $app->count("SELECT * FROM `vacancy` WHERE (`region` = '$r[name]' OR `area` = '$r[name]' OR `address` = '$r[name]') AND `status` = 0"); ?></div>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="map-tooltip">
                <span class="tol-caption"></span>
            </div>
            <svg id="svg2" xmlns="http://www.w3.org/2000/svg" viewBox="<?php echo $gg['view']; ?>">
                <defs></defs>
                <g>

                    <?php
                    $sql = $app->query("SELECT * FROM `map_list` WHERE `map_code` = '$_GET[loc]' OR `map_name` LIKE '%$_GET[loc]%' ORDER BY `id`");
                    while ($r = $sql->fetch()) {
                        ?>

                        <a data-name="<?php echo $r['name'] ?>" data-job="<?php echo $app->count("SELECT * FROM `vacancy` WHERE (`region` = '$r[name]' OR `area` = '$r[name]' OR `address` = '$r[name]') AND `status` = 0"); ?>" href="/job-list?loc=<?php echo $r['code'] ?>" class="okrug-<?php echo $r['id'] ?> map-tab-link" data-color="<?php echo $r['color'] ?>">
                            <?php echo $r['g'] ?>
                        </a>

                        <?php
                    }
                    ?>

                </g>

            </svg>
        </div>

    <?php } ?>

    <?php } else if ($countLoc2 > 0) {



    }?>

<? } ?>










