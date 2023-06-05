<?php
    $model = $form['model'];
?>
<div class="form-group">
    <label for="{{ $form['model'] }}" class="col-form-label">{{ $label }}</label>
    <input type="text" readonly class="form-control-plaintext" id="{{ $form['model'] }}"  v-model="{{ $form['model'] }}" >
</div>
