<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            {!! $productCode ?? '' !!}
            {!! $productName ?? '' !!}
            {!! $category ?? '' !!}
            {!! $description ?? '' !!}
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="row">
                <div class="col-7">
                    {!! $price ?? '' !!}
                </div>
                <div class="col-3">
                    {!! $unitCount ?? '' !!}
                </div>
                <div class="col-2">
                    {!! $unit ?? '' !!}
                </div>
            </div>
            {!! $picture ?? '' !!}
        </div>
    </div>
</div>

