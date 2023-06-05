<form-question-dialog
    label="{{ $label }}"
    modal-id="{{ \Illuminate\Support\Str::random(5) }}"
    alert-id="{{ \Illuminate\Support\Str::random(5) }}"
    import-dialog-id="{{ \Illuminate\Support\Str::random(5) }}"
    section-dialog-id="{{ \Illuminate\Support\Str::random(5) }}"
    category-dialog-id="{{ \Illuminate\Support\Str::random(5) }}"

    v-bind:items.sync="{{ $form['model'] }}"
    v-bind:sections.sync="{{ $form['sections'] }}"
    v-bind:categories.sync="{{ $form['categories'] }}"

    @if( isset($form['on_item_change']) && $form['on_item_change'] == true )
    @onitemchange="{{ $form['on_item_change'] }}"
    @endif


    :object-default="{!!  $form['model'].'ObjDef' ?? '' !!}"
    :cols="{{ $form['model'].'Fields' }}"
    :template="{{ $form['model'].'Template' }}"
    :content="{{ $form['model'].'Content' }}"
    :params="{{ $form['model'].'Params' }}"

    :item-total.sync="{{ $form['model'].'Total' }}"

    ns="{{ $form['ns'] ?? 'doc' }}"

    modal-size="{{ $form['modal_size'] ?? '' }}"
    modal-entity="{{ $form['modal_entity'] ?? $label }}"
    entity-name-key="{{ $form['entity_name_key'] ?? '_id' }}"

    :preview-columns="{{ $form['model'].'ImportFields' }}"
    :preview-headings="{{ $form['model'].'ImportHeadings' }}"
    source-url="{{ url('api/v1/core/import/source') }}"
    upload-url="{{ url('api/v1/core/import/upload') }}"
    commit-url="{{ url('api/v1/core/import/load') }}"
    download-tmpl-url="{{ url('api/v1/core/export/xls/template') }}"


    @if( isset($form['collapsible']) && $form['collapsible'] == true )
    collapsible
    @endif

    @if( isset($form['show_panel']) && $form['show_panel'] == true )
    open-show-panel
    @endif

    @if( isset($form['ext_add']) && $form['ext_add'] == true )
    ext-add
    @endif

    @if( isset($form['ext_add_cmd']) && $form['ext_add_cmd'] != '' )
    ext-add-cmd="{{ $form['ext_add_cmd'] }}"
    @endif

    @if( isset($form['ext_edit']) && $form['ext_edit'] == true )
    ext-edit
    @endif

    @if( isset($form['ext_edit_cmd']) && $form['ext_edit_cmd'] != '' )
    ext-edit-cmd="{{ $form['ext_edit_cmd'] }}"
    @endif

    @if( isset($form['hide_add_button']) && $form['hide_add_button'] == true )
    hide-add-button
    @endif

    @if( isset($form['hide_util_button']) && $form['hide_util_button'] == true )
    hide-util-button
    @endif

    @if( isset($form['show_table_header']) && $form['show_table_header'] == true )
    show-table-header
    @endif
    @if( isset($form['ordered']) && $form['ordered'] == true )
    ordered
    @endif
>
</form-question-dialog>
