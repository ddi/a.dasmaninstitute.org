<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <base href="/" />
    <title>{{ $title ?? 'Medical' }}</title>
    <!-- include common vendor stylesheets & fontawesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('node_modules/bootstrap/dist/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('node_modules/@fortawesome/fontawesome-free/css/fontawesome.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('node_modules/@fortawesome/fontawesome-free/css/regular.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('node_modules/@fortawesome/fontawesome-free/css/brands.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('node_modules/@fortawesome/fontawesome-free/css/solid.css') }}">
    <!-- include vendor stylesheets used in "Dashboard" page. see "/views//pages/partials/dashboard/@vendor-stylesheets.hbs" -->
    <!-- include fonts -->
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/ace-font.css') }}">
    <!-- ace.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/ace.css') }}">
    <!-- favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/favicon.png') }}" />
    <!-- "Dashboard" page styles, specific to this page for demo only -->
    <link rel="stylesheet" type="text/css" href="{{ asset('views/pages/dashboard/@page-style.css') }}">
</head>

<body>
    <div class="body-container">
        <nav class="navbar navbar-expand-lg navbar-fixed navbar-blue">
            <div class="navbar-inner">
                <div class="navbar-intro justify-content-xl-between">
                    <a class="navbar-brand text-white" href="#">
                        <i class="fa fa-city"></i>
                        <span>Medical</span>
                        <span>Apps</span>
                    </a><!-- /.navbar-brand -->
                </div><!-- /.navbar-intro -->

                <!-- mobile #navbarMenu toggler button -->
                <button class="navbar-toggler ml-1 mr-2 px-1" type="button" data-toggle="collapse"
                    data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false"
                    aria-label="Toggle navbar menu">
                    <span class="pos-rel">
                        <img class="border-2 brc-white-tp1 radius-round" width="36"
                            src="{{ asset('assets/image/avatar/avatar6.jpg') }}" alt="Jason's Photo">
                        <span
                            class="bgc-warning radius-round border-2 brc-white p-1 position-tr mr-n1px mt-n1px"></span>
                    </span>
                </button>
                <div class="navbar-menu collapse navbar-collapse navbar-backdrop" id="navbarMenu">
                    <div class="navbar-nav">
                        <ul class="nav">
                            @auth
                                <li class="nav-item dropdown order-first order-lg-last">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                                        aria-haspopup="true" aria-expanded="false">
                                        <img id="id-navbar-user-image"
                                            class="d-none d-lg-inline-block radius-round border-2 brc-white-tp1 mr-2 w-6"
                                            src="assets/image/avatar/avatar6.jpg" alt="Jason's Photo">
                                        <span class="d-inline-block d-lg-none d-xl-inline-block">
                                            <span class="text-90" id="id-user-welcome">Welcome,</span>

                                            <span class="nav-user-name">{{ Auth::user()->username }}</span>

                                        </span>

                                        <i class="caret fa fa-angle-down d-none d-xl-block"></i>
                                        <i class="caret fa fa-angle-left d-block d-lg-none"></i>
                                    </a>

                                    <div
                                        class="dropdown-menu dropdown-caret dropdown-menu-right dropdown-animated brc-primary-m3 py-1">

                                        <a class="dropdown-item btn btn-outline-grey bgc-h-secondary-l3 btn-h-light-secondary btn-a-light-secondary"
                                            href="{{ route('logout') }}">
                                            <i class="fa fa-power-off text-warning-d1 text-105 mr-1"></i>
                                            Logout
                                        </a>
                                    </div>
                                </li><!-- /.nav-item:last -->
                            @endauth

                        </ul><!-- /.navbar-nav menu -->
                    </div><!-- /.navbar-nav -->

                </div><!-- /#navbarMenu -->


            </div><!-- /.navbar-inner -->
        </nav>
        <div class="main-container bgc-white">
            <div id="sidebar" class="sidebar sidebar-fixed expandable sidebar-light">
                <div class="sidebar-inner">
                    <div class="ace-scroll flex-grow-1" data-ace-scroll="{}">
                        <ul class="nav has-active-border active-on-right">
                            <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                                <a href="{{ route('home') }}" class="nav-link">
                                    <i class="nav-icon fa fa-tachometer-alt"></i>
                                    <span class="nav-text fadeable">
                                        <span>Dashboard</span>
                                    </span>
                                </a>
                                <b class="sub-arrow"></b>
                            </li>
                            @auth
                                <li class="nav-item-caption">
                                    <span class="fadeable pl-3">Gate log</span>
                                    <span class="fadeinable mt-n2 text-125">&hellip;</span>
                                </li>
                                <li class="nav-item {{ request()->routeIs('employees.index') ? 'active' : '' }}">
                                    <a href="{{ route('employees.index') }}" class="nav-link">
                                        <i class="nav-icon fa fa-tachometer-alt"></i>
                                        <span class="nav-text fadeable">
                                            <span>
                                                Employees list
                                            </span>
                                        </span>
                                    </a>
                                    <b class="sub-arrow"></b>
                                </li>
                                <li class="nav-item {{ request()->routeIs('instrument.index') ? 'active' : '' }}">
                                    <a href="{{ route('employees.index') }}" class="nav-link">
                                        <i class="nav-icon fa fa-tachometer-alt"></i>
                                        <span class="nav-text fadeable">
                                            <span>
                                                Departments list
                                            </span>
                                        </span>
                                    </a>
                                    <b class="sub-arrow"></b>
                                </li>
                            @else
                                <li class="nav-item ">
                                    <a href="" class="nav-link">
                                        <i class="nav-icon fa fa-tachometer-alt"></i>
                                        <span class="nav-text fadeable">
                                            <span>
                                                Register
                                            </span>
                                        </span>
                                    </a>
                                    <b class="sub-arrow"></b>
                                </li>
                                <li class="nav-item ">
                                    <a href="{{ route('login') }}" class="nav-link">
                                        <i class="nav-icon fa fa-tachometer-alt"></i>
                                        <span class="nav-text fadeable">
                                            <span>
                                                Login
                                            </span>
                                        </span>
                                    </a>
                                    <b class="sub-arrow"></b>
                                </li>
                            @endauth
                            <li class="nav-item-caption">
                                <span class="fadeable pl-3">Gate log</span>
                                <span class="fadeinable mt-n2 text-125">&hellip;</span>
                            </li>
                            <li class="nav-item {{ request()->routeIs('employees.index') ? 'active' : '' }}">
                                <a href="{{ route('employees.index') }}" class="nav-link">
                                    <i class="nav-icon fa fa-tachometer-alt"></i>
                                    <span class="nav-text fadeable">
                                        <span>
                                            Employees list
                                        </span>
                                    </span>
                                </a>
                                <b class="sub-arrow"></b>
                            </li>
                            <li class="nav-item {{ request()->routeIs('instrument.index') ? 'active' : '' }}">
                                <a href="{{ route('employees.index') }}" class="nav-link">
                                    <i class="nav-icon fa fa-tachometer-alt"></i>
                                    <span class="nav-text fadeable">
                                        <span>
                                            Departments list
                                        </span>
                                    </span>
                                </a>
                                <b class="sub-arrow"></b>
                            </li>

                        </ul>

                    </div><!-- /.sidebar scroll -->


                    <div class="sidebar-section">
                        <div class="sidebar-section-item fadeable-bottom">
                            <div class="fadeinable">
                                <!-- shows this when collapsed -->
                                <div class="pos-rel">
                                    <img alt="Alexa's Photo" src="assets/image/avatar/avatar3.jpg" width="42"
                                        class="px-1px radius-round mx-2 border-2 brc-default-m2" />
                                    <span
                                        class="bgc-success radius-round border-2 brc-white p-1 position-tr mr-1 mt-2px"></span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div role="main" class="main-content">
                <div class="page-content">
                    @if (session('success'))
                        <div class="alert d-flex bgc-green-l4 brc-green-m4 border-1 border-l-0 pl-3 radius-l-0"
                            role="alert">
                            <div class="position-tl h-102 border-l-4 brc-green mt-n1px"></div>
                            <i class="fa fa-check mr-3 text-180 text-green"></i>

                            <span class="align-self-center text-green-d2 text-120">
                                {{ session('success') }}
                            </span>
                        </div>
                    @endif
                    @includeWhen($errors->any(), 'components/_errors')
                    <div class="page-header border-0">
                        <h1 class="page-title text-primary-d2 text-150">
                            {{ $mainTitle ?? 'MainTitle' }}
                            <small class="page-info text-dark-d3">
                                <i class="fa fa-angle-double-right text-80"></i>
                                {{ $subTitle ?? 'SubTitle' }}
                            </small>
                        </h1>
                    </div>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
    <!-- include common vendor scripts used in demo pages -->
    <script src="{{ asset('node_modules/jquery/dist/jquery.js') }}"></script>
    <script src="{{ asset('node_modules/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.js') }}"></script>
    <!-- include vendor scripts used in "Dashboard" page. see "/views//pages/partials/dashboard/@vendor-scripts.hbs" -->
    <script src="{{ asset('node_modules/chart.js/dist/Chart.js') }}"></script>
    <script src="{{ asset('node_modules/sortablejs/Sortable.js') }}"></script>
    <!-- include ace.js -->
    <script src="{{ asset('dist/js/ace.js') }}"></script>
    <!-- "Dashboard" page script to enable its demo functionality -->
    <script src="{{ asset('views/pages/dashboard/@page-script.js') }}"></script>
</body>

</html>
