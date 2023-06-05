<active-form
        v-model="{{ $form['model'] }}"
        :content="{{ $form['model'] }}"
        :object-default="{{ $form['model'].'DefaultObject' }}"
        :template="{{ $form['template'].'Template' }}"
        :params="{{ $form['model'].'Params' }}"
></active-form>
