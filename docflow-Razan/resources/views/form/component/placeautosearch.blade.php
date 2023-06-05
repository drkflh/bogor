<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<place-auto-search
        {{--:model.sync="{{ $form['model'] }}"--}}
        v-model="{{ $form['model'] }}"
        @if(isset($form['options']))
            search-url="{{ url( $form['options']['url'] )  }}"
        @endif
        @if(isset($form['param']))
            search-url="{{ url( $form['param']['url'] )  }}"
        @endif
        {{--@foreach($form['attr'] as $att=>$v)--}}
            {{--{{ $att }}="{{ $v }}"--}}
        {{--@endforeach--}}
></place-auto-search>
<br>
