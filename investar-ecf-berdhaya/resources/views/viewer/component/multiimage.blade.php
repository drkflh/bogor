@if(isset($label) && $label != '')
    <label for="{{ $form['model'] }}" style="font-size: 9pt;font-weight: bold;" >{{ __($label) }}</label>
@endif
<div style="display: block;">
    <img v-if="!_.isEmpty({{ $form['model'] }}) && _.head({{ $form['model'] }})"
         :src="_.head({{ $form['model'] }}"
         @click="showLightBox( '{{ trim($form['model']) }}')"
         style="height:190px;width: 100%; object-fit: cover; border-radius: 16px; cursor:pointer;" ><br>
</div>
