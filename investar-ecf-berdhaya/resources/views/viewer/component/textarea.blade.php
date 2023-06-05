@if( $label != '' )
<label for="{{ $form['model'] }}" class="view-label" >{{ $label }}</label>
@endif
<p class="form-control underlined"
   style="word-break: break-word; min-height:35px; height:fit-content !important;"
   v-html="{{ $form['model'] }}"
></p>
