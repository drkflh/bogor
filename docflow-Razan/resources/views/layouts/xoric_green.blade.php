<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ env('SITE_NAME','') }} - {{ env('SITE_TITLE') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('themes/xoric/green') }}/assets/images/favicon.ico">

    <!-- datepicker -->
    <link href="{{ url('themes/xoric/green') }}/assets/libs/air-datepicker/css/datepicker.min.css" rel="stylesheet" type="text/css" />

    <!-- jvectormap -->
    <link href="{{ url('themes/xoric/green') }}/assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />

    <!-- Bootstrap Css -->
    <link href="{{ url('themes/xoric/green') }}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ url('themes/xoric/green') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ url('themes/xoric/green') }}/assets/css/app.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" id="css-main" href="{{ url('themes/xoric/green') }}/assets/css/fonts.css">
    <link href="https://fonts.googleapis.com/css?family=Merriweather|Merriweather+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" id="css-main" href="{{ url('/') }}/css/framework.css">


    <script src="{{ url(mix('js/app.js')) }}"></script>

    @yield('js')

    <style>
        body, .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
            font-family: "Merriweather Sans",Lato,Muli,-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
        }

        body{
            font-size: 9pt;
        }

        .footer {
            bottom: 0;
            padding: 20px calc(24px / 2);
            position: fixed;
            z-index: 1000;
            right: 0;
            color: #74788d;
            left: 250px;
            height: 60px;
            -webkit-box-shadow: 0 2px 4px rgba(0,0,0,.08);
            box-shadow: 0 2px 4px rgba(0,0,0,.08);
            background-color: #fff;
        }
        #sidebar-menu ul li a {
            display: block;
            padding: .7rem 1.5rem;
            color: #7c8a96;
            position: relative;
            font-size: 13px;
            -webkit-transition: all .4s;
            transition: all .4s;
        }

        #sidebar-menu ul li a i {
            font-size: 18px;
            padding-right: 8px;
            width: 30px;
        }

        #sidebar-menu ul li ul.sub-menu li a{
            padding: .4rem 1.5rem .4rem 3.7rem;
            font-size: 12px;
            color: #7c8a96;
        }

        .page-title-box {
            padding: 24px 12px 65px 12px;
            background-color: {{ env('XORIC_COLOR', '#2fa97c') }};
        }

    </style>

</head>

<body data-topbar="colored"
      @if(env('SIDEBAR_DEFAULT_OPEN') == false)
      class="sidebar-enable vertical-collpsed"
      @endif
>

<!-- Begin page -->
<div id="layout-wrapper">

    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="{{ url( env('AUTH_REDIRECT_TO','/') ) }}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{ url( env('APP_LOGO_SMALL') ) }}" alt="" height="35">
                                </span>
                        <span class="logo-lg">
                                    <img src="{{ url( env('APP_LOGO') ) }}" alt="" height="50">
                                </span>
                    </a>

                    <a href="{{ url( env('AUTH_REDIRECT_TO','/') ) }}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{ url( env('APP_LOGO_SMALL') ) }}" alt="" height="35">
                                </span>
                        <span class="logo-lg">
                                    <img src="{{ url( env('APP_LOGO') ) }}" alt="" height="50">
                                </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                    <i class="mdi mdi-backburger"></i>
                </button>

                <!-- App Search-->
                <form class="app-search d-none d-lg-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="mdi mdi-magnify"></span>
                    </div>
                </form>
            </div>

            <div class="d-flex">

                <div class="dropdown d-inline-block d-lg-none ml-2">
                    <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-magnify"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                         aria-labelledby="page-header-search-dropdown">

                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-flag-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="" src="{{ url('themes/xoric/green') }}/assets/images/flags/us.jpg" alt="Header Language" height="14">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <img src="{{ url('themes/xoric/green') }}/assets/images/flags/spain.jpg" alt="user-image" class="mr-2" height="12"><span class="align-middle">Spanish</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <img src="{{ url('themes/xoric/green') }}/assets/images/flags/germany.jpg" alt="user-image" class="mr-2" height="12"><span class="align-middle">German</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <img src="{{ url('themes/xoric/green') }}/assets/images/flags/italy.jpg" alt="user-image" class="mr-2" height="12"><span class="align-middle">Italian</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <img src="{{ url('themes/xoric/green') }}/assets/images/flags/russia.jpg" alt="user-image" class="mr-2" height="12"><span class="align-middle">Russian</span>
                        </a>
                    </div>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                        <i class="mdi mdi-tune"></i>
                    </button>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="{{ url('themes/xoric/green') }}/assets/images/users/avatar-1.jpg" alt="Header Avatar">
                        <span class="d-none d-sm-inline-block ml-1">{{ Auth::check() ? Auth::user()->name :'Guest'  }}</span>
                        <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a class="dropdown-item" href="{{ url('profile') }}"><i class="mdi mdi-face-profile font-size-16 align-middle mr-1"></i> Profile</a>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-credit-card-outline font-size-16 align-middle mr-1"></i> Billing</a>
                        <a class="dropdown-item" href="{{ url('setting') }}"><i class="mdi mdi-account-settings font-size-16 align-middle mr-1"></i> Settings</a>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-lock font-size-16 align-middle mr-1"></i> Lock screen</a>
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href=""  onclick="event.preventDefault();
                                 document.getElementById('logout-form-2').submit();" >
                            <i class="mdi mdi-logout font-size-16 align-middle mr-1"></i> Logout</a>
                        <form id="logout-form-2" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </div>
                </div>

            </div>
        </div>

    </header>

    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">

        <div data-simplebar class="h-100">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                @include('partials.nav.xoric.nav')

            <!-- Left Menu Start -->

            </div>
            <!-- Sidebar -->
        </div>
    </div>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content" id="app">

        <div class="page-content">

            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="page-title mb-1">{{ $title??"" }}</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active"><i class="fa fa-chevron-right"></i></li>
                            </ol>
                        </div>
                        <div class="col-md-4">
                            <div class="float-right d-none d-md-block">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-settings-outline mr-1"></i> Settings
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Separated link</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- end page title end breadcrumb -->

            <div class="page-content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            @yield('content')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>
            <!-- end page-content-wrapper -->
        </div>
        <!-- End Page-content -->


        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <a class="font-w600" href="{{ env('APP_URL') }}" target="_blank">{{ env('SITE_TITLE') }}</a> &copy; <span>{{ date('Y', time()) }}</span>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-right d-none d-sm-block">
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->

    @yield('modal')

</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar class="h-100">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-tabs-custom rightbar-nav-tab nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link py-3 active" data-toggle="tab" href="#chat-tab" role="tab">
                    <i class="mdi mdi-message-text font-size-22"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-3" data-toggle="tab" href="#tasks-tab" role="tab">
                    <i class="mdi mdi-format-list-checkbox font-size-22"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-3" data-toggle="tab" href="#settings-tab" role="tab">
                    <i class="mdi mdi-settings font-size-22"></i>
                </a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content text-muted">
            <div class="tab-pane active" id="chat-tab" role="tabpanel">

                <form class="search-bar py-4 px-3">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="mdi mdi-magnify"></span>
                    </div>
                </form>

                <h6 class="px-4 py-3 mt-2 bg-light">Group Chats</h6>

                <div class="p-2">
                    <a href="javascript: void(0);" class="text-reset notification-item pl-3 mb-2 d-block">
                        <i class="mdi mdi-checkbox-blank-circle-outline mr-1 text-success"></i>
                        <span class="mb-0 mt-1">App Development</span>
                    </a>

                    <a href="javascript: void(0);" class="text-reset notification-item pl-3 mb-2 d-block">
                        <i class="mdi mdi-checkbox-blank-circle-outline mr-1 text-warning"></i>
                        <span class="mb-0 mt-1">Office Work</span>
                    </a>

                    <a href="javascript: void(0);" class="text-reset notification-item pl-3 mb-2 d-block">
                        <i class="mdi mdi-checkbox-blank-circle-outline mr-1 text-danger"></i>
                        <span class="mb-0 mt-1">Personal Group</span>
                    </a>

                    <a href="javascript: void(0);" class="text-reset notification-item pl-3 d-block">
                        <i class="mdi mdi-checkbox-blank-circle-outline mr-1"></i>
                        <span class="mb-0 mt-1">Freelance</span>
                    </a>
                </div>

                <h6 class="px-4 py-3 mt-4 bg-light">Favourites</h6>

                <div class="p-2">
                    <a href="javascript: void(0);" class="text-reset notification-item">
                        <div class="media">
                            <div class="position-relative align-self-center mr-3">
                                <img src="{{ url('themes/xoric/green') }}/assets/images/users/avatar-10.jpg" class="rounded-circle avatar-xs" alt="user-pic">
                                <i class="mdi mdi-circle user-status online"></i>
                            </div>
                            <div class="media-body overflow-hidden">
                                <h6 class="mt-0 mb-1">Andrew Mackie</h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-0 text-truncate">It will seem like simplified English.</p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="javascript: void(0);" class="text-reset notification-item">
                        <div class="media">
                            <div class="position-relative align-self-center mr-3">
                                <img src="{{ url('themes/xoric/green') }}/assets/images/users/avatar-1.jpg" class="rounded-circle avatar-xs" alt="user-pic">
                                <i class="mdi mdi-circle user-status away"></i>
                            </div>
                            <div class="media-body overflow-hidden">
                                <h6 class="mt-0 mb-1">Rory Dalyell</h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-0 text-truncate">To an English person, it will seem like simplified</p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="javascript: void(0);" class="text-reset notification-item">
                        <div class="media">
                            <div class="position-relative align-self-center mr-3">
                                <img src="{{ url('themes/xoric/green') }}/assets/images/users/avatar-9.jpg" class="rounded-circle avatar-xs" alt="user-pic">
                                <i class="mdi mdi-circle user-status busy"></i>
                            </div>
                            <div class="media-body overflow-hidden">
                                <h6 class="mt-0 mb-1">Jaxon Dunhill</h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-0 text-truncate">To achieve this, it would be necessary.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <h6 class="px-4 py-3 mt-4 bg-light">Other Chats</h6>

                <div class="p-2 pb-4">
                    <a href="javascript: void(0);" class="text-reset notification-item">
                        <div class="media">
                            <div class="position-relative align-self-center mr-3">
                                <img src="{{ url('themes/xoric/green') }}/assets/images/users/avatar-2.jpg" class="rounded-circle avatar-xs" alt="user-pic">
                                <i class="mdi mdi-circle user-status online"></i>
                            </div>
                            <div class="media-body overflow-hidden">
                                <h6 class="mt-0 mb-1">Jackson Therry</h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-0 text-truncate">Everyone realizes why a new common language.</p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="javascript: void(0);" class="text-reset notification-item">
                        <div class="media">
                            <div class="position-relative align-self-center mr-3">
                                <img src="{{ url('themes/xoric/green') }}/assets/images/users/avatar-4.jpg" class="rounded-circle avatar-xs" alt="user-pic">
                                <i class="mdi mdi-circle user-status away"></i>
                            </div>
                            <div class="media-body overflow-hidden">
                                <h6 class="mt-0 mb-1">Charles Deakin</h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-0 text-truncate">The languages only differ in their grammar.</p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="javascript: void(0);" class="text-reset notification-item">
                        <div class="media">
                            <div class="position-relative align-self-center mr-3">
                                <img src="{{ url('themes/xoric/green') }}/assets/images/users/avatar-5.jpg" class="rounded-circle avatar-xs" alt="user-pic">
                                <i class="mdi mdi-circle user-status online"></i>
                            </div>
                            <div class="media-body overflow-hidden">
                                <h6 class="mt-0 mb-1">Ryan Salting</h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-0 text-truncate">If several languages coalesce the grammar of the resulting.</p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="javascript: void(0);" class="text-reset notification-item">
                        <div class="media">
                            <div class="position-relative align-self-center mr-3">
                                <img src="{{ url('themes/xoric/green') }}/assets/images/users/avatar-6.jpg" class="rounded-circle avatar-xs" alt="user-pic">
                                <i class="mdi mdi-circle user-status online"></i>
                            </div>
                            <div class="media-body overflow-hidden">
                                <h6 class="mt-0 mb-1">Sean Howse</h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-0 text-truncate">It will seem like simplified English.</p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="javascript: void(0);" class="text-reset notification-item">
                        <div class="media">
                            <div class="position-relative align-self-center mr-3">
                                <img src="{{ url('themes/xoric/green') }}/assets/images/users/avatar-7.jpg" class="rounded-circle avatar-xs" alt="user-pic">
                                <i class="mdi mdi-circle user-status busy"></i>
                            </div>
                            <div class="media-body overflow-hidden">
                                <h6 class="mt-0 mb-1">Dean Coward</h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-0 text-truncate">The new common language will be more simple.</p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="javascript: void(0);" class="text-reset notification-item">
                        <div class="media">
                            <div class="position-relative align-self-center mr-3">
                                <img src="{{ url('themes/xoric/green') }}/assets/images/users/avatar-8.jpg" class="rounded-circle avatar-xs" alt="user-pic">
                                <i class="mdi mdi-circle user-status away"></i>
                            </div>
                            <div class="media-body overflow-hidden">
                                <h6 class="mt-0 mb-1">Hayley East</h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-0 text-truncate">One could refuse to pay expensive translators.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>

            <div class="tab-pane" id="tasks-tab" role="tabpanel">
                <h6 class="p-3 mb-0 mt-4 bg-light">Working Tasks</h6>

                <div class="p-2">
                    <a href="javascript: void(0);" class="text-reset item-hovered d-block p-3">
                        <p class="text-muted mb-0">App Development<span class="float-right">75%</span></p>
                        <div class="progress mt-2" style="height: 4px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </a>

                    <a href="javascript: void(0);" class="text-reset item-hovered d-block p-3">
                        <p class="text-muted mb-0">Database Repair<span class="float-right">37%</span></p>
                        <div class="progress mt-2" style="height: 4px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 37%" aria-valuenow="37" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </a>

                    <a href="javascript: void(0);" class="text-reset item-hovered d-block p-3">
                        <p class="text-muted mb-0">Backup Create<span class="float-right">52%</span></p>
                        <div class="progress mt-2" style="height: 4px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 52%" aria-valuenow="52" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </a>
                </div>

                <h6 class="p-3 mb-0 mt-4 bg-light">Upcoming Tasks</h6>

                <div class="p-2">
                    <a href="javascript: void(0);" class="text-reset item-hovered d-block p-3">
                        <p class="text-muted mb-0">Sales Reporting<span class="float-right">12%</span></p>
                        <div class="progress mt-2" style="height: 4px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 12%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </a>

                    <a href="javascript: void(0);" class="text-reset item-hovered d-block p-3">
                        <p class="text-muted mb-0">Redesign Website<span class="float-right">67%</span></p>
                        <div class="progress mt-2" style="height: 4px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 67%" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </a>

                    <a href="javascript: void(0);" class="text-reset item-hovered d-block p-3">
                        <p class="text-muted mb-0">New Admin Design<span class="float-right">84%</span></p>
                        <div class="progress mt-2" style="height: 4px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 84%" aria-valuenow="84" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </a>
                </div>

                <div class="p-3 mt-2">
                    <a href="javascript: void(0);" class="btn btn-success btn-block waves-effect waves-light">Create Task</a>
                </div>

            </div>
            <div class="tab-pane" id="settings-tab" role="tabpanel">
                <h6 class="px-4 py-3 bg-light">General Settings</h6>

                <div class="p-4">
                    <h6 class="font-weight-medium">Online Status</h6>
                    <div class="custom-control custom-switch mb-1">
                        <input type="checkbox" class="custom-control-input" id="settings-check1" name="settings-check1" checked="">
                        <label class="custom-control-label font-weight-normal" for="settings-check1">Show your status to all</label>
                    </div>

                    <h6 class="mt-4">Auto Updates</h6>
                    <div class="custom-control custom-switch mb-1">
                        <input type="checkbox" class="custom-control-input" id="settings-check2" name="settings-check2" checked="">
                        <label class="custom-control-label font-weight-normal" for="settings-check2">Keep up to date</label>
                    </div>

                    <h6 class="mt-4">Backup Setup</h6>
                    <div class="custom-control custom-switch mb-1">
                        <input type="checkbox" class="custom-control-input" id="settings-check3" name="settings-check3">
                        <label class="custom-control-label font-weight-normal" for="settings-check3">Auto backup</label>
                    </div>

                </div>

                <h6 class="px-4 py-3 mt-2 bg-light">Advanced Settings</h6>

                <div class="p-4">
                    <h6 class="font-weight-medium">Application Alerts</h6>
                    <div class="custom-control custom-switch mb-1">
                        <input type="checkbox" class="custom-control-input" id="settings-check4" name="settings-check4" checked="">
                        <label class="custom-control-label font-weight-normal" for="settings-check4">Email Notifications</label>
                    </div>

                    <div class="custom-control custom-switch mb-1">
                        <input type="checkbox" class="custom-control-input" id="settings-check5" name="settings-check5">
                        <label class="custom-control-label font-weight-normal" for="settings-check5">SMS Notifications</label>
                    </div>

                    <h6 class="mt-4">API</h6>
                    <div class="custom-control custom-switch mb-1">
                        <input type="checkbox" class="custom-control-input" id="settings-check6" name="settings-check6">
                        <label class="custom-control-label font-weight-normal" for="settings-check6">Enable access</label>
                    </div>

                </div>
            </div>
        </div>

    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- JAVASCRIPT -->
{{--<script src="{{ url('themes/xoric/green') }}/assets/libs/jquery/jquery.min.js"></script>--}}
{{--<script src="{{ url('themes/xoric/green') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>--}}
<script src="{{ url('themes/xoric/green') }}/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="{{ url('themes/xoric/green') }}/assets/libs/simplebar/simplebar.min.js"></script>
<script src="{{ url('themes/xoric/green') }}/assets/libs/node-waves/waves.min.js"></script>

<script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>

{{--<!-- datepicker -->--}}
{{--<script src="{{ url('themes/xoric/green') }}/assets/libs/air-datepicker/js/datepicker.min.js"></script>--}}
{{--<script src="{{ url('themes/xoric/green') }}/assets/libs/air-datepicker/js/i18n/datepicker.en.js"></script>--}}

{{--<!-- apexcharts -->--}}
{{--<script src="{{ url('themes/xoric/green') }}/assets/libs/apexcharts/apexcharts.min.js"></script>--}}

{{--<script src="{{ url('themes/xoric/green') }}/assets/libs/jquery-knob/jquery.knob.min.js"></script>--}}

{{--<!-- Jq vector map -->--}}
{{--<script src="{{ url('themes/xoric/green') }}/assets/libs/jqvmap/jquery.vmap.min.js"></script>--}}
{{--<script src="{{ url('themes/xoric/green') }}/assets/libs/jqvmap/maps/jquery.vmap.usa.js"></script>--}}

{{--<script src="{{ url('themes/xoric/green') }}/assets/js/pages/dashboard.init.js"></script>--}}

<script src="{{ url('themes/xoric/green') }}/assets/js/app.js"></script>

</body>
</html>
