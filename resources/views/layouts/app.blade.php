<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>Tiny Dashboard - A Bootstrap Dashboard Template</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css') }}/simplebar.css">
    <!-- Fonts CSS -->
    <link
        href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css') }}/feather.css">
    <link rel="stylesheet" href="{{ asset('assets/css') }}/select2.css">
    <link rel="stylesheet" href="{{ asset('assets/css') }}/dropzone.css">
    <link rel="stylesheet" href="{{ asset('assets/css') }}/uppy.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css') }}/jquery.steps.css">
    <link rel="stylesheet" href="{{ asset('assets/css') }}/jquery.timepicker.css">
    <link rel="stylesheet" href="{{ asset('assets/css') }}/quill.snow.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css') }}/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css') }}/app-light.css" id="lightTheme">
    <link rel="stylesheet" href="{{ asset('assets/css') }}/app-dark.css" id="darkTheme" disabled>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<style>
    .card {
        border-radius: 16px;
    }
</style>

<body class="vertical  light  ">
    <div class="wrapper">
        <nav class="topnav navbar navbar-light">
            <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
                <i class="fe fe-menu navbar-toggler-icon"></i>
            </button>
            <form class="form-inline mr-auto searchform text-muted">
                <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search"
                    placeholder="Type something..." aria-label="Search">
            </form>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="light">
                        <i class="fe fe-sun fe-16"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink"
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="avatar avatar-sm mt-2">
                            <img src="./assets/img/avatars/face-1.jpg" alt="..." class="avatar-img rounded-circle">
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activities</a>
                    </div>
                </li>
            </ul>
        </nav>
        <aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
            <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3"
                data-toggle="toggle">
                <i class="fe fe-x"><span class="sr-only"></span></i>
            </a>
            <nav class="vertnav navbar navbar-light">
                <!-- nav bar -->
                <div class="w-100 mb-4 d-flex">
                    <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
                        <svg version="1.1" id="logo" class="navbar-brand-img brand-sm"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                            y="0px" viewBox="0 0 120 120" xml:space="preserve">
                            <g>
                                <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                                <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                                <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                            </g>
                        </svg>
                    </a>
                </div>
                <ul class="navbar-nav flex-fill w-100 mb-2">
                    <li class="nav-item w-100">
                        <a class="nav-link {{ Request::is('home') ? 'text-primary fw-bold' : '' }}" href="/home">
                            <i class="fe fe-home fe-16"></i>
                            <span class="ml-3 item-text">Dashboard</span>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav flex-fill w-100 mb-2">
                    <li class="nav-item w-100">
                        <a class="nav-link {{ Request::is('pos') ? 'text-primary fw-bold' : '' }}" href="/pos">
                            <i class="fe fe-shopping-cart fe-16"></i>
                            <span class="ml-3 item-text">POS</span>
                        </a>
                    </li>
                </ul>

                <p class="text-muted nav-heading mt-4 mb-1">
                    <span>Master</span>
                </p>

                <ul class="navbar-nav flex-fill w-100 mb-2">
                    <li class="nav-item w-100">
                        <a class="nav-link {{ Request::is('products*') ? 'text-primary fw-bold' : '' }}"
                            href="/products">
                            <i class="fe fe-package fe-16"></i>
                            <span class="ml-3 item-text">Produk</span>
                        </a>

                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link {{ Request::is('categories') ? 'text-primary fw-bold' : '' }}"
                            href="/categories">
                            <i class="fe fe-list fe-16"></i>
                            <span class="ml-3 item-text">Kategori Produk</span>
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link {{ Request::is('categories-expense*') ? 'text-primary fw-bold' : '' }}"
                            href="/categories-expense">
                            <i class="fe fe-list fe-16"></i>
                            <span class="ml-3 item-text">Kategori Pengeluaran</span>
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link  {{ Request::is('expenses*') ? 'text-primary fw-bold' : '' }}"
                            href="/expenses">
                            <i class="fe fe-credit-card fe-16"></i>
                            <span class="ml-3 item-text">Pengeluaran</span>
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link {{ Request::is('product-incomes*') ? 'text-primary fw-bold' : '' }}"
                            href="/product-incomes">
                            <i class="fe fe-shopping-cart fe-16"></i>
                            <span class="ml-3 item-text">Belanja</span>
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link {{ Request::is('transactions*') ? 'text-primary fw-bold' : '' }}"
                            href="/transactions">
                            <i class="fe fe-credit-card fe-16"></i>
                            <span class="ml-3 item-text">Transaksi</span>
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link" {{ Request::is('report*') ? 'text-primary fw-bold' : '' }}
                            href="/report">
                            <i class="fe fe-bar-chart fe-16"></i>
                            <span class="ml-3 item-text">Laporan</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="row align-items-center mb-2">
                            <div class="col">
                                <h2 class="h5 page-title">@yield('title', 'welcome')</h2>
                            </div>
                        </div>
                        @yield('content')

                    </div> <!-- .col-12 -->
                </div> <!-- .row -->
            </div>
        </main>
    </div>
    <script src="{{ asset('assets/js') }}/jquery.min.js"></script>
    <script src="{{ asset('assets/js') }}/popper.min.js"></script>
    <script src="{{ asset('assets/js') }}/moment.min.js"></script>
    <script src="{{ asset('assets/js') }}/bootstrap.min.js"></script>
    <script src="{{ asset('assets/js') }}/simplebar.min.js"></script>
    <script src='{{ asset('assets/js') }}/daterangepicker.js'></script>
    <script src='{{ asset('assets/js') }}/jquery.stickOnScroll.js'></script>
    <script src="{{ asset('assets/js') }}/tinycolor-min.js"></script>
    <script src="{{ asset('assets/js') }}/config.js"></script>
    <script src="{{ asset('assets/js') }}/d3.min.js"></script>
    <script src="{{ asset('assets/js') }}/topojson.min.js"></script>
    <script src="{{ asset('assets/js') }}/datamaps.all.min.js"></script>
    <script src="{{ asset('assets/js') }}/datamaps-zoomto.js"></script>
    <script src="{{ asset('assets/js') }}/datamaps.custom.js"></script>
    <script src="{{ asset('assets/js') }}/Chart.min.js"></script>
    <script>
        /* defind global options */
        Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
        Chart.defaults.global.defaultFontColor = colors.mutedColor;
    </script>
    <script src="{{ asset('assets/js') }}/gauge.min.js"></script>
    <script src="{{ asset('assets/js') }}/jquery.sparkline.min.js"></script>
    <script src="{{ asset('assets/js') }}/apexcharts.min.js"></script>
    <script src="{{ asset('assets/js') }}/apexcharts.custom.js"></script>
    <script src='{{ asset('assets/js') }}/jquery.mask.min.js'></script>
    <script src='{{ asset('assets/js') }}/select2.min.js'></script>
    <script src='{{ asset('assets/js') }}/jquery.steps.min.js'></script>
    <script src='{{ asset('assets/js') }}/jquery.validate.min.js'></script>
    <script src='{{ asset('assets/js') }}/jquery.timepicker.js'></script>
    <script src='{{ asset('assets/js') }}/dropzone.min.js'></script>
    <script src='{{ asset('assets/js') }}/uppy.min.js'></script>
    <script src='{{ asset('assets/js') }}/quill.min.js'></script>
    <script>
        $('.select2').select2({
            theme: 'bootstrap4',
        });
        $('.select2-multi').select2({
            multiple: true,
            theme: 'bootstrap4',
        });
        $('.drgpicker').daterangepicker({
            singleDatePicker: true,
            timePicker: false,
            showDropdowns: true,
            locale: {
                format: 'MM/DD/YYYY'
            }
        });
        $('.time-input').timepicker({
            'scrollDefault': 'now',
            'zindex': '9999' /* fix modal open */
        });
        /** date range picker */
        if ($('.datetimes').length) {
            $('.datetimes').daterangepicker({
                timePicker: true,
                startDate: moment().startOf('hour'),
                endDate: moment().startOf('hour').add(32, 'hour'),
                locale: {
                    format: 'M/DD hh:mm A'
                }
            });
        }
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                    'month')]
            }
        }, cb);
        cb(start, end);
        $('.input-placeholder').mask("00/00/0000", {
            placeholder: "__/__/____"
        });
        $('.input-zip').mask('00000-000', {
            placeholder: "____-___"
        });
        $('.input-money').mask("#.##0,00", {
            reverse: true
        });
        $('.input-phoneus').mask('(000) 000-0000');
        $('.input-mixed').mask('AAA 000-S0S');
        $('.input-ip').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
            translation: {
                'Z': {
                    pattern: /[0-9]/,
                    optional: true
                }
            },
            placeholder: "___.___.___.___"
        });
        // editor
        var editor = document.getElementById('editor');
        if (editor) {
            var toolbarOptions = [
                [{
                    'font': []
                }],
                [{
                    'header': [1, 2, 3, 4, 5, 6, false]
                }],
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{
                        'header': 1
                    },
                    {
                        'header': 2
                    }
                ],
                [{
                        'list': 'ordered'
                    },
                    {
                        'list': 'bullet'
                    }
                ],
                [{
                        'script': 'sub'
                    },
                    {
                        'script': 'super'
                    }
                ],
                [{
                        'indent': '-1'
                    },
                    {
                        'indent': '+1'
                    }
                ], // outdent/indent
                [{
                    'direction': 'rtl'
                }], // text direction
                [{
                        'color': []
                    },
                    {
                        'background': []
                    }
                ], // dropdown with defaults from theme
                [{
                    'align': []
                }],
                ['clean'] // remove formatting button
            ];
            var quill = new Quill(editor, {
                modules: {
                    toolbar: toolbarOptions
                },
                theme: 'snow'
            });
        }
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
    <script>
        var uptarg = document.getElementById('drag-drop-area');
        if (uptarg) {
            var uppy = Uppy.Core().use(Uppy.Dashboard, {
                inline: true,
                target: uptarg,
                proudlyDisplayPoweredByUppy: false,
                theme: 'dark',
                width: 770,
                height: 210,
                plugins: ['Webcam']
            }).use(Uppy.Tus, {
                endpoint: 'https://master.tus.io/files/'
            });
            uppy.on('complete', (result) => {
                console.log('Upload complete! We’ve uploaded these files:', result.successful)
            });
        }
    </script>
    <script src="{{ asset('assets/js') }}/apps.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('{{ asset('assets/js') }}', new Date());
        gtag('config', 'UA-56159088-1');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
    @if (session('success') || session('error'))
        <script>
            $(document).ready(function() {
                var successMessage = "{{ session('success') }}";
                var errorMessage = "{{ session('error') }}";

                if (successMessage) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: successMessage,
                    });
                }

                if (errorMessage) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                    });
                }
            });
        </script>
    @endif
</body>

</html>
