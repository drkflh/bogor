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

    </style>
    <link href="{{ url( env('APP_CSS', 'css/investar.css') ) }}" rel="stylesheet">

@endsection

@section('auth_form')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        {{--                        <input id="roleId" type="hidden" name="roleId" value="{{ \App\Helpers\AuthUtil::getRoleId('Owner') }}" >--}}

        <div class="form-group">
            <label for="name" class="col-form-label text-md-right">{{ __('Pilih Peran Anda') }}</label>
            <?php
            $idx = 1;
            ?>
            <select name="roleId" class="form-select">
                @foreach( config('util.auth_roles') as $role)
                    <option name="roleId" id="option-{{ $idx }}" {{ ($idx == 1) ? 'selected':'' }}
                    value="{{ \App\Helpers\AuthUtil::getRoleId( $role['value']) }}" >
                        {{ __( $role['text']) }}
                    </option>
            <?php
            $idx++;
            ?>
            @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                   value="{{ old('name') }}" required autocomplete="name" autofocus>

            @error('name')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                   value="{{ old('email') }}" required autocomplete="email">

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="mobile" class="col-form-label text-md-right">{{ __('Handphone') }}</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <select class="form-select" name="country_code">
                        @foreach( config('util.mobile_countries') as $opt)
                            <option
                                value="{{ $opt['value'] }}" {{ $opt['value'] == '+62' ? 'selected':'' }} >{{ $opt['text'] }}</option>
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

        <div class="form-group">
            <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                   name="password" required autocomplete="new-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
            @foreach ($errors->get('password') as $error)
                <div>{{ $error }}</div>
            @endforeach
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password-confirm" class="col-form-label text-md-right">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                   autocomplete="new-password">
        </div>
        <!-- <hr> -->
        <!-- <div class="form-group">
            <label for="password-confirm" class="col-form-label text-md-right">{{ __('Referral Code') }}</label>
            <input id="referral-code" type="text" class="form-control" name="referral_code" >
        </div> -->

        <div class="form-group">
            <button type="submit" class="btn btn-lg btn-gradient-success mt-4 mb-4 mb-lg-0 text-white">
                {{ __('Register') }}
                <i class="mdi mdi-arrow-right fs-14 ms-1"></i>
            </button>
        </div>
    </form>
    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-center align-items-center">
            <span>
                {{__('Already a user')}} ?
                <a href="{{ url('login') }}" class="text-muted" style="font-size: 11pt">
                    {{ __('Enter') }}
                </a>
            </span>
        </div>
    </div>

@endsection
