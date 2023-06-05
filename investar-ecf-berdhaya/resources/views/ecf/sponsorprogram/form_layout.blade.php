
<div class="form-row" style="border-bottom: thin solid #000000;">
</div>
<div class="form-row">
    <div style="background-color:#fff199;height:130px;width:200px; margin-right:2px; border-right: thin solid #000000;">
    <center><h1 class="pt-4">SP</h1></center>
    </div>
    <div style="width: 300px;padding-left:20px;padding-right: 15px;margin-top:5px;">
    {!! $period ?? '' !!}
    </div>
    <div style="width: 250px;padding-right:15px;">
        <div style="margin-top:24px;">{!! $sponsorId ?? '' !!}</div>
    </div>
    <div style="width: 170px;padding-right:15px;margin-top:24px;">
    {!! $description ?? '' !!}
    </div>
</div>
<div class="form-row" style="height:5px; border-bottom: thin solid #000000;border-top: thin solid #000000;">
</div>

{{-- end header --}}

{{-- body --}}
<div class="row" style="margin-left:3px;">
    <div class="col-4" style="margin-bottom:5px; ">
        <h5 style="color:#000000; font-size: 17px;"><b>Sponsorship </b></h5>
        <div class="row">
            <div class="col-4">
            {!! $programId ?? '' !!}
            </div>
            <div class="col-8">
            {!! $programName ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-11">
            {!! $sponsorName ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-11">
            {!! $sponsor ?? '' !!}
            </div>
        </div>
    </div>
<div class="col-4" style="border-right: thin solid #000000;border-left: thin solid #000000;">
        <h5 style="color:#000000; font-size:17px;"><b>Voucher</b></h5>
        <div class="row">
            <div class="col-11">
            {!! $voucherPicture ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-3">
            {!! $voucherUnitCurrency ?? '' !!}
            </div>
            <div class="col-9">
            {!! $voucherUnitValue ?? '' !!}
            </div>
        </div>
    </div>
    <div class="col-4">
        <h5 style="color:#000000; font-size:17px;"><b>Program Details</b></h5>
        <div class="row">
            <div class="col-3">
                {!! $qty ?? '' !!}
                </div>
            <div class="col-3">
            {!! $programAllocationCurrency ?? '' !!}
            </div>
            <div class="col-6">
            {!! $programAllocation ?? '' !!}
            </div>
        </div>
    </div>
<div class="form-row pb-3 pt-3" style="border-bottom: thin solid #000000;">
</div>
</div>

<div class="form-row" style="border-bottom: thin solid #000000;">
</div>

<!-- <div class="form-row" style="border-top: thin solid #3d3d3d;"></div> -->
<!-- <b-tabs content-class="mt-3 tabHeader mb-4" nav-class="tab-header" fill justified>

    <b-tab title="Other Program ">
    <div class="row pb-4">
        <div class="col-3">
        {!! $programAllocationCurrency ?? '' !!}
        </div>
        <div class="col-3">
        {!! $programAllocation ?? '' !!}
        </div>
    </div>
     -->
    <!-- </b-tab>
    <b-tab title="Voucher">
    <div class="row">
        <div class="col-4">
            {!! $voucherPicture ?? '' !!}
        </div>
        <div class="col-4">
            {!! $voucherUnitCurrency ?? '' !!}
        </div>
        <div class="col-4">
            {!! $voucherUnitValue ?? '' !!}
        </div>
    </div>
    </b-tab> -->
<!--
    <b-tab title="Koordinat">
    <div class="row">
        <div class="col-4">
        {!! $lng ?? '' !!}
        </div>
        <div class="col-4">
        {!! $lat ?? '' !!}
        </div>
        <div class="col-4">
        {!! $lngLat ?? '' !!}
        </div>
    </div>
    </b-tab> -->
<!-- </b-tabs> -->

<!-- <div class="form-row" style="border-bottom: thin solid #000000;">
</div> -->
