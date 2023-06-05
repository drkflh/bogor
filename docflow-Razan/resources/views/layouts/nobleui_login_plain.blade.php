<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('SITE_NAME','') }} - {{ env('SITE_TITLE') }}</title>
    <!-- core:css -->
    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/vendors/core/core.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- end plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/fonts/feather-font/css/iconfont.css">
    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/css/demo_1/style.css">
    <!-- End layout styles -->
      <link rel="shortcut icon" href="{{ url(env('APP_FAVICON', 'favicon.ico')) }}" />
</head>
<body>
<div class="main-wrapper">
    <div class="page-wrapper full-page" style="
            background-image: url({!! url('images').'/'.env('LOGIN_FG','') !!} ) !important;
        );
        background-blend-mode: soft-light;
        " >
        <div class="page-content d-flex align-items-center justify-content-center">

            <div class="row w-100 mx-0 auth-page">
                <div class="col-md-12 col-xl-12 mx-auto">
                    <div class="card" style="max-width: 1500px;margin: auto;">
                        <div class="row">
                            <div class="col-md-8 col-xl-9 pr-md-0">
                                <div class="auth-left-wrapper" style="background-image: url({!! url('images').'/'.env('LOGIN_FG','') !!});
                                    background-size: auto 100%;
                                    background-repeat: no-repeat;max-width: 1500px;width: 1500px;">

                                </div>
                            </div>
                            <div class="col-md-4 col-xl-3 pl-md-0">
                                <div class="auth-form-wrapper px-4 py-5">

                                    <a href="#" class="noble-ui-logo d-block mb-2">
                                        <img src="{{ url( env('APP_LOGO_SMALL') ) }}" alt="" height="70">
                                        @if(env('LOGO_TEXT', false ))
                                            <span class="sidebar-brand" style="font-size: 15pt;font-weight: bold;">{{ env('SITE_TITLE') }}</span>
                                        @endif
                                    </a>
                                    <h5 class="text-muted font-weight-bolder mb-4" style="padding-left: 25px;font-size: 14.25pt !important;">{{ env('SITE_DESCRIPTION') }}</h5>
                                    <form action="{{ route('login') }}" method="post">
                                        @csrf
                                        <div class="form-group col-xs-12 col-md-10 col-lg-10 col-xl-9">

                                            <label for="login-password">Email / Username</label>
                                            <input id="login" type="text"
                                                   class="form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
                                                   name="login" value="{{ old('username') ?: old('email') }}" required autofocus>

                                            @if ($errors->has('username') || $errors->has('email'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                                                </span>
                                            @endif


                                        </div>
                                        <div class="form-group col-xs-12 col-md-10 col-lg-10 col-xl-9">
                                            <label for="login-password">Password</label>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                        <div class="row">
                                            <div class="form-check form-check-flat form-check-primary mt-3 col-6 offset-1 " style="padding-left: 10px;">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input"  name="remember" id="remember"  {{ old('remember') ? 'checked' : '' }}>
                                                    Remember me
                                                    <i class="input-frame"></i></label>
                                            </div>
                                            <div class="mt-2 col-4">
                                                <button type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0 text-white">
                                                    <i class="si si-login mr-10"></i> Login
                                                </button>
                                            </div>
                                        </div>
                                        {{--<a href="{{ url('register') }}" class="d-block mt-3 text-muted">Not a user? Sign up</a>--}}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- core:js -->
<script src="{{ url('themes/nobleui') }}/assets/vendors/core/core.js"></script>
<!-- endinject -->
<!-- plugin js for this page -->
<!-- end plugin js for this page -->
<!-- inject:js -->
<script src="{{ url('themes/nobleui') }}/assets/vendors/feather-icons/feather.min.js"></script>
<script src="{{ url('themes/nobleui') }}/assets/js/template.js"></script>
<!-- endinject -->
<!-- custom js for this page -->
<!-- end custom js for this page -->
</body>
</html>
