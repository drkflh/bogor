@if($label != '')
<label for="{{ $form['model'] }}" >{{  __($label)  }}</label><br>
@endif
<tags-input
        v-model="{{ $form['model'] }}"
        :init-tags="{{ $form['model'] }}"
        @if(isset($form['options']))
            search-url="{{ url( $form['options']['url'] ?? '' )  }}"
        @endif
        @if(isset($form['param']))
            search-url="{{ url( $form['param']['url'] ?? '' )  }}"
        @endif
></tags-input>
<br>
