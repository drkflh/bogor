<div class="form-row" style="border-bottom: thin solid #000000;">
</div>
<div class="form-row">
    <div class="d-flex justify-content-center align-items-center" style="background-color:#fff199;height:100px;width:100px; margin-right:2px; border-right: thin solid #000000;">
        <h1>SV</h1>
    </div>
    <div style="padding-left:20px;padding-right: 15px;width: 175px;">
        <div style="margin-top:5px;" class="ellipsis">{!! $voucherCode ?? '' !!}</div>
    </div>
    <div style="width: 75px;padding-right:15px;margin-top:5px;">
        {!! $voucherCurrency ?? '' !!}
    </div>
    <div style="width: 150px;padding-right:15px;margin-top:5px;">
        {!! $voucherValue ?? '' !!}
    </div>
    <div style="width: 150px;padding-right:15px;margin-top:5px;">
        {!! $trxStatus ?? '' !!}
    </div>
    <!-- <div style="width: 75px;padding-right:15px;margin-top:5px;">
        {!! $usedAt ?? '' !!}
    </div> -->
</div>
<div class="form-row" style="height:5px; border-bottom: thin solid #000000;border-top: thin solid #000000;">
</div>
<div class="row" style="margin-left:3px;">
    <div class="col-6" style="border-right: thin solid #000000;border-left: thin solid #000000;">
        <h5 style="color:#000000; font-size:17px;"><b>Sponsorship Program</b></h5>
        <div class="row">
            <div class="col-11">
                {!! $sponsorId ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-11">
                {!! $sponsorName?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-11">
                {!! $programId ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-11">
                {!! $programName ?? '' !!}
            </div>
        </div>
    </div>
    <div class="col-6">
        <h5 style="color:#000000; font-size:17px;"><b>Details</b></h5>
        <div class="row">
            <div class="col-11">
                {!! $productName ?? '' !!}
            </div>
        </div>
    </div>
</div>

