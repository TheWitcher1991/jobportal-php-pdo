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

    let $form = $('.form-chat'),
        box = $('.chat-ul'),
        text = $('.input-msg')

    function chatError(response) {
        console.log(response);
    }

    function chatSuccess(responce, act) {
        if (act === 3) {
            if (responce.status === 'В сети') $('.sb-img > div > p').html(`<span style="color: #1967d2">${responce.status}</span>`)
            else $('.sb-img > div > p').html(responce.status)
        } else {
            let list = responce.data.list;
            box.html(list);
        }

    }



    function update() {
        send(2)
        send(3)
    }

    async function send(act) {

        let process = false;

        if (!process) {

            process = true;

            await $.ajax({
                url: '/scripts/chat',
                data: `act=${act}&id=${$_GET['id']}&${$form.serialize()}`,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: function () {
                    chatError()

                    process = false;
                },
                success: function (responce) {
                    if (responce.code === 'success') {
                        chatSuccess(responce, act);
                        if (act === 1) {
                            $form.reset()
                        }
                    } else {
                        chatError(responce)
                    }

                    process = false;
                }})

        }


    }



    if ($_GET['id'] || $_GET['id'] >= 0) {
        let interval = setInterval(() => send(3), 6000)
        let interval2 = setInterval(() => send(2), 3000)
    }

    $(document).on('click', '.send-chat-y', function (e) {
        e.preventDefault()
        send(1)
        document.querySelector('.input-msg').value = ''
        return false;
    })


    let $form2 = $('.form-chat-list'),
        box2 = $('.chat-list-box')

    function _catalogError(responce) {
        console.log(responce)
        box2.html('<span class="chat-error">Ошибка, повторите</span>');
    }

    function _catalogSuccess(responce) {
        box2.html('');
        let chat = responce.data.list;
        let type = responce.data.type;
        if (responce.data.count > 0) {
            for (let item in chat) {
                let r = chat[item]
                if (type == 'users') {
                    box2.append(`
                <li class="${Number($_GET['id']) === r.id ? 'chat-act' : ''}">
                                        <a href="/messages?id=${r.id}">
                                            <div class="clist-img">
                                        <span>
                                            <img src="/static/image/company/${r.com_img}" alt="">
                                        </span>
                                            </div>
                                            <div class="clist-content">
                                                <div class="cl-top">
                                        <span class="cl-name">
                                        ${r.company.substr(0,30).replace(/(<([^>]+)>)/gi,"")}
                                        <m>${r.lock_user || r.lock_company ? '<i class="mdi mdi-cancel"></i>' : ''}</m>
                                        </span>
                                                    <span class="cl-time">
                                            ${r.last}
                                        </span>
                                                </div>
                                                <div class="cl-bot">
                                                ${r.last_m.substr(0, 30).replace(/(<([^>]+)>)/ig,"")}
                                               
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                `)
                } else {
                    box2.append(`
                <li class="${Number($_GET['id']) === r.id ? 'chat-act' : ''}">
                                        <a href="/messages?id=${r.id}">
                                            <div class="clist-img">
                                        <span>
                                            <img src="/static/image/users/${r.img}" alt="">
                                        </span>
                                            </div>
                                            <div class="clist-content">
                                                <div class="cl-top">
                                        <span class="cl-name">
                                        ${r.user}
                                        <m>${r.lock_user || r.lock_company ? '<i class="mdi mdi-cancel"></i>' : ''}</m>
                                        </span>
                                                    <span class="cl-time">
                                            ${r.last}
                                        </span>
                                                </div>
                                                <div class="cl-bot">
                                                     ${r.last_m.substr(0, 30).replace(/(<([^>]+)>)/ig,"")}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                `)
                }

            }
        } else {
            box2.html('<span class="chat-error">Чаты не найдены</span>');
        }
    }



    function _getData() {



        box2.html(`
        <div class="placeholder-main">
         <div class="placeholder-chat">
                                    <div class="placeholder-item chat-img"></div>
                                    <div class="placeholder-block-chat">
                                        <div class="pc-flex">
                                            <div class="placeholder-item chat-title"></div>
                                            <div class="placeholder-item chat-litter-1"></div>
                                        </div>
                                        <div class="placeholder-item chat-little-2"></div>
                                    </div>
                                </div>
                                 <div class="placeholder-chat">
                                    <div class="placeholder-item chat-img"></div>
                                    <div class="placeholder-block-chat">
                                        <div class="pc-flex">
                                            <div class="placeholder-item chat-title"></div>
                                            <div class="placeholder-item chat-litter-1"></div>
                                        </div>
                                        <div class="placeholder-item chat-little-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder-chat">
                                    <div class="placeholder-item chat-img"></div>
                                    <div class="placeholder-block-chat">
                                        <div class="pc-flex">
                                            <div class="placeholder-item chat-title"></div>
                                            <div class="placeholder-item chat-litter-1"></div>
                                        </div>
                                        <div class="placeholder-item chat-little-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder-chat">
                                    <div class="placeholder-item chat-img"></div>
                                    <div class="placeholder-block-chat">
                                        <div class="pc-flex">
                                            <div class="placeholder-item chat-title"></div>
                                            <div class="placeholder-item chat-litter-1"></div>
                                        </div>
                                        <div class="placeholder-item chat-little-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder-chat">
                                    <div class="placeholder-item chat-img"></div>
                                    <div class="placeholder-block-chat">
                                        <div class="pc-flex">
                                            <div class="placeholder-item chat-title"></div>
                                            <div class="placeholder-item chat-litter-1"></div>
                                        </div>
                                        <div class="placeholder-item chat-little-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder-chat">
                                    <div class="placeholder-item chat-img"></div>
                                    <div class="placeholder-block-chat">
                                        <div class="pc-flex">
                                            <div class="placeholder-item chat-title"></div>
                                            <div class="placeholder-item chat-litter-1"></div>
                                        </div>
                                        <div class="placeholder-item chat-little-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder-chat">
                                    <div class="placeholder-item chat-img"></div>
                                    <div class="placeholder-block-chat">
                                        <div class="pc-flex">
                                            <div class="placeholder-item chat-title"></div>
                                            <div class="placeholder-item chat-litter-1"></div>
                                        </div>
                                        <div class="placeholder-item chat-little-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder-chat">
                                    <div class="placeholder-item chat-img"></div>
                                    <div class="placeholder-block-chat">
                                        <div class="pc-flex">
                                            <div class="placeholder-item chat-title"></div>
                                            <div class="placeholder-item chat-litter-1"></div>
                                        </div>
                                        <div class="placeholder-item chat-little-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder-chat">
                                    <div class="placeholder-item chat-img"></div>
                                    <div class="placeholder-block-chat">
                                        <div class="pc-flex">
                                            <div class="placeholder-item chat-title"></div>
                                            <div class="placeholder-item chat-litter-1"></div>
                                        </div>
                                        <div class="placeholder-item chat-little-2"></div>
                                    </div>
                                </div>

                            </div>`)
        $('.search-chat').attr('disabled', 'true')

        setTimeout(function () {
            $.ajax({
                url: '/scripts/filter-chat',
                data: `id=${$('.lock-ses').val()}&${$form2.serialize()}`,
                type: 'POST',
                cache: true,
                dataType: 'json',
                error: _catalogError,
                success: function (responce) {
                    if (responce.code === 'success') {
                        $('.search-chat').removeAttr('disabled')
                        _catalogSuccess(responce);
                    } else {
                        _catalogError(responce)
                    }

                }})
        }, 500)

    }

    $(document).on('click', '.search-chat', function () {
        _getData()
    })

    _getData()

    $('#upload-chat-photo').change(function () {
        if (window.FormData === undefined) {
            alert('В вашем браузере загрузка файлов не поддерживается');
        } else {
            let formData = new FormData();
            $.each($('#upload-chat-photo')[0].files, function(key, input) {
                formData.append('file[]', input);
            });
            $.ajax({
                type: 'POST',
                url: '/scripts/uploads-js',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                dataType : 'json',
                success: function(response){
                    response.forEach(function(row) {
                        if (row.error == '') {
                            $('.image-box').fadeIn(200)
                            $('.image-box').css('display', 'flex')
                            $('.image-box').append(row.data);
                        } else {
                            alert(row.error);
                        }
                    });
                    $(".image-box").val('');
                }
            })
        }
    })

    $(document).on('click', '.lock-chat-go', function () {
        $.ajax({
            url: '/scripts/profile-js',
            data: `id=${Number($_GET['id'])}&MODULE_CHAT_LOCK=1`,
            type: 'POST',
            cache: false,
            dataType: 'json',
            error: (response) => console.log(response),
            success: function (responce) {
                if (responce.code === 'success') {
                    location.reload()
                } else {
                    console.log(responce)
                }
            }})


    })

    $(document).on('click', '.unlock-chat-go', function () {
        $.ajax({
            url: '/scripts/profile-js',
            data: `id=${Number($_GET['id'])}&MODULE_CHAT_UNLOCK=1`,
            type: 'POST',
            cache: false,
            dataType: 'json',
            error: (response) => console.log(response),
            success: function (responce) {
                if (responce.code === 'success') {
                    location.reload()
                } else {
                    console.log(responce)
                }
            }})


    })


})(jQuery);