<label for="{{ $form['model'] }}" >{{ $label }}</label>
<div style="height:450px;max-height: 600px;display: block;">
    <vue-markdown
        style="min-height: 400px;"
        :source="{{ $form['model'] }}"
    ></vue-markdown>
</div>
