@if( isset($label) && $label != '')
<label style="color:#800000;" for="{{ $form['model'] }}" class="view-label" >{{ __($label) }}</label>
@endif
<simple-table
        striped
        hover
        :items="{{ $form['model'] }}"
        :fields="{{ $form['model'].'Fields' }}"
        @if( isset($form['ordered']) && $form['ordered'] == true )
            ordered
        @endif
>
</simple-table>
