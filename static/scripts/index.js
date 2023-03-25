(function ($) {

    'use strict';

    $(window).on('load', function () {
        $('#loader-site').delay(200).fadeOut(500)
    })

    let bg = document.querySelectorAll('.parallax-bg-1');
    for (let i = 0; i < bg.length; i++){
        window.addEventListener('mousemove', function(e) {
            let x = e.clientX / window.innerWidth;
            let y = e.clientY / window.innerHeight;
            bg[i].style.transform = 'translate(-' + x * 20 + 'px, -' + y * 5 + 'px)';
        });
    }

    let bg2 = document.querySelectorAll('.parallax-bg-2');
    for (let i = 0; i < bg2.length; i++){
        window.addEventListener('mousemove', function(e) {
            let x = e.clientX / window.innerWidth;
            let y = e.clientY / window.innerHeight;
            bg2[i].style.transform = 'translate(-' + x * 30 + 'px, -' + y * 30 + 'px)';
        });
    }

    let bg3 = document.querySelectorAll('.parallax-bg-3');
    for (let i = 0; i < bg3.length; i++){
        window.addEventListener('mousemove', function(e) {
            let x = e.clientX / window.innerWidth;
            let y = e.clientY / window.innerHeight;
            bg3[i].style.transform = 'translate(-' + x * 20 + 'px, -' + y * 20 + 'px)';
        });
    }

    let bg4 = document.querySelectorAll('.parallax-bg-4');
    for (let i = 0; i < bg4.length; i++){
        window.addEventListener('mousemove', function(e) {
            let x = e.clientX / window.innerWidth;
            let y = e.clientY / window.innerHeight;
            bg4[i].style.transform = 'translate(-' + x * 30 + 'px, -' + y * 30 + 'px)';
        });
    }


    function request(url, type, data) {
        return new Promise((succeed, fail) => {
            const xhr = new XMLHttpRequest();
            xhr.responseType = "json";
            xhr.open(type, url, true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.addEventListener("load", () => {
                if (xhr.status >=200 && xhr.status < 400)
                    succeed(xhr.response);
                else
                    fail(new Error(`Request failed: ${xhr.statusText}`));
            });
            xhr.addEventListener("error", () => fail(new Error("Network error")));
            xhr.send(data);
        });
    }


    document.addEventListener('DOMContentLoaded', function () {

        let salary = document.querySelector('.salaryTo'),
            salary_end = document.querySelector('.salaryFrom')

        document.querySelector('#q104').addEventListener('click', function () {
            salary.setAttribute('disabled', 'true')
            salary_end.setAttribute('disabled', 'true')
            salary.value = '';
            salary_end.value = '';
        })

        document.querySelector('#q304').addEventListener('click', function () {
            salary.setAttribute('disabled', 'true')
            salary_end.setAttribute('disabled', 'true')
            salary.value = '';
            salary_end.value = '';
        })

        document.querySelector('#q305').addEventListener('click', function () {
            salary.removeAttribute('disabled')
            salary_end.removeAttribute('disabled')
        })


        let i = 1;
        for(let li of carousel.querySelectorAll('li')) {
            li.style.position = 'relative';
            li.insertAdjacentHTML('beforeend', `<span style="position:absolute;left:0;top:0">${i}</span>`);
            i++;
        }
        let width = 250;
        let count = 3;

        let list = carousel.querySelector('ul');
        let listElems = carousel.querySelectorAll('li');

        let position = 0;

        carousel.querySelector('.prev').onclick = function() {
            position += width * count;

            position = Math.min(position, 0)
            list.style.marginLeft = position + 'px';
        };

        carousel.querySelector('.next').onclick = function() {
            position -= width * count;
            position = Math.max(position, -width * (listElems.length - count));
            list.style.marginLeft = position + 'px';
        };



        const slider = new ChiefSlider('.slider', {
            loop: false
        });

        let swiper = new Swiper('.blog-slider', {
            effect: 'fade',
            loop: true,
            mousewheel: {
                invert: false,
            },
            autoHeight: true,
            pagination: {
                el: '.blog-slider__pagination',
                clickable: true,
            }
        });


    });


    const previewFormResume = function (where) {
        document.querySelector(where).classList.add('active-preview');
        document.querySelector(where).innerHTML += `
        `;
    };

    const tabsi = function (b, who1, who2, cl) {
        $(b[0]).on('click', (c) => {
            c.preventDefault()
            $(who1).removeClass(cl)
            $(who2).removeClass(cl)
            $(b[0]).addClass(cl)
            $(b[1]).addClass(cl)
        })
    }

    const toggle = (b, c) => {
        b.forEach(function (el, i) {
            $(el).on('click', function (e) {
                e.preventDefault();
                if ($(c[i]).css('display') === 'none') {
                    $('.p-hs').fadeOut();
                    $(c[i]).fadeIn(300);
                } else if ($(c[i]).css('display') === 'block') {
                    $(c[i]).fadeOut(300);
                }
            })
        })
    };

    const createSkills = function (where, text, count) {
        document.querySelector(where).innerHTML += `
            <div class="skills-${count} plusform">
                <div class="tag-main">
                    <span class="tag-text">${text}</span>
                    <span onclick="$(this).parent().remove();" class="tag-trash"><i class="mdi mdi-delete"></i></span>
                </div>
                <input style="display:none" type="text" id="skill-text-${count}" name="skill-text-${count}" value="${text}">
            </div>
        `;
        document.querySelector('.countSkills').value = count;
    };

    const createFormEducation = function (where, count) {
        document.querySelector(where).innerHTML += `
            <div class="education-${count} addform">
                <span class="del-ed del-pf "><i class="mdi mdi-close"></i></span>
                
                <div style="margin: 35px 0 20px 0;" class="label-block">
                    <label for="ed-title-${count}">Организация</label>
                    <input type="text" id="ed-title-${count}" name="ed-title-${count}">
                </div>
                
                <div class="label-block">
                    <label for="ed-date-${count}">Дата обучения (Начало-Конец)</label>
                    <input type="text" id="ed-date-${count}" name="ed-date-${count}">
                </div>
        
                <div class="label-block">
                    <label for="ed-text-${count}">Краткое описание</label>
                    <textarea name="ed-text-${count}" id="ed-text-${count}" style="height:100px;" cols="30" rows="10"></textarea>
                </div>  
            </div>
        `;
        document.querySelector('.countEdu').value = count;
    };

    const createFormExp = function (where, count) {
        document.querySelector(where).innerHTML += `
            <div class="exp-${count} addform">
                <span class="exp-ed del-pf "><i class="mdi mdi-close"></i></span>
                
                <div style="margin: 35px 0 20px 0;" class="label-block">
                    <label for="exp-title-${count}">Организация</label>
                    <input type="text" id="exp-title-${count}" name="exp-title-${count}" >
                </div>
                
                <div class="label-block">
                    <label for="exp-date-${count}">Дата работы (Начало-Конец)</label>
                    <input type="text" id="exp-date-${count}" name="exp-date-${count}">
                </div>
        
                <div class="label-block">
                    <label for="exp-text-${count}">Краткое описание</label>
                    <textarea id="exp-text-${count}" name="exp-text-${count}" style="height:100px;" cols="30" rows="10"></textarea>
                </div> 
                
     
            </div>
        `;
        document.querySelector('.countExp').value = count;
    }

    const getHref = function (listId) {
        let Nodelist = document.querySelectorAll(`#nav > div > div > ul.left > li:nth-child(${listId}) > div > ul > li > a`),
            res = [];
        Nodelist.forEach(el => {
            res.push(el.href.split('.tech')[1]);
        });
        return res;
    };

    const activeItem = function (obj) {
        obj = obj || {};
        let path = window.location.pathname + window.location.search;
        for (let key in obj) {
            obj[key].forEach(el => {
                if (path === String(el)) {
                    $(`#nav > div > div > ul.left > li:nth-child(${key}) > a`).addClass('active-menuItem');
                }
            });
        }
    };

    const activeItem2 = function (selector, obj) {
        obj = obj || {};
        let path = window.location.pathname + window.location.search;
        for (let key in obj) {
            obj[key].forEach(el => {
                if (path === String(el)) {
                    $(`.profile-aside-nav > ${selector} > li:nth-child(${key}) > a`).addClass('active-menuItem2');
                }
            });
        }
    };

    const activeItem4 = function (obj) {
        obj = obj || {};
        let path = window.location.pathname + window.location.search;
        for (let key in obj) {
            obj[key].forEach(el => {
                if (path === String(el)) {
                    $(`.mm-list > ul > li:nth-child(${key}) > a`).addClass('active-menuItem4');
                }
            });
        }
    };

    $(window).scroll(function () {
        let height = $(window).scrollTop();

        if (height > 64) {
            $('#nav').addClass('h-container-active');
            $('#arrow__up').fadeIn();
        } else {
            $('#nav').removeClass('h-container-active');
            $('#arrow__up').fadeOut();
        }
    });


    $(document).ready(function () {

        $('.counter').spincrement({
            thousandSeparator: "",
            duration: 1200
        });







        $(document).on('click', '.eye-password', function () {
            if ($(this).hasClass('in-pass')) {
                $(this).removeClass('mdi-eye-outline in-pass')
                $(this).addClass('mdi-eye-off-outline off-pass')
                $(this).siblings('input').attr('type', 'text')
            } else {
                $(this).removeClass('mdi-eye-off-outline off-pass')
                $(this).addClass('mdi-eye-outline in-pass')
                $(this).siblings('input').attr('type', 'password')
            }
        })

        $(document).on('click', '.print-bth', function () {
            window.print()
            return false;
        })


        $(document).on('click', '.mm-list > ul > li > a', function () {
            $(this).children().toggleClass('active-mi');
            let a = $(this).siblings().slideToggle(200);
        })

        $(document).on('click', '.open-menu', function () {
            $('.mobile-menu').fadeIn(100);
            $('body').addClass('body-hidden');
        })

        $(document).on('click', '.mm-exit > span', function () {
            $('.mobile-menu').fadeOut(100);
            $('body').removeClass('body-hidden');
        })

        let $leftMenu = $('.left-menu ul > li > a')
        let $right = $('.map svg a')

        $leftMenu.mouseenter(function(){
            let classOne = $(this).attr('href');
            let color = $(this).data('color');
            let name = $(this).data('name');
            let job = $(this).data('job')
            let currentElement = $(".map a[href='"+classOne+"']");
            currentElement.find('polygon').css('fill',color).css('stroke-width', '2px')
            currentElement.find('path').css('fill',color).css('stroke-width', '2px')
            $(this).addClass('active');
            $('.map-tooltip').addClass('active-tol');
            $('.tol-caption').html(`${name} <i class="icon-briefcase"></i> ${job}`);
        });

        $leftMenu.mouseleave(function(){
            let classOne = $(this).attr('href');
            let currentElement = $(".map a[href='"+classOne+"']");
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
            let currentElement = $(".left-menu a[href='"+classOne+"']");
            $(this).find('polygon').css('fill',color).css('stroke-width', '2px')
            $(this).find('path').css('fill',color).css('stroke-width', '2px')
            currentElement.addClass('active');
            $('.map-tooltip').addClass('active-tol');
            $('.tol-caption').html(`${name} <i class="icon-briefcase"></i> ${job}`);

        });

        $right.mouseleave(function(){
            let classOne = $(this).attr('href');
            let currentElement = $(".left-menu a[href='"+classOne+"']");
            let fillPol =  $(this).find('polygon').attr('fill');
            let fillPath = $(this).find('path').attr('fill');
            $(this).find('polygon').css('fill', fillPol).css('stroke-width', '1px')
            $(this).find('path').css('fill',fillPath).css('stroke-width', '1px')
            currentElement.removeClass('active');
            $('.map-tooltip').removeClass('active-tol');
            $('.tol-caption').html('');
        });

        $(document).on('click', '.filter-main .filter-layout > .fl-title', function () {
            $(this).siblings().fadeToggle(200)
            $(this).find('i').toggleClass('fl-i-active')
        })

        $(document).on('click', '.filter-main .filter-layout > .fl-bth', function () {
            $(this).siblings().fadeToggle(200)
            $(this).find('i').toggleClass('fl-i-active')
        })

        $(document).on('click', '.filter-up-bth > span', () => {
            $('.c-search-block').fadeIn(200);
            $('.manage-filter-list').fadeIn(200);
            $('.filter-bth-wrap').css('display', 'flex')
            $('body').addClass('body-hidden');
        })

        $(document).on('click', '.filter-title i', () => {
            $('.c-search-block').fadeOut(200);
            $('.manage-filter-list').fadeOut(200);
            $('.filter-bth-wrap').css('display', 'none')
            $('body').removeClass('body-hidden');
        })

        $(document).on('click', '.filter-bth-wrap', () => {
            $('.c-search-block').fadeOut(200);
            $('.manage-filter-list').fadeOut(200);
            $('.filter-bth-wrap').css('display', 'none')
            $('body').removeClass('body-hidden');
        })

        //tabsi(['.dt-a-1', '.dt-b-1'], '.detail-tabs > ul > li', '.detail-block > div', 'dt-active');
        //tabsi(['.dt-a-2', '.dt-b-2'], '.detail-tabs > ul > li', '.detail-block > div', 'dt-active');
        //tabsi(['.dt-a-3', '.dt-b-3'], '.detail-tabs > ul > li', '.detail-block > div', 'dt-active');

        $(document).on('click', '.success-blue i', function () {
            $(this).parent().remove();
        })

        $(document).on('click', '.create-respond-mini', function (e) {
            e.preventDefault();
            $('#auth').addClass('auth-b-act');
            $('#auth .contact-wrapper').removeClass('auth-c-act');
            $('#auth .respond-wrapper').addClass('auth-c-act');
            $('body').addClass('body-hidden');
        })

        $(document).on('click', '.job-cont', function (e) {
            e.preventDefault();
            $('#auth').addClass('auth-b-act');
            $('#auth .contact-wrapper').addClass('auth-c-act');
            $('body').addClass('body-hidden');
        })

        toggle(['.sb-icon-bth'], ['.sb-icon-pop'])

        $(document).on('click', '.del-ed', function () {
            $(this).parent().remove();
        });

        $(document).on('click', '.exp-ed', function () {
            $(this).parent().remove();
        });

        let counterVal = 0;

        $(document).on('click', '.add-form-p-1', () => {createFormEducation('.red-p', ++counterVal)})

        $(document).on('click', '.add-form-p-2', () => {createFormExp('.rex-p', ++counterVal)})

        $(document).on('click', '.skills-bth button', () => {
            if ($('.skills-input').val()) {
                createSkills('.skills-box', $('.skills-input').val(), ++counterVal)
                $('.skills-input').val('')
            }
        })

        $(document).on('click', '.tabs-form > .a-p > a', (e) => {
            e.preventDefault();
            $('#auth').addClass('auth-b-act');
            $('#auth .auth-wrapper').addClass('auth-c-act');
        })

        $(document).on('click', '.open-auth', (e) => {
            e.preventDefault();
            $('#auth').addClass('auth-b-act');
            $('#auth .auth-wrapper').addClass('auth-c-act');
            $('body').addClass('body-hidden');
        });

        $(document).on('click', '.form-close', (e) => {
            e.preventDefault();
            $(document).find('#auth').removeClass('auth-b-act');
            $(document).find('#auth > div').removeClass('auth-b-act');
            $(document).find('#auth2').removeClass('auth-b-act');
            $(document).find('#auth2 > div').removeClass('auth-b-act');
            $(document).find('#auth .auth-wrapper').removeClass('auth-c-act');
            $(document).find('#auth .lost-wrapper').removeClass('auth-c-act');
            $(document).find('#auth .contact-wrapper').removeClass('auth-c-act');
            $(document).find('#auth .respond-wrapper').removeClass('auth-c-act');
            $('body').removeClass('body-hidden');
        });

        $(document).on('click', '.lost-pass-a', (e) => {
            e.preventDefault();
            $('#auth .auth-wrapper').removeClass('auth-c-act');
            $('#auth .lost-wrapper').addClass('auth-c-act');
        })

        $(document).on('click', '.lost-pass-a-2', (e) => {
            e.preventDefault();
            $('#auth').addClass('auth-b-act');
            $('#auth .lost-wrapper').addClass('auth-c-act');
            $('body').addClass('body-hidden');

        })

        $(document).on('click', '.pfa-a-bth', (e) => {
            e.preventDefault();
            $('.avatar-popup').addClass('ap-active');
            $('.avatarp-container').addClass('apc-active');
        });

        $(document).on('click', '.pfb-bth', (e) => {
            e.preventDefault();
            $('.banner-popup').addClass('ap-active');
            $('.banner-container').addClass('apc-active');
        });

        $(document).on('click', '.ap-close', (e) => {
            e.preventDefault();
            $('.avatar-popup').removeClass('ap-active');
            $('.avatarp-container').removeClass('apc-active');
            $('.banner-popup').removeClass('ap-active');
            $('.banner-container').removeClass('ap-active');
        });

        $(document).on('click', '.cm-close', (e) => {
            e.preventDefault();
            $('.contact-m').removeClass('apr-active');
            $('.contact-m-container').removeClass('aprc-active');
        });

        $(document).on('click', '.rm-close', (e) => {
            e.preventDefault();
            $('.respond-m').removeClass('apr-active');
            $('.respond-m-container').removeClass('aprc-active');
        });

        $(document).on('click', '.contact-me', (e) => {
            e.preventDefault();
            $('.contact-m').addClass('apr-active');
            $('.contact-m-container').addClass('aprc-active');
        });

        $(document).on('click', '.react', (e) => {
            e.preventDefault();
            $('.respond-m').addClass('apr-active');
            $('.respond-m-container').addClass('aprc-active');
        });

        let st = district['Северо-Кавказский федеральный округ']['Ставропольский край'];
        let $arr = [];
        for (let i in st) {
            let arr = st[i];
            for (let i in arr) {
                $arr.push(`/job-list?loc=${arr[i]}`)
            }
        }

        const menuItem = {
            1: ['/'],
            2: ['/job-list?loc=stav', '/job-list/?loc=stav'],
            3: ['/company-list'],
            4: ['/resume', '/resume-list'],
            5: ['/faculty', '/students'],
            6: ['/employer']
        };

        const menuItem2 = {
            2: ['/profile'],
            3: ['/views'],
            4: ['/change-password', '/logs', '/2fa'],
            5: ['/add-education', '/add-exp', '/add-achievement', '/add-works'],
            6: ['/me-respond'],
            7: ['/messages'],
            8: ['/notice'],
            9: ['/me-review', '/me-sub', '/save']

        };

        const menuItem3 = {
            2: ['/profile'],
            3: ['/change-password', '/logs', '/logs/'],
            4: ['/create-job'],
            5: ['/responded'],
            6: ['/manage-job'],
            7: ['/messages'],
            8: ['/archive-job', '/archive-responded'],
            9: ['/notice'],
            10: ['/me-review', '/me-sub', '/save']
        };

        const menuItem4 = {
            1: ['/'],
            2: [...getHref(2), '/job', '/category', '/all', '/job-list/?loc=stav', '/job-list'],
            3: ['/company-list'],
            4: ['/resume-list'],
            5: ['/faculty', '/students'],
            6: ['/employer']
        }

        activeItem(menuItem);

        activeItem2('.pa-ul-company', menuItem3);

        activeItem2('.pa-ul-user', menuItem2);

        activeItem4(menuItem4);

        let uploadButton = {
            $button: $('.uploadButton-input'),
            $nameField: $('.uploadButton-file-name')
        };

        $(document).on('change', '.uploadButton-input', function() {

            let selectedFile = [];
            for (let i = 0; i < $(this).get(0).files.length; ++i) {
                selectedFile.push($(this).get(0).files[i].name + '<br>');
            }
            $('.uploadButton-file-name').html(selectedFile);
        });

        /* $('.select-opt').select2({
            dropdownParent: $('.header-container'),
            minimumResultsForSearch: 20,
            width: "100%"
        }); */

        $(document).on('click', '#arrow__up', (e) => {
            e.preventDefault();

            $('html, body').animate({
                scrollTop: 0
            }, 500);

            return false;
        });

        const btns = document.querySelectorAll('.pulse-bth')

        btns.forEach(el => {
            el.addEventListener('click', function(e) {
                const
                    size = Math.max(this.offsetWidth, this.offsetHeight),
                    x = e.offsetX - size / 2,
                    y = e.offsetY - size / 2,
                    wave = document.createElement('span')

                wave.className = 'wave'
                wave.style.cssText = `width:${size}px;height:${size}px;top:${y}px;left:${x}px`
                this.appendChild(wave)

                setTimeout(() => wave.remove(), 500)
            })
        })

    });

})(jQuery, window, document)

function startIndex() {
    $.ajax({
        url: '/scripts/index-script',
        data: '',
        type: 'POST',
        cache: false,
        dataType: 'json',
        error: (response) => console.log(response),
        success: function (responce) {
            if (responce.code === 'success') {
                console.log('Success start...')
            } else {
                console.log(responce)
            }
        }
    })
}

(function ($) {startIndex();})(jQuery, window, document)