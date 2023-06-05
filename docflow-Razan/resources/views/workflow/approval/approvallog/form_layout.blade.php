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

{!! $requestEntity ?? '' !!}
{!! $requestEntityURI ?? '' !!}
{!! $requesterId ?? '' !!}
{!! $requesterName ?? '' !!}
{!! $requesterSignature ?? '' !!}
{!! $requestNote ?? '' !!}
{!! $requestApprovers ?? '' !!}
{!! $approvalPolicy ?? '' !!}
{!! $actionURI ?? '' !!}
{!! $approvalStatus ?? '' !!}
{!! $approvalStatusNote ?? '' !!}

