<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<date-picker
    v-model="{{ $form['model'] }}"
    :format="dpFormat"
    type="date"
    value-type="date"
    range
    placeholder="Select date range">
</date-picker><br>
