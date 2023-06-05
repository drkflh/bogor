<upload-xls-dialog
    ref="{{ $form['ref'] ??'csvDataUploader'}}"
    button-text="{{ $form['button_text'] ??' Upload CSV / XLS'}}"
    button-text-class="{{ $form['button_text_class'] ??''}}"
    icon-class="{{ $form['icon_class'] ??'las la-upload'}}"
    button-class="{{ $form['button_class'] ??'btn btn-primary'}}"
    @hidden="{{ $form['on_hidden'] ??'uploadModalHidden'}}"
    handle="{{ \Illuminate\Support\Str::random(5) }}"
    modal-id="{{ \Illuminate\Support\Str::random(5) }}"

    uploadurl="{{ url('api/v1/core/import/upload') }}"
    commiturl="{{ url('api/v1/core/import/commit') }}"
    sourceurl="{{ url('api/v1/core/import/source') }}"
    download-tmpl-url="{{ url('api/v1/core/export/xls/template') }}"

    :no-button="{{ $form['no_button'] ?? false }}"
    :previewheadings="{{ $form['preview_headings'] ??'previewHeadings'}}"
    :previewcolumns="{{ $form['preview_columns'] ??'previewColumns'}}"
    ns="{{ $form['ns'] ?? 'csvData' }}"
    :aux-overrides="{{ $form['aux_overrides'] ??'[]'}}"
>

</upload-xls-dialog>
