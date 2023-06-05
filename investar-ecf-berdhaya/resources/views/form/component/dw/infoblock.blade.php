
<?php $model = '{{'.$form['model'].'}}' ?>

<div class="card card-body">
    <a href="{{ url( $form['url'] ) }}">

        <div class="media mg-b-10">
            <div class="crypto-icon bg-secondary pd-r-8">
                @if(isset($form['icon']))
                    {!! $form['icon'] !!}
                @elseif(isset($form['icon_img']) )
                    <img style="{!! $form['icon_img']['style'] !!}" src="{{ url($form['icon_img']['src']) }}" />
                @endif
            </div><!-- crypto-icon -->
            <div class="media-body pd-l-8">
                <h6 class="tx-11 tx-spacing-1 tx-uppercase tx-semibold mg-b-5">{{ $label }}</h6>
                <div class="d-flex align-items-baseline tx-rubik">
                    <h5 class="tx-20 mg-b-0">{{ $model }}</h5>
                    {{--<p class="mg-b-0 tx-11 tx-danger mg-l-3"><i class="icon ion-md-arrow-down"></i> 0.77%</p>--}}
                </div>
            </div><!-- media-body -->
        </div><!-- media -->
        {{--@if(isset($form['show_ribbon']) && $form['show_ribbon'] == true)--}}
        {{--<div class="ribbon-box">{{ $model }}</div>--}}
        {{--@endif--}}


    </a>
</div>
