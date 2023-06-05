<diagnosa-input-table
        label="{{ $label }}"
        :items="{{ $form['model'] }}"
        :object-default="{!!  $form['model'].'ObjDef' ?? '' !!}"
        :cols="{{ $form['model'].'Fields' }}"
        :template="{{ $form['model'].'Template' }}"
        :content="{{ $form['model'].'Content' }}"
        :params="{{ $form['model'].'Params' }}"
        @if( isset($form['default_mata']) && $form['default_mata'] == true )
            :default-mata="{{ $form['default_mata']  }}"
        @endif
        @if( isset($form['hide_add_button']) && $form['hide_add_button'] == true )
            hide-add-button
        @endif
        @if( isset($form['hide_edit_button']) && $form['hide_edit_button'] == true )
            hide-edit-button
        @endif
>
</diagnosa-input-table>
