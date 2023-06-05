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
    <!-- icon line -->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/css/demo_1/style.css">
    <link rel="stylesheet" href="{{ url(  env('APP_CSS', 'css/parama.css')  ) }}">
    <link href="{{ url('/') }}/css/table_framework.css" rel="stylesheet">

    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ url(env('APP_FAVICON', 'favicon.ico')) }}"/>
    <script src="{{ url( 'js/jquery-3.6.0.min.js' ) }}"></script>
</head>
<body>
<div class="main-wrapper">
    <div class="page-wrapper full-page" style="background-image: url({{ url( env('LOGIN_BG', '' ) ) }}); background-size: cover;background-blend-mode: normal;" >
        <div class="page-content d-flex align-items-center justify-content-center">
            <div class="row wd-md-60p wd-lg-50p wd-xl-35p wd-sm-75p auth-page rounded-20">
                <div class="col-md-5 col-xl-5 col-sm-5 col-xs-12 pr-md-0 d-none d-sm-inline-block d-md-inline-block rounded-md-left-20" style="border-color: {{ env('NOBLE_OPT_COLOR','white') }};background-color: {{ env('NOBLE_OPT_COLOR','white') }};" >
                    <div class="auth-left-wrapper d-flex align-items-center justify-content-center" style="background:none;">
                        @if( env('APP_LOGO','') != '' )
                            <img src="{{ url( env('APP_LOGO') ) }}" alt="" class="w-75 h-auto">
                        @endif
                        @if(env('LOGO_TEXT', false ))
                            <span class="sidebar-brand" style="font-size: 15pt;font-weight: bold;">{{ env('SITE_TITLE') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-7 col-xl-7 col-sm-7 col-xs-12 pl-md-0 rounded-md-right-20" style="background-color: white;">
                    <div class="auth-form-wrapper px-4 py-5">

                        <h5 class="text-muted text-center font-weight-bolder mb-4" style="font-size: 14.25pt !important;">{{ env('SITE_DESCRIPTION') }}</h5>
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="form-group">

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
                            <div class="form-group">
                                <label for="login-password">Password</label>
                                <div class="input-group mb-3">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    <div class="input-group-append">
                                        <button class="btn btn-light" type="button" onclick="pasVis()">
                                            <i class="las la-eye" style="font-size: 14pt;"  id="iconPass"></i>
                                        </button>
                                    </div>
                                </div>

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                @enderror

                            </div>
                            <div class="row" >
                                <div class="mt-1 col-md-12 col-sm-12 col-xs-12 d-flex flex-nowrap justify-content-lg-end justify-content-md-end justify-content-sm-end align-items-center">
                                    <label class="form-check-label mr-md-4 mr-sm-4 d-flex align-items-center mt-0 mr-auto" style="font-size: 11pt;" >
                                        <input type="checkbox" class="form-check-input mt-0 d-flex align-items-center"  name="remember" id="remember"  {{ old('remember') ? 'checked' : '' }}>
                                        Remember me
                                        <i class="input-frame"></i>
                                    </label>
                                    <button type="submit" class="btn btn-primary text-white">
                                        <i style="font-size: 15pt;" class="las la-sign-in-alt"></i> Login
                                    </button>
                                </div>
                            </div>

                            @if(env('ENABLE_REGISTRATION', false))
                                <a href="{{ url('register') }}" class="btn btn-outline-primary text-primary mt-5 d-block" style="font-size: 16px">Register</a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){

    });

    function pasVis() {
        x = $('#password');
        y = $('#iconPass');

        console.log('x', x);
        console.log('y', y);

        if (x.prop('type') === "password") {
            x.prop('type', 'text');
            y.removeClass().addClass('las la-eye-slash');
        } else {
            x.prop('type', 'password');
            y.removeClass().addClass('las la-eye');
        }
    }

</script>
<!-- core:js -->
<script src="{{ url('themes/nobleui') }}/assets/vendors/core/core.js"></script>
<!-- endinject -->
<!-- plugin js for this page -->
<!-- end plugin js for this page -->
<!-- inject:js -->
<script src="{{ url('themes/nobleui') }}/assets/vendors/feather-icons/feather.min.js"></script>
{{--<script src="{{ url('themes/nobleui') }}/assets/js/template.js"></script>--}}
<!-- endinject -->
<!-- custom js for this page -->
<!-- end custom js for this page -->
</body>
</html>
