@if(env('SKIP_VALIDATION', true ))
    @if($label != '')
        <label for="{{ $form['model'] }}" >{{ $label }}</label><br>
    @endif
    <material-input type=""text

        name="{{ $form['model'] }}"

        v-model="{{ $form['model'] }}"
        @if(isset($form['form']['v_show']))
            v-show="{!! $form['form']['v_show'] !!}"
        @endif
        @if(isset($form['form']['class']))
            class="form-control {!! $form['form']['class'] !!}"
        @else
            class="form-control"
        @endif
    ></material-input>
@else
    <validation-provider rules="{{ $form['validator'] ?? '' }}" v-slot="{ errors }" name="{{ strtolower($label) }}">
        <material-input type=""text
            name="{{ $form['model'] }}"

            v-model="{{ $form['model'] }}"

            @if(isset($form['form']['v_show']))
                v-show="{!! $form['form']['v_show'] !!}"
            @endif

            @if(isset($form['form']['class']))
                class="form-control {!! $form['form']['class'] !!}"
            @else
                class="form-control"
            @endif
        ></material-input>
        <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
    </validation-provider>
@endif

