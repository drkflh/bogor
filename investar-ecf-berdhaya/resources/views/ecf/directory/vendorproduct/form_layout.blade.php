<div class="container">
    <div class="row">
        <div class="col-md-6">
            {!! $vendorCode ?? '' !!}
            {!! $productCode ?? '' !!}
            {!! $productName ?? '' !!}
            {!! $category ?? '' !!}
            {!! $description ?? '' !!}
        </div>
        <div class="col-md-6">
        <div class="row">
            <div class="col-sm-9">
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

