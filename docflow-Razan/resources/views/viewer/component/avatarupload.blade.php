<label for="{{ $form['model'] }}" style="font-size: 9pt;font-weight: bold;" >{{ $label }}</label>
<div class="d-flex justify-content-center" style="display: block;">
    <img  :src="{{ $form['model'] }}" @click="showLightBox( 0 )"
          onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/blank.png' ) ) }}';"
          style="height:145px;width: 145px; object-fit: cover; border-radius: 16% " >
    <br>
</div>
