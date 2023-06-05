<div class="row">
    <div class="col-3">
        {!! $title ?? '' !!}
        {!! $slug ?? '' !!}
        {!! $description ?? '' !!}
        <hr>
        {!! $section ?? '' !!}
        {!! $category ?? '' !!}
        {!! $status ?? '' !!}
        <div class="row">
            <div class="col-6">
                {!! $validFrom ?? '' !!}
            </div>
            <div class="col-6">
                {!! $validUntil ?? '' !!}
            </div>
        </div>
    </div>
    <div class="col-3">
        {!! $treeData ?? '' !!}
    </div>
    <div class="col-6">
        {!! $treeView ?? '' !!}
    </div>
</div>
