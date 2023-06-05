<div class="container">
<div class="row pb-3">
        <div class="col-12">
            <p style="color:#000000; font-size: 15px;margin-bottom:3px;"><b><u>Data KYC Pemodal</u></b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Nama </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'name') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Email</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'email') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Nomor WhatsApp </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'mobileString') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Bank Yang Digunakan </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'bankName') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>No. Rekening </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'bankNo') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Pemilik No. Rekening </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'bankNoOwner') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Tempat Lahir </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'placeOfBirth') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Tanggal Lahir </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'dateOfBirth') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Gender </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'gender') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>No. @{{ _.get(content, 'idType') }}</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'idNumber') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p style="color:#000000; font-size: 13px;"><b>Foto KTP :</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <img :src="_.get(content, 'idPic' ?? ' ')" onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/blank.png' ) ) }}';"></img>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p style="color:#000000; font-size: 13px;"><b>Foto Selfie KTP: </b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <img :src="_.get(content, 'idCardSelfie' ?? ' ')" onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/blank.png' ) ) }}';"></img>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p style="color:#000000; font-size: 13px;"><b>Foto KK: </b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <img :src="_.get(content, 'kkPicture' ?? ' ')" onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/blank.png' ) ) }}';"></img>
        </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Kabupaten/Kota </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'kabupaten') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Provinsi </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'province') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Kewarganegaraan </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'citizenship') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Pekerjaan </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'currentJob') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Deskripsi Pekerjaan </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'currentJobDesc') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Mother Name </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'motherName') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Nama Ahli Waris </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'heirName') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Hubungan Ahli Waris </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'heirRelation') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Sumber Penghasilan </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'incomeSource') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Deskripsi Sumber Penghasilan </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'incomeSourceDesc') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Budget Investasi </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'investmentBudget') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Tujuan Investasi </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'investmentGoal') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Resiko </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'risk') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Preferensi Investasi </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'investmentPreference') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Tipe Investor </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'investorType') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Tau Investar Dari </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'getToKnowInvestar') }}</b></p>
        </div>
    </div>
    <!-- <div class="row pb-3">
        <div class="col-12">
            <p style="color:#000000; font-size: 15px;margin-bottom:3px;"><b><u>Approval</u></b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Total Request </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>Rp.&nbsp;@{{ formatCurrency(_.get(content, 'requiredFunding')) }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Jenis Pendanaan </b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'typeOfFunding') }}</b></p>
        </div>
    </div> -->
            <!-- <img src="@{{ _.get(content, 'bizPlanTriennial') }}"/> -->

    {{-- <hr> --}}

    <!-- <div class="row pt-3 pb-3">
        <div class="col-12">
            <p style="color:#000000; font-size: 15px;margin-bottom:3px;"><b><u>Other</u></b></p>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Merek Dagang :</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'bizTradeMark') }} </b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Nama Badan Usaha :</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'bizRegisteredName') }} </b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>No. WA :</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'contactWA') }} </b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Penanggung Jawab :</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'name') }} </b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Jabatan PJ :</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'bizPicPosition') }} </b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Email PJ:</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'bizPicEmail') }} </b></p>
        </div>
    </div>


    {{-- <div class="row pt-3">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Request By :</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'requestBy') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Audited By :</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'auditedBy') }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p style="color:#000000; font-size: 13px;"><b>Authorize By :</b></p>
        </div>
        <div class="col-8">
            <p style="color:#000000; font-size: 13px;"><b>@{{ _.get(content, 'authorizedBy') }}</b></p>
        </div>
    </div> --}} -->

</div>
