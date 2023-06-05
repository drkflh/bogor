<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
{{--<pdf-view--}}
{{--        :doc-url="{{ $form['model'] }}"--}}
{{--        :handle="handle"--}}
{{--        ns="{{ $form['model'] }}"--}}
{{--        base-url=""--}}
{{--        :defaulturl="defaultImageDraw"--}}
{{--        mode="single"--}}
{{--        buttonlabel="{{ (isset($form['attr']['buttonlabel']))?$form['attr']['buttonlabel']:'Edit' }}"--}}
{{--    >--}}

{{--</pdf-view>--}}
<div id="printedItemContentFrame" style="height: 100%; min-height: 800px;">
    <iframe :src="{{ $form['model'] }}" id="print-iframe"
{{--            v-on:load="iOnLoad"--}}
{{--            @loaded="iOnLoad"--}}
            style="height:100%;width: 100%; min-height: 800px;border:none"></iframe>
</div>
