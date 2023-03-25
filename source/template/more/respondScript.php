
<script>

    function getRandomInt(max) {
        return Math.floor(Math.random() * max);
    }

    function MessageBox(text) {
        let id = getRandomInt(100);
        $('.errors-block-fix').html(`
                            <div class="alert-block alert-${id}">
                                <div>
                                    <span>${text}</span>
                                    </br />
                                </div>
                                <span class="exp-ed"><i class="mdi mdi-close"></i></span>
                            </div>
                            `)
        $('.errors-block-fix > div').css('display', 'flex')
        setTimeout (() => {
            $(`.alert-${id}`).remove();
        }, 3000)
    }

    function respondArch(id, type) {
        $('#auth .error').fadeOut(50)
        $('#auth textarea').removeClass('errors')
        $('#auth select').removeClass('errors')
        $('#auth input').removeClass('errors')
        $('.lock-yes').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
        $('.lock-yes').attr('disabled', 'true')
        $.ajax({
            url: '/scripts/respond-js',
            data: `id=${id}&MODULE_ARCH=1`,
            type: 'POST',
            cache: false,
            dataType: 'json',
            error: (response) => {MessageBox('Произошла ошибка. Повторите')},
            success: function (responce) {
                if (responce.code === 'success') {
                    if (type === 4) {
                        deleteForm()
                        $('.lock-yes').removeAttr('disabled')
                        $('.lock-yes').html('Изменить статус')
                        $(`.respond-item-${id}`).fadeOut(500)
                        $('.r-accept').html(`

                        <i class="mdi mdi-hand-wave-outline"></i>
                        Принят на работу (${responce.count})`)
                        $('.respond-list > span').html(`${responce.count} откликов`)
                        MessageBox('Отклик теперь в архиве')
                    } else if (type === 5) {
                        deleteForm()
                        $('.lock-yes').removeAttr('disabled')
                        $('.lock-yes').html('Изменить статус')
                        $(`.respond-item-${id}`).fadeOut(500)
                        $('.r-none').html(`Отказ (${responce.count})`)
                        $('.respond-list > span').html(`${responce.count} откликов`)
                    }
                } else {
                    MessageBox('Произошла ошибка. Повторите')
                }
            }
        })
    }

    function respondTalk(id, user, type) {
        $('#auth .error').fadeOut(50)
        $('#auth select').removeClass('errors')
        $('#auth textarea').removeClass('errors')
        $('#auth input').removeClass('errors')
        $('.lock-yes').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
        $('.lock-yes').attr('disabled', 'true')
        $.ajax({
            url: '/scripts/respond-js',
            data: `id=${id}&type=${type}&user=${user}&MODULE_TALK=1&${$('.form-respond').serialize()}`,
            type: 'POST',
            cache: false,
            dataType: 'json',
            error: (response) => MessageBox('Произошла ошибка. Повторите'),
            success: function (responce) {
                if (responce.code === 'success') {
                    deleteForm()
                    $('.lock-yes').html('Изменить статус')
                    $(`.respond-item-${id}`).fadeOut(500)
                    $('.r-talk').html(`
                    <i class="mdi mdi-phone-in-talk-outline"></i>
                    Разговор по телефону (${responce.count})`)
                    $('.r-new').html(`
                    <i class="mdi mdi-alert-decagram-outline"></i>
                    Неразорабранные (${responce.countOut})`)
                    $('.respond-list > span').html(`${responce.countOut} откликов`)
                } else {
                    $('.lock-yes').html('Изменить статус')
                    $('.lock-yes').removeAttr('disabled')
                    if (responce.code === 'validate_error') {
                        let $r = responce.array;
                        if ($r['day']) {
                            $('.day').addClass('errors')
                            $('.e-day').show()
                        }
                        if ($r['text']) {
                            $('.text').addClass('errors')
                            $('.e-text').show()
                        }
                        if ($r['time']) {
                            $('.time').addClass('errors')
                            $('.e-time').show()
                        }
                    } else {
                        MessageBox('Произошла ошибка. Повторите')
                    }
                }
            }
        })
    }

    function respondMeeting(id, user, type) {
        $('#auth .error').fadeOut(50)
        $('#auth select').removeClass('errors')
        $('#auth input').removeClass('errors')
        $('#auth textarea').removeClass('errors')
        $('.lock-yes').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
        $('.lock-yes').attr('disabled', 'true')
        $.ajax({
            url: '/scripts/respond-js',
            data: `id=${id}&type=${type}&user=${user}&MODULE_MEETING=1&${$('.form-respond').serialize()}`,
            type: 'POST',
            cache: false,
            dataType: 'json',
            error: (response) => MessageBox('Произошла ошибка. Повторите'),
            success: function (responce) {
                if (responce.code === 'success') {
                    deleteForm()
                    $('.lock-yes').html('Изменить статус')
                    $(`.respond-item-${id}`).fadeOut(500)
                    $('.r-meeting').html(`
                    <i class="mdi mdi-head-question-outline"></i>
                    Собеседование (${responce.count})`)
                    $('.r-talk ').html(`
                     <i class="mdi mdi-phone-in-talk-outline"></i>
                    Разговор по телефону (${responce.countOut})`)
                    $('.respond-list > span').html(`${responce.countOut} откликов`)
                } else {
                    if (responce.code === 'validate_error') {
                        $('.lock-yes').html('Изменить статус')
                        $('.lock-yes').removeAttr('disabled')
                        let $r = responce.array;
                        if ($r['day']) {
                            $('.day').addClass('errors')
                            $('.e-day').show()
                        }
                        if ($r['text']) {
                            $('.text').addClass('errors')
                            $('.e-text').show()
                        }
                        if ($r['time']) {
                            $('.time').addClass('errors')
                            $('.e-time').show()
                        }
                        if ($r['address']) {
                            $('.address').addClass('errors')
                            $('.e-address').show()
                        }
                    } else {
                        MessageBox('Произошла ошибка. Повторите')
                    }
                }
            }
        })
    }

    function respondAccept(id, user, type) {
        $('#auth .error').fadeOut(50)
        $('#auth select').removeClass('errors')
        $('#auth input').removeClass('errors')
        $('#auth textarea').removeClass('errors')
        $('.lock-yes').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
        $('.lock-yes').attr('disabled', 'true')
        $.ajax({
            url: '/scripts/respond-js',
            data: `id=${id}&type=${type}&user=${user}&MODULE_ACCEPT=1&${$('.form-respond').serialize()}`,
            type: 'POST',
            cache: false,
            dataType: 'json',
            error: (response) => MessageBox('Произошла ошибка. Повторите'),
            success: function (responce) {
                if (responce.code === 'success') {
                    deleteForm()
                    $('.lock-yes').html('Изменить статус')
                    $(`.respond-item-${id}`).fadeOut(500)
                    $('.r-accept').html(`
                    <i class="mdi mdi-hand-wave-outline"></i>
                    Принят на работу (${responce.count})`)
                    $('.r-meeting ').html(`
                      <i class="mdi mdi-head-question-outline"></i>
                    Собеседование (${responce.countOut})`)
                    $('.respond-list > span').html(`${responce.countOut} откликов`)
                } else {
                    if (responce.code === 'validate_error') {
                        $('.lock-yes').removeAttr('disabled')
                        $('.lock-yes').html('Изменить статус')
                        let $r = responce.array;
                        if ($r['text']) {
                            $('.text').addClass('errors')
                            $('.e-text').show()
                        }
                    } else {
                        MessageBox('Произошла ошибка. Повторите')
                    }
                }
            }
        })
    }

    function respondRefuse(id, user, type) {
        $('#auth .error').fadeOut(50)
        $('#auth select').removeClass('errors')
        $('#auth input').removeClass('errors')
        $('#auth textarea').removeClass('errors')
        $('.lock-yes').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
        $('.lock-yes').attr('disabled', 'true')
        $.ajax({
            url: '/scripts/respond-js',
            data: `id=${id}&type=${type}&user=${user}&MODULE_REFUSE=1&${$('.form-respond').serialize()}`,
            type: 'POST',
            cache: false,
            dataType: 'json',
            error: (response) => MessageBox('Произошла ошибка. Повторите'),
            success: function (responce) {
                if (responce.code === 'success') {
                    deleteForm()
                    $('.lock-yes').html('Изменить статус')
                    $(`.respond-item-${id}`).fadeOut(500)
                    $('.r-none').html(`
                    <i class="mdi mdi-delete-variant"></i>
                    Отказ (${responce.count})`)
                    $('.respond-list > span').html(`${responce.countOut} откликов`)
                } else {
                    if (responce.code === 'validate_error') {
                        $('.lock-yes').removeAttr('disabled')
                        $('.lock-yes').html('Изменить статус')
                        let $r = responce.array;
                        if ($r['text']) {
                            $('.text').addClass('errors')
                            $('.e-text').show()
                        }
                    } else {
                        MessageBox('Произошла ошибка. Повторите')
                    }
                }
            }
        })
    }

    function respondThink(id) {
        $('.lock-yes').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
        $('.lock-yes').attr('disabled', 'true')
        $.ajax({
            url: '/scripts/respond-js',
            data: `id=${id}&MODULE_THINK=1`,
            type: 'POST',
            cache: false,
            dataType: 'json',
            error: (response) => MessageBox('Произошла ошибка. Повторите'),
            success: function (responce) {
                if (responce.code === 'validate_error') {
                    console.log(responce)
                    $('.lock-yes').html('Изменить статус')
                    $('.lock-yes').removeAttr('disabled')
                } else if (responce.code === 'success') {
                    deleteForm()
                    $('.lock-yes').html('Изменить статус')
                    $(`.respond-item-${id}`).fadeOut(500)
                    $('.r-think').html(`Подумать (${responce.count})`)
                    $('.r-new').html(`Неразобранные (${responce.countOut})`)
                    $('.respond-list > span').html(`${responce.countOut} откликов`)
                } else {
                    MessageBox('Произошла ошибка. Повторите')
                }
            }
        })
    }

    function createRefuse(id, name, job, name, firstname, type, user) {
        document.querySelector('.profile-body').innerHTML += `
                        <div id="auth" style="display:flex">
                    <div class="contact-wrapper" style="display:block">
                        <div class="resp-pop-container auth-log">
                            <div class="auth-title">
                                Изменить статус
                                <i class="mdi mdi-close form-detete" onclick="deleteForm()"></i>
                            </div>
                            <div class="auth-form">
                                <form class="form-respond" role="form" method="post">
                                <div style="margin: 0 0 10px 0;" class="label-b-check">
                                    <input onclick="
let c = document.querySelector('#q2')
                if (c.checked) {
                    $('.text').removeAttr('disabled')
                } else {
                    $('.text').val('')
                    $('.text').attr('disabled', 'true')
                    $('.form-respond input, .form-respond textarea').removeClass('errors')
                    $('span.error').hide()
                }
" checked type="checkbox" class="custom-checkbox" id="q2" name="notext" value="1">
                                    <label for="q2">
                                        отправить сообщение
                                    </label>
                                </div>
                                    <div class="label-block">
                                        <label for="">Сообщение <span>*<span></label>
                                        <textarea name="text" class="text" id="text" cols="30" rows="10" style="height:165px;">
Здравствуйте, ${firstname}!
Спасибо за интерес, проявленный к вакансии "${job}". К сожалению, в настоящий момент мы не готовы пригласить Вас на дальнейшее интервью по этой вакансии. Мы внимательно ознакомились с Вашим резюме и, возможно, вернёмся к Вашей кандидатуре, когда у нас возникнет такая потребность.</textarea>
                                        <span class="error e-text" style="display: none">Введите сообщение</span>
                                    </div>
                                </form>
                                <span><i class="icon-briefcase"></i> ${job}</span>
                                 <span><i class="icon-user"></i> ${name}</span>
                                <form method="post">
                                    <div class="pop-flex-bth">
                                        <button class="more-inf" type="button" onclick="deleteForm()">Отмена</button>
                                        <button onclick="respondRefuse(${id}, ${user}, ${type})" type="button" class="lock-yes">Изменить статус</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `
    }

    function createAccept(id, name, job, name, firstname, type, user) {
        document.querySelector('.profile-body').innerHTML += `
                        <div id="auth" style="display:flex">
                    <div class="contact-wrapper" style="display:block">
                        <div class="resp-pop-container auth-log">
                            <div class="auth-title">
                                Изменить статус
                                <i class="mdi mdi-close form-detete" onclick="deleteForm()"></i>
                            </div>
                            <div class="auth-form">
                                <form class="form-respond" role="form" method="post">
                                <div style="margin: 0 0 10px 0;" class="label-b-check">
                                    <input onclick="
let c = document.querySelector('#q2')
                if (c.checked) {
                    $('.text').removeAttr('disabled')
                    $('.day').removeAttr('disabled')
                    $('.time').removeAttr('disabled')
                    $('.address').removeAttr('disabled')
                } else {
                    $('.text').val('')
                    $('.day').val('')
                    $('.time').val('')
                    $('.address').val('')
                    $('.text').attr('disabled', 'true')
                    $('.day').attr('disabled', 'true')
                    $('.address').attr('disabled', 'true')
                    $('.form-respond input, .form-respond textarea').removeClass('errors')
                    $('span.error').hide()
                    $('.time').attr('disabled', 'true')
                }
" checked type="checkbox" class="custom-checkbox" id="q2" name="notext" value="1">
                                    <label for="q2">
                                        отправить сообщение
                                    </label>
                                </div>
                                    <div class="label-block">
                                        <label for="">Сообщение <span>*<span></label>
                                        <textarea name="text" class="text" id="text" cols="30" rows="10" style="height:100px;">
Здравствуйте, firstname!
Мы бы хотели принять Вас на работу. Если Вам будет не удобно в это время, пожалуйста, сообщите нам.
                                        </textarea>
                                        <span class="error e-text" style="display: none">Введите сообщение</span>
                                    </div>
 <span style="color: #1d1d1d;
display: flex;
align-items: center;
margin: 0 0 16px 0;
font-size: 15px;
font-weight: 400;">Вы можете указать дату и время выхода на работу</span>
                                    <div class="flex f-n">

                                <div class="label-block au-fn au-fn-1">
                                    <label for="">День</label>
                                    <input type="text" class="day" id="day" name="day" value="" placeholder="Например, 24 августа">
                                    <span class="error e-day" style="display: none">Введите день</span>
                                </div>
                                <div class="label-block au-fn">
                                    <label for="">Время</label>
                                    <input  type="time" class="time" id="time" name="time" value="" placeholder="Например, 16:00">
                                    <span class="error e-time" style="display: none">Укажите время</span>
                                </div>
                            </div>
                                <div class="label-block">
                                    <label for="">Адрес</label>
                                    <input type="text" class="address" id="address" name="address" value="" placeholder="Например, г. Ставрополь, ул. Ленина 224, 5 этаж и т.д.">
                                    <span class="error e-address" style="display: none">Введите адрес</span>
                                </div>
                                </form>
                                <span><i class="icon-briefcase"></i> ${job}</span>
                                 <span><i class="icon-user"></i> ${name}</span>
                                <form method="post">
                                    <div class="pop-flex-bth">
                                        <button class="more-inf" type="button" onclick="deleteForm()">Отмена</button>
                                        <button onclick="respondAccept(${id}, ${user}, ${type})" type="button" class="lock-yes">Изменить статус</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `
    }

    function createMeeting(id, name, job, name, firstname, type, user) {
        document.querySelector('.profile-body').innerHTML += `
                        <div id="auth" style="display:flex">
                    <div class="contact-wrapper" style="display:block">
                        <div class="resp-pop-container auth-log">
                            <div class="auth-title">
                                Изменить статус
                                <i class="mdi mdi-close form-detete" onclick="deleteForm()"></i>
                            </div>
                            <div class="auth-form">
                                <form class="form-respond" role="form" method="post">
                                <div style="margin: 0 0 10px 0;" class="label-b-check">
                                    <input onclick="
let c = document.querySelector('#q2')
                if (c.checked) {
                    $('.text').removeAttr('disabled')
                    $('.day').removeAttr('disabled')
                    $('.time').removeAttr('disabled')
                    $('.address').removeAttr('disabled')
                } else {
                    $('.text').val('')
                    $('.day').val('')
                    $('.time').val('')
                    $('.address').val('')
                    $('.text').attr('disabled', 'true')
                    $('.day').attr('disabled', 'true')
                    $('.address').attr('disabled', 'true')
                    $('.form-respond input, .form-respond textarea').removeClass('errors')
                    $('span.error').hide()
                    $('.time').attr('disabled', 'true')
                }
" checked type="checkbox" class="custom-checkbox" id="q2" name="notext" value="1">
                                    <label for="q2">
                                        отправить сообщение
                                    </label>
                                </div>
                                    <div class="label-block">
                                        <label for="">Сообщение <span>*<span></label>
                                        <textarea name="text" class="text" id="text" cols="30" rows="10" style="height:100px;">
Здравствуйте, ${firstname}!
Мы бы хотели назначить личную встречу с Вами. Если Вам будет не удобно в это время, пожалуйста, сообщите нам.
                                        </textarea>
                                        <span class="error e-text" style="display: none">Введите сообщение</span>
                                    </div>
                                    <div class="flex f-n">
                                <div class="label-block au-fn au-fn-1">
                                    <label for="">День <span>*<span></label>
                                    <input type="text" class="day" id="day" name="day" value="" placeholder="Например, 24 августа">
                                    <span class="error e-day" style="display: none">Введите день</span>
                                </div>
                                <div class="label-block au-fn">
                                    <label for="">Время <span>*<span></label>
                                    <input  type="time" class="time" id="time" name="time" value="" placeholder="Например, 16:00">
                                    <span class="error e-time" style="display: none">Укажите время</span>
                                </div>
                            </div>
                                <div class="label-block">
                                    <label for="">Адрес <span>*<span></label>
                                    <input type="text" class="address" id="address" name="address" value="" placeholder="Например, г. Ставрополь, ул. Ленина 224, 5 этаж и т.д.">
                                    <span class="error e-address" style="display: none">Введите адрес</span>
                                </div>
                                </form>
                                <span><i class="icon-briefcase"></i> ${job}</span>
                                 <span><i class="icon-user"></i> ${name}</span>
                                <form method="post">
                                    <div class="pop-flex-bth">
                                        <button class="more-inf" type="button" onclick="deleteForm()">Отмена</button>
                                        <button onclick="respondMeeting(${id}, ${user}, ${type})" type="button" class="lock-yes">Изменить статус</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `
    }

    function createTalk(id, name, job, name, firstname, type, user) {
        document.querySelector('.profile-body').innerHTML += `
                        <div id="auth" style="display:flex">
                    <div class="contact-wrapper" style="display:block">
                        <div class="resp-pop-container auth-log">
                            <div class="auth-title">
                                Изменить статус
                                <i class="mdi mdi-close form-detete" onclick="deleteForm()"></i>
                            </div>
                            <div class="auth-form">
                                <form class="form-respond" role="form" method="post">
                                <div style="margin: 0 0 10px 0;" class="label-b-check">
                                    <input onclick="
let c = document.querySelector('#q2')
                if (c.checked) {
                    $('.text').removeAttr('disabled')
                    $('.day').removeAttr('disabled')
                    $('.time').removeAttr('disabled')
                } else {
                    $('.text').val('')
                    $('.day').val('')
                    $('.time').val('')
                    $('.text').attr('disabled', 'true')
                    $('.day').attr('disabled', 'true')
                    $('.form-respond input, .form-respond textarea').removeClass('errors')
                    $('span.error').hide()
                    $('.time').attr('disabled', 'true')
                }
" checked type="checkbox" class="custom-checkbox" id="q2" name="notext" value="1">
                                    <label for="q2">
                                        отправить сообщение и указать время звонка
                                    </label>
                                </div>
                                    <div class="label-block">
                                        <label for="">Сообщение <span>*<span></label>
                                        <textarea name="text" class="text" id="text" cols="30" rows="10" style="height:140px;">
Здравствуйте, ${firstname}!
Спасибо за интерес, проявленный к вакансии "${job}". Ваше резюме показалось нам очень интересным. Мы бы хотели провести с Вами беседу по телефону. Если Вам будет не удобно в это время, пожалуйста, сообщите нам.</textarea>
                                        <span class="error e-text" style="display: none">Введите сообщение</span>
                                    </div>
                                    <div class="flex f-n">
                                <div class="label-block au-fn au-fn-1">
                                    <label for="">День <span>*<span></label>
                                    <input type="text" class="day" id="day" name="day" value="" placeholder="Например, 24 августа">
                                    <span class="error e-day" style="display: none">Введите день</span>
                                </div>
                                <div class="label-block au-fn">
                                    <label for="">Время <span>*<span></label>
                                    <input  type="time" class="time" id="time" name="time" value="" placeholder="Например, 16:00">
                                    <span class="error e-time" style="display: none">Укажите время</span>
                                </div>
                            </div>
                                </form>
                                <span><i class="icon-briefcase"></i> ${job}</span>
                                 <span><i class="icon-user"></i> ${name}</span>
                                <form method="post">
                                    <div class="pop-flex-bth">
                                        <button class="more-inf" type="button" onclick="deleteForm()">Отмена</button>
                                        <button onclick="respondTalk(${id}, ${user}, ${type})" type="button" class="lock-yes">Изменить статус</button>
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