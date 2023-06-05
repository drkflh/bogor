@if($label != '')
    <label for="{{ $form['model'] }}" >{{ __($label) }}</label>
@endif
<div class="list-container"
    style="overflow: auto;
    height: {{ $form['height'] ?? '200px' }}
    max-height: 500px;"
>
    <simple-nestable
        :tree.sync="{{ $form['model'] }}"
    ></simple-nestable>
</div>
