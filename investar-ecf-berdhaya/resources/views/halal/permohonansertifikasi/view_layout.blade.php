
<div class="form-row" style="border-bottom: thin solid #000000;">
</div>
<div class="form-row">
    <div style="background-color:#fff199;height:100px;width:200px; margin-right:2px; border-right: thin solid #000000;">
    <center><h1>PS</h1></center>
    </div>
    <div style="padding-left:20px;padding-right: 15px;width: 230px;">
        <div style="margin-top:5px;"> {!! $businessBizRegisteredName ?? '' !!}</div>
    </div>
    <div style="width: 170px;padding-right:15px;margin-top:5px;">
        {!! $businessBizIdNumber ?? '' !!}
    </div>
    <div style="width: 200px;margin-top:5px;">
        {!! $businessBizTradeMark ?? '' !!}
    </div>
    <div style="width: 200px;margin-left:15px;margin-top:5px;">
        {!! $businessBizType ?? '' !!}
    </div>
    <div style="width: 200px;margin-left:15px;margin-top:5px;">
        {!! $businessBizCompanytType ?? '' !!}
    </div>
</div>
<div class="form-row" style="height:5px; border-bottom: thin solid #000000;border-top: thin solid #000000;">
</div>

<div class="row" style="margin-left:3px;">
    <div class="col-7" style="margin-bottom:5px; ">
        <h5 style="color:#000000; font-size: 17px;"><b>Penanggung Jawab </b></h5>
        <div class="row">
            <div class="col-6">
                {!! $businessExtId ?? '' !!}
            </div>
            <div class="col-6">
                {!! $businessBizPicEmail ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                {!! $businessBizPicName ?? '' !!}
            </div>
            <div class="col-6">
                {!! $businessBizPosition ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                {!! $businessBizContactWA ?? '' !!}
            </div>
            <div class="col-6">
                {!! $businessBizOwnerIdCard ?? '' !!}
            </div>
        </div>
    </div>
    <div class="col-4" style="border-left: thin solid #000000;">
        <h5 style="color:#000000; font-size:17px;"><b>Sosial Media</b></h5>
        <div class="row">
            <div class="col-6">
                {!! $businessBizFacebook ?? '' !!}
            </div>
            <div class="col-5">
                {!! $businessBizInstagram ?? '' !!}
            </div>
            <div class="col-6">
                {!! $businessBizTwitter ?? '' !!}
            </div>
            <div class="col-6">
                {!! $businessBizIdType ?? '' !!}
            </div>
            <div class="col-12">
                {!! $businessBizAddress ?? '' !!}
            </div>
        </div>

    </div>
</div> 
<div class="form-row pb-3" style="border-bottom: thin solid #000000;">
</div>

<b-tabs content-class="mt-3 tabHeader mb-4" nav-class="tab-header" fill justified>
<b-tab title="Factory" active>
    {!! $bizFactories ?? '' !!}
</b-tab>
<b-tab title="Outlet" >
    {!! $bizOutlets ?? '' !!}
</b-tab>
<b-tab title="Aspek Legal" >
    {!! $businessBizLegality ?? '' !!}
</b-tab>

<b-tab title="Penyelia Halal">
    {!! $businessBizPenyelia ?? '' !!}
</b-tab>
</b-tabs>

