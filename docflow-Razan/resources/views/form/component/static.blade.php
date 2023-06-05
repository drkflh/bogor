<?php
    $model = sprintf('{{ %s }}',  $form['model']);
?>
<label for="{{ $form['model'] }}">{{ $label }}</label>
<div class="form-control">{{ $model }}</div>
