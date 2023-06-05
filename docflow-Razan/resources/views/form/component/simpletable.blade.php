<div class="card">
    <div class="card-header">
        <label for="{{ $form['model'] }}" >{{ $label }}</label>
    </div>
    <div class="card-body">
        <simple-table
            striped
            hover
            :items="{{ $form['model'] }}"
            :fields="{{ $form['model'].'Fields' }}" >
        </simple-table>
    </div>
    <div class="card-footer">

    </div>
</div>
