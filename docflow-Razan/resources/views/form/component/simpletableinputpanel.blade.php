<simple-table-input-panel
        label="{{ $label }}"
        :items="{{ $form['model'] }}"
        :cols="{{ $form['model'].'Fields' }}"
        modal-id="{{ \Illuminate\Support\Str::random(5) }}"
>
</simple-table-input-panel>
