@if(Auth::user()->roleSlug == 'penerbit')
    <b-tabs content-class="mt-3 tabHeader"
        nav-class="tab-header" fill justified >
        <b-tab title="Personal Profile" active>
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
                <div class="col-md-10">
                    {!! $idNumber ?? '' !!}
                </div>
                <div class="cold-md-12">
                    {!! $idPic ?? '' !!}
                </div>
            </form>
        </b-tab>
        @if(Auth::user()->approvalStatus == 'DECLINED')
        <b-tab title="Data Individu">
            <div class="row" style="margin-left:3px;">
                <div class="col-12" style="margin-bottom:5px; ">
                    <div class="row">
                        <div class="col-6">
                            {!! $name ?? '' !!}
                        </div>
                        <div class="col-6">
                            {!! $contactWA ?? '' !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {!! $position ?? '' !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            {!! $ownerIdCard ?? '' !!}
                        </div>
                        <div class="col-6">
                            {!! $directorIdCard ?? '' !!}
                        </div>
                    </div>
                </div>
            </div>
        </b-tab>
        <b-tab title="Legalitas">
            <div class="row" style="margin-left:3px;">
                <div class="col-6" style="margin-bottom:5px; ">
                    <div class="container text-left">
                        <div class="row align-items-start">
                            <div class="col">
                                {!! $bizTradeMark ?? '' !!}
                            </div>
                        </div>
                    </div>
                    <div class="container text-left">
                        <div class="row align-items-start">
                            <div class="col">
                                {!! $bizAddress ?? '' !!}
                            </div>
                        </div>
                    </div>
                    
                    <div class="container text-left">
                        <div class="row align-items-start">
                            <div class="col">
                            {!! $bizType ?? '' !!}  
                            </div>
                        </div>
                    </div>

                    <div class="container text-left">
                        <div class="row align-items-start">
                            <div class="col">
                                {!! $bizRegisteredName ?? '' !!}
                            </div>
                        </div>
                    </div>

                    <div class="container text-left">
                        <div class="row align-items-start">
                            <div class="col">
                            {!! $bizCompanyType ?? '' !!}
                            </div>
                        </div>
                    </div>

                    <div class="container text-left">
                        <div class="row align-items-start">
                            <div class="col">
                            {!! $bizIdType ?? '' !!}
                            </div>                    
                        </div>
                    </div>

                    <div class="container text-left">
                        <div class="row align-items-start">
                            <div class="col">
                            {!! $bizIdNumber ?? '' !!}
                            </div>                    
                        </div>
                    </div>

                    <div class="container text-left">
                        <div class="row align-items-start">
                            <div class="col">
                            {!! $noNPWP ?? '' !!}
                            </div>
                        </div>
                    </div>

                    <div class="container text-left">
                        <div class="row align-items-start">
                            <div class="col">
                            {!! $attNPWP ?? '' !!}
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="col-5 ml-2" style="border-left: thin solid #000000;">
                    <div class="container text-left">
                        {!! $attAktaPerusahaan ?? '' !!}
                        {!! $attSKKemenhumham ?? '' !!}
                        {!! $attTDP ?? '' !!}
                        {!! $slikOJK ?? '' !!}
                        {!! $legality ?? '' !!}
                    </div>
                </div>
            </div>
        </b-tab>
        <b-tab title="Informasi Bisnis">
            <div>    
                <div class="row" style="margin-left:3px;">
                    <div class="col-6" style="margin-bottom:5px; ">
                        <div class="container text-left">
                            <div class="row align-items-start">
                                <div class="col">
                                {!! $productServices ?? '' !!}
                                </div>
                            </div>
                        </div>
                        <div class="container text-left">
                            <div class="row align-items-start">
                                <div class="col">
                                {!! $productServicesDescription ?? '' !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="container text-left">
                            <div class="row align-items-start">
                                <div class="col">
                                {!! $establishedSinceYear ?? '' !!}
                                </div>
                            </div>
                        </div>

                        <div class="container text-left">
                            <div class="row align-items-start">
                                <div class="col">
                                {!! $noOfBranches ?? '' !!}
                                </div>
                            </div>
                        </div>

                        <div class="container text-left">
                            <div class="row align-items-start">
                                <div class="col">
                                {!! $marketingFunnels ?? '' !!}
                                </div>
                            </div>
                        </div>

                        <div class="container text-left">
                            <div class="row align-items-start">
                                <div class="col">
                                {!! $monthlyGrossRevenue ?? '' !!}
                                </div>                    
                            </div>
                        </div>

                        <div class="container text-left">
                            <div class="row align-items-start">
                                <div class="col">
                                {!! $monthlyNettRevenue ?? '' !!}
                                </div>                    
                            </div>
                        </div>

                        <div class="container text-left">
                            <div class="row align-items-start">
                                <div class="col">
                                {!! $requiredFunding ?? '' !!}
                                </div>
                            </div>
                        </div>

                        <div class="container text-left">
                            <div class="row align-items-start">
                                <div class="col">
                                {!! $typeOfFunding ?? '' !!}
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    
                    <div class="col-5 ml-2" style="border-left: thin solid #000000;">
                        <div class="container text-left">
                        {!! $attCompanyProfile ?? '' !!}
                        {!! $attFinancialReports ?? '' !!}
                        {!! $bizPlanTriennial ?? '' !!}
                        {!! $attBizPlan ?? '' !!}         
                        <!-- {!! $contractReference ?? '' !!} -->
                        {!! $covidStrategy ?? '' !!}
                        </div>
                    </div>
                </div>
            </div>
        </b-tab>
        <b-tab title="Sumber Informasi">
            <div>
                {!! $getToKnowInvestar ?? '' !!}
            </div>
        </b-tab>
        @endif
    </b-tab>

@elseif(Auth::user()->roleSlug == 'pemodal')
    <b-tabs content-class="mt-3 tabHeader"
        nav-class="tab-header" fill justified >
        <b-tab title="Personal Profile" active>
            <form class="row g-3">
                <div class="col-12">
                    {!! $avatar ?? '' !!}
                </div>
                <div class="col-md-6">
                    {!! $name ?? '' !!}
                </div>
                <div class="col-md-6">
                    {!! $placeOfBirth ?? '' !!}
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
                <div class="col-md-10">
                    {!! $idNumber ?? '' !!}
                </div>
                <div class="cold-md-12">
                    {!! $idPic ?? '' !!}
                </div>
            </form>
        </b-tab>
        @if(Auth::user()->approvalStatus == 'DECLINED')
        <b-tab title="Personal Info">
            <div class="row" style="margin-left:3px;">
                <div class="col-6" style="margin-bottom:5px; ">
                    <div class="container text-left">
                    {!! $name ?? '' !!}
                    <div class="row align-items-start">
                        <div class="col">
                        {!! $firstName ?? '' !!}
                        </div>
                        <div class="col">
                        {!! $lastName ?? '' !!}
                        </div>
                    </div>
                    
                    {!! $gender ?? '' !!}
                    <div class="row align-items-start">
                        <div class="col">
                        {!! $placeOfBirth ?? '' !!}
                        </div>
                    </div>
                    
                    
                    {!! $citizenship ?? '' !!}
                    {!! $maritalStatus ?? '' !!}
                    {!! $relativeName ?? '' !!}
                    {!! $relativeMobile ?? '' !!}
                    {!! $relativeRelation ?? '' !!}
                    </div>
                </div>

                <div class="col-5 ml-2" style="border-left: thin solid #000000;">
                    <div class="container text-left">
                        {!! $IdCardAddress ?? '' !!}
                        {!! $address ?? '' !!}


                        {!! $lastEducation ?? '' !!}
                        {!! $currentJob ?? '' !!}
                        {!! $monthlyIncome ?? '' !!}
                        {!! $incomeSource ?? '' !!}

                        {!! $currentJobDesc ?? '' !!}
                        {!! $incomeSourceDesc ?? '' !!}
                    </div>
                </div>
            </div>
        </b-tab>
        <b-tab title="Document">
            <div class="row" style="margin-left:3px;">
                <div class="col-6" style="margin-bottom:5px; ">
                    <div class="container text-left">
                    {!! $idPic ?? '' !!}
                    {!! $idCardSelfie ?? '' !!}
                    
                    </div>
                </div>

                <div class="col-5" style="border-left: thin solid #000000;">
                    <div class="container text-left">
                    {!! $npwpPicture ?? '' !!}
                    {!! $npwpSelfie ?? '' !!}
                    {!! $kkPicture ?? '' !!}
                    </div>
                </div>
            </div>
        </b-tab>
        <b-tab title="Bank">
            <form class="row g-3">
                <div class="col-12">
                {!! $noSid ?? '' !!}
                </div>
                <div class="col-md-6">
                {!! $bankName ?? '' !!}
                </div>
                <div class="col-md-6">
                {!! $bankNo ?? '' !!}
                </div>
                <div class="col-md-6">
                {!! $bankNoOwner ?? '' !!}
                </div>
                <div class="col-md-6">
                {!! $motherName ?? '' !!}
                </div>
                <div class="col-md-6">
                {!! $heirName ?? '' !!}
                </div>
                <div class="col-md-6">
                {!! $heirRelation ?? '' !!}
                
                </div>
            </form>

        </b-tab>
        <b-tab title="Preference">
            <form class="row g-3">
                <div class="col-md-6">
                {!! $investmentBudget ?? '' !!}
                </div>
                <div class="col-md-6">
                {!! $investmentGoal ?? '' !!}
                </div>
                <div class="col-md-6">
                {!! $risk ?? '' !!}
                </div>
                <div class="col-md-6">
                {!! $investmentPreference ?? '' !!}
                </div>
                <div class="col-md-6">
                {!! $investorType ?? '' !!}
                </div>
                <div class="col-md-6">
                {!! $getToKnowInvestar ?? '' !!}
                </div>
                <div class="col-md-12">
                {!! $legality ?? '' !!}
                
                </div>
            </form>
        </b-tab>
        @endif
    </b-tab>
@else
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
    @if (Auth::user()->roleSlug == 'pemodal')
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
    @endif
</b-tabs>
@endif
