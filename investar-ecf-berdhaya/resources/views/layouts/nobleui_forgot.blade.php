<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('SITE_NAME','') }} - {{ env('SITE_TITLE') }}</title>
    <!-- core:css -->
    <link rel="stylesheet" href="{{ url('themes/nobleui/assets/vendors/core/core.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- end plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ url('themes/nobleui/assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ url('themes/nobleui/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <!-- endinject -->
    <!-- icon line -->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ url('themes/nobleui/assets/css/demo_1/style.css') }}">
    <link href="{{ url('css/table_framework.css') }}" rel="stylesheet">

    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ url(env('APP_FAVICON', 'favicon.ico')) }}"/>
    <script src="{{ url( 'js/jquery-3.6.0.min.js' ) }}"></script>
</head>
<body>
<div class="main-wrapper">
    <div class="page-wrapper full-page"
         style="background-image: url({{ url( env('LOGIN_BG', '' ) ) }}); background-size: cover;background-blend-mode: normal;">
        <div class="page-content d-flex align-items-center justify-content-center" style="padding: 0px;">

            <div class="row w-100 mx-0 auth-page" style="height: 100%;background-color: transparent;">
                <div class="col-lg-6 col-md-5 d-none d-md-block">

                </div>
                <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 h-100" style="background-color: white;height: 100% !important;display: flex;align-items: center;justify-content: center;">
                    <div class="" style="border-radius: 0px;box-shadow: 0px;width: 90%;">
                        <div class="card-body" style="padding: 0px;border-radius: 0px;">
                            <div class="row d-flex justify-content-md-end justify-content-sm-center" style="background-color: transparent;margin: 0px !important;">

                                <div class="col-lg-12 col-md-12 col-sm-7 col-xs-12 pl-md-0"
                                     style="background-color: white;border-radius: 20px;">
                                    <div class="auth-form-wrapper px-4 py-5">

                                        <h6 class="text-muted text-center font-weight-bolder mb-4"
                                        >
                                            <div class="d-inline-flex flex-column">
                                                <img src="{{ url( env('APP_LOGO') ) }}" alt="" height="75">
                                                <h4 class="text-muted text-left font-weight-bolder mb-4" style="display: inline-block;width: fit-content;" >
                                                    {{ __('Forgot Password') }}
                                                </h4>
                                            </div>
                                        </h6>

                                        @if ($message = Session::get('success'))
                                            <div class="alert alert-success alert-block">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @endif
                                        <form action="{{ url('pass/forgot') }}" method="post">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label text-md-right" for="login">{{ __('Mobile') }}</label>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">+62</span>
                                                        </div>
                                                        <input id="mobile" type="text"
                                                               class="form-control{{ $errors->has('username') || $errors->has('email') || $errors->has('mobile') ? ' is-invalid' : '' }}"
                                                               name="mobile" value="{{ old('mobile') }}" required autofocus>

                                                        @if ($errors->has('mobile'))
                                                            <span class="invalid-feedback">
                                                                <strong>{{ $errors->first('mobile') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" >
                                                <div class="mt-1 col-md-12 col-sm-12 col-xs-12 d-flex flex-nowrap justify-content-lg-end justify-content-md-end justify-content-sm-end align-items-center">
                                                    <a
                                                        href="{!! url('login') !!}"
                                                        class="btn mr-3"
                                                    > {{__('Cancel')}}
                                                    </a>
                                                    <button type="submit" class="btn btn-primary text-white">
                                                        <i style="font-size: 15pt;" class="las la-sign-in-alt"></i>
                                                        {{__('Reset Password')}}
                                                    </button>
                                                </div>
                                            </div>
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
