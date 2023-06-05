<label for="{{ $form['model'] }}" >{{ $label }}</label>
<div
style="overflow: auto;
    height: 100vh;
    max-height: 100vh;"
>
    <drag-tree
        :tree-data="{{ $form['model'] }}"
    >

    </drag-tree>
</div>
