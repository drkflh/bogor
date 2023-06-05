@extends(env('REGISTER_LAYOUT', env('DEFAULT_LAYOUT', 'layouts.codebase') . '_register'))

@section('js')
    <script>
        $(document).ready(function() {
            $('.radio-group .radio').click(function() {
                $('.selected .fa').removeClass('fa-check');
                $('.radio').removeClass('selected');
                $(this).addClass('selected');
            })
        });
    </script>

    <style>

    </style>
    <link href="{{ url(env('APP_CSS', 'css/investar.css')) }}" rel="stylesheet">
@endsection

@section('auth_form')

    <form method="POST" action="{{ route('afterResend') }}">
    <input type="hidden" name="cartSession" value="{{ $cartSession }}">
        @csrf
        <label for="name" class="col-md-12 col-form-label text-md-right">Enter the OTP Code sent to your email</label>
        
        @if ($message = Session::get('warning'))
            <div class="alert alert-warning alert-block">
                <button type="button" class="close" onclick="this.parentElement.style.display='none';" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        <div class="form-group d-flex flex-nowrap">
            <input id="otp1" type="text" class=" w-25 @error('otp1') is-invalid @enderror" name="otp1"
                value="" required autocomplete="name" autofocus maxlength="1">

            <input id="otp2" type="text" class=" w-25 @error('otp2') is-invalid @enderror" name="otp2"
                value="" required autocomplete="name" autofocus maxlength="1">

            <input id="otp3" type="text" class="w-25  @error('otp3') is-invalid @enderror" name="otp3"
                value="" required autocomplete="name" autofocus maxlength="1">

            <input id="otp4" type="text" class="w-25 @error('otp4') is-invalid @enderror" name="otp4"
                value="" required autocomplete="name" autofocus maxlength="1">
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center align-items-center">
                <span>
                    {{__("Didn't recieve the OTP")}} ?
                    <a href="{{ route('otpVerify', $cartSession) }}" class="text-muted" style="font-size: 11pt">
                        {{ __('RESEND OTP') }}
                    </a>
                </span>
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
    @endsection
