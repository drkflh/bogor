<?php $model = '{{'.$form['model'].'}}' ?>
<a class="card block block-link-shadow text-center" href="{{ url( $form['url'] ) }}">
    <div class="card-body block-content ribbon ribbon-bookmark ribbon-{{ $form['infotype']  }} ribbon-left">
        <p class="font-w600">{{ $label }}</p>
        <{{ $form['charttype'] }} :data="{{ $form['model'] }}"></{{ $form['charttype'] }}>
    </div>
</a>
