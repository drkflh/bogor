<div>
    <div class="row">
        <div class="col-6">
            {!! $farmId ?? '' !!}
        </div>
        <div class="col-6">
            {!! $officerId ?? '' !!}
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            {!! $mobile ?? '' !!}
        </div>
        <div class="col-6">
            {!! $priority ?? '' !!}
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            {!! $dayOfWeek ?? '' !!}
        </div>
        <div class="col-6">
            <div class="row">
                <div class="col-6">
                    {!! $hour ?? '' !!}
                </div>
                <div class="col-6">
                    {!! $minutes ?? '' !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            {!! $channel ?? '' !!}
        </div>
        <div class="col-6">
            {!! $topic ?? '' !!}
        </div>
    </div>
    {!! $messageType ?? '' !!}
</div>
