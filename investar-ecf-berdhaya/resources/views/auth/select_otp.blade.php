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
                    <form action="{{ route('otpResend') }}" method="post">
                    <input type="hidden" name="email" value="{{ $email }}">
                    <input type="hidden" name="mobile" value="{{ $mobile }}">
                        @csrf
                        @if (isset($success))
                            <div class="alert alert-success alert-block">
                                <strong>{{ $success }}</strong>
                            </div>
                        @endif
                        @if (isset($failed))
                            <div class="alert alert-warning alert-block">
                                <strong>{{ $failed }}</strong>
                            </div>
                        @endif
                        
                        <div class="btn-group d-flex align-items-center justify-content-center">
                        <input type="radio" class="btn-check" name="options" value="email" id="option1" autocomplete="on" />
                        <label class="btn btn-secondary" for="option1">Email</label>

                        <input type="radio" class="btn-check" name="options" value="mobile" id="option2" autocomplete="on" />
                        <label class="btn btn-secondary" for="option2">Mobile</label>
                        </div>

                        <!-- <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Default radio
                            </label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                Default checked radio
                            </label>
                            </div> -->

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

                        <!-- <div class="form-group row mb-2">

                            <div class="col-md-12">
                                <label for="email" class="col-form-label text-md-right">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> -->

                        <div class="form-group row mb-2 mt-3">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Kirim') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
