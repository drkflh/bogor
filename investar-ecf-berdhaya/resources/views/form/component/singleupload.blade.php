<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<single-upload
        v-model="{{ $form['model'] }}"
        :handle="handle"
        ns="{{ $form['model'] }}"
        @if(isset($form['options']))
            uploadurl="{{ url( $form['options']['url'] )  }}"
        @endif
        @if(isset($form['param']))
            uploadurl="{{ url( $form['param']['url'] )  }}"
        @endif
        defaulturl="{{ url( env('DEFAULT_THUMBNAIL') ) }}"
        mode="single"
        :button-template="{{ $form['model'].'Template' }}"
        button-label="{{ (isset($form['options']['buttonlabel']))?$form['options']['buttonlabel']:'Click or drop to upload' }}"
    >

</single-upload>
