<div class="container">
    <div class="row">
        <div class="col-md-7">
            {!! $productCode ?? '' !!}
            {!! $productName ?? '' !!}
            {!! $category ?? '' !!}
            {!! $description ?? '' !!}
        </div>
        <div class="col-md-5">
        <div class="row">
            <div class="col-sm-3">
                {!! $currency ?? '' !!}
            </div>
            <div class="col-sm-5">
                {!! $price ?? '' !!}
            </div>
            <div class="col-sm-3">
                {!! $unit ?? '' !!}
            </div>
        </div>
            {!! $picture ?? '' !!}
        </div>
    </div>
</div>

