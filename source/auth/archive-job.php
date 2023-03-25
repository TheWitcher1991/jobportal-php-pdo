<?php

use Work\plugin\lib\pQuery;

if (isset($_SESSION['company']) && isset($_SESSION['password']) && $_SESSION['type'] == 'company') {

    if ($_SESSION['type'] == 'company') {
        $sql = "SELECT * FROM `company` WHERE `id` = :id";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() <= 0) {
            pQuery::notFound();
        }

        $r = $stmt->fetch();
    } else {
        $app->notFound();
    }

    Head($r['name'] . ' - закрытые вакансии');


    ?>
    <body class="profile-body">

    <main class="wrapper wrapper-profile" id="wrapper">

        <div class="errors-block-fix"></div>

        <?php require('template/more/profileAside.php'); ?>

        <section class="profile-base">

            <?php require('template/more/profileHeader.php'); ?>

            <div class="profile-content create-resume">

                <div class="section-nav-profile">
                    <span><a href="/profile">Профиль</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a href="/manage-job">Закрытые вакансии</a></span>
                </div>

                <div class="manage-resume-data">


                    <div class="manage-profile-block">
                        <div class="block-table">
                            <table class="default-table">
                                <thead>
                                <tr>
                                    <th><span><i class="mdi mdi-pound"></i> Заголовок</span></th>
                                    <th><span><i class="mdi mdi-eye-outline"></i> Просмотры</span></th>
                                    <th><span><i class="mdi mdi-account-school"></i> Отклики</span></th>
                                    <th><span><i class="mdi mdi-calendar-check"></i> Дата закрытия</span></th>
                                    <th><span><i class="mdi mdi-calendar"></i> Дата размещения</span></th>
                                    <th><span><i class="mdi mdi-button-pointer"></i> Действия</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $results_per_page = 20;
                                $number_of_results = $app->count("SELECT * FROM `vacancy` WHERE `company_id` = '$r[id]' AND `status` = 1");
                                $number_of_pages = ceil($number_of_results / $results_per_page);
                                if (!isset($_GET['page'])) {
                                    $pag = 1;
                                } else {
                                    $pag = $_GET['page'];
                                }
                                $this_page_first_result = ($pag - 1) * $results_per_page;


                                $sql2 = "SELECT * FROM `vacancy` WHERE `company_id` = ? AND `status` = 1 ORDER BY `id` DESC LIMIT $this_page_first_result, $results_per_page";
                                $stmt2 = $PDO->prepare($sql2);
                                $stmt2->execute([$r['id']]);
                                if ($stmt2->rowCount() <= 0) {
                               } else {
                                    $count = 0;
                                    while ($rr = $stmt2->fetch()) {
                                        $count = $count + 1;
                                        ?>
                                        <tr class="job-<?php echo $count ?>">
                                            <td class="tb-title"><a target="_blank" href="/job?id=<?php echo $rr['id'] ?>"><?php echo $rr['title'] ?></a></td>
                                            <td class="tb-cat"><span><?php echo $rr['views'] ?></span></td>
                                            <td class="tb-cat"><span><?php echo $app->count("SELECT * FROM `respond` WHERE `job_id` = '$rr[id]'") ?></span></td>
                                            <td class="tb-date"><span><?php echo $rr['trash'] ?></span></td>
                                            <td class="tb-date"><span><?php echo $rr['date'] ?></span></td>
                                            <td class="tb-form">
                                                <form action="" method="post">
                                                    <div class="block-manage">

                                                        <a target="_blank" href="/analysis-job/?id=<?php echo $rr['id'] ?>" class="manage-bth"><i class="icon-graph"></i> Статистика </a>
                                                        <!--<button onclick="formVac(<?php echo $rr['id'] ?>, '<?php echo $rr['title'] ?>')"
                                                        class="manage-bth" name="pub-<?php echo $rr['id'] ?>" type="button"><i class="icon-note"></i> Опубликовать снова </button>-->
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
    <?
    if ($stmt2->rowCount() > 0) {
        ?>

                        <div class="table-paginator">
                            <div class="tp-1">
                                <span class="tp-now"><?php echo $pag ?></span> из <span class="tp-total"><?php echo $number_of_pages ?></span>
                            </div>
                            <div class="tp-2">
                                <?php


                                echo $paginator->table($pag, $number_of_results, 20, '/archive-job/?page=');

                                ?>
                            </div>
                        </div>

    <?
    }
    ?>
                    </div>



                </div>
            </div>

        </section>

    </main>

    <?php require('template/more/profileFooter.php'); ?>

    <script>

        function deleteForm(){document.querySelector('#auth').remove();}

        function publicJob(id, ctx) {
            $('.yes-delete-vac').attr('disabled', 'true');
            $('.yes-delete-vac').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`);
            let date = $('#date').val();
            $('.empty').fadeOut(50)
            $('input').removeClass('errors')
            $.ajax({
                url: '/scripts/profile-js',
                data: `id=${id}&MODULE_PUBLIC_AGAIN=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => {
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
                    $('.yes-delete-vac').removeAttr('disabled');
                    $('.yes-delete-vac').html('Закрыть');
                },
                success: function (responce) {
                    if (responce.code === 'validate_error') {
                        let $arr = responce.error
                        for (let i in $arr) {
                            $(`#${i}`).addClass('errors');
                            $(`.e-${i}`).fadeIn(50)
                        }
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
                        $('.yes-delete-vac').removeAttr('disabled');
                        $('.yes-delete-vac').html('Закрыть');
                    } else {
                        if (responce.code === 'success') {
                            $('.errors-block-fix').html(`
                            <div class="alert-block">
                                <div>
                                    <span>Отлично! Немного подождите...</span>
                                    </br />
                                </div>
                                <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                            </div>
                            `)
                            $('.errors-block-fix > div').css('display', 'flex')
                            location.reload()
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
                            $('.yes-delete-vac').removeAttr('disabled');
                            $('.yes-delete-vac').html('Закрыть');
                        }
                    }
                }})
        }

        function formVac(id,name){document.querySelector('.profile-body').innerHTML+=`

                        <div id="auth" style="display:flex">
                    <div class="contact-wrapper" style="display:block">
                        <div class="auth-container auth-log" style="display:block">
                            <div class="auth-title">
                                Добавить вакансию
                                <i class="mdi mdi-close form-detete" onclick="deleteForm()"></i>
                            </div>
                            <div class="auth-form">
                                <div class="pop-text">
                                    Вы уверены, что хотите снова опубликовать данную вакансию?
                                </div>
                                <span><i class="icon-briefcase"></i> ${name}</span>
                                <div class="label-block">
                                        <label for="date">Ожидаемая дата закрытия <span>*</span></label>
                                        <input <? if (isset($err['date'])) { ?> class="errors" <? } ?> type="date" id="date" name="date" min="<?php echo date("Y-m-d", time() + 1 * 24 * 60 * 60); ?>" value="<?php echo date('Y-m-d', time() + 31 * 24 * 60 * 60); ?>"
                                                                                                      max="<?php echo date('Y-m-d', time() + 562 * 24 * 60 * 60); ?>">
                                        <span class="empty e-date">ата указана неверно</span>
                                    </div>

                                <form method="post">
                                    <div class="pop-flex-bth">
                                        <button class="more-inf" type="button" onclick="deleteForm()">Отмена</button>
                                        <button data-id="${id}" type="button" class="lock-yes yes-delete-vac" name="delete-${id}" onclick="publicJob(${id}, this)">Опубликовать</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `}

    </script>

    </body>
    </html>
<?php
} else {
    pQuery::notFound();
}
?>