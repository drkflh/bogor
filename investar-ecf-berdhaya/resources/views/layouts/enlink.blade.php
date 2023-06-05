<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ env('SITE_NAME','') }} - {{ env('SITE_TITLE') }}</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;200&family=Merriweather+Sans:wght@300&family=Nunito+Sans:wght@200&family=Overpass:wght@100&display=swap');
    </style>
    <link href="{{ url('themes/enlink') }}/assets/css/app.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ url('line-awesome-master/dist/font-awesome-line-awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ url('line-awesome-master/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('themes/nobleui/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">

    <!-- loader styles -->
    <link rel="stylesheet" href="{{ url('themes/loaders/dots.css') }}">
    <link rel="stylesheet" href="{{ url(  'css/theme/enlink.css'  ) }}">
    <link rel="stylesheet" href="{{ url(  env('APP_CSS', 'css/parama.css')  ) }}">

    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ url(env('APP_FAVICON', 'favicon.ico')) }}" />

    <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>

    <script src="{{ url(mix('js/manifest.js')) }}"></script>
    <script src="{{ url(mix('js/vendor.js')) }}"></script>
    <script src="{{ url(mix('js/app.js')) }}"></script>

    @yield('js')


</head>

<body onload="spinner()">

    <div class="app" id="content-block" style="visibility: hidden;display:none;" >
        <div class="layout" >
            <!-- Header START -->
            <div class="header">
                <div class="logo logo-dark d-flex align-items-center justify-content-around">
                    <a href="{{ url('/') }}">
                        <img src="{{ url( env('APP_LOGO_LIGHT') ) }}" alt="Logo" height="45">
                        <img class="logo-fold" src="{{ url( env('APP_FAVICON') ) }}" alt="Logo" height="45">
                    </a>
                    @if(env('LOGO_TEXT', false ))
                        <h4 class="logo-text">{{ env('SITE_TITLE') }}</h4>
                    @endif
                </div>
                <div class="logo logo-white">
                    <a href="{{ url('/') }}">
                        <img src="{{ url( env('APP_LOGO_LIGHT') ) }}" alt="Logo" height="45">
                        <img class="logo-fold" src="{{ url( env('APP_FAVICON') ) }}" alt="Logo" height="45">
                    </a>
                    @if(env('LOGO_TEXT', false ))
                        <h4 class="logo-text">{{ env('SITE_TITLE') }}</h4>
                    @endif
                </div>
                <div class="nav-wrap">
                    <ul class="nav-left">
                        <li class="desktop-toggle">
                            <a href="#">
                                <i class="anticon"></i>
                            </a>
                        </li>
                        <li class="mobile-toggle">
                            <a href="#">
                                <i class="anticon"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#search-drawer">
                                <i class="anticon anticon-search"></i>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav-right">
                        <li class="dropdown dropdown-animated scale-left">
                            <a href="#" data-toggle="dropdown">
                                <i class="anticon anticon-bell notification-badge"></i>
                            </a>
                            <div class="dropdown-menu pop-notification">
                                <div class="p-v-15 p-h-25 border-bottom d-flex justify-content-between align-items-center">
                                    <p class="text-dark font-weight-semibold m-b-0">
                                        <i class="anticon anticon-bell"></i>
                                        <span class="m-l-10">Notification</span>
                                    </p>
                                    <a class="btn-sm btn-default btn" href="#">
                                        <small>View All</small>
                                    </a>
                                </div>
                                <div class="relative">
                                    <div class="overflow-y-auto relative scrollable" style="max-height: 300px">
                                        <a href="#" class="dropdown-item d-block p-15 border-bottom">
                                            <div class="d-flex">
                                                <div class="avatar avatar-blue avatar-icon">
                                                    <i class="anticon anticon-mail"></i>
                                                </div>
                                                <div class="m-l-15">
                                                    <p class="m-b-0 text-dark">You received a new message</p>
                                                    <p class="m-b-0"><small>8 min ago</small></p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item d-block p-15 border-bottom">
                                            <div class="d-flex">
                                                <div class="avatar avatar-cyan avatar-icon">
                                                    <i class="anticon anticon-user-add"></i>
                                                </div>
                                                <div class="m-l-15">
                                                    <p class="m-b-0 text-dark">New user registered</p>
                                                    <p class="m-b-0"><small>7 hours ago</small></p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown dropdown-animated scale-left">
                            <div class="pointer" data-toggle="dropdown">
                                <div class="avatar avatar-image  m-h-10 m-r-15">
                                    @if(Auth::check())
                                        <img src="{{ Auth::user()->avatar }}"
                                             onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/coffee.png' ) ) }}';"
                                             class="user-img" alt="{{Auth::user()->name}}'s Profile Pic">
                                    @endif
                                </div>
                            </div>
                            <div class="p-b-15 p-t-20 dropdown-menu pop-profile">
                                <div class="p-h-20 p-b-15 m-b-10 border-bottom">
                                    <div class="d-flex m-r-50">
                                        <div class="avatar avatar-lg avatar-image">
                                            @if(Auth::check())
                                                <img src="{{ Auth::user()->avatar }}"
                                                     onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/coffee.png' ) ) }}';"
                                                     class="user-img" alt="{{Auth::user()->name}}'s Profile Pic">
                                            @endif
                                        </div>
                                        <?php
                                            //$lang = Auth::user()->lang ?? env('DEFAULT_LANG');
                                            $langList = config('util.languages');
                                            $lang = App::currentLocale();
                                            $lang = trim($lang) == '' || is_null($lang) ? env('DEFAULT_LANG', 'en'): strtolower($lang);
                                            $lang = $langList[ $lang];
                                        ?>
                                        <div class="m-l-10">
                                            <p class="m-b-0 text-dark font-weight-semibold">{{ Auth::user()->name }}</p>
                                            <p class="m-b-0 opacity-07">{{ \App\Helpers\AuthUtil::getRoleName(Auth::user()->roleId ) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="#" class="dropdown-item d-block p-h-15 p-v-10">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="anticon opacity-04 font-size-16 anticon-user"></i>
                                            <span class="m-l-10">Edit Profile</span>
                                        </div>
                                        <i class="anticon font-size-10 anticon-right"></i>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item d-block p-h-15 p-v-10">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="anticon opacity-04 font-size-16 anticon-lock"></i>
                                            <span class="m-l-10">Account Setting</span>
                                        </div>
                                        <i class="anticon font-size-10 anticon-right"></i>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item d-block p-h-15 p-v-10">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="anticon opacity-04 font-size-16 anticon-project"></i>
                                            <span class="m-l-10">Projects</span>
                                        </div>
                                        <i class="anticon font-size-10 anticon-right"></i>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item d-block p-h-15 p-v-10">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="anticon opacity-04 font-size-16 anticon-logout"></i>
                                            <span class="m-l-10">Logout</span>
                                        </div>
                                        <i class="anticon font-size-10 anticon-right"></i>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#quick-view">
                                <i class="anticon anticon-appstore"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Header END -->

            <!-- Side Nav START -->
            <div class="side-nav">
                <div class="side-nav-inner">
                    @if( View::exists('partials.nav.enlink.nav') )
                        @include('partials.nav.enlink.nav')
                    @endif
                </div>
            </div>
            <!-- Side Nav END -->

            <!-- Page Container START -->
            <div class="page-container">

                <!-- Content Wrapper START -->
                <div class="main-content" id="app">
                    <div class="page-header">
                        <h2 class="">{{ $title }}</h2>
{{--                        <div class="header-sub-title">--}}
{{--                            <nav class="breadcrumb breadcrumb-dash">--}}
{{--                                <a href="{{ url('themes/enlink') }}/#" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>--}}
{{--                                <a class="breadcrumb-item" href="{{ url('themes/enlink') }}/#">Breadcrumb 1</a>--}}
{{--                                <span class="breadcrumb-item active">Breadcrumb 2</span>--}}
{{--                            </nav>--}}
{{--                        </div>--}}
                    </div>
                    @yield('content')
                    @yield('modal')
                    <!-- Content goes Here -->
                </div>
                <!-- Content Wrapper END -->

                <!-- Footer START -->
                <footer class="footer">
                    <div class="footer-content">
                        <p class="m-b-0">Copyright © 2019 Theme_Nate. All rights reserved.</p>
                        <span>
                            <a href="{{ url('themes/enlink') }}/" class="text-gray m-r-15">Term &amp; Conditions</a>
                            <a href="{{ url('themes/enlink') }}/" class="text-gray">Privacy &amp; Policy</a>
                        </span>
                    </div>
                </footer>
                <!-- Footer END -->

            </div>
            <!-- Page Container END -->
            <div id="spinner_" class="overlay" style="background: white;opacity:1;position:fixed; top:0;left:0;width: 100%;height:100%;display:block;" >
                <div class="vertical-centered-box">
                    <div class="content">
                        <div class="loader-circle"></div>
                        <div class="loader-line-mask one">
                            <div class="loader-line"></div>
                        </div>
                        <div class="loader-line-mask two">
                            <div class="loader-line"></div>
                        </div>
                        <div class="loader-line-mask three">
                            <div class="loader-line"></div>
                        </div>
                        <div class="loader-line-mask four">
                            <div class="loader-line"></div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Search Start-->
            <div class="modal modal-left fade search" id="search-drawer">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header justify-content-between align-items-center">
                            <h5 class="modal-title">Search</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <i class="anticon anticon-close"></i>
                            </button>
                        </div>
                        <div class="modal-body scrollable">
                            <div class="input-affix">
                                <i class="prefix-icon anticon anticon-search"></i>
                                <input type="text" class="form-control" placeholder="Search">
                            </div>
                            <!-- Content goes Here -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Search End-->

            <!-- Quick View START -->
            <div class="modal modal-right fade quick-view" id="quick-view">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header justify-content-between align-items-center">
                            <h5 class="modal-title">Quick View</h5>
                        </div>
                        <div class="modal-body scrollable">
                            <!-- Content goes Here -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Quick View END -->
        </div>
    </div>


    <!-- page js -->
    <script type="application/javascript">
        function spinner() {
            setTimeout(() => {
                document.getElementById("spinner_").style.display = "none";
                document.getElementById("app").style.display = "block";
                document.getElementById("content-block").style.display = "block";
                document.getElementById("content-block").style.visibility = "visible";
            }, 900);
        }
    </script>

    <!-- Core Vendors JS -->
{{--    <script src="{{ url('themes/enlink') }}/assets/js/vendors.min.js"></script>--}}
    <script src="{{ url('themes/enlink') }}/assets/js/vendors/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>

    <!-- Core JS -->
    <script src="{{ url('themes/enlink') }}/assets/js/app.min.js"></script>

</body>

</html>
