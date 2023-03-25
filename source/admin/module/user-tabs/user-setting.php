<?php
if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

if ($_SESSION['type'] == 'admin') {
    $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

    if (empty($a['id'])) {
        $app->notFound();
    }
}

?>

    <div style="margin-bottom: 30px" class="pr-data-block block-p bl-1">
        <span>Данные студента</span>
        <form role="form" class="form-profile" method="POST">


            <!--<div class="uploads-block">
                                <span class="image-block">
                                    <img src="/static/image/users/<?php echo $user['img'] ?>" alt="">
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
                                        <img src="/static/image/users/<?php echo $user['img'] ?>" alt="">
                                            <div class="pfa-a-bth"><i class="mdi mdi-pencil"></i></div>
    <?php if ($user['img'] != 'placeholder.png') { ?>
        <button type="submit" name="delete-logo-user"><span class="mdi mdi-window-close"></span></button>
    <?php } ?>
                                    </span>
                </div>
                <div class="ini-text">разрешенные типы файлов: png</div>
            </div>





            <div class="label-block">
                <label for="">Желаемая профессия  <span>*</span></label>
                <input type="text" id="prof" name="prof" placeholder="" value="<?php echo $user['prof'] ?>">
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
                    <input type="text" id="name" name="name" value="<?php echo $user['name'] ?>" placeholder="">
                    <span class="empty e-name">Это поле не должно быть пустым</span>
                </div>

                <div class="label-block au-fn">
                    <label for="">Фамилия <span>*</span></label>
                    <input type="text" id="surname" name="surname" value="<?php echo $user['surname'] ?>" placeholder="">
                    <span class="empty e-surname">Это поле не должно быть пустым</span>
                </div>

                <div class="label-block au-fn au-fn-2">
                    <label for="">Отчество <span>*</span></label>
                    <input type="text" id="patronymic" name="patronymic"value="<?php echo $user['patronymic'] ?>" placeholder="">
                    <span class="empty e-patronymic">Это поле не должно быть пустым</span>
                </div>
            </div>



            <div class="label-block au-fn au-fn-1">
                <label for="">Дата рождения <span>*</span></label>
                <div class="label-date-block">
                    <div>
                        <input maxlength="2" size="4" type="number" inputmode="numeric" name="date-1" id="date-1" placeholder="День" value="<?

                        if (!empty($user['age'])) {
                            echo DateTime::createFromFormat('d.m.Y', $user['age'])->format('d');
                        }

                        ?>">

                    </div>
                    <div>
                        <select name="date-2" id="date-2">
                            <?php
                            $job_type = ['', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];

                            if (!empty($user['age'])) {
                                foreach ($job_type as $key) {
                                    if (DateTime::createFromFormat('d.m.Y', $user['age'])->format('m') == $key) {
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
                        if (!empty($user['age'])) {
                            echo DateTime::createFromFormat('d.m.Y', $user['age'])->format('Y');
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
                        <input <?php if ($user['gender'] == 'Мужской') echo 'checked' ?> class="custom-radio" name="gender" type="radio" id="q101" value="Мужской">
                        <label for="q101">Мужской</label>
                    </p>

                    <p>
                        <input <?php if ($user['gender'] == 'Женский') echo 'checked' ?> class="custom-radio" name="gender" type="radio" id="q102" value="Женский">
                        <label for="q102">Женский</label>
                    </p>

                </div>
                <span class="empty e-radio">Это поле не должно быть пустым</span>
            </div>


            <div class="flex f-n">

                <div class="label-block au-fn au-fn-1">
                    <label for="email">E-mail <span>*</span></label>
                    <input disabled type="email" value="<?php echo $user['email'] ?>" placeholder="">

                </div>

                <div class="label-block au-fn">
                    <label for="">Телефон <span>*</span></label>
                    <input  type="tel" id="tel" name="phone" value="<?php echo $user['phone'] ?>" placeholder="+7 (999) 999-99-99">
                    <span class="empty e-tel">Это поле не должно быть пустым</span>
                </div>
            </div>

            <div class="label-block">
                <label for="">О себе</label>
                <textarea name="about" id="about" cols="30" rows="5"><?php echo $user['about'] ?></textarea>
            </div>
            <div class="label-block">
                <label class="" for="">Статус поиска</label>
                <div class="label-select-block">
                    <select name="stat" id="">
                        <option value="">Выбрать</option>
                        <?php
                        $job_type = ['В активном поиске', 'Рассматриваю предложения', 'Не ищу работу', 'Предложили работу', 'Вышел на новое место'];

                        if (isset($user['stat'])) {
                            foreach ($job_type as $key) {
                                if ($user['stat'] == $key) {
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
                    <label class="" for="">Факультет <span>*</span></label>
                    <div class="label-select-block">
                        <select name="faculty" id="faculty">
                            <?php
                            $job_type = [
                                'Факультет агробиологии и земельных ресурсов', 'Факультет экологии и ландшафтной архитектуры',
                                'Экономический факультет', 'Инженерно-технологический факультет',
                                'Биотехнологический факультет', 'Факультет социально-культурного сервиса и туризма',
                                'Электроэнергетический факультет', 'Учетно-финансовый факультет',
                                'Факультет ветеринарной медицины', 'Факультет среднего профессионального образования'];

                            if (isset($user['faculty'])) {
                                foreach ($job_type as $key) {
                                    if ($user['faculty'] == $key) {
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



                <div class="label-block au-fn"><label for="">Направление <span>*</span></label>
                    <div class="label-select-block">
                        <select class="select2-direction" name="direction" id="direction">
                            <option selected value="<?php echo $user['direction'] ?>"><?php echo $user['direction'] ?></option>
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



            <div class="label-block">
                <label for="">Образование <span>*</span></label>
                <div class="label-select-block">
                    <select name="degree" id="degree">
                        <?php
                        $job_type = ['Среднее профессиональное', 'Высшее (Бакалавриат)', 'Высшее (Специалитет)', 'Высшее (Магистратура)', 'Высшее (Аспирантура)'];

                        if (isset($user['degree'])) {
                            foreach ($job_type as $key) {
                                if ($user['degree'] == $key) {
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

                            if (isset($user['category'])) {
                                foreach ($cat as $key) {
                                    if ($user['category'] == $key) {
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

                            if (isset($user['exp'])) {
                                foreach ($exp as $key) {
                                    if ($user['exp'] == $key) {
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


            <?php $timeMe = explode(", ", $user['time']); ?>


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

                    if (isset($user['time'])) {
                        foreach ($time as $key) {
                            if ($user['time'] == $key) {
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

                <?php $typeMe = explode(", ", $user['type']); ?>

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

                    if (isset($user['type'])) {
                        foreach ($job_type as $key) {
                            if ($user['type'] == $key) {
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
                    <input type="number" id="salary" name="salary" value="<?php echo $user['salary'] ?>" placeholder="">
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

                        if (isset($user['drive'])) {
                            foreach ($job_type as $key) {
                                if ($user['drive'] == $key) {
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
                <input <?php if ($user['car'] == 1) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="q2" name="car" value="1">
                <label for="q2">
                    имею личный автомобиль
                </label>
            </div>
            <div class="label-b-check">
                <input <?php if ($user['go'] == 1) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="q1" name="go" value="1">
                <label for="q1">
                    я готов(-а) к переезду
                </label>
            </div>
            <div class="label-b-check">
                <input <?php if ($user['inv'] == 1) echo 'checked' ?> type="checkbox" class="custom-checkbox" id="q3" name="inv" value="1">
                <label for="q3">
                    у меня есть инвалидность
                </label>
            </div>

            <div class="flex f-n">
                <div class="label-block au-fn au-fn-1">
                    <label for="">Vk</label>
                    <input type="text" id="vk" name="vk" value="<?php echo $user['vk'] ?>" placeholder="Например, vk.com/profile">
                </div>

                <div class="label-block au-fn">
                    <label for="">Telegram</label>
                    <input type="text" id="telegram" name="telegram" value="<?php echo $user['telegram'] ?>" placeholder="Например, t.me/username">
                </div>
            </div>

            <div class="flex f-n">
                <div class="label-block au-fn au-fn-1">
                    <label for="">GitHub</label>
                    <input type="text" id="github" name="github" value="<?php echo $user['github'] ?>" placeholder="Например, https://github.com/profile">
                </div>

                <div class="label-block au-fn">
                    <label for="">Skype</label>
                    <input type="text" id="skype" name="skype" value="<?php echo $user['skype'] ?>" placeholder="">
                </div>
            </div>

            <div class="pf-bth">
                <button class="bth save-resume" type="button" name="">Сохранить</button>
            </div>
        </form>
    </div>














    <?php
} else {
    $app->notFound();
}
?>