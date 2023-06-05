@extends( env('DEFAULT_LAYOUT', 'layouts.nobleui'))

@section('content')
<div class="card">
    <div class="card-body">
        <b-tabs content-class="mt-3" nav-class="tab-header">
            <b-tab title="Profile" active>
                <div class="row">
                    <div class="col-4" style="border-right: thin solid rgba(72, 94, 144, 0.16);">
                        {!! $avatar ?? '' !!}
                        {!! $name ?? '' !!}
                        {!! $placeOfBirth ?? '' !!}
                        {!! $dateOfBirth ?? '' !!}
                        {!! $address ?? '' !!}
                        {!! $province ?? '' !!}
                        {!! $city ?? '' !!}
                        {!! $ZIP ?? '' !!}
                    </div>
                    <div class="col-4">
                        <h5>Login Info</h5>
                        {!! $email ?? '' !!}
                        {!! $username ?? '' !!}
                        {!! $mobile ?? '' !!}
                        {!! $phone ?? '' !!}
                        {!! $roleId ?? '' !!}
                        <hr>
                        {!! $password ?? '' !!}
                        {!! $confirm_password ?? '' !!}
                    </div>
                    <div class="col-4">
                        <h5>Authorization</h5>
                        {!! $pin ?? '' !!}
                        {!! $confirm_pin ?? '' !!}
                        <hr>
                        {!! $idType ?? '' !!}
                        {!! $idNumber ?? '' !!}
                        {!! $idPic ?? '' !!}
                    </div>
                </div>
            </b-tab>
            <b-tab title="Signature Specimen" @click="refreshSignature">
                <div class="row">
                    <div class="col-md-6" >
                        {!! $signatureInput !!}
                    </div>
                    <div class="col-md-4">
                        {!! $signatureSpecimen !!}
                    </div>
                </div>
            </b-tab>
        </b-tabs>
    </div>
</div>
@endsection
