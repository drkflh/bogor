<div class="row">
    <div class="col-3" style="border-right: thin solid darkgrey;">
        {!! $name !!}
        {!! $key !!}
        <div class="row">
            <div class="col-6">
                {!! $validFrom !!}
            </div>
            <div class="col-6">
                {!! $validUntil !!}
            </div>
        </div>
        {!! $tags !!}
    </div>
    <div class="col-3" style="border-right: thin solid darkgrey;">
        {!! $formModel !!}
        {!! $formObjectDefault !!}
        {!! $formParam !!}
    </div>
    <div class="col-6">
        {{ $formContent }}
        {{ $formPreview }}
    </div>
</div>
