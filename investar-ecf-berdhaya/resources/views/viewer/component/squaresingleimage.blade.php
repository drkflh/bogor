@if($label && $label != '')
<label for="{{ $form['model'] }}" style="font-size: 9pt;font-weight: bold;" >{{ $label }}</label>
@endif
<div style="display: block; text-align:center; width:100%;">
    <img  :src="{{ $form['model'] }}" @click="showLightBox( '{{ trim($form['model']) }}')"
          onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/blank.png' ) ) }}';"
          style="height:190px;width: 190px; margin:auto; object-fit: cover; border-radius: 16px; cursor:pointer;" ><br>
</div>
