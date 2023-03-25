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
        $sort = $('#sort_job'),
        $sortStatus = $('#sort_status'),
        $expInput = $('.filter-exp input'),
        $timeInput = $('.filter-time input'),
        $typeInput = $('.filter-type input'),
        $companyInput = $('.filter-company input'),
        $moreInput = $('.filter-more input')


    function _bindHandlers() {
        $pag.on('click', 'a', _changePage)
        $expInput.on('change', function () {
            _getData(1, $_GET['t'] > 0 ? $_GET['t'] : 0)
        });
        $timeInput.on('change', function () {
            _getData(1, $_GET['t'] > 0 ? $_GET['t'] : 0)
        });
        $typeInput.on('change', function () {
            _getData(1, $_GET['t'] > 0 ? $_GET['t'] : 0)
        });
        $companyInput.on('change', function () {
            _getData(1, $_GET['t'] > 0 ? $_GET['t'] : 0)
        });
        $moreInput.on('change', function () {
            _getData(1, $_GET['t'] > 0 ? $_GET['t'] : 0)
        });
        $sort.on('change', function () {
            _getData(1, $_GET['t'] > 0 ? $_GET['t'] : 0)
        });
        $sortStatus.on('change', function () {
            _getData(1, $_GET['t'] > 0 ? $_GET['t'] : 0)
        });
    }

    function _catalogError(responce) {
        console.log(responce)
        $('.bsc-list').html('<span class="wow fadeIn vac-error">Ошибка. Повторите</span>');
    }

    function _catalogSuccess(responce) {
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
        _getData($page.attr('data-page'), $_GET['t'] > 0 ? $_GET['t'] : 0);
        $page.addClass('page-active');

        $('html, body').animate({
            scrollTop: 0
        }, 0);
    }

    function _renderPagination({ pagination }) {
        $pag.html(pagination);
    }


    function _getData(page = 1, type = $sortStatus.val() || 0) {
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
            if ($sortStatus.val()) {
                type = $sortStatus.val()
            }
            $.ajax({
                url: '/scripts/profile-js',
                data: `t=${type}&sort=${$sort.val()}&key=${$keyInput.val()}&loc=${$locInput.val()}&page=${+page}&${$form.serialize()}&MODULE_GET_LIST_USER=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: _catalogError,
                success: function (responce) {
                    if (responce.code === 'success') {
                        $('.bsc-list').html('');
                        _catalogSuccess(responce);
                        $('.bth-respond-open').on('click', function () {
                            restoreRespond($(this).attr('data-id'))
                        })
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

    function restoreRespond(id) {
        $.ajax({
            url: '/scripts/profile-js',
            data: `id=${id}&MODULE_RESTORE_RESPOND=1`,
            type: 'POST',
            cache: false,
            dataType: 'json'
        });
    }

    function init () {
        _getData(1, $_GET['t'] > 0 ? $_GET['t'] : 0)
        _bindHandlers()
    }

    $(document).on('click', '.manage-search-block button', function () {
        _getData(1, $_GET['t'] > 0 ? $_GET['t'] : 0)
    })





    init();
})(jQuery);