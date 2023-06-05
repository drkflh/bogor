<div class="container withCustomInput">
    <div class="row">
        <div class="col-5">
            {!! $productCode !!}
            {!! $productName !!}
            {!! $active !!}
            <div class="row">
                <div :class="!active || active == 'no' ? 'formActive' : ''">
                    <div class="col-6">
                    {!! $activeFrom !!}
                    </div>
                    <div class="col-6">
                    {!! $inactiveDate !!}
                    </div>
                </div>
            </div>
            {!! $companyCode !!}
            {!! $brandCode !!}
        </div>
        <div class="col-7">
            <div class="row">
                <div class="col-6">
                    {!! $retailValueBeforeTax !!}
                </div>
                <div class="col-6">
                    {!! $nonTaxable !!}
                </div>
            </div>
            {!! $categoryCode !!}
            {!! $barcodeEAN !!}
            {!! $productImage !!}
            {!! $productPhotos !!}
        </div>
    </div>
</div>
