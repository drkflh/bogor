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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Overpass&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
    <link rel="stylesheet" id="css-main" href="{{ url('themes/codebase') }}/assets/css/codebase.min.css">

    <link href="{{ url('/') }}/lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

    <script src="{{ url(mix('js/app.js')) }}"></script>

    @yield('js')

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/flat.min.css"> -->
    <!-- END Stylesheets -->

    <style>
        body, .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
            font-family: "IBM Plex Sans",Muli,-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
        }

        .row{
            margin-left: 0px !important;
        }
    </style>

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
<div id="page-container" class="main-content-boxed">

    <!-- Main Container -->
    <main id="main-container">

        <!-- Page Content -->
        <div class="bg-body-dark bg-pattern">
            <div class="row mx-0 justify-content-center">
                <div class="col-lg-12 col-xl-12">
                    <div class="content content-full overflow-hidden">
                        <!-- Header -->
                        <div class="py-30 text-left">
                            <a class="link-effect font-w700" href="{{ url('/') }}">
                                <img src="{{ url( env('APP_LOGO') ) }}" height="65" />
                            </a>
                        </div>
                        <div class="row">
                            <div style="width: 100%;background-size: cover ;background-image: url( {{ url('images/app/dms/login-fg.png')  }} ); background-position: left top" class="col-8" >

                            </div>
                            <div style="width:500px;" class="col-4 pull-right">
                                <!-- Sign In Form -->
                                <!-- jQuery Validation functionality is initialized with .js-validation-signin class in js/pages/op_auth_signin.min.js which was auto compiled from _es6/pages/op_auth_signin.js -->
                                <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                                <form action="{{ route('login') }}" method="post">
                                    @csrf

                                    <div class="block block-themed block-rounded block-shadow">
                                        <div class="block-content">
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    {{--<label for="login-username">Email</label>--}}
                                                    {{--<input type="text" id="email" name="email"  class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}

                                                    {{--@error('email')--}}
                                                    {{--<span class="invalid-feedback" role="alert">--}}
                                                    {{--<strong>{{ $message }}</strong>--}}
                                                    {{--</span>--}}
                                                    {{--@enderror--}}

                                                    <input id="login" type="text"
                                                           class="form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
                                                           name="login" value="{{ old('username') ?: old('email') }}" required autofocus>

                                                    @if ($errors->has('username') || $errors->has('email'))
                                                        <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label for="login-password">Password</label>
                                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror

                                                </div>
                                            </div>
                                            <div class="form-group row m-10">
                                                <div class="col-sm-5 d-sm-flex align-items-center pull-left">
                                                    <div class="custom-control custom-checkbox mr-auto ml-0 mb-0 mt-10">
                                                        <input class="custom-control-input" type="checkbox" name="remember" id="remember"  {{ old('remember') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="remember">Remember Me</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 text-sm-right pull-right">
                                                    <button type="submit" class="btn btn-alt-primary">
                                                        <i class="si si-login mr-10"></i> Sign In
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="block-content bg-body-light">
                                            <div class="form-group text-center">
                                                <a class="link-effect text-muted ml-20 mr-10 mb-5 d-inline-block pull-left" href="{{ url('register') }}">
                                                    <i class="las la-plus mr-5"></i> Create Account
                                                </a>
                                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block pull-right" href="{{ url('resetpass') }}">
                                                    <i class="las la-warning mr-5"></i> Forgot Password
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- END Sign In Form -->

                            </div>
                        </div>
                        <!-- END Header -->

                    </div>
                </div>
            </div>
        </div>
        <!-- END Page Content -->

    </main>
    <!-- END Main Container -->
</div>
<!-- END Page Container -->

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
<script src="{{ url('themes/codebase') }}/assets/js/codebase.core.min.js"></script>

<!--
    Codebase JS

    Custom functionality including Blocks/Layout API as well as other vital and optional helpers
    webpack is putting everything together at assets/_es6/main/app.js
-->
<script src="{{ url('themes/codebase') }}/assets/js/codebase.app.min.js"></script>

<!-- Page JS Plugins -->
<script src="{{ url('themes/codebase') }}/assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>

<!-- Page JS Code -->
<script src="{{ url('themes/codebase') }}/assets/js/pages/op_auth_signup.min.js"></script>
</body>
</html>
