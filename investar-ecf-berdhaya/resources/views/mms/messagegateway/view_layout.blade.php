<div class="container withCustomInput">
    <div class="row">
        <div class="col-4">
            {!! $gatewayName ?? '' !!}
            {!! $gatewaySlug ?? '' !!}
            {!! $gatewayType ?? '' !!}
        </div>
        <div class="col-8">
            {!! $isActive ?? '' !!}
            <h6>WA Session ID</h6>
            <div class="row">
                <div class="col-6">
                    {!! $gatewaySessionKey ?? '' !!}
                </div>
                <div class="col-2 pt-4">
                    <button class="btn btn-outline-primary mt-2" @click="getWASession()">
                        <i class="las la-sync"></i>
                    </button>
                </div>
                <div class="col-4">
                    {!! $delExist ?? '' !!}
                </div>
            </div>
            <hr>
            <img :src="waSessionQR"
                 onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_CARD_IMAGE', 'images/blank.png' ) ) }}';"
                 alt="WA Session" style="width: 200px; height: 200px;" />
        </div>
    </div>
</div>
