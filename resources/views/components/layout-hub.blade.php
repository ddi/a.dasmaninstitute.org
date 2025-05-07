<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <base href="/" />
    <title>{{ $title ?? 'DDI Apps' }}</title>
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
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
    <!-- "Dashboard" page styles, specific to this page for demo only -->
    <link rel="stylesheet" type="text/css" href="{{ asset('views/pages/dashboard/@page-style.css') }}">
    @livewireStyles
</head>

<body>
    <div class="body-container">
        <div class="main-container bgc-white">
            <div id="sidebar" class="sidebar sidebar-fixed expandable sidebar-light">
                <div class="sidebar-inner">
                    <div class="ace-scroll flex-grow-1" data-ace-scroll="{}">
                        @if (file_exists('images/ddi-logo.png'))
                            <div class="py-3 d-flex flex-column align-items-center m-3 bg-white radius-1">
                                <img alt="DDI Logo" src="{{ URL::asset('/images/ddi-logo.png') }}" width="190" height="173"
                                    class="p-2px" />
                            </div>
                        @endif

                        <div class="d-flex flex-column align-items-center m-3">

                            version 0.1.0

                        </div>
                        <ul class="nav has-active-border active-on-right">
                            <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                                <a href="{{ route('home') }}" class="nav-link">
                                    <i class="nav-icon fa fa-tachometer-alt"></i>
                                    <span class="nav-text fadeable">
                                        <span>Home</span>
                                    </span>
                                </a>
                                <b class="sub-arrow"></b>
                            </li>
                            @can('manage', App\Models\HubLink::class)
                                <li class="nav-item {{ request()->routeIs('hublinks.index') ? 'active' : '' }}">
                                    <a href="{{ route('hublinks.index') }}" class="nav-link">
                                        <i class="nav-icon fa fa-tachometer-alt"></i>
                                        <span class="nav-text fadeable">
                                            <span>
                                                Hub Links Manager
                                            </span>
                                        </span>
                                    </a>
                                    <b class="sub-arrow"></b>
                                </li>
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
                            @endcan
                            @can('manage', App\Models\Patient::class)
                                <li class="nav-item {{ request()->routeIs('patients.index') ? 'active' : '' }}">
                                    <a href="{{ route('patients.index') }}" wire:navigate.hover class="nav-link">
                                        <i class="nav-icon fa fa-users"></i>
                                        <span class="nav-text fadeable">
                                            <span>
                                                Patients
                                            </span>
                                        </span>
                                    </a>
                                    <b class="sub-arrow"></b>
                                </li>
                            @endcan
                            @can('manage', App\Models\User::class)
                                <li class="nav-item-caption">
                                    <span class="fadeable pl-3">Admin</span>
                                    <span class="fadeinable mt-n2 text-125">&hellip;</span>
                                </li>
                                <li class="nav-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                    <a href="{{ route('users.index') }}" class="nav-link">
                                        <i class="nav-icon fa fa-users"></i>
                                        <span class="nav-text fadeable">
                                            <span>
                                                Users
                                            </span>
                                        </span>
                                    </a>
                                    <b class="sub-arrow"></b>
                                </li>
                            @endcan
                            @if (false)
                                @auth
                                    <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                                        <a href="{{ route('about') }}" wire:navigate.hover class="nav-link">
                                            <i class="nav-icon fa fa-users"></i>
                                            <span class="nav-text fadeable">
                                                <span>
                                                    About
                                                </span>
                                            </span>
                                        </a>
                                        <b class="sub-arrow"></b>
                                    </li>
                                    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                        <a href="{{ route('dashboard') }}" wire:navigate.hover class="nav-link">
                                            <i class="nav-icon fa fa-users"></i>
                                            <span class="nav-text fadeable">
                                                <span>
                                                    Dashboard
                                                </span>
                                            </span>
                                        </a>
                                        <b class="sub-arrow"></b>
                                    </li>
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
                                    <li class="nav-item {{ request()->routeIs('login') ? 'active' : '' }}">
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
                                    <li class="nav-item {{ request()->routeIs('login') ? 'active' : '' }}">
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
                            @endif
                        </ul>

                    </div><!-- /.sidebar scroll -->


                    @auth
                        <div class="sidebar-section">
                            <div class="sidebar-section-item fadeable-bottom">
                                <div class="fadeable hideable w-100 bg-transparent shadow-none border-0">
                                    <!-- shows this when full-width -->
                                    <div id="sidebar-footer-bg"
                                        class="d-flex align-items-center bgc-white shadow-sm mx-2 mt-2px py-2 radius-t-1 border-x-1 border-t-2 brc-primary-m3">
                                        <div class="d-flex mr-auto py-1">
                                            <div class="ml-3">
                                                <span class="text-blue-d1 font-bolder">{{ Auth::user()->username }}</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('logout') }}"
                                            class="d-style btn btn-outline-orange btn-h-light-orange btn-a-light-orange border-0 p-2 mr-1"
                                            title="Logout">
                                            <i class="fa fa-sign-out-alt text-150 text-orange-d2 f-n-hover"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="sidebar-section">
                            <div class="sidebar-section-item fadeable-bottom">
                                <div class="fadeable hideable w-100 bg-transparent shadow-none border-0">
                                    <!-- shows this when full-width -->
                                    <div id="sidebar-footer-bg"
                                        class="d-flex align-items-center bgc-white shadow-sm mx-2 mt-2px py-2 radius-t-1 border-x-1 border-t-2 brc-primary-m3">
                                        <div class="d-flex mr-auto py-1">
                                            <div class="ml-3">
                                                <a href="{{ route('login') }}" class="text-blue-d1 font-bolder">
                                                    Login
                                                </a>
                                            </div>
                                        </div>
                                        <a href="#"
                                            class="d-style btn btn-outline-orange btn-h-light-orange btn-a-light-orange border-0 p-2 mr-1"
                                            title="Logout">
                                            <i class="fa fa-sign-in-alt text-150 text-orange-d2 f-n-hover"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endauth
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
                    @if (session('error'))
                        <div class="alert d-flex bgc-red-l3 brc-red-m4 border-1 border-l-0 pl-3 radius-l-0" role="alert">
                            <div class="position-tl h-102 border-l-4 brc-red mt-n1px"></div>
                            <i class="fa fa-exclamation-triangle mr-3 text-180 text-danger-m2"></i>

                            <span class="align-self-center text-dark-tp3 text-120">
                                {{ session('error') }}
                            </span>
                        </div>
                    @endif
                    @includeWhen($errors->any(), 'components/_errors')

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
    @livewireScripts
</body>

</html>