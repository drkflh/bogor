@if($label && $label != '')
<label for="{{ $form['model'] }}" style="font-size: 9pt;font-weight: bold;">{{ $label }}</label>
@endif
<div style="display: block font-size: 100pt;" v-html="formatDateTimeUTC({{ $form['model'] }})">
</div>
