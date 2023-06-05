<b-tabs content-class="mt-3 tabHeader" nav-class="tab-header" fill justified>
    <b-tab title="User Profile" active>
        <div class="row">
            <div class="col-4" style="border-right: thin solid rgba(72, 94, 144, 0.16);">
                {!! $avatar ?? '' !!}
                <div class="row">
                    <div class="col-12">
                        {!! $name ?? '' !!}
                    </div>
{{--                    <div class="col-2">--}}
{{--                        {!! $initial ?? '' !!}--}}
{{--                    </div> --}}
                </div>
                {!! $roleId ?? '' !!}
                {!! $username ?? '' !!}
                {!! $email ?? '' !!}
                {!! $mobile ?? '' !!}
            </div>
            <div class="col-4">

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
                {!! $city ?? '' !!}
                {!! $ZIP ?? '' !!}
                {!! $companyName ?? '' !!}
            </div>
            <div class="col-4">
                @if ($_isCreate)
                    <h5>Authorization</h5>
                    <h6>Password</h6>
                    {!! $password ?? '' !!}
                    {!! $confirm_password ?? '' !!}
                    @if(env('USE_PIN',false))
                    <hr>
                    <h6>PIN</h6>
                    {!! $pin ?? '' !!}
                    {!! $confirm_pin ?? '' !!}
                    <hr>
                    @endif
                @endif
                <h5>Bank Info</h5>
                {!! $bankName ?? '' !!}
                {!! $accountName ?? '' !!}
                {!! $accountNumber ?? '' !!}
            </div>
        </div>
    </b-tab>
    <b-tab title="User Identity" @click="refreshSignature">
        <div class="row justify-content-center">
            <div class="col-8">
                {!! $idType ?? '' !!}
                {!! $idNumber ?? '' !!}
                {!! $idPic ?? '' !!}
                {!! $initialSpecimen ?? '' !!}
                <div class="col-4" style="margin-left:230px;" >
                    {!! $initialInput ?? '' !!}
                </div>
            </div>
            {{-- <div class="col-4" >
                {!! $signatureSpecimen ?? '' !!}
                {!! $signatureInput ?? '' !!}
            </div> --}}
        </div>
    </b-tab>
    <b-tab title="Employment"
           @click="refreshEmployment"
        >
        <div class="row">
            <div class="col-4">
                <div class="row">
                    <div class="col-6 pb-3">
                        {!! $useTimeTracker?? '' !!}
                    </div>
                    <div class="col-6 pb-3">
                        {!! $useAttendance?? '' !!}
                    </div>
                </div>
                {!! $statusEmployee ?? '' !!}
                {!! $employeeId ?? '' !!}
                {!! $companyName ?? '' !!}
                <div class="row">
                    <div class="col-6">
                        {!! $bizUnit ?? '' !!}
                    </div>
                    <div class="col-6">
                        {!! $department ?? '' !!}
                    </div>
                </div>
                {!! $jobObject ?? '' !!}
                <div class="row">
                    <div class="col-7">
                        {!! $jobTitle ?? '' !!}
                    </div>
                    <div class="col-5">
                        {!! $jobTitleSeq ?? '' !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-7">
                        {!! $jobGroup ?? '' !!}
                    </div>
                    <div class="col-5">
                        {!! $jobGroupSeq ?? '' !!}
                    </div>
                </div>
            </div>
            <div class="col-4">
                {!! $costCenter ?? '' !!}
                {!! $allocationCenter ?? '' !!}
                {!! $medicalApprover ?? '' !!}
                {!! $leaveApprover ?? '' !!}
                {!! $expenseApprover ?? '' !!}
            </div>
            <div class="col-4">
                <h5>Leave</h5>
                {!! $leaveCarryOver ?? '' !!}
                {!! $leaveAdvence ?? '' !!}
                {!! $leaveAlreadyTaken ?? '' !!}
                {!! $leaveEntitlement ?? '' !!}
                {!! $leaveOtherEntitilement ?? '' !!}
                {!! $leavePeriod ?? '' !!}
            </div>
        </div>
    </b-tab>
</b-tabs>
