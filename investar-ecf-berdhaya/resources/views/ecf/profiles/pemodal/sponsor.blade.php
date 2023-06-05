{{--<b-tabs content-class="mt-3 tabHeader"--}}
{{--        nav-class="tab-header" fill justified >--}}
{{--    <b-tab title="User Profile" active>--}}
        <div class="row">
            <div class="col-12" style="border-right: thin solid rgba(72, 94, 144, 0.16);">
                {!! $avatar ?? '' !!}
                <div class="row">
                    <div class="col-12">
                        {!! $name ?? '' !!}
                    </div>
                    <!-- <div class="col-2">
                        {!! $initial ?? '' !!}
                    </div> -->
                </div>
                {!! $roleName ?? '' !!}
                {!! $username ?? '' !!}
                {!! $email ?? '' !!}
                {!! $mobile ?? '' !!}
            </div>
            <div class="col-12">

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
            </div>
        </div>
{{--            <div class="col-md-6 col-sm-6 col-xs-12">--}}
{{--                <h5>Bank Info</h5>--}}
{{--                {!! $bankName ?? '' !!}--}}
{{--                {!! $accountName ?? '' !!}--}}
{{--                {!! $accountNumber ?? '' !!}--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </b-tab>--}}
{{--    <b-tab title="User Identity" @click="refreshSignature" >--}}
{{--        <div class="row">--}}
{{--            <div class="col-4">--}}
{{--                {!! $idType ?? '' !!}--}}
{{--                {!! $idNumber ?? '' !!}--}}
{{--                {!! $idPic ?? '' !!}--}}
{{--            </div>--}}
{{--            <div class="col-4" >--}}
{{--                {!! $signatureSpecimen ?? '' !!}--}}
{{--                {!! $signatureInput ?? '' !!}--}}
{{--            </div>--}}
{{--            <div class="col-4">--}}
{{--                {!! $initialSpecimen ?? '' !!}--}}
{{--                {!! $initialInput ?? '' !!}--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </b-tab>--}}
{{--    <b-tab title="Employment"--}}
{{--           @click="refreshEmployment"--}}
{{--        >--}}
{{--        <div class="row">--}}
{{--            <div class="col-4">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-6 pb-3">--}}
{{--                        {!! $useTimeTracker?? '' !!}--}}
{{--                    </div>--}}
{{--                    <div class="col-6 pb-3">--}}
{{--                        {!! $useAttendance?? '' !!}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                {!! $statusEmployee ?? '' !!}--}}
{{--                {!! $employeeId ?? '' !!}--}}
{{--                {!! $employeeDateHired ?? '' !!}--}}
{{--                {!! $companyName ?? '' !!}--}}
{{--                <div class="row">--}}
{{--                    <div class="col-6">--}}
{{--                        {!! $jobTitle ?? '' !!}--}}
{{--                    </div>--}}
{{--                    <div class="col-6">--}}
{{--                        {!! $department ?? '' !!}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-4">--}}
{{--                {!! $costCenter ?? '' !!}--}}
{{--                {!! $allocationCenter ?? '' !!}--}}
{{--                {!! $medicalApprover ?? '' !!}--}}
{{--                {!! $leaveApprover ?? '' !!}--}}
{{--                {!! $expenseApprover ?? '' !!}--}}
{{--            </div>--}}
{{--            <div class="col-4">--}}
{{--                <h5>Leave</h5>--}}
{{--                {!! $leaveCarryOver ?? '' !!}--}}
{{--                {!! $leaveAdvence ?? '' !!}--}}
{{--                {!! $leaveAlreadyTaken ?? '' !!}--}}
{{--                {!! $leaveEntitlement ?? '' !!}--}}
{{--                {!! $leaveOtherEntitilement ?? '' !!}--}}
{{--                {!! $leavePeriod ?? '' !!}--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </b-tab>--}}
{{--</b-tabs>--}}
