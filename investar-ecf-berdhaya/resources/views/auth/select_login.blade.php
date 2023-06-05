@extends(  env('LOGIN_LAYOUT', env('DEFAULT_LAYOUT', 'layouts.codebase').'_register' )  )

@section('js')

    <script>
        $(document).ready(function () {
            $('.radio-group .radio').click(function () {
                $('.selected .fa').removeClass('fa-check');
                $('.radio').removeClass('selected');
                $(this).addClass('selected');
            });
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

    <style>
        .wrapper{
            display: inline-flex;
            background: #fff;
            height: 100px;
            width: 100%;
            align-items: center;
            justify-content: space-evenly;
            padding: 20px 15px;
        }
        .wrapper .option{
            background: #fff;
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            margin: 0 10px;
            border-radius: 5px;
            cursor: pointer;
            padding: 0 10px;
            border: 2px solid lightgrey;
            transition: all 0.3s ease;
        }
        .wrapper .option .dot{
            height: 20px;
            width: 20px;
            background: #d9d9d9;
            border-radius: 50%;
            position: relative;
        }
        .wrapper .option .dot::before{
            position: absolute;
            content: "";
            top: 4px;
            left: 4px;
            width: 12px;
            height: 12px;
            background: #0069d9;
            border-radius: 50%;
            opacity: 0;
            transform: scale(1.5);
            transition: all 0.3s ease;
        }
        input[type="radio"]{
            display: none;
        }
        #option-1:checked:checked ~ .option-1,
        #option-2:checked:checked ~ .option-2{
            border-color: #0069d9;
            background: #0069d9;
        }
        #option-1:checked:checked ~ .option-1 .dot,
        #option-2:checked:checked ~ .option-2 .dot{
            background: #fff;
        }
        #option-1:checked:checked ~ .option-1 .dot::before,
        #option-2:checked:checked ~ .option-2 .dot::before{
            opacity: 1;
            transform: scale(1);
        }
        .wrapper .option span{
            font-size: 20px;
            color: #808080;
        }
        #option-1:checked:checked ~ .option-1 span,
        #option-2:checked:checked ~ .option-2 span{
            color: #fff;
        }
    </style>
    <link href="{{ url( env('APP_CSS', 'css/investar.css') ) }}" rel="stylesheet">

@endsection

@section('breadcumb')
<div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ url('/') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Login
                </div>
            </div>
        </div>
@endsection

@section('auth_form')
    <form method="POST" action="{{ route('login') }}">
        @csrf

        @if (isset($message))
            <div class="alert alert-success alert-block">
                <strong>{{ $message }}</strong>
            </div>
        @endif

        <div class="form-group row mb-2">
            <div class="col-md-12">
                <label for="login" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
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
        <div class="form-group row mb-2">
            <div class="col-md-12">
                <label for="name" class="col-form-label text-md-right">{{ __('Password') }}</label>
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
        </div>
        <div class="row" >
            <div class="col-12 d-flex justify-content-between">
                <label class="form-check-label mr-md-4 mr-sm-4 d-flex align-items-center justify-content-start mt-0 mr-auto w-50" style="font-size: 11pt;" >
                    <input type="checkbox" class="form-check-input mt-0 mr-2 p-2 d-flex align-items-center"  name="remember" id="remember"  {{ old('remember') ? 'checked' : '' }}>
                    <span class="ml-2 p-2">
                                    {{ __('Remember me') }}
                                    </span>
                </label>
                <button type="submit" class="btn btn-lg btn-gradient-success mt-4 mb-4 mb-lg-0 text-white">
                    {{ __('Login') }} <i class="mdi mdi-arrow-right fs-14 ms-1"></i>
                </button>
            </div>
        </div>

        <div class="row mt-4" >
            <div class="col-12 d-flex justify-content-between align-items-center">
                                <span>
                                    {{__('Forgot password')}} ?
                                    <a href="{{ url('pass/forgot') }}" class="text-muted" style="font-size: 11pt">
                                        {{ __('Reset') }}
                                    </a>
                                </span>
                @if(env('ENABLE_REGISTRATION', false))
                    <span>
                                    {{ __('Not yet signed up ?') }}
                                    <a href="{{ url('register') }}" class="text-muted" style="font-size: 11pt">
                                        {{ __('Register') }}
                                    </a>
                                </span>
                @endif
            </div>
        </div>
    </form>
@endsection
