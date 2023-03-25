<div class="pr-pass-block block-p bl-2">
    <span>Сменить пароль</span>
    <form method="post" id="form" class="form-password" role="form">
        <div class="label-block">
            <label for="">Действующий пароль <span>*</span></label>

            <div class="label-password-2">
                <input <? if (isset($err['password'])) { ?> class="errors" <? } ?>  type="password" id="password" name="password" placeholder="" value="<? echo $_POST['password']; ?>">
                <i class="mdi mdi-eye-outline eye-password in-pass"></i>
            </div>


            <? if (isset($err['password'])) { ?> <span class="error"><? echo $err['password']; ?></span> <? } ?>
            <span class="empty e-password"></span>
        </div>
        <div class="label-block">
            <label for="">Новый пароль <span>*</span></label>
            <div class="label-password-2">
                <input <? if (isset($err['new_password'])) { ?> class="errors" <? } ?> type="password" id="new_password" name="new_password" placeholder="Пароль должен быть не меньше 8 символов" value="<? echo $_POST['new_password']; ?>">
                <i class="mdi mdi-eye-outline eye-password in-pass"></i>
            </div>
            <? if (isset($err['new_password'])) { ?> <span class="error"><? echo $err['new_password']; ?></span> <? } ?>
            <span class="empty e-new_password"></span>
        </div>
        <div class="label-block">
            <label for="">Повторите новый пароль <span>*</span></label>
            <div class="label-password-2">
                <input <? if (isset($err['lost_password'])) { ?> class="errors" <? } ?> type="password" id="lost_password" name="lost_password" placeholder="" value="<? echo $_POST['lost_password']; ?>">
                <i class="mdi mdi-eye-outline eye-password in-pass"></i>
            </div>
            <? if (isset($err['lost_password'])) { ?> <span class="error"><? echo $err['lost_password']; ?></span> <? } ?>
            <span class="empty e-lost_password"></span>
        </div>
        <div class="captcha" style="margin-bottom: 35px;">
            <div class="captcha__image-reload">
                <img class="captcha__image" src="/scripts/captcha" width="132" alt="captcha">
                <button type="button" class="captcha__refresh"><i class="mdi mdi-refresh"></i></button>
            </div>
            <div class="captcha__group">
                <label for="captcha">Код, изображенный на картинке <span>*</span></label>
                <input <? if (isset($err['captcha'])) { ?> class="errors" <? } ?> type="text" name="captcha" id="captcha">
                <? if (isset($err['captcha'])) { ?> <span class="error"><? echo $err['captcha']; ?></span> <? } ?>
                <span class="empty e-captcha"></span>
            </div>
        </div>
        <div class="pf-bth">
            <button class="bth save-pass" type="button">Изменить</button>
        </div>
    </form>

</div>