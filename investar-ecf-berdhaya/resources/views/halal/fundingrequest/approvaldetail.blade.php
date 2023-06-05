<div class="container">
    <div class="row pb-3">
        <div class="col-12">
            <p style="color:#000000; font-size: 15px;margin-bottom:3px;"><b><u>Funding Info</u></b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Total Request :</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>Rp.&nbsp;@{{ formatCurrency(_.get( content , 'requiredFunding' )) }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Jenis Pendanaan :</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get( content , 'typeOfFunding' ) }}</b></p>
        </div>
    </div>
 
{{-- <hr> --}}

    <div class="row pt-3 pb-3">
        <div class="col-12">
            <p style="color:#000000; font-size: 15px;margin-bottom:3px;"><b><u>Other</u></b></p>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Merek Dagang :</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get( content , 'bizTradeMark' )}} </b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Nama Badan Usaha :</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get( content , 'bizRegisteredName' )}} </b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>No. WA :</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get( content , 'contactWA' )}} </b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Penanggung Jawab :</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get( content , 'bizPicName' )}} </b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Jabatan PJ :</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get( content , 'bizPicPosition' )}} </b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Email PJ:</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get( content , 'bizPicEmail' )}} </b></p>
        </div>
    </div>


    {{-- <div class="row pt-3">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Request By :</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get( content , 'requestBy' ) }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Audited By :</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get( content , 'auditedBy' ) }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Authorize By :</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get( content , 'authorizedBy' ) }}</b></p>
        </div>
    </div> --}}

</div>