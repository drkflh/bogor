@if($label != '')
<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
@endif
<div class="mt-20"
     @if(isset($form['attr']))
        @foreach($form['attr'] as $att=>$v)
            {{ $att }}="{{ $v }}"
        @endforeach
     @endif
>
    <map-display
            :zoom="mapZoom"
            marker-icon="{{ url(env('MARKER_IMAGE')) }}"
            marker-icon-retina="{{ url(env('MARKER_IMAGE')) }}"
            v-model="{{ $form['model'] }}"
            @if( isset($form['show_all_buttons']) && $form['show_all_buttons'] == true )
                show-all-buttons
            @endif
            {{--:show-all-buttons="{{ isset($form['show_all_buttons']) && $form['show_all_buttons'] == true ?'true':'false' }}"--}}
    >
    </map-display>
</div>
