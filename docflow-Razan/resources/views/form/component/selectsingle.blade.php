<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<multiselect
        v-model="{{ $form['model'] }}"
        :options="selectOptions.{{ $form['optionModel'] ?? 'default' }}"
        :searchable="false"
        :label="{{ $form['optionLabel'] ?? 'name' }}"
        :track-by="{{ $form['optionKey'] ?? '_id' }}"
        @input="onSelect{{ ucwords($form['model']) }}"
>
    <?php
        $optKey = '{{ option.'.$form['optionLabel'].' }}';
        $optLabel = '{{ props.option.'.$form['optionLabel'].' }}';
    ?>
    <template slot="singleLabel" slot-scope="{ option }">
        {{ $optKey }}
    </template>
    <template slot="option" slot-scope="props">
        {{ $optLabel }}
    </template>
</multiselect>
