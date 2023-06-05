@if($label != '')
    <label>{{ $label }}</label>
@endif
@if(env('SKIP_VALIDATION', true ))
    <b-form-group>
        <b-form-radio-group id="radio-group-{{ $form['model'] }}" v-model="{{ $form['model'] }}" name="{{ $form['model'] }}">
            <b-form-radio key="{{ $form['model'] }}Yes" value="Yes">Yes</b-form-radio>
            <b-form-radio key="{{ $form['model'] }}No" value="No">No</b-form-radio>
            <b-form-radio key="{{ $form['model'] }}NA" value="NA">NA</b-form-radio>
        </b-form-radio-group>
    </b-form-group>
@else
    <validation-provider rules="{{ $form['validator'] ?? '' }}" v-slot="{ errors }" name="{{ strtolower($form['model']) }}">
        <b-form-group>
            <b-form-radio-group id="radio-group-{{ $form['model'] }}" v-model="{{ $form['model'] }}" name="{{ $form['model'] }}">
                <b-form-radio key="{{ $form['model'] }}Yes" value="Yes">Yes</b-form-radio>
                <b-form-radio key="{{ $form['model'] }}No" value="No">No</b-form-radio>
                <b-form-radio key="{{ $form['model'] }}NA" value="NA">NA</b-form-radio>
            </b-form-radio-group>
        </b-form-group>
        <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
    </validation-provider>
@endif
