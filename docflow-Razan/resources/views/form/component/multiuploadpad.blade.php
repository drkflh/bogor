<label for="{{ $form['model'] }}">{{ __($label) }}</label><br>
<multi-upload-pad
    v-model="{{ $form['model'] }}"
    :handle="handle"
    ns="{{ $form['model'] }}"
    defaulturl="{{ url( env('DEFAULT_THUMBNAIL') ) }}"
    mode="single"

    @if(isset($form['options']))
        uploadurl="{{ url( $form['options']['url'] )  }}"
        @if( isset($form['options']['filename'] ) && $form['options']['filename'] != '')
            :filename="{{ $form['options']['filename']  }}"
        @endif
        @if( isset($form['options']['dir'] ) && $form['options']['dir'] != '')
            dir="{{ $form['options']['dir']  }}"
        @endif
        @if( isset($form['options']['noHandle'] ) && $form['options']['noHandle'] == true)
            no-handle
        @endif
        @if( isset($form['options']['rawUpload'] ) && $form['options']['rawUpload'] == true)
            raw-upload
        @endif
        buttonlabel="{{ (isset($form['options']['buttonlabel']))?$form['options']['buttonlabel']:'Click or drop to upload' }}"
        accepted-files="{{ $form['options']['acceptedFiles'] ?? 'image/*, video/*, application/pdf' }}"

        @if( isset($form['options']['baseUrl'] ) && $form['options']['baseUrl'] != '')
            :base-url.sync="{{ $form['options']['baseUrl']  }}"
        @endif

        @if( isset($form['options']['docPath'] ) && $form['options']['docPath'] != '')
            :doc-path.sync="{{ $form['options']['docPath']  }}"
        @endif

    @endif
    @if(isset($form['param']))
        uploadurl="{{ url( $form['param']['url'] )  }}"
        @if( isset($form['param']['filename'] ) && $form['param']['filename'] != '')
            :filename="{{ $form['param']['filename']  }}"
        @endif
        @if( isset($form['param']['dir'] ) && $form['param']['dir'] != '')
            dir="{{ $form['param']['dir']  }}"
        @endif
        @if( isset($form['param']['noHandle'] ) && $form['param']['noHandle'] == true)
            no-handle
        @endif
        @if( isset($form['param']['rawUpload'] ) && $form['param']['rawUpload'] == true)
            raw-upload
        @endif
        buttonlabel="{{ (isset($form['param']['buttonlabel']))?$form['param']['buttonlabel']:'Click or drop to upload' }}"
        accepted-files="{{ $form['param']['acceptedFiles'] ?? 'image/*, video/*, application/pdf' }}"

        @if( isset($form['param']['baseUrl'] ) && $form['param']['baseUrl'] != '')
            :base-url.sync="{{ $form['param']['baseUrl']  }}"
        @endif

        @if( isset($form['param']['docPath'] ) && $form['param']['docPath'] != '')
            :doc-path.sync="{{ $form['param']['docPath']  }}"
        @endif

    @endif


>

</multi-upload-pad>
