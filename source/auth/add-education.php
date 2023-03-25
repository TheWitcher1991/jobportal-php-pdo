<?php

use Work\plugin\lib\pQuery;

if (isset($_SESSION['surname']) && isset($_SESSION['password']) && $_SESSION['type'] == 'users') {

    if ($_SESSION['type'] == 'users') {
        $sql = "SELECT * FROM `users` WHERE `id` = :id";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() <= 0) {
            pQuery::notFound();
        }

        $r = $stmt->fetch();
    }



    Head($r['name'] . ' ' . $r['surname'] . ' - добавить образование');

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
                    <span><a>Добавить образование</a></span>
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

                  <div class="resume-bth">
                        <a onclick="createForm()" class="bth-a create-ed">Добавить образование</a>
                    </div>








                    <?php
                    $sqled = "SELECT * FROM `education` WHERE `user_id` = :t ORDER BY `id`";
                    $stmted = $PDO->prepare($sqled);
                    $stmted->bindValue(':t', $r['id']);
                    $stmted->execute();
                    if ($stmted->rowCount() > 0) {
                        ?>

                        <div class="u-d-ab">
                            <span>Ваши данные</span>
                            <div class="db-text" style="padding: 16px 26px">
                                <ul class="dl-exp">
                                    <?php
                                    while ($re = $stmted->fetch()) {
                                        ?>
                                        <li class="education-<?php echo $re['id']; ?>">
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
                                            <button type="button" class="del-detatil" onclick="deleteDetail('<?php echo $re['id']; ?>')"><i class="mdi mdi-trash-can-outline"></i></button>
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


        <script>

            function deleteDetail(id) {
                $(`.education-${Number(id)} button`).html('<i class="mdi mdi-reload reload-bth"></i>')
                $(`.education-${Number(id)} button`).attr('disabled', 'true')
                $.ajax({
                    url: '/scripts/profile-js',
                    data: `id=${id}&MODULE_DELETE_EDUCATION=1`,
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
                            $(`.education-${Number(id)}`).remove()
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



            function respondEducation () {
                $('#auth .empty').fadeOut(50)
                $('#auth select').removeClass('errors')
                $('#auth input').removeClass('errors')
                $('.lock-yes').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
                $('.lock-yes').attr('disabled', 'true')
                $.ajax({
                    url: '/scripts/profile-js',
                    data: `${$('.form-education').serialize()}&MODULE_ADD_EDUCATION=1`,
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
                            if (responce.count === 1) {
                                location.reload()
                            } else {
                                deleteForm()
                                $('.dl-exp').append(responce.list)
                                $('.errors-block-fix').html(`
                            <div class="alert-block">
                                <div>
                                    <span>Успешно!</span>
                                    </br />
                                </div>
                                <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                            </div>
                            `)
                                $('.lock-yes').removeAttr('disabled')
                                $('.lock-yes').html('Добавить')
                                $('.errors-block-fix > div').css('display', 'flex')
                            }
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
                                    <label for="">Учебное заведение <span>*</span></label>
                                    <input type="text" name="ed-title" id="ed-title" placeholder="" value="">
                                    <span class="empty e-ed-title">Введите заведение</span>
                                </div>

                                <div class="label-block">
                                    <label for="">Специализация <span>*</span></label>
                                    <input type="text" name="ed-prof" id="ed-prof" value="">
                                    <span class="empty e-ed-prof">Введите специализацию</span>
                                </div>

                                <div class="label-block">
                                    <label for="">Год окончания <span>*</span></label>
                                    <input type="number" maxlength="4" size="4" inputmode="numeric" name="ed-date" id="ed-date" placeholder="" value="">
                                     <span class="empty e-ed-date">Некорректная дата</span>
                                </div>

                                <div class="label-block">
                                    <label for="">Краткое описание </label>
                                    <textarea name="ed-text" id="ed-text" style="height:100px;" cols="30" rows="10"></textarea>
                                </div>

                        </form>

                        <form method="post">
                            <div class="pop-flex-bth">
                                <button class="more-inf" type="button" onclick="deleteForm()">Отмена</button>
                                <button onclick="respondEducation()" type="button" class="lock-yes">Добавить</button>
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
            $('#auth').remove();
        }




        </script>



    </body>
    </html>
    <?php
} else {
    pQuery::notFound();
}
?>