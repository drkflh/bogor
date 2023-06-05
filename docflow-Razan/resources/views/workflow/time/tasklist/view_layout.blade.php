<div class="row">
    <div class="col-6">
        <div class="row">
            <div class="col-3">
                {!! $projectName ?? '' !!}
            </div>
            <div class="col-6">
                {!! $taskName ?? '' !!}
            </div>
            <div class="col-3">
                {!! $taskType ?? '' !!}
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="row">
            <div class="col-3">
                {!! $startDateTime ?? '' !!}
            </div>
            <div class="col-3">
                {!! $endDateTime ?? '' !!}
            </div>
            <div class="col-3">
                {!! $duration ?? '' !!}
            </div>
            <div class="col-3">
                {!! $progressStatus ?? '' !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-2">
        {{-- {!! $projectId ?? '' !!} --}}
        {!! $assignedTo ?? '' !!}
    </div>
    <div class="col-4">
        {{-- {!! $taskId ?? '' !!} --}}
        {!! $taskDescription ?? '' !!}
    </div>
    <div class="col-4">
        {{-- {!! $taskId ?? '' !!} --}}
        {!! $taskGuide ?? '' !!}
    </div>
    <div class="col-2">
        {{-- {!! $projectId ?? '' !!} --}}
        {!! $taskAttachments ?? '' !!}
    </div>
</div>
