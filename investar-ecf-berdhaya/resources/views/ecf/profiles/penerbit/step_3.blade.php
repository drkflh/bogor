@if (\Session::has('error'))
    <div class="alert alert-danger">
        <ul>
            <li>{!! \Session::get('error') !!}</li>
        </ul>
    </div>
@endif
<div>    
    <div class="row" style="margin-left:3px;">
        <div class="col-6" style="margin-bottom:5px; ">
            <div class="container text-left">
                <div class="row align-items-start">
                {!! $isComplete !!}
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

            <div class="container text-left">
                <div class="row align-items-start">
                    <div class="col">
                    {!! $typeOfFundingDetail ?? '' !!}
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
