<div class="card">
    <div class="card-header">
        <legend for="{{ $form['model'] }}" >{{ $label }}</legend>
    </div>
    <div class="card-body">
        <active-view
                :content="{{ $form['model'] }}"
                :template="{{ $form['template'].'Template' }}"
        ></active-view>
    </div>
    <div class="card-footer">

    </div>
</div>
