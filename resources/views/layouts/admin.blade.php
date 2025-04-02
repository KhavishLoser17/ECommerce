<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Information System</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="stylesheet" type="text/css" href="{{asset('css/animate.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/animation.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('font/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('icon/style.css')}}">
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('images/favicon.ico')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/sweetalert.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.js"></script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css' rel='stylesheet' />
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css' rel='stylesheet' />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        

    <meta name="author" content="Bestlink" />
      @stack("style")


</head>
<body class="body">
    <div id="wrapper">
        <div id="page" class="">
            <div class="layout-wrap">
                <div class="section-menu-left bg-sky-800">
                    <div class="box-logo flex items-center justify-center space-x-2">
                        <a href="{{ route('admin.index') }}" id="site-logo-inner" class="flex items-center space-x-2">
                            <img id="logo_header" alt="Bestlink College Logo"
                                src="{{ asset('images/logo/logo1.png') }}"
                                data-light="{{ asset('images/logo/logo1.png') }}"
                                data-dark="{{ asset('images/logo/logo.png') }}"
                                class="w-20 h-auto">
                            <span class="text-lg font-semibold ">Bestlink College of The Philippines</span>
                        </a>
                        <div class="button-show-hide">
                            <i class="icon-menu-left"></i>
                        </div>
                    </div>
                    <div class="center text-white">
                        <div class="center-item">
                            <div class="center-heading text-white text-xl font-bold">Main Home</div>
                            <ul class="menu-list">
                                <li class="menu-item">
                                    <a href="{{route('admin.index')}}" class="flex items-center space-x-3 py-3 px-4 text-3xl">
                                        <i class="fas fa-tachometer-alt text-3xl"></i>
                                        <span>Dashboard</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="center-item">
                            <ul class="menu-list">
                                <!-- Faculty Members Dropdown -->
                                <li class="menu-item group">
                                    <a href="#" class="flex items-center px-4 py-3 rounded-t-lg text-3xl">
                                        <i class="fas fa-users text-xl mr-3"></i>
                                        <span>Faculty Members</span>
                                    </a>
                                    <ul class="hidden group-hover:block rounded-b-lg">
                                        <li>
                                            <a href="{{route('admin.teacher')}}" class="flex items-center px-4 py-2  text-3xl">
                                                <i class="fas fa-chalkboard-teacher text-xl mr-3"></i> Teachers
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('admin.staff')}}" class="flex items-center px-4 py-2 text-3xl">
                                                <i class="fas fa-user-tie text-xl mr-3"></i> Staffs
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <!-- Other Menu Items -->
                                <li class="menu-item group">
                                    <a href="#" class="flex items-center px-4 py-3 rounded-t-lg text-3xl">
                                        <i class="fas fa-users text-xl mr-3"></i>
                                        <span>Schedules</span>
                                    </a>
                                    <ul class="hidden group-hover:block rounded-b-lg">
                                        <li>
                                            <a href="{{route('admin.faculty-attendance')}}" class="flex items-center px-4 py-2  text-3xl">
                                                <i class="fas fa-chalkboard-teacher text-xl mr-3"></i> Faculties Schedule
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('admin.schedule')}}" class="flex items-center px-4 py-2 text-3xl">
                                                <i class="fas fa-user-tie text-xl mr-3"></i> Announcement Schedule
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item">
                                    <a href="{{route('admin.makeup')}}" class="flex items-center space-x-3 py-3 text-3xl">
                                        <i class="fas fa-chalkboard text-2xl"></i>
                                        <span>Makeup-Class</span>
                                    </a>
                                </li>

                                <li class="menu-item">
                                    <a href="{{route('admin.event')}}" class="flex items-center space-x-3 py-3 text-3xl">
                                        <i class="fas fa-calendar-check text-2xl"></i>
                                        <span>Event Management</span>
                                    </a>
                                </li>

                                <li class="menu-item">
                                    <a href="#" class="flex items-center space-x-3 py-3 text-3xl">
                                        <i class="fas fa-money-bill-wave text-xl"></i>
                                        <span>Payroll</span>
                                    </a>
                                </li>

                                <!-- Logout -->
                                <li class="menu-item">
                                    <form method="POST" action="{{route('logout')}}" id="logout-form">
                                        @csrf
                                        <a href="{{route('logout')}}"
                                           class="flex items-center space-x-3 py-3 text-3xl"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt text-xl"></i>
                                            <span>Logout</span>
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="section-content-right">

                    <div class="header-dashboard">
                        <div class="wrap">
                            <div class="header-left">
                                <a href="index-2.html">
                                    <img class="" id="logo_header_mobile" alt="" src="images/logo/logo1.png"
                                        data-light="images/logo/logo1.png" data-dark="images/logo/logo1.png"
                                        data-width="154px" data-height="52px" data-retina="images/logo/logo1.png">
                                </a>
                                <div class="button-show-hide">
                                    <i class="icon-menu-left"></i>
                                </div>




                            </div>
                            <div class="header-grid">

                                <div class="popup-wrap message type-header">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="header-item">
                                                <span class="text-tiny">1</span>
                                                <i class="icon-bell"></i>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end has-content"
                                            aria-labelledby="dropdownMenuButton2">
                                            <li>
                                                <h6>Notifications</h6>
                                            </li>
                                            <li>
                                                <div class="message-item item-1">
                                                    <div class="image">
                                                        <i class="icon-noti-1"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Discount available</div>
                                                        <div class="text-tiny">Morbi sapien massa, ultricies at rhoncus
                                                            at, ullamcorper nec diam</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="message-item item-2">
                                                    <div class="image">
                                                        <i class="icon-noti-2"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Account has been verified</div>
                                                        <div class="text-tiny">Mauris libero ex, iaculis vitae rhoncus
                                                            et</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="message-item item-3">
                                                    <div class="image">
                                                        <i class="icon-noti-3"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Order shipped successfully</div>
                                                        <div class="text-tiny">Integer aliquam eros nec sollicitudin
                                                            sollicitudin</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="message-item item-4">
                                                    <div class="image">
                                                        <i class="icon-noti-4"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Order pending: <span>ID 305830</span>
                                                        </div>
                                                        <div class="text-tiny">Ultricies at rhoncus at ullamcorper</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li><a href="#" class="tf-button w-full">View all</a></li>
                                        </ul>
                                    </div>
                                </div>




                                <div class="popup-wrap user type-header">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="header-user wg-user">
                                                <span class="image rounded-sm w-50px">
                                                    <img src="{{asset('images/avatar/crim1.jpg')}}" alt="" class="w-50px">
                                                </span>
                                                {{-- <span class="flex flex-column">
                                                    <span class="body-title mb-2">{{ Auth::user()->name }}</span>
                                                    <span class="text-tiny">{{ Auth::user()->name}}</span>
                                                </span> --}}

                                            </span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end has-content"
                                            aria-labelledby="dropdownMenuButton3">
                                            <li>
                                                <a href="#" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-user"></i>
                                                    </div>
                                                    <div class="body-title-2">Account</div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-mail"></i>
                                                    </div>
                                                    <div class="body-title-2">Inbox</div>
                                                    <div class="number">27</div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-file-text"></i>
                                                    </div>
                                                    <div class="body-title-2">Taskboard</div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-headphones"></i>
                                                    </div>
                                                    <div class="body-title-2">Support</div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="login.html" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-log-out"></i>
                                                    </div>
                                                    <form method="POST" action="{{route('logout')}}" id="logout-form">
                                                        @csrf
                                                        <a href="{{route('logout')}}"
                                                           class="flex items-center space-x-2"
                                                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                            <div class="icon"><i class="icon-settings text-white"></i></div>
                                                            <div class="text">Logout</div>
                                                        </a>
                                                    </form>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="main-content">
                        @yield('content')
                        <div class="bottom-page fixed bottom-0 w-full bg-gray-100 text-center py-2">
                            <div class="body-text text-2xl text-gray-700">
                                Created by Students of Bestlink College of The Philippines
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('js/jquery.min.js') }}"></script>
    <script src="{{asset('js/bootstrap.min.js') }}"></script>
    <script src="{{asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{asset('js/sweetalert.min.js') }}"></script>
    <script src="{{asset('js/apexcharts/apexcharts.js') }}"></script>
    <script src="{{asset('js/main.js') }}"></script>
    <script>
        (function ($) {

            var tfLineChart = (function () {

                var chartBar = function () {

                    var options = {
                        series: [{
                            name: 'Total',
                            data: [0.00, 0.00, 0.00, 0.00, 0.00, 273.22, 208.12, 0.00, 0.00, 0.00, 0.00, 0.00]
                        }, {
                            name: 'Pending',
                            data: [0.00, 0.00, 0.00, 0.00, 0.00, 273.22, 208.12, 0.00, 0.00, 0.00, 0.00, 0.00]
                        },
                        {
                            name: 'Delivered',
                            data: [0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00]
                        }, {
                            name: 'Canceled',
                            data: [0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00]
                        }],
                        chart: {
                            type: 'bar',
                            height: 325,
                            toolbar: {
                                show: false,
                            },
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '10px',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        legend: {
                            show: false,
                        },
                        colors: ['#2377FC', '#FFA500', '#078407', '#FF0000'],
                        stroke: {
                            show: false,
                        },
                        xaxis: {
                            labels: {
                                style: {
                                    colors: '#212529',
                                },
                            },
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        },
                        yaxis: {
                            show: false,
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return "$ " + val + ""
                                }
                            }
                        }
                    };

                    chart = new ApexCharts(
                        document.querySelector("#line-chart-8"),
                        options
                    );
                    if ($("#line-chart-8").length > 0) {
                        chart.render();
                    }
                };

                /* Function ============ */
                return {
                    init: function () { },

                    load: function () {
                        chartBar();
                    },
                    resize: function () { },
                };
            })();

            jQuery(document).ready(function () { });

            jQuery(window).on("load", function () {
                tfLineChart.load();
            });

            jQuery(window).on("resize", function () { });
        })(jQuery);
    </script>
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.js'></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

    @stack("scripts")
</body>
</html>
