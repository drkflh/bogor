<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<photo-cam
        v-model="{{ $form['model'] }}"
        :handle="handle"
        ns="{{ $form['model'] }}"
        @if(isset($form['options']))
            uploadurl="{{ url( $form['options']['url'] )  }}"
        @endif
        @if(isset($form['param']))
            uploadurl="{{ url( $form['param']['url'] )  }}"
        @endif
        :defaulturl="defaultImageDraw"
        mode="single"
    >

</photo-cam>
