<div class="container withCustomInput">
    <div class="row">
        <div class="col-5">
            <div class="row">
                <div class="col-6">
                    {!! $assetId ?? '' !!}
                    {!! $publishFrom ?? '' !!}
                    {!! $publishStatus ?? '' !!}
                </div>
                <div class="col-6">
                    <div style="margin-top: 32px;">{!! $active ?? '' !!}</div>
                    {!! $publishUntil ?? '' !!}
                    {!! $masterHandle ?? '' !!}
                </div>
            </div>
        </div>
        <div class="col-7">
            {!! $title ?? '' !!}
            {!! $description ?? '' !!}
            <div class="row">
                <div class="col-6">
                    {!! $variants ?? '' !!}
                </div>
                <div class="col-6">
                    {!! $assetGroup ?? '' !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            {!! $constraintProgram ?? '' !!}
            {!! $constraintEntity ?? '' !!}
        </div>
        <div class="col-6">
            {!! $masterImage ?? '' !!}
        </div>
    </div>
</div>