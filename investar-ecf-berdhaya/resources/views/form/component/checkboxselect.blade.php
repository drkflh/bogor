@if($label != '')
    <label>{{ $label }}</label>
@endif
@if(env('SKIP_VALIDATION', true ))
    <b-form-group>
        <b-form-checkbox-group id="checkbox-group-{{ $form['model'] }}" v-model="{{ $form['model'] }}" name="{{ $form['model'] }}">
            @if( isset($form['value_object']) && $form['value_object'] == true )
                <b-form-checkbox v-for="p in {{ $form['model'] }}Options" :key="p" :value="p"  class="{{ $form['item_class'] ?? 'col-3' }}" >@{{ p.text }}</b-form-checkbox>
            @else
                <b-form-checkbox v-for="p in {{ $form['model'] }}Options" :key="p.value" :value="p.value"  class="{{ $form['item_class'] ?? 'col-3' }}" >@{{ p.text }}</b-form-checkbox>
            @endif
        </b-form-checkbox-group>
    </b-form-group>
@else
    <validation-provider rules="{{ $form['validator'] ?? '' }}" v-slot="{ errors }" name="{{ strtolower($form['model']) }}">
        <b-form-group>
            <b-form-checkbox-group id="checkbox-group-{{ $form['model'] }}" v-model="{{ $form['model'] }}" name="{{ $form['model'] }}">
                @if( isset($form['value_object']) && $form['value_object'] == true )
                    <b-form-checkbox v-for="p in {{ $form['model'] }}Options" :key="p" :value="p"  class="{{ $form['item_class'] ?? 'col-3' }}" >@{{ p.text }}</b-form-checkbox>
                @else
                    <b-form-checkbox v-for="p in {{ $form['model'] }}Options" :key="p.value" :value="p.value"  class="{{ $form['item_class'] ?? 'col-3' }}" >@{{ p.text }}</b-form-checkbox>
                @endif
            </b-form-checkbox-group>
        </b-form-group>
        <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
    </validation-provider>
@endif
