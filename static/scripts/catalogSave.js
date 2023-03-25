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

    let $form = $('.form-job'),
        $pag = $('.paginator'),
        $keyInput = $('#title'),
        $locInput = $('#loc'),
        $expInput = $('.filter-exp input'),
        $timeInput = $('.filter-time input'),
        $typeInput = $('.filter-type input'),
        $companyInput = $('.filter-company input'),
        $moreInput = $('.filter-more input')


    function _bindHandlers() {
        $pag.on('click', 'a', _changePage)
        $expInput.on('change', _getData);
        $timeInput.on('change', _getData);
        $typeInput.on('change', _getData);
        $companyInput.on('change', _getData);
        $moreInput.on('change', _getData);
    }

    function _catalogError(responce) {
        console.log(responce)
        $('.bsc-list').html('<span class="wow fadeIn vac-error">Упс! Возникла непредвиденная ошибка</span>');
    }

    function _catalogSuccess(responce) {
        console.log(responce)
        $('.manage-search-block button').removeAttr('disabled')
        $('select').removeAttr('disabled')
        $('.filter-load').fadeOut(10)
        $('.manage-title').html(responce.data.count)
        $('.bsc-list').html(`${responce.data.list}`);
    }

    function _changePage(e) {
        e.preventDefault();
        e.stopPropagation();

        let $page = $(e.target).parent('div');
        $pag.find('div').removeClass('page-active');
        $page.addClass('page-active');
        _getData($page.attr('data-page'));
        $page.addClass('page-active');

        $('html, body').animate({
            scrollTop: 0
        }, 0);
    }

    function _renderPagination({ pagination }) {
        $pag.html(pagination);
    }


    function _getData(page = 1) {
        $('.bsc-list').html(`
        <div id="placeholder-main">
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder">
                                    <div style="width: 100%;">
                                        <div class="placeholder-item jx-nav"></div>
                                        <div class="placeholder-item jx-title"></div>
                                        <div class="placeholder-item jx-little" style="margin: 6px 0 14px 0;"></div>
                                        <div  style="margin: 10px 0 0 0;" class="placeholder-item mx-bigger"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle"></div>
                                        <div style="margin: 6px 0 10px 0;" class="placeholder-item mx-middle-2"></div>
                                    </div>
                                </div>
                            </div>
        
        `);
        $('select').attr('disabled', 'true')
        $('.manage-search-block button').attr('disabled', 'true');
        $('.filter-load').fadeIn(10)
        $('.manage-title').html(`<span><div class="placeholder-item jx-title"></div></span>`)
        setTimeout(function () {
            $.ajax({
                url: '/scripts/profile-js',
                data: `key=${$keyInput.val()}&loc=${$locInput.val()}&page=${+page}&${$form.serialize()}&MODULE_GET_LIST_SAVE=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: _catalogError,
                success: function (responce) {
                    if (responce.code === 'success') {
                        $('.bsc-list').html('');
                        _catalogSuccess(responce);
                        _renderPagination({
                            pagination: responce.data.pagination
                        });
                    } else {
                        _catalogError(responce);
                        console.log(responce);
                    }
                }});

        }, 500)


    }

    function init () {
        _getData(1)
        _bindHandlers()
    }

    $(document).on('click', '.manage-search-block button', function () {
        _getData(1)
    })





    init();
})(jQuery);