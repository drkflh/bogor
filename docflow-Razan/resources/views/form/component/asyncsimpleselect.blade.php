<async-simple-select
    :id="{{ $form['ref'] }}"
    :name="{{ $form['ref'] }}"
    refs="{{ $form['ref'] }}"
    v-model="{{ $form['model'] }}"
    :options="{{ $form['model'].'Options'}}"
    label="{{ $label }}"
    :autocomplete="'off'"
    :disabled="false"
    :placeholder="'Search'"
    selector="{{ $form['selector'] }}"
    @selected="onSelect2">
</async-simple-select>
