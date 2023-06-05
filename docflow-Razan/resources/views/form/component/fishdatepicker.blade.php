<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<fish-date-picker
        v-model="{{ $form['model'] }}"
        mode="day"
        format="{{ env('DATE_PICKER_FORMAT', 'dd/MM/yyyy' ) }}"
        hint="{{ env('DATE_FORMAT', 'DD/MM/YYYY' ) }}">
</fish-date-picker>
<br>
