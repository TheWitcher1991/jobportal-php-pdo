<?php
if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

    if ($_SESSION['type'] == 'admin') {
        $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($a['id'])) {
            $app->notFound();
        }
    }

    ?>

    <?php if (count($res2) > 0) { ?>

        <div class="block-al" style="margin: 0 0 30px 0">
            <span>Просмотры и отклики <i class="fa-solid fa-minus"></i></span>
            <div class="chart">
                <div id="respond2" style="height: 250px"></div>
            </div>
        </div>

    <?php } ?>


    <div class="pr-data-block block-p bl-1">




        <span>Данные компании</span>
        <form role="form" class="form-profile" method="post">


            <h3>Логотип компании</h3>
            <div class="pfa-wrap">
                <div class="pfa-a pfa-comp">

                                <span>
                                    <img src="/static/image/company/<?php echo $rc['img'] ?>" alt="">
                                      <div class="pfa-a-bth"><i class="mdi mdi-pencil"></i></div>
                                    <?php if ($rc['img'] != 'placeholder.png') { ?>
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

                    if (trim($rc['baner']) == '') {

                        echo '<div class="pfb-bth more-inf"><i class="mdi mdi-pencil"></i> Добавить</div>';

                    }

                    ?>

                    <?php if (isset($rc['baner']) AND trim($rc['baner']) != '') { ?>
                        <div class="prof-baner">
                            <img src="/static/image/company_banner/<?php echo $rc['baner'] ?>" alt="">

                            <?php

                            if (!empty($rc['baner']) AND trim($rc['baner']) != '') {

                                echo '<div class="pfb-bth pfbbs"><i class="mdi mdi-pencil"></i></div>';

                            }

                            ?>

                            <button type="submit" name="delete-logo-baner"><span class="mdi mdi-window-close"></span></button>
                        </div>
                    <?php } ?>
                </div>
                <div class="ini-text">разрешенные типы файлов: png, jpg, avif</div>
            </div>


            <!--   <h3>Логотип компании</h3>
                            <div class="pfa-a pfa-comp">
                                <div class="pfa-a-bth more-inf"><i class="mdi mdi-pencil"></i> Изменить</div>
                                <span>
                                <img src="/static/image/company/<?php echo $rc['img'] ?>" alt="">
                                <?php if ($rc['img'] != 'placeholder.png') { ?>
                                    <button type="submit" name="delete-logo-user"><span class="mdi mdi-window-close"></span></button>
                                <?php } ?>
                            </span>
                            </div>
                            <h3>Баннер компании</h3>
                            <div style="margin: 0 0 20px 0" class="pfb-a">
                                <div class="pfb-bth more-inf"><i class="mdi mdi-pencil"></i> <?php if (isset($rc['baner']) AND trim($rc['baner']) != '') echo 'Изменить'; else echo 'Добавить'; ?></div>
                                <?php if (isset($rc['baner']) AND trim($rc['baner']) != '') { ?>
                                    <div class="prof-baner">
                                        <img src="/static/image/company_banner/<?php echo $rc['baner'] ?>" alt="">
                                        <button type="submit" name="delete-logo-baner"><span class="mdi mdi-window-close"></span></button>
                                    </div>
                                <?php } ?>
                            </div> -->

            <div class="flex f-n">
                <div class="label-block au-fn au-fn-1">
                    <label for="">Контактное лицо</label>
                    <input type="text" id="username" name="username" value="<?php echo $rc['username'] ?>" placeholder="">
                    <span class="empty e-username">Это поле не должно быть пустым</span>
                </div>


                <div class="label-block au-fn">
                    <label for="">Телефон <span>*</span></label>
                    <input  type="tel" id="tel" name="tel" value="<?php echo $rc['phone'] ?>" placeholder="">
                    <span class="empty e-tel">Это поле не должно быть пустым</span>
                </div>
            </div>



            <div class="flex f-n">
                <div class="label-block au-fn au-fn-1">
                    <label for="">ИНН Компании <span>*</span></label>
                    <input type="number" id="inn" name="inn" value="<?php echo $rc['inn'] ?>" placeholder="">
                    <span class="empty e-inn">Это поле не должно быть пустым</span>
                </div>
                <div class="label-block au-fn">
                    <label class="" for="">Тип компании <span>*</span></label>
                    <div class="label-select-block">
                        <select id="type" name="type">
                            <?php
                            $job_type = ['Частная', 'Государственная', 'Смешанная', 'Кадровое агенство'];

                            if (isset($rc['type'])) {
                                foreach ($job_type as $key) {
                                    if ($rc['type'] == $key) {
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
                    <input disabled type="text" value="<?php echo $rc['name'] ?>" placeholder="">


                </div>
                <div class="label-block au-fn">
                    <label for="email">E-mail <span>*</span></label>
                    <input disabled type="email" value="<?php echo $rc['email'] ?>" placeholder="">
                </div>
            </div>
            <div class="flex f-n">
                <div class="label-block au-fn  au-fn-1">
                    <label for="">Город <span>*</span></label>
                    <div class="label-select-block">
                        <select <? if (isset($err['address'])) { ?> class="errors" <? } ?> name="address" id="address" placeholder="Выберите город">
                            <?php

                            if (isset($rc['address'])) {
                                foreach ($city as $key) {
                                    if ($rc['address'] == $key) {
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
                    <input type="text" name="specialty" id="specialty" value="<?php echo $rc['specialty'] ?>">

                </div>



            </div>

            <div class="label-block">
                <label for="about">О компании</label>
                <textarea name="about" id="about" id="about" cols="30" rows="5"><?php echo $rc['about'] ?></textarea>
            </div>

            <div class="flex f-n">
                <div class="label-block au-fn au-fn-1">
                    <label for="">Количество работников</label>
                    <div class="label-select-block">
                        <select name="people" id="people">
                            <option selected value="<?php echo $rc['people'] ?>"><?php echo $rc['people'] ?></option>
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
                        <input type="number" id="middle" name="middle" value="<?php echo $rc['middle'] ?>" placeholder="">
                        <span class="lb-in">руб.</span>
                    </div>
                </div>
            </div>


            <div style="margin:0" class="label-block">
                <label for="">Web-site</label>
                <input type="text" id="website" name="website" value="<?php echo $rc['website'] ?>" placeholder="">
            </div>
            <div class="pf-bth" style="margin: 30px 0 0 0;">
                <button class="bth save-company" type="button" name="">Сохранить</button>
            </div>
        </form>

    </div>



    <?php
} else {
    $app->notFound();
}
?>
