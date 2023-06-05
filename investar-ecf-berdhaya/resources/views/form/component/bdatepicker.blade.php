@if($label != '')
<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
@endif
<b-form-datepicker
    v-model="{{ $form['model'] }}"
    format="{{ env('DATE_FORMAT', 'DD-MMM-YYYY' ) }}"
    placeholder="{{ env('DATE_FORMAT', 'DD-MMM-YYYY' ) }}"
    locale="id"
>
</b-form-datepicker>
<br>
