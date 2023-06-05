<div class="card">
    <div class="card-header">
        User Profile
      </div>
    <div class="card-body" style="display: block;min-height: 500px;" >
        <b-tabs content-class="mt-3 tabHeader"
                nav-class="tab-header" fill justified >
            <b-tab title="User Profile" active>
                <div class="row">
                    <div class="col-4" style="border-right: thin solid rgba(72, 94, 144, 0.16);">
                        {!! $avatar ?? '' !!}
                        {!! $name ?? '' !!}
                        {!! $placeOfBirth ?? '' !!}
                        {!! $dateOfBirth ?? '' !!}
                        {!! $address ?? '' !!}
                        {!! $city ?? '' !!}
                        {!! $province ?? '' !!}
                        {!! $ZIP ?? '' !!}
                    </div>
                    <div class="col-4">
                        <h5>Login Info</h5>
                        {!! $email ?? '' !!}
                        {!! $username ?? '' !!}
                        {!! $mobile ?? '' !!}
                        {!! $phone ?? '' !!}
                        {!! $roleId ?? '' !!}
{{--                        <h5>Bank Info</h5>--}}
{{--                        {!! $bankName ?? '' !!}--}}
{{--                        {!! $accountName ?? '' !!}--}}
{{--                        {!! $accountNumber ?? '' !!}--}}
                    </div>
                    <div class="col-4">
                        <h5>Authorization</h5>
                        {!! $idType ?? '' !!}
                        {!! $idNumber ?? '' !!}
                        {!! $idPic ?? '' !!}
                    </div>
                </div>
            </b-tab>
            <b-tab title="Signature Specimen"
                   @click="refreshSignature"
            >
                <div class="row">
                    <div class="col-4">
                    </div>
                    <div class="col-4" >
                        {!! $signatureSpecimen ?? '' !!}
                        {!! $signatureInput ?? '' !!}
                    </div>
                    <div class="col-4">
                        {!! $initialSpecimen ?? '' !!}
                        {!! $initialInput ?? '' !!}
                    </div>
                </div>
            </b-tab>
        </b-tabs>
    </div>
</div>
