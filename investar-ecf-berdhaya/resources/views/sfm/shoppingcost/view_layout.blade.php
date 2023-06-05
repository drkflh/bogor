<div class="container">
    <div class="row">
        <div class="col-12">
        {!! $name ?? '' !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            {!! $cost ?? '' !!}
            {!! $weightCostUnit ?? '' !!}
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="row">
                <div class="col-6">
                    {!! $origin ?? '' !!}
                </div>
                <div class="col-6">
                    {!! $destination ?? '' !!}
                </div>
            </div>
                <div class="row">
                    <div class="col-6">
                        {!! $minWeight ?? '' !!}
                    </div>
                    <div class="col-6">
                        {!! $maxWeight ?? '' !!}
                    </div>
                </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
        {!! $description ?? '' !!}
        </div>
    </div>
</div>