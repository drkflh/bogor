@if(isset($label) && $label != '')
    <label for="{{ $form['model'] }}" class="view-label" >{{ __($label) }}</label>
@endif
<p class="form-control underlined"
   style="word-break: break-word;min-height:35px; height:fit-content !important;border-bottom-color: lightgrey !important;"
   v-html="formatDate( '{{ $form['model'] }}' )" >
</p>
