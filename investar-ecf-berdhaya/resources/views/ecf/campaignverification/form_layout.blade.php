<div class="card">
    <div class="card-body shadow-lg p-3 bg-body rounded">
        <form class="p-5" style="margin-top: -30px;">
            <h4 style="color: rgb(255, 102, 0);"><b>Data Verification</b></h4>
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    {!! $masterId ?? '' !!}
                </div>
                <div class="col-md-3 col-sm-12">
                    {!! $companyId ?? '' !!}
                </div>
                <div class="col-md-3 col-sm-12">
                    {!! $sbuId ?? '' !!}
                </div>
                <div class="col-md-3 col-sm-12">
                    {!! $deptId ?? '' !!}
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    {!! $masterName ?? '' !!}
                </div>
                <div class="col-md-3 col-sm-12">
                    {!! $companyName ?? '' !!}
                </div>
                <div class="col-md-3 col-sm-12">
                    {!! $sbuName ?? '' !!}
                </div>
                <div class="col-md-3 col-sm-12">
                    {!! $deptName ?? '' !!}
                </div>
                
            </div>
            
            <br>
            <h4 style="color: rgb(255, 102, 0);"><b>Form Verification Campaign</b></h4>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    {!! $email ?? '' !!}
                </div>
                <div class="col-md-6 col-sm-12">
                    {!! $contactWA ?? '' !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    {!! $name ?? '' !!}
                </div>
                <div class="col-md-6 col-sm-12">
                    {!! $position ?? '' !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    {!! $ownerIdCard ?? '' !!}
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    {!! $bizTradeMark ?? '' !!}
                </div>
                <div class="col-md-6 col-sm-12">
                    {!! $bizType ?? '' !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    {!! $bizAddress ?? '' !!}
                </div>
            </div>
            <div class="row" style="padding-top: 30px;">
                <div class="col-md-4 col-sm-12">
                    {!! $bizRegisteredName ?? '' !!}
                </div>
                <div class="col-md-4 col-sm-12">
                    {!! $legality ?? '' !!}
                </div>
                <div class="col-md-4 col-sm-12">
                    {!! $bizCompanyType ?? '' !!}
                </div>
                
            </div>
    
            <br>
            <h4 style="color: rgb(255, 102, 0);"><b>Berkas - Berkas</b></h4>
            <div class="row"style="padding-top: 30px;">
                <div class="col-md-6 col-sm-12">
                    {!! $attSKKemenhumham ?? '' !!}
                </div>
                <div class="col-md-6 col-sm-12">
                    {!! $attAktaPerusahaan ?? '' !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    {!! $attTDP ?? '' !!}
                </div>
                <div class="col-md-6 col-sm-12">
                    {!! $attNPWP ?? '' !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    {!! $slikOJK ?? '' !!}
                </div>
                <div class="col-md-6 col-sm-12">
                    {!! $attCompanyProfile ?? '' !!}
                </div>
            </div>
            
            <br>
            <h4 style="color: rgb(255, 102, 0);"><b>Full Description Of Business</b></h4>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    {!! $noNPWP ?? '' !!}
                </div>
                <div class="col-md-6 col-sm-12">
                    {!! $productServices ?? '' !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    {!! $establishedSinceYear ?? '' !!}
                </div>
                <div class="col-md-3 col-sm-12">
                    {!! $noOfBranches ?? '' !!}
                </div>
                <div class="col-md-6 col-sm-12">
                    {!! $establishedYear ?? '' !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    {!! $monthlyGrossRevenue ?? '' !!}
                </div>
                <div class="col-md-3 col-sm-12">
                    {!! $monthlyNettRevenue ?? '' !!}
                </div>
                <div class="col-md-6 col-sm-12">
                    {!! $marketingFunnels ?? '' !!}
                </div>
            </div>
            
            {!! $productServicesDescription ?? '' !!}
    
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    {!! $attFinancialReports ?? '' !!}
                </div>
                <div class="col-md-6 col-sm-12">
                    {!! $bizPlanTriennial ?? '' !!}
                </div>
            </div>
           
            {!! $attBizPlan ?? '' !!}
    
            <div class="row" style="padding-bottom: 30px;">
                <div class="col-md-6 col-sm-12">
                    {!! $requiredFunding ?? '' !!}
                </div>
                <div class="col-md-6 col-sm-12">
                    {!! $typeOfFunding ?? '' !!}
                </div>
            </div>
    
            <div class="row" style="padding-bottom: 30px;">
                <div class="col-md-6 col-sm-12">
                    {!! $contractReference ?? '' !!}
                </div>
                <div class="col-md-6 col-sm-12">
                    {!! $covidStrategy ?? '' !!}
                </div>
            </div>
    
            {!! $getToKnowInvestar ?? '' !!} 
            
        
    </form>
    </div>
</div>