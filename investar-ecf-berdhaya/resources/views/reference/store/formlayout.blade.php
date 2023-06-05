<div class="container">
    <div class="row">
        <div class="col-4">
            {!! $storeCode !!}
            {!! $storeName !!}
            {!! $companyCode !!}
        </div>
        <div class="col-4">
            {!! $phone !!}
            {!! $email !!}
            {!! $locationCode !!}
        </div>
        <div class="col-4">
            {!! $active !!}
            <div :class="!active || active == 'no' ? 'formActive' : ''">
                {!! $activeFrom !!}
                {!! $inactiveDate !!}
            </div>
        </div>
    </div>
</div>
