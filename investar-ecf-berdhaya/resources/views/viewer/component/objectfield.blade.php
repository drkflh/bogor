@if(isset($label) && $label != '')
    <label for="{{ $form['model'] }}" class="view-label" >{{ __($label) }}</label>
@endif
@if( $form['type'] == 'currency' || $form['type'] == 'nominal' )
    <p class="form-control underlined"
       style="word-break: break-word;min-height:35px; height:fit-content !important;border-bottom-color: lightgrey !important;"
       v-html="formatCurrency( _.get( {{ $form['model'] }}, '{{ $form['field'] }}', 0 ) )" >
    </p>
@else
<p class="form-control underlined"
   style="word-break: break-word;min-height:35px; height:fit-content !important; border-bottom-color: lightgrey !important;"
   v-html=" _.get( {{ $form['model'] }}, '{{ $form['field'] }}', '' ) " >
</p>
@endif

