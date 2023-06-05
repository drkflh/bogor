<div>
    <div class="row">
        <div class="col-12">
            {!! $farmId ?? '' !!}
            <div class="row">
                <div class="col-md-10 col-sm-12">
                    {!! $farmName ?? '' !!}
                </div>
                <div class="col-md-1 col-sm-12">
                    {!! $isActive ?? '' !!}
                </div>
            </div>
            {!! $address ?? '' !!}
            {!! $kelurahan ?? '' !!}
            {!! $kecamatan ?? '' !!}
            {!! $zip ?? '' !!}
            {!! $kabupaten ?? '' !!}
            {!! $province ?? '' !!}
{{--            <h6>Location</h6>--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-6 col-sm-12">--}}
{{--                    {!! $lat ?? '' !!}--}}
{{--                </div>--}}
{{--                <div class="col-md-6 col-sm-12">--}}
{{--                    {!! $lng ?? '' !!}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <h6>Geofence</h6>--}}
{{--            {!! $geoFence ?? '' !!}--}}
        </div>
{{--        <div class="col-8">--}}
{{--            {!! $geoFenceMap ?? '' !!}--}}
{{--        </div>--}}
    </div>
</div>
