@if($label != '')
    <label for="{{ $form['model'] }}" >{{ __($label) ?? '' }}</label><br>
@endif
<div style="display:block;width: 100%;">
    <span v-for="p in {{ $form['model'] }}" v-html="p.text" class="badge badge-pill badge-primary p-2 mr-2 mt-1" ></span>
</div>
