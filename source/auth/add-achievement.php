<?php

use Work\plugin\lib\pQuery;

if (isset($_SESSION['surname']) && isset($_SESSION['password']) && $_SESSION['type'] == 'users') {

    if ($_SESSION['type'] == 'users') {
        $sql = "SELECT * FROM `users` WHERE `id` = :id";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() <= 0) {
            $app->notFound();
        }

        $r = $stmt->fetch();
    }

    Head($r['name'] . ' ' . $r['surname'] . ' - добавить достижение');


    /*if (isset($_POST['add']) && isset($_POST['text'])) {
        $type = $_POST['type'];
        $title = $_POST['title'];
        $text = $_POST['text'];

        $sql = "INSERT INTO `achievement` (`name`, `type`, `text`, `user`)
                                            VALUES(:n, :typ, :t, :u)";
        $stmt = $PDO->prepare($sql);
        $stmt->execute([
            ':n' => $title,
            ':typ' => $type,
            ':t' => $text,
            ':u' => (int) $r['id']
        ]);

        $success = 'Данные успешно записаны!';

    }*/

    ?>

    <body class="profile-body">

    <main class="wrapper wrapper-profile" id="wrapper">


        <?php require('template/more/profileAside.php'); ?>

        <section class="profile-base">

            <?php require('template/more/profileHeader.php'); ?>


            <div class="profile-content profile">

                <div class="section-nav-profile">
                    <span><a href="/profile">Профиль</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a>Добавить достижение</a></span>
                </div>

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
                <div class="profile-data">

                    <? include 'template/more/profileHead.php'; ?>

                    <div class="resume-bth">
                        <a onclick="createForm()" class="bth-a create-achi">Добавить достижение</a>
                    </div>






                    <?php
                    $sqled = "SELECT * FROM `achievement` WHERE `user` = :t";
                    $stmted = $PDO->prepare($sqled);
                    $stmted->bindValue(':t', $r['id']);
                    $stmted->execute();
                    if ($stmted->rowCount() > 0) {
                        ?>

                        <div class="u-d-ab">
                            <span>Ваши данные</span>
                            <div class="db-text" style="padding: 16px 26px">
                                <ul class="dds-exp">
                                    <?php
                                    while ($rx = $stmted->fetch()) {
                                        ?>
                                        <li style="display:block;" class="ach-<?php echo $rx['id']; ?>">
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
                                            $stmtei->bindValue(':ui', $r['id']);
                                            $stmtei->bindValue(':hash', $rx['hash']);
                                            $stmtei->execute();

                                            if ($stmtei->rowCount() > 0) {


                                                ?>
                                                <div class="dle-img">
                                                    <?php while ($i = $stmtei->fetch()) {

                                                        $ext = mb_strtolower(mb_substr(mb_strrchr(@$i['filename'], '.'), 1));


                                                        ?>

                                                            <div data-file="<?php echo $i['filename'] ?>" data-id="<?php echo $i['id'] ?>">
                                                                <a data-file="<?php echo $i['filename'] ?>" data-id="<?php echo $i['id'] ?>" class="none" href="/static/file/users_file/<?php echo $i['filename'] ?>" download="">
                                                                    <i class="icon-cloud-download"></i> .<?php echo $ext ?>

                                                                </a>
                                                                <button data-file="<?php echo $i['filename'] ?>" data-id="<?php echo $i['id'] ?>"><i class="mdi mdi-close"></i></button>
                                                            </div>



                                                    <?php } ?>


                                                </div>
                                            <?php } ?>
                                            <button type="button" class="del-detatil" onclick="deleteDetail('<?php echo $rx['id']; ?>')"><i class="mdi mdi-trash-can-outline"></i></button>
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


                </div>
            </div>
        </section>

    </main>



    <?php require('template/more/profileFooter.php'); ?>

    <?php

    if (isset($_SESSION['id']) && isset($_SESSION['password']) && $_SESSION['type'] == 'users') {

        ?>

        <script>

            function deleteDetail(id) {
                $(`.ach-${Number(id)} button`).html('<i class="mdi mdi-reload reload-bth"></i>')
                $(`.ach-${Number(id)} button`).attr('disabled', 'true')
                $.ajax({
                    url: '/scripts/profile-js',
                    data: `id=${id}&MODULE_DELETE_ACHIEVEMENT=1`,
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    error: function (response) {
                        $('.errors-block-fix').html(`
                            <div class="alert-block">
                                <div>
                                    <span>Произошла ошибка. Повторите</span>
                                    </br />
                                </div>
                                <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                            </div>
                            `)
                        $('.errors-block-fix > div').css('display', 'flex')

                    },
                    success: function (responce) {
                        if (responce.code === 'success') {
                            if (responce.count <= 0) {
                                location.reload()
                            } else {
                                $(`.ach-${Number(id)}`).remove()
                            }
                        } else {
                            $('.errors-block-fix').html(`
                            <div class="alert-block">
                                <div>
                                    <span>Произошла ошибка. Повторите</span>
                                    </br />
                                </div>
                                <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                            </div>
                            `)
                            $('.errors-block-fix > div').css('display', 'flex')
                        }
                    }
                })
            }

            function respondArchi () {
                $('#auth .empty').fadeOut(50)
                $('#auth select').removeClass('errors')
                $('#auth input').removeClass('errors')
                $('.lock-yes').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
                $('.lock-yes').attr('disabled', 'true')
                $.ajax({
                    url: '/scripts/profile-js',
                    data: `${$('.form-education').serialize()}&MODULE_ADD_ACHIEVEMENT=1`,
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    error: function (response) {
                        $('.errors-block-fix').html(`
                            <div class="alert-block">
                                <div>
                                    <span>Произошла ошибка. Повторите</span>
                                    </br />
                                </div>
                                <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                            </div>
                            `)
                        $('.lock-yes').removeAttr('disabled')
                        $('.lock-yes').html('Добавить')
                        $('.errors-block-fix > div').css('display', 'flex')
                    },
                    success: function (responce) {
                        if (responce.code === 'success') {
                            location.reload()
                        } else {
                            if (responce.code === 'validate_error') {
                                $('.lock-yes').removeAttr('disabled')
                                $('.lock-yes').html('Добавить')
                                let $arr = responce.error
                                for (let i in $arr) {
                                    $(`#${i}`).addClass('errors');
                                    $(`#${i}`).text($arr[i]);
                                    $(`.e-${i}`).fadeIn(50)
                                    $(`.e-${i}`).text($arr[i]);
                                }
                            } else {
                                $('.errors-block-fix').html(`
                            <div class="alert-block">
                                <div>
                                    <span>Произошла ошибка. Повторите</span>
                                    </br />
                                </div>
                                <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                            </div>
                            `)
                                $('.lock-yes').removeAttr('disabled')
                                $('.lock-yes').html('Добавить')
                                $('.errors-block-fix > div').css('display', 'flex')
                            }
                        }
                    }
                })
            }

            function upload () {
                $('.lock-yes').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
                $('.lock-yes').attr('disabled', 'true')
                $('.uploadButton-button').addClass('disabled-file')
                $('.upload-cxt').attr('disabled', 'true')

                    if (window.FormData === undefined) {
                        alert('В вашем браузере загрузка файлов не поддерживается');
                    } else {
                        let formData = new FormData();
                        $.each($('.upload-cxt')[0].files, function(key, input) {
                            formData.append('file[]', input);
                        });
                        $.ajax({
                            type: 'POST',
                            url: '/scripts/uploads-js',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            dataType : 'json',
                            success: function(response){
                                response.forEach(function(row) {
                                    if (row.error == '') {
                                        $('.image-box').fadeIn(200)
                                        $('.image-box').css('display', 'flex')
                                        $('.image-box').append(row.data);
                                        $('.uploadButton-button').removeClass('disabled-file')
                                        $('.upload-cxt').removeAttr('disabled')
                                        $('.lock-yes').removeAttr('disabled')
                                        $('.lock-yes').html('Добавить')
                                    } else {
                                        alert(row.error);
                                        $('.uploadButton-button').removeClass('disabled-file')
                                        $('.upload-cxt').removeAttr('disabled')
                                        $('.lock-yes').removeAttr('disabled')
                                        $('.lock-yes').html('Добавить')
                                    }
                                });
                                $(".image-box").val('');
                            }
                        })
                    }
            }

            function createForm() {
                document.querySelector('.profile-body').innerHTML += `
        <div id="auth" style="display:flex">
            <div class="contact-wrapper" style="display:block">
                <div class="auth-container auth-log auth-form-r" >
                    <div class="auth-title">
                        Образование
                        <i class="mdi mdi-close form-detete" onclick="deleteForm()"></i>
                    </div>
                    <div class="auth-form">
                        <form class="form-education" role="form" method="post">

                                <div class="label-block">
                                    <label for="">Тип <span>*</span></label>
                                    <div class="label-select-block">
                                    <select name="type" id="type">
                                        <option value="Личные файлы">Личные файлы</option>
                                        <option value="Общественная работа в университете">Общественная работа в университете</option>
                                        <option value="Участие в общественных организациях">Участие в общественных организациях</option>
                                        <option value="Волонтерская работа">Волонтерская работа</option>
                                        <option value="Научное направление">Научное направление</option>
                                        <option value="Статья в научных трудах">Статья в научных трудах</option>
                                        <option value="Статья в изданиях, рекомендованных ВАК">Статья в изданиях, рекомендованных ВАК</option>
                                        <option value="Патенты и авторские свидетельства и др.">Патенты и авторские свидетельства и др.</option>
                                        <option value="Участие в грантовых программах, стажировках">Участие в грантовых программах, стажировках</option>
                                        <option value="Стажировки в России">Стажировки в России</option>
                                        <option value="Языковые сертификаты">Языковые сертификаты</option>
                                        <option value="Благодарственные письма">Благодарственные письма</option>
                                        <option value="Почетные грамоты">Почетные грамоты</option>
                                        <option value="Дипломы">Дипломы</option>
                                        <option value="Медали">Медали</option>
                                        <option value="Сертификаты">Сертификаты</option>
                                    </select>
                                    <div class="label-arrow">
                                        <i class="mdi mdi-chevron-down"></i>
                                    </div>
                                </div>
                                    <span class="empty e-type">Выберите тип</span>
                                </div>

                                <div class="label-block">
                                    <label for="">Название <span>*</span></label>
                                    <input type="text" name="title" id="title" value="">
                                    <span class="empty e-title">Введите название</span>
                                </div>
                                <div class="label-block">
                                    <label for="">Краткое описание </label>
                                    <textarea name="text" id="text" style="height:100px;" cols="30" rows="10"></textarea>
                                </div>

   <div class="upload-block">
                                <div class="uploadButton-block">
                                    <input onchange="upload()" class="uploadButton-input upload-cxt" type="file" name="file[]" accept=".jpg,.jpeg,.png,.doc,.txt,.rar,.zip,.tar,.docx,.ppt,.odt"  id="upload3" multiple>
                                    <label class="uploadButton-button ripple-effect" for="upload3" style="">
                                        <i class="icon-cloud-upload"></i>
                                        Нажмите для загрузки файлов
                                        <br />
                                        DOC, DOCX, PPT, ODT PDF, TXT, RAR, ZIP, TAR, PNG, JPG
                                    </label>
                                    <span class="uploadButton-file-name"></span>
                                </div>
                                <div class="text"></div>
                            </div>

                            <div class="image-box"></div>

                        </form>

                        <form method="post">
                            <div class="pop-flex-bth">
                                <button class="more-inf" type="button" onclick="deleteForm()">Отмена</button>
                                <button onclick="respondArchi()" type="button" class="lock-yes">Добавить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        `
            }

            function deleteForm () {
                $('#auth').css('display', 'none')
                $(document).find('#auth').remove();
            }

        </script>

        <script language="JavaScript" src="/static/scripts/profile.js?v=<?= date('YmdHis') ?>"></script>


        <?php
    }


    ?>

    </body>
    </html>
    <?php
} else {
    pQuery::notFound();
}
?>