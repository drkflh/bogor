@if($label != '')
    <label for="{{ $form['model'] }}" >{{ $label }}</label><br>
@endif
<image-strip
    :images="{{ $form['model'] }}"
>

</image-strip>
