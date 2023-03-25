<?php
if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

    if ($_SESSION['type'] == 'admin') {
        $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id", [':id' => $_SESSION['id']]);

        if (empty($a['id'])) {
            $app->notFound();
        }
    }

    $faculty = (int) $_GET['f'];

    if ($faculty == 1) $f = 'Экономический факультет';
    else if ($faculty == 2) $f = 'Факультет агробиологии и земельных ресурсов';
    else if ($faculty == 3) $f = 'Факультет экологии и ландшафтной архитектуры';
    else if ($faculty == 4) $f = 'Инженерно-технологический факультет';
    else if ($faculty == 5) $f = 'Факультет социально-культурного сервиса и туризма';
    else if ($faculty == 6) $f = 'Электроэнергетический факультет';
    else if ($faculty == 7) $f = 'Учетно-финансовый факультет';
    else if ($faculty == 8) $f = 'Факультет среднего профессионального образования';
    else if ($faculty == 9) $f = 'Факультет ветеринарной медицины';
    else if ($faculty == 10) $f = 'Биотехнологический факультет';
    else $f = '';

    Head('Статистика ' . $f);



    ?>

    <body class="profile-body">



    <main class="wrapper wrapper-profile" id="wrapper">


        <?php require('admin/template/adminAside.php'); ?>

        <section class="profile-base">

            <?php require('admin/template/adminHeader.php'); ?>

            <div class="profile-content admin-content">

                <div class="section-nav-profile">
                    <span><a href="/admin/analysis">Кабинет</a></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a href="/admin/statistics">Статистика</a></span>
    <?php if (!empty($faculty)) { ?>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                    <span><a target="_blank" href="/students/?f=<?php echo $f; ?>"><?php echo $f; ?></a></span>
    <?php } ?>
                </div>
                <?php if (empty($faculty)) { ?>

                        <div class="create-box-chart-all">

                            <span><i class="mdi mdi-chart-box-plus-outline"></i> Общая статистика</span>

                            <i class="mdi mdi-chevron-down"></i>

                        </div>

                <div class="chart-wrapper-block-2">

                    <div class="row sparkboxes mt-4">
                        <div class="col-md-3">
                            <div class="box box1">
                                <div class="details">
                                    <h3>1213</h3>
                                    <h4>CLICKS</h4>
                                </div>
                                <div id="spark1"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box box2">
                                <div class="details">
                                    <h3>422</h3>
                                    <h4>VIEWS</h4>
                                </div>
                                <div id="spark2"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box box3">
                                <div class="details">
                                    <h3>311</h3>
                                    <h4>LEADS</h4>
                                </div>
                                <div id="spark3"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box box4">
                                <div class="details">
                                    <h3>22</h3>
                                    <h4>SALES</h4>
                                </div>
                                <div id="spark4"></div>
                            </div>
                        </div>
                    </div>

                    <div class="analysis-manage-flex">
                        <div class="block-result">
                            <span>Просмотры за месяц <i class="fa-solid fa-minus"></i></span>
                            <div class="chart">
                                <div id="views_1"></div>
                            </div>
                        </div>

                        <div class="block-result">
                            <span>Отклики за месяц <i class="fa-solid fa-minus"></i></span>
                            <div class="chart">
                                <div id="views_2"></div>
                            </div>
                        </div>
                    </div>


                </div>

                    <div class="faculty-list">
                        <a href="/admin/statistics/?f=1" target="_blank" class="faculty-item">

                            <span>
                                    <img src="/static/image/fak/faculty/econom.jpg" alt="">
                            </span>

                            <h1>Экономический</h1>

                            <ul>
                                <li>
                                    <span>0</span>
                                    <span>Студентов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Откликов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Трудоустроено</span>
                                </li>
                            </ul>

                        </a>

                        <a href="/admin/statistics/?f=6" target="_blank" class="faculty-item">

                            <span>
                                    <img src="/static/image/fak/faculty/electro.jpg" alt="">
                            </span>

                            <h1>Электроэнергетический</h1>

                            <ul>
                                <li>
                                    <span>0</span>
                                    <span>Студентов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Откликов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Трудоустроено</span>
                                </li>
                            </ul>

                        </a>

                        <a href="/admin/statistics/?f=2" target="_blank" class="faculty-item">

                            <span>
                                    <img src="/static/image/fak/faculty/agro.jpg" alt="">
                            </span>

                            <h1>Агробиологии и земельных ресурсов</h1>

                            <ul>
                                <li>
                                    <span>0</span>
                                    <span>Студентов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Откликов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Трудоустроено</span>
                                </li>
                            </ul>

                        </a>

                        <a href="/admin/statistics/?f=3" target="_blank" class="faculty-item">

                            <span>
                                    <img src="/static/image/fak/faculty/eco.jpg" alt="">
                            </span>

                            <h1>Экологии и ландшафтной архитектуры</h1>

                            <ul>
                                <li>
                                    <span>0</span>
                                    <span>Студентов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Откликов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Трудоустроено</span>
                                </li>
                            </ul>

                        </a>

                        <a href="/admin/statistics/?f=4" target="_blank" class="faculty-item">

                            <span>
                                    <img src="/static/image/fak/faculty/meh.jpg" alt="">
                            </span>

                            <h1>Инженерно-технологический</h1>

                            <ul>
                                <li>
                                    <span>0</span>
                                    <span>Студентов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Откликов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Трудоустроено</span>
                                </li>
                            </ul>

                        </a>

                        <a href="/admin/statistics/?f=5" target="_blank" class="faculty-item">

                            <span>
                                    <img src="/static/image/fak/faculty/skst.jpg" alt="">
                            </span>

                            <h1>Социально-культурного сервиса и туризма</h1>

                            <ul>
                                <li>
                                    <span>0</span>
                                    <span>Студентов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Откликов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Трудоустроено</span>
                                </li>
                            </ul>

                        </a>

                        <a href="/admin/statistics/?f=7" target="_blank" class="faculty-item">

                            <span>
                                    <img src="/static/image/fak/faculty/uchet.jpg" alt="">
                            </span>

                            <h1>Учетно-финансовый</h1>

                            <ul>
                                <li>
                                    <span>0</span>
                                    <span>Студентов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Откликов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Трудоустроено</span>
                                </li>
                            </ul>

                        </a>

                        <a href="/admin/statistics/?f=8" target="_blank" class="faculty-item">

                            <span>
                                    <img src="/static/image/fak/faculty/spo.jpg" alt="">
                            </span>

                            <h1>Среднего профессионального образования</h1>

                            <ul>
                                <li>
                                    <span>0</span>
                                    <span>Студентов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Откликов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Трудоустроено</span>
                                </li>
                            </ul>

                        </a>

                        <a href="/admin/statistics/?f=9" target="_blank" class="faculty-item">

                            <span>
                                    <img src="/static/image/fak/vetfak.jpg" alt="">
                            </span>

                            <h1>Ветеринарной медицины</h1>

                            <ul>
                                <li>
                                    <span>0</span>
                                    <span>Студентов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Откликов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Трудоустроено</span>
                                </li>
                            </ul>

                        </a>

                        <a href="/admin/statistics/?f=10" target="_blank" class="faculty-item">

                            <span>
                                    <img src="/static/image/fak/tehmenfak.jpg" alt="">
                            </span>

                            <h1>Биотехнологический</h1>

                            <ul>
                                <li>
                                    <span>0</span>
                                    <span>Студентов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Откликов</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span>Трудоустроено</span>
                                </li>
                            </ul>

                        </a>
                    </div>

                <?php } else { ?>

    <div class="chart-wrapper-block">


        <div class="al-stats" style="margin: 0 0 30px 0;">
            <ul>
                <li>
                    <div class="as-t">
                        <span class="as-tt">0</span>
                        <span class="as-tk">Просмотров</span>
                    </div>
                    <div class="as-i"><i class="icon-eye"></i></div>

                </li>
                <li>
                    <div class="as-t">
                        <span class="as-tt">0</span>
                        <span class="as-tk">Студентов</span>
                    </div>
                    <div class="as-i"><i class="icon-graduation"></i></div>

                </li>
                <li>
                    <div class="as-t">
                        <span class="as-tt">0</span>
                        <span class="as-tk">Трудоустроено</span>
                    </div>
                    <div class="as-i"><i class="icon-fire"></i></div>

                </li>
            </ul>
        </div>



        <div class="row sparkboxes mt-4">
            <div class="col-md-3">
                <div class="box box1">
                    <div class="details">
                        <h3>1213</h3>
                        <h4>CLICKS</h4>
                    </div>
                    <div id="spark1"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box box2">
                    <div class="details">
                        <h3>422</h3>
                        <h4>VIEWS</h4>
                    </div>
                    <div id="spark2"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box box3">
                    <div class="details">
                        <h3>311</h3>
                        <h4>LEADS</h4>
                    </div>
                    <div id="spark3"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box box4">
                    <div class="details">
                        <h3>22</h3>
                        <h4>SALES</h4>
                    </div>
                    <div id="spark4"></div>
                </div>
            </div>
        </div>



        <div class="analysis-manage-flex">
            <div class="block-result">
                <span>Просмотры за месяц <i class="fa-solid fa-minus"></i></span>
                <div class="chart">
                    <div id="views_1"></div>
                </div>
            </div>

            <div class="block-result">
                <span>Отклики за месяц <i class="fa-solid fa-minus"></i></span>
                <div class="chart">
                    <div id="views_2"></div>
                </div>
            </div>
        </div>

        <div class="analysis-manage-flex">
            <div class="block-result">
                <span>Самые частые категории <i class="fa-solid fa-minus"></i></span>
                <div class="chart">
                    <div id="views_4"></div>
                </div>
            </div>

            <div class="block-result">
                <span>Отказы по направлениям <i class="fa-solid fa-minus"></i></span>
                <div class="chart">
                    <div id="views_7"></div>
                </div>
            </div>

            <div class="block-result">
                <span>Самые частые компании <i class="fa-solid fa-minus"></i></span>
                <div class="chart">
                    <div id="views_3"></div>
                </div>
            </div>
        </div>

        <div class="block-al" style="margin: 0 0 30px 0">
            <span>Анализ #1 <i class="fa-solid fa-minus"></i></span>
            <div class="chart">
                <div id="views_5"></div>
            </div>
        </div>

        <div class="block-al" style="margin: 0 0 30px 0">
            <span>Анализ #2 <i class="fa-solid fa-minus"></i></span>
            <div class="chart">
                <div id="views_6"></div>
            </div>
        </div>

    </div>


                <?php  }?>


            </div>



        </section>

    </main>


    <?php require('admin/template/adminFooter.php'); ?>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.css" integrity="sha512-Ax++m07N1ygXmTSeRlQZnB5leVSw9eDeHQZ2ltn7oln1U3d+6d+/u1JEZ/zY/tLtmmEL741jEnDUlmWttBPLOA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js" integrity="sha512-K5BohS7O5E+S/W8Vjx4TIfTZfxe9qFoRXlOXEAWJD7MmOXhvsSl2hJihqc0O8tlIfcjrIkQXiBjixV8jgon9Uw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>




    <script>

        var randomizeArray = function (arg) {
            var array = arg.slice();
            var currentIndex = array.length, temporaryValue, randomIndex;

            while (0 !== currentIndex) {

                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex -= 1;

                temporaryValue = array[currentIndex];
                array[currentIndex] = array[randomIndex];
                array[randomIndex] = temporaryValue;
            }

            return array;
        }

        window.Apex = {
            chart: {
                foreColor: '#2a2a2a',
                toolbar: {
                    show: false
                },
            },
            stroke: {
                width: 3
            },
            tooltip: {
                theme: 'dark'
            },
            grid: {
                borderColor: "#e0e0e0",
                xaxis: {
                    lines: {
                        show: true
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#views_1"), {
            series: [{
                name: "Просмотры",
                data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
            }],
            chart: {
                height: 350,
                type: 'area',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
            }
        });
        chart.render();



        var chart = new ApexCharts(document.querySelector("#views_2"), {
            series: [{
                name: 'Отклики',
                data: [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13, 9, 17, 2, 7, 5]
            }],
            chart: {
                height: 350,
                type: 'line',
            },
            forecastDataPoints: {
                count: 7
            },
            stroke: {
                width: 5,
                curve: 'smooth'
            },
            xaxis: {
                type: 'datetime',
                categories: ['1/11/2000', '2/11/2000', '3/11/2000', '4/11/2000', '5/11/2000', '6/11/2000', '7/11/2000', '8/11/2000', '9/11/2000', '10/11/2000', '11/11/2000', '12/11/2000', '1/11/2001', '2/11/2001', '3/11/2001','4/11/2001' ,'5/11/2001' ,'6/11/2001'],
                tickAmount: 10,
                labels: {
                    formatter: function(value, timestamp, opts) {
                        return opts.dateFormatter(new Date(timestamp), 'dd MMM')
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    gradientToColors: [ '#FDD835'],
                    shadeIntensity: 1,
                    type: 'horizontal',
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100, 100, 100]
                },
            },
            yaxis: {
                min: -10,
                max: 40
            }
        });
        chart.render();



        var chart = new ApexCharts(document.querySelector("#views_3"), {
            series: [44, 55, 13, 43, 22],
            chart: {
                width: 380,
                type: 'pie',
            },
            labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
            responsive: [{
                breakpoint: 350,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        });
        chart.render();

        var chart = new ApexCharts(document.querySelector("#views_7"), {
            series: [25, 15, 44, 55, 41, 17],
            chart: {
                width: '100%',
                type: 'pie',
            },
            labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            theme: {
                monochrome: {
                    enabled: true
                }
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        offset: -5
                    }
                }
            },
            dataLabels: {
                formatter(val, opts) {
                    const name = opts.w.globals.labels[opts.seriesIndex]
                    return [name, val.toFixed(1) + '%']
                }
            },
            legend: {
                show: false
            }
        });
        chart.render();

        var chart = new ApexCharts(document.querySelector("#views_4"), {
            series: [{
                name: 'Series 1',
                data: [80, 50, 30, 40, 100, 20, 0, 50, 30, 40, 100, 20],
            }, {
                name: 'Series 2',
                data: [20, 30, 40, 80, 20, 80, 0, 50, 30, 40, 100, 20],
            }, {
                name: 'Series 3',
                data: [44, 76, 78, 13, 43, 10, 0, 50, 30, 40, 100, 20],
            }],
            chart: {
                height: 350,
                type: 'radar',
                dropShadow: {
                    enabled: true,
                    blur: 1,
                    left: 1,
                    top: 1
                }
            },
            stroke: {
                width: 2
            },
            fill: {
                opacity: 0.1
            },
            markers: {
                size: 0
            },
            xaxis: {
                categories: ['2011', '2012', '2013', '2014', '2015', '2016']
            }
        });
        chart.render();


        var chart = new ApexCharts(document.querySelector("#views_5"), {
            series: [{
                name: 'Income',
                type: 'column',
                data: [1.4, 2, 2.5, 1.5, 2.5, 2.8, 3.8, 4.6]
            }, {
                name: 'Cashflow',
                type: 'column',
                data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5]
            }, {
                name: 'Revenue',
                type: 'line',
                data: [20, 29, 37, 36, 44, 45, 50, 58]
            }],
            chart: {
                height: 350,
                type: 'line',
                stacked: false
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: [1, 1, 4]
            },
            xaxis: {
                categories: [2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016],
            },
            yaxis: [
                {
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: '#008FFB'
                    },
                    labels: {
                        style: {
                            colors: '#008FFB',
                        }
                    },
                    tooltip: {
                        enabled: true
                    }
                },
                {
                    seriesName: 'Income',
                    opposite: true,
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: '#00E396'
                    },
                    labels: {
                        style: {
                            colors: '#00E396',
                        }
                    },
                },
                {
                    seriesName: 'Revenue',
                    opposite: true,
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: '#FEB019'
                    },
                    labels: {
                        style: {
                            colors: '#FEB019',
                        },
                    },
                },
            ],
            tooltip: {
                fixed: {
                    enabled: true,
                    position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
                    offsetY: 30,
                    offsetX: 60
                },
            },
            legend: {
                horizontalAlign: 'left',
                offsetX: 40
            }
        });
        chart.render();

        var chart = new ApexCharts(document.querySelector("#views_6"), {
            series: [{
                name: 'TEAM A',
                type: 'column',
                data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30]
            }, {
                name: 'TEAM B',
                type: 'area',
                data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43]
            }, {
                name: 'TEAM C',
                type: 'line',
                data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39]
            }],
            chart: {
                height: 350,
                type: 'line',
                stacked: false,
            },
            stroke: {
                width: [0, 2, 5],
                curve: 'smooth'
            },
            plotOptions: {
                bar: {
                    columnWidth: '50%'
                }
            },

            fill: {
                opacity: [0.85, 0.25, 1],
                gradient: {
                    inverseColors: false,
                    shade: 'light',
                    type: "vertical",
                    opacityFrom: 0.85,
                    opacityTo: 0.55,
                    stops: [0, 100, 100, 100]
                }
            },
            labels: ['01/01/2003', '02/01/2003', '03/01/2003', '04/01/2003', '05/01/2003', '06/01/2003', '07/01/2003',
                '08/01/2003', '09/01/2003', '10/01/2003', '11/01/2003'
            ],
            markers: {
                size: 0
            },
            xaxis: {
                type: 'datetime'
            },
            yaxis: {
                title: {
                    text: 'Points',
                },
                min: 0
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function (y) {
                        if (typeof y !== "undefined") {
                            return y.toFixed(0) + " points";
                        }
                        return y;

                    }
                }
            }
        });
        chart.render();


        var spark1 = {
            chart: {
                id: 'spark1',
                group: 'sparks',
                type: 'line',
                height: 80,
                sparkline: {
                    enabled: true
                },
                dropShadow: {
                    enabled: true,
                    top: 1,
                    left: 1,
                    blur: 2,
                    opacity: 0.2,
                }
            },
            series: [{
                data: [25, 66, 41, 59, 25, 44, 12, 36, 9, 21]
            }],
            stroke: {
                curve: 'smooth'
            },
            markers: {
                size: 0
            },
            grid: {
                padding: {
                    top: 20,
                    bottom: 10,
                    left: 110
                }
            },
            colors: ['#fff'],
            tooltip: {
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function formatter(val) {
                            return '';
                        }
                    }
                }
            }
        }

        var spark2 = {
            chart: {
                id: 'spark2',
                group: 'sparks',
                type: 'line',
                height: 80,
                sparkline: {
                    enabled: true
                },
                dropShadow: {
                    enabled: true,
                    top: 1,
                    left: 1,
                    blur: 2,
                    opacity: 0.2,
                }
            },
            series: [{
                data: [12, 14, 2, 47, 32, 44, 14, 55, 41, 69]
            }],
            stroke: {
                curve: 'smooth'
            },
            grid: {
                padding: {
                    top: 20,
                    bottom: 10,
                    left: 110
                }
            },
            markers: {
                size: 0
            },
            colors: ['#fff'],
            tooltip: {
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function formatter(val) {
                            return '';
                        }
                    }
                }
            }
        }

        var spark3 = {
            chart: {
                id: 'spark3',
                group: 'sparks',
                type: 'line',
                height: 80,
                sparkline: {
                    enabled: true
                },
                dropShadow: {
                    enabled: true,
                    top: 1,
                    left: 1,
                    blur: 2,
                    opacity: 0.2,
                }
            },
            series: [{
                data: [47, 45, 74, 32, 56, 31, 44, 33, 45, 19]
            }],
            stroke: {
                curve: 'smooth'
            },
            markers: {
                size: 0
            },
            grid: {
                padding: {
                    top: 20,
                    bottom: 10,
                    left: 110
                }
            },
            colors: ['#fff'],
            xaxis: {
                crosshairs: {
                    width: 1
                },
            },
            tooltip: {
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function formatter(val) {
                            return '';
                        }
                    }
                }
            }
        }

        var spark4 = {
            chart: {
                id: 'spark4',
                group: 'sparks',
                type: 'line',
                height: 80,
                sparkline: {
                    enabled: true
                },
                dropShadow: {
                    enabled: true,
                    top: 1,
                    left: 1,
                    blur: 2,
                    opacity: 0.2,
                }
            },
            series: [{
                data: [15, 75, 47, 65, 14, 32, 19, 54, 44, 61]
            }],
            stroke: {
                curve: 'smooth'
            },
            markers: {
                size: 0
            },
            grid: {
                padding: {
                    top: 20,
                    bottom: 10,
                    left: 110
                }
            },
            colors: ['#fff'],
            xaxis: {
                crosshairs: {
                    width: 1
                },
            },
            tooltip: {
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function formatter(val) {
                            return '';
                        }
                    }
                }
            }
        }

        new ApexCharts(document.querySelector("#spark1"), spark1).render();
        new ApexCharts(document.querySelector("#spark2"), spark2).render();
        new ApexCharts(document.querySelector("#spark3"), spark3).render();
        new ApexCharts(document.querySelector("#spark4"), spark4).render();


    </script>


    </body>
    </html>
    <?php
} else {
    $app->notFound();
}
?>