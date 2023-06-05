<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<avatar-upload
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
        buttonlabel="{{ (isset($form['attr']['buttonlabel']))?$form['attr']['buttonlabel']:'Click or drop to upload' }}"
    >

</avatar-upload>
