<!-- Include JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>

<script src=" https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"></script>

<script language="JavaScript" src="/static/scripts/index.js?v=<?= date('YmdHis') ?>"></script>

<script language="JavaScript" src="/static/scripts/region.js?v=<?= date('YmdHis') ?>"></script>

<script language="JavaScript" src="/static/scripts/area.js?v=<?= date('YmdHis') ?>"></script>

<script language="JavaScript" src="/static/scripts/chart.js?v=<?= date('YmdHis') ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.0/apexcharts.min.js" integrity="sha512-ro5O5VVV9gDtjXsjo45nSjsZgA40zABFFZ+x4UoEkFS1fIBF/ZHNBHMQkdJQLGLCLLAXighOK1LpQL2v7wpv/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" integrity="sha512-Eak/29OTpb36LLo2r47IpVzPBLXnAMPAVypbSZiZ4Qkf8p/7S/XRG5xp7OKWPPYfJT6metI+IORkR5G8F900+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js" integrity="sha512-d4KkQohk+HswGs6A1d6Gak6Bb9rMWtxjOa0IiY49Q3TeFd5xAzjWXDCBW9RS7m86FQ4RzM2BdHmdJnnKRYknxw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

<script>
    let options = {
        debug: 'info',
        modules: {
            toolbar: [
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                ['bold', 'italic', 'underline', 'strike', { 'align': [] }],
                ['image', 'blockquote'],
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


        $('button[name=save-data-comp]').on('click', function (e)  {
            $('#editor-area').val(quill.root.innerHTML)
            return true;
        })

    })(jQuery, window, document);

</script>



<script>

    (function ($) {

        new WOW().init();

        $(window).on('load', () => $('#loader-site').delay(200).fadeOut(500))

        $(document).ready(function () {

            $('.pm-open-mobile').on('click', function () {
                $('.profile-aside').fadeIn(300)
            })

            $('.profile-mob-exit').on('click', function () {
                $('.profile-aside').fadeOut(300)
            })

            $('.back-menu').on('click', function () {
                $('.profile-aside').fadeToggle(200)
            })

            $('.default-table').DataTable({
                "paging": false,
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

            $('.profile-aside-nav > ul > li > a').on('click', function (event) {
                ul = $(this).parent().children('ul');
                ul.slideToggle("slow");
                $(this).toggleClass('a-pop');
            })

            $("#tel").mask("+7 (999) 999-9999");

            $('.city_res').select2({
                placeholder: "Выберите город",
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

            

        })

    })(jQuery, window, document);

</script>

<!-- / Include JS -->