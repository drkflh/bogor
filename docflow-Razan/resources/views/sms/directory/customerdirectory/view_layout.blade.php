<div class="row">
    <div class="col-7" style="border-right: thin solid #800000; ">
        <div class="row">
            <div class="col-3">
                {!! $customerClass !!}
            </div>
            <div class="col-5">
                {!! $customerName !!}
            </div>
            <div class="col-1">
                <label>&nbsp;Create </label>
                <button class="btn btn-default" @click="getSequence()">
                    <i class="fa fa-plus-square"></i>
                </button>
            </div>
            <div class="col-3 font-weight-bold">
                {!! $customerCode !!}
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                {!! $address !!}
                {!! $address2 !!}
            </div>
            <div class="col-3">
                {!! $city !!}
                {!! $country!!}
            </div>
            <div class="col-3">
                {!! $province!!}
                {!! $postalCode!!}
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                {!! $offPhones!!}
                {!! $offEmails !!}
            </div>
            <div class="col-6">
                {!! $offFaxes !!}
                {!! $website !!}
            </div>
        </div>
        <div style="color:#800000;">
            {!! $picContacts !!}
        </div>
    </div>
    <div class="col-5">
        <div class="container mt-4">
            <div style="color:#800000;">Filled by Finance Department Only:</div>
            <hr style="margin-top:2px;">
            <div class="row">
                <div class="col-6">
                    {!! $customerTaxId !!}
                    {!! $pkpNo !!}
                </div>
                <div class="col-1">
                </div>
                <div class="col-5" style="color:#800000;">
                    {!! $taxCollector !!}
                </div>
            </div>
        </div>
    </div>
</div>

