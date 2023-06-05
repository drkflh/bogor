<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<topic-selector
        v-model="{{ $form['model'] }}"
        :topic-options="{{ $form['select_options'] ?? $form['model'].'Options' }}"
        :topic-text.sync="{{ $form['topicText'] }}"
        :topic-descr.sync="{{ $form['topicDescr'] }}"
        :topic-feature.sync="{{ $form['topicFeature'] }}"
        :topic-function.sync="{{ $form['topicFunction'] }}"
        :topic-doc-class.sync="{{ $form['topicDocClass'] }}"
        :topic-active-yrs.sync="{{ $form['topicActiveYrs'] }}"
        :topic-disp-per.sync="{{ $form['topicDispPer'] }}"

        @if(isset($form['attr']))
            @foreach($form['attr'] as $att=>$v)
                {{ $att }}="{{ $v }}"
            @endforeach
        @endif
/>
<br>
