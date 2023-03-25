


<!-- Include JS -->




<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>

<script src=" https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"></script>

<script src="/static/scripts/index.js?v=<?= date('YmdHis') ?>"></script>

<script src="/static/scripts/region.js?v=<?= date('YmdHis') ?>"></script>

<script src="/static/scripts/area.js?v=<?= date('YmdHis') ?>"></script>

<script src="/static/scripts/chart.js?v=<?= date('YmdHis') ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" integrity="sha512-Eak/29OTpb36LLo2r47IpVzPBLXnAMPAVypbSZiZ4Qkf8p/7S/XRG5xp7OKWPPYfJT6metI+IORkR5G8F900+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js" integrity="sha512-d4KkQohk+HswGs6A1d6Gak6Bb9rMWtxjOa0IiY49Q3TeFd5xAzjWXDCBW9RS7m86FQ4RzM2BdHmdJnnKRYknxw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

<script>



    function getRandomInt(max) {
        return Math.floor(Math.random() * max);
    }

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

</script>

<script>
    let options = {
        debug: 'info',
        modules: {
            toolbar: [
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                ['bold', 'italic', 'underline', 'strike', { 'align': [] }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [{ 'color': [] }, { 'background': [] }],
                ['clean']
            ]
        },
        placeholder: 'Введите текст...',
        theme: 'snow'
    };
    let quill = new Quill('#editor', options);

    (function ($) {
        $(document).on('click', 'input[name=create-job]', function (e)  {
            $('#editor-area').val(quill.root.innerHTML)
            return true;
        })

        $(document).on('click', 'input[name=save-data-comp]', function (e)  {
            $('#editor-area').val(quill.root.innerHTML)
            return true;
        })

    })(jQuery, window, document);

</script>

<script>
    const refreshCaptcha=(target)=>{const captchaImage=target.closest('.captcha__image-reload').querySelector('.captcha__image');captchaImage.src='/captcha?r='+new Date().getUTCMilliseconds()}
    const captchaBtn=document.querySelector('.captcha__refresh');captchaBtn.addEventListener('click',(e)=>refreshCaptcha(e.target))
</script>

<script>

    (function ($) {

        new WOW().init();

        $(window).on('load', () => $('#loader-site').delay(200).fadeOut(500))

        $(document).ready(function () {

            $(document).on('click', '.create-box-chart-all', function () {
                $('.chart-wrapper-block-2').fadeToggle(200)
            })

            $(document).on('click', '.pm-open-mobile', function () {
                $('.profile-aside').fadeIn(300)
            })

            $(document).on('click', '.fa-minus', function () {
                $(this).parent().next().slideToggle(200)
            })

            $(document).on('click', '.profile-mob-exit', function () {
                $('.profile-aside').fadeOut(300)
            })

            $(document).on('click', '.back-menu', function () {
                $('.profile-aside').fadeToggle(200)
            })

            let $leftMenu = $('.map-admin-ul > li > a')
            let $right = $('.admin-map-ctx svg a')

            $leftMenu.mouseenter(function(){
                let classOne = $(this).attr('href');
                let color = $(this).data('color');
                let name = $(this).data('name');
                let job = $(this).data('job')
                let currentElement = $(".admin-map-ctx a[href='"+classOne+"']");
                currentElement.find('polygon').css('fill',color).css('stroke-width', '2px')
                currentElement.find('path').css('fill',color).css('stroke-width', '2px')
                $(this).addClass('active');
                $('.map-tooltip').addClass('active-tol');
                $('.tol-caption').html(`${name} <i class="icon-briefcase"></i> ${job}`);
            });

            $leftMenu.mouseleave(function(){
                let classOne = $(this).attr('href');
                let currentElement = $(".admin-map-ctx a[href='"+classOne+"']");
                let fillPol =  currentElement.find('polygon').attr('fill');
                let fillPath = currentElement.find('path').attr('fill');
                currentElement.find('polygon').css('fill', fillPol).css('stroke-width', '1px')
                currentElement.find('path').css('fill', fillPath).css('stroke-width', '1px')
                $(this).removeClass('active');
                $('.map-tooltip').removeClass('active-tol');
                $('.tol-caption').html('');
            });

            $right.mouseenter(function(){
                let classOne = $(this).attr('href');
                let color = $(this).data('color');
                let name = $(this).data('name');
                let job = $(this).data('job')
                let currentElement = $(".map-admin-ul a[href='"+classOne+"']");
                $(this).find('polygon').css('fill',color).css('stroke-width', '2px')
                $(this).find('path').css('fill',color).css('stroke-width', '2px')
                currentElement.addClass('active');
                $('.map-tooltip').addClass('active-tol');
                $('.tol-caption').html(`${name} <i class="icon-briefcase"></i> ${job}`);

            });

            $right.mouseleave(function(){
                let classOne = $(this).attr('href');
                let currentElement = $(".map-admin-ul a[href='"+classOne+"']");
                let fillPol =  $(this).find('polygon').attr('fill');
                let fillPath = $(this).find('path').attr('fill');
                $(this).find('polygon').css('fill', fillPol).css('stroke-width', '1px')
                $(this).find('path').css('fill',fillPath).css('stroke-width', '1px')
                currentElement.removeClass('active');
                $('.map-tooltip').removeClass('active-tol');
                $('.tol-caption').html('');
            });

            $("#tel").mask("+7 (999) 999-99-99");

            $('.default-table').DataTable({

                "info": false,
                language: {
                    "processing": "Подождите...",
                    "search": "Поиск:",
                    "loadingRecords": "Загрузка записей...",
                    "zeroRecords": "Ничего не найдено.",
                    "emptyTable": "В таблице отсутствуют данные",
                    "aria": {
                        "sortAscending": ": активировать для сортировки столбца по возрастанию",
                        "sortDescending": ": активировать для сортировки столбца по убыванию"
                    }
                }
            });


            $('.company-list-select').select2({
                placeholder: "Выберите компанию",
                maximumSelectionLength: 2,
                language: "ru"
            });

            $('.select2-region').select2({
                placeholder: "Выберите регион",
                maximumSelectionLength: 2,
                language: "ru"
            });

            $('.select2-direction').select2({
                placeholder: "Выберите направления",
                maximumSelectionLength: 2,
                language: "ru"
            });

            $('.city_res').select2({
                placeholder: "Выберите город",
                maximumSelectionLength: 2,
                language: "ru"
            });


            $('.address').select2({
                placeholder: "Выберите город",
                maximumSelectionLength: 2,
                language: "ru"
            });



            $('.select2-region').on('change', function (e) {
                $('.profile-area label').remove();
                $('.profile-area .label-select-block').remove();
                $('.profile-city label').remove();
                $('.profile-city .label-select-block').remove();
                $('.e-area').hide()
                $('.e-address').hide()
                if (this.value === 'Ставропольский край') {
                    document.querySelector('.profile-area').innerHTML += '<label for="address">Район <span>*</span></label>'
                    document.querySelector('.profile-area').innerHTML += `
                    <div class="label-select-block">
                         <select class="select2-area" id="area" name="area" placeholder="Выберите район">
                            <option></option>
                         </select>
                        <div class="label-arrow">
                            <i class="mdi mdi-chevron-down"></i>
                        </div>
                    </div>
                    <span class="empty e-area">Выберите район</span>
                    `
                    let data = district['Северо-Кавказский федеральный округ']['Ставропольский край'];
                    for (let key in data) {
                        document.querySelector('.select2-area').innerHTML += `<option value="${key}">${key}</option`
                    }
                    $('.select2-area').select2({
                        placeholder: "Выберите район",
                        maximumSelectionLength: 2,
                        language: "ru"
                    });
                    awr();

                } else {
                    document.querySelector('.profile-city').innerHTML += '<label for="address">Населённый пункт <span>*</span></label>'
                    document.querySelector('.profile-city').innerHTML += `
                    <div class="label-select-block">
                         <select class="select2-address" id="address" name="address" placeholder="Выберите населённый пункт">
                            <option></option>
                         </select>
                        <div class="label-arrow">
                            <i class="mdi mdi-chevron-down"></i>
                        </div>
                    </div>
                    <span class="empty e-address">Выберите населённый пункт</span>
                    `
                    let data = region[this.value];
                    for (let key in data) {
                        document.querySelector('.select2-address').innerHTML += `<option value="${data[key]}">${data[key]}</option`
                    }
                    $('.select2-address').select2({
                        placeholder: "Выберите населённый пункт",
                        maximumSelectionLength: 2,
                        language: "ru"
                    });
                }
            })



            function awr () {

                $('.select2-area').on('change', function () {
                    $('.profile-city label').remove();
                    $('.profile-city .label-select-block').remove();
                    $('.e-address').hide()
                    document.querySelector('.profile-city').innerHTML += '<label for="address">Населённый пункт <span>*</span></label>'
                    document.querySelector('.profile-city').innerHTML += `
                            <div class="label-select-block">
                                 <select class="select2-address" id="address" name="address" placeholder="Выберите населённый пункт">
                                    <option></option>
                                 </select>
                                <div class="label-arrow">
                                    <i class="mdi mdi-chevron-down"></i>
                                </div>
                            </div>
                            <span class="empty e-address">Выберите населённый пункт</span>
                            `
                    let rx = $('.select2-area').val();
                    let data = district['Северо-Кавказский федеральный округ']['Ставропольский край'][rx];
                    for (let key in data) {
                        document.querySelector('.select2-address').innerHTML += `<option value="${data[key]}">${data[key]}</option`
                    }
                    $('.select2-address').select2({
                        placeholder: "Выберите населённый пункт",
                        maximumSelectionLength: 2,
                        language: "ru"
                    });
                });

            }

            const activeItem3 = function (obj) {
                obj = obj || {};
                let path = window.location.pathname + window.location.search;
                for (let key in obj) {
                    obj[key].forEach(el => {
                        if (path === String(el)) {
                            $(`.admin-aside-nav > ul > li:nth-child(${key}) > a`).addClass('active-menuItem2');
                        }
                    });
                }
            };

            const menuItem4 = {
                2: ['/admin/analysis'],
                3: ['/admin/logs'],
                4: ['/admin/ip'],
                5: ['/admin/students-list', '/admin/students-add'],
                6: ['/admin/companys-list', '/admin/companys-add'],
                7: ['/admin/jobs-list', '/admin/jobs-add', '/admin/jobs-close'],
            };

            activeItem3(menuItem4);

            $(document).on('click', '.admin-aside-nav > ul > li > a', function (event) {
                ul = $(this).parent().children('ul');
                ul.slideToggle("slow");
                $(this).toggleClass('a-pop');
            })

            $(document).on('click', '.profile-aside-nav > ul > li > a', function (event) {
                ul = $(this).parent().children('ul');
                ul.slideToggle("slow");
                $(this).toggleClass('a-pop');
            })
        })

    })(jQuery, window, document);

</script>