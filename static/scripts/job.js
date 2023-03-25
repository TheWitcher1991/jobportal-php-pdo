'use strict';

(function ($) {

    let $_GET = window
        .location
        .search
        .replace('?','')
        .split('&')
        .reduce(
            function(p,e){
                let a = e.split('=');
                p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
                return p;
            },
            {}
        );

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

    function _catalogError(responce) {
        MessageBox('Произошла ошибка. Повторите')
    }

    function _getData() {
        setTimeout(function () {
            $.ajax({
                url: '/scripts/job-js',
                data: `${$('.form-create-job').serialize()}&MODULE_CREATE_JOB=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => {
                    _catalogError(response)
                    $('.create-job').html('Разместить')
                    document.querySelector('.create-job').removeAttribute('disabled')
                },
                success: function (responce) {
                    if (responce.code === 'validate_error') {
                        let $arr = responce.error
                        for (let i in $arr) {
                            if (i === 'region') $('span[aria-controls="select2-region-container"]').css({
                                'border': '1px solid #ff4c4c',
                                'background': 'rgba(255,22,46,.06)'
                            })
                            if (i === 'address') $('span[aria-controls="select2-address-container"]').css({
                                'border': '1px solid #ff4c4c',
                                'background': 'rgba(255,22,46,.06)'
                            })
                            if (i === 'area') $('span[aria-controls="select2-area-container"]').css({
                                'border': '1px solid #ff4c4c',
                                'background': 'rgba(255,22,46,.06)'
                            })
                            if (i === 'text') {
                                $('.ql-container.ql-snow, .ql-toolbar.ql-snow').css('border', '1px solid #ff4c4c')
                                $('.ql-toolbar.ql-snow + .ql-container.ql-snow').css('border-top', '0')
                            }
                            $(`#${i}`).addClass('errors');
                            $(`.e-${i}`).fadeIn(50)
                        }
                        $('.create-job').html('Разместить')
                        document.querySelector('.create-job').removeAttribute('disabled')
                        MessageBox('Ошибка валидации')
                    } else {
                        if (responce.code === 'success') {
                            $('.form-create-job')[0].reset()
                            MessageBox('Публикуем...')
                            window.location.href = '/manage-job';
                        } else {
                            _catalogError(responce)
                            $('.create-job').html('Разместить')
                            document.querySelector('.create-job').removeAttribute('disabled')
                        }
                    }


                }})
        }, 500)

    }


    function _getEdit() {
        setTimeout(function () {
            $.ajax({
                url: '/scripts/job-js',
                data: `${$('.form-edit-job').serialize()}&job=${$_GET['id']}&cid=${$_GET['act']}&MODULE_EDIT_JOB=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: (response) => {
                    _catalogError(response)
                    $('.edit-job').html('Изменить')
                    document.querySelector('.edit-job').removeAttribute('disabled')
                },
                success: function (responce) {
                    if (responce.code === 'validate_error') {
                        let $arr = responce.error
                        for (let i in $arr) {
                            if (i === 'region') $('span[aria-controls="select2-region-container"]').css({
                                'border': '1px solid #ff4c4c',
                                'background': 'rgba(255,22,46,.06)'
                            })
                            if (i === 'address') $('span[aria-controls="select2-address-container"]').css({
                                'border': '1px solid #ff4c4c',
                                'background': 'rgba(255,22,46,.06)'
                            })
                            if (i === 'area') $('span[aria-controls="select2-area-container"]').css({
                                'border': '1px solid #ff4c4c',
                                'background': 'rgba(255,22,46,.06)'
                            })
                            if (i === 'text') {
                                $('.ql-container.ql-snow, .ql-toolbar.ql-snow').css('border', '1px solid #ff4c4c')
                                $('.ql-toolbar.ql-snow + .ql-container.ql-snow').css('border-top', '0')
                            }
                            $(`#${i}`).addClass('errors');
                            $(`.e-${i}`).fadeIn(50)
                        }
                        $('.edit-job').html('Изменить')
                        document.querySelector('.edit-job').removeAttribute('disabled')
                        MessageBox('Ошибка валидации')
                    } else {
                        if (responce.code === 'success') {
                            MessageBox('Изменения внесены')
                            $('.edit-job').html('Изменить')
                            document.querySelector('.edit-job').removeAttribute('disabled')
                        } else {
                            _catalogError(responce)
                            $('.edit-job').html('Изменить')
                            document.querySelector('.edit-job').removeAttribute('disabled')
                        }
                    }


                }})
        }, 500)



    }


    $('.create-job').on('click', function (e) {
        e.preventDefault()
        $('#editor-area').val(quill.root.innerHTML)
        $('.empty').fadeOut(50)
        $('select').removeClass('errors')
        $('input').removeClass('errors')
        $('.label-block .select2-container--default .select2-selection--single').css({
            'border': '1px solid #cdd0d5',
            'background': '#ffffff'
        })
        $('.create-job').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
        $('.create-job').attr('disabled', 'true')
        _getData()
    })

    $('.edit-job').on('click', function (e) {
        e.preventDefault()
        $('#editor-area').val(quill.root.innerHTML)
        $('.empty').fadeOut(50)
        $('select').removeClass('errors')
        $('input').removeClass('errors')
        $('.label-block .select2-container--default .select2-selection--single').css({
            'border': '1px solid #cdd0d5',
            'background': '#ffffff'
        })
        $('.edit-job').html(`<svg class="spinner-bth" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>`)
        $('.edit-job').attr('disabled', 'true')
        _getEdit()

    })

})(jQuery);