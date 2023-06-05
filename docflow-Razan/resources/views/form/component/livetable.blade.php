<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<live-table
    @if(isset($form['options']))
        data-url="{{ url( $form['options']['url'] )  }}"
    @endif
    @if(isset($form['param']))
        data-url="{{ url( $form['param']['url'] )  }}"
    @endif
    :columns="{{ $form['model'].'Columns' }}"
    :extra-data="{{ $form['model'].'Extra' ?? '{}' }}"
>
</live-table>
