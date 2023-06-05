<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<doc-upload
        v-model="{{ $form['model'] }}"
        :handle="handle"
        ns="{{ $form['model'] }}"
        :qr="{{ isset($form['qr']) && $form['qr'] == true ? 'true': 'false' }}"
        bucket="{{ $form['bucket'] ?? 'docs' }}"
        @if(isset($form['options']))
            uploadurl="{{ url( $form['options']['url'] )  }}"
            :filename="{{ $form['options']['filename']  }}"
            accepted-files="{{ $form['options']['acceptedFiles'] ?? 'application/pdf, image/*, video/*'  }}"
            dir="{{ $form['options']['dir']  }}"
            @if( isset($form['options']['noHandle'] ) && $form['options']['noHandle'] == true)
                no-handle
            @endif
            buttonlabel="{{ (isset($form['options']['buttonlabel']))?$form['options']['buttonlabel']:'Click or drop to upload' }}"
            :base-url.sync="{{ $form['options']['baseUrl']  }}"
            :doc-path.sync="{{ $form['options']['docPath']  }}"
        @endif
        @if(isset($form['param']))
            uploadurl="{{ url( $form['param']['url'] )  }}"
            :filename="{{ $form['param']['filename']  }}"
            accepted-files="{{ $form['param']['acceptedFiles'] ?? 'application/pdf, image/*, video/*'  }}"
            dir="{{ $form['param']['dir']  }}"
            @if( isset($form['param']['noHandle'] ) && $form['param']['noHandle'] == true)
                no-handle
            @endif
            buttonlabel="{{ (isset($form['param']['buttonlabel']))?$form['param']['buttonlabel']:'Click or drop to upload' }}"
            :base-url.sync="{{ $form['param']['baseUrl']  }}"
            :doc-path.sync="{{ $form['param']['docPath']  }}"
        @endif
        defaulturl="{{ url( env('DEFAULT_THUMBNAIL') ) }}"
        mode="single"
    >

</doc-upload>
