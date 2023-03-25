'use strict';

(function ($) {

    $(document).ready(function () {

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

        $(document).on('click', '.save-push', function (e) {
            e.preventDefault();
            $('.save-push').attr('disabled', 'true')
            $('.save-push').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
            $.ajax({
                url: '/scripts/profile-js',
                data: `${$('.form-password').serialize()}&MODULE_SETTING_MAIL=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => {
                    MessageBox('Произошла ошибка. Повторите')
                    $('.save-push').removeAttr('disabled')
                    $('.save-push').html('Сохранить')
                },
                success: function (responce) {
                    if (responce.code === 'success') {
                        MessageBox('Изменения внесены')
                        $('.save-push').removeAttr('disabled')
                        $('.save-push').html('Сохранить')
                    } else {
                        MessageBox('Произошла ошибка. Повторите')
                        $('.save-push').removeAttr('disabled')
                        $('.save-push').html('Сохранить')
                    }
                }});

        })

        $(document).on('click', '.save-pass', function (e) {
            e.preventDefault();
            $('.save-pass').attr('disabled', 'true')
            $('.save-pass').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
            $('.empty').fadeOut(50)
            $('select').removeClass('errors')
            $('input').removeClass('errors')
            $('.label-block .select2-container--default .select2-selection--single').css('border', '1px solid #cdd0d5')

            setTimeout(function () {
                $.ajax({
                    url: '/scripts/profile-js',
                    data: `${$('.form-password').serialize()}&MODULE_SAVE_PASS=1`,
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    error: (response) => {
                        MessageBox('Произошла ошибка. Повторите')
                    },
                    success: function (responce) {
                        if (responce.code === 'validate_error') {
                            let $arr = responce.error
                            for (let i in $arr) {
                                $(`#${i}`).addClass('errors');
                                $(`#${i}`).text($arr[i]);
                                $(`.e-${i}`).fadeIn(50)
                                $(`.e-${i}`).text($arr[i]);
                            }
                            $('.save-pass').removeAttr('disabled')
                            $('.save-pass').html('Изменить')
                        } else {
                            if (responce.code === 'success') {
                                $('.save-pass').removeAttr('disabled')
                                $('.save-pass').html('Изменить')
                                MessageBox('Пароль изменен')
                                $('.form-password')[0].reset()
                            } else {
                                MessageBox('Произошла ошибка. Повторите')
                                $('.form-password')[0].reset()
                                $('.save-pass').removeAttr('disabled')
                                $('.save-pass').html('Изменить')
                            }
                        }
                    }});
            }, 500)


        })

        $(document).on('click', '.save-resume', function (e) {
            e.preventDefault();
            $('.save-resume').attr('disabled', 'true')
            $('.save-resume').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
            $('.empty').fadeOut(50)
            $('select').removeClass('errors')
            $('input').removeClass('errors')
            $('textarea').removeClass('errors')
            $('.label-block .select2-container--default .select2-selection--single').css({
                'border': '1px solid #cdd0d5',
                'background': '#ffffff'
            })

            setTimeout(function () {
                $.ajax({
                    url: '/scripts/profile-js',
                    data: `${$('.form-profile').serialize()}&MODULE_SAVE=1`,
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    error: (response) => {
                        MessageBox('Произошла ошибка. Повторите')
                        console.log(response)
                    },
                    success: function (responce) {
                        if (responce.code === 'validate_error') {
                            let $arr = responce.error
                            for (let i in $arr) {
                                if (i === 'faculty') $('span[aria-controls="select2-faculty-container"]').css({
                                    'border': '1px solid #ff4c4c',
                                    'background': 'rgba(255,22,46,.06)'
                                })
                                if (i === 'direction') $('span[aria-controls="select2-direction-container"]').css({
                                    'border': '1px solid #ff4c4c',
                                    'background': 'rgba(255,22,46,.06)'
                                })
                                if (i === 'degree') $('span[aria-controls="select2-degree-container"]').css({
                                    'border': '1px solid #ff4c4c',
                                    'background': 'rgba(255,22,46,.06)'
                                })
                                $(`#${i}`).addClass('errors');
                                $(`.e-${i}`).fadeIn(50)
                            }
                            $('.save-resume').removeAttr('disabled')
                            $('.save-resume').html('Отправить')
                            MessageBox('Ошибка валидации')
                        } else {
                            if (responce.code === 'success') {
                                $('.save-resume').removeAttr('disabled')
                                $('.save-resume').html('Сохранить')
                                MessageBox('Изменения внесены')
                            } else {
                                MessageBox('Произошла ошибка. Повторите')
                                console.log(responce)
                            }
                        }
                    }});
            }, 500)


        })

        $(document).on('click', '.save-resume-education', function (e) {
            e.preventDefault();
            $('.save-resume-education').attr('disabled', 'true')
            $('.save-resume-education').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
            $('.empty').fadeOut(50)
            $('select').removeClass('errors')
            $('input').removeClass('errors')
            $('textarea').removeClass('errors')
            $('.label-block .select2-container--default .select2-selection--single').css({
                'border': '1px solid #cdd0d5',
                'background': '#ffffff'
            })

            setTimeout(function () {
                $.ajax({
                    url: '/scripts/profile-js',
                    data: `${$('.form-profile-education').serialize()}&MODULE_SAVE_EDUCATION=1`,
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    error: (response) => {
                        MessageBox('Произошла ошибка. Повторите')
                        $('.save-resume-education').removeAttr('disabled')
                        $('.save-resume-education').html('Сохранить')
                        console.log(response)
                    },
                    success: function (responce) {
                        if (responce.code === 'validate_error') {
                            let $arr = responce.error
                            for (let i in $arr) {
                                if (i === 'faculty') $('span[aria-controls="select2-faculty-container"]').css({
                                    'border': '2px solid #ff4c4c',
                                    'background': 'rgba(255,22,46,.06)'
                                })
                                if (i === 'direction') $('span[aria-controls="select2-direction-container"]').css({
                                    'border': '2px solid #ff4c4c',
                                    'background': 'rgba(255,22,46,.06)'
                                })
                                if (i === 'degree') $('span[aria-controls="select2-degree-container"]').css({
                                    'border': '2px solid #ff4c4c',
                                    'background': 'rgba(255,22,46,.06)'
                                })
                                $(`#${i}`).addClass('errors');
                                $(`.e-${i}`).fadeIn(50)
                            }
                            $('.save-resume-education').removeAttr('disabled')
                            $('.save-resume-education').html('Сохранить')
                            MessageBox('Ошибка валидации')
                        } else {
                            if (responce.code === 'success') {
                                $('.save-resume-education').removeAttr('disabled')
                                $('.save-resume-education').html('Сохранить')
                                MessageBox('Изменения внесены')
                            } else {
                                $('.save-resume-education').removeAttr('disabled')
                                $('.save-resume-education').html('Сохранить')
                                MessageBox('Произошла ошибка. Повторите')
                                console.log(responce)
                            }
                        }
                    }});
            }, 500)


        })

        $(document).on('click', '.save-company', function (e) {
            e.preventDefault();
            $('.save-company').attr('disabled', 'true')
            $('.save-company').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
            $('.empty').fadeOut(50)
            $('select').removeClass('errors')
            $('input').removeClass('errors')
            $('textarea').removeClass('errors')
            $('.label-block .select2-container--default .select2-selection--single').css({
                'border': '1px solid #cdd0d5',
                'background': '#ffffff'
            })

            setTimeout(function () {
                $.ajax({
                    url: '/scripts/profile-js',
                    data: `${$('.form-profile').serialize()}&MODULE_SAVE=1`,
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    error: (response) => {
                        MessageBox('Произошла ошибка. Повторите')
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
                            $('.save-company').removeAttr('disabled')
                            $('.save-company').html('Сохранить')
                            MessageBox('Ошибка валидации')
                        } else {
                            if (responce.code === 'success') {
                                $('.save-company').removeAttr('disabled')
                                $('.save-company').html('Отправить')
                                MessageBox('Изменения внесены')
                            } else {
                                MessageBox('Произошла ошибка. Повторите')
                            }
                        }
                    }});
            }, 500)


        })



        $(document).on('click', '.mail-go', function (e) {
            e.preventDefault();
            $('.mail-go').attr('disabled', 'true')
            $('.mail-go').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
            $('.e-email').fadeOut(50)
            $('.email-inp').removeClass('errors')
            $.ajax({
                url: '/scripts/profile-js',
                data: `mail=${$('.email-inp').val()}&MODULE_EDIT_MAIL=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => {
                    MessageBox('Произошла ошибка. Повторите')
                    $('.mail-go').removeAttr('disabled')
                    $('.mail-go').val('Отправить')
                },
                success: function (responce) {
                    if (responce.code === 'validate_error') {
                        $('.email-inp').addClass('errors');
                        $('.e-email').show()
                        $('.mail-go').removeAttr('disabled')
                        $('.mail-go').html('Отправить')
                    } else {
                        if (responce.code === 'success') {
                            $('.access-block').html('Сообщение успешно отправлено');
                            $('.email-inp').val('');
                            $('.mail-go').removeAttr('disabled')
                            $('.mail-go').html('Отправить')
                            $('.edit-mail-box .label-block').remove();
                            $('.edit-mail-box .a-bth').remove();
                            $('.edit-mail-box .label-b-info').remove();
                        } else {
                            MessageBox('Произошла ошибка. Повторите')
                            $('.mail-go').removeAttr('disabled')
                            $('.mail-go').html('Отправить')
                        }
                    }



                }});
        })

        $(document).on('click', '.add-skill', function (e) {
            e.preventDefault();
            $.ajax({
                url: '/scripts/profile-js',
                data: `text=${$('.skill').val()}&MODULE_ADD_SKILL=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => {
                    MessageBox('Произошла ошибка. Повторите')
                },
                success: function (responce) {
                    if (responce.code === 'success') {
                        $('.skill-list').prepend(responce.html);
                        $('.skill').val('');
                    } else {
                        MessageBox('Произошла ошибка. Повторите')
                    }
                }});
        });

        $(document).on('click', '.add-lang', function (e) {
            e.preventDefault();
            if ($.trim($('.lang').val()) !== '' && $.trim($('.lvl').val()) !== '') {
                $.ajax({
                    url: '/scripts/profile-js',
                    data: `lang=${$('.lang').val()}&lvl=${$('.lvl').val()}&MODULE_ADD_LANG=1`,
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    error: (response) => {
                        MessageBox('Произошла ошибка. Повторите')
                    },
                    success: function (responce) {
                        if (responce.code === 'success') {
                            $('.lang-list').prepend(responce.html);
                            $('.lang').val('');
                            $('.lvl').val('');
                        } else {
                            MessageBox('Произошла ошибка. Повторите')
                        }
                    }
                });
            }
        });

        $(document).on('click', '.dle-img button', function (e) {
            e.preventDefault();
            $(this).html('<i class="mdi mdi-reload reload-bth"></i>')
            $(this).attr('disabled', 'true')
            let id = $(this).attr('data-id'),
                file = $(this).attr('data-file')
            console.log(id)
            $.ajax({
                url: '/scripts/profile-js',
                data: `id=${id}&file=${file}&MODULE_DELETE_FILE=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => {
                    MessageBox('Произошла ошибка. Повторите')
                },
                success: function (responce) {
                    if (responce.code === 'success') {
                        $(`div[data-id="${id}"]`).remove()
                    } else {
                        $(`div[data-id="${id}"]`).remove()
                        MessageBox('Произошла ошибка. Повторите')
                    }
                }});
        })

    });

})(jQuery);