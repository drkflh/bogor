<button-modal-user-select
    ref="{{ $form['ref'] ?? $form['model'] }}"
    ok-title="{{ $form['ok_title'] ?? 'OK' }}"
    :no-button="{{ $form['no_button'] ?? 'false' }}"
    button-text="{{ $label ?? 'Open Modal' }}"
    button-text-class="{{ $form['text_class'] ?? '' }}"
    button-class="{{ $form['button_class'] ?? 'btn btn-primary' }}"
    action-url="{{ url( $form['param']['url'] ?? '' ) }}"
    :object-default="{!!  $form['model'].'ObjDef' ?? '' !!}"
    modal-size="{{ $form['modal_size'] ?? 'lg' }}"
    @hidden="{{ $form['on_hidden'] ?? '' }}"
    @shown="{{ $form['on_shown'] ?? '' }}"

    handle="{{ \Illuminate\Support\Str::random(5) }}"
    modal-id="{{ \Illuminate\Support\Str::random(5) }}"

>

</button-modal-user-select>
