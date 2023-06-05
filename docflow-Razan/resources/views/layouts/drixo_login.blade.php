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

    <link rel="shortcut icon" href="{{ url('themes/drixo') }}/assets/images/favicon.ico">

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
            color: grey;
        }
    </style>
</head>


<body class="fixed-left">

<!-- Loader -->
<div id="preloader"><div id="status"><div class="spinner"></div></div></div>

<!-- Begin page -->
<div class="accountbg">

    <div class="content-center">
        <div class="content-desc-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-8">
                        <div class="card">
                            <div class="card-body">

                                <h3 class="text-center mt-0 m-b-15">
                                    <a href="index.html" class="logo logo-admin"><img src="assets/images/logo-dark.png" height="30" alt="logo"></a>
                                </h3>

                                <h4 class="text-muted text-center font-18"><b>Sign In</b></h4>

                                <div class="p-2">
                                    <form class="form-horizontal m-t-20"  action="{{ route('login') }}" method="post">
                                        @csrf

                                        <div class="form-group row">
                                            <div class="col-12">
                                                <label for="username">Email</label>
                                                <input type="text" id="email" name="email"  class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
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

                                        <div class="form-group row">
                                            <div class="col-12">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" name="remember" id="remember"  {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="remember">Remember me</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group text-center row m-t-20">
                                            <div class="col-12">
                                                <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</button>
                                            </div>
                                        </div>

                                        <div class="form-group m-t-10 mb-0 row">
                                            <div class="col-sm-7 m-t-20">
                                                <a href="pages-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                                            </div>
                                            <div class="col-sm-5 m-t-20">
                                                <a href="pages-register.html" class="text-muted"><i class="mdi mdi-account-circle"></i> Create an account</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
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


<!-- App js -->
<script src="{{ url('themes/drixo') }}/assets/js/app.js"></script>

</body>
</html>
