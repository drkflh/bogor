@if(env('SKIP_VALIDATION', true ))
    @if(isset($form['position']) && ($form['position'] == 'hidden' || $form['position'] == 'top'))
        <label for="{{ $form['model'] }}" >{{ __($label) }}</label><br>
    @endif
    <b-form-checkbox v-model="{{ $form['model'] }}" name="check-button" disabled switch size="lg">
        @if(isset($form['position']) && !($form['position'] == 'hidden' || $form['position'] == 'top'))
            {{ __($label) }}
        @endif
    </b-form-checkbox>
@else
    <validation-provider rules="{{ $form['validator'] ?? '' }}" v-slot="{ errors }" name="{{ $label }}">
        @if(isset($form['position']) && $form['position'] == 'hidden')
            <label for="{{ $form['model'] }}" >{{ __($label) }}</label><br>
        @endif
        <b-form-checkbox v-model="{{ $form['model'] }}" name="check-button" disabled switch size="lg">
            @if(isset($form['position']) && !($form['position'] == 'hidden' || $form['position'] == 'top'))
                {{ __($label) }}
            @endif
        </b-form-checkbox>
        <div style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
    </validation-provider>
@endif
