@if($label != '')
    <label for="{{ $form['model'] }}" >{{ __($label) }}</label><br>
@endif
@if(env('SKIP_VALIDATION', true ) == true)
    <validation-provider rules="{{ $form['validator'] ?? '' }}" v-slot="{ errors }" name="{{ strtolower($label) }}">
@endif
        <signature-card-upload
            name="{{ $form['model'] }}"
            v-model="{{ $form['model'] }}"
            :handle="handle"
            ns="{{ $form['model'] }}"
            @if(isset($form['options']))
                uploadurl="{{ url( $form['options']['url'] )  }}"
                sign-upload-url="{{ url( $form['options']['url'] )  }}"
            @endif
            @if(isset($form['param']))
                uploadurl="{{ url( $form['param']['url'] )  }}"
                sign-upload-url="{{ url( $form['param']['url'] )  }}"
            @endif
            @if(isset($form['hide_upload_button']) && $form['hide_upload_button'] == true )
                :hide-upload-button="{{ $form['hide_upload_button'] ? 'true':'false' }}"
            @endif
            bucket="{{ $form['bucket'] ?? 'media' }}"
            defaulturl="{{ url( env('DEFAULT_THUMBNAIL') ) }}"
            mode="single"
            buttonlabel="{{ (isset($form['attr']['buttonlabel']))?$form['attr']['buttonlabel']:'Click or drop to upload' }}"

            sign-width="{{ $form['sign_width'] ?? '100%' }}"
            sign-height="{{ $form['sign_height'] ?? '200px' }}"
            sign-ref="{{ $form['sign_ref'] ?? $form['model'].'Ref'  }}"
            :sign-handle="{{ $form['sign_handle'] ?? 'handle' }}"
            sign-ns="{{ $form['sign_ns'] ?? 'signature' }}"

            :specimen="{{ $form['specimen'] ?? 'specimen' }}"


        >

        </signature-card-upload>
@if(env('SKIP_VALIDATION', true ) == true)
        <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
    </validation-provider>
@endif
