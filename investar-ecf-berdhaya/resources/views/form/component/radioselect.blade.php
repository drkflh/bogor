@if($label != '')
    <label>{{ $label }}</label>
@endif
@if(env('SKIP_VALIDATION', true ))
    <b-form-group>
        <b-form-radio-group id="radio-group-{{ $form['model'] }}" v-model="{{ $form['model'] }}" name="{{ $form['model'] }}">
            @if( isset($form['value_object']) && $form['value_object'] == true )
                <b-form-radio v-for="p in {{ $form['model'] }}Options" :key="p.value" :value="p">@{{ p.text }}</b-form-radio>
            @else
                <b-form-radio v-for="p in {{ $form['model'] }}Options" :key="p.value" :value="p.value">@{{ p.text }}</b-form-radio>
            @endif
        </b-form-radio-group>
    </b-form-group>
@else
    <validation-provider rules="{{ $form['validator'] ?? '' }}" v-slot="{ errors }" name="{{ strtolower($form['model']) }}">
        <b-form-group>
            <b-form-radio-group id="radio-group-{{ $form['model'] }}" v-model="{{ $form['model'] }}" name="{{ $form['model'] }}">
                @if( isset($form['value_object']) && $form['value_object'] == true )
                    <b-form-radio v-for="p in {{ $form['model'] }}Options" :key="p.value" :value="p">@{{ p.text }}</b-form-radio>
                @else
                    <b-form-radio v-for="p in {{ $form['model'] }}Options" :key="p.value" :value="p.value">@{{ p.text }}</b-form-radio>
                @endif
            </b-form-radio-group>
        </b-form-group>
        <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
    </validation-provider>
@endif
