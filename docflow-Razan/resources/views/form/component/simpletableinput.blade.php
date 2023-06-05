<simple-table-input
        label="{{ $label }}"
        :items="{{ $form['model'] }}"
        :cols="{{ $form['model'].'Fields' }}"
        @if( isset($form['ordered']) && $form['ordered'] == true )
            ordered
        @endif
>
</simple-table-input>
