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

    <!-- Bootstrap Css -->
    <link href="{{ url('themes/xoric/green') }}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ url('themes/xoric/green') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ url('themes/xoric/green') }}/assets/css/app.min.css" rel="stylesheet" type="text/css" />

    <style>
        .form-group-custom {
            position: relative;
            padding-top: 8px;
        }
    </style>

</head>

<body class="bg-primary bg-pattern">
<div class="home-btn d-none d-sm-block">
    <a href="{{ url('/') }}"><i class="mdi mdi-home-variant h2 text-white"></i></a>
</div>

<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mb-5">
                    <a href="{{ url('/') }}" class="logo"><img src="{{ url(env('APP_LOGO_LIGHT')) }}" height="70" alt="logo"></a>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row justify-content-center">
            <div class="col-xl-5 col-sm-8">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="p-2">
                            <h5 class="mb-5 text-center">Sign in to continue to {{ env('SITE_TITLE') }}</h5>
                            <form action="{{ route('login') }}" method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-group-custom mb-4">
                                            <input id="login" type="text"
                                                   class="form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
                                                   name="login" value="{{ old('username') ?: old('email') }}" required autofocus>

                                            @if ($errors->has('username') || $errors->has('email'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                                                </span>
                                            @endif

                                            <label for="username">User Name</label>
                                        </div>

                                        <div class="form-group form-group-custom mb-4">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <label for="userpassword">Password</label>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" name="remember" id="remember"  {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="customControlInline">Remember me</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="text-md-right mt-3 mt-md-0">
                                                    <a href="{{ url('resetpass') }}" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <button class="btn btn-success btn-block waves-effect waves-light" type="submit">Log In</button>
                                        </div>
                                        <div class="mt-4 text-center">
                                            <a href="{{ url('register') }}" class="text-muted"><i class="mdi mdi-account-circle mr-1"></i> Create an account</a>
                                        </div>
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
<!-- end Account pages -->

<!-- JAVASCRIPT -->
<script src="{{ url('themes/xoric/green') }}/assets/libs/jquery/jquery.min.js"></script>
<script src="{{ url('themes/xoric/green') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ url('themes/xoric/green') }}/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="{{ url('themes/xoric/green') }}/assets/libs/simplebar/simplebar.min.js"></script>
<script src="{{ url('themes/xoric/green') }}/assets/libs/node-waves/waves.min.js"></script>

<script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>

<script src="{{ url('themes/xoric/green') }}/assets/js/app.js"></script>

</body>
</html>
