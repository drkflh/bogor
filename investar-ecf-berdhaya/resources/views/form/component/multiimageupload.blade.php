<multi-image-upload
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
        buttonlabel="{{ (isset($form['attr']['buttonlabel']))?$form['attr']['buttonlabel']:'Click or drop to upload' }}"
    >

</multi-image-upload>
