<div class="container withCustomInput">
    <div class="row">
        <div class="col-4">
            <div class="row">
                <div class="col-6">
                    {!! $messageId ?? '' !!}
                    {!! $from ?? '' !!}
                    {!! $cc ?? '' !!}
                </div>
                <div class="col-6">
                    {!! $action ?? '' !!}
                    {!! $to ?? '' !!}
                    {!! $bcc ?? '' !!}
                </div>
            </div>
        </div>
        <div class="col-8">
            {!! $subject ?? '' !!}
            <div class="row">
                <div class="col-4">
                    {!! $status ?? '' !!}
                </div>
                <div class="col-4">
                    {!! $attachments ?? '' !!}
                </div>
                <div class="col-4">
                    {!! $timestamp ?? '' !!}
                </div>
            </div>
        </div>
    </div>
</div>