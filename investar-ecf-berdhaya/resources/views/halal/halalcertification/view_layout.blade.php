

<div class="row pb-3" style="margin-left:0px;">
    <div class="col-7">
        <h5 style="color:#000000; font-size: 17px;"><b>Detail Usaha</b></h5>
        <div class="row">
            <div class="col-4 pt-4" >
            {!! $registrationNo ?? '' !!}
            </div>
            <div class="col-4 pt-4" >
            {!! $productName ?? '' !!}
            </div>
            <div class="col-3 pt-4" >
            {!! $registrationDate ?? '' !!}
            </div>
            <div class="col-4 pt-4">
            {!! $productClassification ?? '' !!}
            </div>
            <div class="col-5 pt-4">
            {!! $supervisorRefObject ?? '' !!}
            </div>
            <div class="col-2 pt-4">
            {!! $certificationStatus ?? '' !!}
            </div>
            <div class="col-6 pt-4">
            {!! $validatorInstitution ?? '' !!}
            </div>
            <div class="col-5 pt-4">
            {!! $validatorName ?? '' !!}
            </div>
        </div>
    </div>
    <div style="border-left: thin solid #000000;"></div>
    <div class="col-4 pl-5">
        <h5 style="color:#000000; font-size: 17px;"><b>Profil Usaha </b></h5>
        <div class="row">
            <div class="col-10 pt-4">
            {!! $businessRef ?? '' !!}
            </div>
            <div class="col-10 pt-4">
            {!! $tradeMark ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-12 pt-2">
            {!! $marketArea ?? '' !!}
            </div>
        </div>
            
    </div>
</div>
<div class="form-row" style="height:5px; border-bottom: thin solid #000000;border-top: thin solid #000000;">
</div> 

<b-tabs content-class="mt-3 tabHeader mb-4" nav-class="tab-header" fill justified>
    <b-tab title="Bill of Material" active>
    {!! $bom ?? '' !!}
</b-tab>

</b-tabs>
