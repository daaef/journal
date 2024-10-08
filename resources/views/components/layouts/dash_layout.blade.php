<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $title ?? 'JAPR Website' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- file upload -->
    <link rel="stylesheet" href="{{ asset('css/file-upload.css') }}">
    <!-- file upload -->
    <link rel="stylesheet" href="{{ asset('css/plyr.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <!-- full calendar -->
    <link rel="stylesheet" href="{{ asset('css/full-calendar.css') }}">
    <!-- jquery Ui -->
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <!-- editor quill Ui -->
    <link rel="stylesheet" href="{{ asset('css/editor-quill.css') }}">
    <!-- apex charts Css -->
    <link rel="stylesheet" href="{{ asset('css/apexcharts.css') }}">
    <!-- calendar Css -->
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <!-- jvector map Css -->
    <link rel="stylesheet" href="{{ asset('css/jquery-jvectormap-2.0.5.css') }}">
    {{--    @vite('resources/sass/main.scss')--}}
    @vite(['resources/js/app.js', 'resources/sass/main.scss'])
</head>
<body>
<aside class="sidebar">
    <!-- sidebar close btn -->
    <button type="button"
            class="sidebar-close-btn text-gray-500 hover-text-white hover-bg-main-600 text-md w-24 h-24 border border-gray-100 hover-border-main-600 d-xl-none d-flex flex-center rounded-circle position-absolute">
        <i
            class="ph ph-x"></i></button>
    <!-- sidebar close btn -->

    <a href="{{route('dashboard')}}"
       class="sidebar__logo text-center p-20 position-sticky inset-block-start-0 bg-white w-100 z-1 pb-10">
        <img class="w-25s" src="{{ asset('images/japr-logo.png') }}" alt="Logo">
    </a>

    <div class="sidebar-menu-wrapper overflow-y-auto scroll-sm">
        <div class="p-20 pt-10">
            <ul class="sidebar-menu">
                <li class="sidebar-menu__item">
                    <a href="javascript:void(0)" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-squares-four"></i></span>
                        <span class="text">Dashboard</span>
                        {{-- <span class="link-badge">3</span> --}}
                    </a>
                    <!-- Submenu End -->
                </li>
                <li class="sidebar-menu__item">
                    <a href="{{ route('categories.index') }}" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-squares-four"></i></span>
                        <span class="text">Categories</span>
                        {{-- <span class="link-badge">3</span> --}}
                    </a>
                    <!-- Submenu End -->
                </li>
                <li class="sidebar-menu__item">
                            <span
                                class="text-gray-300 text-sm px-20 pt-20 fw-semibold border-top border-gray-100 d-block text-uppercase">Settings</span>
                </li>
                <li class="sidebar-menu__item">
                    <a href="" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-gear"></i></span>
                        <span class="text">Account Settings</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

</aside>

<div class="dashboard-main-wrapper">

    <div class="top-navbar flex-between gap-16">

        <div class="flex-align gap-16">
            <!-- Toggle Button Start -->
            <button type="button" class="toggle-btn d-xl-none d-flex text-26 text-gray-500"><i
                    class="ph ph-list"></i></button>
            <!-- Toggle Button End -->

            <form action="#" class="w-350 d-sm-block d-none">
                <div class="position-relative">
                    <button type="submit" class="input-icon text-xl d-flex text-gray-100 pointer-event-none"><i
                            class="ph ph-magnifying-glass"></i></button>
                    <input type="text"
                           class="form-control ps-40 h-40 border-transparent focus-border-main-600 bg-main-50 rounded-pill placeholder-15"
                           placeholder="Search...">
                </div>
            </form>
        </div>

        <div class="flex-align gap-16">
            <!-- User Profile Start -->
            <div class="dropdown">
                <button
                    class="users arrow-down-icon border border-gray-200 rounded-pill p-4 d-inline-block pe-40 position-relative"
                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Str::words(auth()->user()->fullname, 1, '') }}
                </button>
                <div class="dropdown-menu dropdown-menu--lg border-0 bg-transparent p-0">
                    <div class="card border border-gray-100 rounded-12 box-shadow-custom">
                        <div class="card-body">
                            <div class="flex-align gap-8 mb-20 pb-20 border-bottom border-gray-100">
                                <img src="assets/images/thumbs/user-img.png" alt=""
                                     class="w-54 h-54 rounded-circle">
                                <div class="">
                                    <h4 class="mb-0">{{ auth()->user()->fullname }}</h4>
                                    <p class="fw-medium text-13 text-gray-200">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                            <ul class="max-h-270 overflow-y-auto scroll-sm pe-4">
                                <li class="mb-4">
                                    <a href="setting.html"
                                       class="py-12 text-15 px-20 hover-bg-gray-50 text-gray-300 rounded-8 flex-align gap-8 fw-medium text-15">
                                            <span class="text-2xl text-primary-600 d-flex"><i
                                                    class="ph ph-gear"></i></span>
                                        <span class="text">Account Settings</span>
                                    </a>
                                </li>
                                <li class="mb-4">
                                    <a href="pricing-plan.html"
                                       class="py-12 text-15 px-20 hover-bg-gray-50 text-gray-300 rounded-8 flex-align gap-8 fw-medium text-15">
                                            <span class="text-2xl text-primary-600 d-flex"><i
                                                    class="ph ph-chart-bar"></i></span>
                                        <span class="text">Upgrade Plan</span>
                                    </a>
                                </li>
                                <li class="mb-4">
                                    <a href="analytics.html"
                                       class="py-12 text-15 px-20 hover-bg-gray-50 text-gray-300 rounded-8 flex-align gap-8 fw-medium text-15">
                                            <span class="text-2xl text-primary-600 d-flex"><i
                                                    class="ph ph-chart-line-up"></i></span>
                                        <span class="text">Daily Activity</span>
                                    </a>
                                </li>
                                <li class="mb-4">
                                    <a href="message.html"
                                       class="py-12 text-15 px-20 hover-bg-gray-50 text-gray-300 rounded-8 flex-align gap-8 fw-medium text-15">
                                            <span class="text-2xl text-primary-600 d-flex"><i
                                                    class="ph ph-chats-teardrop"></i></span>
                                        <span class="text">Inbox</span>
                                    </a>
                                </li>
                                <li class="mb-4">
                                    <a href="email.html"
                                       class="py-12 text-15 px-20 hover-bg-gray-50 text-gray-300 rounded-8 flex-align gap-8 fw-medium text-15">
                                            <span class="text-2xl text-primary-600 d-flex"><i
                                                    class="ph ph-envelope-simple"></i></span>
                                        <span class="text">Email</span>
                                    </a>
                                </li>
                                <li class="pt-8 border-top border-gray-100">
                                    <a href="sign-in.html"
                                       class="py-12 text-15 px-20 hover-bg-danger-50 text-gray-300 hover-text-danger-600 rounded-8 flex-align gap-8 fw-medium text-15">
                                            <span class="text-2xl text-danger-600 d-flex"><i
                                                    class="ph ph-sign-out"></i></span>
                                        <span class="text">Log Out</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- User Profile Start -->

        </div>
    </div>


    <div class="dashboard-body">

        <div class="row gy-4">
            <div class="col-lg-9">
                {{ $slot }}
            </div>
            <div class="col-lg-3">

                <!-- Calendar Start -->
                <div class="card">
                    <div class="card-body">
                        <div class="calendar">
                            <div class="calendar__header">
                                <button type="button" class="calendar__arrow left"><i
                                        class="ph ph-caret-left"></i></button>
                                <p class="display h6 mb-0">""</p>
                                <button type="button" class="calendar__arrow right"><i
                                        class="ph ph-caret-right"></i></button>
                            </div>

                            <div class="calendar__week week">
                                <div class="calendar__week-text">Su</div>
                                <div class="calendar__week-text">Mo</div>
                                <div class="calendar__week-text">Tu</div>
                                <div class="calendar__week-text">We</div>
                                <div class="calendar__week-text">Th</div>
                                <div class="calendar__week-text">Fr</div>
                                <div class="calendar__week-text">Sa</div>
                            </div>
                            <div class="days"></div>
                        </div>                      <!-- Events End -->
                    </div>
                </div>
                <!-- Calendar End -->
            </div>
        </div>
    </div>

    <div class="dashboard-footer">
        <div class="flex-center flex-wrap gap-16">
            <p class="text-gray-300 text-13 fw-normal"> &copy; Copyright JAPR 2024, All Right Reserverd</p>
        </div>
    </div>
</div>
<!-- Jquery js -->
<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
<!-- Bootstrap Bundle Js -->
<script src="{{ asset('js/boostrap.bundle.min.js') }}"></script>
<!-- Phosphor Js -->
<script src="{{ asset('js/phosphor-icon.js') }}"></script>
<!-- file upload -->
<script src="{{ asset('js/file-upload.js') }}"></script>
<!-- file upload -->
<script src="{{ asset('js/plyr.js') }}"></script>
<!-- dataTables -->
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<!-- full calendar -->
<script src="{{ asset('js/full-calendar.js') }}"></script>
<!-- jQuery UI -->
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<!-- jQuery UI -->
<script src="{{ asset('js/editor-quill.js') }}"></script>
<!-- apex charts -->
<script src="{{ asset('js/apexcharts.min.js') }}"></script>
<!-- Calendar Js -->
<script src="{{ asset('js/calendar.js') }}"></script>
<!-- jvectormap Js -->
<script src="{{ asset('js/jquery-jvectormap-2.0.5.min.js') }}"></script>
<!-- jvectormap world Js -->
<script src="{{ asset('js/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- main js -->
<script src="{{ asset('js/main.js') }}"></script>
<script src="./node_modules/preline/dist/preline.js"></script>
<script>
    function createChart(chartId, chartColor) {

        let currentYear = new Date().getFullYear();

        var options = {
            series: [
                {
                    name: 'series1',
                    data: [18, 25, 22, 40, 34, 55, 50, 60, 55, 65],
                },
            ],
            chart: {
                type: 'area',
                width: 80,
                height: 42,
                sparkline: {
                    enabled: true // Remove whitespace
                },

                toolbar: {
                    show: false
                },
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 1,
                colors: [chartColor],
                lineCap: 'round'
            },
            grid: {
                show: true,
                borderColor: 'transparent',
                strokeDashArray: 0,
                position: 'back',
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
                row: {
                    colors: undefined,
                    opacity: 0.5
                },
                column: {
                    colors: undefined,
                    opacity: 0.5
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0
                },
            },
            fill: {
                type: 'gradient',
                colors: [chartColor], // Set the starting color (top color) here
                gradient: {
                    shade: 'light', // Gradient shading type
                    type: 'vertical',  // Gradient direction (vertical)
                    shadeIntensity: 0.5, // Intensity of the gradient shading
                    gradientToColors: [`${chartColor}00`], // Bottom gradient color (with transparency)
                    inverseColors: false, // Do not invert colors
                    opacityFrom: .5, // Starting opacity
                    opacityTo: 0.3,  // Ending opacity
                    stops: [0, 100],
                },
            },
            // Customize the circle marker color on hover
            markers: {
                colors: [chartColor],
                strokeWidth: 2,
                size: 0,
                hover: {
                    size: 8
                }
            },
            xaxis: {
                labels: {
                    show: false
                },
                categories: [`Jan ${currentYear}`, `Feb ${currentYear}`, `Mar ${currentYear}`, `Apr ${currentYear}`, `May ${currentYear}`, `Jun ${currentYear}`, `Jul ${currentYear}`, `Aug ${currentYear}`, `Sep ${currentYear}`, `Oct ${currentYear}`, `Nov ${currentYear}`, `Dec ${currentYear}`],
                tooltip: {
                    enabled: false,
                },
            },
            yaxis: {
                labels: {
                    show: false
                }
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            },
        };

        var chart = new ApexCharts(document.querySelector(`#${chartId}`), options);
        chart.render();
    }

    // Call the function for each chart with the desired ID and color
    createChart('complete-course', '#2FB2AB');
    createChart('earned-certificate', '#27CFA7');
    createChart('course-progress', '#6142FF');
    createChart('community-support', '#FA902F');


    // =========================== Double Line Chart Start ===============================
    function createLineChart(chartId, chartColor) {
        var options = {
            series: [
                {
                    name: 'Study',
                    data: [8, 15, 9, 20, 10, 33, 13, 22, 8, 17, 10, 15],
                },
                {
                    name: 'Test',
                    data: [8, 24, 18, 40, 18, 48, 22, 38, 18, 30, 20, 28],
                },
            ],
            chart: {
                type: 'area',
                width: '100%',
                height: 300,
                sparkline: {
                    enabled: false // Remove whitespace
                },
                toolbar: {
                    show: false
                },
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            colors: ['#3D7FF9', chartColor],  // Set the color of the series
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: 'smooth',
                width: 1,
                colors: ["#3D7FF9", chartColor],
                lineCap: 'round',
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.9,  // Decrease this value to reduce opacity
                    opacityTo: 0.2,    // Decrease this value to reduce opacity
                    stops: [0, 100]
                }
            },
            grid: {
                show: true,
                borderColor: '#E6E6E6',
                strokeDashArray: 3,
                position: 'back',
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: true
                    }
                },
                row: {
                    colors: undefined,
                    opacity: 0.5
                },
                column: {
                    colors: undefined,
                    opacity: 0.5
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0
                },
            },
            // Customize the circle marker color on hover
            markers: {
                colors: ["#3D7FF9", chartColor],
                strokeWidth: 3,
                size: 0,
                hover: {
                    size: 8
                }
            },
            xaxis: {
                labels: {
                    show: false
                },
                categories: [`Jan`, `Feb`, `Mar`, `Apr`, `May`, `Jun`, `Jul`, `Aug`, `Sep`, `Oct`, `Nov`, `Dec`],
                tooltip: {
                    enabled: false,
                },
                labels: {
                    formatter: function (value) {
                        return value;
                    },
                    style: {
                        fontSize: "14px"
                    }
                },
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return "$" + value + "Hr";
                    },
                    style: {
                        fontSize: "14px"
                    }
                },
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            },
            legend: {
                show: false,
                position: 'top',
                horizontalAlign: 'right',
                offsetX: -10,
                offsetY: -0
            }
        };

        var chart = new ApexCharts(document.querySelector(`#${chartId}`), options);
        chart.render();
    }

    createLineChart('doubleLineChart', '#27CFA7');
    // =========================== Double Line Chart End ===============================

    // ================================= Multiple Radial Bar Chart Start =============================
    var options = {
        series: [100, 60, 25],
        chart: {
            height: 172,
            type: 'radialBar',
        },
        colors: ['#3D7FF9', '#27CFA7', '#020203'],
        stroke: {
            lineCap: 'round',
        },
        plotOptions: {
            radialBar: {
                hollow: {
                    size: '30%',  // Adjust this value to control the bar width
                },
                dataLabels: {
                    name: {
                        fontSize: '16px',
                    },
                    value: {
                        fontSize: '16px',
                    },
                    total: {
                        show: true,
                        formatter: function (w) {
                            return '82%'
                        }
                    }
                }
            }
        },
        labels: ['Completed', 'In Progress', 'Not Started'],
    };

    var chart = new ApexCharts(document.querySelector("#radialMultipleBar"), options);
    chart.render();
    // ================================= Multiple Radial Bar Chart End =============================

    // ========================== Export Js Start ==============================
    document.getElementById('exportOptions').addEventListener('change', function () {
        const format = this.value;
        const table = document.getElementById('studentTable');
        let data = [];
        const headers = [];

        // Get the table headers
        table.querySelectorAll('thead th').forEach(th => {
            headers.push(th.innerText.trim());
        });

        // Get the table rows
        table.querySelectorAll('tbody tr').forEach(tr => {
            const row = {};
            tr.querySelectorAll('td').forEach((td, index) => {
                row[headers[index]] = td.innerText.trim();
            });
            data.push(row);
        });

        if (format === 'csv') {
            downloadCSV(data);
        } else if (format === 'json') {
            downloadJSON(data);
        }
    });

    function downloadCSV(data) {
        const csv = data.map(row => Object.values(row).join(',')).join('\n');
        const blob = new Blob([csv], {type: 'text/csv'});
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'students.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }

    function downloadJSON(data) {
        const json = JSON.stringify(data, null, 2);
        const blob = new Blob([json], {type: 'application/json'});
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'students.json';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }

    // ========================== Export Js End ==============================
    window.HSStaticMethods.autoInit();
</script>
<script>
    @if (Session::has('message'))
    const type = "{{ Session::get('alert-type', 'info') }}";
    switch (type) {
        case 'info':

            toastr.options.timeOut = 10000;
            toastr.info("{{ Session::get('message') }}");
            var audio = new Audio('audio.mp3');
            audio.play();
            break;
        case 'success':

            toastr.options.timeOut = 10000;
            toastr.success("{{ Session::get('message') }}");
            var audio = new Audio('audio.mp3');
            audio.play();

            break;
        case 'warning':

            toastr.options.timeOut = 10000;
            toastr.warning("{{ Session::get('message') }}");
            var audio = new Audio('audio.mp3');
            audio.play();

            break;
        case 'error':

            toastr.options.timeOut = 10000;
            toastr.error("{{ Session::get('message') }}");
            var audio = new Audio('audio.mp3');
            audio.play();

            break;
    }
    @endif
</script>
</body>
</html>
