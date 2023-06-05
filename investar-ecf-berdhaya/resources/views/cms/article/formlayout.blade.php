<div class="row">
    <div class="col-3">
        {!! $section ?? '' !!}
        {!! $category ?? '' !!}
        {!! $tags ?? '' !!}
        {!! $status ?? '' !!}
        <div class="row">
            <div class="col-6">
                {!! $validFrom ?? '' !!}
            </div>
            <div class="col-6">
                {!! $validUntil ?? '' !!}
            </div>
        </div>
        {!! $attachments ?? '' !!}
    </div>
    <div class="col-9">
        {!! $title ?? '' !!}
        {!! $slug ?? '' !!}
        {!! $description ?? '' !!}
        {!! $body ?? '' !!}
    </div>
</div>
