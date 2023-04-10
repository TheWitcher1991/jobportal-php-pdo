<?php

session_start();

use Work\plugin\lib\pQuery;



if (!isset($_SESSION['id']) && !isset($_SESSION['password'])) {
    /*if (isset($_POST["reg-user"]) and (isset($_POST["name"]) and isset($_POST["password"]))) {

        $err = [];

        $captcha = $_SESSION['captcha'];
        unset($_SESSION['captcha']);
        $code = $_POST['captcha'];
        $code = crypt(trim($code), '$1$itchief$7');

        if (empty($_POST['name']) or trim($_POST['name']) == '') $err['name'] = 'Введите имя';
        if (empty($_POST['surname']) or trim($_POST['surname']) == '') $err['surname'] = 'Введите фамилию';
        if (empty($_POST['prof']) or trim($_POST['prof']) == '') $err['prof'] = 'Введите профессию';
        if (empty($_POST['email']) or trim($_POST['email']) == '') $err['email'] = 'Введите email';
        if (empty($_POST['faculty']) or trim($_POST['faculty']) == '') $err['faculty'] = 'Укажите факультет';
        if (empty($_POST['direction']) or trim($_POST['direction']) == '') $err['direction'] = 'Укажите направление';
        if (empty($_POST['degree']) or trim($_POST['degree']) == '') $err['degree'] = 'Укажите текущее образование';
        if (strlen ($_POST['password']) < 8) $err[] = $err['password'] = 'Пароль должен быть не меньше 8 символов';

        if (empty($err)) {

            $ers = $app->fetch("SELECT * FROM `temp_users` WHERE `email` = :email", [':email' => XSS_DEFENDER($_POST['email'])]);

            if (isset($ers['id'])) {
                $err['email'] = 'Извините, но аккаунт с данной почтой находится на стадии подтверждения.';
            } else {
                $name = XSS_DEFENDER($_POST['name']);
                $surname = XSS_DEFENDER($_POST['surname']);
                $email = XSS_DEFENDER($_POST['email']);
                $password = XSS_DEFENDER($_POST['password']);
                $faculty = XSS_DEFENDER($_POST['faculty']);
                $direction = XSS_DEFENDER($_POST['direction']);
                $degree = XSS_DEFENDER($_POST['degree']);
                $prof = XSS_DEFENDER($_POST['prof']);

                $r = $app->fetch("SELECT * FROM `users` WHERE `email` = :email", [':email' => $email]);
                $r2 = $app->fetch("SELECT * FROM `company` WHERE `email` = :email", [':email' => $email]);

                if (!empty($r['id']) || !empty($r2['id'])) {
                    $err['email'] = 'Данная E-mail почта занята';
                } else {
                    $code = md5(md5(random_str(25)));
                    $pass_code = md5(md5(random_str(25)));

                    $new_pass = md5(md5($password . $pass_code . $name));


                    if (SENDMAIL($mail, "Подтверждение почты", $email, $name . ' ' . $surname, '
Здравствуйте! Для подтверждения почты и окончательной регистрации на сайте <a target="_blank" href="stgaujob.ru">СтГАУ Агрокадры</a>
пройдите по нижеследующей ссылке. Ссылка действует 24 часа.
Ваш логин: '.$email.'
Ваш пароль: '.$password.'
<a style="margin: 16px 0 0 0;
font-size: 14px;font-weight: 400;cursor: pointer;padding: 6px 21px;border: 0;
border-radius: 3px;transition: all 0.2s linear;outline: none;color: #fff;box-shadow: 0 4px 20px rgb(0 0 0 / 10%);
background-color: #1967D2;
background-clip: padding-box;border-color: #1967D2;position: relative;text-decoration: none;
display: inline-block;"
 class="go-bth" href="http://stgaujob.ru/registers/confirm-user?email='.$email.'&code='.$code.'">
Подтвердить</a>    
                    ')) {
                        $_SESSION["$email-confirm-user"] = [
                            'email' => $email,
                            'code' => $code,
                            'msg' => 'На Вашу почту был отправлен запрос на подтверждения Вашего аккаунта. Пожалуйста, следуйте инструкциям в письме.'
                        ];

                        $app->execute("INSERT INTO `temp_users` (`name`, `surname`, `prof`, `email`, `password`, `password_hash`, `degree`, `faculty`, `direction`, `code`, `time`)
                        VALUES (:nm, :sn, :prof, :email, :password, :hash, :deg, :faculty, :direction, :code, NOW())", [
                                ':nm' => $name,
                                ':sn' => $surname,
                                ':prof' => $prof,
                                ':email' => $email,
                                ':password' => $new_pass,
                                ':hash' => $pass_code,
                                ':deg' => $degree,
                                ':faculty' => $faculty,
                                ':direction' => $direction,
                                ':code' => $code
                            ]);

                        header("Location: /create-success/?c=$email&code=$code");
                        exit;
                    } else {
                        $err['email_error'] = 'Извините, что-то пошло не так, повторите регистрацию';
                    }

                }
            }

        }

    }*/


    if (isset($_POST['login'])) {
        $err = [];

        if (trim($_POST['email_l']) == '') $err[] = 'Введите e-mail!';
        if (trim($_POST['password_l']) == '') $err[] = 'Введите пароль!';

        if (empty($err)) {
            $app->login($_POST['email'], $_POST['password']);
        }
    }
    Head('Регистрация студента');
    ?>
    <body class="body-auth">


    <main id="wrapper" class="wrapper wrapper-auth">
        <section class="auth-section">
            <div class="auth-container-auth-ms">



                <?php
                if (isset($err['email_error'])) {
                    ?>
                    <div class="alert-block" style="margin:res;130px 0 16px 0">
                        <div>
                            <span><?php echo $err['email_error']; ?></span>
                        </div>
                        <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if (isset($err['emailno'])) {
                    ?>
                    <div class="alert-block" style="margin:res;130px 0 16px 0">
                        <div>
                            <span><?php echo $err['emailno']; ?></span>
                        </div>
                        <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if (isset($success)) {
                    ?>
                    <div class="alert-block" style="margin:res;130px 0 16px 0">
                        <div>
                            <span><?php echo $success; ?></span>
                        </div>
                        <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="auth-container-aut">
                <a href="/" class="auth-span-a"><i class="mdi mdi-close"></i></a>
                <div class="auth-form">
                    <div>
                        <h1>Регистрация</h1>

                        <div class="af-tabs">
                            <ul class="tabs-li">
                                <li><a class="tabs-act">Как студент</a></li>
                                <li><a href="/create/employers">Как работадатель</a></li>
                            </ul>
                        </div>

                        <div class="errors-block"></div>

                        <div class="tabs-item">
                            <div class="tabs-form tb-si-b tabs-act">

                                <div class="el-steps">
                                    <div class="el-step step-active el-step-process">
                                        <div class="el-step_icon">1</div>
                                        <div class="el-step_text">Заполнение <br /> данных</div>
                                    </div>
                                    <div class="el-step">
                                        <div class="el-step_icon">2</div>
                                        <div class="el-step_text">Подтверждение <br /> email</div>
                                    </div>
                                </div>

                                <form role="form" class="form-create-user" method="post">
                                    <div class="flex-h">
                                        <div class="flex f-n">
                                            <div class="label-block au-fn au-fn-1">
                                                <label for="">Имя <span>*</span></label>
                                                <input data-name="name" <? if (isset($err['name'])) { ?> class="errors" <? } ?>  class="field-user" type="text" id="name" name="name"placeholder="" value="<? echo $_POST['name']; ?>">
                                                <span class="empty e-name">Введите имя</span>
                                                <? if (isset($err['name'])) { ?> <span class="error"><? echo $err['name']; ?></span> <? } ?>
                                            </div>

                                            <div class="label-block au-fn">
                                                <label for="">Фамилия <span>*</span></label>
                                                <input data-name="surname" <? if (isset($err['surname'])) { ?> class="errors" <? } ?>  class="field-user" type="text" id="surname" name="surname" placeholder="" value="<? echo $_POST['surname']; ?>">
                                                <? if (isset($err['surname'])) { ?> <span class="error"><? echo $err['surname']; ?></span> <? } ?>
                                                <span class="empty e-surname">Введите фамилию</span>
                                            </div>
                                        </div>
                                        <div class="flex f-i">

                                            <div class="flex f-n">
                                                <div class="label-block au-fn au-fn-1">
                                                    <label for="">E-mail <span>*</span></label>
                                                    <input data-name="email" <? if (isset($err['email'])) { ?> class="errors" <? } ?>
                                                           class="field-user" type="email" id="email" name="email" placeholder="" value="">
                                                    <? if (isset($err['email'])) { ?> <span class="error"><? echo $err['email']; ?></span> <? } ?>
                                                    <span class="empty e-email">Введите email</span>
                                                    <span class="empty e-mail">Введите email</span>
                                                    <span class="empty e-mail-2">Извините, но аккаунт с данной email почтой находится на стадии подтверждения</span>
                                                    <span class="empty e-mail-3">Данная email почта занята</span>
                                                </div>

                                                <div class="label-block au-fn">
                                                    <label for="">Телефон <span>*</span></label>
                                                    <input data-name="tel" <? if (isset($err['phone'])) { ?> class="errors" <? } ?>  class="field-user" type="tel" id="tel" name="phone"  placeholder="+7 (999) 999-99-99" value="<? echo $_POST['phone']; ?>">
                                                    <? if (isset($err['phone'])) { ?> <span class="error"><? echo $err['phone']; ?></span> <? } ?>
                                                    <span class="empty e-tel">Введите телефон</span>
                                                    <span class="empty e-tel-2">Данный номер телефона занят</span>
                                                </div>
                                            </div>

                                            <div class="label-block">
                                                <label for="">Желаемая профессия <span>*</span></label>
                                                <input data-name="prof" <? if (isset($err['prof'])) { ?> class="errors" <? } ?>  class="field-user" type="text" id="prof" name="prof" placeholder="" value="<? echo $_POST['prof']; ?>">
                                                <? if (isset($err['prof'])) { ?> <span class="error"><? echo $err['prof']; ?></span> <? } ?>
                                                <span class="empty e-prof">Введите профессию</span>
                                            </div>

                                            <div class="label-block">

                                            </div>

                                            <div class="label-block">
                                                <label for="">Пароль <span>*</span></label>
                                                <div class="label-password">
                                                    <input data-name="password" <? if (isset($err['password'])) { ?> class="errors" <? } ?>  class="field-user" type="password" id="password" name="password" placeholder="Пароль должен быть не меньше 8 символов">

                                                    <i class="mdi mdi-eye-outline eye-password in-pass"></i>
                                                </div>


                                               <? if (isset($err['password'])) { ?> <span class="error"><? echo $err['password']; ?></span> <? } ?>
                                                <span class="empty e-password">Пароль должен быть не меньше 8 символов</span>
                                            </div>

                                            <div class="label-block">
                                                <label for="">Текущее образование <span>*</span></label>
                                                <div class="label-select-block">
                                                    <select data-name="degree" <? if (isset($err['degree'])) { ?> class="errors" <? } ?>  class="field-user" name="degree" id="degree">
                                                        <option value="">Выберите</option>
                                                        <?php
                                                        $degree = ['Среднее профессиональное', 'Высшее (Бакалавриат)', 'Высшее (Специалитет)', 'Высшее (Магистратура)', 'Высшее (Аспирантура)'];

                                                        if (isset($_POST['degree'])) {
                                                            foreach ($degree as $key) {
                                                                if ($_POST['degree'] == $key) {
                                                                    echo '<option selected value="'.$key.'">'.$key.'</option>';
                                                                } else {
                                                                    echo '<option value="'.$key.'">'.$key.'</option>';
                                                                }
                                                            }
                                                        } else {
                                                            foreach ($degree as $key) {
                                                                echo '<option value="'.$key.'">'.$key.'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="label-arrow">
                                                        <i class="mdi mdi-chevron-down"></i>
                                                    </div>
                                                </div>
                                                <? if (isset($err['degree'])) { ?> <span class="error"><? echo $err['degree']; ?></span> <? } ?>
                                                <span class="empty e-degree">Выберите образование</span>
                                            </div>


                                            <div class="flex f-n">
                                                <div class="label-block au-fn au-fn-1">
                                                    <label for="">Факультет <span>*</span></label>
                                                    <div class="label-select-block">
                                                        <select data-name="faculty" <? if (isset($err['faculty'])) { ?> class="errors" <? } ?>  class="field-user" name="faculty" id="faculty">
                                                            <option value="">Выбрать</option>
                                                            <?php
                                                            $job_type = [
                                                                'Факультет агробиологии и земельных ресурсов', 'Факультет экологии и ландшафтной архитектуры',
                                                                'Экономический факультет', 'Инженерно-технологический факультет',
                                                                'Биотехнологический факультет', 'Факультет социально-культурного сервиса и туризма',
                                                                'Электроэнергетический факультет', 'Учетно-финансовый факультет',
                                                                'Факультет ветеринарной медицины', 'Факультет среднего профессионального образования'];

                                                            if (isset($_POST['faculty'])) {
                                                                foreach ($job_type as $key) {
                                                                    if ($_POST['faculty'] == $key) {
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
                                                    <? if (isset($err['faculty'])) { ?> <span class="error"><? echo $err['faculty']; ?></span> <? } ?>
                                                    <span class="empty e-faculty">Выберите факультет</span>
                                                </div>

                                                <div class="label-block au-fn">
                                                    <label for="">Направление <span>*</span></label>
                                                    <div class="label-select-block">
                                                        <select data-name="direction" class="select2-direction <? if (isset($err['direction'])) { ?> errors <? } ?> " name="direction" id="direction">
                                                            <option value="">Выбрать</option>
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
                                                    <? if (isset($err['direction'])) { ?> <span class="error"><? echo $err['direction']; ?></span> <? } ?>
                                                    <span class="empty e-direction">Выберите направление</span>
                                                </div>
                                            </div>





                                            <div class="captcha" style="margin: 0;">
                                                <div class="captcha__image-reload">
                                                    <img class="captcha__image" src="/scripts/captcha" width="132" alt="captcha">
                                                    <button type="button" class="captcha__refresh"><i class="mdi mdi-refresh"></i></button>
                                                </div>
                                                <div style="margin: 0 0 30px" class="captcha__group">
                                                    <label for="captcha">Код, изображенный на картинке <span>*</span></label>
                                                    <input data-name="captcha" style="height: 36px;font-size: 13px;padding: 8px 12px;" <? if (isset($err['captcha'])) { ?> class="errors" <? } ?> type="text" name="captcha" id="captcha">
                                                    <? if (isset($err['captcha'])) { ?> <span class="error"><? echo $err['captcha']; ?></span> <? } ?>
                                                    <span class="empty e-captcha">Код неверный или устарел</span>
                                                </div>
                                            </div>

                                            <div class="label-block label-b-info">
                                                Нажимая кнопку «Продолжить», Вы принимаете условия «<a target="_blank" href="http://stgau.ru/privacy/">Политики конфиденциальности</a>»
                                            </div>
                                        </div>
                                    </div>
                                    <div class="a-b-main">
                                        <div class="a-b-bth">
                                            <button class="reg-user" name="reg-user" type="button">Продолжить</button>
                                        </div>
                                        <div class="a-l-a">
                                            <a href="/login">У меня уже есть акаунт</a>
                                            <a class="form-i-a" href="/login-admin"><i class="mdi mdi-shield-crown-outline"></i></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
        </section>

    </main>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" integrity="sha512-Eak/29OTpb36LLo2r47IpVzPBLXnAMPAVypbSZiZ4Qkf8p/7S/XRG5xp7OKWPPYfJT6metI+IORkR5G8F900+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="/static/scripts/auth.js?v=<?= date('YmdHis') ?>"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js" integrity="sha512-d4KkQohk+HswGs6A1d6Gak6Bb9rMWtxjOa0IiY49Q3TeFd5xAzjWXDCBW9RS7m86FQ4RzM2BdHmdJnnKRYknxw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>

        (function($){ new WOW().init();const refreshCaptcha=(target)=>{const captchaImage=target.closest('.captcha__image-reload').querySelector('.captcha__image');captchaImage.src='/scripts/captcha?r='+new Date().getUTCMilliseconds()}
            const captchaBtn=document.querySelector('.captcha__refresh');captchaBtn.addEventListener('click',(e)=>refreshCaptcha(e.target));$(window).on('load',function(){$('#loader-site').delay(200).fadeOut(500)})
            $(document).ready(function(){$("#tel").mask("+7 (999) 999-99-99");$('.select2-direction').select2({placeholder:"Выберите направления",maximumSelectionLength:2,language:"ru"})})})(jQuery,window,document)
    </script>

    </body>
    </html>
    <?php
} else {

    pQuery::notFound();
}
?>