@if(isset($label) && $label != '')
    <label for="{{ $form['model'] }}" class="view-label" >{{ __($label) }}</label>
@endif
<p class="underlined" style="word-break: break-word;" v-html="formatCurrency({{ $form['model'] }}, {{ isset($form['always_negative']) && $form['always_negative'] ? 'true': 'false' }} )" ></p>
