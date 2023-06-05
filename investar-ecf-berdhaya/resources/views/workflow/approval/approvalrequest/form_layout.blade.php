<div class="row">
    <div class="col-4">
        {!! $docDescription ?? '' !!}
        {!! $requesterName ?? '' !!}
        {!! $requesterId ?? '' !!}
        {!! $requestNote ?? '' !!}
        {!! $authorizationSign ?? '' !!}
        {!! $requestApprovers ?? '' !!}
    </div>
    <div class="col-4">
        {!! $approverDecision ?? '' !!}
        {!! $approverNote ?? '' !!}
        {!! $approverPin ?? '' !!}
        {!! $signatureInput ?? '' !!}
    </div>
    <div class="col-4">
        {!! $approverSignature ?? '' !!}
        {!! $approverDecisionList ?? '' !!}
    </div>
</div>
