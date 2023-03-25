<?php
if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

    if ($_SESSION['type'] == 'admin') {
        $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($a['id'])) {
            $app->notFound();
        }

    }

  /*  if (isset($_POST["user-add"])) {

        $err = [];

        if (empty($_POST['name']) or trim($_POST['name']) == '') $err['name'] = 'Введите имя';
        if (empty($_POST['surname']) or trim($_POST['surname']) == '') $err['surname'] = 'Введите фамилию';
        if (empty($_POST['patronymic']) or trim($_POST['patronymic']) == '') $err['patronymic'] = 'Введите отчество';
        if (empty($_POST['email']) or trim($_POST['email']) == '') $err['email'] = 'Введите email';
        if (empty($_POST['phone']) or trim($_POST['phone']) == '') $err['phone'] = 'Введите телефон';
        if (empty($_POST['faculty']) or trim($_POST['faculty']) == '') $err['faculty'] = 'Укажите факультет';
        if (empty($_POST['direction']) or trim($_POST['direction']) == '') $err['direction'] = 'Укажите направление';
        if (empty($_POST['degree']) or trim($_POST['degree']) == '') $err['degree'] = 'Укажите текущее образование';
        if (strlen ($_POST['password']) < 8) $err[] = $err['password'] = 'Пароль должен быть не меньше 8 символов';

        if (empty($err)) {
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $patronymic = $_POST['patronymic'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $faculty = $_POST['faculty'];
            $direction = $_POST['direction'];
            $degree = $_POST['degree'];

            $r = $app->fetch("SELECT * FROM `users` WHERE `email` = :email", [':email' => $email]);

            if (!empty($r['id'])) {
                $err['email'] = 'Данная E-mail почта занята';
            } else {

                $code = random_str(25);

                $new_pass = md5(md5($password . $code . $name));

                $app->execute("INSERT INTO `users` (`name`, `code`, `surname`, `patronymic`, `email`, `password`, `faculty`, `direction`, `date`, `degree`, `phone`) 
                        VALUES(:uname, :code, :surname, :patronymic, :email, :pass, :faculty, :direction, :d, :degree, :phone)", [
                    ':uname' => $name,
                    ':code' => $code,
                    ':surname' => $surname,
                    ':patronymic' => $patronymic,
                    ':email' => $email,
                    ':pass' => $new_pass,
                    ':faculty' => $faculty,
                    ':direction' => $direction,
                    ':d' => $Date,
                    ':degree' => $degree,
                    ':phone' => $phone
                ]);



                $apply = 'Студент успешно записан в базу!';

            }

        }

    } */




    Head('Добавить студента');
    ?>

    <body class="profile-body">

    <main class="wrapper wrapper-profile" id="wrapper">


        <?php require('admin/template/adminAside.php'); ?>

        <section class="profile-base">

            <?php require('admin/template/adminHeader.php'); ?>

            <div class="profile-content admin-content">

                <div class="section-nav-profile">
                    <span><a href="/analysys">Кабинет</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a href="/students-add">Добавить студента</a></span>
                </div>

                <?php if (isset($apply)) { ?>
                    <div class="alert-block">
                        <div>
                            <span><?php echo $apply; ?></span>
                        </div>
                        <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                    </div>
                <?php } ?>



                <div class="errors-block-fix"></div>

                <div class="admin-data profile-data">

                    <div class="admin-data-block">
                        <span>Форма для заполнения</span>

                            <form class="form-create-user" role="form" method="post">

                                <div class="flex f-n">
                                    <div class="label-block au-fn au-fn-1">
                                        <label for="">Имя <span>*</span></label>
                                        <input type="text" id="name" name="name" value="<?php echo $_POST['name'] ?>" placeholder="">
                                        <? if (isset($err['name'])) { ?> <span class="error"><? echo $err['name']; ?></span> <? } ?>
                                        <span class="empty e-name">Введите имя</span>
                                    </div>

                                    <div class="label-block au-fn">
                                        <label for="">Фамилия <span>*</span></label>
                                        <input type="text" id="surname" name="surname" value="<?php echo $_POST['surname'] ?>" placeholder="">
                                        <? if (isset($err['surname'])) { ?> <span class="error"><? echo $err['surname']; ?></span> <? } ?>
                                        <span class="empty e-surname">Введите фамилию</span>
                                    </div>

                                    <div class="label-block au-fn au-fn-2">
                                        <label for="">Отчество <span>*</span></label>
                                        <input type="text" id="patronymic" name="patronymic"value="<?php echo $_POST['patronymic'] ?>" placeholder="">
                                        <? if (isset($err['patronymic'])) { ?> <span class="error"><? echo $err['patronymic']; ?></span> <? } ?>
                                        <span class="empty e-patronymic">Введите отчество</span>
                                    </div>
                                </div>

                                <div class="label-block">
                                    <label for="">Предполагаемая профессия <span>*</span></label>
                                    <input type="text" id="prof" name="prof" value="<?php echo $_POST['prof'] ?>" placeholder="">
                                    <? if (isset($err['prof'])) { ?> <span class="error"><? echo $err['prof']; ?></span> <? } ?>
                                    <span class="empty e-prof">Введите профессию</span>
                                </div>

                                <div class="label-block">
                                    <label for="">Пароль <span>*</span></label>
                                    <div class="label-password-2">
                                        <input type="password" id="password" name="password" value="" placeholder="Пароль должен быть не меньше 8 символов">
                                        <i class="mdi mdi-eye-outline eye-password in-pass"></i>
                                    </div>

                                    <? if (isset($err['password'])) { ?> <span class="error"><? echo $err['password']; ?></span> <? } ?>
                                    <span class="empty e-password">Введите пароль</span>
                                </div>


                                <div class="flex f-n">
                                    <div class="label-block au-fn au-fn-1">
                                        <label for="">E-mail <span>*</span></label>
                                        <input type="email" id="email" name="email" value="<?php echo $_POST['email'] ?>" placeholder="">
                                        <? if (isset($err['email'])) { ?> <span class="error"><? echo $err['email']; ?></span> <? } ?>
                                        <span class="empty e-email">Введите email</span>
                                    </div>

                                    <div class="label-block au-fn">
                                        <label for="">Телефон <span>*</span></label>
                                        <input  type="text" id="tel" name="phone" value="<?php echo $_POST['phone'] ?>" placeholder="+7 (999) 999-99-99">
                                        <? if (isset($err['phone'])) { ?> <span class="error"><? echo $err['phone']; ?></span> <? } ?>
                                        <span class="empty e-phone">Введите телефон</span>
                                    </div>
                                </div>

                                <div class="label-block">
                                    <label class="" for="">Факультет <span>*</span></label>
                                    <div class="label-select-block">
                                        <select class="field-user" id="faculty" name="faculty">
                                            <option value="">Выбрать</option>
                                            <option value="Факультет агробиологии и земельных ресурсов">Факультет агробиологии и земельных ресурсов</option>
                                            <option value="Факультет экологии и ландшафтной архитектуры">Факультет экологии и ландшафтной архитектуры</option>
                                            <option value="Экономический факультет">Экономический факультет</option>
                                            <option value="Инженерно-технологический факультет">Инженерно-технологический факультет</option>
                                            <option value="Биотехнологический факультет">Биотехнологический факультет</option>
                                            <option value="Факультет социально-культурного сервиса и туризма">Факультет социально-культурного сервиса и туризма</option>
                                            <option value="Электроэнергетический факультет">Электроэнергетический факультет</option>
                                            <option value="Учетно-финансовый факультет">Учетно-финансовый факультет</option>
                                            <option value="Факультет ветеринарной медицины">Факультет ветеринарной медицины</option>
                                            <option value="Факультет среднего профессионального образования">Факультет среднего профессионального образования</option>
                                        </select>
                                        <div class="label-arrow">
                                            <i class="mdi mdi-chevron-down"></i>
                                        </div>
                                    </div>
                                    <? if (isset($err['faculty'])) { ?> <span class="error"><? echo $err['faculty']; ?></span> <? } ?>
                                    <span class="empty e-faculty">Выберите факультет</span>
                                </div>
                                <div class="label-block">
                                    <label for="">Направление <span>*</span></label>
                                    <div class="label-select-block">
                                        <select class="select2-direction" name="direction" id="direction">
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
                                    <span class="empty e-direction">Выберите направление</span>
                                </div>

                                <div class="label-block">
                                    <label for="">Текущее образование <span>*</span></label>
                                    <div class="label-select-block">
                                        <select class="field-user" name="degree" id="degree">
                                            <option value="Среднее профессиональное">Среднее профессиональное</option>
                                            <option value="Высшее (Бакалавриат)">Высшее (Бакалавриат)</option>
                                            <option value="Высшее (Специалитет)">Высшее (Специалитет)</option>
                                            <option value="Высшее (Магистратура)">Высшее (Магистратура)</option>
                                            <option value="Высшее (Аспирантура)">Высшее (Аспирантура)</option>
                                        </select>
                                        <div class="label-arrow">
                                            <i class="mdi mdi-chevron-down"></i>
                                        </div>
                                    </div>
                                    <? if (isset($err['degree'])) { ?> <span class="error"><? echo $err['degree']; ?></span> <? } ?>
                                    <span class="empty e-degree">Выберите образование</span>
                                </div>

                                <div class="pf-bth">
                                    <button class="bth user-add" type="button" name="user-add">
                                        Добавить
                                    </button>
                                </div>
                            </form>



                    </div>

                </div>

            </div>


        </section>

    </main>


    <?php require('admin/template/adminFooter.php'); ?>

    <script>



        function addUser() {

            $('.empty').fadeOut(50)
            $('input').removeClass('errors')
            $('select').removeClass('errors')
            $('.label-block .select2-container--default .select2-selection--single').css({
                'border': '2px solid transparent',
                'background': 'rgb(245, 246, 248)'
            })
            $('.user-add').attr('disabled', 'true')
            $('.user-add').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)

            $.ajax({
                url: '/admin/admin-js',
                data: `${$('.form-create-user').serialize()}&MODULE_CREATE_STUDENT=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => {
                    MessageBox('Произошла ошибка. Повторите')
                    $('.user-add').html('Добавить')
                    document.querySelector('.user-add').removeAttribute('disabled')
                },
                success: function (responce) {
                    if (responce.code === 'validate_error') {
                        let $arr = responce.error
                        for (let i in $arr) {
                            if (i === 'direction') $('span[aria-controls="select2-direction-container"]').css({
                                'border': '2px solid #ff4c4c',
                                'background': 'rgba(255,22,46,.06)'
                            })
                            $(`#${i}`).addClass('errors');
                            $(`.e-${i}`).fadeIn(50)
                        }
                        $('.user-add').html('Добавить')
                        document.querySelector('.user-add').removeAttribute('disabled')
                    } else {
                        if (responce.code === 'success') {
                            $('.form-create-user')[0].reset()
                            MessageBox('Студент добавлен')
                            $('.user-add').html('Добавить')
                            document.querySelector('.user-add').removeAttribute('disabled')
                        } else {
                            MessageBox('Произошла ошибка. Повторите')
                            $('.user-add').html('Добавить')
                            document.querySelector('.user-add').removeAttribute('disabled')
                        }
                    }
                }})
        }

        $('.bth').on('click', function (e) {
            e.preventDefault()
            addUser()
        })




    </script>

    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>