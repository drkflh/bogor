@if($label != '')
    <label for="{{ $form['model'] }}" >{{ $label }}</label><br>
@endif
<sign-pad
    ref="{{ $form['model'] }}Pad"
    v-model="{{ $form['model'] }}"
    :handle="handle"
    ns="{{ $form['ns'] ?? $form['model'] }}"
    uploadurl="{{ url( 'api/v1/core/form-upload' )  }}"
    mode="single"
    width="{{ $form['width'] ?? '100%'  }}"
    height="{{ $form['height'] ?? '200px'  }}"
>

</sign-pad>
