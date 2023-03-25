<?php


if (isset($_SESSION['id']) && isset($_SESSION['password'])) {

    if ($_SESSION['type'] == 'users') {
        $r = $app->fetch("SELECT * FROM `users` WHERE `id` = :id", [':id' => $_SESSION['id']]);
    
        if (empty($r['id'])) {
            $app->notFound();
            exit;
        }
    } else if ($_SESSION['type'] == 'company') {
        $r = $app->fetch("SELECT * FROM `company` WHERE `id` = :id", [':id' => $_SESSION['id']]);
    
        if (empty($r['id'])) {
            $app->notFound();
            exit;
        }
    } else {
        $app->notFound();
        exit;
    }



    /*if (isset($_POST["save-data-user"])) {
        $err = [];

        if (empty($err)) {
            $name = XSS_DEFENDER($_POST['name']);
            $surname = XSS_DEFENDER($_POST['surname']);
            $patronymic = XSS_DEFENDER($_POST['patronymic']);
            $email = XSS_DEFENDER($_POST['email']);
            $faculty = XSS_DEFENDER($_POST['faculty']);
            $direction = XSS_DEFENDER($_POST['direction']);
            $degree = XSS_DEFENDER($_POST['degree']);
            $phone = XSS_DEFENDER($_POST['phone']);
            $about = preg_replace ( "'<script[^>]*?>.*?</script>'si", "", $_POST['about']);
            $about = str_replace($xss,"",$about);
            $age = XSS_DEFENDER($_POST['age']);
            $gender = XSS_DEFENDER($_POST['gender']);
            $exp = XSS_DEFENDER($_POST['exp']);
            $time = XSS_DEFENDER($_POST['time']);
            $category = XSS_DEFENDER($_POST['category']);
            $prof = XSS_DEFENDER($_POST['prof']);
            $salary = XSS_DEFENDER($_POST['salary']);
            $drive = XSS_DEFENDER($_POST['drive']);
            $type = XSS_DEFENDER($_POST['type']);
            $stat = XSS_DEFENDER($_POST['stat']);
            $car = XSS_DEFENDER($_POST['car']);
            $go = XSS_DEFENDER($_POST['go']);
            $inv = XSS_DEFENDER($_POST['inv']);
            if ($car == 1) $car = 1;
            else $car = 0;
            if ($go == 1) $go = 1;
            else $go = 0;
            if ($inv == 1) $inv = 1;
            else $inv = 0;




            $app->execute("UPDATE `users` SET 
                `about` = :about,
                `stat` = :stat,
                `type` = :typ,
                `name` = :nam,
                `surname` = :surname,
                `patronymic` = :patronymic,
                `email` = :email, 
                `faculty` = :faculty,
                `direction` = :direction,
                `degree` = :degree,
                `phone` = :phone,
                `age` = :age,
                `gender` = :gender,
                `exp` = :exp,
                `time` = :ti,
                `category` = :category,
                `prof` = :prof,
                `salary` = :salary,
                `car` = :car,
                `drive` = :drive,
                `go` = :g,
                `inv` = :inv,
                `last_save` = :lastsave WHERE `id` = :id", [
                ':about' => $about,
                ':stat' => $stat,
                ':typ' => $type,
                ':nam' => $name,
                ':surname' => $surname,
                ':patronymic' => $patronymic,
                ':email' => $email,
                ':faculty' => $faculty,
                ':direction' => $direction,
                ':degree' => $degree,
                ':phone' => $phone,
                ':age' => $age,
                ':gender' => $gender,
                ':exp' => $exp,
                ':ti' => $time,
                ':category' => $category,
                ':prof' => $prof,
                ':salary' => $salary,
                ':car' => $car,
                ':drive' => $drive,
                ':g' => $go,
                ':inv' => $inv,
                ':lastsave' => $Date_ru . ' ' . date('H:i'),
                ':id' => $_SESSION['id']
            ]);

            $success = "Данные успешно изменены.";
        }
    }*/

    /*if (isset($_POST["save-data-comp"])) {
        $err = [];

        if (empty($err)) {
            $username = XSS_DEFENDER($_POST['username']);
            $inn = XSS_DEFENDER($_POST['inn']);
            $about = preg_replace ( "'<script[^>]*?>.*?</script>'si", "", $_POST['about']);
            $about = str_replace($xss,"",$about);
            $phone = XSS_DEFENDER($_POST['phone']);
            $addres = XSS_DEFENDER($_POST['address']);
            $people = XSS_DEFENDER($_POST['people']);
            $specialty = XSS_DEFENDER($_POST['specialty']);
            $website = XSS_DEFENDER($_POST['website']);
            $middle = XSS_DEFENDER($_POST['middle']);
            $type = XSS_DEFENDER($_POST['type']);

            $app->execute("UPDATE `company` SET 
                `inn` = :inn,
                `username` = :usern,
                `about` = :about, 
                `phone` = :phone,
                `address` = :addres, 
                `people` = :people,
                `specialty` = :specialty,
                `website` = :website,
                `middle` = :mid,
                 `type` = :tp WHERE `id` = :id", [
                ':inn' => $inn,
                ':usern' => $username,
                ':about' => $about,
                ':phone' => $phone,
                ':addres' => $addres,
                ':people' => $people,
                ':specialty' => $specialty,
                ':website' => $website,
                ':mid' => $middle,
                ':tp' => $type,
                ':id' => $_SESSION['id']
            ]);

            $success = "Данные успешно изменены.";
        }
    }*/






    if (isset($_POST["save-banner"])) {
        $avatar = '';

        if(file_exists($_FILES['file-ban']['tmp_name']) || is_uploaded_file($_FILES['file-up']['tmp_name'])) {
            $avatar = $_FILES['file-ban'];
            move_uploaded_file($avatar['tmp_name'], '/home/s/stgau/public_html/static/image/company_banner/' . $_SESSION['company'] . '_' . $avatar['name']);
            $avatar = $_SESSION['company'] . '_' . $avatar['name'];
            $app->execute("UPDATE `company` SET `baner` = :img WHERE `id` = :id", [
                ':img' => $avatar,
                ':id' => $_SESSION['id']
            ]);
            $success = "Баннер успешно изменен";
        } else {
            $success = "Изображение не загружено";
        }


    }


    if ($_SESSION['type'] == 'users') {
        if (isset($_POST["delete-logo-user"])) {
            $avatar = '';

            $app->execute("UPDATE `users` SET `img` = :img WHERE `id` = :id", [
                ':img' => 'placeholder.png',
                ':id' => $_SESSION['id']
            ]);
        }
    } else if ($_SESSION['type'] == 'company') {
        if (isset($_POST["delete-logo-user"])) {
            $avatar = '';

            $app->execute("UPDATE `company` SET `img` = :img WHERE `id` = :id", [
                ':img' => 'placeholder.png',
                ':id' => $_SESSION['id']
            ]);

            $app->execute("UPDATE `vacancy` SET `img` = :img WHERE `company_id` = :id", [
                ':img' => 'placeholder.png',
                ':id' => $_SESSION['id']
            ]);

            $app->execute("UPDATE `chat` SET `com_img` = :img WHERE `company_id` = :id", [
                ':img' => 'placeholder.png',
                ':id' => $_SESSION['id']
            ]);

        }

        if (isset($_POST["delete-logo-baner"])) {
            $avatar = '';

            $app->execute("UPDATE `company` SET `baner` = :img WHERE `id` = :id", [
                ':img' => '',
                ':id' => $_SESSION['id']
            ]);

        }
    }



    if (isset($_POST["upload-office"])) {
        $avatar = '';
        if(file_exists($_FILES['file-office']['tmp_name']) || is_uploaded_file($_FILES['file-office']['tmp_name'])) {
            $avatar = $_FILES['file-office'];
            move_uploaded_file($avatar['tmp_name'], '/home/s/stgau/public_html/static/image/c_office/' . $_SESSION['id'] . '_' . $avatar['name']);
            $avatar = $_SESSION['id'] . '_' . $avatar['name'];
            $app->execute("INSERT INTO `office_img` (`company`, `company_id`, `img`) VALUES(:cn, :ci, :im)", [
                ':cn' => $r['name'],
                ':ci' => $r['id'],
                ':im' => $avatar
            ]);
            $success = "Фото успешно загружено!";
            $app->go('/');
        } else {
            $success = "Произошла ошибка.";
        }
    }





    if (isset($_POST['edit-mail'])) {

        if ($_SESSION['type'] == 'company') {
            $email = XSS_DEFENDER($_POST['email-inp']);
        }

    }

    Head('Профиль');
?>
<body class="profile-body">

<?php if ($_SESSION['type'] == 'company') { ?>
    <div class="banner-popup">
        <form enctype="multipart/form-data" action="" method="POST">
            <div class="banner-container">
                <div class="ap-title">
                    Изменить баннер
                    <i class="mdi mdi-close ap-close"></i>
                </div>
                <div class="ap-cnt-2">
                    <div class="upload-block">
                        <div class="uploadButton-block">
                            <input class="uploadButton-input" type="file" name="file-ban" accept=".jpg,.jpeg,.png,.avif"  id="upload_banner">
                            <label class="uploadButton-button ripple-effect" for="upload_banner" style="">
                                <i class="icon-cloud-upload"></i>
                                Нажмите для загрузки файла
                                <br />
                                Рекомендуемое разрешение 1920 x 640!
                                <br />
                                PNG, JPG, AVIF
                            </label>
                            <span class="uploadButton-file-name"></span>
                        </div>
                        <div class="text"></div>
                    </div>

                    <div class="image-box"></div>
                </div>
                <div class="ap-bth">
                    <input class="more-inf" type="submit" name="save-banner" value="Сохранить">
                </div>
            </div>
        </form>
    </div>
<?php } ?>


<div class="avatar-popup">
    <?php if ($_SESSION['type'] == 'company') { ?>
        <form enctype="multipart/form-data" action="" method="POST" class="img-form">
            <div class="avatarp-container">
                <div class="ap-title">
                    Изменить аватар
                    <i class="mdi mdi-close ap-close"></i>
                </div>
                <div class="ap-cnt-2">
                    <div class="upload-block">
                        <div class="uploadButton-block">
                            <input class="uploadButton-input upload-cxt upload-user" type="file" name="file-up" accept=".png" id="upload">
                            <label class="uploadButton-button ripple-effect" for="upload" style="">
                                <i class="icon-cloud-upload"></i>
                                Нажмите для загрузки файла
                                <br />
                                PNG
                            </label>
                            <span class="uploadButton-file-name"></span>
                        </div>
                        <div class="text"></div>
                    </div>

                    <div class="image-box"></div>
                </div>

                <div class="ap-bth">
                    <button id="save-logo" class="img-go bth" name="save-img" type="button">Сохранить</button>
                </div>
            </div>
        </form>
    <?php } ?>
    <?php if ($_SESSION['type'] == 'users') { ?>
        <form enctype="multipart/form-data" action="" method="POST" class="img-form">
            <div class="avatarp-container">
                <div class="ap-title">
                    Изменить аватар
                    <i class="mdi mdi-close ap-close"></i>
                </div>
                <div class="ap-cnt-2">
                    <div class="upload-block">
                        <div class="uploadButton-block">
                            <input class="uploadButton-input upload-cxt upload-user" type="file" name="file-up" accept=".png" id="upload">
                            <label class="uploadButton-button ripple-effect" for="upload" style="">
                                <i class="icon-cloud-upload"></i>
                                Нажмите для загрузки файла
                                <br />
                                PNG
                            </label>
                            <span class="uploadButton-file-name"></span>
                        </div>
                        <div class="text"></div>
                    </div>

                    <div class="image-box"></div>
                </div>

                <div class="ap-bth">
                    <button id="save-logo" class="img-go bth" name="save-img" type="button">Сохранить</button>
                </div>
            </div>
        </form>
    <?php } ?>
</div>

<main class="wrapper wrapper-profile" id="wrapper">


    <?php require('template/more/profileAside.php'); ?>

    <section class="profile-base">

        <?php require('template/more/profileHeader.php'); ?>
    

        <div class="profile-content profile">

            <div class="errors-block-fix">

            </div>

            <?php if (isset($success)) { ?>
                <div class="alert-block">
                    <div>
                        <span><?php echo $success; ?></span>
                    </div>
                    <span class="exp-ed"><i class="mdi mdi-close"></i></span>    
                </div>
            <?php } ?>
            <?php if (empty(trim($r['about'])) && $_SESSION['type'] == 'company') { ?>
                <div class="alert-block">
                    <div>
                        <span>Пожалуйста заполните поле "О компании", чтобы информация о Вас корректно изображалась на сайте.</span>
                        </br />
                    </div>
                    <span class="exp-ed"><i class="mdi mdi-close"></i></span>  
                </div>
            <?php } ?>




            <div class="profile-data">


                <?php if ($_SESSION['type'] == 'users') { ?>
                <div class="data-flex">
                  <!--  <div class="al-stats" style="margin: 0 0 30px 0;">
                        <ul>

                            <li>
                                <div class="as-t">
                                    <?php
                                    $views_r = $app->count("SELECT * FROM `online_resume` WHERE `users` = $r[id]");
                                    ?>

                                    <span class="as-tt"><?php echo $views_r; ?></span>
                                    <span class="as-tk">Сейчас смотрят</span>
                                </div>
                                <div class="as-i"><i class="mdi mdi-eye-outline"></i></div>

                            </li>
                            <li>
                                <div class="as-t">
                                    <span class="as-tt"><?php echo $r['view'] ?></span>
                                    <span class="as-tk">Всего просмотров</span>
                                </div>
                                <div class="as-i"><i class="mdi mdi-database-eye-outline"></i></div>

                            </li>
                            <li>
                                <div class="as-t">
                                    <span class="as-tt"><?php echo $app->rowCount("SELECT * FROM `respond` WHERE `user_id` = :id", [':id' => $r['id']]); ?></span>
                                    <span class="as-tk">Всего откликов</span>
                                </div>
                                <div class="as-i"><i class="mdi mdi-briefcase-variant-outline"></i></div>

                            </li>
                        </ul>
                    </div>-->

                    <? include 'template/more/profileHead.php'; ?>

                    <div style="margin-bottom: 30px" class="pr-data-block block-p bl-1">
                        <span>Данные для резюме</span>
                        <form role="form" class="form-profile" method="POST">




                            <!--<div class="uploads-block">
                                <span class="image-block">
                                    <img src="/static/image/users/<?php echo $r['img'] ?>" alt="">
                                </span>

                                    <div class="picture-block">
                                        <input style="display:none;" class="uploadButton-input" type="file" name="file-up" id="upload-logo" accept=".jpg,.jpeg,.png,.gif,.svg">
                                        <label for="upload-logo">

                                            <span><i class="mdi mdi-cloud-upload-outline"></i></span>
                                            Нажмите для загрузки <br />
                                            SVG, PNG, JPG или GIF (макс. 400 x 400 p.)

                                        </label>

                                    </div>

                            </div>-->




                            <div class="pfa-wrap">
                                <div class="pfa-a pfa-user">

                                    <span>
                                        <img src="/static/image/users/<?php echo $r['img'] ?>" alt="">
                                            <div class="pfa-a-bth"><i class="mdi mdi-pencil"></i></div>
    <?php if ($r['img'] != 'placeholder.png') { ?>
                                            <button type="submit" name="delete-logo-user"><span class="mdi mdi-window-close"></span></button>
    <?php } ?>
                                    </span>
                                </div>
                                <div class="ini-text">разрешенные типы файлов: png</div>
                            </div>

                            <div class="label-block">
                                <label for="">Желаемая профессия  <span>*</span></label>
                                <input type="text" id="prof" name="prof" placeholder="" value="<?php echo $r['prof'] ?>">
                                <span class="empty e-prof">Это поле не должно быть пустым</span>
                            </div>
                            <!--<div class="label-block">
                                <label for="address_c">В каком городе Вы хотите работать?</label>
                                <div class="label-select-block">
                                    <select name="address" class="city_res"  placeholder="Выберите город">
                                        <option value="">Выбрать</option>
                                        <? foreach ($city as $key => $val) { ?>
                                            <option value="<? echo $val ?>"><? echo $val ?></option>
                                        <? } ?>
                                    </select>
                                    <div class="label-arrow">
                                        <i class="mdi mdi-chevron-down"></i>
                                    </div>
                                </div>
                            </div>-->
                            <div class="flex f-n">
                                <div class="label-block au-fn au-fn-1">
                                    <label for="">Имя <span>*</span></label>
                                    <input type="text" id="name" name="name" value="<?php echo $r['name'] ?>" placeholder="">
                                    <span class="empty e-name">Это поле не должно быть пустым</span>
                                </div>

                                <div class="label-block au-fn">
                                    <label for="">Фамилия <span>*</span></label>
                                    <input type="text" id="surname" name="surname" value="<?php echo $r['surname'] ?>" placeholder="">
                                    <span class="empty e-surname">Это поле не должно быть пустым</span>
                                </div>

                                <div class="label-block au-fn au-fn-2">
                                    <label for="">Отчество <span>*</span></label>
                                    <input type="text" id="patronymic" name="patronymic"value="<?php echo $r['patronymic'] ?>" placeholder="">
                                    <span class="empty e-patronymic">Это поле не должно быть пустым</span>
                                </div>
                            </div>



                                <div class="label-block au-fn au-fn-1">
                                    <label for="">Дата рождения <span>*</span></label>
                                    <div class="label-date-block">
                                        <div>
                                            <input maxlength="2" size="4" type="number" inputmode="numeric" name="date-1" id="date-1" placeholder="День" value="<?

                                            if (!empty($r['age'])) {
                                                    echo DateTime::createFromFormat('d.m.Y', $r['age'])->format('d');
                                            }

                                           ?>">

                                        </div>
                                        <div>
                                            <select name="date-2" id="date-2">
                                                <?php
                                                $job_type = ['', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];

                                                if (!empty($r['age'])) {
                                                    foreach ($job_type as $key) {
                                                        if (DateTime::createFromFormat('d.m.Y', $r['age'])->format('m') == $key) {
                                                            echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                        } else {
                                                            echo '<option value="'.$key.'">'.$key.'</option>';
                                                        }
                                                    }
                                                } else {
                                                    foreach ($job_type as $key) {
                                                        echo '<option value="'.$key.'">'.$key.'</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div>
                                            <input value="<?
                                            if (!empty($r['age'])) {
                                                echo DateTime::createFromFormat('d.m.Y', $r['age'])->format('Y');
                                            }

                                            ?>" type="number" maxlength="4" size="4" inputmode="numeric" name="date-3" id="date-3" placeholder="Год">

                                        </div>
                                      </div>
                                    <span class="empty e-date e-date-1 e-date-2 e-date-3">Некорректная дата</span>
                                </div>

                                <div class="label-block-radio au-fn">
                                    <label for="">Пол <span>*</span></label>
                                    <div class="label-radio-block">

                                        <p>
                                            <input <?php if ($r['gender'] == 'Мужской') echo 'checked' ?> class="custom-radio" name="gender" type="radio" id="q101" value="Мужской">
                                            <label for="q101">Мужской</label>
                                        </p>

                                        <p>
                                            <input <?php if ($r['gender'] == 'Женский') echo 'checked' ?> class="custom-radio" name="gender" type="radio" id="q102" value="Женский">
                                            <label for="q102">Женский</label>
                                        </p>

                                    </div>
                                    <span class="empty e-radio">Это поле не должно быть пустым</span>
                                </div>


                            <div class="flex f-n">

                                <div class="label-block au-fn au-fn-1">
                                    <label for="email">E-mail <span>*</span></label>
                                    <input disabled type="email" value="<?php echo $r['email'] ?>" placeholder="">
                                    <span class="label-block-a edit-email">Изменить</span>
                                </div>

                                <div class="label-block au-fn">
                                    <label for="">Телефон <span>*</span></label>
                                    <input  type="tel" id="tel" name="phone" value="<?php echo $r['phone'] ?>" placeholder="+7 (999) 999-99-99">
                                    <span class="empty e-tel">Это поле не должно быть пустым</span>
                                </div>
                            </div>

                            <div class="label-block">
                                <label for="">О себе</label>
                                <textarea name="about" id="about" cols="30" rows="5"><?php echo $r['about'] ?></textarea>
                            </div>


                            <div class="label-block">
                                <label for="">Гражданство <span>*</span></label>
                                <div class="label-select-block">
                                    <select name="nationality" id="nationality">
                                        <?php
                                        $job_type = ['Российская Федерация', 'Инностранное гражданство'];

                                        if (isset($r['nationality'])) {
                                            foreach ($job_type as $key) {
                                                if ($r['nationality'] == $key) {
                                                    echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                } else {
                                                    echo '<option value="'.$key.'">'.$key.'</option>';
                                                }
                                            }
                                        } else {
                                            foreach ($job_type as $key) {
                                                echo '<option value="'.$key.'">'.$key.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="label-arrow">
                                        <i class="mdi mdi-chevron-down"></i>
                                    </div>
                                </div>
                                <span class="empty e-nationality">Это поле не должно быть пустым</span>
                            </div>

                            <div class="label-block">
                                <label class="" for="">Статус поиска</label>
                                <div class="label-select-block">
                                    <select name="stat" id="">
                                        <option value="">Выбрать</option>
                                        <?php
                                        $job_type = ['В активном поиске', 'Рассматриваю предложения', 'Не ищу работу', 'Предложили работу', 'Вышел(-а) на новое место'];

                                        if (isset($r['stat'])) {
                                            foreach ($job_type as $key) {
                                                if ($r['stat'] == $key) {
                                                    echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                } else {
                                                    echo '<option value="'.$key.'">'.$key.'</option>';
                                                }
                                            }
                                        } else {
                                            foreach ($job_type as $key) {
                                                echo '<option value="'.$key.'">'.$key.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="label-arrow">
                                        <i class="mdi mdi-chevron-down"></i>
                                    </div>
                                </div>
                            </div>







                            <div class="flex f-n">
                                <div class="label-block au-fn au-fn-1">
                                    <label for="">Сфера деятельности</label>
                                    <div class="label-select-block">
                                        <select name="category" id="category" <? if (isset($err['category'])) { ?> class="errors" <? } ?>>
                                            <option value="">Выбрать</option>
                                            <?php
                                            $cat = [];
                                            $sqlc = $app->query("SELECT * FROM `category`");
                                            while ($c = $sqlc->fetch()) {
                                                $cat[] = $c['name'];
                                            }

                                            if (isset($r['category'])) {
                                                foreach ($cat as $key) {
                                                    if ($r['category'] == $key) {
                                                        echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                    } else {
                                                        echo '<option value="'.$key.'">'.$key.'</option>';
                                                    }
                                                }
                                            } else {
                                                foreach ($cat as $key) {
                                                    echo '<option value="'.$key.'">'.$key.'</option>';
                                                }
                                            }
                                            ?>

                                        </select>
                                        <div class="label-arrow">
                                            <i class="mdi mdi-chevron-down"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="label-block au-fn">
                                    <label for="email">Опыт работы в сфере</label>
                                    <div class="label-select-block">
                                        <select name="exp" id="">
                                            <option value="">Выбрать</option>
                                            <?php
                                            $exp = ['Без опыта', '1-3 года', '3-6 лет', 'Более 6 лет'];

                                            if (isset($r['exp'])) {
                                                foreach ($exp as $key) {
                                                    if ($r['exp'] == $key) {
                                                        echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                    } else {
                                                        echo '<option value="'.$key.'">'.$key.'</option>';
                                                    }
                                                }
                                            } else {
                                                foreach ($exp as $key) {
                                                    echo '<option value="'.$key.'">'.$key.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="label-arrow">
                                            <i class="mdi mdi-chevron-down"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <?php $timeMe = explode(", ", $r['time']); ?>


                            <div class="flex f-n">
                                <div class="label-block au-fn au-fn-1">
                                    <label for="time[]">График работы</label>
                                    <div class="label-check-block">
                                        <div>
                                            <input <?php if (in_array("Полный рабочий день", $timeMe)) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="t1" name="time[]" value="1">
                                            <label for="t1">
                                                Полный рабочий день
                                            </label>
                                        </div>
                                        <div>
                                            <input <?php if (in_array("Сменный график", $timeMe)) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="t2" name="time[]" value="2">
                                            <label for="t2">
                                                Сменный график
                                            </label>
                                        </div>
                                        <div>
                                            <input <?php if (in_array("Гибкий график", $timeMe)) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="t3" name="time[]" value="3">
                                            <label for="t3">
                                                Гибкий график
                                            </label>
                                        </div>
                                        <div>
                                            <input <?php if (in_array("Вахтовый метод", $timeMe)) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="t4" name="time[]" value="4">
                                            <label for="t4">
                                                Вахтовый метод
                                            </label>
                                        </div>
                                        <div>
                                            <input <?php if (in_array("Ненормированный рабочий день", $timeMe)) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="t5" name="time[]" value="5">
                                            <label for="t5">
                                                Ненормированный рабочий день
                                            </label>
                                        </div>
                                    </div>


                                    <!--<div class="label-select-block">
                                        <select name="time" id="">
                                            <option value="">Выбрать</option>
                                            <?php
                                            $time = ['Полный рабочий день', 'Гибкий график', 'Сменный график', 'Ненормированный рабочий день', 'Вахтовый метод', 'Неполный рабочий день'];

                                            if (isset($r['time'])) {
                                                foreach ($time as $key) {
                                                    if ($r['time'] == $key) {
                                                        echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                    } else {
                                                        echo '<option value="'.$key.'">'.$key.'</option>';
                                                    }
                                                }
                                            } else {
                                                foreach ($time as $key) {
                                                    echo '<option value="'.$key.'">'.$key.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="label-arrow">
                                            <i class="mdi mdi-chevron-down"></i>
                                        </div>
                                    </div>-->
                                </div>

                                <?php $typeMe = explode(", ", $r['type']); ?>

                                <div class="label-block au-fn">
                                    <label for="type[]">Тип занятости</label>

                                    <div class="label-check-block">
                                        <div>
                                            <input <?php if (in_array("Полная занятость", $typeMe)) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="y1" name="type[]" value="1">
                                            <label for="y1">
                                                Полная занятость
                                            </label>
                                        </div>
                                        <div>
                                            <input <?php if (in_array("Частичная занятость", $typeMe)) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="y2" name="type[]" value="2">
                                            <label for="y2">
                                                Частичная занятость
                                            </label>
                                        </div>
                                        <div>
                                            <input <?php if (in_array("Проектная работа", $typeMe)) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="y3" name="type[]" value="3">
                                            <label for="y3">
                                                Проектная работа
                                            </label>
                                        </div>
                                        <div>
                                            <input <?php if (in_array("Стажировка", $typeMe)) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="y4" name="type[]" value="4">
                                            <label for="y4">
                                                Стажировка
                                            </label>
                                        </div>
                                        <div>
                                            <input <?php if (in_array("Удаленная работа", $typeMe)) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="y5" name="type[]" value="5">
                                            <label for="y5">
                                                Удаленная работа
                                            </label>
                                        </div>
                                        <div>
                                            <input <?php if (in_array("Волонтерство", $typeMe)) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="y6" name="type[]" value="6">
                                            <label for="y6">
                                                Волонтерство
                                            </label>
                                        </div>
                                    </div>

                                    <!--<div class="label-select-block">
                                        <select name="type" id="">
                                            <option value="">Выбрать</option>
                                            <?php
                                            $job_type = ['Полная занятость', 'Частичная занятость', 'Временная', 'Стажировка', 'Сезонная', 'Удаленная'];

                                            if (isset($r['type'])) {
                                                foreach ($job_type as $key) {
                                                    if ($r['type'] == $key) {
                                                        echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                    } else {
                                                        echo '<option value="'.$key.'">'.$key.'</option>';
                                                    }
                                                }
                                            } else {
                                                foreach ($job_type as $key) {
                                                    echo '<option value="'.$key.'">'.$key.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="label-arrow">
                                            <i class="mdi mdi-chevron-down"></i>
                                        </div>
                                    </div>-->
                                </div>
                            </div>


                            <div class="label-block">
                                <label for="">Желаемая зарплата</label>
                                <div class="lb-block">
                                    <input type="number" id="salary" name="salary" value="<?php echo $r['salary'] ?>" placeholder="">
                                    <span class="lb-in">руб.</span>
                                </div>
                            </div>



                            <div class="label-block" style="margin: 0 0 6px 0;">
                                <label for="">Водительские права</label>
                                <div class="label-select-block">
                                    <select name="drive" id="">
                                        <option value="">Выбрать</option>
                                        <?php
                                        $job_type = ['Не имеются', 'A', 'B', 'C', 'D', 'E'];

                                        if (isset($r['drive'])) {
                                            foreach ($job_type as $key) {
                                                if ($r['drive'] == $key) {
                                                    echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                } else {
                                                    echo '<option value="'.$key.'">'.$key.'</option>';
                                                }
                                            }
                                        } else {
                                            foreach ($job_type as $key) {
                                                echo '<option value="'.$key.'">'.$key.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="label-arrow">
                                        <i class="mdi mdi-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="label-b-check">
                                <input <?php if ($r['car'] == 1) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="q2" name="car" value="1">
                                <label for="q2">
                                    имею личный автомобиль
                                </label>
                            </div>
                            <div class="label-b-check">
                                <input <?php if ($r['go'] == 1) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="q1" name="go" value="1">
                                <label for="q1">
                                    я готов(-а) к переезду
                                </label>
                            </div>
                            <div class="label-b-check">
                                <input <?php if ($r['inv'] == 1) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="q3" name="inv" value="1">
                                <label for="q3">
                                    у меня есть инвалидность
                                </label>
                            </div>

                            <div class="flex f-n">
                                <div class="label-block au-fn au-fn-1">
                                    <label for="">Vk</label>
                                    <input type="text" id="vk" name="vk" value="<?php echo $r['vk'] ?>" placeholder="Например, vk.com/profile">
                                </div>

                                <div class="label-block au-fn">
                                    <label for="">Telegram</label>
                                    <input type="text" id="telegram" name="telegram" value="<?php echo $r['telegram'] ?>" placeholder="Например, t.me/username">
                                </div>
                            </div>

                            <div class="flex f-n">
                                <div class="label-block au-fn au-fn-1">
                                    <label for="">GitHub</label>
                                    <input type="text" id="github" name="github" value="<?php echo $r['github'] ?>" placeholder="Например, https://github.com/profile">
                                </div>

                                <div class="label-block au-fn">
                                    <label for="">Skype</label>
                                    <input type="text" id="skype" name="skype" value="<?php echo $r['skype'] ?>" placeholder="">
                                </div>
                            </div>

                            <div class="pf-bth">
                                <button class="bth save-resume" type="button" name="">Сохранить</button>
                            </div>
                        </form>
                    </div>

                     <div class="pr-data-block block-p" style="margin: 0 0 30px 0;">
                        <span>Данные об обучении</span>
                        <form  enctype="multipart/form-data" class="form-profile form-profile-education" action="" method="post">

                            <div class="label-block">
                                <label for="">Образование <span>*</span></label>
                                <div class="label-select-block">
                                    <select name="degree" id="degree">
                                        <?php
                                        $job_type = ['Среднее профессиональное', 'Высшее (Бакалавриат)', 'Высшее (Специалитет)', 'Высшее (Магистратура)', 'Высшее (Аспирантура)'];

                                        if (isset($r['degree'])) {
                                            foreach ($job_type as $key) {
                                                if ($r['degree'] == $key) {
                                                    echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                } else {
                                                    echo '<option value="'.$key.'">'.$key.'</option>';
                                                }
                                            }
                                        } else {
                                            foreach ($job_type as $key) {
                                                echo '<option value="'.$key.'">'.$key.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="label-arrow">
                                        <i class="mdi mdi-chevron-down"></i>
                                    </div>
                                </div>
                                <span class="empty e-degree">Это поле не должно быть пустым</span>
                            </div>

                            <div class="label-block">
                                <label for="course">Курс <span>*</span></label>
                                <div class="label-radio-block">

                                    <p>
                                        <input <?php if ($r['course'] == 'Выпущен') echo 'checked' ?> class="custom-radio" name="course" type="radio" id="q201" value="Выпущен">
                                        <label for="q201">Выпущен</label>
                                    </p>

                                    <p>
                                        <input <?php if ($r['course'] == '1') echo 'checked' ?> class="custom-radio" name="course" type="radio" id="q202" value="1">
                                        <label for="q202">1</label>
                                    </p>

                                    <p>
                                        <input <?php if ($r['course'] == '2') echo 'checked' ?> class="custom-radio" name="course" type="radio" id="q203" value="2">
                                        <label for="q203">2</label>
                                    </p>

                                    <p>
                                        <input <?php if ($r['course'] == '3') echo 'checked' ?> class="custom-radio" name="course" type="radio" id="q204" value="3">
                                        <label for="q204">3</label>
                                    </p>

                                    <p>
                                        <input <?php if ($r['course'] == '4') echo 'checked' ?> class="custom-radio" name="course" type="radio" id="q205" value="4">
                                        <label for="q205">4</label>
                                    </p>

                                    <p>
                                        <input <?php if ($r['course'] == '5') echo 'checked' ?> class="custom-radio" name="course" type="radio" id="q206" value="5">
                                        <label for="q206">5</label>
                                    </p>

                                    <p>
                                        <input <?php if ($r['course'] == '6') echo 'checked' ?> class="custom-radio" name="course" type="radio" id="q207" value="6">
                                        <label for="q207">6</label>
                                    </p>


                                </div>
                                <span class="empty e-course">Это поле не должно быть пустым</span>
                            </div>



                            <div class="flex f-n">
                                <div class="label-block au-fn au-fn-1">
                                    <label for="financing">Тип финансирования <span>*</span></label>
                                    <select name="financing" id="financing">

                                        <?php
                                        $financing = ['Коммерция', 'Бюджет', 'Целевой приём', 'Квота ОП'];

                                        if (isset($r['financing'])) {
                                            foreach ($financing as $key) {
                                                if ($r['financing'] == $key) {
                                                    echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                } else {
                                                    echo '<option value="'.$key.'">'.$key.'</option>';
                                                }
                                            }
                                        } else {
                                            foreach ($financing as $key) {
                                                echo '<option value="'.$key.'">'.$key.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <span class="empty e-financing">Это поле не должно быть пустым</span>
                                </div>

                                <div class="label-block au-fn">
                                    <label for="form_education">Форма обучения <span>*</span></label>
                                    <select name="form_education" id="form_education">
                                        <?php
                                        $form_education = ['Очная', 'Очно-заочная', 'Заочная'];

                                        if (isset($r['form_education'])) {
                                            foreach ($form_education as $key) {
                                                if ($r['form_education'] == $key) {
                                                    echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                } else {
                                                    echo '<option value="'.$key.'">'.$key.'</option>';
                                                }
                                            }
                                        } else {
                                            foreach ($form_education as $key) {
                                                echo '<option value="'.$key.'">'.$key.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <span class="empty e-form_education">Это поле не должно быть пустым</span>
                                </div>
                            </div>

                            <div class="flex f-n">
                                <div class="label-block au-fn au-fn-1">
                                    <label class="" for="faculty">Факультет <span>*</span></label>
                                    <div class="label-select-block">
                                        <select name="faculty" id="faculty">
                                            <?php
                                            $job_type = [
                                                'Факультет агробиологии и земельных ресурсов', 'Факультет экологии и ландшафтной архитектуры',
                                                'Экономический факультет', 'Инженерно-технологический факультет',
                                                'Биотехнологический факультет', 'Факультет социально-культурного сервиса и туризма',
                                                'Электроэнергетический факультет', 'Учетно-финансовый факультет',
                                                'Факультет ветеринарной медицины', 'Факультет среднего профессионального образования'];

                                            if (isset($r['faculty'])) {
                                                foreach ($job_type as $key) {
                                                    if ($r['faculty'] == $key) {
                                                        echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                    } else {
                                                        echo '<option value="'.$key.'">'.$key.'</option>';
                                                    }
                                                }
                                            } else {
                                                foreach ($job_type as $key) {
                                                    echo '<option value="'.$key.'">'.$key.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="label-arrow">
                                            <i class="mdi mdi-chevron-down"></i>
                                        </div>
                                    </div>
                                    <span class="empty e-faculty">Это поле не должно быть пустым</span>
                                </div>



                                <div class="label-block au-fn"><label for="direction">Направление <span>*</span></label>
                                    <div class="label-select-block">
                                        <select class="select2-direction" name="direction" id="direction">
                                            <option selected value="<?php echo $r['direction'] ?>"><?php echo $r['direction'] ?></option>
                                            <option value="Экономика (Бакалавр)">Экономика (Бакалавр)</option>
                                            <option value="Менеджмент (Бакалавр)">Менеджмент (Бакалавр)</option>
                                            <option value="Государственной и муниципальное управление">Государственной и муниципальное управление</option>
                                            <option value="Бизнес-информатика">Бизнес-информатика</option>
                                            <option value="Информационные системы и технологии">Информационные системы и технологии</option>
                                            <option value="Экономика фирмы и отпавлевых рынков">Экономика фирмы и отпавлевых рынков</option>
                                            <option value="Экономическое и правовове обеспечение бизнеса">Экономическое и правовове обеспечение бизнеса</option>
                                            <option value="Управление проектами">Управление проектами</option>
                                            <option value="Государственное региональное управление">Государственное региональное управление</option>
                                            <option value="Информационная бизнес-аналитика">Информационная бизнес-аналитика</option>
                                            <option value="Разработка и сопровождение информационных систем">Разработка и сопровождение информационных систем</option>
                                            <option value="Система корпоративного управления">Система корпоративного управления</option>
                                            <option value="Экономика и управление народным хозяйством">Экономика и управление народным хозяйством</option>
                                            <option value="Зоотехния (Бакалавр)">Зоотехния (Бакалавр)</option>
                                            <option value="Технология производства и переработки с.-х. продукции">Технология производства и переработки с.-х. продукции</option>
                                            <option value="Технология продукции и организация общественного питания">Технология продукции и организация общественного питания</option>
                                            <option value="Зоотехния (Магистр)">Зоотехния (Магистр)</option>
                                            <option value="Продукты питания животного происхождения">Продукты питания животного происхождения</option>
                                            <option value="Агроинженерия (Бакалавр)">Агроинженерия (Бакалавр)</option>
                                            <option value="Эксплуатация транспортно-технологических машин и комплексов (Бакалавр)">Эксплуатация транспортно-технологических машин и комплексов (Бакалавр)</option>
                                            <option value="Агроинженерия (Магистр)">Агроинженерия (Магистр)</option>
                                            <option value="Эксплуатация транспортно-технологических машин и комплексов (Магистр)">Эксплуатация транспортно-технологических машин и комплексов (Магистр)</option>
                                            <option value="Агрономия (Бакалавр)">Агрономия (Бакалавр)</option>
                                            <option value="Землеустройство и кадастры (Бакалавр)">Землеустройство и кадастры (Бакалавр)</option>
                                            <option value="Продукты питания из растительного сырья (Бакалавр)">Продукты питания из растительного сырья (Бакалавр)</option>
                                            <option value="Садоводство (Бакалавр)">Садоводство (Бакалавр)</option>
                                            <option value="Агрономия (Магистр)">Агрономия (Магистр)</option>
                                            <option value="Землеустройство и кадастры (Магистр)">Землеустройство и кадастры (Магистр)</option>
                                            <option value="Продукты питания из растительного сырья (Магистр)">Продукты питания из растительного сырья (Магистр)</option>
                                            <option value="Садоводство (Магистр)">Садоводство (Магистр)</option>
                                            <option value="Ветеринарно-санитарная экспертиза (Бакалавр)">Ветеринарно-санитарная экспертиза (Бакалавр)</option>
                                            <option value="Ветеринарно-санитарная экспертиза (Магистр)">Ветеринарно-санитарная экспертиза (Магистр)</option>
                                            <option value="Ветеринария">Ветеринария</option>
                                            <option value="Сервис">Сервис</option>
                                            <option value="Туризм">Туризм</option>
                                            <option value="Гостиничное дело (Бакалавр)">Гостиничное дело (Бакалавр)</option>
                                            <option value="Информационные системы и программирование (СПО)">Информационные системы и программирование (СПО)</option>
                                            <option value="Электроснабжение (СПО)">Электроснабжение (СПО)</option>
                                            <option value="Технология продукции общественного питания (СПО)">Технология продукции общественного питания (СПО)</option>
                                            <option value="Земельно-имущественные отношения (СПО)">Земельно-имущественные отношения (СПО)</option>
                                            <option value="Техническое обслуживание и ремонт автомобильного транспорта (СПО)">Техническое обслуживание и ремонт автомобильного транспорта (СПО)</option>
                                            <option value="Агрономия (СПО)">Агрономия (СПО)</option>
                                            <option value="Электрификация и автоматизация сельского хозяйства (СПО)">Электрификация и автоматизация сельского хозяйства (СПО)</option>
                                            <option value="Садово-парковое и ландшафтное строительство (СПО)">Садово-парковое и ландшафтное строительство (СПО)</option>
                                            <option value="Эксплуатация и ремонт сельскохозяйственной техники и оборудования (СПО)">Эксплуатация и ремонт сельскохозяйственной техники и оборудования (СПО)</option>
                                            <option value="Ветеринария (СПО)">Ветеринария (СПО)</option>
                                            <option value="Экономика и бухгалтерский учёт (СПО)">Экономика и бухгалтерский учёт (СПО)</option>
                                            <option value="Коммерция (СПО)">Коммерция (СПО)</option>
                                            <option value="Финансы (СПО)">Финансы (СПО)</option>
                                            <option value="Банковское дело (СПО)">Банковское дело (СПО)</option>
                                            <option value="Гостиничное дело (СПО)">Гостиничное дело (СПО)</option>
                                            <option value="Экология и природопользование">Экология и природопользование</option>
                                            <option value="Ландшафтная архитектура">Ландшафтная архитектура</option>
                                            <option value="Электроэнергетика и электротехника (Бакалавр)">Электроэнергетика и электротехника (Бакалавр)</option>
                                            <option value="Электроэнергетика и электротехника (Магистр)">Электроэнергетика и электротехника (Магистр)</option>
                                            <option value="Экономика (Магистр)">Экономика (Магистр)</option>
                                            <option value="Менеджемент (Магистр)">Менеджемент (Магистр)</option>
                                            <option value="Финансы и кредит (Магистр)">Финансы и кредит (Магистр)</option>
                                        </select>
                                        <div class="label-arrow">
                                            <i class="mdi mdi-chevron-down"></i>
                                        </div>
                                    </div>
                                    <span class="empty e-direction">Это поле не должно быть пустым</span>
                                </div>
                            </div>

                            <div class="flex f-n">
                                <div class="label-block au-fn au-fn-1">
                                    <label for="inn">ИНН</label>
                                    <input type="number" id="inn" name="inn" value="<?php echo $r['inn'] > 0 ? $r['inn'] : ''  ?>" placeholder="">
                                    <span class="empty e-inn">Это поле не должно быть пустым</span>
                                </div>

                                <div class="label-block au-fn">
                                    <label for="snils">СНИЛС <span>*</span></label>
                                    <input type="text" id="snils" name="snils" value="<?php echo $r['snils'] > 0 ? $r['snils'] : '' ?>" placeholder="">
                                    <span class="empty e-snils">Это поле не должно быть пустым</span>
                                </div>
                            </div>

                            <div class="pf-bth">
                                <button class="bth save-resume-education" type="button" name="">Сохранить</button>
                            </div>

                        </form>
                    </div>


                    <div class="pr-data-block block-p bl-0">
                        <span>Дополнительно</span>
                        <form  enctype="multipart/form-data" class="form-pf-add" action="" method="post">


                            <div class="label-block-skill">
                                <label for="">Профессиональны навыки</label>


                                    <ul class="skill-list">
                                        <?php

                                        $sqlsk = "SELECT * FROM `skills_resume` WHERE `user_id` = :t ORDER BY `id` DESC";
                                        $stmtsk = $PDO->prepare($sqlsk);
                                        $stmtsk->bindValue(':t', (int) $r['id']);
                                        $stmtsk->execute();
                                        if ($stmtsk->rowCount() > 0) {

                                        while ($rs = $stmtsk->fetch()) {

                                            if (isset($_POST['skill-del-'.$rs['id']])) {

                                                $app->execute('DELETE FROM `skills_resume` WHERE `id` = :id', [
                                                    ':id' => $rs['id']
                                                ]);
                                                $app->go('/profile');
                                            }


                                            ?>
                                            <li class="skill-<?php echo $rs['id'] ?>">

                                                <span><?php echo $rs['text'] ?></span>
                                                <button type="submit" name="skill-del-<?php echo $rs['id'] ?>"><i class="mdi mdi-delete"></i></button>


                                            </li>
                                            <?php
                                        }
                                        }
                                        ?>
                                    </ul>

                                <div class="bth-skill">
                                    <input type="text" class="skill" name="skill" placeholder="javascript, ответственный и т.д.">
                                    <button class="add-skill" type="button" name="add-skill">Добавить</button>
                                </div>
                            </div>
                            <div class="label-block-lang">
                                <label for="">Владение иностранным языком</label>


                                    <ul class="lang-list">
                                        <?php

                                        $stmtsl = $PDO->prepare("SELECT * FROM `lang` WHERE `user` = :t ORDER BY `id` DESC");
                                        $stmtsl->bindValue(':t', (int) $r['id']);
                                        $stmtsl->execute();
                                        if ($stmtsl->rowCount() > 0) {

                                        while ($rs = $stmtsl->fetch()) {

                                            if (isset($_POST['lang-del-'.$rs['id']])) {

                                                $app->execute('DELETE FROM `lang` WHERE `id` = :id', [
                                                    ':id' => $rs['id']
                                                ]);
                                                $app->go('/profile');
                                            }


                                            ?>
                                            <li class="lang-<?php echo $rs['id'] ?>">

                                                <span><?php echo $rs['name'] ?> - <?php echo $rs['lvl'] ?></span>
                                                <button type="submit" name="lang-del-<?php echo $rs['id'] ?>"><i class="mdi mdi-delete"></i></button>


                                            </li>
                                            <?php
                                        }
                                        }
                                        ?>
                                    </ul>

                                <div class="lan-flex">
                                    <div>
                                        <select class="lang" name="lang" id="">
                                            <option value="" disabled selected>Название</option>
                                            <option value="Английский" data-qa="resumesearch-filter-language-eng">
                                                Английский
                                            </option>
                                            <option value="Немецкий" data-qa="resumesearch-filter-language-deu">Немецкий
                                            </option>
                                            <option value="Французский" data-qa="resumesearch-filter-language-fra">Французский
                                            </option>
                                            <option value="Кыргызский" data-qa="resumesearch-filter-language-kir">Кыргызский
                                            </option>
                                            <option value="Бирманский" data-qa="resumesearch-filter-language-mya">Бирманский
                                            </option>
                                            <option value="Удмуртский" data-qa="resumesearch-filter-language-udm">Удмуртский
                                            </option>
                                            <option value="Азербайджанский" data-qa="resumesearch-filter-language-aze">
                                                Азербайджанский
                                            </option>
                                            <option value="Албанский" data-qa="resumesearch-filter-language-sqi">Албанский
                                            </option>
                                            <option value="Арабский" data-qa="resumesearch-filter-language-ara">Арабский
                                            </option>
                                            <option value="Армянский" data-qa="resumesearch-filter-language-hye">Армянский
                                            </option>
                                            <option value="Африкаанс" data-qa="resumesearch-filter-language-afr">Африкаанс
                                            </option>
                                            <option value="Башкирский" data-qa="resumesearch-filter-language-bak">Башкирский
                                            </option>
                                            <option value="Белорусский" data-qa="resumesearch-filter-language-bel">Белорусский
                                            </option>
                                            <option value="Болгарский" data-qa="resumesearch-filter-language-bul">Болгарский
                                            </option>
                                            <option value="Венгерский" data-qa="resumesearch-filter-language-hun">Венгерский
                                            </option>
                                            <option value="Вьетнамский" data-qa="resumesearch-filter-language-vie">Вьетнамский
                                            </option>
                                            <option value="Голландский" data-qa="resumesearch-filter-language-nld">Голландский
                                            </option>
                                            <option value="Греческий" data-qa="resumesearch-filter-language-ell">Греческий
                                            </option>
                                            <option value="Грузинский" data-qa="resumesearch-filter-language-kat">Грузинский
                                            </option>
                                            <option value="Датский" data-qa="resumesearch-filter-language-dan">Датский
                                            </option>
                                            <option value="Иврит" data-qa="resumesearch-filter-language-heb">Иврит
                                            </option>
                                            <option value="Испанский" data-qa="resumesearch-filter-language-spa">Испанский
                                            </option>
                                            <option value="Итальянский" data-qa="resumesearch-filter-language-ita">Итальянский
                                            </option>
                                            <option value="Казахский" data-qa="resumesearch-filter-language-kaz">Казахский
                                            </option>
                                            <option value="Китайский" data-qa="resumesearch-filter-language-zho">Китайский
                                            </option>
                                            <option value="Коми" data-qa="resumesearch-filter-language-kom">Коми</option>
                                            <option value="Корейский" data-qa="resumesearch-filter-language-kor">Корейский
                                            </option>
                                            <option value="Курдский" data-qa="resumesearch-filter-language-kur">Курдский
                                            </option>
                                            <option value="Латышский" data-qa="resumesearch-filter-language-lav">Латышский
                                            </option>
                                            <option value="Литовский" data-qa="resumesearch-filter-language-lit">Литовский
                                            </option>
                                            <option value="Македонский" data-qa="resumesearch-filter-language-mke">Македонский
                                            </option>
                                            <option value="Монгольский" data-qa="resumesearch-filter-language-mon">Монгольский
                                            </option>
                                            <option value="Норвежский" data-qa="resumesearch-filter-language-nor">Норвежский
                                            </option>
                                            <option value="Персидский" data-qa="resumesearch-filter-language-fas">Персидский
                                            </option>
                                            <option value="Польский" data-qa="resumesearch-filter-language-pol">Польский
                                            </option>
                                            <option value="Португальский" data-qa="resumesearch-filter-language-por">
                                                Португальский
                                            </option>
                                            <option value="Румынский" data-qa="resumesearch-filter-language-ron">Румынский
                                            </option>
                                            <option value="Русский" data-qa="resumesearch-filter-language-rus">Русский
                                            </option>
                                            <option value="Санскрит" data-qa="resumesearch-filter-language-san">Санскрит
                                            </option>
                                            <option value="Сербский" data-qa="resumesearch-filter-language-srp">Сербский
                                            </option>
                                            <option value="Словацкий" data-qa="resumesearch-filter-language-slk">Словацкий
                                            </option>
                                            <option value="Словенский" data-qa="resumesearch-filter-language-slv">Словенский
                                            </option>
                                            <option value="Суахили" data-qa="resumesearch-filter-language-swa">Суахили
                                            </option>
                                            <option value="Таджикский" data-qa="resumesearch-filter-language-tgk">Таджикский
                                            </option>
                                            <option value="Тайский" data-qa="resumesearch-filter-language-tha">Тайский
                                            </option>
                                            <option value="Татарский" data-qa="resumesearch-filter-language-tat">Татарский
                                            </option>
                                            <option value="Турецкий" data-qa="resumesearch-filter-language-tur">Турецкий
                                            </option>
                                            <option value="Туркменский" data-qa="resumesearch-filter-language-tuk">Туркменский
                                            </option>
                                            <option value="Узбекский" data-qa="resumesearch-filter-language-uzb">Узбекский
                                            </option>
                                            <option value="Украинский" data-qa="resumesearch-filter-language-ukr">Украинский
                                            </option>
                                            <option value="Урду" data-qa="resumesearch-filter-language-urd">Урду</option>
                                            <option value="Финский" data-qa="resumesearch-filter-language-fin">Финский
                                            </option>
                                            <option value="Хорватский" data-qa="resumesearch-filter-language-hrv">Хорватский
                                            </option>
                                            <option value="Чеченский" data-qa="resumesearch-filter-language-che">Чеченский
                                            </option>
                                            <option value="Чешский" data-qa="resumesearch-filter-language-ces">Чешский
                                            </option>
                                            <option value="Чувашский" data-qa="resumesearch-filter-language-chv">Чувашский
                                            </option>
                                            <option value="Шведский" data-qa="resumesearch-filter-language-swe">Шведский
                                            </option>
                                            <option value="Эстонский" data-qa="resumesearch-filter-language-est">Эстонский
                                            </option>
                                            <option value="Японский" data-qa="resumesearch-filter-language-jpn">Японский
                                            </option>
                                            <option value="Хинди" data-qa="resumesearch-filter-language-hin">Хинди
                                            </option>
                                            <option value="Индонезийский" data-qa="resumesearch-filter-language-ind">
                                                Индонезийский
                                            </option>
                                            <option value="Ингушский" data-qa="resumesearch-filter-language-inh">Ингушский
                                            </option>
                                            <option value="Кашмирский" data-qa="resumesearch-filter-language-kas">Кашмирский
                                            </option>
                                            <option value="Эсперанто" data-qa="resumesearch-filter-language-epo">Эсперанто
                                            </option>
                                            <option value="Кхмерский (Камбоджийский)" data-qa="resumesearch-filter-language-khm">Кхмерский
                                                (Камбоджийский)
                                            </option>
                                            <option value="Креольский (Сейшельские острова)" data-qa="resumesearch-filter-language-crs">Креольский
                                                (Сейшельские острова)
                                            </option>
                                            <option value="Абхазский" data-qa="resumesearch-filter-language-abk">Абхазский
                                            </option>
                                            <option value="Осетинский" data-qa="resumesearch-filter-language-oss">Осетинский
                                            </option>
                                            <option value="Кабардино-черкесский" data-qa="resumesearch-filter-language-kbd">
                                                Кабардино-черкесский
                                            </option>
                                            <option value="krc" data-qa="resumesearch-filter-language-krc">
                                                Карачаево-балкарский
                                            </option>
                                            <option value="Каталанский" data-qa="resumesearch-filter-language-cat">Каталанский
                                            </option>
                                            <option value="Уйгурский" data-qa="resumesearch-filter-language-uig">Уйгурский
                                            </option>
                                            <option value="Абазинский" data-qa="resumesearch-filter-language-abq">Абазинский
                                            </option>
                                            <option value="Кумыкский" data-qa="resumesearch-filter-language-kum">Кумыкский
                                            </option>
                                            <option value="Тамильский" data-qa="resumesearch-filter-language-tam">Тамильский
                                            </option>
                                            <option value="Латинский" data-qa="resumesearch-filter-language-lat">Латинский
                                            </option>
                                            <option value="Малазийский" data-qa="resumesearch-filter-language-zlm">Малазийский
                                            </option>
                                            <option value="Ногайский" data-qa="resumesearch-filter-language-nog">Ногайский
                                            </option>
                                            <option value="Амхарский" data-qa="resumesearch-filter-language-amh">Амхарский
                                            </option>
                                            <option value="Даргинский" data-qa="resumesearch-filter-language-dar">Даргинский
                                            </option>
                                            <option value="Аварский" data-qa="resumesearch-filter-language-ava">Аварский
                                            </option>
                                            <option value="Баскский" data-qa="resumesearch-filter-language-eus">Баскский
                                            </option>
                                            <option value="Бенгальский" data-qa="resumesearch-filter-language-ben">Бенгальский
                                            </option>
                                            <option value="Боснийский" data-qa="resumesearch-filter-language-bos">Боснийский
                                            </option>
                                            <option value="Бурятский" data-qa="resumesearch-filter-language-bua">Бурятский
                                            </option>
                                            <option value="Дагестанский" data-qa="resumesearch-filter-language-dag">
                                                Дагестанский
                                            </option>
                                            <option value="Ирландский" data-qa="resumesearch-filter-language-gle">Ирландский
                                            </option>
                                            <option value="Исландский" data-qa="resumesearch-filter-language-isl">Исландский
                                            </option>
                                            <option value="Карельский" data-qa="resumesearch-filter-language-krl">Карельский
                                            </option>
                                            <option value="Лакский" data-qa="resumesearch-filter-language-lbe">Лакский
                                            </option>
                                            <option value="Лаосский" data-qa="resumesearch-filter-language-lao">Лаосский
                                            </option>
                                            <option value="Лезгинский" data-qa="resumesearch-filter-language-lez">Лезгинский
                                            </option>
                                            <option value="Марийский" data-qa="resumesearch-filter-language-chm">Марийский
                                            </option>
                                            <option value="Непальский" data-qa="resumesearch-filter-language-nep">Непальский
                                            </option>
                                            <option value="Панджаби" data-qa="resumesearch-filter-language-pan">Панджаби
                                            </option>
                                            <option value="Пушту" data-qa="resumesearch-filter-language-pus">Пушту
                                            </option>
                                            <option value="Сомалийский" data-qa="resumesearch-filter-language-som">Сомалийский
                                            </option>
                                            <option value="Тагальский" data-qa="resumesearch-filter-language-tgl">Тагальский
                                            </option>
                                            <option value="Талышский" data-qa="resumesearch-filter-language-tly">Талышский
                                            </option>
                                            <option value="Тибетский" data-qa="resumesearch-filter-language-bod">Тибетский
                                            </option>
                                            <option value="Тувинский" data-qa="resumesearch-filter-language-tyv">Тувинский
                                            </option>
                                            <option value="Фламандский" data-qa="resumesearch-filter-language-vls">Фламандский
                                            </option>
                                            <option value="Мансийский" data-qa="resumesearch-filter-language-mns">Мансийский
                                            </option>
                                            <option value="Якутский" data-qa="resumesearch-filter-language-sah">Якутский
                                            </option>
                                        </select>
                                        <select class="lvl" name="lvl" id="">
                                            <option value="" disabled selected>Уровень владения</option>
                                            <option value="A1 - Начальный" data-qa="A1 - Начальный">A1 — Начальный</option>
                                            <option value="A2 - Элементарный" data-qa="A2 - Элементарный">A2 — Элементарный</option>
                                            <option value="B1 - Средний" data-qa="B1 - Средний">B1 — Средний</option>
                                            <option value="B2 - Средне-продвинутый" data-qa="B2 - Средне-продвинутый">B2 — Средне-продвинутый</option>
                                            <option value="C1 - Продвинутый" data-qa="C1 - Продвинутый">C1 — Продвинутый</option>
                                            <option value="C2 - В совершенстве" data-qa="C2 - В совершенстве">C2 — В совершенстве</option>
                                            <option value="Родной язык" data-qa="Родной язык">Родной язык</option>
                                        </select>
                                    </div>
                                    <button class="add-lang" type="button" name="add-lang">Добавить</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <?php } ?>

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


                <? include 'template/more/profileHead.php'; ?>



<!--                <div class="al-stats" style="margin: 0 0 30px 0;">
                    <ul>
                        <li>
                            <div class="as-t">
                                <span class="as-tt"><?php echo $r['job'] ?></span>
                                <span class="as-tk">Вакансии</span>
                            </div>
                            <div class="as-i"><i class="mdi mdi-database-check-outline"></i></div>

                        </li>
                        <li>
                            <div class="as-t">
                                <span class="as-tt"><?php echo $app->rowCount("SELECT * FROM `respond` WHERE `company_id` = :id", [':id' => $r['id']]) ?></span>
                                <span class="as-tk">Отклики</span>
                            </div>
                            <div class="as-i"><i class="mdi mdi-school-outline"></i></div>

                        </li>
                        <li>
                            <div class="as-t">
                                <span class="as-tt"><?php echo $rating ?></span>
                                <span class="as-tk">Рейтинг</span>
                            </div>
                            <div class="as-i"><i class="mdi mdi-star-outline"></i></div>

                        </li>
                        <li>
                            <div class="as-t">
                                <span class="as-tt"><?php echo $count ?></span>
                                <span class="as-tk">Отзывы</span>
                            </div>
                            <div class="as-i"><i class="mdi mdi-message-star-outline"></i></div>

                        </li>
                    </ul>
                </div>-->



                <div class="pr-data-block block-p bl-1">





                        <span>Ваши данные</span>
                    <form role="form" class="form-profile" method="post">





                     <!-- <div class="block-prof-info">
                            <a href="/company/?id=<?php echo $r['id']  ?> ">Страница "О компании"</a>
                            <span>Сейчас просматривают ваши вакансии <?php echo $app->count("SELECT * FROM `online_job` WHERE `company` = $r[id]"); ?> студентов</span>
                            <span> Сейчас просматривают страницу  компании <?php echo $app->count("SELECT * FROM `online_company` WHERE `company` = $r[id]"); ?> студентов</span>
                        </div> -->
                        <h3>Логотип компании</h3>
                        <div class="pfa-wrap">
                            <div class="pfa-a pfa-comp">

                                <span>
                                    <img src="/static/image/company/<?php echo $r['img'] ?>" alt="">
                                      <div class="pfa-a-bth"><i class="mdi mdi-pencil"></i></div>
                                    <?php if ($r['img'] != 'placeholder.png') { ?>
                                        <button type="submit" name="delete-logo-user"><span class="mdi mdi-window-close"></span></button>
                                    <?php } ?>


                                </span>
                            </div>
                            <div class="ini-text">разрешенные типы файлов: png</div>
                        </div>

                        <h3>Баннер компании</h3>
                        <div class="pfa-wrap">
                            <div class="pfb-a">

                                <?php

                                if (trim($r['baner']) == '') {

                                    echo '<div class="pfb-bth more-inf"><i class="mdi mdi-pencil"></i> Добавить</div>';

                                }

                                ?>

                                <?php if (isset($r['baner']) AND trim($r['baner']) != '') { ?>
                                <div class="prof-baner">
                                    <img src="/static/image/company_banner/<?php echo $r['baner'] ?>" alt="">

                                    <?php

                                    if (!empty($r['baner']) AND trim($r['baner']) != '') {

                                        echo '<div class="pfb-bth pfbbs"><i class="mdi mdi-pencil"></i></div>';

                                    }

                                    ?>

                                    <button type="submit" name="delete-logo-baner"><span class="mdi mdi-window-close"></span></button>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="ini-text">разрешенные типы файлов: png, jpg, avif</div>
                        </div>

                        <div class="flex f-n">
                            <div class="label-block au-fn au-fn-1">
                                <label for="">Контактное лицо</label>
                                <input type="text" id="username" name="username" value="<?php echo $r['username'] ?>" placeholder="">
                                <span class="empty e-username">Это поле не должно быть пустым</span>
                            </div>


                            <div class="label-block au-fn">
                                <label for="">Телефон <span>*</span></label>
                                <input  type="tel" id="tel" name="tel" value="<?php echo $r['phone'] ?>" placeholder="">
                                <span class="empty e-tel">Это поле не должно быть пустым</span>
                            </div>
                        </div>



                        <div class="flex f-n">
                            <div class="label-block au-fn au-fn-1">
                                <label for="">ИНН Компании <span>*</span></label>
                                <input type="number" id="inn" name="inn" value="<?php echo $r['inn'] ?>" placeholder="">
                                <span class="empty e-inn">Это поле не должно быть пустым</span>
                            </div>
                            <div class="label-block au-fn">
                                <label class="" for="">Тип компании <span>*</span></label>
                                <div class="label-select-block">
                                    <select id="type" name="type">
                                        <?php
                                        $job_type = ['Частная', 'Государственная', 'Смешанная', 'Кадровое агенство'];

                                        if (isset($r['type'])) {
                                            foreach ($job_type as $key) {
                                                if ($r['type'] == $key) {
                                                    echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                } else {
                                                    echo '<option value="'.$key.'">'.$key.'</option>';
                                                }
                                            }
                                        } else {
                                            foreach ($job_type as $key) {
                                                echo '<option value="'.$key.'">'.$key.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="label-arrow">
                                        <i class="mdi mdi-chevron-down"></i>
                                    </div>
                                </div>
                                <span class="empty e-type">Тип обязателен</span>
                            </div>
                        </div>
                        <div class="flex f-n">
                            <div class="label-block au-fn au-fn-1">
                                <label for="name">Название <span>*</span></label>
                                <input disabled type="text" value="<?php echo $r['name'] ?>" placeholder="">
                                <span class="label-block-a edit-name">Изменить</span>


                            </div>
                            <div class="label-block au-fn">
                                <label for="email">E-mail <span>*</span></label>
                                <input disabled type="email" value="<?php echo $r['email'] ?>" placeholder="">
                                <span class="label-block-a edit-email">Изменить</span>
                            </div>
                        </div>
                        <div class="flex f-n">
                            <div class="label-block au-fn  au-fn-1">
                                <label for="">Город <span>*</span></label>
                                <div class="label-select-block">
                                    <select <? if (isset($err['address'])) { ?> class="errors" <? } ?> name="address" id="address" placeholder="Выберите город">
                                        <?php

                                        if (isset($r['address'])) {
                                            foreach ($city as $key) {
                                                if ($r['address'] == $key) {
                                                    echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                } else {
                                                    echo '<option value="'.$key.'">'.$key.'</option>';
                                                }
                                            }
                                        } else {
                                            foreach ($city as $key) {
                                                echo '<option value="'.$key.'">'.$key.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="label-arrow">
                                        <i class="mdi mdi-chevron-down"></i>
                                    </div>
                                </div>
                                <span class="empty e-address">Город обязателн</span>
                            </div>

                            <div class="label-block au-fn">
                                <label for="email">Специализация</label>
                                <input type="text" name="specialty" id="specialty" value="<?php echo $r['specialty'] ?>">

                            </div>



                        </div>

                        <div class="label-block">
                            <label for="about">О компании</label>
                            <textarea name="about" id="about" id="about" cols="30" rows="5"><?php echo $r['about'] ?></textarea>
                        </div>

                        <div class="flex f-n">
                            <div class="label-block au-fn au-fn-1">
                                <label for="">Количество работников</label>
                                <div class="label-select-block">
                                    <select name="people" id="people">
                                        <option selected value="<?php echo $r['people'] ?>"><?php echo $r['people'] ?></option>
                                        <option value="10-50">10-50</option>
                                        <option value="50-100">50-100</option>
                                        <option value="100-200">100-200</option>
                                        <option value="200-400">200-400</option>
                                        <option value="400-500">400-500</option>
                                        <option value="500-1000">500-1000</option>
                                        <option value="Более 1000">Более 1000</option>
                                    </select>
                                    <div class="label-arrow">
                                        <i class="mdi mdi-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="label-block au-fn">
                                <label for="">Средняя зарплата</label>
                                <div class="lb-block">
                                    <input type="number" id="middle" name="middle" value="<?php echo $r['middle'] ?>" placeholder="">
                                    <span class="lb-in">руб.</span>
                                </div>
                            </div>
                        </div>


                        <div style="margin:0" class="label-block">
                            <label for="">Web-site</label>
                            <input type="text" id="website" name="website" value="<?php echo $r['website'] ?>" placeholder="">
                        </div>
                        <div class="pf-bth" style="margin: 30px 0 0 0;">
                            <button class="bth save-company" type="button" name="">Сохранить</button>
                        </div>
                    </form>

                </div>

                <?php } ?>

              <!--  <?php if ($_SESSION['type'] == 'company') { ?>
                    <div class="block-p bl-b">
                        <span>Фотографии офиса</span>
                        <form enctype="multipart/form-data" action="" method="POST">

                            <div class="upload-block" style="max-width: 300px">
                                <div class="uploadButton-block">
                                    <input class="uploadButton-input" type="file" name="file-office" accept=".jpg,.jpeg,.png,.gif,.svg" id="upload_2">
                                    <label class="uploadButton-button ripple-effect" for="upload_2" style="">
                                        <i class="icon-arrow-up"></i>
                                        Нажмите для загрузки файла
                                        <br>
                                        SVG, PNG, JPG или GIF
                                    </label>
                                    <span class="uploadButton-file-name"></span>
                                </div>
                                <div class="text"></div>
                            </div>



                            <div class="office-block">
                                    <?php
                                    $sqlsk = "SELECT * FROM `office_img` WHERE `company_id` = :t ORDER BY `id` DESC";
                                    $stmtsk = $PDO->prepare($sqlsk);
                                    $stmtsk->bindValue(':t', (int) $r['id']);
                                    $stmtsk->execute();
                                    if ($stmtsk->rowCount() > 0) {
                                        ?>

                                        <ul>
                                            <?php

                                            while ($rs = $stmtsk->fetch()) {


                                                ?>
                                                <li>

                                                    <img src="/static/image/c_office/<?php echo $rs['img'] ?>" alt="">

                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>

                                        <?php
                                    }
                                    ?>
                            </div>

                            <div class="pf-bth">
                                <input class="bth open-upload-img" type="submit" name="upload-office" value="Добавить">
                            </div>
                        </form>
                    </div>
                    <?php } ?> -->

            </div>


        </div>
    </section>

</main>

<div id="auth2">
    <div class="edit-name-box">
        <div class="auth-container auth-log">
            <div class="auth-title">
                Изменить название
                <i class="mdi mdi-close form-close"></i>
            </div>
            <div class="auth-form">
                <form class="form" action="" method="POST">
                    <div class="access-block"></div>

                    <div class="label-block label-b-info">
                        Вы уверены, что хотите сменить название?
                    </div>

                    <div class="label-block">
                        <label for="">Название <span>*</span></label>
                        <input type="text" class="name-inp" name="name-inp" placeholder="">
                        <span class="error e-name" style="display: none">Введите название</span>
                    </div>
                    <div style="margin: 0">
                        <button class="name-go bth" name="edit-name" type="button">Подтвердить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="auth">
    <div class="edit-mail-box">
        <div class="auth-container auth-log">
            <div class="auth-title">
                Изменить email
                <i class="mdi mdi-close form-close"></i>
            </div>
            <div class="auth-form">
                <form class="form" action="" method="POST">
                    <div class="access-block"></div>

                    <div class="label-block label-b-info">
                        Введите новый E-mail, на который будет отправлено письмо для подтверждения смены почты
                    </div>

                    <div class="label-block">
                        <label for="">E-mail <span>*</span></label>
                        <input type="email" class="email-inp" name="email-inp" placeholder="">
                        <span class="error e-email" style="display: none">Введите email</span>
                    </div>
                    <div style="margin: 0">
                        <button class="mail-go bth" name="edit-mail" type="button">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<? include 'template/more/profileFooter.php'; ?>





<script language="JavaScript" src="/static/scripts/profile.js?v=<?= date('YmdHis') ?>"></script>

<script>


    $(document).on('change', '#upload', function () {
        if (window.FormData === undefined) {
            alert('В вашем браузере загрузка файлов не поддерживается');
        } else {
            $('.img-go').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
            $('.img-go').attr('disabled', 'true')

            $('.image-box').html('');
            $('.uploadButton-button').addClass('disabled-file')
            $('.upload-cxt').attr('disabled', 'true')

            let formData = new FormData();
            formData.append('file', $("#upload")[0].files[0]);
            $.ajax({
                type: 'POST',
                url: '/scripts/uploads-only-js',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                dataType : 'json',
                success: function(response){
                    if (response.error === '') {
                        $('.image-box').fadeIn(200)
                        $('.image-box').css('display', 'flex')
                        $('.image-box').html(response.success);
                        $('.uploadButton-button').removeClass('disabled-file')
                        $('.upload-cxt').removeAttr('disabled')
                        $('.img-go').removeAttr('disabled')
                        $('.img-go').html('Сохранить')
                    } else {
                        alert('Неверный форма изображения');
                        $('.uploadButton-button').removeClass('disabled-file')
                        $('.upload-cxt').removeAttr('disabled')
                        $('.img-go').removeAttr('disabled')
                        $('.img-go').html('Сохранить')
                    }
                }
            })
        }
    })

</script>


    <?php if ($_SESSION['type'] == 'company') { ?>


        <script>

            $(document).ready(function () {

                $(document).on('click', '#save-logo', function (e) {
                    e.preventDefault()
                    $('.img-go').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                    <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
                </svg>`)
                    $('.img-go').attr('disabled', 'true')

                    let getImg = $('.upload-user');

                    if ($.trim(getImg.val()) === '') {
                        alert('Файл не загружен')
                        $('.img-go').removeAttr('disabled')
                        $('.img-go').html('Сохранить')
                    } else {
                        let img = $('.avatarp-container .img-item input').val()
                        $.ajax({
                            url: '/scripts/profile-js',
                            data: `img=${img}&MODULE_SAVE_LOGO=1`,
                            type: 'POST',
                            cache: false,
                            dataType: 'json',
                            error: (response) => {
                                alert('Произошла ошибка')
                                $('.img-go').removeAttr('disabled')
                                $('.img-go').html('Сохранить')
                            },
                            success: function (responce) {
                                if (responce.code === 'success') {
                                    $('.avatarp-container .image-box').remove();
                                    $('.avatarp-container .uploadButton-file-name').html('');
                                    $('.img-form')[0].reset();
                                    $('.img-go').removeAttr('disabled')
                                    $('.img-go').html('Сохранить')
                                    location.reload();
                                } else {
                                    alert('Произошла ошибка')
                                    $('.img-go').removeAttr('disabled')
                                    $('.img-go').html('Сохранить')
                                }
                            }})
                    }
                })

                $(document).on('click', '.name-go', function (e) {
                    e.preventDefault();
                    $('.name-go').attr('disabled', 'true')
                    $('.name-go').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                    <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
                </svg>`)
                    $('.e-name').fadeOut(50)
                    $('.name-inp').removeClass('errors')
                    $.ajax({
                        url: '/scripts/profile-js',
                        data: `name=${$('.name-inp').val()}&MODULE_EDIT_NAME=1`,
                        type: 'POST',
                        cache: false,
                        dataType: 'json',
                        error: (response) => {
                            MessageBox('Произошла ошибка. Повторите')
                            $('.name-go').removeAttr('disabled')
                            $('.name-go').html('Отправить')
                        },
                        success: function (responce) {
                            if (responce.code === 'validate_error') {
                                $('.name-inp').addClass('errors');
                                $('.e-name').show()
                                $('.name-go').removeAttr('disabled')
                                $('.name-go').html('Отправить')
                            } else {
                                if (responce.code === 'success') {
                                    $('.access-block').html('Немного подождите...');
                                    location.reload()
                                } else {
                                    MessageBox('Произошла ошибка. Повторите')
                                    $('.name-go').removeAttr('disabled')
                                    $('.name-go').html('Отправить')
                                }
                            }



                        }});
                })

            })(jQuery)
        </script>

        <?php } ?>


    <?php if ($_SESSION['type'] == 'users') { ?>

        <script>
            (function () {
                $(document).ready(function () {

                    $(document).on('click', '#save-logo', function (e) {
                        e.preventDefault()
                        $('.img-go').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
                        $('.img-go').attr('disabled', 'true')

                        let getImg = $('.upload-user');

                        if ($.trim(getImg.val()) === '') {
                            alert('Файл не загружен')
                            $('.img-go').removeAttr('disabled')
                            $('.img-go').html('Сохранить')
                        } else {
                            let img = $('.avatarp-container .img-item input').val()
                            $.ajax({
                                url: '/scripts/profile-js',
                                data: `img=${img}&MODULE_SAVE_LOGO=1`,
                                type: 'POST',
                                cache: false,
                                dataType: 'json',
                                error: (response) => {
                                    alert('Произошла ошибка')
                                    $('.img-go').removeAttr('disabled')
                                    $('.img-go').html('Сохранить')
                                },
                                success: function (responce) {
                                    if (responce.code === 'success') {
                                        $('.avatarp-container .image-box').remove();
                                        $('.avatarp-container .uploadButton-file-name').html('');
                                        $('.img-form')[0].reset();
                                        $('.img-go').removeAttr('disabled')
                                        $('.img-go').html('Сохранить')
                                        location.reload();
                                    } else {
                                        alert('Произошла ошибка')
                                        $('.img-go').removeAttr('disabled')
                                        $('.img-go').html('Сохранить')
                                    }
                                }})
                        }
                    })


                })
            })(jQuery)
        </script>

    <?php } ?>

<script>
    (function () {
        $(document).ready(function () {



            $(document).on('click', '.edit-name', function (e) {
                e.preventDefault();
                $('#auth2').addClass('auth-b-act');
                $('#auth2 .edit-name-box').addClass('auth-c-act');
                $('body').addClass('body-hidden');
            })

            $(document).on('click', '.edit-email', function (e) {
                e.preventDefault();
                $('#auth').addClass('auth-b-act');
                $('#auth .edit-mail-box').addClass('auth-c-act');
                $('body').addClass('body-hidden');
            })


            $('#datalistOptions').select2(
                {
                    placeholder: "Выберите город",
                    maximumSelectionLength: 2,
                    language: "ru"
                }
            )
        })
    })(jQuery)
</script>

</body>
</html>
<?php
} else {
    $app->notFound();
}
?>