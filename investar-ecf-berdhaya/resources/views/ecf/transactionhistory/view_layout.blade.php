{{--

{!! $masterId ?? '' !!}
{!! $masterName ?? '' !!}
{!! $companyId ?? '' !!}
{!! $companyName ?? '' !!}
{!! $sbuId ?? '' !!}
{!! $sbuName ?? '' !!}
{!! $deptId ?? '' !!}
{!! $deptName ?? '' !!} --}}
<div class="form-row" style="border-bottom: thin solid #000000;">
</div>
<div class="form-row">
    <div style="background-color:#fff199;height:100px;width:200px; margin-right:2px; border-right: thin solid #000000;">
        <center>
            <h1>SC</h1>
        </center>
    </div>
    <div style="padding-left:10px;padding-right: 15px;width:120px;">
        <div style="margin-top:5px;">{!! $productCode ?? '' !!}</div>
    </div>
    <div style="padding-right: 15px;width: 200px;">
        <div style="margin-top:5px;">{!! $productName ?? '' !!}</div>
    </div>
    <div style="width: 200px;padding-right:15px;margin-top:5px;">
        {!! $vendorCode ?? '' !!}
    </div>
    <div class="" style="width: 300px;padding-right:10px;margin-top:5px;">
        {!! $price ?? '' !!}
    </div>
    <div class="" style="width: 100px;padding-right:15px;margin-top:5px;">
        {!! $orderStatus ?? '' !!}
    </div>
</div>
<div class="form-row" style="height:5px; border-bottom: thin solid #000000;border-top: thin solid #000000;">
</div>

{{-- end header --}}

{{-- body --}}
<div class="row" style="margin-left:3px;">
    <div class="col-6" style="margin-bottom:5px; ">
        <h5 style="color:#000000; font-size: 17px;"><b>Information</b></h5>
        <div class="row">
            <div class="col-md-7 col-sm-3 ">
                {!! $userName ?? '' !!}
            </div>
            <div class="col-md-4 col-sm-2">
                {!! $userId ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 col-sm-3">
                {!! $userLocation ?? '' !!}
            </div>
            <div class="col-md-4 col-sm-2">
                {!! $orderTimestamp ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 col-sm-3">
                {!! $description ?? '' !!}
            </div>
            <div class="col-md-4 col-sm-2">
                {!! $category ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-11">
                {!! $picture ?? '' !!}
            </div>
        </div>

    </div>
    <div class="col-5" style="border-left: thin solid #000000;">
        <h5 class="pl" style="color:#000000; font-size:17px;"><b>Unit</b></h5>
        <div class="row pl-3">
            <div class="col-md-7 col-sm-3">
                {!! $unitCount ?? '' !!}
            </div>
            <div class="col-md-3 col-sm-2">
                {!! $unit ?? '' !!}
            </div>
            <div class="col-md-2 col-sm-2">
                {!! $orderQty ?? '' !!}
            </div>
        </div>
        <h5 class="pl pt-5" style="color:#000000; font-size:17px;"><b>Note</b></h5>
        <div class="row pl-3 pt-3">
            <div class="col-md-12">
                {!! $specifications ?? '' !!}
            </div>
            <div class="col-md-12">
                {!! $orderNote ?? '' !!}
            </div>
            <div class="col-md-12">
            {!! $cartSession ?? '' !!}
            </div>
        </div>
    </div>
</div>

<div class="form-row pb-3" style="border-bottom: thin solid #000000;">
</div>
