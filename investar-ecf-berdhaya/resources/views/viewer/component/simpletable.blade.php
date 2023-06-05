<label for="{{ $form['model'] }}" class="view-label" >{{ $label }}</label>
<simple-table
    striped
    :items="{{ $form['model'] }}"
    :fields="{{ $form['model'].'Fields' }}"
    @if( isset($form['ordered']) && $form['ordered'] == true )
        ordered
    @endif
>
</simple-table>
