<?php
$is_inline = isset($form['inline']) && $form['inline'] == true ? true : false;
$has_prepend = isset($form['prepend']) && $form['prepend'] == true ? true : false;
$has_append = isset($form['append']) && $form['append'] == true ? true : false;
?>
@if( $is_inline )
    <div class="form-row mt-2">
@endif
        @if($label != '')
            <label for="{{ $form['model'] }}" class="{{ $form['label_class'] ?? '' }}" >{{ __($label) }}</label>
        @endif
        @if($has_prepend || $has_append)
            <div class="input-group">
        @endif
            @if($has_prepend)
                <div class="input-group-prepend">
                    <span class="input-group-text" >{!!  $form['prepend'] !!}</span>
                </div>
            @endif
            @if( $form['type'] == 'currency' || $form['type'] == 'nominal' )
                <p class="form-control underlined"
                   style="word-break: break-word;min-height:35px; height:fit-content !important;border-bottom-color: lightgrey !important;"
                   v-html="formatCurrency({{ $form['model'] }})" >
                </p>
            @else
                <p class="form-control underlined"
                   style="word-break: break-word;min-height:35px; height:fit-content !important; border-bottom-color: lightgrey !important;"
                   v-html="{{ $form['model'] }} ?? '&nbsp;'" >
                </p>
            @endif
            @if($has_append)
                <div class="input-group-append">
                    <span class="input-group-text" >{!! $form['append'] !!}</span>
                </div>
            @endif
        @if($has_prepend || $has_append)
            </div>
        @endif
@if( $is_inline )
    </div>
@endif

