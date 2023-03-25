<?php
if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

    if ($_SESSION['type'] == 'admin') {
        $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($a['id'])) {
            $app->notFound();
        }
    } else {
        $app->notFound();
    }



    /*if (isset($_POST["company-add"])) {

        $err = [];

        if (empty($_POST['inn']) or trim($_POST['inn']) == '') $err['inn'] = 'Введите ИНН';
        if (empty($_POST['username']) or trim($_POST['username']) == '') $err['username'] = 'Введите имя';
        if (empty($_POST['type']) or trim($_POST['type']) == '') $err['type'] = 'Укажите тип компании';
        if (empty($_POST['name']) or trim($_POST['name']) == '') $err['name'] = 'Введите название компании';
        if (empty($_POST['phone']) or trim($_POST['phone']) == '') $err['phone'] = 'Введите телефон';
        if (empty($_POST['email']) or trim($_POST['email']) == '') $err['email'] = 'Введите email';
        if (empty($_POST['address']) or trim($_POST['address']) == '') $err['address'] = 'Введите город';
        if (strlen ($_POST['password']) < 8) $err[] = $err['password'] = 'Пароль должен быть не меньше 8 символов';

        if (empty($err)) {
            $username = $_POST['username'];
            $inn = $_POST['inn'];
            $type = $_POST['type'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $password = $_POST['password'];

            $r = $app->fetch("SELECT * FROM `company` WHERE `email` = :email", [':email' => $email]);

            if (!empty($r['id'])) {
                $err[] = 'Данная E-mail почта занята';
            } else {

                $code = random_str(25);

                $new_pass = md5(md5($password . $code . $email));

                $app->execute("INSERT INTO `company` (`inn`, `verified`, `username`, `code`, `type`, `name`, `phone`, `email`, `password`, `date`, `address`) 
                                                VALUES(:inn, :ver, :un, :code, :typ, :uname, :phone, :email, :passwor, :d, :ad)", [
                    ':inn' => $inn,
                    ':ver' => 1,
                    ':un' => $username,
                    ':code' => $code,
                    ':typ' => $type,
                    ':uname' => $name,
                    ':phone' => $phone,
                    ':email' => $email,
                    ':passwor' => $new_pass,
                    ':d' => $Date,
                    ':ad' => $address
                ]);



                SENDMAIL($mail, 'Регистрация на stgaujob', $email, $name, "
Благодарим за регистрация на stgaujob.ru! 
Ваш логин: $email 
Ваш пароль: $password  
");

                $apply = 'Компания успешно записана в базу!';


            }

        }

    }*/

    Head('Добавить компанию');


    ?>

    <body class="profile-body">

    <main class="wrapper wrapper-profile" id="wrapper">

        <div class="errors-block-fix"></div>


        <?php require('admin/template/adminAside.php'); ?>

        <section class="profile-base">

            <?php require('admin/template/adminHeader.php'); ?>

            <div class="profile-content admin-content">

                <div class="section-nav-profile">
                    <span><a href="/analysys">Кабинет</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span>Добавить компанию</span>
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

                <div class="errors-block">

                </div>

                <div class="admin-data">

                    <div class="admin-data-block profile-data">
                        <span>Форма для заполнения</span>

                        <form class="form-create-company" role="form" method="post">



                            <div class="flex f-n">
                                <div class="label-block au-fn au-fn-1">
                                    <label for="">ИНН компании <span>*</span></label>
                                    <input <? if (isset($err['inn'])) { ?> class="errors" <? } ?> type="text" id="inn" name="inn" placeholder="" value="<? echo $_POST['inn']; ?>">
                                    <? if (isset($err['inn'])) { ?> <span class="error"><? echo $err['inn']; ?></span> <? } ?>
                                    <span class="empty e-inn">Введите ИНН</span>
                                </div>

                                <div class="label-block au-fn">
                                    <label for="">Контактное лицо</label>
                                    <input <? if (isset($err['username'])) { ?> class="errors" <? } ?> type="text" id="username" name="username" placeholder="Например, Иван Иванов" value="<? echo $_POST['username']; ?>">
                                    <? if (isset($err['username'])) { ?> <span class="error"><? echo $err['username']; ?></span> <? } ?>
                                    <span class="empty e-username">Введите контактное лицо</span>
                                </div>
                            </div>


                            <div class="flex f-n">
                                <div class="label-block au-fn au-fn-1">
                                    <label for="">Тип компании <span>*</span></label>
                                    <div class="label-select-block">
                                        <select id="type" <? if (isset($err['type'])) { ?> class="errors" <? } ?> name="type">
                                            <option value="">Выбрать</option>
                                            <option value="Частная">Частная</option>
                                            <option value="Государственная">Государственная</option>
                                            <option value="Смешанная">Смешанная</option>
                                            <option value="Кадровое агенство">Кадровое агенство</option>
                                        </select>
                                        <div class="label-arrow">
                                            <i class="mdi mdi-chevron-down"></i>
                                        </div>
                                    </div>
                                    <? if (isset($err['type'])) { ?> <span class="error"><? echo $err['type']; ?></span> <? } ?>
                                    <span class="empty e-type">Выберите тип</span>
                                </div>

                                <div class="label-block au-fn">
                                    <label for="">Название компании <span>*</span></label>
                                    <input <? if (isset($err['name'])) { ?> class="errors" <? } ?> type="text" id="name" name="name" placeholder="" value="<? echo $_POST['name']; ?>">
                                    <? if (isset($err['name'])) { ?> <span class="error"><? echo $err['name']; ?></span> <? } ?>
                                    <span class="empty e-name">Введите название</span>
                                </div>
                            </div>

                            <div class="label-block">
                                <label for="">E-mail <span>*</span></label>
                                <input <? if (isset($err['email'])) { ?> class="errors" <? } ?> type="email" id="mail" name="email" placeholder="" value="<? echo $_POST['email']; ?>">
                                <? if (isset($err['email'])) { ?> <span class="error"><? echo $err['email']; ?></span> <? } ?>
                                <span class="empty e-mail">Введите email</span>
                            </div>

                            <div class="label-block">
                                <label for="">Телефон <span>*</span></label>
                                <input <? if (isset($err['phone'])) { ?> class="errors" <? } ?> type="text" id="tel" name="phone" placeholder="+7 (999) 999-99-99" value="<? echo $_POST['phone']; ?>">
                                <? if (isset($err['phone'])) { ?> <span class="error"><? echo $err['phone']; ?></span> <? } ?>
                                <span class="empty e-tel">Введите телефон</span>
                            </div>

                            <div class="label-block">
                                <label for="address">Город <span>*</span></label>
                                <div class="label-select-block">
                                    <select id="address" class="address" name="address" placeholder="Выберите город">
                                        <option value="">Выбрать</option>
                                        <? foreach ($city as $key => $val) { ?>
                                            <option value="<? echo $val ?>"><? echo $val ?></option>
                                        <? } ?>
                                    </select>
                                    <div class="label-arrow">
                                        <i class="mdi mdi-chevron-down"></i>
                                    </div>
                                </div>
                                <? if (isset($err['address'])) { ?> <span class="error"><? echo $err['address']; ?></span> <? } ?>
                                <span class="empty e-address">Выберите город</span>
                            </div>

                            <div class="label-block">
                                <label for="">Пароль <span>*</span></label>

                                <div class="label-password-2">
                                    <input <? if (isset($err['password'])) { ?> class="errors" <? } ?> type="password" id="password" name="password" placeholder="Пароль должен быть не меньше 8 символов">
                                    <i class="mdi mdi-eye-outline eye-password in-pass"></i>
                                </div>
                                
                                <span class="empty e-password">Пароль должен быть не меньше 8 символов</span>
                            </div>
                            <div class="pf-bth">
                                <button class="bth company-add" type="button" name="company-add">
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




            function addCompany() {

                $('.empty').fadeOut(50)
                $('input').removeClass('errors')
                $('select').removeClass('errors')
                $('.label-block .select2-container--default .select2-selection--single').css({
                    'border': '2px solid transparent',
                    'background': '#ffffff'
                })
                $('.company-add').attr('disabled', 'true')
                $('.company-add').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
                $.ajax({
                    url: '/admin/admin-js',
                    data: `${$('.form-create-company').serialize()}&MODULE_CREATE_COMPANY=1`,
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    error: (response) => {
                        MessageBox('Произошла ошибка. Повторите')
                        $('.company-add').html('Продолжить')
                        document.querySelector('.company-add').removeAttribute('disabled')
                    },
                    success: function (responce) {
                        if (responce.code === 'validate_error') {
                            let $arr = responce.error
                            for (let i in $arr) {
                                if (i === 'address') $('span[aria-controls="select2-address-container"]').css({
                                    'border': '1px solid #ff4c4c',
                                    'background': 'rgba(255,22,46,.06)'
                                })
                                $(`#${i}`).addClass('errors');
                                $(`.e-${i}`).fadeIn(50)
                            }
                            $('.company-add').html('Добавить')
                            document.querySelector('.company-add').removeAttribute('disabled')
                        } else {
                            if (responce.code === 'success') {
                                $('.form-create-company')[0].reset()
                                $('.errors-block').html(`
                            <div class="alert-block wow fadeIn">
                                    <div>
                                        <span>Компания добавлена</span>
                                    </div>
                                    <span onclick="$(this).parent().remove()" class="exp-ed"><i class="mdi mdi-close"></i></span>
                                    </div>
                        `)
                                $('.company-add').html('Добавить')
                                document.querySelector('.company-add').removeAttribute('disabled')
                            } else {
                                MessageBox('Произошла ошибка. Повторите')
                                $('.company-add').html('Добавить')
                                document.querySelector('.company-add').removeAttribute('disabled')
                            }
                        }
                    }})
            }

            $('.bth').on('click', function (e) {
                e.preventDefault()
                addCompany()
            })




    </script>


    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>