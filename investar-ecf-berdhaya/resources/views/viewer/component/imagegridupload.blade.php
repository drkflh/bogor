<label for="{{ $form['model'] }}" style="font-size: 9pt;font-weight: bold;" >{{ $label }}</label>
<div style="display: block;">
  <img  :src="{{ $form['model'] }}" @click="showLightBox( 0 )"
        style="height:190px;width: 100%; object-fit: cover; border-radius: 16px; " ><br>
</div>
