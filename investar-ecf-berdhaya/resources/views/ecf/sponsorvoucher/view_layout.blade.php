

<div class="form-row" style="border-bottom: thin solid #000000;">
</div>
<div class="form-row">
    <div style="background-color:#fff199;height:100px;width:200px; margin-right:2px; border-right: thin solid #000000;">
    <center><h1>SV</h1></center>
    </div>
    <div style="padding-left:20px;padding-right: 15px;width: 200px;">
        <div style="margin-top:5px;">{!! $voucherCode ?? '' !!}</div>
    </div>
    <div style="width: 150px;padding-right:15px;margin-top:5px;">
        {!! $voucherCurrency ?? '' !!}
    </div>
    <div style="width: 150px;padding-right:15px;margin-top:5px;">
        {!! $voucherValue ?? '' !!}
    </div>
    <!-- <div style="width: 200px;margin-top:5px;">
        
    </div> -->
</div>
<div class="form-row" style="height:5px; border-bottom: thin solid #000000;border-top: thin solid #000000;">
</div>

{{-- end header --}}

{{-- body --}}
<div class="row" style="margin-left:3px;">
    <!-- <div class="col-4" style="margin-bottom:5px; "> -->
        <!-- <h5 style="color:#000000; font-size: 17px;"><b>Departemen & SBU</b></h5> -->
        <!-- <div class="row">
            <div class="col-11">
                {!! $sbuId ?? '' !!}
            </div>
        </div> -->
        <!-- <div class="row">
            <div class="col-11">
            {!! $sbuName ?? '' !!}
            </div>
        </div> -->
        <!-- <div class="row">
            <div class="col-11">
            {!! $deptId ?? '' !!}
            </div>
        </div> -->
        <!-- <div class="row">
            <div class="col-11">
            {!! $deptName ?? '' !!}
            </div>
        </div> -->
    <!-- </div> -->
<div class="col-6" style="border-right: thin solid #000000;border-left: thin solid #000000;">
        <h5 style="color:#000000; font-size:17px;"><b>Program Sponsor</b></h5>
        <!-- <div class="row">
            <div class="col-11">
            {!! $sponsorId ?? '' !!}
            </div>
        </div> -->
        <div class="row">
            <div class="col-11">
            {!! $sponsorName?? '' !!}
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-11">
            {!! $programId ?? '' !!}
            </div>
        </div> -->
        <div class="row">
            <div class="col-11">
            {!! $programName ?? '' !!}
            </div>
        </div>
    </div>
    <div class="col-6" style="border-right: thin solid #000000;border-left: thin solid #000000;">
        <h5 style="color:#000000; font-size:17px;"><b>Rincian</b></h5>
        <div class="row">
            <div class="col-11">
            {!! $usedAt ?? '' !!}
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-11">
            {!! $usedById ?? '' !!}
            </div>
        </div> -->
        <div class="row">
            <div class="col-11">
            {!! $usedByObject ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-11">
            {!! $isActive ?? '' !!}
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
    
    <b-tab title="Voucher">
    <div class="row">
        <div class="col-4">
        {!! $voucherCode ?? '' !!}
        </div>
        <div class="col-4">
        {!! $voucherCurrency ?? '' !!}
        </div>
        <div class="col-4">
        {!! $voucherValue ?? '' !!}
        </div>
    </div>
    </b-tab>

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
    </b-tab>
</b-tabs> -->

