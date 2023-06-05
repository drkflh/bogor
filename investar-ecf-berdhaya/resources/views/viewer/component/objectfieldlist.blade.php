@if(isset($label) && $label != '')
    <label for="{{ $form['model'] }}" class="view-label" >{{ __($label) }}</label>
@endif
<ol style="list-style-type: decimal-leading-zero;">
    <li v-for="val in {{ $form['model'] }}"
        class="underlined pl-1"
        style="word-break: break-word;min-height:35px; height:fit-content !important; border-bottom-color: lightgrey !important;"
        v-html="_.get( val, '{{ $form['field'] }}', '' )"
    >
    </li>
</ol>

