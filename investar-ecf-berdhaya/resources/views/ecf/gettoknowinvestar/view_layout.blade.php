{{-- <div>

<div class="row">
    <div class="col-12">
        {!! $name ?? '' !!}
    </div>
</div>
{!! $description ?? '' !!}
<div class="row">
    <div class="col-12">
        {!! $seq ?? '' !!}
    </div>
</div>
</div> --}}

<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    {!! $name ?? '' !!}
                    {!! $description ?? '' !!}
                    {!! $seq ?? '' !!}
                </div>
            </div>
        </div>
    </div>
</div>