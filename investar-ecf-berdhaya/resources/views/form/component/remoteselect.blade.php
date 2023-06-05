<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<remote-select
        id="{{ $form['model'] }}"
        v-model="{{ $form['model'] }}"
        @if(isset($form['options']))
            search-url="{{ url( $form['options']['url'] )  }}"
        @endif
        @if(isset($form['param']))
            search-url="{{ url( $form['param']['url'] )  }}"
        @endif
></remote-select>
<br>
