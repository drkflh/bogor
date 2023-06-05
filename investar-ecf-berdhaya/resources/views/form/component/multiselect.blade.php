<div>
    <label class="typo__label">{{ $label }}</label>
    <multiselect
    v-model="{{ $form['model'] }}"
    :options="{{ $form['model'].'Options'  }}"
    :multiple="true"
    :close-on-select="false"
    :clear-on-select="false"
    :preserve-search="true"
    placeholder="{{ $label }}"
    label="text"
    track-by="text"
    :show-labels="false"
    :preselect-first="false">
    </multiselect>
</div>
