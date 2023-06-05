@if(isset($label) && $label != '')
    <label for="{{ $form['model'] }}" class="view-label" >{{ __($label) }}</label>
@endif
@if( $form['type'] == 'currency' || $form['type'] == 'nominal' )
    <{{ $form['element'] ?? 'h4' }} class="form-control underlined"
       style="word-break: break-word;border-bottom-color: lightgrey !important;"
       v-html="formatCurrency({{ $form['model'] }})" >
    </{{ $form['element'] ?? 'h4' }}>
@else
<{{ $form['element'] ?? 'h4' }} class="form-control underlined"
   style="word-break: break-word;min-height:35px; border-bottom-color: lightgrey !important;"
   v-html="{{ $form['model'] }} ?? '&nbsp;'" >
</{{ $form['element'] ?? 'h4' }}>
@endif

