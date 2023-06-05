<div class="container">
    <div class="row">
        <div class="col-md-7">
            {!! $companyId ?? '' !!}
            {!! $companyName ?? '' !!}
            {!! $productCode ?? '' !!}
            {!! $productName ?? '' !!}
            {!! $category ?? '' !!}
            {!! $description ?? '' !!}
        </div>
        <div class="col-md-5">
        <div class="row">
            <div class="col-sm-5">
                {!! $currency ?? '' !!}
            </div>
            <div class="col-sm-5">
                {!! $price ?? '' !!}
            </div>
            <div class="col-sm-3">
                {!! $unit ?? '' !!}
            </div>
        </div>
            <div class="row">
                    <div class="col-6">
                        {!! $products ?? '' !!}
                    </div>
                    <div class="col-6">
                        {!! $stock ?? '' !!}
                    </div>
                </div>
            {!! $picture ?? '' !!}
        </div>
    </div>
</div>

