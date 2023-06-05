<label for="{{ $form['model'] }}" >{{ $label }}</label>
<div class="list-container"
style="overflow: auto;
    height: 500px;
    max-height: 500px;"
>
    <active-sortable-list
        :list="{{ $form['model'] }}"
        :item-template="{{ $form['model'].'ItemTemplate' }}"
        :clicked.sync="{{ $form['selected'] }}"
    >
    </active-sortable-list>
</div>
