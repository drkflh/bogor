<div class="container withCustomInput">
    <div class="row">
        <div class="col-6">
            {!! $requesterName ?? '' !!}
            {!! $requestNote ?? '' !!}
            {!! $requestApprovers ?? '' !!}
        </div>
        <div class="col-6">
            {!! $authorizationSign ?? '' !!}
            {!! $decision ?? '' !!}
            {!! $timestamp ?? '' !!}
        </div>
    </div>
</div>


{!! $requesterSignature ?? '' !!}


{!! $note ?? '' !!}
{!! $commitUrl ?? '' !!}
{!! $entity ?? '' !!}
{!! $doc ?? '' !!}
{!! $docId ?? '' !!}
{!! $tz ?? '' !!}
