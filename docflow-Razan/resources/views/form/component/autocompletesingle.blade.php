<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<multiselect
        v-model="{{ $form['model'] }}"
        :options= {{ json_encode($form['options']) }}
></multiselect>
