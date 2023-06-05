@if($label != '')
    <label for="{{ $form['model'] }}" class="{{ $form['label_class'] ?? '' }}" >{{ __($label) }}</label>
@endif

@if(env('SKIP_VALIDATION', true ) == false)
    <validation-provider rules="{{ $form['validator'] ?? '' }}" v-slot="{ errors }"
                         name="{{ strtolower($label) }}"
                         vid="{{ $form['model'] }}"
    >
@endif
        <input type="password"
                name="{{ $form['model'] }}"
                v-model="{{ $form['model'] }}"
                ref="{{ $form['model'] }}"
                class="{!! 'form-control '.($form['class'] ?? '') !!}"
            @if(isset($form['v_show']))
                v-show="{!! $form['v_show'] !!}"
            @endif
            @if(isset($form['placeholder']))
                placeholder="{!! $form['placeholder'] !!}"
            @endif
            @if(isset($form['attr']) && is_array($form['attr']))
                @foreach($form['attr'] as $at=>$av)
                    {{ $at }}="{{ $av }}"
                @endforeach
            @endif
        >
@if(env('SKIP_VALIDATION', true ) == false)
        <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
    </validation-provider>
@endif

