<label for="{{ $form['model'] }}" class="view-label" >{{ __($label) }}</label>
<p class="underlined" style="word-break: break-word;" v-html="formatCurrency({{ $form['model'] }})" ></p>
