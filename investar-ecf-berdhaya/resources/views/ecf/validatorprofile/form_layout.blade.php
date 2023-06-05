<div>

<b-tabs content-class="mt-3 tabHeader mb-4" nav-class="tab-header" fill justified>
    <b-tab title="Profile" active>
        {!! $validatorExtId ?? '' !!}
        {!! $validatorName ?? '' !!}
        {!! $validatorEmail ?? '' !!}
        {!! $validatorNik ?? '' !!}
        {!! $validatorPlaceOfBirth ?? '' !!}
        {!! $validatorDateOfBirth ?? '' !!}
        {!! $validatorCountryCode ?? '' !!}
        {!! $validatorMobile ?? '' !!}
        {!! $validatorGender ?? '' !!}
    </b-tab>
    <b-tab title="Address" >
        {!! $validatorAddress ?? '' !!}
        {!! $validatorProvince ?? '' !!}
        {!! $validatorCity ?? '' !!}
        {!! $validatorKelurahan ?? '' !!}
        {!! $validatorZip ?? '' !!}
    </b-tab>
    <b-tab title="Attachment" >
        {!! $validatorPhoto ?? '' !!}
        {!! $validatorIdPhoto ?? '' !!}
        {!! $validatorIdType ?? '' !!}
        {!! $validatorPhone ?? '' !!}
    </b-tab>

    <b-tab title="Account">
        {!! $validatorBankName ?? '' !!}
        {!! $validatorAccountName ?? '' !!}
        {!! $validatorAccountNumber ?? '' !!}
    </b-tab>
</b-tabs>



</div>