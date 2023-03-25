<?php

if (isset($_POST['send'])) {
    if (!empty($_POST['text']) and !empty($_POST['loc'])) exit(header('location: /job-list?key='.$_POST['text'].'&loc=' . $_POST['loc']));
    if (!empty($_POST['text']) and empty($_POST['loc'])) exit(header('location: /job-list?key=' . $_POST['text']));
    if (empty($_POST['text']) and !empty($_POST['loc'])) exit(header('location: /job-list?loc=' . $_POST['loc']));
    if (empty($_POST['text']) and empty($_POST['loc'])) exit(header('location: /job-list'));
}

Head('Обзор вакансий по отраслям во всех регионах');

?>
<body>

<?php require('template/base/nav.php'); ?>


<header id="header-search">
    <?php require('template/base/navblock.php'); ?>
    <div class="header-search-container">
        <div class="container">
            <form action="" method="POST">
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
                <div class="hs-container">

                        <span class="hs-h">Свежие вакансии</span>

                    <div class="header-input-container">
                        <div class="hi-field">
                            <i class="mdi mdi-magnify"></i>
                            <input class="hi-title" name="text" type="text" placeholder="Должность или ключевое слово">
                        </div>
                        <div class="hi-field">
                            <i class="mdi mdi-crosshairs-gps"></i>
                            <input class="hi-location" name="loc" type="text" placeholder="Город или регион" value="<?php echo $_GET['loc'] ?>">
                        </div>
                        <input type="submit" class="hs-bth" name="send" value="Найти">
                    </div>
                </div>
            </form>
        </div>
    </div>
</header>



<main id="wrapper" class="wrapper">


    <div class="job-list-section">
        <div class="container">
            <div class="section-nav">
                <span><a href="/">Главная</a></span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span>Обзор вакансий</span>
            </div>
            <div class="section-header">
                <span class="home-title">Обзор вакансий по отраслям во всех регионах</span>
            </div>
            <div class="section-items">
                <ul class="category-male">
                    <?php
                    $sql = $app->query("SELECT * FROM `category` ORDER BY `job` DESC");
                    while ($r = $sql->fetch()) {


                        $sqlc = "SELECT * FROM `vacancy` WHERE `category` = :n";
                        $stmtc = $PDO->prepare($sqlc);
                        $stmtc->bindValue(':n', $r['name']);
                             $stmtc->execute();

                             $salary = 0;
                             $i = 0;

                             while ($d = $stmtc->fetch()) {
                                 $salary += (int) $d['salary'] + $d['salary_end'];
                                 if ($d['salary'] > 0 && $d['salary_end'] > 0) {
                                     $i += 2;
                                 } else if ($d['salary'] > 0 && empty($d['salary_end'])) {
                                     $i += 1;
                                 } else if ($d['salary_end'] > 0 && empty($d['salary'])) {
                                     $i += 1;
                                 }
                             }

                             #$rw = $app->fetch('SELECT * FROM `vacancy` WHERE `category` = :id', [':id' => $r['name']])
                             ?>
                        <!--<li>
                            <a href="/category?id=<?php echo $r['id'] ?>">

                                <span><?php echo mb_strimwidth($r['name'], 0, 50, "..."); ?></span>
                                <span><?php echo $r['job']  ?></span>
                            </a>
                        </li>-->
                        <li>
                            <a href="/category?id=<?php echo $r['id'] ?>">
                                <div class="cat-b-1">
                                    <span><?php echo mb_strimwidth($r['name'], 0, 40, "..."); ?></span>
                                    <p><?php if ($i > 0) { echo ceil($salary / $i); } else { echo '0'; }  ?> руб. в среднем</p>
                                </div>
                                <div class="cat-b-2">
                            <span class="cat-icon">
                                <i class="mdi mdi-<?php echo $r['icon'];  ?>"></i>
                            </span>
                                </div>
                            </a>
                        </li>
                        <?php
                    }
                    ?>

                </ul>
            </div>
        </div>
    </div>
   








</main>

<?php require('template/base/footer.php'); ?>

</body>
</html>