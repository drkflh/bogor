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
<div class="wrapper-page">

    <div class="card">
        <div class="card-body">

            <h3 class="text-center m-0">
                <a href="{{ url('/') }}" class="logo logo-admin"><img src="{{ url( env('APP_LOGO') ) }}" height="30" alt="logo"></a>
            </h3>

            <div class="p-3">
                <h4 class="text-muted font-18 m-b-5 text-center">Welcome Back !</h4>
                <p class="text-muted text-center">Sign in to continue to Lexa.</p>

                <form class="form-horizontal m-t-30"  action="{{ route('login') }}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="username">Email</label>
                        <input type="text" id="email" name="email"  class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <div class="form-group row m-t-20">
                        <div class="col-6 pull-left">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" name="remember" id="remember"  {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customControlInline">Remember me</label>
                            </div>
                        </div>
                        <div class="col-5 text-right pull-right">
                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>

                    <div class="form-group m-t-10 mb-0 row">
                        <div class="col-12 m-t-20">
                            <a href="pages-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="m-t-40 text-center">
        <p>Don't have an account ? <a href="{{ url('register') }}" class=" text-primary"> Signup Now </a> </p>
        <p>
            <a class="font-w600" href="{{ env('APP_URL') }}" target="_blank">{{ env('SITE_TITLE') }}</a> &copy; <span class="js-year-copy">{{ date('Y', time()) }}</span>
        </p>
    </div>

</div>


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
