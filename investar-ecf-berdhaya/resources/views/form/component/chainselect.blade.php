@if($label != '')
    <label for="{{ $form['model'] }}" >{{ $label }}</label><br>
@endif
<chain-select
        id="{{ $form['model'] }}"
        v-model="{{ $form['model'] }}"
        search-url="{{ url( $form['url'] )  }}"
        trigger="{{ $form['trigger'] }}"
></chain-select>
<br>
