<?php $model = '{{'.$form['model'].'}}' ?>
<a class="block block-link-shadow text-center" href="{{ url( $form['url'] ) }}">
    <div class="block-content ribbon ribbon-bookmark ribbon-{{ $form['infotype']  }} ribbon-left">
        @if(isset($form['show_ribbon']) && $form['show_ribbon'] == true)
            <div class="ribbon-box">{{ $model }}</div>
        @endif
        <p class="mt-5">
            @if(isset($form['icon']))
                {!! $form['icon'] !!}
            @elseif(isset($form['icon_img']) )
                <img style="{!! $form['icon_img']['style'] !!}" src="{{ url($form['icon_img']['src']) }}" />
            @endif
        </p>
        <p class="font-w600">{{ $label }}</p>
    </div>
</a>
