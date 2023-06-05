<div>
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-12">
            <div class="row">
                <div class="col-10">
                    {!! $title ?? '' !!}
                </div>
                <div class="col-1">
                    {!! $isActive ?? '' !!}
                </div>
            </div>
            {!! $slug ?? '' !!}
            {!! $description ?? '' !!}
            <hr>
            {!! $paramList ?? '' !!}
        </div>
        <div class="col-lg-7 col-lg-7 col-sm-12">
            {!! $body ?? '' !!}
        </div>
    </div>
</div>
