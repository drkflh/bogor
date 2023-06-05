<div class="container">
    <div class="row">
        <div class="col-4">
            {!! $channelCode !!}
            {!! $channelName !!}
        </div>
        <div class="col-4">
            {!! $active !!}
            <div :class="!active || active == 'no' ? 'formActive' : ''">
                {!! $activeFrom !!}
                {!! $inactiveDate !!}
            </div>
        </div>
    </div>
</div>
