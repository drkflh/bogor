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
    <link href="https://fonts.googleapis.com/css?family=Overpass&display=swap" rel="stylesheet">
    <link href="{{ url('themes/dashforge') }}/lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    {{--<link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/fonts/feather-font/css/iconfont.css">--}}
    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/css/demo_1/style.css">
    <link rel="stylesheet" href="{{ url(  env('APP_CSS', '')  ) }}">

    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ url(env('APP_FAVICON', 'favicon.ico')) }}" />

    <script src="{{ url(mix('js/app.js')) }}"></script>

    @yield('js')

    <style>
        .dropdown .dropdown-menu .dropdown-item, .btn-group .dropdown-menu .dropdown-item, .fc .fc-toolbar.fc-header-toolbar .fc-left .fc-button-group .dropdown-menu .dropdown-item, .fc .fc-toolbar.fc-header-toolbar .fc-right .fc-button-group .dropdown-menu .dropdown-item {
            font-size: 0.9rem !important;
            padding: .25rem .875rem;
            transition: all .2s ease-in-out;
            border-radius: 2px;
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
    </style>

    <script>
        $(document).ready(function(){

        });
    </script>

</head>
<body onload="spinner()" class="{{ env('SIDEBAR_DEFAULT_OPEN')?'':'sidebar-folded' }} {{ ( env('NOBLE_OPT_THEME','dark') == 'dark' )?'sidebar-dark':'' }}" >
<div class="main-wrapper">

    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar">
        <div class="sidebar-header" {!!  ( env('NOBLE_OPT_THEME','dark') == 'hybrid' )?'style="background-color: black;color: white;"':'' !!} >
            <a href="{{ url('/') }}" class="sidebar-brand">
                <img src="{{ url( env('APP_LOGO_SMALL') ) }}" alt="" height="35">
                @if(env('LOGO_TEXT', false ))
                    <span class="sidebar-brand" style="font-size: 15pt;font-weight: bold;">{{ env('SITE_TITLE') }}</span>
                @endif
            </a>
            <div class="sidebar-toggler not-active">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="sidebar-body">
            @include('partials.nav.nobleui.nav')
        </div>
    </nav>
    <!-- partial -->

    <div class="page-wrapper">

        <!-- partial:partials/_navbar.html -->
        <nav class="navbar">
            <a href="#" class="sidebar-toggler">
                <i data-feather="menu"></i>
            </a>
            <div class="navbar-content">
                <div class="row d-flex justify-content-between align-items-center flex-wrap grid-margin mr-2">
                    <h3 class="d-none d-sm-block mb-3 mb-md-0 mt-10" style="margin-top:16px;">{!! $title ?? env('SITE_TITLE') !!}</h3>
                    <h5 class="d-block d-sm-none my-4">{!! $title ?? env('SITE_TITLE') !!}</h5>
                </div>
                {{--<form class="search-form">--}}
                    {{--<div class="input-group">--}}
                        {{--<div class="input-group-prepend">--}}
                            {{--<div class="input-group-text">--}}
                                {{--<i data-feather="search"></i>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<input type="text" class="form-control" id="navbarForm" placeholder="Search here...">--}}
                    {{--</div>--}}
                {{--</form>--}}
                <ul class="navbar-nav">
                    <li class="nav-item dropdown" id="langContainer">
                        <b-form-select v-model="lang" :options="options"></b-form-select>
                    </li>
                    <li class="nav-item dropdown nav-apps">
                        <a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i data-feather="grid"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="appsDropdown">
                            <div class="dropdown-header d-flex align-items-center justify-content-between">
                                <p class="mb-0 font-weight-medium">Web Apps</p>
                                <a href="javascript:;" class="text-muted">Edit</a>
                            </div>
                            <div class="dropdown-body">
                                <div class="d-flex align-items-center apps">
                                    <a href="pages/apps/chat.html"><i data-feather="message-square" class="icon-lg"></i><p>Chat</p></a>
                                    <a href="pages/apps/calendar.html"><i data-feather="calendar" class="icon-lg"></i><p>Calendar</p></a>
                                    <a href="pages/email/inbox.html"><i data-feather="mail" class="icon-lg"></i><p>Email</p></a>
                                    <a href="pages/general/profile.html"><i data-feather="instagram" class="icon-lg"></i><p>Profile</p></a>
                                </div>
                            </div>
                            <div class="dropdown-footer d-flex align-items-center justify-content-center">
                                <a href="javascript:;">View all</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown nav-messages">
                        <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i data-feather="mail"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="messageDropdown">
                            <div class="dropdown-header d-flex align-items-center justify-content-between">
                                <p class="mb-0 font-weight-medium">9 New Messages</p>
                                <a href="javascript:;" class="text-muted">Clear all</a>
                            </div>
                            <div class="dropdown-body">
                                <a href="javascript:;" class="dropdown-item">
                                    <div class="figure">
                                        <img src="https://via.placeholder.com/30x30" alt="userr">
                                    </div>
                                    <div class="content">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p>Leonardo Payne</p>
                                            <p class="sub-text text-muted">2 min ago</p>
                                        </div>
                                        <p class="sub-text text-muted">Project status</p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="dropdown-item">
                                    <div class="figure">
                                        <img src="https://via.placeholder.com/30x30" alt="userr">
                                    </div>
                                    <div class="content">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p>Carl Henson</p>
                                            <p class="sub-text text-muted">30 min ago</p>
                                        </div>
                                        <p class="sub-text text-muted">Client meeting</p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="dropdown-item">
                                    <div class="figure">
                                        <img src="https://via.placeholder.com/30x30" alt="userr">
                                    </div>
                                    <div class="content">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p>Jensen Combs</p>
                                            <p class="sub-text text-muted">1 hrs ago</p>
                                        </div>
                                        <p class="sub-text text-muted">Project updates</p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="dropdown-item">
                                    <div class="figure">
                                        <img src="https://via.placeholder.com/30x30" alt="userr">
                                    </div>
                                    <div class="content">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p>Yaretzi Mayo</p>
                                            <p class="sub-text text-muted">5 hr ago</p>
                                        </div>
                                        <p class="sub-text text-muted">New record</p>
                                    </div>
                                </a>
                            </div>
                            <div class="dropdown-footer d-flex align-items-center justify-content-center">
                                <a href="javascript:;">View all</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown nav-notifications">
                        <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i data-feather="bell"></i>
                            <div class="indicator">
                                <div class="circle"></div>
                            </div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="notificationDropdown">
                            <div class="dropdown-header d-flex align-items-center justify-content-between">
                                <p class="mb-0 font-weight-medium">6 New Notifications</p>
                                <a href="javascript:;" class="text-muted">Clear all</a>
                            </div>
                            <div class="dropdown-body">
                                <a href="javascript:;" class="dropdown-item">
                                    <div class="icon">
                                        <i data-feather="user-plus"></i>
                                    </div>
                                    <div class="content">
                                        <p>New customer registered</p>
                                        <p class="sub-text text-muted">2 sec ago</p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="dropdown-item">
                                    <div class="icon">
                                        <i data-feather="gift"></i>
                                    </div>
                                    <div class="content">
                                        <p>New Order Recieved</p>
                                        <p class="sub-text text-muted">30 min ago</p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="dropdown-item">
                                    <div class="icon">
                                        <i data-feather="alert-circle"></i>
                                    </div>
                                    <div class="content">
                                        <p>Server Limit Reached!</p>
                                        <p class="sub-text text-muted">1 hrs ago</p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="dropdown-item">
                                    <div class="icon">
                                        <i data-feather="layers"></i>
                                    </div>
                                    <div class="content">
                                        <p>Apps are ready for update</p>
                                        <p class="sub-text text-muted">5 hrs ago</p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="dropdown-item">
                                    <div class="icon">
                                        <i data-feather="download"></i>
                                    </div>
                                    <div class="content">
                                        <p>Download completed</p>
                                        <p class="sub-text text-muted">6 hrs ago</p>
                                    </div>
                                </a>
                            </div>
                            <div class="dropdown-footer d-flex align-items-center justify-content-center">
                                <a href="javascript:;">View all</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown nav-profile">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i data-feather="user" ></i>
                            {{--@if(Auth::check())--}}
                                {{--<img style="width: 30px;height: 30px;" src="{{ (isset(Auth::user()->avatar))?\App\Helpers\AuthUtil::getAvatar( Auth::user()->avatar, url('images/coffee.png') )  : url('images/coffee.png') }}" class="rounded-circle" alt="">--}}
                            {{--@endif--}}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="profileDropdown">
                            <div class="dropdown-header d-flex flex-column align-items-center">
                                <div class="figure mb-3">
                                    @if(Auth::check())
                                        <img style="width: 80px;height: 80px;" src="{{ (isset(Auth::user()->avatar))?\App\Helpers\AuthUtil::getAvatar( Auth::user()->avatar, url('images/coffee.png') )  : url('images/coffee.png') }}" class="rounded-circle" alt="">
                                    @endif
                                </div>
                                <div class="info text-center">
                                    <p class="name font-weight-bold mb-0">{{ Auth::user()->name }}</p>
                                    <p class="name mb-3">{{ \App\Helpers\AuthUtil::getRoleName(Auth::user()->roleId ) }}</p>
                                    <p class="email text-muted mb-3">{{ Auth::user()->email }}</p>
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
                </ul>
            </div>
        </nav>
        <!-- partial -->

        <div id="spinner_" style="background: ()">
            <div class="spinner"></div>
        </div>
        <div class="page-content" id="app">
            @yield('content')
        </div>

        <!-- partial:partials/_footer.html -->
{{--        <footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between">--}}
{{--            <p class="text-muted text-center text-md-left">--}}
{{--                Copyright © 2020 <a href="https://www.nobleui.com" target="_blank">NobleUI</a>. All rights reserved--}}
{{--            </p>--}}
{{--            <p class="text-muted text-center text-md-left mb-0 d-none d-md-block">Handcrafted With <i class="mb-1 text-primary ml-1 icon-small" data-feather="heart"></i></p>--}}
{{--        </footer>--}}
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
