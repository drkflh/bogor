<div>
    <div class="row">
        <div class="col-md-4 col-sm-12">
            {!! $cycleGroup ?? '' !!}
        </div>
        <div class="col-md-7 col-sm-12">
            {!! $cycleName ?? '' !!}
        </div>
        <div class="col-md-1 col-sm-12">
            {!! $seq ?? '' !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-12">
            {!! $cyclePeriod ?? '' !!}
        </div>
        <div class="col-md-4 col-sm-12">
            {!! $continueTo ?? '' !!}
        </div>
        <div class="col-md-4 col-sm-12">
            {!! $breakTo ?? '' !!}
        </div>
    </div>
    <h6>Whatsapp Notification</h6>
    <hr>
    <div class="row">
        <div class="col-md-3 col-sm-12">
            {!! $cycleStartWA ?? '' !!}
        </div>
        <div class="col-md-3 col-sm-12">
            {!! $cycleStartWAAt ?? '' !!}
        </div>
        <div class="col-md-6 col-sm-12">
            <p class="small">WA to send at start of normal cycle. Must be positive value ( incl. 0 ), and will send the message n days after start of cycle.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-12">
            {!! $cycleBreakWA ?? '' !!}
        </div>
        <div class="col-md-3 col-sm-12">
            {!! $cycleBreakWAAt ?? '' !!}
        </div>
        <div class="col-md-6 col-sm-12">
            <p class="small">WA to send if cycle is branching / break on certain condition. Must be positive value ( incl. 0 ), and will send the message n days after break of cycle.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-12">
            {!! $cycleEndWA ?? '' !!}
        </div>
        <div class="col-md-3 col-sm-12">
            {!! $cycleEndWAAt ?? '' !!}
        </div>
        <div class="col-md-6 col-sm-12">
            <p class="small">WA to send at end of normal cycle. Negative value will send the message before end of cycle.</p>
        </div>
    </div>
{{--    <div class="row">--}}
{{--        <div class="col-md-3 col-sm-12">--}}
{{--            {!! $inParams ?? '' !!}--}}
{{--        </div>--}}
{{--        <div class="col-md-6 col-sm-12">--}}
{{--            {!! $expression ?? '' !!}--}}
{{--        </div>--}}
{{--        <div class="col-md-3 col-sm-12">--}}
{{--            {!! $outParams ?? '' !!}--}}
{{--        </div>--}}
{{--    </div>--}}
    {!! $description ?? '' !!}
</div>
