<label for="{{ $form['model'] }}" >{{ $label }}</label>
<div
style="overflow: auto;
    height: 100vh;
    max-height: 100vh;"
>
    <org-tree
        :tree-data="{{ $form['model'] }}"
    >

    </org-tree>
</div>
