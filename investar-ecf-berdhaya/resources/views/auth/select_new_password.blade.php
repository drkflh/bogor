@extends(  env('REGISTER_LAYOUT', env('DEFAULT_LAYOUT', 'layouts.codebase').'_register' )  )

@section('js')

    <script>
        $(document).ready(function () {
            $('.radio-group .radio').click(function () {
                $('.selected .fa').removeClass('fa-check');
                $('.radio').removeClass('selected');
                $(this).addClass('selected');
            });
        });
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

@endsection

@section('auth_form')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('postNewPass') }}" method="post">
                    <input id="cartSession" type="hidden" name="cartSession" value="{{ $cartSession }}" >
                    <input id="email" type="hidden" name="email" value="{{ $email }}" >
                        @csrf
                        <!-- <div class="form-group row mb-4"> -->
                            <!-- <label for="name" class="col-form-label text-md-right">{{ __('Send OTP code via') }}</label> -->
                            <!-- <div class="wrapper">
                                <input type="radio" name="sendVia" id="option-1" value="mobile" checked>
                                <input type="radio" name="sendVia" id="option-2" value="email">
                                <label for="option-1" class="option option-1">
                                    <div class="dot"></div>
                                    <span>{{ __('Mobile') }}</span>
                                </label>
                                <label for="option-2" class="option option-2">
                                    <div class="dot"></div>
                                    <span>{{ __('Email') }}</span>
                                </label>
                            </div> -->
                        <!-- </div> -->

                        <!-- <div class="form-group row">

                            <div class="col-md-12">
                                <label for="mobile" class="col-form-label text-md-right">{{ __('Handphone') }}</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <select class="form-select" name="country_code">
                                            @foreach( config('util.mobile_countries') as $opt)
                                                <option value="{{ $opt['value'] }}" {{ $opt['value'] == '+62' ? 'selected':'' }} >{{ $opt['text'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input id="mobile" type="text"
                                           class="form-control @error('mobile') is-invalid @enderror"
                                           name="mobile" value="{{ old('mobile') }}" required
                                           autocomplete="mobile">
                                    @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div> -->

                        <div class="form-group row mb-2">
                            <div class="form-group">
                                <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                    autocomplete="new-password">
                            </div>
                            
                        </div>

                        <div class="form-group row mb-2 mt-3">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
