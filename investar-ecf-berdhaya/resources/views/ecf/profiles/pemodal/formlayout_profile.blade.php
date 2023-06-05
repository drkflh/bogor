<b-tabs content-class="mt-3 tabHeader"
        nav-class="tab-header" fill justified >
    <b-tab title="Data Diri" active>
        <div class="row">
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

                <h5 class="section">Identitas</h5>
                <div class="row">
                    <div class="col-2">
                        {!! $idType ?? '' !!}
                    </div>
                    <div class="col-10">
                        {!! $idNumber ?? '' !!}
                    </div>
                </div>
                {!! $idPic ?? '' !!}
            </div>
        </div>
    </b-tab>
    <b-tab title="Profil Usaha"
           @click="refreshSignature"
        >
        <div class="row">
            <div class="col-12">
                {!! $bizTradeMark ?? '' !!}
                <div class="row">
                    <div class="col-4">
                        {!! $bizCompanyType ?? '' !!}
                    </div>
                    <div class="col-md-8 col-sm-12">
                        {!! $bizRegisteredName ?? '' !!}
                    </div>
                </div>
                {!! $bizIdType ?? '' !!}
                {!! $bizIdNumber ?? '' !!}
                {!! $bizAddress ?? '' !!}
                {!! $bizType ?? '' !!}
                <h5 class="section">Penanggung Jawab</h5>
                {!! $bizPicEmail ?? '' !!}
                {!! $bizPicName ?? '' !!}
                {!! $bizPicPosition ?? '' !!}
                <h5 class="section">Media Sosial</h5>
                {!! $bizInstagram ?? '' !!}
                {!! $bizFacebook ?? '' !!}
                {!! $bizTwitter ?? '' !!}
            </div>
        </div>
    </b-tab>
    <b-tab title="Kontak Kerabat"
           @click="refreshSignature"
        >
        <div class="row">
            <div class="col-12">
                {!! $relativeName ?? '' !!}
                {!! $relativeEmail ?? '' !!}
                {!! $relativeMobile ?? '' !!}
                {!! $relativeAddress ?? '' !!}
                {!! $relativeKabupaten ?? '' !!}
                {!! $relativeProvince ?? '' !!}
                {!! $relativeZIP ?? '' !!}

                <h5>Identitas</h5>
                {!! $relativeIdType ?? '' !!}
                {!! $relativeIdNumber ?? '' !!}
                {!! $relativeIdPic ?? '' !!}

            </div>
        </div>
    </b-tab>
</b-tabs>
