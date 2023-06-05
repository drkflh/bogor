<div class="row">
    <div class="col-3" style="border-right: thin solid rgba(72, 94, 144, 0.16);">
        {!! $avatar !!}
        <hr>
        {!! $name !!}
        {!! $placeOfBirth !!}
        {!! $dateOfBirth !!}
    </div>
    <div class="col-9">
        <b-tabs content-class="mt-3 tabHeader" nav-class="tab-header" fill justified >
            <b-tab title="Login Info" active>
                {!! $email !!}
                {!! $username !!}
                {!! $mobile !!}
                {!! $phone !!}
                {!! $regStatus !!}
            </b-tab>
            <b-tab title="Address and Contact">
                {!! $address !!}
                {!! $ZIP !!}
                {!! $province !!}
                {!! $city !!}
            </b-tab>
            <b-tab title="ID Card">
                {!! $idType !!}
                {!! $idNumber !!}
                {!! $idPic !!}
            </b-tab>
        </b-tabs>
    </div>
</div>
