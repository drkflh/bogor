@if($label && $label != '')
<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
@endif
<pre
    v-html="{{ $form['model'] }}"
    style="display: block; padding:6px; overflow-scrolling: auto;"
></pre>
