'use strict';

(function ($) {


        function _getData() {

                $.ajax({
                        url: '/scripts/feedback-js',
                        data: `act=1&${$('.feedback-form').serialize()}`,
                        type: 'POST',
                        cache: false,
                        dataType: 'json',
                        error: (response) => console.log(response),
                        success: function (responce) {
                                if (responce.code === 'success') {
                                        $('.message-block').append(`<span class="lock-site"><i class="icon-check"></i> Больше спасибо за отклик! Ваше сообщение успешно доставлено администратору.</span>`)
                                        $('.feedback-form')[0].reset()
                                        $('.e-text').hide()
                                        $('.e-captcha').hide()
                                        $('.text').removeClass('errors')
                                        $('.captcha').removeClass('errors')
                                        $('.bth-feedback').html('Отправить')
                                        $('.bth-feedback').removeAttr('disabled')
                                } else {
                                        if (responce.code === 'validate_error') {
                                                let $r = responce.array;
                                                if ($r['text']) {
                                                        $('.text').addClass('errors')
                                                        $('.e-text').text($r['text']);
                                                        $('.e-text').fadeIn(50)
                                                }
                                                if ($r['captcha']) {
                                                        $('.captcha').addClass('errors')
                                                        $('.e-captcha').text($r['captcha']);
                                                        $('.e-captcha').fadeIn(50)
                                                }
                                                $('.bth-feedback').html('Отправить')
                                                $('.bth-feedback').removeAttr('disabled')
                                        } else {
                                                console.log(responce)
                                                $('.bth-feedback').html('Отправить')
                                                $('.bth-feedback').removeAttr('disabled')
                                        }
                                }
                        }})
        }

        $(document).on('click', '.bth-feedback', function (e) {
                e.preventDefault()
                $('.error').fadeOut(50)
                $(this).html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
                $(this).attr('disabled', 'true')
                $('select').removeClass('errors')
                $('textarea').removeClass('errors')
                $('input').removeClass('errors')
                $('.label-block .select2-container--default .select2-selection--single').css('border', '1px solid #cdd0d5')
                _getData()
        })

})(jQuery);