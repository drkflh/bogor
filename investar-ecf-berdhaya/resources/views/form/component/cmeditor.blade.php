<label for="{{ $form['model'] }}" >{{ $label }}</label>
<div style="height:450px;max-height: 600px;overflow-y: scroll;display: block;">
    {{--<vue-prism-editor--}}
            {{--style="min-height: 400px;"--}}
            {{--v-model="{{ $form['model'] }}"--}}
            {{--language="{{ $form['lang'] }}"--}}
    {{--@if(isset( $form['attr'] ))--}}
        {{--@foreach($form['attr'] as $at=>$val)--}}
            {{--{{ $at }}="{{ $val }}"--}}
        {{--@endforeach--}}
    {{--@endif--}}
    {{--></vue-prism-editor>--}}
    <codemirror
        v-model="{{ $form['model'] }}"
        mode="{{ $form['lang'] }}"
        @if(isset( $form['attr'] ))
            @foreach($form['attr'] as $at=>$val)
                {{ $at }}="{{ $val }}"
            @endforeach
        @endif
    >

    </codemirror>
</div>
<p>
    <b>Language Mode :</b> {{ $form['lang'] }}
</p>
