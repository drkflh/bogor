@if (\Session::has('error'))
    <div class="alert alert-danger">
        <ul>
            <li>{!! \Session::get('error') !!}</li>
        </ul>
    </div>
@endif
<form class="row g-3">
    <div class="col-12">
        {!! $avatar ?? '' !!}
    </div>
    <div class="col-md-12">
        {!! $name ?? '' !!}
    </div>
    <div class="col-md-6">
        {!! $placeOfBirth ?? '' !!}
    </div>
    <div class="col-md-6">
        {!! $dateOfBirth ?? '' !!}
    </div>
    <div class="col-md-6">
        {!! $mobile ?? '' !!}
    </div>
    <div class="col-md-6">
        @if(\App\Helpers\AuthUtil::isAdmin())
            {!! $email ?? '' !!}
        @else
            <label for="email"  >{{ __('Email') }}</label>
            <p class="form-control underlined"
               style="word-break: break-word;min-height:35px; border-bottom-color: lightgrey !important;"
               v-html="email" >
            </p>
        @endif
    </div>
    <div class="col-12">
        {!! $address ?? '' !!}
    </div>
    <div class="col-md-5">
        {!! $kabupaten ?? '' !!}
    </div>
    <div class="col-md-5">
        {!! $province ?? '' !!}
    </div>
    <div class="col-md-2">
        {!! $ZIP ?? '' !!}
    </div>

    <h5>Identitas</h5>
    <div class="col-md-2">
        {!! $idType ?? '' !!}
    </div>
    <div class="col-md-8">
        {!! $idNumber ?? '' !!}
    </div>
    <div class="col-md-2">
        {!! $idValidation ?? '' !!}
    </div>
    @if (\Session::has('validation'))
    <div class="cold-md-12">
        <div class="alert alert-warning">
            <div>
                {!! \Session::get('validation') !!}
            </div>
        </div>
    </div>
    @endif
    <div class="cold-md-12">
        {!! $idPic ?? '' !!}
    </div>
</form>

<!-- <div class="row">
    <div class="col-12">
        {!! $avatar ?? '' !!}
        {!! $name ?? '' !!}
        @if(\App\Helpers\AuthUtil::isAdmin())
            {!! $email ?? '' !!}
        @else
            <label for="email"  >{{ __('Email') }}</label>
            <p class="form-control underlined"
               style="word-break: break-word;min-height:35px; border-bottom-color: lightgrey !important;"
               v-html="email" >
            </p>
        @endif
        {!! $mobile ?? '' !!}
        <div class="row">
            <div class="col-6">
                {!! $placeOfBirth ?? '' !!}
            </div>
            <div class="col-6">
                {!! $dateOfBirth ?? '' !!}
            </div>
        </div>
        {!! $address ?? '' !!}
        {!! $kabupaten ?? '' !!}
        {!! $province ?? '' !!}
        {!! $ZIP ?? '' !!}

        <h5>Identitas</h5>
        {!! $idType ?? '' !!}
        {!! $idNumber ?? '' !!}
        {!! $idPic ?? '' !!}

    </div>
</div> -->
