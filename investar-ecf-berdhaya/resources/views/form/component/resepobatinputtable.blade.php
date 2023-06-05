<resep-obat-input-table
        label="{{ $label }}"
        :items.sync="{{ $form['model'] }}"
        :history-items="{{ $form['model'].'History' }}"
        :object-default="{!!  $form['model'].'ObjDef' ?? '' !!}"
        :cols="{{ $form['model'].'Fields' }}"
        :template="{{ $form['model'].'Template' }}"
        :content="{{ $form['model'].'Content' }}"
        :params="{{ $form['model'].'Params' }}"
        @if( isset($form['hide_add_button']) && $form['hide_add_button'] == true )
            hide-add-button
        @endif
>
</resep-obat-input-table>
