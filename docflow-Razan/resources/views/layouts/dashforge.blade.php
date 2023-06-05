<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ env('SITE_NAME','') }} - {{ env('SITE_TITLE') }}</title>

    <meta name="description" content="{{ env('SITE_DESCRIPTION'), '' }}">
    <meta name="author" content="{{ env('SITE_CREATOR','') }}">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="{{ env('SITE_TITLE') }}">
    <meta property="og:site_name" content="{{ env('SITE_NAME'), '' }}">
    <meta property="og:description" content="{{ env('SITE_DESCRIPTION'), '' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL'), '' }}">
    <meta property="og:image" content="">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">


    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="DashForge">
    <meta name="twitter:description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="twitter:image" content="http://themepixels.me/dashforge/img/dashforge-social.png">


    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('themes/dashforge') }}/assets/img/favicon.png">

    <!-- vendor css -->
    <link href="{{ url('themes/dashforge') }}/lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="{{ url('themes/dashforge') }}/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="{{ url('themes/dashforge') }}/lib/jqvmap/jqvmap.min.css" rel="stylesheet">

    <script src="{{ url(mix('js/app.js')) }}"></script>

    @yield('js')

<!-- DashForge CSS -->
    <link rel="stylesheet" href="{{ url('themes/dashforge') }}/assets/css/dashforge.css">
    <link rel="stylesheet" href="{{ url('themes/dashforge') }}/assets/css/dashforge.dashboard.css">

</head>
<body>

<aside class="aside aside-fixed">
    <div class="aside-header">
        <a href="{{ url('/') }}" class="aside-logo">{{ env('SITE_TITLE') }}</span></a>
        <a href="" class="aside-menu-link">
            <i data-feather="menu"></i>
            <i data-feather="x"></i>
        </a>
    </div>
    <div class="aside-body">
        <div class="aside-loggedin">
            <div class="d-flex align-items-center justify-content-start">
                @if(Auth::check())
                    <a href="" class="avatar"><img src="{{ (isset(Auth::user()->avatar))?\App\Helpers\AuthUtil::getAvatar( Auth::user()->avatar, url('images/coffee.png') )  : url('images/coffee.png') }}" class="rounded-circle" alt=""></a>
                @endif
                <div class="aside-alert-link">
                    {{--<a href="" class="new" data-toggle="tooltip" title="You have 2 unread messages"><i data-feather="message-square"></i></a>--}}
                    {{--<a href="" class="new" data-toggle="tooltip" title="You have 4 new notifications"><i data-feather="bell"></i></a>--}}
                    <a href="" onclick="event.preventDefault();document.getElementById('logout-form').submit();" data-toggle="tooltip" title="Sign out">
                        <i data-feather="log-out"></i>
                    </a>

                </div>
            </div>
            <div class="aside-loggedin-user">
                <a href="#loggedinMenu" class="d-flex align-items-center justify-content-between mg-b-2" data-toggle="collapse">
                    <h6 class="tx-semibold mg-b-0">{{ (Auth::check() && isset(Auth::user()->name))?Auth::user()->name:'Guest' }}</h6>
                    <i data-feather="chevron-down"></i>
                </a>
                <p class="tx-color-03 tx-12 mg-b-0">{{ (Auth::check())? \App\Helpers\AuthUtil::getRoleName(Auth::user()->roleId):'Guest' }}</p>
            </div>
            <div class="collapse" id="loggedinMenu">
                <ul class="nav nav-aside mg-b-0">
                    <li class="nav-item"><a href="{{ url('profile') }}" class="nav-link"><i data-feather="user"></i> <span>View Profile</span></a></li>
                    <li class="nav-item"><a href="{{ url('profile/edit') }}" class="nav-link"><i data-feather="edit"></i> <span>Edit Profile</span></a></li>
                    <li class="nav-item"><a href="{{ url('setting') }}" class="nav-link"><i data-feather="settings"></i> <span>Settings</span></a></li>
                    {{--<li class="nav-item"><a href="" class="nav-link"><i data-feather="help-circle"></i> <span>Help Center</span></a></li>--}}
                    <li class="nav-item">
                        <a href=""  class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                           data-toggle="tooltip" title="Sign out">
                            <i data-feather="log-out"></i> <span>Sign Out</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div><!-- aside-loggedin -->
        @include('partials.nav.dashforge.nav')
    </div>
</aside>

<div class="content ht-100v pd-0">
    <div class="content-header">
        <div class="content-search">
            <i data-feather="search"></i>
            <input type="search" class="form-control" placeholder="Search...">
        </div>
        <nav class="nav">
            <a href="" class="nav-link"><i data-feather="help-circle"></i></a>
            {{--<a href="" class="nav-link"><i data-feather="grid"></i></a>--}}
            {{--<a href="" class="nav-link"><i data-feather="align-left"></i></a>--}}
        </nav>
    </div><!-- content-header -->

    <div class="content-body" id="app" >
        <div class="container-fluid pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    {{--<nav aria-label="breadcrumb">--}}
                        {{--<ol class="breadcrumb breadcrumb-style1 mg-b-10">--}}
                            {{--<li class="breadcrumb-item"><a href="#">Dashboard</a></li>--}}
                            {{--<li class="breadcrumb-item active" aria-current="page">Sales Monitoring</li>--}}
                        {{--</ol>--}}
                    {{--</nav>--}}
                    <h2 class="mg-b-0 tx-spacing--1">{!! $title !!}</h2>
                </div>
                <div class="d-none d-md-block">
                    {{--<button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="mail" class="wd-10 mg-r-5"></i> Email</button>--}}
                    <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="printer" class="wd-10 mg-r-5"></i> Print List</button>
                    {{--<button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="file" class="wd-10 mg-r-5"></i> Generate Report</button>--}}
                </div>
            </div>
            @yield('content')
        </div><!-- container -->
    </div>
</div>

@yield('modal')

<script src="{{ url('themes/dashforge') }}/lib/feather-icons/feather.min.js"></script>
<script src="{{ url('themes/dashforge') }}/lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<script src="{{ url('themes/dashforge') }}/assets/js/dashforge.js"></script>
<script src="{{ url('themes/dashforge') }}/assets/js/dashforge.aside.js"></script>
{{--<script src="{{ url('themes/dashforge') }}/assets/js/dashforge.sampledata.js"></script>--}}
{{--<script src="{{ url('themes/dashforge') }}/assets/js/dashboard-one.js"></script>--}}

<!-- append theme customizer -->
<script src="{{ url('themes/dashforge') }}/lib/js-cookie/js.cookie.js"></script>
{{--<script src="{{ url('themes/dashforge') }}/assets/js/dashforge.settings.js"></script>--}}
</body>
</html>
