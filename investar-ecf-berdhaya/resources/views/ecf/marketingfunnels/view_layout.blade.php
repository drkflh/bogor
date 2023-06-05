<div class="card">

    <div class="card-body shadow-lg p-3 bg-body rounded">
        <div class="row p-2">
            <div class="col-md-8 col-sm-12">
                {!! $name ?? '' !!}
            </div>
            <div class="col-md-4 col-sm-12">
                {!! $seq ?? '' !!}
            </div>
        </div>
        
        <div class="row p-3">
            <div class="col-12">
                {!! $description ?? '' !!}
            </div>
        </div>
    </div>
</div>