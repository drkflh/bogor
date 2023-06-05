@if($label != '')
<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
@endif
<date-picker
    v-model="{{ $form['model'] }}"
    format="{{ env('DATE_FORMAT', 'DD-MMM-YYYY' ) }}"
    type="date"
    value-type="date"
    placeholder="{{ env('DATE_FORMAT', 'DD-MMM-YYYY' ) }}"
>
</date-picker>
<br>
