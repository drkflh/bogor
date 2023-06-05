<label for="{{ $form['model'] }}" >{{ __($label) }}</label><br>
@if(env('SKIP_VALIDATION', false))
    <validation-provider rules="{{ $form['validator'] ?? '' }}" v-slot="{ errors }" name="{{ strtolower($label) }}">
        <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
@endif
        <ckeditor
            v-model="{{ $form['model'] }}"
            :editor="editor"
            :config="editorConfig">
        </ckeditor>
@if(env('SKIP_VALIDATION', false))
    </validation-provider>
@endif
