@if($label != '')
    <label for="{{ $form['model'] }}" >{{  __($label)  }}</label><br>
@endif
<user-selector
    v-model="{{ $form['model'] }}"
    :default-value="{{ $form['model'] }}"
    @if(isset($form['options']))
        search-url="{{ url( $form['options']['url'] ?? '' )  }}"
    @endif
    @if(isset($form['param']))
        search-url="{{ url( $form['param']['url'] ?? '' )  }}"
    @endif
></user-selector>
