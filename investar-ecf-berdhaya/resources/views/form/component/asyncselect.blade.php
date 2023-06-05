<async-select
    id="{{ $form['model'] }}"
    name="{{ $form['model'] }}"
    refs="{{ $form['model'] }}"
    v-model="{{ $form['model'] }}"
    label="{{ $label }}"
    search-var="{{ $form['options']['params'] }}"
    search-url="{{ $form['options']['url'] }}"
    :autocomplete="'off'"
    :disabled="false"
    :placeholder="'Search'"
    value-field="{{ $form['options']['valuefield'] }}"
    label-field="{{ $form['options']['labelfield'] }}"
    model-field="{{ $form['options']['modelfield'] }}"
    selected-type="{{ $form['options']['selected'] }}"
    multiple="{{ $form['options']['multiple'] }}"
    @selected="onSelected">
</async-select>