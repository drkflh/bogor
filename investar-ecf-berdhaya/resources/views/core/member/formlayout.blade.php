<b-tabs content-class="mt-3 tabHeader"
        nav-class="tab-header" fill justified >
    <b-tab title="User Profile" active>
        <div class="row">
            <div class="col-4" style="border-right: thin solid rgba(72, 94, 144, 0.16);">
                {!! $avatar !!}
                {!! $name !!}
                {!! $placeOfBirth !!}
                {!! $dateOfBirth !!}
                {!! $address !!}
                {!! $city !!}
                {!! $province !!}
                {!! $ZIP !!}
            </div>
            <div class="col-4">
                <h5>Login Info</h5>
                {!! $email !!}
                {!! $username !!}
                {!! $mobile !!}
                {!! $phone !!}
                {!! $roleId !!}
                <hr>
                {!! $password !!}
                {!! $confirm_password !!}
                <div>
                    {!! $isActive !!}
                </div>
            </div>
            <div class="col-4">
                <h5>Authorization</h5>
                {!! $pin !!}
                {!! $confirm_pin !!}
                <hr>
                {!! $idType !!}
                {!! $idNumber !!}
                {!! $idPic !!}
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
                {!! $signatureInput !!}
            </div>
            <div class="col-4">
                {!! $signatureSpecimen !!}
            </div>
        </div>
    </b-tab>
</b-tabs>
