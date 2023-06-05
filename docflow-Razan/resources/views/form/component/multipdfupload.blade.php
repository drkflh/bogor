<multi-pdf-upload
        v-model="{{ $form['model'] }}"
        label="{{ $label }}"
        label-for="{{ $form['model'] }}"
        :handle="handle"
        ns="{{ $form['model'] }}"
        @if(isset($form['options']))
            uploadurl="{{ url( $form['options']['url'] )  }}"
        @endif
        @if(isset($form['param']))
            uploadurl="{{ url( $form['param']['url'] )  }}"
        @endif
        defaulturl="{{ url('images/coffee.png') }}"
        mode="multi"
        @if( isset($form['attr']['doc_strip']) && $form['attr']['doc_strip'] )
            doc-strip
        @endif
        @if( isset($form['attr']['hide_uploader']) && $form['attr']['hide_uploader'] )
            hide-uploader
        @endif
        buttonlabel="{{ (isset($form['attr']['buttonlabel']))?$form['attr']['buttonlabel']:'Click or drop to upload' }}"
    >

</multi-pdf-upload>
