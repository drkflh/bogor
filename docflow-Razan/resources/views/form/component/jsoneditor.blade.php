<label for="{{ $form['model'] }}" >{{ __($label) }}</label><br>
<json-editor
    :json-tree.sync="{{ $form['model'] }}"
    @if(isset( $form['attr'] ))
        @foreach($form['attr'] as $at=>$val)
            {{ $at }}="{{ $val }}"
        @endforeach
    @endif
></json-editor>
