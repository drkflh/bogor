
<!-- <div>

{{-- {!! $masterId ?? '' !!}
{!! $masterName ?? '' !!}
{!! $companyId ?? '' !!}
{!! $companyName ?? '' !!}
{!! $sbuId ?? '' !!}
{!! $sbuName ?? '' !!}
{!! $deptId ?? '' !!}
{!! $deptName ?? '' !!} --}}
{!! $email ?? '' !!}
{!! $name ?? '' !!}
{!! $position ?? '' !!}
{!! $contactWA ?? '' !!}
{!! $ownerIdCard ?? '' !!}
{!! $bizTradeMark ?? '' !!}
{!! $bizAddress ?? '' !!}
{!! $bizType ?? '' !!}
{!! $bizRegisteredName ?? '' !!}
{!! $bizCompanyType ?? '' !!}
{!! $legality ?? '' !!}
{!! $attAktaPerusahaan ?? '' !!}
{!! $attSKKemenhumham ?? '' !!}
{!! $attTDP ?? '' !!}
{!! $attNPWP ?? '' !!}
{!! $noNPWP ?? '' !!}
{!! $slikOJK ?? '' !!}
{!! $productServices ?? '' !!}
{!! $establishedSinceYear ?? '' !!}
{!! $establishedYear ?? '' !!}
{!! $attCompanyProfile ?? '' !!}
{!! $noOfBranches ?? '' !!}
{!! $productServicesDescription ?? '' !!}
{!! $marketingFunnels ?? '' !!}
{!! $monthlyGrossRevenue ?? '' !!}
{!! $monthlyNettRevenue ?? '' !!}
{!! $attFinancialReports ?? '' !!}
{!! $bizPlanTriennial ?? '' !!}
{!! $attBizPlan ?? '' !!}
{!! $requiredFunding ?? '' !!}
{!! $typeOfFunding ?? '' !!}
{!! $contractReference ?? '' !!}
{!! $covidStrategy ?? '' !!}
{!! $campaignTitle ?? '' !!}
{!! $campaignPeriod ?? '' !!}
{!! $campaignStart ?? '' !!}
{!! $campaignEnd ?? '' !!}
{!! $campaignExecSummary ?? '' !!}
{!! $campaignProspectus ?? '' !!}
{!! $projectROI ?? '' !!}
{!! $projectDuration ?? '' !!}
{!! $lotEmitted ?? '' !!}
{!! $pricePerLot ?? '' !!}
{!! $unitPerLot ?? '' !!}
{!! $minLot ?? '' !!}
{!! $dividendPeriod ?? '' !!}
{!! $dividendPeriodUnit ?? '' !!}
{!! $dividendAnnualReturn ?? '' !!}
</div> -->



<div>
@if (\Session::has('msg'))
    <div class="alert alert-danger">
        <ul>
            <li>{!! \Session::get('msg') !!}</li>
        </ul>
    </div>
@endif

    <div class="form-row" style="border-bottom: thin solid #000000;">
    </div>
    <div class="form-row">
            <div class="container text-left">
                <div class="row align-items-start">
                    <div style="background-color:#fff199;height:80px;width:170px; margin-right:2px; border-right: thin solid #000000;">
                    <center><h1>KP</h1></center>
                    </div>
            
                    <div class="col">
                        {!! $bizProfileId ?? '' !!}
                    </div>

                    <div class="col">
                        {!! $bizType ?? '' !!}
                    </div>

                    <div class="col">
                        {!! $bizCompanyType ?? '' !!}
                    </div>
                </div>
            </div>

            <div class="container text-left mb-3">
                <div class="row align-items-start">
                    <div class="col">
                        {!! $bizRegisteredName ?? '' !!}
                    </div>

                    <div class="col">
                        {!! $bizTradeMark ?? '' !!}
                    </div>
                </div>
            </div>
    </div>

    <div class="form-row" style="border-bottom: thin solid #000000;">
    </div>

    <div class="row mb-3" style="margin-left:3px;">
        <div class="col-6" style="margin-bottom:5px; ">
            <h5 class="mt-3" style="color:#000000; font-size: 17px;margin-top:5px;"><b>Info Perusahaan: </b></h5>
                <div class="container text-left">
                <div class="row align-items-start">
                    <div class="col">
                        {!! $ownerIdCard ?? '' !!}
                    </div>
                    <div class="col">
                        {!! $directorIdCard ?? '' !!}
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
                        {!! $noNPWP ?? '' !!}
                    </div>
                    <!-- <div class="col">
                        {!! $legality ?? '' !!}
                    </div> -->
                    <div class="col">
                        {!! $noOfBranches ?? '' !!}
                    </div>
                    <!-- <div class="col">
                        {!! $slikOJK ?? '' !!}
                    </div> -->
                </div>
            </div>
            <div class="container text-left">
                <div class="row align-items-start">
                    

                    <div class="col">
                        {!! $establishedSinceYear ?? '' !!}
                    </div>

                    <div class="col">
                        {!! $establishedYear ?? '' !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-5 ml-2" style="border-left: thin solid #000000;">
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
                        {!! $marketingFunnels ?? '' !!}
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
                        {!! $monthlyGrossRevenue ?? '' !!}
                    </div>
                    <div class="col">
                        {!! $monthlyNettRevenue ?? '' !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-row" style="border-bottom: thin solid #000000;">
    </div>

    <div class="row" style="margin-left:3px;">
        <div class="col-6" style="margin-bottom:5px; ">
            <h5 class="mt-3" style="color:#000000; font-size: 17px;margin-top:5px;"><b> Penanggung Jawab: </b></h5>
            <div class="container text-left">
                <div class="row align-items-start">
                    <div class="col">
                        {!! $name ?? '' !!}
                    </div>
                    <div class="col">
                        {!! $position ?? '' !!}
                    </div>
                </div>
            </div>
            <div class="container text-left">
                <div class="row align-items-start">
                    <div class="col">
                        {!! $email ?? '' !!}
                    </div>
                    <div class="col">
                        {!! $contactWA ?? '' !!}
                    </div>
                </div>
            </div>
            <div class="container text-left">
                <div class="row align-items-start">
                    <div class="col">
                        {!! $idPic ?? '' !!}
                    </div>
                </div>
            </div>
            <h5 class="mt-3" style="color:#000000; font-size: 17px;margin-top:5px;"><b>Pendanaan: </b></h5>
            <div class="container text-left">
                <div class="row align-items-start">
                    <div class="col">
                        {!! $requiredFunding ?? '' !!}
                    </div>
                    <div class="col">
                        {!! $typeOfFunding ?? '' !!}
                    </div>
                    <div class="col">
                        {!! $typeOfFundingDetail ?? '' !!}
                    </div>
                </div>
            </div>

            <h5 class="mt-3" style="color:#000000; font-size: 17px;margin-top:5px;"><b>Kampanye: </b></h5>
            <div class="container text-left">
                <div class="row align-items-start">
                    <div class="col">
                        {!! $campaignTitle ?? '' !!}
                    </div>
                    <div class="col">
                        {!! $campaignPeriod ?? '' !!}
                    </div>
                </div>
            </div>

            <div class="container text-left">
                <div class="row align-items-start">
                    <div class="col">
                        {!! $campaignExecSummary ?? '' !!}
                    </div>
                </div> 
                <div class="row align-items-start">
                    <div class="col">
                        {!! $campaignProspectus ?? '' !!}
                    </div>
                </div>                
                {!! $picture ?? '' !!}
            </div>
    
            <h5 class="mt-3" style="color:#000000; font-size: 17px;margin-top:5px;"><b>Projek: </b></h5>
            <div class="container text-left">
                <div class="row align-text-start">
                    <div class="col">
                        {!! $projectROI ?? '' !!}
                    </div>
                    <div class="col">
                        {!! $projectDuration ?? '' !!}
                    </div>
                </div>
            </div>
            <h5 class="mt-3" style="color:#000000; font-size: 17px;margin-top:5px;"><b>lot: </b></h5>
            <div class="container text-left">
                <div class="row align-text-start">
                    <div class="col">
                        {!! $lotEmitted ?? '' !!}
                    </div>
                    <div class="col">
                        {!! $pricePerLot ?? '' !!}
                    </div>
                </div>
            </div>
            <div class="container text-left">
                <div class="row align-text-start">
                    <div class="col">
                        {!! $unitPerLot ?? '' !!}
                    </div>
                    <div class="col">
                        {!! $minLot ?? '' !!}
                    </div>
                </div>
            </div>
            <h5 class="mt-3" style="color:#000000; font-size: 17px;margin-top:5px;"><b>Dividen: </b></h5>
            <div class="container text-left">
                <div class="row align-text-start">
                    <div class="col">
                        {!! $dividendPeriod ?? '' !!}
                    </div>
                    <div class="col">
                        {!! $dividendPeriodUnit ?? '' !!}
                    </div>
                </div>
                <div class="row align-text-star">
                    <div class="col">
                        {!! $dividendAnnualReturn ?? '' !!}
                    </div>
                </div>
            </div>
            <h5 class="mt-3" style="color:#000000; font-size: 17px;margin-top:5px;"><b>Lainnya: </b></h5>
            <div class="container text-left">
                <div class="row align-text-start">
                    <div class="col">
                        {!! $contractReference ?? '' !!}
                    </div>
                </div>
            </div>
            <div class="container text-left">
                <div class="row align-text-start">
                    <div class="col">
                        {!! $covidStrategy ?? '' !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-5 ml-2" style="border-left: thin solid #000000;">
            <h5 class="mt-3" style="color:#000000; font-size:17px;margin-top:5px;"><b>Berkas-Berkas:</b></h5>
            <div class="container text-left">
                {!! $attAktaPerusahaan ?? '' !!}
                {!! $attSKKemenhumham ?? '' !!}
                {!! $attNIB ?? '' !!}
                {!! $attTDP ?? '' !!}
                {!! $attNPWP ?? '' !!}
                {!! $slikOJK ?? '' !!}
                {!! $attCompanyProfile ?? '' !!}
                {!! $attFinancialReports ?? '' !!}
                {!! $bizPlanTriennial ?? '' !!}
                {!! $attBizPlan ?? '' !!}
            </div>
        </div>
    </div>
</div>
