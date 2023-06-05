<label for="{{ $form['model'] }}" >{{ $label }}</label>
<div style="max-height: 600px;display: block;">
    <vue-codemirror-editor
            style="min-height: 50px;height:{{ $form['height'] ?? '450px' }}"
            v-model="{{ $form['model'] }}"
            :option="{
                    mode: {{ $form['lang'] ?? 'html' }},
                    theme:'material-darker'
                }"
            @if(isset( $form['attr'] ))
                @foreach($form['attr'] as $at=>$val)
                    {{ $at }}="{{ $val }}"
                @endforeach
            @endif
    ></vue-codemirror-editor>
    <p>
        <b>Language Mode :</b> {{ $form['lang'] ?? 'html' }}
    </p>
</div>
