<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{ env('SITE_NAME','') }} - {{ env('SITE_TITLE') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('themes/shreyu') }}/assets/images/favicon.ico">

    <!-- plugin css -->
    <link href="{{ url('themes/shreyu') }}/assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('themes/shreyu') }}/assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('themes/shreyu') }}/assets/libs/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('themes/shreyu') }}/assets/libs/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ url('themes/shreyu') }}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('themes/shreyu') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('themes/shreyu') }}/assets/css/app.min.css" rel="stylesheet" type="text/css" />

    <script src="{{ url(mix('js/app.js')) }}"></script>

    @yield('js')

    <style>
        body {
            font-size: 12px;
        }
    </style>

</head>

<body>

<!-- Begin page -->
<div id="wrapper">

    <!-- Topbar Start -->
    <div class="navbar navbar-expand flex-column flex-md-row navbar-custom">
        <div class="container-fluid">
            <!-- LOGO -->

            <a href="{{ url( env('AUTH_REDIRECT_TO','/') ) }}" class="navbar-brand mr-0 mr-md-2 logo">
                <span class="logo-lg">
                    <img src="{{ url( env('APP_LOGO') ) }}" alt="" height="50">
                    <span class="d-inline h5 ml-1 text-logo">{{ env('SITE_TITLE','') }}</span>
                </span>
                <span class="logo-sm">
                    <img src="{{ url( env('APP_LOGO_SMALL') ) }}" alt="" height="35">
                </span>
            </a>

            <ul class="navbar-nav bd-navbar-nav flex-row list-unstyled menu-left mb-0">
                <li class="">
                    <button class="button-menu-mobile open-left disable-btn">
                        <i data-feather="menu" class="menu-icon"></i>
                        <i data-feather="x" class="close-icon"></i>
                    </button>
                </li>
            </ul>

            <ul class="navbar-nav flex-row ml-auto d-flex list-unstyled topnav-menu float-right mb-0">
                <li class="d-none d-sm-block">
                    <div class="app-search">
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span data-feather="search"></span>
                            </div>
                        </form>
                    </div>
                </li>

                <li class="dropdown d-none d-lg-block" data-toggle="tooltip" data-placement="left" title="Change language">
                    <a class="nav-link dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button"
                       aria-haspopup="false" aria-expanded="false">
                        <i data-feather="globe"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <img src="{{ url('themes/shreyu') }}/assets/images/flags/germany.jpg" alt="user-image" class="mr-2" height="12"> <span
                                    class="align-middle">German</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <img src="{{ url('themes/shreyu') }}/assets/images/flags/italy.jpg" alt="user-image" class="mr-2" height="12"> <span
                                    class="align-middle">Italian</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <img src="{{ url('themes/shreyu') }}/assets/images/flags/spain.jpg" alt="user-image" class="mr-2" height="12"> <span
                                    class="align-middle">Spanish</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <img src="{{ url('themes/shreyu') }}/assets/images/flags/russia.jpg" alt="user-image" class="mr-2" height="12"> <span
                                    class="align-middle">Russian</span>
                        </a>
                    </div>
                </li>


                <li class="dropdown notification-list" data-toggle="tooltip" data-placement="left"
                    title="8 new unread notifications">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                       aria-expanded="false">
                        <i data-feather="bell"></i>
                        <span class="noti-icon-badge"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                        <!-- item-->
                        <div class="dropdown-item noti-title border-bottom">
                            <h5 class="m-0 font-size-16">
                                        <span class="float-right">
                                            <a href="" class="text-dark">
                                                <small>Clear All</small>
                                            </a>
                                        </span>Notification
                            </h5>
                        </div>

                        <div class="slimscroll noti-scroll">

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item border-bottom">
                                <div class="notify-icon bg-primary"><i class="uil uil-user-plus"></i></div>
                                <p class="notify-details">New user registered.<small class="text-muted">5 hours ago</small>
                                </p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item border-bottom">
                                <div class="notify-icon">
                                    <img src="{{ url('themes/shreyu') }}/assets/images/users/avatar-1.jpg" class="img-fluid rounded-circle" alt="" />
                                </div>
                                <p class="notify-details">Karen Robinson</p>
                                <p class="text-muted mb-0 user-msg">
                                    <small>Wow ! this admin looks good and awesome design</small>
                                </p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item border-bottom">
                                <div class="notify-icon">
                                    <img src="{{ url('themes/shreyu') }}/assets/images/users/avatar-2.jpg" class="img-fluid rounded-circle" alt="" />
                                </div>
                                <p class="notify-details">Cristina Pride</p>
                                <p class="text-muted mb-0 user-msg">
                                    <small>Hi, How are you? What about our next meeting</small>
                                </p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item border-bottom active">
                                <div class="notify-icon bg-success"><i class="uil uil-comment-message"></i> </div>
                                <p class="notify-details">Jaclyn Brunswick commented on Dashboard<small class="text-muted">1
                                        min
                                        ago</small></p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item border-bottom">
                                <div class="notify-icon bg-danger"><i class="uil uil-comment-message"></i></div>
                                <p class="notify-details">Caleb Flakelar commented on Admin<small class="text-muted">4 days
                                        ago</small></p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-primary">
                                    <i class="uil uil-heart"></i>
                                </div>
                                <p class="notify-details">Carlos Crouch liked
                                    <b>Admin</b>
                                    <small class="text-muted">13 days ago</small>
                                </p>
                            </a>
                        </div>

                        <!-- All-->
                        <a href="javascript:void(0);"
                           class="dropdown-item text-center text-primary notify-item notify-all border-top">
                            View all
                            <i class="fi-arrow-right"></i>
                        </a>

                    </div>
                </li>

                <li class="dropdown notification-list" data-toggle="tooltip" data-placement="left" title="Settings">
                    <a href="javascript:void(0);" class="nav-link right-bar-toggle">
                        <i data-feather="settings"></i>
                    </a>
                </li>

                <li class="dropdown notification-list align-self-center profile-dropdown">
                    <a class="nav-link dropdown-toggle nav-user mr-0" data-toggle="dropdown" href="#" role="button"
                       aria-haspopup="false" aria-expanded="false">
                        <div class="media user-profile ">
                            <img src="{{ url('themes/shreyu') }}/assets/images/users/avatar-7.jpg" alt="user-image" class="rounded-circle align-self-center" />
                            <div class="media-body text-left">
                                <h6 class="pro-user-name ml-2 my-0">
                                    <span>Shreyu N</span>
                                    <span class="pro-user-desc text-muted d-block mt-1">Administrator </span>
                                </h6>
                            </div>
                            <span data-feather="chevron-down" class="ml-2 align-self-center"></span>
                        </div>
                    </a>
                    <div class="dropdown-menu profile-dropdown-items dropdown-menu-right">
                        <a href="pages-profile.html" class="dropdown-item notify-item">
                            <i data-feather="user" class="icon-dual icon-xs mr-2"></i>
                            <span>My Account</span>
                        </a>

                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i data-feather="settings" class="icon-dual icon-xs mr-2"></i>
                            <span>Settings</span>
                        </a>

                        {{--<a href="javascript:void(0);" class="dropdown-item notify-item">--}}
                            {{--<i data-feather="help-circle" class="icon-dual icon-xs mr-2"></i>--}}
                            {{--<span>Support</span>--}}
                        {{--</a>--}}

                        {{--<a href="pages-lock-screen.html" class="dropdown-item notify-item">--}}
                            {{--<i data-feather="lock" class="icon-dual icon-xs mr-2"></i>--}}
                            {{--<span>Lock Screen</span>--}}
                        {{--</a>--}}

                        <div class="dropdown-divider"></div>

                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i data-feather="log-out" class="icon-dual icon-xs mr-2"></i>
                            <span>Logout</span>
                        </a>


                    </div>
                </li>
            </ul>
        </div>

    </div>
    <!-- end Topbar -->

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left-side-menu">
        <div class="media user-profile mt-2 mb-2">
            <img src="{{ url('themes/shreyu') }}/assets/images/users/avatar-7.jpg" class="avatar-sm rounded-circle mr-2" alt="Shreyu" />
            <img src="{{ url('themes/shreyu') }}/assets/images/users/avatar-7.jpg" class="avatar-xs rounded-circle mr-2" alt="Shreyu" />

            <div class="media-body">
                <h6 class="pro-user-name mt-0 mb-0">{{ Auth::check() ? Auth::user()->name :'Guest'  }}</h6>
                <span class="pro-user-desc">{{ Auth::check() ? \App\Helpers\AuthUtil::getRoleName(Auth::user()->roleId)  :'Guest'  }}</span>
            </div>
            <div class="dropdown align-self-center profile-dropdown-menu">
                <a class="dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                   aria-expanded="false">
                    <span data-feather="chevron-down"></span>
                </a>
                <div class="dropdown-menu profile-dropdown">
                    <a href="{{ url('profile') }}" class="dropdown-item notify-item">
                        <i data-feather="user" class="icon-dual icon-xs mr-2"></i>
                        <span>My Account</span>
                    </a>

                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i data-feather="settings" class="icon-dual icon-xs mr-2"></i>
                        <span>Settings</span>
                    </a>

                    {{--<a href="javascript:void(0);" class="dropdown-item notify-item">--}}
                        {{--<i data-feather="help-circle" class="icon-dual icon-xs mr-2"></i>--}}
                        {{--<span>Support</span>--}}
                    {{--</a>--}}

                    {{--<a href="pages-lock-screen.html" class="dropdown-item notify-item">--}}
                        {{--<i data-feather="lock" class="icon-dual icon-xs mr-2"></i>--}}
                        {{--<span>Lock Screen</span>--}}
                    {{--</a>--}}

                    <div class="dropdown-divider"></div>

                    <a href="javascript:void(0);" class="dropdown-item notify-item"
                       onclick="event.preventDefault();document.getElementById('logout-form-2').submit();" >
                        <i data-feather="log-out" class="icon-dual icon-xs mr-2"></i>
                        <span>Logout</span>
                    </a>

                    <form id="logout-form-2" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </div>
            </div>
        </div>
        <div class="sidebar-content">
            <!--- Sidemenu -->
            <div id="sidebar-menu" class="slimscroll-menu">
                @include('partials.nav.shreyu.nav')
            </div>
            <!-- End Sidebar -->

            <div class="clearfix"></div>
        </div>
        <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page"  id="app">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row page-title">
                    <div class="col-md-12">
                        <nav aria-label="breadcrumb" class="float-right mt-1">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">{{ env('SITE_TITLE','')  }}</a></li>
                                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Advanced</li>
                            </ol>
                        </nav>
                        <h4 class="mb-1 mt-0">{{ $title??'' }}</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        @yield('content')
                    </div><!-- end col-->
                </div>
                <!-- end row-->

            </div> <!-- container-fluid -->

        </div> <!-- content -->



        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        2019 &copy; Shreyu. All Rights Reserved. Crafted with <i class='uil uil-heart text-danger font-size-12'></i> by <a href="https://coderthemes.com" target="_blank">Coderthemes</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>

    @yield('modal')

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

<!-- Right Sidebar -->
<div class="right-bar">
    <div class="rightbar-title">
        <a href="javascript:void(0);" class="right-bar-toggle float-right">
            <i data-feather="x-circle"></i>
        </a>
        <h5 class="m-0">Customization</h5>
    </div>

    <div class="slimscroll-menu">

        <h5 class="font-size-16 pl-3 mt-4">Choose Variation</h5>
        <div class="p-3">
            <h6>Default</h6>
            <a href="index.html"><img src="{{ url('themes/shreyu') }}/assets/images/layouts/vertical.jpg" alt="vertical" class="img-thumbnail demo-img" /></a>
        </div>
        <div class="px-3 py-1">
            <h6>Top Nav</h6>
            <a href="layouts-horizontal.html"><img src="{{ url('themes/shreyu') }}/assets/images/layouts/horizontal.jpg" alt="horizontal" class="img-thumbnail demo-img" /></a>
        </div>
        <div class="px-3 py-1">
            <h6>Dark Side Nav</h6>
            <a href="layouts-dark-sidebar.html"><img src="{{ url('themes/shreyu') }}/assets/images/layouts/vertical-dark-sidebar.jpg" alt="dark sidenav" class="img-thumbnail demo-img" /></a>
        </div>
        <div class="px-3 py-1">
            <h6>Condensed Side Nav</h6>
            <a href="layouts-dark-sidebar.html"><img src="{{ url('themes/shreyu') }}/assets/images/layouts/vertical-condensed.jpg" alt="condensed" class="img-thumbnail demo-img" /></a>
        </div>
        <div class="px-3 py-1">
            <h6>Fixed Width (Boxed)</h6>
            <a href="layouts-boxed.html"><img src="{{ url('themes/shreyu') }}/assets/images/layouts/boxed.jpg" alt="boxed"
                                              class="img-thumbnail demo-img" /></a>
        </div>
    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- Vendor js -->
<script src="{{ url('themes/shreyu') }}/assets/js/vendor.min.js"></script>

<!-- App js -->
<script src="{{ url('themes/shreyu') }}/assets/js/app.min.js"></script>

</body>
</html>
