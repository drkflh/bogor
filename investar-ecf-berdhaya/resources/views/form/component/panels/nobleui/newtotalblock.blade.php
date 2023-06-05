<?php
$model = '{{'.$form['model'].'}}';
$deltaModel = '{{'.$form['delta'].'}}';
$verifiedModel = '{{'.$form['verified'].'}}';
?>
<div class="card">
    <div class="card-body" style="{{ $form['style'] ?? 'backgroundcolor: #4bd41e;' }}">
        <div class="d-flex justify-content-between align-items-baseline">
            <h6 class="card-title mb-0">{{ $label }}</h6>
        </div>
        <div class="row">
            <div class="col-8">
                <h1 class="mb-3">{{ $model }}</h1>
            </div>
            <div class="col-4">
                <h2>{{ $verifiedModel }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                @if( isset($form['delta']) )
                <div class="d-flex align-items-baseline">
                    <p class="text-success">
                        <span>{{ $deltaModel }}</span>
                        <i class="icon-sm mb-1 las" :class="{{ $form['delta'] }} > 0 ? 'la-arrow-up' : 'la-arrow-down'" ></i>
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>


