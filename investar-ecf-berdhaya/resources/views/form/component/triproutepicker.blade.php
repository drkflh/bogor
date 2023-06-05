<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<trip-route-picker
        {{--:model.sync="{{ $form['model'] }}"--}}
        v-model="{{ $form['model'] }}"
        search-url="{{ url( $form['options']['url'] )  }}"
        {{--@foreach($form['attr'] as $att=>$v)--}}
            {{--{{ $att }}="{{ $v }}"--}}
        {{--@endforeach--}}
></trip-route-picker>
<br>
