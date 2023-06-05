@if (\Session::has('error'))
    <div class="alert alert-danger">
        <ul>
            <li>{!! Session::get('error') !!}</li>
        </ul>
    </div>
@endif
        <div class="row" style="margin-left:3px;">
            <div class="col-12" style="margin-bottom:5px; ">
                {!! $isComplete !!}
                <div class="row">
                    <div class="col-6">
                        {!! $name ?? '' !!}
                    </div>
                    <div class="col-6">
                        {!! $contactWA ?? '' !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        {!! $position ?? '' !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        {!! $ownerIdCard ?? '' !!}
                    </div>
                    <div class="col-6">
                        {!! $directorIdCard ?? '' !!}
                    </div>
                </div>
                
                <!-- <br><div class="form-row pb-3" style="border-bottom: thin solid #000000;"> -->
                <!-- </div> -->
                <!-- <h5 style="color:#000000; font-size: 17px;"><b>Legalitas Perusahaan: </b></h5>
                {!! $bizTradeMark ?? '' !!}
                {!! $bizAddress ?? '' !!}
                {!! $bizType ?? '' !!}
                {!! $bizRegisteredName ?? '' !!}
                {!! $bizCompanyType ?? '' !!}
                {!! $legality ?? '' !!}
                {!! $attAktaPerusahaan ?? '' !!}
                {!! $attSKKemenhumham ?? '' !!}
                {!! $attTDP ?? '' !!}
                {!! $noNPWP ?? '' !!}
                {!! $attNPWP ?? '' !!}
                {!! $slikOJK ?? '' !!} -->

                <!-- <div class="row">
                    <div class="col-12">
                        {!! $bizRegisteredName ?? '' !!}
                    </div>
                    <div class="col-12">
                        {!! $bizCompanyType ?? '' !!}
                    </div>
                    <div class="col-12">
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
                        {!! $lamDokumen ?? '' !!}
                    </div>
                </div> -->

            </div>
        </div>
{{--        <div class="form-row pb-3" style="border-bottom: thin solid #000000;">--}}
{{--        </div>--}}

{{--    <b-tabs content-class="mt-3 tabHeader mb-4" nav-class="tab-header" fill justified>--}}
{{--        <b-tab title="Factory" active>--}}
{{--            {!! $pabrik ?? '' !!}--}}
{{--        </b-tab>--}}
{{--        <b-tab title="Outlet" >--}}
{{--            {!! $outlet ?? '' !!}--}}
{{--        </b-tab>--}}
{{--        <b-tab title="Legalitas" >--}}
{{--            {!! $pu_aspek_legal ?? '' !!}--}}
{{--        </b-tab>--}}

{{--        <b-tab title="Penyelia">--}}
{{--            {!! $penyelia ?? '' !!}--}}
{{--        </b-tab>--}}
{{--    </b-tabs>--}}



