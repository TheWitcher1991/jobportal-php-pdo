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

    let $form = $('.form-resume'),
        $salaryInput = $('.filter-salary input'),
        $ageTo = $('.age-to'),
        $expInput = $('.filter-exp input'),
        $ageFrom = $('.age-from'),
        $genderInput = $('.filter-gender input'),
        $pag = $('.paginator'),
        $keyInput = $('#title'),
        $sort = $('#sort_respond'),
        $sortFaculty = $('#sort_faculty');

    function _bindHandlers() {
        $pag.on('click', 'a', _changePage);
        $salaryInput.on('change', function () {
            _getData(1, $_GET['t'] > 0 ? $_GET['t'] : 0)
        });
        $expInput.on('change', function () {
            _getData(1, $_GET['t'] > 0 ? $_GET['t'] : 0)
        });
        $genderInput.on('change', function () {
            _getData(1, $_GET['t'] > 0 ? $_GET['t'] : 0)
        });
        $sortFaculty.on('change', function () {
            _getData(1, $_GET['t'] > 0 ? $_GET['t'] : 0)
        });
        $ageTo.on('change', function () {
            _getData(1, $_GET['t'] > 0 ? $_GET['t'] : 0)
        });
        $ageFrom.on('change', function () {
            _getData(1, $_GET['t'] > 0 ? $_GET['t'] : 0)
        });
        $sort.on('change', function () {
            _getData(1, $_GET['t'] > 0 ? $_GET['t'] : 0)
        });
    }

    function _catalogError(responce) {

        $('.bsc-list').html('<span class="wow fadeIn vac-error">Упс! Возникла непредвиденная ошибка</span>');
    }

    function _catalogSuccess(responce) {
        $('.manage-title').html(responce.data.count)
        $('.bsc-list').html(`${responce.data.list}`);
        $('.manage-search-block button').removeAttr('disabled')
        $('select').removeAttr('disabled')
        $('.filter-load').fadeOut(10)
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


    function _getData(page = 1, type = 0) {
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
                url: '/scripts/respond-js',
                data: `id=${$_GET['id']}&faculty=${$sortFaculty.val()}&sort=${$sort.val()}&key=${$keyInput.val()}&t=${type}&page=${+page}&${$form.serialize()}&MODULE_GET_LIST=1`,
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
        _getData(1, $_GET['t'] > 0 ? $_GET['t'] : 0)
        _bindHandlers()
    }

    $('.manage-search-block button').on('click', function () {
        _getData(1, $_GET['t'] > 0 ? $_GET['t'] : 0)
    })

    init();
})(jQuery);