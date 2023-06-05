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

@endsection

@section('auth_form')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('postForgotPass') }}" method="post">
                        @csrf
                        <div class="form-group row mb-4">
                            <label for="name" class="col-form-label text-md-right">{{ __('Send reset password link via') }}</label>
                            <div class="wrapper">
                                <input type="radio" name="options" id="option-1" value="mobile" checked>
                                <label for="option-1" class="option option-1">
                                    <div class="dot"></div>
                                    <span>{{ __('Mobile') }}</span>
                                </label>
                                <input type="radio" name="options" id="option-2" value="email">
                                
                                <label for="option-2" class="option option-2">
                                    <div class="dot"></div>
                                    <span>{{ __('Email') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">

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
                        </div>

                        <div class="form-group row mb-2">

                            <div class="col-md-12">
                                <label for="email" class="col-form-label text-md-right">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-2 mt-3">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
