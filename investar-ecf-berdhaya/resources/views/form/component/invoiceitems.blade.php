<invoice-items
        label="{{ $label }}"
        modal-id="{{ \Illuminate\Support\Str::random(5) }}"

        :items="{{ $form['model'] }}"
        :object-default="{!!  $form['model'].'ObjDef' ?? '' !!}"
        :cols="{{ $form['model'].'Fields' }}"
        :template="{{ $form['model'].'Template' }}"
        :content="{{ $form['model'].'Content' }}"
        :params="{{ $form['model'].'Params' }}"
        qty-col="{{ $form['qty_col'] }}"
        unit-total-col="{{ $form['unit_total_col'] }}"
        unit-price-col="{{ $form['unit_price_col'] }}"
        @if( isset($form['hide_add_button']) && $form['hide_add_button'] == true )
            hide-add-button
        @endif
        @if( isset($form['show_table_header']) && $form['show_table_header'] == true )
            show-table-header
        @endif
        @if( isset($form['ordered']) && $form['ordered'] == true )
            ordered
        @endif
>
</invoice-items>
