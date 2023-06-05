<div class="form-row" style="border-bottom: thin solid #000000;">
</div>
{{-- <h6 class="form-inline" style="margin-right:100px;"> {!! $participatingCompany !!} &emsp;&emsp;&emsp; {!! $area !!} &emsp;&emsp;&emsp; {!! $status !!} &emsp;&emsp;&emsp; {!! $jobNo !!}</h6> --}}
    <div class="form-row">
        <div style="background-color:#fff199;height:100px;width:150px; margin-right:2px; border-right: thin solid #000000;">
        </div>
        <div class="mr-3" style="padding-left:20px;width: 150px;">
            {!! $inquiryDate !!}
        </div>
        <div class="mr-3" style="width: 210px">
            {!! $participatingCompany !!}
        </div>
        <div class="mr-3" style="width: 120px;">
            {!! $area !!}
        </div>
        <div class="mr-3" style="width: 120px;">
            {!! $status !!}
        </div>
        @if($_isCreate)
        <div style="margin-right: 0px">
                <button class="btn btn-default" style="margin-top:30px;margin-left: -10px;" @click="getJRSequence()">
                    <i class="las la-plus-square"></i>
                </button>
        </div>
        @endif
        <div class="col-1 mr-3">
            {!! $jobNo !!}
        </div>
        <div style="width: 120px;" class="mr-3">
            {!! $bidStatus !!}
        </div>
        <div style="width: 120px;">
            {!! $jobStatus !!}
        </div>
    </div>
<div class="form-row" style="height:5px; border-bottom: thin solid #000000;border-top: thin solid #000000;">
</div>
<h5 style="color:#000000; font-size: 17px;"><b>Job Profile</b></h5>
<div class="row">
    <div class="col-4" style="border-right: thin solid black;">
        <div class="row">
            <div class="col-6">
                {!! $rfqReference !!}
            </div>
            <div class="col-6" style="">
                {!! $dated!!}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! $scope !!}
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="row">
            <div class="col-12">
                {!! $tenderDesc!!}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! $company !!}
            </div>
        </div>
    </div>
    <div class="col-4" style="border-right: thin solid black;">
        <div class="row">
            <div class="col-12">
                {!! $project !!}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! $projectOwner !!}
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-9">
        <h5 style="color:#000000; font-size: 17px;"><b>Schedule</b></h5>
        <div class="row">
            <div class="col-2">
                {!! $registrationDate !!}
            </div>
            <div class="col-2">
                {!! $preQualification !!}
            </div>
            <div class="col-2">
                {!! $bidSubmission !!}
            </div>
            <div class="col-4">
                {!! $withPrebidMeeting !!} {!! $prebidMeetingDate !!}
            </div>
            <div class="col-2">
                {!! $bidOpeningDate !!}
            </div>
        </div>
    </div>
    <div class="col-3" style="border-left: thin #000000 solid;">
        <h5 style="color:#000000; font-size: 17px;"><b>Assignment</b></h5>
        <div class="row">
            <div class="col-6">
                {!! $salesPerson !!}
            </div>
            <div class="col-6">
                {!! $proposal !!}
            </div>
        </div>
    </div>
</div>
<div class="form-row" style="border-top: thin solid #3d3d3d;"></div>

<section>
    <h6>Bid Terms</h6>
    <div class="row">
        <div class="col-4">
            <table table style="width:100%;">
                <tr>
                    <td style="width:35%; padding: 0.1rem 0.1rem;" >Local Content</td>
                    <td style="width:2%; padding: 0.1rem 0.1rem;"> :</td>
                    <td style="width:47%; padding: 0.1rem 0.1rem;">{!! $localContent !!}</td>
                </tr>
                <tr>
                    <td >Owner Estimate</td>
                    <td>:</td>
                    <td>{!! $ownerEstimate !!}</td>
                </tr>
                <tr>
                    <td>Master List</td>
                    <td>:</td>
                    <td>{!! $masterList !!}</td>
                </tr>
                <tr>
                    <td>Customer Incoterms</td>
                    <td>:</td>
                    <td>{!! $custIncoterms !!}</td>
                </tr>
                <tr>
                    <td>Delivery Point</td>
                    <td>:</td>
                    <td>{!! $ownerEstimate !!}</td>
                </tr>
                <tr>
                    <td>Master List</td>
                    <td>:</td>
                    <td>{!! $masterList !!}</td>
                </tr>
                <tr>
                    <td>Customer Incoterms</td>
                    <td>:</td>
                    <td>{!! $custIncoterms !!}</td>
                </tr>
            </table>
        </div>
        <div class="col-4">
            <table table style="width:100%;">
                <tr>
                    <td style="width:35%; padding: 0.1rem 0.1rem;" >Alternative Quote</td>
                    <td style="width:2%;"> :</td>
                    <td style="width:47%;">{!! $alternativeQuotation !!}</td>
                </tr>
                <tr>
                    <td>Partial Quote</td>
                    <td>:</td>
                    <td>{!! $partialQuote !!}</td>
                </tr>
                <tr>
                    <td>Partial Delivery</td>
                    <td>:</td>
                    <td>{!! $partialDelivery !!}</td>
                </tr>
                <tr>
                    <td>AML</td>
                    <td>:</td>
                    <td>{!! $aml !!}</td>
                </tr>
                <tr>
                    <td>Spec. Requirement</td>
                    <td>:</td>
                    <td>{!! $specificPrequalification !!}</td>
                </tr>
                <tr>
                    <td>Warranty Period</td>
                    <td>:</td>
                    <td>{!! $bidWarrantyTime !!}</td>
                </tr>
            </table>
        </div>
        <div class="col-4">
            <table table style="width=100%">
                <tr>
                    <td style="width:35%; padding: 0.1rem 0.1rem;" >Penalty (Max)</td>
                    <td style="width:2%;"> :</td>
                    <td style="width:30%;">{!! $penaltyMax !!}</td>
                    <td style="width:2%;"> |</td>
                    <td style="width:30%;">{!! $penaltyMaxPeriod !!}</td>
                </tr>
                <tr>
                    <td>Bid Bond</td>
                    <td>:</td>
                    <td>{!! $bidBond !!}</td>
                    <td>|</td>
                    <td>{!! $bidBondPeriod !!}</td>
                </tr>
                <tr>
                    <td>Perform Bond</td>
                    <td>:</td>
                    <td>{!! $performBond !!}</td>
                    <td>|</td>
                    <td>{!! $performBondPeriod !!}</td>
                </tr>
                <tr>
                    <td>Warranty Bond</td>
                    <td>:</td>
                    <td>{!! $warrantyBond !!}</td>
                    <td>|</td>
                    <td>{!! $warrantyBondPeriod !!}</td>
                </tr>
                    <tr>
                    <td>Price Validity</td>
                    <td>:</td>
                    <td colspan="2">{!! $itbIkppValidity !!}</td>
                </tr>
                <tr>
                    <td>Valid Thru</td>
                    <td>:</td>
                    <td colspan="2">{!! $validityThru !!}</td>
                </tr>
            </table>
        </div>

    </div>
</section>
<div class="form-row" style="border-bottom: thin solid #000000;"></div>
<section>
    <h6>Principal Terms</h6>
    <div class="row">
        {!! $principalTerms ?? '' !!}
    <div>
</section>

<section>
    <h6>Bid Documents</h6>
    <div class="row">
        {!! $bidDocument!!}
    <div>
</section>
<div class="form-row" style="border-bottom: thin solid #000000;"></div>
<section>
    <h6>Evaluation</h6>
    <div class="row">
        {!! $evaluation ?? '' !!}
    <div>
</section>
<div class="form-row" style="border-bottom: thin solid #000000;"></div>
<section>
    <h6>Commercial</h6>
    <div class="row">
        {!! $commercial ?? '' !!}
    <div>
</section>
<div class="form-row" style="border-bottom: thin solid #000000;"></div>
<section>
    <h6>Follow Up Record</h6>
    <div class="row">
        {!! $followUp ?? '' !!}
    <div>
</section>
<div class="form-row" style="border-bottom: thin solid #000000;"></div>
{{-- status --}}
 {{-- <label style="font-size:13pt;" ><b>Status</b></label>
        <div class="row">
            <div class="col-2">
                {!! $pocontract !!}
            </div>
            <div class="col-2">
                {!! $poAmount !!}
            </div>
        </div>
        <hr style="border: 1px solid;"> --}}

{{-- bid document --}}

