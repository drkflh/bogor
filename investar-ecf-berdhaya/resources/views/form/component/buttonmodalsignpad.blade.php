@if($label != '')
    <label>{{ __($label) }}</label><hr>
@endif
<button-modal-sign-pad
    ref="{{ $form['ref'] ?? $form['model'] }}"
    :item.sync="{{ $form['model'] }}"
    ok-title="{{ $form['ok_title'] ?? 'OK' }}"
    :no-button="{{ $form['no_button'] ?? 'false' }}"
    button-text="{{ $label ?? 'Open Modal' }}"
    button-text-class="{{ $form['text_class'] ?? '' }}"
    button-class="{{ $form['button_class'] ?? 'btn btn-primary' }}"
    action-url="{{ url( $form['action_url'] ?? '' ) }}"
    pin-url="{{ url( $form['pin_url'] ?? 'auth/check-pin' ) }}"
    upload-url="{{ url( 'api/v1/core/upload' ) }}"
    sign-url="{{ url( 'api/v1/core/form-upload' )  }}"
    defaulturl="{{ url( 'images/default_256.jpg' )  }}"
    specimen="{{ Auth::user()->signatureSpecimen ?? '' }}"

    modal-size="{{ $form['modal_size'] ?? 'md' }}"
    @hidden="{{ $form['on_hidden'] ?? '' }}"
    @shown="{{ $form['on_shown'] ?? '' }}"

    handle="{{ \Illuminate\Support\Str::random(5) }}"
    modal-id="{{ \Illuminate\Support\Str::random(5) }}"

>

</button-modal-sign-pad>
