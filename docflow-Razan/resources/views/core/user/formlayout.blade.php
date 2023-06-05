<b-tabs content-class="mt-3 tabHeader"
        nav-class="tab-header" fill justified >
    <b-tab title="User Profile" active>
        <div class="row">
            <div class="col-4" style="border-right: thin solid rgba(72, 94, 144, 0.16);">
                {!! $avatar ?? '' !!}
                {!! $name ?? '' !!}
                {!! $roleId ?? '' !!}
                {!! $username ?? '' !!}
                {!! $email ?? '' !!}
                {!! $mobile ?? '' !!}
            </div>
            <div class="col-4">
                {!! $placeOfBirth ?? '' !!}
                {!! $dateOfBirth ?? '' !!}
                {!! $address ?? '' !!}
                {!! $province ?? '' !!}
                {!! $city ?? '' !!}
                {!! $ZIP ?? '' !!}
            </div>
            <div class="col-4">
                @if($_isCreate)
                    <h5>Authorization</h5>
                    <h6>Password</h6>
                    {!! $password ?? '' !!}
                    {!! $confirm_password ?? '' !!}
                    <br>
                    <h6>PIN</h6>
                    {!! $pin ?? '' !!}
                    {!! $confirm_pin ?? '' !!}
                    <br>
                    <br>
                @endif
            </div>
        </div>
    </b-tab>
    <b-tab title="User Identity"
           @click="refreshSignature"
        >
        <div class="row">
            <div class="col-4">
                {!! $idType ?? '' !!}
                {!! $idNumber ?? '' !!}
                {!! $idPic ?? '' !!}
            </div>
            <div class="col-4" >
                {!! $signatureSpecimen ?? '' !!}
                {!! $signatureInput ?? '' !!}
            </div>
            <div class="col-4">
                {!! $initialSpecimen ?? '' !!}
                {!! $initialInput ?? '' !!}
            </div>
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

            </div>
            <div class="col-4">

            </div>
        </div>
    </b-tab>
</b-tabs>
