@if($label && $label != '')
    <label for="{{ $form['model'] }}" >{{ $label }}</label><br>
@endif
<vue-player
    :autoplay="true"
    :src="{{ $form['model'] }}">
</vue-player>
