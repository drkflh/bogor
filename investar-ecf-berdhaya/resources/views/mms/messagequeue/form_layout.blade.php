<div class="container withCustomInput">
    <div class="row">
        <div class="col-4">
            <div class="row">
                <div class="col-6">
                    {!! $gatewayType ?? '' !!}
                    {!! $from ?? '' !!}
                    {!! $cc ?? '' !!}
                    {!! $lastAction ?? '' !!}
                </div>
                <div class="col-6">
                    {!! $gatewaySlug ?? '' !!}
                    {!! $to ?? '' !!}
                    {!! $bcc ?? '' !!}
                    {!! $lastActionTs ?? '' !!}
                </div>
            </div>
        </div>
        <div class="col-8">
            {!! $subject ?? '' !!}
            {!! $body ?? '' !!}
            <div class="row">
                <div class="col-4">
                    {!! $status ?? '' !!}
                </div>
                <div class="col-4">
                    {!! $attachments ?? '' !!}
                </div>
                <div class="col-4"></div>
            </div>
        </div>
    </div>
</div>