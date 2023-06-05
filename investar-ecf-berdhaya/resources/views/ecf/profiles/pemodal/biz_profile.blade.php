<div class="row" style="margin-left:3px;">
            <div class="col-12" style="margin-bottom:5px; ">
                <h5 style="color:#000000; font-size: 17px;"><b>Profil Badan Usaha </b></h5>
                <div class="row">
                    <div class="col-12">
                        {!! $bizRegisteredName ?? '' !!}
                    </div>
                    <div class="col-6">
                        {!! $bizCompanyType ?? '' !!}
                    </div>
                    <div class="col-6">
                        {!! $bizIdType ?? '' !!}
                    </div>
                    <div class="col-12">
                        {!! $bizIdNumber ?? '' !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        {!! $bizTradeMark ?? '' !!}
                    </div>
                    <div class="col-12">
                        {!! $bizType ?? '' !!}
                    </div>
                    <div class="col-12">
                        {!! $bizAddress ?? '' !!}
                    </div>
                    <div class="col-12">
                        {!! $kota_pu ?? '' !!}
                    </div>
                    <div class="col-12">
                        {!! $prov_pu ?? '' !!}
                    </div>
                    <div class="col-12">
                        {!! $id_prov ?? '' !!}
                    </div>
                    <div class="col-12">
                        {!! $kode_pos_pu ?? '' !!}
                    </div>
                    <div class="col-12">
                        {!! $no_telp_pu ?? '' !!}
                    </div>
                    <div class="col-12">
                        {!! $skala_usaha ?? '' !!}
                    </div>
                    <div class="col-12">
                        {!! $email_perusahaan ?? '' !!}
                    </div>
                    <div class="col-12">
                        {!! $modal_dasar ?? '' !!}
                    </div>
                    <div class="col-12">
                        {!! $lamDokumen ?? '' !!}
                    </div>
                </div>
                <br><div class="form-row pb-3" style="border-bottom: thin solid #000000;">
                </div>
                <h5 style="color:#000000; font-size: 17px;"><b>Penanggung Jawab </b></h5>
                <div class="row">
                    <div class="col-12">
                        {!! $bizPicName ?? '' !!}
                    </div>
                    <div class="col-12">
                        {!! $bizPicEmail ?? '' !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        {!! $bizPicPosition ?? '' !!}
                    </div>
                    <div class="col-12">
                        {!! $contactWA ?? '' !!}
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
        <b-tab title="Legalitas" >
            {!! $pu_aspek_legal ?? '' !!}
        </b-tab>

        <b-tab title="Penyelia">
            {!! $penyelia ?? '' !!}
        </b-tab>
    </b-tabs>



