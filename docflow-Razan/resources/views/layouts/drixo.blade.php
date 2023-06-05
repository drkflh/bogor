<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{ env('SITE_NAME','').' - ' }}{{ $title }}</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{ url('themes/drixo') }}/assets/images/favicon.ico">

    <!-- DataTables -->
    {{--<link href="{{ url('themes/drixo') }}/assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />--}}
    {{--<link href="{{ url('themes/drixo') }}/assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />--}}
    <!-- Responsive datatable examples -->
    {{--<link href="{{ url('themes/drixo') }}/assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />--}}
    <link rel="stylesheet" href="{{ url('themes/drixo') }}/assets/plugins/morris/morris.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Overpass&display=swap">

    <link href="{{ url('themes/drixo') }}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{ url('themes/drixo') }}/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="{{ url('themes/drixo') }}/assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="{{ url('/') }}/lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/lib/ionicons/css/ionicons.min.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ url(mix('js/app.js')) }}"></script>

    @yield('js')

    <style>
        body, h1, h2, h3, h4, h5, h6 {
            font-family: "IBM Plex Sans",Muli,-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
        }

        .notification-list .noti-icon {
            font-size: 24px;
            padding: 0 10px;
            vertical-align: middle;
            color: white;
        }
    </style>
</head>


<body class="fixed-left">

<!-- Loader -->
<div id="preloader"><div id="status"><div class="spinner"></div></div></div>

<!-- Begin page -->
<div id="wrapper">

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">
        <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
            <i class="ion-close"></i>
        </button>

        <div class="left-side-logo d-block d-lg-none">
            <div class="text-center">

                <a href="{{ url('/') }}" class="logo"><img src="{{ url($logo) }}" height="20" alt="logo"></a>
            </div>
        </div>

        <div class="sidebar-inner slimscrollleft">

            <div id="sidebar-menu">
                @include('partials.nav.drixo.nav')
            </div>
            <div class="clearfix"></div>
        </div> <!-- end sidebarinner -->
    </div>
    <!-- Left Sidebar End -->

    <!-- Start right Content here -->

    <div class="content-page">
        <!-- Start content -->
        <div class="content">

            <!-- Top Bar Start -->
            <div class="topbar">

                <div class="topbar-left	d-none d-lg-block" >
                    <div class="text-center">

                        <a href="{{ url('/') }}" class="logo"><img src="{{ url($logo) }}" height="50" alt="logo"></a>
                    </div>
                </div>

                <nav class="navbar-custom" >

                    <ul class="list-inline float-right mb-0">
                        <li class="list-inline-item notification-list dropdown d-none d-sm-inline-block">
                            <form role="search" class="app-search">
                                <div class="form-group mb-0">
                                    <input type="text" class="form-control" placeholder="Search..">
                                    <button type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </li>
                        <li class="list-inline-item dropdown notification-list">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="false" aria-expanded="false">
                                <i class="mdi mdi-email-outline noti-icon"></i>
                                <span class="badge badge-danger badge-pill noti-icon-badge">5</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-lg">
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <span class="badge badge-danger float-right">367</span>
                                    <h5>Messages</h5>
                                </div>
                                <div class="slimscroll" style="max-height: 230px;">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon"><img src="{{ url('themes/drixo') }}/assets/images/users/user-2.jpg" alt="user-img" class="img-fluid rounded-circle" /> </div>
                                        <p class="notify-details"><b>Charles M. Jones</b><span class="text-muted">Dummy text of the printing and typesetting industry.</span></p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon"><img src="{{ url('themes/drixo') }}/assets/images/users/user-3.jpg" alt="user-img" class="img-fluid rounded-circle" /> </div>
                                        <p class="notify-details"><b>Thomas J. Mimms</b><span class="text-muted">You have 87 unread messages</span></p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon"><img src="{{ url('themes/drixo') }}/assets/images/users/user-4.jpg" alt="user-img" class="img-fluid rounded-circle" /> </div>
                                        <p class="notify-details">Luis M. Konrad<span class="text-muted">It is a long established fact that a reader will</span></p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon"><img src="{{ url('themes/drixo') }}/assets/images/users/user-5.jpg" alt="user-img" class="img-fluid rounded-circle" /> </div>
                                        <p class="notify-details"><b>Kendall E. Walker</b><span class="text-muted">Dummy text of the printing and typesetting industry.</span></p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon"><img src="{{ url('themes/drixo') }}/assets/images/users/user-6.jpg" alt="user-img" class="img-fluid rounded-circle" /> </div>
                                        <p class="notify-details"><b>David M. Ryan</b><span class="text-muted">You have 87 unread messages</span></p>
                                    </a>
                                </div>


                                <!-- All-->
                                <a href="javascript:void(0);" class="dropdown-item notify-all">
                                    View All
                                </a>

                            </div>
                        </li>

                        <li class="list-inline-item dropdown notification-list">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="false" aria-expanded="false">
                                <i class="mdi mdi-bell-outline noti-icon"></i>
                                <span class="badge badge-success badge-pill noti-icon-badge">3</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-lg">
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <span class="badge badge-danger float-right">84</span>
                                    <h5>Notification</h5>
                                </div>

                                <div class="slimscroll" style="max-height: 230px;">

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-primary"><i class="mdi mdi-cart-outline"></i></div>
                                        <p class="notify-details">Your order is placed<span class="text-muted">Dummy text of the printing and typesetting industry.</span></p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-success"><i class="mdi mdi-message"></i></div>
                                        <p class="notify-details">New Message received<span class="text-muted">You have 87 unread messages</span></p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-warning"><i class="mdi mdi-martini"></i></div>
                                        <p class="notify-details">Your item is shipped<span class="text-muted">It is a long established fact that a reader will</span></p>
                                    </a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-danger"><i class="mdi mdi-message"></i></div>
                                        <p class="notify-details">New Message received<span class="text-muted">You have 87 unread messages</span></p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-info"><i class="mdi mdi-martini"></i></div>
                                        <p class="notify-details">Your item is shipped<span class="text-muted">It is a long established fact that a reader will</span></p>
                                    </a>
                                </div>

                                <!-- All-->
                                <a href="javascript:void(0);" class="dropdown-item notify-all">
                                    View All
                                </a>

                            </div>
                        </li>

                        <li class="list-inline-item dropdown notification-list">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="false" aria-expanded="false">
                                <img src="{{ url('themes/drixo') }}/assets/images/users/user-1.jpg" alt="user" class="rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
                                <a class="dropdown-item" href="{{ url('profile') }}"><i class="mdi mdi-account-circle m-r-5 text-muted"></i> Profile</a>
                                <a class="dropdown-item" href="{{ url('setting') }}"><i class="mdi mdi-settings m-r-5 text-muted"></i> Settings</a>
                                <a class="dropdown-item" href=""  onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();" ><i class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>

                            </div>
                        </li>

                    </ul>

                    <ul class="list-inline menu-left mb-0">
                        <li class="list-inline-item">
                            <button type="button" class="button-menu-mobile open-left waves-effect">
                                <i class="ion-navicon"></i>
                            </button>
                        </li>
                    </ul>

                    <div class="clearfix"></div>

                </nav>

            </div>
            <!-- Top Bar End -->

            <div class="page-content-wrapper ">

                <div class="container-fluid">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="float-right page-breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">{{ env('SITE_NAME') }}</a></li>
                                    <li class="breadcrumb-item"><a href="#">Tables</a></li>
                                    <li class="breadcrumb-item active">Datatable</li>
                                </ol>
                            </div>
                            <h5 class="page-title">{{ $title }}</h5>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row" id="app">
                        <div class="col-12">
                            <div class="card m-b-30">
                                <div class="card-body">

                                @yield('content')

                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    <div id="modalContainer">
                        @yield('modal')
                    </div>

                </div><!-- container fluid -->

            </div> <!-- Page content Wrapper -->

        </div> <!-- content -->

        <footer class="footer">
            © 2018 <b>Drixo</b> <span class="d-none d-sm-inline-block"> - Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesdesign.</span>
        </footer>

    </div>
    <!-- End Right content here -->

</div>
<!-- END wrapper -->


<!-- jQuery  -->
<script src="{{ url('themes/drixo') }}/assets/js/modernizr.min.js"></script>
<script src="{{ url('themes/drixo') }}/assets/js/detect.js"></script>
<script src="{{ url('themes/drixo') }}/assets/js/fastclick.js"></script>
<script src="{{ url('themes/drixo') }}/assets/js/jquery.slimscroll.js"></script>
<script src="{{ url('themes/drixo') }}/assets/js/jquery.blockUI.js"></script>
<script src="{{ url('themes/drixo') }}/assets/js/waves.js"></script>
<script src="{{ url('themes/drixo') }}/assets/js/jquery.nicescroll.js"></script>
<script src="{{ url('themes/drixo') }}/assets/js/jquery.scrollTo.min.js"></script>

<!-- Required datatable js -->
{{--<script src="{{ url('themes/drixo') }}/assets/plugins/datatables/jquery.dataTables.min.js"></script>--}}
{{--<script src="{{ url('themes/drixo') }}/assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>--}}
<!-- Buttons examples -->
{{--<script src="{{ url('themes/drixo') }}/assets/plugins/datatables/dataTables.buttons.min.js"></script>--}}
{{--<script src="{{ url('themes/drixo') }}/assets/plugins/datatables/buttons.bootstrap4.min.js"></script>--}}
{{--<script src="{{ url('themes/drixo') }}/assets/plugins/datatables/jszip.min.js"></script>--}}
{{--<script src="{{ url('themes/drixo') }}/assets/plugins/datatables/pdfmake.min.js"></script>--}}
{{--<script src="{{ url('themes/drixo') }}/assets/plugins/datatables/vfs_fonts.js"></script>--}}
{{--<script src="{{ url('themes/drixo') }}/assets/plugins/datatables/buttons.html5.min.js"></script>--}}
{{--<script src="{{ url('themes/drixo') }}/assets/plugins/datatables/buttons.print.min.js"></script>--}}
{{--<script src="{{ url('themes/drixo') }}/assets/plugins/datatables/buttons.colVis.min.js"></script>--}}
<!-- Responsive examples -->
{{--<script src="{{ url('themes/drixo') }}/assets/plugins/datatables/dataTables.responsive.min.js"></script>--}}
{{--<script src="{{ url('themes/drixo') }}/assets/plugins/datatables/responsive.bootstrap4.min.js"></script>--}}

<!-- Datatable init js -->
{{--<script src="{{ url('themes/drixo') }}/assets/pages/datatables.init.js"></script>--}}

<!-- App js -->
<script src="{{ url('themes/drixo') }}/assets/js/app.js"></script>

</body>
</html>
