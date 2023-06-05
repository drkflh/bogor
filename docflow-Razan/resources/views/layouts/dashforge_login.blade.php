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
    <meta property="og:image:secure_url" content="http://themepixels.me/dashforge/img/dashforge-social.png">
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


    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="author" content="ThemePixels">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('themes/dashforge') }}/assets/img/favicon.png">

    <title>DashForge Responsive Bootstrap 4 Dashboard Template</title>

    <!-- vendor css -->
    <link href="{{ url('themes/dashforge') }}/lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="{{ url('themes/dashforge') }}/lib/ionicons/css/ionicons.min.css" rel="stylesheet">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{ url('themes/dashforge') }}/assets/css/dashforge.css">
    <link rel="stylesheet" href="{{ url('themes/dashforge') }}/assets/css/dashforge.auth.css">

    <script src="{{ url(mix('js/app.js')) }}"></script>

</head>
<body>

{{--<header class="navbar navbar-header navbar-header-fixed">--}}
    {{--<a href="#" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>--}}
    {{--<div class="navbar-brand">--}}
        {{--<a href="{{ url('themes/dashforge') }}/index.html" class="df-logo">dash<span>forge</span></a>--}}
    {{--</div><!-- navbar-brand -->--}}
    {{--<div id="navbarMenu" class="navbar-menu-wrapper">--}}
        {{--<div class="navbar-menu-header">--}}
            {{--<a href="{{ url('themes/dashforge') }}/index.html" class="df-logo">dash<span>forge</span></a>--}}
            {{--<a id="mainMenuClose" href=""><i data-feather="x"></i></a>--}}
        {{--</div><!-- navbar-menu-header -->--}}
        {{--<ul class="nav navbar-menu">--}}
            {{--<li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Main Navigation</li>--}}
            {{--<li class="nav-item with-sub">--}}
                {{--<a href="" class="nav-link"><i data-feather="pie-chart"></i> Dashboard</a>--}}
                {{--<ul class="navbar-menu-sub">--}}
                    {{--<li class="nav-sub-item"><a href="dashboard-one.html" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Sales Monitoring</a></li>--}}
                    {{--<li class="nav-sub-item"><a href="dashboard-two.html" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Website Analytics</a></li>--}}
                    {{--<li class="nav-sub-item"><a href="dashboard-three.html" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Cryptocurrency</a></li>--}}
                    {{--<li class="nav-sub-item"><a href="dashboard-four.html" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Helpdesk Management</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="nav-item with-sub">--}}
                {{--<a href="" class="nav-link"><i data-feather="package"></i> Apps</a>--}}
                {{--<ul class="navbar-menu-sub">--}}
                    {{--<li class="nav-sub-item"><a href="app-calendar.html" class="nav-sub-link"><i data-feather="calendar"></i>Calendar</a></li>--}}
                    {{--<li class="nav-sub-item"><a href="app-chat.html" class="nav-sub-link"><i data-feather="message-square"></i>Chat</a></li>--}}
                    {{--<li class="nav-sub-item"><a href="app-contacts.html" class="nav-sub-link"><i data-feather="users"></i>Contacts</a></li>--}}
                    {{--<li class="nav-sub-item"><a href="app-file-manager.html" class="nav-sub-link"><i data-feather="file-text"></i>File Manager</a></li>--}}
                    {{--<li class="nav-sub-item"><a href="app-mail.html" class="nav-sub-link"><i data-feather="mail"></i>Mail</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="nav-item with-sub">--}}
                {{--<a href="" class="nav-link"><i data-feather="layers"></i> Pages</a>--}}
                {{--<div class="navbar-menu-sub">--}}
                    {{--<div class="d-lg-flex">--}}
                        {{--<ul>--}}
                            {{--<li class="nav-label">Authentication</li>--}}
                            {{--<li class="nav-sub-item"><a href="page-signin.html" class="nav-sub-link"><i data-feather="log-in"></i> Sign In</a></li>--}}
                            {{--<li class="nav-sub-item"><a href="page-signup.html" class="nav-sub-link"><i data-feather="user-plus"></i> Sign Up</a></li>--}}
                            {{--<li class="nav-sub-item"><a href="page-verify.html" class="nav-sub-link"><i data-feather="user-check"></i> Verify Account</a></li>--}}
                            {{--<li class="nav-sub-item"><a href="page-forgot.html" class="nav-sub-link"><i data-feather="shield-off"></i> Forgot Password</a></li>--}}
                            {{--<li class="nav-label mg-t-20">User Pages</li>--}}
                            {{--<li class="nav-sub-item"><a href="page-profile-view.html" class="nav-sub-link"><i data-feather="user"></i> View Profile</a></li>--}}
                            {{--<li class="nav-sub-item"><a href="page-connections.html" class="nav-sub-link"><i data-feather="users"></i> Connections</a></li>--}}
                            {{--<li class="nav-sub-item"><a href="page-groups.html" class="nav-sub-link"><i data-feather="users"></i> Groups</a></li>--}}
                            {{--<li class="nav-sub-item"><a href="page-events.html" class="nav-sub-link"><i data-feather="calendar"></i> Events</a></li>--}}
                        {{--</ul>--}}
                        {{--<ul>--}}
                            {{--<li class="nav-label">Error Pages</li>--}}
                            {{--<li class="nav-sub-item"><a href="page-404.html" class="nav-sub-link"><i data-feather="file"></i> 404 Page Not Found</a></li>--}}
                            {{--<li class="nav-sub-item"><a href="page-500.html" class="nav-sub-link"><i data-feather="file"></i> 500 Internal Server</a></li>--}}
                            {{--<li class="nav-sub-item"><a href="page-503.html" class="nav-sub-link"><i data-feather="file"></i> 503 Service Unavailable</a></li>--}}
                            {{--<li class="nav-sub-item"><a href="page-505.html" class="nav-sub-link"><i data-feather="file"></i> 505 Forbidden</a></li>--}}
                            {{--<li class="nav-label mg-t-20">Other Pages</li>--}}
                            {{--<li class="nav-sub-item"><a href="page-timeline.html" class="nav-sub-link"><i data-feather="file-text"></i> Timeline</a></li>--}}
                            {{--<li class="nav-sub-item"><a href="page-pricing.html" class="nav-sub-link"><i data-feather="file-text"></i> Pricing</a></li>--}}
                            {{--<li class="nav-sub-item"><a href="page-help-center.html" class="nav-sub-link"><i data-feather="file-text"></i> Help Center</a></li>--}}
                            {{--<li class="nav-sub-item"><a href="page-invoice.html" class="nav-sub-link"><i data-feather="file-text"></i> Invoice</a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div><!-- nav-sub -->--}}
            {{--</li>--}}
            {{--<li class="nav-item"><a href="{{ url('themes/dashforge') }}/components/" class="nav-link"><i data-feather="box"></i> Components</a></li>--}}
            {{--<li class="nav-item"><a href="{{ url('themes/dashforge') }}/collections/" class="nav-link"><i data-feather="archive"></i> Collections</a></li>--}}
        {{--</ul>--}}
    {{--</div><!-- navbar-menu-wrapper -->--}}
    {{--<div class="navbar-right">--}}
        {{--<a href="http://dribbble.com/themepixels" class="btn btn-social"><i class="fab fa-dribbble"></i></a>--}}
        {{--<a href="https://github.com/themepixels" class="btn btn-social"><i class="fab fa-github"></i></a>--}}
        {{--<a href="https://twitter.com/themepixels" class="btn btn-social"><i class="fab fa-twitter"></i></a>--}}
        {{--<a href="https://themeforest.net/item/azia-responsive-bootstrap-4-dashboard-template/22983790" class="btn btn-buy"><i data-feather="shopping-bag"></i> <span>Buy Now</span></a>--}}
    {{--</div><!-- navbar-right -->--}}
{{--</header><!-- navbar -->--}}

<div class="content content-auth" style="padding-left: 0px;">
    <div class="container-fluid" style="padding: 0px;">
        <div class="media align-items-stretch justify-content-center ht-100p pos-relative">
            <div class="media-body align-items-center d-none d-lg-flex">
                <div style="width: 100%">
                    <img style="width: 100%" src="{{ url( 'themes/dashforge' ) }}/assets/img/joy-tunes-office.jpg" class="img-fluid" alt="">
                </div>
            </div><!-- media-body -->
            <div class="sign-wrapper mg-lg-l-50 mg-xl-l-60">
                <div class="wd-100p">
                    <h3 class="tx-color-01 mg-b-5">Sign In</h3>
                    <p class="tx-color-03 tx-16 mg-b-40">Welcome back! Please signin to continue.</p>
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Username / Email</label>

                            <input id="login" type="text"
                                   class="form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
                                   name="login" value="{{ old('username') ?: old('email') }}" required autofocus>

                            @if ($errors->has('username') || $errors->has('email'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                            </span>
                            @endif


                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between mg-b-5">
                                <label class="mg-b-0-f">Password</label>
                                <a href="" class="tx-13">Forgot password?</a>
                            </div>

                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror


                        </div>
                        <button type="submit" class="btn btn-brand-02 btn-block">Sign In</button>
                    </form>
                    {{--<div class="divider-text">or</div>--}}
                    {{--<button class="btn btn-outline-facebook btn-block">Sign In With Facebook</button>--}}
                    {{--<button class="btn btn-outline-twitter btn-block">Sign In With Twitter</button>--}}
                    <div class="tx-13 mg-t-20 tx-center">Don't have an account? <a href="{{ url('register') }}">Create an Account</a></div>
                </div>
            </div><!-- sign-wrapper -->
        </div><!-- media -->
    </div><!-- container -->
</div><!-- content -->

<footer class="footer">
    <div>
        <span>{{ date('Y', time()) }} - {{ env('SITE_TITLE') }}</span>
    </div>
    <div>
        <nav class="nav">
            {{--<a href="https://themeforest.net/licenses/standard" class="nav-link">Licenses</a>--}}
        </nav>
    </div>
</footer>

<script src="{{ url('themes/dashforge') }}/lib/jquery/jquery.min.js"></script>
<script src="{{ url('themes/dashforge') }}/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ url('themes/dashforge') }}/lib/feather-icons/feather.min.js"></script>
<script src="{{ url('themes/dashforge') }}/lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<script src="{{ url('themes/dashforge') }}/assets/js/dashforge.js"></script>

<!-- append theme customizer -->
<script src="{{ url('themes/dashforge') }}/lib/js-cookie/js.cookie.js"></script>
<script src="{{ url('themes/dashforge') }}/assets/js/dashforge.settings.js"></script>
<script>
    $(function(){
        'use script'

        window.darkMode = function(){
            $('.btn-white').addClass('btn-dark').removeClass('btn-white');
        }

        window.lightMode = function() {
            $('.btn-dark').addClass('btn-white').removeClass('btn-dark');
        }

        var hasMode = Cookies.get('df-mode');
        if(hasMode === 'dark') {
            darkMode();
        } else {
            lightMode();
        }
    })
</script>
</body>
</html>
