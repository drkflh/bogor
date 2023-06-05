<div class="form-row" style="border-bottom: thin solid #000000;">
</div>
<div class="form-row">
    <div style="background-color:#fff199;height:100px;width:200px; margin-right:2px; border-right: thin solid #000000;">
    </div>
    <div style="padding-left:20px;padding-right: 15px;width: 170px;">
        <div style="margin-top:3px;">{!! $requestDate ?? '' !!}</div>
    </div>
    <div style="width: 240px;padding-right:15px;">
        @if($_isCreate)
            {!! $companyCode ?? '' !!}
        @else
            {!! $companyName ?? '' !!}
        @endif
    </div>
    <div style="width: 150px;padding-right:15px;">
        {!! $jobNo ?? '' !!}
    </div>
    <div style="width: 120px;padding-right:15px;">
        {!! $costCenter ?? '' !!}
    </div>
    <div style="color:#000000;width: 85px;padding-right:15px;">
        {!! $currency ?? '' !!}
    </div>
    @if($_isCreate)
        <div style="margin-right: 0px">
            <button class="btn btn-default" style="margin-top:30px;margin-left: -10px;" @click="getPRSequence()">
                <i class="las la-plus-square"></i>
            </button>
        </div>
    @endif
    <div style="width: 200px;">
        {!! $requestNo ?? '' !!}
    </div>
    <div style="width: 30px;margin-left:5px;margin-right:20px;">
        {!! $rev ?? '' !!}
    </div>
</div>
<div class="form-row" style="height:5px; border-bottom: thin solid #000000;border-top: thin solid #000000;">
</div>

{{-- end header --}}

{{-- body --}}
<div class="row" style="margin-left:3px;">
    <div class="col-4" style="margin-bottom:30px; ">
        <h5 style="color:#000000; font-size: 17px;"><b>Order To: </b></h5>
        <div class="row">
            <div class="col-4">
                @if($_isCreate)
                    {!! $vendorObject ?? '' !!}
                @else
                    {!! $vendorCode ?? '' !!}
                @endif
            </div>
            <div class="col-8">
                {!! $vendorName ?? '' !!}
            </div>
        </div>
        <div class="row ">
            <div class="col-12">
                {!! $vendorAddress ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! $vendorAddress2 ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                {!! $vendorCity?? '' !!}
            </div>
            <div class="col-6">
                {!! $vendorProvince?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                {!! $vendorCountry?? '' !!}
            </div>
            <div class="col-6">
                {!! $vendorPostal?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                {!! $vendorPic ?? '' !!}
            </div>
            <div class="col-4">
                {!! $vendorPhone?? '' !!}
            </div>
            <div class="col-4">
                {!! $vendorEmail?? '' !!}
            </div>
        </div>
    </div>
    <div class="col-4" style="border-right: thin solid #000000;border-left: thin solid #000000;">
        <h5 style="color:#000000; font-size:17px;"><b>Deliver To:</b></h5>
        <div class="row">
            <div class="col-12">
                {!! $shippingInstansi ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! $shippingAddress ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! $shippingAddress2 ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                {!! $shippingCity?? '' !!}
            </div>
            <div class="col-6">
                {!! $shippingProvince?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                {!! $shippingCountry?? '' !!}
            </div>
            <div class="col-6">
                {!! $shippingPostalCode?? '' !!}
            </div>
        </div>
        <div class="row mt-1 mb-2">
            <div class="col-4">
                {!! $contactPerson ?? '' !!}
            </div>
            <div class="col-4">
                {!! $contactNo?? '' !!}
            </div>
            <div class="col-4">
                {!! $contactEmail?? '' !!}
            </div>
        </div>
    </div>
    <div class="col-4">
        <h5 style="color:#000000; font-size:17px;"><b>Purpose of Purchase:</b></h5>
        <label style="color:#800000;font-style: italic;font-size:11px;margin:1px 0;">Briefly prescribed the purpose of this purchase</label>
        {!! $purposeOfPurchase?? '' !!}
        <h5 style="color:#000000; font-size:17px;margin-bottom: 24px;"><b>Reference :</b></h5>
        <div class="row">
            <div class="col-5">
                {!! $referenceNo?? '' !!}
            </div>
            <div style="color:#000000;padding-top:3px;" class="col-5">
                {!! $referenceDate?? '' !!}
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-6">
                {!! $incoTerm?? '' !!}
            </div>
            <div class="col-6">
                {!! $modaShipment?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-8">
                <label style="color:#000000;font-weight:bold">Discount:</label>
                <div class="row pt-2">
                    <div class="col-lg-5 col-md-4" >
                        {!! $discountSwitch ?? '' !!}
                    </div>
                    <div class="col-lg-7 col-md-8">
                        {!! $discountPercentage ?? '' !!}
                    </div>
                </div>
                <div class="row pt-2 pb-2">
                    <div class="col-lg-5 col-md-4">
                        {!! $discountLumpSumSwitch ?? '' !!}
                    </div>
                    <div class="col-lg-7 col-md-8">
                        {!! $discountLumpSum ?? '' !!}
                    </div>
                </div>
                <br>
            </div>

            <div class="col-lg-6 col-md-4">
                <label style="color:#000000;font-weight:bold;margin-bottom: 21px;">VAT:</label>
                <div class="row pt-2">
                    <div class="col-12" >
                        {!! $vat ?? '' !!}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="form-row" style="height:1px; border-top: thin solid #000000;">
</div>
<div class="row" style="margin-left:3px;">
    <div class="col-4 pt-1 pb-3">
        <h5>Initial</h5>
        <div class="form-row">
            <div class="pr-3 text-200">
                {!! $reviewedBy1 ?? '' !!}
            </div>
            <div class="pr-3 text-200">
                {!! $reviewedBy2 ?? '' !!}
            </div>
        </div>
    </div>
    <div class="col-8 pt-1 pb-3">
        <h5>Authorization</h5>
        <div class="form-row">
            <div class="pr-3 text-200" >
                {!! $requestBy ?? '' !!}
            </div>
            <div class="pr-3 text-200" >
                {!! $recomendedBy?? '' !!}
            </div>
            <div class="pr-3 text-200" >
                {!! $auditedBy?? '' !!}
            </div>
            <div class="pr-3 text-200" >
                {!! $authorizedBy?? '' !!}
            </div>
        </div>
    </div>
</div>

<div class="form-row" style="height:1px; border-top: thin solid #000000;">
</div>


{{-- tab details --}}
<b-tabs content-class="mt-3 tabHeader mb-4" nav-class="tab-header" fill justified>
    <b-tab title="Detail" active>
        <div class="row">
            {!! $details ?? '' !!}
        </div>
        <div class="row">
            <div class="col-9">

            </div>
            <div class="col-3 total-grid">
                <div class="row">
                    <div class="col-6 text-right">
                        <label style="color:#000000;font-weight:bold;">Total</label>
                    </div>
                    <div class="col-6 text-right">
                        {!! $total ?? '' !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 text-right">
                        <label style="color:#000000;font-weight:bold;">Discount</label>
                    </div>
                    <div class="col-6 text-right">
                        {!! $totalDisc ?? '' !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 text-right">
                        <label style="color:#000000;font-weight:bold;">VAT</label>
                    </div>
                    <div class="col-6 text-right">
                        {!! $totalVat ?? '' !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 text-right">
                        <label style="color:#000000;font-weight:bold;">Grand Total</label>
                    </div>
                    <div class="col-6 text-right">
                        {!! $grandTotal ?? '' !!}
                    </div>
                </div>
            </div>
        </div>
    </b-tab>

    <b-tab title="Invoice Tax">
        <div class="row" style="margin-left: 120px; align-items: center;">
            {!! $invoiceTax ?? '' !!}
        </div>
    </b-tab>

    <b-tab title="Instruction">
        <div class="row" style="margin-left: 120px; align-items: center;">
            {!! $shippingInst ?? '' !!}
        </div>
    </b-tab>

    <b-tab title="Payment Terms">
        <div class="row" style="margin-left: 120px; align-items: center;">
            {!! $termOfPayment ?? '' !!}
        </div>
    </b-tab>

    <b-tab title="Documentation">
        <div class="row">
            <div class="col-12">
                {!! $addDocument ?? '' !!}
            </div>
        </div>
    </b-tab>

    <b-tab title="Correspondence">
        <div class="row" style="margin-left: 120px; align-items: center;">
            {!! $communication ?? '' !!}
        </div>
    </b-tab>

</b-tabs>
