<div class="container withCustomInput">
    <div class="row">
        <div class="col-4">
            {!! $entity ?? '' !!}
            {!! $doc ?? '' !!}
            {!! $approverId ?? '' !!}
            {!! $approverName ?? '' !!}
        </div>
        <div class="col-4">
            {!! $decisionObj ?? '' !!}
            {!! $decision ?? '' !!}
            {!! $note ?? '' !!}
            {!! $timestamp ?? '' !!}
        </div>
        <div class="col-4">
            {!! $authorization ?? '' !!}
            {!! $authorizationSign ?? '' !!}
            {!! $timestamp ?? '' !!}
        </div>
    </div>
</div>
{!! $requesterName ?? '' !!}
{!! $requesterSignature ?? '' !!}
{!! $requestNote ?? '' !!}
{!! $requestApprovers ?? '' !!}

