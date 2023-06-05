<!doctype html>
<html lang="en" class="no-focus">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

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

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ url('themes/codebase') }}/assets/media/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ url('themes/codebase') }}/assets/media/favicons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('themes/codebase') }}/assets/media/favicons/apple-touch-icon-180x180.png">
    <!-- END Icons -->

    <!-- Stylesheets -->

    <!-- Fonts and Codebase framework -->
    <link rel="stylesheet" id="css-main" href="{{ url('themes/codebase') }}/assets/css/fonts.css">
    {{--<link href="https://fonts.googleapis.com/css?family=Merriweather|Merriweather+Sans&display=swap" rel="stylesheet">--}}
    <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:ital,wght@0,300;0,400;0,700;0,800;1,300;1,400;1,700;1,800&display=swap" rel="stylesheet">
    {{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap">--}}
    {{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Overpass&display=swap">--}}
    {{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">--}}
    <link rel="stylesheet" id="css-main" href="{{ url('themes/codebase') }}/assets/css/codebase.min.css">
    <link rel="stylesheet" id="css-main" href="{{ url('themes/codebase') }}/assets/css/themes/elegance.css">

    <link href="{{ url('/') }}/lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

    {{--<script src="{{ url('themes/codebase') }}/assets/js/core/jquery.min.js"></script>--}}

    <script src="{{ url(mix('js/app.js')) }}"></script>

    <link href="{{ url('/') }}/css/kmn_framework.css" rel="stylesheet">

    @yield('js')

    <style>

        legend{
            font-weight: 900;
            font-size: 1.1rem !important;
            line-height: 2.8em !important;
        }
        hr {
            border-top-color: lightgray;
        }

        .nav-tabs {
            overflow-x: scroll;
            overflow-y: hidden;
            display: -webkit-box;
            display: -moz-box;
        }

        .custom-checkbox label{
            margin-top: 0px;
        }

        h6.obj-section{
            font-weight: 900;
            font-size: 1.2rem !important;
        }


        .table thead th {
            border-top: none;
            border-bottom: none;
            font-weight: 600;
            text-transform: capitalize;
            vertical-align: top;
        }

        .table tr td {
            vertical-align: middle;
        }

        .nav-main .nav-main-heading {
            padding: 11px 18px 6px 18px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: .55;
        }
    </style>

<!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="{{ url('themes/codebase') }}/assets/css/themes/flat.min.css"> -->
    <!-- END Stylesheets -->
</head>
<body>

<!-- Page Container -->
<!--
    Available classes for #page-container:

GENERIC

    'enable-cookies'                            Remembers active color theme between pages (when set through color theme helper Template._uiHandleTheme())

SIDEBAR & SIDE OVERLAY

    'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
    'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
    'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
    'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
    'sidebar-inverse'                           Dark themed sidebar

    'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
    'side-overlay-o'                            Visible Side Overlay by default

    'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

    'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

HEADER

    ''                                          Static Header if no class is added
    'page-header-fixed'                         Fixed Header

HEADER STYLE

    ''                                          Classic Header style if no class is added
    'page-header-modern'                        Modern Header style
    'page-header-inverse'                       Dark themed Header (works only with classic Header style)
    'page-header-glass'                         Light themed Header with transparency by default
                                                (absolute position, perfect for light images underneath - solid light background on scroll if the Header is also set as fixed)
    'page-header-glass page-header-inverse'     Dark themed Header with transparency by default
                                                (absolute position, perfect for dark images underneath - solid dark background on scroll if the Header is also set as fixed)

MAIN CONTENT LAYOUT

    ''                                          Full width Main Content if no class is added
    'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
    'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)
-->
<div id="page-container" class="{{ env('SIDEBAR_DEFAULT_OPEN', true)?'sidebar-o':'sidebar' }} enable-page-overlay side-scroll page-header-modern">
    <!-- Side Overlay-->
        @include('partials.app.kmn.codebase.rightsidebar',['right_sidebar_model'=>$right_sidebar_model,'right_sidebar_data'=>$right_sidebar_data,'right_sidebar_params'=>$right_sidebar_params,'right_sidebar_template'=>$right_sidebar_template])



    <!-- END Side Overlay -->

    <!-- Sidebar -->
    <!--
        Helper classes

        Adding .sidebar-mini-hide to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
        Adding .sidebar-mini-show to an element will make it visible (opacity: 1) when the sidebar is in mini mode
            If you would like to disable the transition, just add the .sidebar-mini-notrans along with one of the previous 2 classes

        Adding .sidebar-mini-hidden to an element will hide it when the sidebar is in mini mode
        Adding .sidebar-mini-visible to an element will show it only when the sidebar is in mini mode
            - use .sidebar-mini-visible-b if you would like to be a block when visible (display: block)
    -->
    <nav id="sidebar">
        <!-- Sidebar Content -->
        <div class="sidebar-content">
            <!-- Side Header -->
            <div class="content-header content-header-fullrow px-15">
                <!-- Mini Mode -->
                <div class="content-header-section sidebar-mini-visible-b">
                    <!-- Logo -->
                    <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                                <span class="text-dual-primary-dark">c</span><span class="text-primary">b</span>
                            </span>
                    <!-- END Logo -->
                </div>
                <!-- END Mini Mode -->

                <!-- Normal Mode -->
                <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                    <!-- Close Sidebar, Visible only on mobile screens -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                        <i class="fa fa-times text-danger"></i>
                    </button>
                    <!-- END Close Sidebar -->

                    <!-- Logo -->
                    <div class="content-header-item">
                        <a class="link-effect font-w700" href="{{ url( env('AUTH_REDIRECT_TO','/') ) }}">
                            <img src="{{ url( env('APP_LOGO') ) }}" height="35" />
                            {{--<i class="si si-fire text-primary"></i>--}}
                            {{--<span class="font-size-xl text-dual-primary-dark">code</span><span class="font-size-xl text-primary">base</span>--}}
                        </a>
                    </div>
                    <!-- END Logo -->
                </div>
                <!-- END Normal Mode -->
            </div>
            <!-- END Side Header -->

            <!-- Side User -->
            <div class="content-side content-side-full px-10 align-parent">
                <!-- Visible only in mini mode -->
                {{--<div class="sidebar-mini-visible-b align-v animated fadeIn">--}}
                    {{--<img class="img-avatar img-avatar32" src="{{ url('themes/codebase') }}/assets/media/avatars/avatar15.jpg" alt="">--}}
                {{--</div>--}}
                <!-- END Visible only in mini mode -->

                <!-- Visible only in normal mode -->
                <div class="sidebar-mini-hidden-b text-center">
                    {{--<a class="img-link" href="be_pages_generic_profile.html">--}}
                        {{--<img class="img-avatar" src="{{ url('themes/codebase') }}/assets/media/avatars/avatar15.jpg" alt="">--}}
                    {{--</a>--}}
                    <ul class="list-inline mt-10">
                        <li class="list-inline-item">
                            <a class="link-effect text-dual-primary-dark font-size-xs font-w600 text-uppercase" href="be_pages_generic_profile.html">{{ Auth::check() ? Auth::user()->name :'Guest'  }}</a>
                        </li>
                        <li class="list-inline-item">
                            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                            <a class="link-effect text-dual-primary-dark" data-toggle="layout" data-action="sidebar_style_inverse_toggle" href="javascript:void(0)">
                                <i class="fa fa-sun-o"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="link-effect text-dual-primary-dark" href="" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();" >
                                <i class="si si-logout"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- END Visible only in normal mode -->
            </div>
            <!-- END Side User -->

            <!-- Side Navigation -->
            <div class="content-side content-side-full">
                @include('partials.nav.codebase.nav')
            </div>
            <!-- END Side Navigation -->
        </div>
        <!-- Sidebar Content -->
    </nav>
    <!-- END Sidebar -->

    <script>
        $(document).ready(function(){
            infobarvm = new Vue({
                mounted(){
                    console.log('sidebar_mounted');
                },
                data: function(){
                    return {
                        infoHeader: '{{ $info_topbar_header }}',
                        infoModel: {!! json_encode( $info_topbar_model ?? new ArrayObject() ) !!},
                        infoDefault: {!! json_encode( $info_topbar_model ?? new ArrayObject() ) !!},
                        infoContent: {!! json_encode( $info_topbar_model ?? new ArrayObject() ) !!},
                        infoParams: {!! json_encode( $info_topbar_params ?? new ArrayObject() ) !!},
                        infoTemplate: {!! is_array($info_topbar_template)? json_encode($info_topbar_template) : $info_topbar_template !!},

                        printTemplate: {!! is_array($print_template)? json_encode($print_template) : $print_template !!},

                        printData: {},

                        @if($info_topbar_show)
                        topBarShow: true,
                    @else
                        topBarShow: false,
                    @endif
                    }
                },
                methods: {
                    getData(){
                        return this.infoModel;
                    },
                    setHeader(val){
                        this.infoHeader = val;
                        this.infoContent.infoHeader = val;
                    },
                    setContent(val){
                        this.infoContent.info = val.info;
                        this.infoContent.alergi = val.alergi;
                        this.infoContent.kondisikhusus = val.kondisikhusus;
                    },
                    setPrintContent(val){
                        this.printData = val;
                    }
                }
            }).$mount('#top-overlay');
        });
    </script>
    <!-- Header -->
    <header id="page-header">
        <!-- Header Content -->
        <div class="content-header">
            <!-- Left Section -->
            <div class="content-header-section" id="top-overlay"  >
                <!-- Toggle Sidebar -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="sidebar_toggle">
                    <i class="fa fa-navicon"></i>
                </button>

                <!--arch Section -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                {{--<button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="header_search_on">--}}
                    {{--<i class="fa fa-search"></i>--}}
                {{--</button>--}}
                {{--<!-- END Open Search Section -->--}}

                @if($show_print_button)
                    <print-element
                            :template="printTemplate"
                            :content="printData"
                    ></print-element>
                @endif

                @if($show_title)
                    {{--<div class="btn-group" role="group">--}}
                        {{--<h3 >{{ $title }}</h3>--}}
                    {{--</div>--}}
                @endif

                @if($info_topbar_show)

                    <div style="float: right;">
                        <active-view
                                v-model="infoModel"
                                :content="infoContent"
                                :params="infoParams"
                                :template="infoTemplate"
                                :object-default="infoDefault"
                        ></active-view>

                    </div>

                @endif

            </div>
            <!-- END Left Section -->

            <!-- Right Section -->
            <div class="content-header-section">

                <!-- Toggle Side Overlay -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->

                @if($info_topbar_show)
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown" data-toggle="layout" data-action="side_overlay_toggle">
                            <i class="fa fa-plus-circle"></i> <span class="d-none d-sm-inline-block">Data Tambahan</span>
                        </button>
                    </div>

                @endif

                {{--<button type="button" class="btn btn-dual-secondary" data-toggle="layout" data-action="side_overlay_toggle">--}}
                    {{--<i class="fa fa-2x fa-info-circle"></i> Data Tambahan--}}
                {{--</button>--}}
                <!-- END Toggle Side Overlay -->
                <!-- User Dropdown -->
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user d-sm-none"></i>
                        <span class="d-none d-sm-inline-block"  style="font-size: 12px;" >{{ Auth::check() ? Auth::user()->name :'Guest'  }} - {{ Auth::check() ? ( Auth::user()->docCode??'') :''  }}</span>
                        <i class="fa fa-angle-down ml-5"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right min-width-200" aria-labelledby="page-header-user-dropdown">
                        <h5 class="h6 text-center py-10 mb-5 border-b text-uppercase">User</h5>
                        <a class="dropdown-item" href="{{ url('profile') }}">
                            <i class="si si-user mr-5"></i> Profile
                        </a>
                        <!-- Toggle Side Overlay -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <a class="dropdown-item" href="{{ url('setting') }}" >
                            <i class="si si-wrench mr-5"></i> Settings
                        </a>
                        <!-- END Side Overlay -->
                        {{--<a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ url('inbox') }}">--}}
                            {{--<span><i class="si si-envelope-open mr-5"></i> Inbox</span>--}}
                            {{--<span class="badge badge-primary">3</span>--}}
                        {{--</a>--}}

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href=""  onclick="event.preventDefault();
                                 document.getElementById('logout-form-2').submit();" >
                            <i class="si si-logout mr-5"></i> Sign Out
                        </a>
                        <form id="logout-form-2" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </div>
                </div>
                <!-- END User Dropdown -->

            </div>
            <!-- END Right Section -->
        </div>
        <!-- END Header Content -->

        <!-- Header Search -->
        <div id="page-header-search" class="overlay-header">
            <div class="content-header content-header-fullrow">
                <form action="be_pages_generic_search.html" method="post">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <!-- Close Search Section -->
                            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                            <button type="button" class="btn btn-secondary" data-toggle="layout" data-action="header_search_off">
                                <i class="fa fa-times"></i>
                            </button>
                            <!-- END Close Search Section -->
                        </div>
                        <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END Header Search -->

        <!-- Header Loader -->
        <!-- Please check out the Activity page under Elements category to see examples of showing/hiding it -->
        <div id="page-header-loader" class="overlay-header bg-primary">
            <div class="content-header content-header-fullrow text-center">
                <div class="content-header-item">
                    <i class="fa fa-sun-o fa-spin text-white"></i>
                </div>
            </div>
        </div>
        <!-- END Header Loader -->
    </header>
    <!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">

        <!-- Page Content -->
        <div class="content" id="app">
            @yield('content')
        </div>
        <!-- END Page Content -->

    </main>
    <!-- END Main Container -->

    <!-- Footer -->
    <footer id="page-footer" class="opacity-0">
        <div class="content py-20 font-size-xs clearfix">
            {{--<div class="float-right">--}}
                {{--Crafted with <i class="fa fa-heart text-pulse"></i> by <a class="font-w600" href="https://1.envato.market/ydb" target="_blank">pixelcave</a>--}}
            {{--</div>--}}
            <div class="float-left">
                <a class="font-w600" href="{{ env('APP_URL') }}" target="_blank">{{ env('SITE_TITLE') }}</a> &copy; <span class="js-year-copy"></span>
            </div>
        </div>
    </footer>
    <!-- END Footer -->
</div>
<!-- END Page Container -->
@yield('modal')

<!--
    Codebase JS Core

    Vital libraries and plugins used in all pages. You can choose to not include this file if you would like
    to handle those dependencies through webpack. Please check out assets/_es6/main/bootstrap.js for more info.

    If you like, you could also include them separately directly from the assets/js/core folder in the following
    order. That can come in handy if you would like to include a few of them (eg jQuery) from a CDN.

    assets/js/core/jquery.min.js
    assets/js/core/bootstrap.bundle.min.js
    assets/js/core/simplebar.min.js
    assets/js/core/jquery-scrollLock.min.js
    assets/js/core/jquery.appear.min.js
    assets/js/core/jquery.countTo.min.js
    assets/js/core/js.cookie.min.js
-->
{{--<script src="{{ url('themes/codebase') }}/assets/js/core/bootstrap.bundle.min.js"></script>--}}
<script src="{{ url('themes/codebase') }}/assets/js/core/simplebar.min.js"></script>
<script src="{{ url('themes/codebase') }}/assets/js/core/jquery-scrollLock.min.js"></script>
<script src="{{ url('themes/codebase') }}/assets/js/core/jquery.appear.min.js"></script>
<script src="{{ url('themes/codebase') }}/assets/js/core/jquery.countTo.min.js"></script>
<script src="{{ url('themes/codebase') }}/assets/js/core/js.cookie.min.js"></script>

{{--<script src="{{ url('themes/codebase') }}/assets/js/codebase.core.min.js"></script>--}}

<!--
    Codebase JS

    Custom functionality including Blocks/Layout API as well as other vital and optional helpers
    webpack is putting everything together at assets/_es6/main/app.js
-->
<script src="{{ url('themes/codebase') }}/assets/js/codebase.app.min.js"></script>
</body>
</html>
