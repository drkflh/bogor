<div class="row">
    <div class="col-md-4 col-sm-12" style="border-right: thin solid rgba(72, 94, 144, 0.16);">
        {!! $avatar ?? '' !!}
        {!! $name ?? '' !!}
        {!! $roleName ?? '' !!}
        {!! $username ?? '' !!}
        {!! $email ?? '' !!}
        {!! $mobile ?? '' !!}
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                {!! $placeOfBirth ?? '' !!}
            </div>
            <div class="col-sm-12 col-md-6">
                {!! $dateOfBirth ?? '' !!}
            </div>
        </div>
        {!! $address ?? '' !!}
        {!! $province ?? '' !!}
        {!! $city ?? '' !!}
        {!! $ZIP ?? '' !!}
    </div>
    <div class="col-md-4 col-sm-12">
        {!! $companyName ?? '' !!}
        {!! $idType ?? '' !!}
        {!! $idNumber ?? '' !!}
        {!! $idPic ?? '' !!}
    </div>
</div>
