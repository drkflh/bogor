<div class="container">
    <div class="row">
        <div class="col-md-7">
            {!! $vendorCode ?? '' !!}
            {!! $productCode ?? '' !!}
            {!! $productName ?? '' !!}
            {!! $category ?? '' !!}
            {!! $description ?? '' !!}
        </div>
        <div class="col-md-5">
        <div class="row">
            <div class="col-sm-7">
                {!! $price ?? '' !!}
            </div>
            <div class="col-sm-5">
                {!! $unit ?? '' !!}
            </div>
        </div>
            {!! $picture ?? '' !!}
        </div>
    </div>
</div>

