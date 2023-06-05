<?php
$position = $form['position'] ?? false;
$has_label = $label != '' && $position != 'hidden' ? true:false;
?>

@if(env('SKIP_VALIDATION', true ))
    <validation-provider rules="{{ $form['validator'] ?? '' }}" v-slot="{ errors }" name="{{ $label }}">
@else
    <span>
@endif

        @if($has_label && $position == 'top')
            <label for="{{ $form['model'] }}" >{{ $label }}</label>
        @endif
        <b-form-checkbox v-model="{{ $form['model'] }}" name="check-button" switch size="lg" style="margin-top:-10px;">
            {{ $position == 'left' || $position == 'right' ? __($label) : '' }}
        </b-form-checkbox>

@if(env('SKIP_VALIDATION', true ))
        <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
    </validation-provider>
@else
    </span>
@endif
