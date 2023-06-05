<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Shreyu - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('themes/shreyu') }}/assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{ url('themes/shreyu') }}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('themes/shreyu') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('themes/shreyu') }}/assets/css/app.min.css" rel="stylesheet" type="text/css" />

    <script src="{{ url(mix('js/app.js')) }}"></script>

    @yield('js')

    <style>
        .input-group-text{
            padding: 5px;
        }
    </style>

</head>

<body class="authentication-bg">

<div class="account-pages my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-md-6 p-5">
                                <div class="mx-auto mb-5">
                                    <a href="index.html">
                                        <img src="{{ url( env('APP_LOGO') ) }}" alt="" height="50" />
                                        <h3 class="d-inline align-middle ml-1 text-logo">{{ env('SITE_NAME','') }}</h3>
                                    </a>
                                </div>

                                <h6 class="h5 mb-0 mt-4">Welcome back!</h6>
                                <p class="text-muted mt-1 mb-4">Enter your email address and password to
                                    access admin panel.</p>

                                <form action="{{ route('login') }}" class="authentication-form" method="post">
                                    @csrf

                                    <div class="form-group">
                                        <label class="form-control-label">Username or Email Address</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="icon-dual" data-feather="mail"></i>
                                                        </span>
                                            </div>
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

                                    <div class="form-group mt-4">
                                        <label class="form-control-label">Password</label>
                                        <a href="pages-recoverpw.html" class="float-right text-muted text-unline-dashed ml-1">Forgot your password?</a>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="icon-dual" data-feather="lock"></i>
                                                        </span>
                                            </div>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input"
                                                   type="checkbox"
                                                   name="remember" id="remember"  {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="checkbox-signin">Remember
                                                me</label>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary btn-block" type="submit"> Log In
                                        </button>
                                    </div>
                                </form>
                                {{--<div class="py-3 text-center"><span class="font-size-16 font-weight-bold">Or</span></div>--}}
                                {{--<div class="row">--}}
                                    {{--<div class="col-6">--}}
                                        {{--<a href="" class="btn btn-white"><i class='uil uil-google icon-google mr-2'></i>With Google</a>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-6 text-right">--}}
                                        {{--<a href="" class="btn btn-white"><i class='uil uil-facebook mr-2 icon-fb'></i>With Facebook</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            </div>
                            <div class="col-lg-6 d-none d-md-inline-block">
                                <div class="auth-page-sidebar">
                                    <div class="overlay"></div>
                                    <div class="auth-user-testimonial">
                                        <p class="font-size-24 font-weight-bold text-white mb-1">I simply love it!</p>
                                        <p class="lead">"It's a elegent templete. I love it very much!"</p>
                                        <p>- Admin User</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-muted">Don't have an account? <a href="{{ url('register') }}" class="text-primary font-weight-bold ml-1">Sign Up</a></p>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->

<!-- Vendor js -->
<script src="{{ url('themes/shreyu') }}/assets/js/vendor.min.js"></script>

<!-- App js -->
<script src="{{ url('themes/shreyu') }}/assets/js/app.min.js"></script>

</body>
</html>
