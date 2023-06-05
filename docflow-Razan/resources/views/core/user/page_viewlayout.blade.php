<b-tabs content-class="mt-3 tabHeader"
        nav-class="tab-header" fill justified >
    <b-tab title="User Profile" active>
        <div class="row">
            <div class="col-4" style="border-right: thin solid rgba(72, 94, 144, 0.16);">
                {!! $avatar ?? '' !!}
                {!! $name ?? '' !!}
                {!! $roleName ?? '' !!}
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
{{--            <div class="col-4">--}}
{{--                <h5>Bank Info</h5>--}}
{{--                {!! $bankName ?? '' !!}--}}
{{--                {!! $accountName ?? '' !!}--}}
{{--                {!! $accountNumber ?? '' !!}--}}
{{--            </div>--}}
        </div>
    </b-tab>
    <b-tab title="User Identity"
           @click="refreshSignature"
        >
        <div class="row">
{{--            <div class="col-4">--}}
{{--                {!! $idType ?? '' !!}--}}
{{--                {!! $idNumber ?? '' !!}--}}
{{--                {!! $idPic ?? '' !!}--}}
{{--            </div>--}}
            <div class="col-4">
                {!! $signatureSpecimen ?? '' !!}
            </div>
            <div class="col-4" >
                {!! $initialSpecimen ?? '' !!}
            </div>
        </div>
    </b-tab>
{{--    <b-tab title="Employment"--}}
{{--           @click="refreshEmployment"--}}
{{--        >--}}
{{--        <div class="row">--}}
{{--            <div class="col-4">--}}
{{--                {!! $statusEmployee ?? '' !!}--}}
{{--                {!! $companyName ?? '' !!}--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </b-tab>--}}
</b-tabs>
