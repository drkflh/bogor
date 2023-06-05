@if(isset($label))
<label for="{{ $form['model'] }}" >{{ __($label) }}</label><br>
@endif
<local-search-select
        id="{{ $form['model'] }}"
        v-model="{{ $form['model'] }}"
        :options="{{ $form['model'].'Options'}}"
        @if(isset($form['on_local_select'] ) )
            @input="{{ $form['on_local_select'] }}"
        @else
            @input="onLocalSelect"
        @endif
></local-search-select>
<br>
