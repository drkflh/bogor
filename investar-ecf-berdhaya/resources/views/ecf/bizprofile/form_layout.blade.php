
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

    <div class="form-row" style="border-bottom: thin solid #000000;">
    </div>
    <div class="row" style="margin-left:3px;">
        <div class="col-12" style="margin-bottom:5px; ">
             <div class="row pb-4">
                <div class="col-2">
                    {!! $bizCompanyType?? '' !!}
                </div>
                <div class="col-4">
                    {!! $bizRegisteredName ?? '' !!}
                </div>
                <div class="col-4">
                    {!! $bizTradeMark ?? '' !!}
                </div>
                <div class="col-2">
                    {!! $bizType ?? '' !!}
                </div>
            </div>
        </div>
    </div>
    <div class="form-row" style="border-bottom: thin solid #000000;">
    </div>

    <div class="row" style="margin-left:3px;">
        <div class="col-12" style="margin-bottom:5px; ">
            <h5 class="mt-5" style="color:#000000; font-size: 17px;margin-top:5px;"><b>Info Perusahaan: </b></h5>
            <div class="row">
                <div class="col">
                    {!! $ownerIdCard ?? '' !!}
                </div>
                <div class="col">
                    {!! $directorIdCard ?? '' !!}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    {!! $bizAddress ?? '' !!}
                </div>
            </div>
            <!-- <div class="row">
                <div class="col">
                    {!! $legality ?? '' !!}
                </div>
            </div> -->
            <!-- <div class="row pb-2">
                <div class="col">
                    {!! $noNPWP ?? '' !!}
                </div>
            </div> -->
            <div class="row pb-4">
                <div class="col">
                    {!! $noNPWP ?? '' !!}
                </div>
                <div class="col">
                    {!! $noOfBranches ?? '' !!}
                </div>
                <div class="col">
                    {!! $establishedSinceYear ?? '' !!}
                </div>
                <div class="col">
                    {!! $establishedYear ?? '' !!}
                </div>
            </div>
            <div class="row pb-2">
                <div class="col">
                    {!! $productServices ?? '' !!}
                </div>
                <div class="col">
                    {!! $marketingFunnels ?? '' !!}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    {!! $productServicesDescription ?? '' !!}
                </div>
            </div>
            <div class="row pb-2">
                <div class="col">
                    {!! $monthlyGrossRevenue ?? '' !!}
                </div>
                <div class="col">
                    {!! $monthlyNettRevenue ?? '' !!}
                </div>
            </div>
        </div>
    </div>
    <div class="form-row" style="border-bottom: thin solid #000000;">
    </div>

    <div class="row" style="margin-left:3px;">
        <div class="col-6" style="margin-bottom:5px; ">
            <h5 class="mt-5" style="color:#000000; font-size: 17px;margin-top:5px;"><b> Penanggung Jawab: </b></h5>
            <div class="row pb-2">
                <div class="col">
                    {!! $name ?? '' !!}
                </div>
                <div class="col">
                    {!! $position ?? '' !!}
                </div>
            </div>
            <div class="row pb-2">
                <div class="col">
                    {!! $email ?? '' !!}
                </div>
                <div class="col">
                    {!! $contactWA ?? '' !!}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    {!! $idPic ?? '' !!}
                </div>
            </div>
            <h5 class="mt-5" style="color:#000000; font-size: 17px;margin-top:5px;"><b>Pendanaan: </b></h5>
            <div class="row pb-2">
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

            <h5 class="mt-5" style="color:#000000; font-size: 17px;margin-top:5px;"><b>Lainnya: </b></h5>
            <div class="row">
                <div class="col">
                     {!! $covidStrategy ?? '' !!}  
                </div>                                  
            </div>
            <div class="row">
                <div class="col">
                    {!! $getToKnowInvestar ?? '' !!}
                </div>  
            </div>
        </div>

        <div class="col-5 ml-2" style="border-left: thin solid #000000;">
            <h5 class="mt-5 ml-3" style="color:#000000; font-size:17px;margin-top:5px;"><b>Berkas-Berkas:</b></h5>

                {!! $attAktaPerusahaan ?? '' !!}
                {!! $attSKKemenhumham ?? '' !!}
                {!! $attNIB ?? '' !!}
                {!! $attTDP ?? '' !!}
                {!! $attNPWP ?? '' !!}
                {!! $attCompanyProfile ?? '' !!}
                {!! $attFinancialReports ?? '' !!}
                {!! $bizPlanTriennial ?? '' !!}
                {!! $attBizPlan ?? '' !!}
                {!! $slikOJK ?? '' !!}

        </div>
    </div>
</div>
