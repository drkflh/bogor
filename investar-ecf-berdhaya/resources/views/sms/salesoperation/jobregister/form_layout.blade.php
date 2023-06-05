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
            @if($_isCreate)
                {!! $bidStatus !!}
            @else
                <label for="bidStatus">Bid Status</label>
                <button-modal-pin-ajax
                    ref="changeBidStatusModal"
                    :item.sync="bidStatusObject"
                    ok-title="OK"
                    :no-button="false"
                    :button-text="bidStatus"
                    button-text-class=""
                    button-class="btn bg-transparent"
                    icon-class=""
                    action-url="{{ url( 'sms/sales-operation/job-register/chg-stat' ) }}"
                    :object-default="bidStatusChangeObjDef"
                    content=""
                    :template="bidStatusChangeTemplate"
                    modal-size="md"
                    @hidden="bidStatusChangeHidden"
                    @shown="bidStatusChangeShown"

                    :handle="generateRandomString(5)"
                    :modal-id="generateRandomString(5)"
                >

                </button-modal-pin-ajax>
            @endif
        </div>
        <div style="width: 120px;">
            @if($_isCreate)
                {!! $jobStatus !!}
            @else
                <label for="bidStatus">Job Status</label>
                <button-modal-pin-ajax
                    ref="changeJobStatusModal"
                    :item.sync="jobStatusObject"
                    ok-title="OK"
                    :no-button="false"
                    :button-text="jobStatus"
                    button-text-class=""
                    button-class="btn bg-transparent"
                    icon-class=""
                    action-url="{{ url( 'sms/sales-operation/job-register/chg-stat' ) }}"
                    :object-default="jobStatusChangeObjDef"
                    content=""
                    :template="jobStatusChangeTemplate"
                    modal-size="md"
                    @hidden="jobStatusChangeHidden"
                    @shown="jobStatusChangeShown"

                    :handle="generateRandomString(5)"
                    :modal-id="generateRandomString(5)"
                >

                </button-modal-pin-ajax>
            @endif
        </div>
    </div>
<div class="form-row" style="height:5px; border-bottom: thin solid #000000;border-top: thin solid #000000;">
</div>
<h5 style="color:#000000; font-size: 17px;"><b>Job Profile</b></h5>
<div class="row">
    <div class="col-4" style="border-right: thin solid black;">
        <div class="row">
            <div class="col-7">
                {!! $rfqReference !!}
            </div>
            <div class="col-5" style="">
                {!! $dated!!}
            </div>
        </div>
        <div class="row">
            <div class="col-7">
                {!! $scope !!}
            </div>
            <div class="col-5">
                {!! $typeOfSupply !!}
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
        <div class="row" style="margin-bottom: 29px;margin-top:5px;">
            <div style="width:140px;margin-left: 12px;margin-right:20px;">
                {!! $registrationDate !!}
            </div>
            <div style="width:140px;margin-left: 12px;margin-right:20px;">
                {!! $preQualification !!}
            </div>
            <div style="width:140px;margin-left: 12px;margin-right:20px;">
                {!! $bidSubmission !!}
            </div>
            <div style="width:220px;">
                <label style="display: block;">Pre Bid Meeting</label>
                <div style="width:50px;height:30px;margin-right:6px;display:inline-block;">
                    {!! $withPrebidMeeting !!}
                </div>
                <div style="width:140px;margin-right:0px;display:inline-block;">
                    {!! $prebidMeetingDate !!}
                </div>
            </div>
            <div style="width:140px;">
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
<div class="row">
    <div class="col-12">
        <b-tabs content-class="mt-3 tabHeader mb-4" nav-class="green-tab-header" fill justified >
            <b-tab title="Bid Terms">
                <div class="row" style="margin: 8px;">
                    <div class="col-4">
                        {!! $localContent !!}
                        {!! $ownerEstimate !!}
                        {!! $masterList !!}
                        {!! $custIncoterms !!}
                        {!! $bidDeliveryPoint !!}
                        {!! $bidDeliveryTime !!}
                        {!! $bidRemarks !!}
                    </div>
                    <div class="col-4">
                        {!! $alternativeQuotation !!}
                        {!! $partialQuote !!}
                        {!! $partialDelivery !!}
                        {!! $aml !!}
                        {!! $specificPrequalification !!}
                        {!! $bidWarrantyTime !!}
                    </div>
                    <div class="col-4">
                        <div class="row">
                            <div class="col-6" style="padding-right: 0px;">
                                {!! $penaltyMax !!}
                            </div>
                            <div class="col-5">
                                {!! $penaltyMaxPeriod !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6" style="padding-right: 0px;">
                                {!! $bidBond !!}
                            </div>
                            <div class="col-5">
                                {!! $bidBondPeriod !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6" style="padding-right: 0px;">
                                {!! $performBond !!}
                            </div>
                            <div class="col-5">
                                {!! $performBondPeriod !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6" style="padding-right: 0px;">
                                {!! $warrantyBond !!}
                            </div>
                            <div class="col-5">
                                {!! $warrantyBondPeriod !!}
                            </div>
                        </div>
                        {!! $itbIkppValidity !!}
                        {!! $validityThru !!}
                    </div>
                </div>
            </b-tab>
            <b-tab title="Principal Terms">
                {!! $principalTerms ?? '' !!}
            </b-tab>
            <b-tab title="Bid Documents">
                {!! $bidDocument!!}
            </b-tab>
            <b-tab title="Evaluation">
                <div class="row" style="margin-left: 120px; align-items: center;">

                </div>
            </b-tab>
            <b-tab title="Commercial">
                <div class="row">
                    <div class="col-3">
                        {!! $quotationNo !!}
                    </div>
                    <div class="col-3">
                        {!! $commercialDate !!}
                    </div>
                    <div class="col-4">
                        {!! $quotationAmount !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        {!! $awardPoNo !!}
                    </div>
                    <div class="col-3">
                        {!! $awardPoNoDate !!}
                    </div>
                    <div class="col-4">
                        {!! $awardPoAmount !!}
                    </div>
                </div>
                <hr style="border-bottom: thin solid darkgrey;">
                {!! $commercial !!}
            </b-tab>
            <b-tab title="Follow Up Record">
                {!! $followUp!!}
            </b-tab>
            <b-tab title="Documentations">
                <b-tabs>
                    <b-tab title="GA Drawings">

                    </b-tab>
                    <b-tab title="Installation Manual">

                    </b-tab>
                    <b-tab title="Test Procedures">

                    </b-tab>
                </b-tabs>
            </b-tab>
        </b-tabs>
    </div>
</div>

<div class="form-row" style="border-bottom: thin solid #000000;"></div>
