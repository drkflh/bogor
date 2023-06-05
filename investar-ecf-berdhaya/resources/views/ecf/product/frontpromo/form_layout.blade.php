<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            {!! $name ?? '' !!}
            {!! $slug ?? '' !!}
            {!! $link ?? '' !!}
            {!! $description ?? '' !!}
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="row">
                <div class="col-12">
                    {!! $period ?? '' !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    {!! $promoCode ?? '' !!}
                </div>
            </div>
            {!! $picture ?? '' !!}
        </div>
    </div>
</div>