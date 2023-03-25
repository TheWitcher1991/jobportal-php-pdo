(function ($) {

    $(document).on('click', '.eye-password', function () {
        if ($(this).hasClass('in-pass')) {
            $(this).removeClass('mdi-eye-outline in-pass')
            $(this).addClass('mdi-eye-off-outline off-pass')
            $(this).siblings('input').attr('type', 'text')
        } else {
            $(this).removeClass('mdi-eye-off-outline off-pass')
            $(this).addClass('mdi-eye-outline in-pass')
            $(this).siblings('input').attr('type', 'password')
        }
    })

    function _catalogError(responce) {
        $('.errors-block').html(`
            <div class="alert-block wow fadeIn">
                    <div>
                        <span>Возникла ошибка. Повторите</span>
                    </div>
                    <span onclick="$(this).parent().remove()" class="exp-ed"><i class="mdi mdi-close"></i></span>
                    </div>
        `)
        console.log(responce)
    }

    function _getUser() {

        $('.label-block .select2-container--default .select2-selection--single').css({
            'border': '2px solid transparent',
            'background': 'rgb(245, 246, 248)'
        })

        let input = document.querySelectorAll('.form-create-user input, .form-create-user select')
        let err = 0;
       input.forEach(el => {

            let i = el.getAttribute('data-name')

           if (i === 'password' && el.value.length < 8) {
               $(`#${i}`).addClass('errors');
               $(`.e-${i}`).fadeIn(50)

               err += 1;
           }

            if ($.trim(el.value) === '' && i !== 'password') {

                if (i === 'direction') $('span[aria-controls="select2-direction-container"]').css({
                    'border': '2px solid #ff4c4c',
                    'background': 'rgba(255,22,46,.06)'
                })
                $(`#${i}`).addClass('errors');
                if (i === 'mail-2' || i === 'mail-3') $(`#email`).addClass('errors');
                $(`.e-${i}`).fadeIn(50)

                err += 1;
            }


        })

        if (err === 0) {
            $('.label-block .select2-container--default .select2-selection--single').css('border', '2px solid transparent')
            $('.reg-user').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
            $('.reg-user').attr('disabled', 'true')
            $.ajax({
                url: '/scripts/create-user-js',
                data: `${$('.form-create-user').serialize()}&MODULE_USER=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => {
                    _catalogError(response)
                    $('.reg-user').html('Продолжить')
                    document.querySelector('.reg-user').removeAttribute('disabled')
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
                            if (i === 'mail-2' || i === 'mail-3') $(`#email`).addClass('errors');
                            $(`.e-${i}`).fadeIn(50)
                        }
                        $('.reg-user').html('Продолжить')
                        document.querySelector('.reg-user').removeAttribute('disabled')
                    } else {
                        if (responce.code === 'success') {
                            $('.errors-block').html(`
                            <div class="alert-block wow fadeIn">
                                    <div>
                                        <span>Отлично! Немного подождите...</span>
                                    </div>
                                    <span onclick="$(this).parent().remove()" class="exp-ed"><i class="mdi mdi-close"></i></span>
                                    </div>
                        `)
                            $('.reg-user').html('Подождите...')
                            window.location.href = responce.link;
                        } else {
                            _catalogError(responce)
                            $('.reg-user').html('Продолжить')
                            document.querySelector('.reg-user').removeAttribute('disabled')
                        }
                    }
                }
            })
        }
    }

    function _getCompany() {

        $('.label-block .select2-container--default .select2-selection--single').css({
            'border': '2px solid transparent',
            'background': 'rgb(245, 246, 248)'
        })


        let input = document.querySelectorAll('.form-create-company input, .form-create-company select')
        let err = 0;
        input.forEach(el => {
            let i = el.getAttribute('data-name')

            if (i === 'password' && el.value.length < 8) {
                $(`#${i}`).addClass('errors');
                $(`.e-${i}`).fadeIn(50)

                err += 1;
            }

            if ($.trim(el.value) === '' && i !== 'password') {
                if (i === 'address') $('span[aria-controls="select2-address-container"]').css({
                    'border': '2px solid #ff4c4c',
                    'background': 'rgba(255,22,46,.06)'
                })
                $(`#${i}`).addClass('errors');
                if (i === 'mail-2' || i === 'mail-3') $(`#email`).addClass('errors');
                $(`.e-${i}`).fadeIn(100)
                console.log(i)
                err += 1;
            }
        })

        if (err === 0) {
            $('.reg-company').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
            $('.reg-company').attr('disabled', 'true')
            $.ajax({
                url: '/scripts/create-user-js',
                data: `${$('.form-create-company').serialize()}&MODULE_COMPANY=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => {
                    _catalogError(response)
                    $('.reg-company').html('Продолжить')
                    document.querySelector('.reg-company').removeAttribute('disabled')
                },
                success: function (responce) {
                    if (responce.code === 'validate_error') {
                        let $arr = responce.error
                        for (let i in $arr) {
                            if (i === 'address') $('span[aria-controls="select2-address-container"]').css({
                                'border': '2px solid #ff4c4c',
                                'background': 'rgba(255,22,46,.06)'
                            })
                            if (i === 'mail-2' || i === 'mail-3') $(`#email`).addClass('errors');
                            $(`#${i}`).addClass('errors');
                            $(`.e-${i}`).fadeIn(50)
                        }
                        $('.reg-company').html('Продолжить')
                        document.querySelector('.reg-company').removeAttribute('disabled')
                    } else {
                        if (responce.code === 'success') {
                            $('.errors-block').html(`
                            <div class="alert-block wow fadeIn">
                                    <div>
                                        <span>Отлично! Немного подождите...</span>
                                    </div>
                                    <span onclick="$(this).parent().remove()" class="exp-ed"><i class="mdi mdi-close"></i></span>
                                    </div>
                        `)
                            $('.reg-company').html('Подождите...')
                            window.location.href = responce.link;
                        } else {
                            _catalogError(responce)
                            $('.reg-company').html('Продолжить')
                            document.querySelector('.reg-company').removeAttribute('disabled')
                        }
                    }
                }
            })
        }
    }

    $('.reg-user').on('click', function (e) {
        $('.empty').fadeOut(50)
        $('input').removeClass('errors')
        $('select').removeClass('errors')
        $('.label-block .select2-container--default .select2-selection--single').css({
            'border': '2px solid #cdd0d5',
            'background': '#ffffff'
        })

        const
            size = Math.max(this.offsetWidth, this.offsetHeight),
            x = e.offsetX - size / 2,
            y = e.offsetY - size / 2,
            wave = document.createElement('span')

        wave.className = 'wave'
        wave.style.cssText = `width:${size}px;height:${size}px;top:${y}px;left:${x}px`
        this.appendChild(wave)

        setTimeout(() => wave.remove(), 500)

        _getUser()
    })

    $('.reg-company').on('click', function (e) {
        $('.empty').fadeOut(50)
        $('input').removeClass('errors')
        $('select').removeClass('errors')
        $('.label-block .select2-container--default .select2-selection--single').css({
            'border': '2px solid #cdd0d5',
            'background': '#ffffff'
        })

        const
            size = Math.max(this.offsetWidth, this.offsetHeight),
            x = e.offsetX - size / 2,
            y = e.offsetY - size / 2,
            wave = document.createElement('span')

        wave.className = 'wave'
        wave.style.cssText = `width:${size}px;height:${size}px;top:${y}px;left:${x}px`
        this.appendChild(wave)

        setTimeout(() => wave.remove(), 500)

        _getCompany()
    })




    $('.login-button').on('click', function (e) {
        const
            size = Math.max(this.offsetWidth, this.offsetHeight),
            x = e.offsetX - size / 2,
            y = e.offsetY - size / 2,
            wave = document.createElement('span')

        wave.className = 'wave'
        wave.style.cssText = `width:${size}px;height:${size}px;top:${y}px;left:${x}px`
        this.appendChild(wave)

        setTimeout(() => wave.remove(), 500)
    })





    $(document).ready(function () {

        $('.a-p > a').on('click', (e) => {
            e.preventDefault();
            $('#auth').addClass('auth-b-act');
            $('#auth .auth-wrapper').addClass('auth-c-act');
        })

        $('.form-close').on('click', (e) => {
            e.preventDefault();
            $('#auth').removeClass('auth-b-act');
            $('#auth .auth-wrapper').removeClass('auth-c-act');
            $('#auth .lost-wrapper').removeClass('auth-c-act');
        })

        $('.lost-pass-a').on('click', (e) => {
            e.preventDefault();
            $('#auth .auth-wrapper').removeClass('auth-c-act');
            $('#auth .lost-wrapper').addClass('auth-c-act');
        })

    });

})(jQuery, window, document);