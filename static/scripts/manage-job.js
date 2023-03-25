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

    function replaceQueryParam(param, newval, search) {
        let regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?"),
            query = search.replace(regex, "$1").replace(/&$/, '');

        return (query.length > 2 ? query + "&" : "?") + (newval ? param + "=" + newval : '');
    }


    function updateURL(page) {

        if (history.pushState) {

            if ($_GET['page']) {
                let baseUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                let str = window.location.search
                str = replaceQueryParam('page', page, str)
                let newUrl = baseUrl + str;
                history.pushState(null, null, newUrl);
            } else {
                if ($_GET['loc'] || $_GET['key']) {

                    let baseUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + window.location.search,
                        newUrl = baseUrl + `&page=${page}`;
                    history.pushState(null, null, newUrl);
                } else {
                    let baseUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + window.location.search,
                        newUrl = baseUrl + `?page=${page}`;
                    history.pushState(null, null, newUrl);
                }
            }
        } else {
            console.warn('History API не поддерживается');
        }

    }


    let $form = $('.form-job'),
        $expInput = $('.filter-exp input'),
        $timeInput = $('.filter-time input'),
        $typeInput = $('.filter-type input'),
        $keyInput = $('#title'),
        $locInput = $('#loc'),
        $sort = $('#sort_job'),
        $pag = $('.paginator')


    let limit = 10;

    function _bindHandlers() {
        $pag.on('click', 'a', _changePage);
        $expInput.on('change', _getData);
        $timeInput.on('change', _getData);
        $typeInput.on('change', _getData);
        $sort.on('change', _getData);
    }

    function _catalogError(responce) {
        console.log(responce)
        $('.manage-title').html(responce.data.countText)
        $('.man-job').html('<span class="wow fadeIn vac-error">Возникла непредвиденная ошибка</span>');
    }

    function _catalogSuccess(responce) {
        $('.manage-title').html(responce.data.countText)
        $('.man-job').html(responce.data.list);
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


    function _getData(page = 1) {
        $('.man-job').html(`
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
        let data = `sort=${$sort.val()}&page=${+page}&limit=${+limit}&key=${$keyInput.val()}&loc=${$locInput.val()}&${$form.serialize()}`
        setTimeout(function () {
            $.ajax({
                url: '/scripts/profile-js',
                data: `${data}&MODULE_MANAGE_JOB=1`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: _catalogError,
                success: function (responce) {
                    if (responce.code === 'success') {
                        $('.manage-search-block button').removeAttr('disabled')
                        $('select').removeAttr('disabled')
                        $('.filter-load').fadeOut(10)
                        $('.man-job').html('')
                        _catalogSuccess(responce);
                        _renderPagination({
                            pagination: responce.data.pagination
                        });

                    } else {
                        _catalogError(responce)
                    }
                }})
        }, 1000)

    }

    function init () {
        _getData(1)
        _bindHandlers()
    }

    $(document).on('click', '.manage-search-block button', function () {
        _getData()
    })


    init();
})(jQuery);