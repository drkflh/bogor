<div class="row" style="margin-left:3px;">    
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