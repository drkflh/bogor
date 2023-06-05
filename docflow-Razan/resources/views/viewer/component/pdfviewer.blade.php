<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<div id="{{ strtolower($form['model']) }}Frame" style="height: 100%; min-height: 800px;">
    <iframe :src="{{ $form['model'] }}" id="{{ strtolower($form['model']) }}-iframe"
            style="height:100%;width: 100%; min-height: 800px;border:none">
    </iframe>
</div>
