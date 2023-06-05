<simple-list-input
        label="{{ $label }}"
        :items="{{ $form['model'] }}"
        :cols="{{ $form['model'].'Fields' }}"
        :params="{{ $form['model'].'Params' }}"
        @if( isset($form['ordered']) && $form['ordered'] == true )
            ordered
        @endif
>
</simple-list-input>
