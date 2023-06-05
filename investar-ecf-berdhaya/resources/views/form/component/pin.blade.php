@if( $label && $label != '' )
    <label for="{{ $form['model'] }}" >{{ __($label) }}</label><br>
@endif

@if(env('SKIP_VALIDATION', true ))
    <pin-input
        v-model="{{ $form['model'] }}"
        {{isset($form['should_auto_focus'] ) && $form['should_auto_focus'] ? 'should-auto-focus' : '' }}
        ref-key="{{ $form['model'] }}"
        num-inputs="{{ $form['num_inputs'] ?? 6 }}"
        input-type="{{ $form['input_type'] ?? 'number' }}"
        separator="{{ $form['separator'] ?? '' }}"
    >
    </pin-input>
@else
    <validation-provider rules="{{ $form['validator'] ?? '' }}" v-slot="{ errors }"
                         name="{{ __($label) }}"
                         vid="{{ $form['model'] }}"
    >
        <pin-input
            v-model="{{ $form['model'] }}"
            {{isset($form['should_auto_focus'] ) && $form['should_auto_focus'] ? 'should-auto-focus' : '' }}
            ref-key="{{ $form['model'] }}"
            num-inputs="{{ $form['num_inputs'] ?? 6 }}"
            input-type="{{ $form['input_type'] ?? 'number' }}"
            separator="{{ $form['separator'] ?? '' }}"
        >
        </pin-input>
        <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
    </validation-provider>
@endif
<br>
