<label for="{{ $form['model'] }}" >{{ __($label) }}</label><br>
<qrcode
    :v-model="{{ $form['model'] }}"
    :value="{!! $form['model']  !!}"
    @if(isset($form['options']))
        :options="{!! $form['options'] !!}"
    @endif
    @if(isset($form['param']))
        :options="{!! $form['param'] !!}"
    @endif
>
</qrcode><br>
