

        <div class="form-row" style="border-bottom: thin solid #000000;">
        </div>
        <div class="form-row">
            <div style="background-color:#fff199;height:100px;width:200px; margin-right:2px; border-right: thin solid #000000;">
            <center><h1>BZ</h1></center>
            </div>
            <div style="padding-left:20px;padding-right: 15px;width: 280px;">
                <div style="margin-top:5px;"> {!! $bizRegisteredName ?? '' !!}</div>
            </div>
            <div style="width: 170px;padding-right:15px;margin-top:5px;">
                {!! $bizCompanyType ?? '' !!}
            </div>
            <div style="width: 270px;margin-top:5px;">
                {!! $bizTradeMark ?? '' !!}
            </div>
            <div style="width: 200px;margin-left:15px;margin-top:5px;">
                {!! $bizType ?? '' !!}
            </div>
        </div>
        <div class="form-row" style="height:5px; border-bottom: thin solid #000000;border-top: thin solid #000000;">
        </div>
    
        <div class="row" style="margin-left:3px;">
            <div class="col-6" style="margin-bottom:5px; ">
                <h5 style="color:#000000; font-size: 17px;"><b>Penanggung Jawab </b></h5>
                <div class="row">
                    <div class="col-10">
                        {!! $bizPicName ?? '' !!}
                    </div>
                    <div class="col-10">
                        {!! $bizPicEmail ?? '' !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-5">
                        {!! $bizPicPosition ?? '' !!}
                    </div>
                    <div class="col-5">
                        {!! $contactWA ?? '' !!}
                    </div>
                </div>

            </div>
            <div class="col-5" style="border-left: thin solid #000000;">
                <h5 style="color:#000000; font-size:17px;"><b>Detail & Attachments :</b></h5>
                <div class="row">
                    <div class="col-7">
                        {!! $bizAddress ?? '' !!}
                    </div>
                    <div class="col-5">
                        {!! $bizIdType ?? '' !!}
                    </div>
                    <div class="col-12">
                        {!! $lamDokumen ?? '' !!}
                    </div>
                </div>
           </div>
        </div> 
        <div class="form-row pb-3" style="border-bottom: thin solid #000000;">
        </div>

    <b-tabs content-class="mt-3 tabHeader mb-4" nav-class="tab-header" fill justified>
        <b-tab title="Factory" active>
            {!! $pabrik ?? '' !!}
        </b-tab>
        <b-tab title="Outlet" >
            {!! $outlet ?? '' !!}
        </b-tab>
        <b-tab title="Aspek Legal" >
            {!! $pu_aspek_legal ?? '' !!}
        </b-tab>

        <b-tab title="Penyelia Halal">
            {!! $penyelia ?? '' !!}
        </b-tab>
    </b-tabs>
    


