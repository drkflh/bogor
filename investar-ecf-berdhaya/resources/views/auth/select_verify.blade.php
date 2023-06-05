@extends(  env('REGISTER_LAYOUT', env('DEFAULT_LAYOUT', 'layouts.codebase').'_register' )  )

@section('auth_form')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            <p>
                {{ __('Verification link has been sent to') }}
            </p>
            <p>
                <b>{{ $email }}</b>
            </p>
            <p>
                {{ __('Please check your email for a verification link.') }}
            </p>
            <p>
                {{ __('If you did not receive the email') }},
            </p>
            <form class="d-flex justify-content-center" method="POST" action="{{ url('verify/resend') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}" />
                <button type="submit" style="border: none;" class="btn btn-link align-baseline">{{ __('Resend verification email') }}</button>.
            </form>
        </div>
    </div>
</div>
@endsection
