<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

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

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Overpass&display=swap">

    <link href="{{ url('themes/lexa') }}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{ url('themes/lexa') }}/assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
    <link href="{{ url('themes/lexa') }}/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="{{ url('themes/lexa') }}/assets/css/style.css" rel="stylesheet" type="text/css">

    <!-- Scripts -->
    <script src="{{ url(mix('js/app.js')) }}"></script>

    @yield('js')

    <style>
        body, h1, h2, h3, h4, h5, h6 {
            font-family: "IBM Plex Sans",Muli,-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
        }

        /*legend{*/
            /*font-weight: 900;*/
            /*font-size: 1.1rem !important;*/
        /*}*/
        /*hr {*/
            /*border-top-color: lightgray;*/
        /*}*/

        /*.nav-tabs {*/
            /*overflow-x: scroll;*/
            /*overflow-y: hidden;*/
            /*display: -webkit-box;*/
            /*display: -moz-box;*/
        /*}*/

        .custom-checkbox label{
            margin-top: 0px;
        }
    </style>

</head>

<body>

<!-- Begin page -->
<div id="wrapper">

    <!-- Top Bar Start -->
    <div class="topbar">

        <!-- LOGO -->
        <div class="topbar-left">
            <a href="{{ url('/') }}" class="logo">
                        <span>
                            <img src="{{ url($logo) }}" alt="" height="80%">
                        </span>
                <i>
                    <img src="{{ url($logo_small) }}" alt="" height="30">
                </i>
            </a>
        </div>

        <nav class="navbar-custom">

            <ul class="navbar-right d-flex list-inline float-right mb-0">
                <li class="dropdown notification-list d-none d-sm-block">
                    <form role="search" class="app-search">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" placeholder="Search..">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </li>

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ti-bell noti-icon"></i>
                        <span class="badge badge-pill badge-danger noti-icon-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
                        <!-- item-->
                        <h6 class="dropdown-item-text">
                            Notifications (258)
                        </h6>
                        <div class="slimscroll notification-item-list">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item active">
                                <div class="notify-icon bg-success"><i class="mdi mdi-cart-outline"></i></div>
                                <p class="notify-details">Your order is placed<span class="text-muted">Dummy text of the printing and typesetting industry.</span></p>
                            </a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-warning"><i class="mdi mdi-message"></i></div>
                                <p class="notify-details">New Message received<span class="text-muted">You have 87 unread messages</span></p>
                            </a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-info"><i class="mdi mdi-martini"></i></div>
                                <p class="notify-details">Your item is shipped<span class="text-muted">It is a long established fact that a reader will</span></p>
                            </a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-primary"><i class="mdi mdi-cart-outline"></i></div>
                                <p class="notify-details">Your order is placed<span class="text-muted">Dummy text of the printing and typesetting industry.</span></p>
                            </a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-danger"><i class="mdi mdi-message"></i></div>
                                <p class="notify-details">New Message received<span class="text-muted">You have 87 unread messages</span></p>
                            </a>
                        </div>
                        <!-- All-->
                        <a href="javascript:void(0);" class="dropdown-item text-center text-primary">
                            View all <i class="fi-arrow-right"></i>
                        </a>
                    </div>
                </li>
                <li class="dropdown notification-list">
                    <div class="dropdown notification-list nav-pro-img">
                        <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{ url('themes/lexa') }}/assets/images/users/user-4.jpg" alt="user" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                            <a class="dropdown-item" href="{{ url('profile') }}"><i class="mdi mdi-account-circle m-r-5"></i> Profile</a>
                            <a class="dropdown-item d-block" href="{{ url('setting') }}"><i class="mdi mdi-settings m-r-5"></i> Settings</a>
                            <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline m-r-5"></i> Lock screen</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href=""  onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();"><i class="mdi mdi-power text-danger"></i> Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </li>

            </ul>

            <ul class="list-inline menu-left mb-0">
                <li class="float-left">
                    <button class="button-menu-mobile open-left waves-effect">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </li>
                {{--<li class="d-none d-sm-block">--}}
                    {{--<div class="dropdown pt-3 d-inline-block">--}}
                        {{--<a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                            {{--Create--}}
                        {{--</a>--}}

                        {{--<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">--}}
                            {{--<a class="dropdown-item" href="#">Action</a>--}}
                            {{--<a class="dropdown-item" href="#">Another action</a>--}}
                            {{--<a class="dropdown-item" href="#">Something else here</a>--}}
                            {{--<div class="dropdown-divider"></div>--}}
                            {{--<a class="dropdown-item" href="#">Separated link</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</li>--}}
            </ul>

        </nav>

    </div>
    <!-- Top Bar End -->

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">
        <div class="slimscroll-menu" id="remove-scroll">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                @include('partials.nav.lexa.nav', ['nav_file'=>$nav_file,'nav_path'=>$nav_path] )

            </div>
            <!-- Sidebar -->
            <div class="clearfix"></div>

        </div>
        <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <h4 class="page-title">{{ $title }}</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ env('SITE_NAME') }}</a></li>
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                                <li class="breadcrumb-item active">Data Table</li>
                            </ol>

                            <div class="state-information d-none d-sm-block">
                                <div class="state-graph">
                                    <div id="header-chart-1"></div>
                                    <div class="info">Balance $ 2,317</div>
                                </div>
                                <div class="state-graph">
                                    <div id="header-chart-2"></div>
                                    <div class="info">Item Sold 1230</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row" id="app">
                    <div class="col-12">
                        {{--<div class="card m-b-20">--}}
                            {{--<div class="card-body">--}}

                                @yield('content')

                            {{--</div>--}}
                        {{--</div>--}}
                    </div> <!-- end col -->
                </div> <!-- end row -->

                <div id="modalContainer">
                    @yield('modal')
                </div>


            </div> <!-- container-fluid -->

        </div> <!-- content -->

        <footer class="footer">
            © 2018 - 2019 Lexa - <span class="d-none d-sm-inline-block"> Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</span>.
        </footer>

    </div>


    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

<!-- jQuery  -->
{{--<script src="{{ url('themes/lexa') }}/assets/js/jquery.min.js"></script>--}}
{{--<script src="{{ url('themes/lexa') }}/assets/js/bootstrap.bundle.min.js"></script>--}}
<script src="{{ url('themes/lexa') }}/assets/js/metisMenu.min.js"></script>
<script src="{{ url('themes/lexa') }}/assets/js/jquery.slimscroll.js"></script>
<script src="{{ url('themes/lexa') }}/assets/js/waves.min.js"></script>

<script src="{{ url('themes/lexa') }}/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

<!-- App js -->
<script src="{{ url('themes/lexa') }}/assets/js/app.js"></script>

</body>

</html>
