<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('SITE_NAME','') }} - {{ env('SITE_TITLE') }}</title>
    <!-- core:css -->
    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/vendors/core/core.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <!-- end plugin css for this page -->
    <!-- inject:css -->
    <link href="{{ url('themes/dashforge') }}/lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/fonts/feather-font/css/iconfont.css">
    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/css/demo_5/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ url(env('APP_FAVICON', 'favicon.ico')) }}" />

    <script src="{{ url(mix('js/app.js')) }}"></script>

    @yield('js')

    <style>
        .dropdown .dropdown-menu .dropdown-item, .btn-group .dropdown-menu .dropdown-item, .fc .fc-toolbar.fc-header-toolbar .fc-left .fc-button-group .dropdown-menu .dropdown-item, .fc .fc-toolbar.fc-header-toolbar .fc-right .fc-button-group .dropdown-menu .dropdown-item {
            font-size: .85rem !important;
            padding: .25rem .875rem;
            transition: all .2s ease-in-out;
            border-radius: 2px;
        }
        .dropdown .dropdown-menu .dropdown-item, .btn-group .dropdown-menu .dropdown-item svg {
            width: 20 !important;
            font-size: .82rem !important;
        }

        .custom-select {
            /* background: none !important; */
            -moz-appearance:none; /* Firefox */
            -webkit-appearance:none; /* Safari and Chrome */
            appearance:none;
        }

        body{
            font-size: 11pt !important;
        }
        .purchased .media .thumbnail {
            width: 50px;
            height: 50px;
            border-radius: 3px;
            background-color: #ddd;
            margin-right: 5px;
            flex-shrink: 0;
        }
        .paymentType .paymentItem h3 {
            font-size: 14px!important;
        }
    </style>

    <script>
        $(document).ready(function(){

        });
    </script>

</head>
<body onload="spinner()" class="{{ env('SIDEBAR_DEFAULT_OPEN')?'':'sidebar-folded' }} {{ ( env('NOBLE_OPT_THEME','dark') == 'dark' )?'sidebar-dark':'' }}" >
<div class="main-wrapper">

    <!-- partial:partials/_navbar.html -->
    <div class="horizontal-menu">
        <nav class="navbar top-navbar">
            <div class="container-fluid">
                <div class="navbar-content">
                    <a href="{{ url('/') }}" class="navbar-brand">
                        <img src="{{ url( env('APP_LOGO_SMALL') ) }}" alt="" height="35">
                        @if(env('LOGO_TEXT', false ))
                            <span class="sidebar-brand" style="font-size: 15pt;font-weight: bold;">{{ env('SITE_TITLE') }}</span>
                        @endif
                    </a>
{{--                    <form class="search-form">--}}
{{--                        <div class="input-group">--}}
{{--                            <div class="input-group-prepend">--}}
{{--                                <div class="input-group-text">--}}
{{--                                    <i data-feather="search"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <input type="text" class="form-control" id="navbarForm" placeholder="Search here...">--}}
{{--                        </div>--}}
{{--                    </form>--}}

                    <ul class="navbar-nav">
                        <li class="nav-item dropdown" id="langContainer">
                            <form method="get" action="{!! url()->full() !!}" >
                                <select name="lang" class="form-control" onchange="this.form.submit()">
                                    @foreach( config('util.languages') as $k=>$v )
                                        <option value="{{ $k }}" {{ $k == $lang ?'selected':'' }} >{{ $v }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </li>
                        <li class="nav-item dropdown nav-profile">
                            @if(Auth::check())
                                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="user" ></i>
                                </a>
                            <div class="dropdown-menu" aria-labelledby="profileDropdown">
                                <div class="dropdown-header d-flex flex-column align-items-center">
                                    <div class="figure mb-3">
                                            <img style="width: 80px;height: 80px;" src="{{ (isset(Auth::user()->avatar))?\App\Helpers\AuthUtil::getAvatar( Auth::user()->avatar, url('images/coffee.png') )  : url('images/coffee.png') }}" class="rounded-circle" alt="">
                                    </div>
                                    <div class="info text-center">
                                        <p class="name font-weight-bold mb-0">{{ Auth::user()->name }}</p>
                                        <p class="name mb-3">{{ \App\Helpers\AuthUtil::getRoleName(Auth::user()->roleId ) }}</p>
                                        <p class="email text-muted mb-3">{{ Auth::user()->email }}</p>
                                        @if( \App\Helpers\AuthUtil::getRoleName(Auth::user()->roleId ) == 'Superuser')
                                          <a type="button" class="btn btn-primary mb-2" href="/tour/admin/dashboard">Dashboard</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="dropdown-body">
                                    <ul class="profile-nav p-0 pt-3">
                                        <li class="nav-item">
                                            <a href="{{ url('profile') }}" class="nav-link">
                                                <i data-feather="user"></i>
                                                <span>Profile</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('profile/edit') }}" class="nav-link">
                                                <i data-feather="edit"></i>
                                                <span>Edit Profile</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href=""  class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                               data-toggle="tooltip" title="Sign out">
                                                <i data-feather="log-out"></i>
                                                <span>Log Out</span>
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        @else
                            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="user" ></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="profileDropdown">
                                <div class="dropdown-body">
                                    <ul class="profile-nav p-0 pt-3">
                                        @if(env('ENABLE_REGISTRATION', false))
                                        <li class="nav-item">
                                            <a href="{{ url('register') }}" class="nav-link">
                                                <i data-feather="edit"></i>
                                                <span>Register</span>
                                            </a>
                                        </li>
                                        @endif()
                                        <li class="nav-item">
                                            <a href="{{ url('login') }}" class="nav-link">
                                                <i data-feather="log-in"></i>
                                                <span>Login</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
                        <i data-feather="menu"></i>
                    </button>
                </div>
            </div>
        </nav>
        <nav class="bottom-navbar">
            <div class="container-fluid" style="text-align: center;" >
                @include('partials.nav.nobleui_h.nav')
            </div>
        </nav>
    </div>
    <!-- partial -->
    <div id="spinner_">
        <div class="spinner"></div>
    </div>
    <div class="page-wrapper">

        <div class="page-content" id="app">

            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                <div>
                    <h4 class="mb-3 mb-md-0">{{ $title }}</h4>
                </div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                </div>
            </div>

            @yield('content')
        </div>

        <!-- partial:partials/_footer.html -->
        <footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between">
            <p class="text-muted text-center text-md-left">
                Copyright © 2020 <a href="https://www.nobleui.com" target="_blank">NobleUI</a>. All rights reserved
            </p>
            <p class="text-muted text-center text-md-left mb-0 d-none d-md-block">Handcrafted With <i class="mb-1 text-primary ml-1 icon-small" data-feather="heart"></i></p>
        </footer>
        <!-- partial -->

    </div>
</div>

@yield('modal')

<!-- core:js -->
<script src="{{ url('themes/nobleui') }}/assets/vendors/core/core.js"></script>
<!-- endinject -->
<!-- plugin js for this page -->
<script src="{{ url('themes/nobleui') }}/assets/vendors/chartjs/Chart.min.js"></script>
<script src="{{ url('themes/nobleui') }}/assets/vendors/jquery.flot/jquery.flot.js"></script>
<script src="{{ url('themes/nobleui') }}/assets/vendors/jquery.flot/jquery.flot.resize.js"></script>
<script src="{{ url('themes/nobleui') }}/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="{{ url('themes/nobleui') }}/assets/vendors/apexcharts/apexcharts.min.js"></script>
<script src="{{ url('themes/nobleui') }}/assets/vendors/progressbar.js/progressbar.min.js"></script>
<!-- end plugin js for this page -->
<!-- inject:js -->
<script src="{{ url('themes/nobleui') }}/assets/vendors/feather-icons/feather.min.js"></script>
<script src="{{ url('themes/nobleui') }}/assets/js/template.js"></script>
<!-- endinject -->
<!-- custom js for this page -->
<script src="{{ url('themes/nobleui') }}/assets/js/dashboard.js"></script>
<script src="{{ url('themes/nobleui') }}/assets/js/datepicker.js"></script>
<!-- end custom js for this page -->
<script>
function spinner() {
    setTimeout(() => {
        document.getElementById("spinner_").style.display = "none";
        document.getElementById("app").style.display = "block";
    }, 900);
}
</script>
</body>
</html>
