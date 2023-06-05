<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<local-select
        id="{{ $form['model'] }}"
        v-model="{{ $form['model'] }}"
        :options="{{ $form['model'].'Options'}}"
        @input="onLocalSelect"
></local-select>
<br>
