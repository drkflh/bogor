@if($label != '')
    <label>{{ $label }}</label>
@endif
@if(env('SKIP_VALIDATION', true ))
    <b-form-group>
        <b-form-radio-group id="radio-group-{{ $form['model'] }}" v-model="{{ $form['model'] }}" name="{{ $form['model'] }}">

            @if(isset($form['options']))
                @foreach($form['options'] as $opt)
                    <b-form-radio value="{{ $opt['value'] }}">{{ $opt['text'] }}</b-form-radio>
                @endforeach
            @endif
            @if(isset($form['param']))
                @foreach($form['param'] as $opt)
                    <b-form-radio value="{{ $opt['value'] }}">{{ $opt['text'] }}</b-form-radio>
                @endforeach
            @endif

        </b-form-radio-group>
    </b-form-group>
@else
    <validation-provider rules="{{ $form['validator'] ?? '' }}" v-slot="{ errors }" name="{{ strtolower($label) }}">
        <b-form-group>
            <b-form-radio-group id="radio-group-{{ $form['model'] }}" v-model="{{ $form['model'] }}" name="{{ $form['model'] }}">

                @if(isset($form['options']))
                    @foreach($form['options'] as $opt)
                        <b-form-radio value="{{ $opt['value'] }}">{{ $opt['text'] }}</b-form-radio>
                    @endforeach
                @endif
                @if(isset($form['param']))
                    @foreach($form['param'] as $opt)
                        <b-form-radio value="{{ $opt['value'] }}">{{ $opt['text'] }}</b-form-radio>
                    @endforeach
                @endif

            </b-form-radio-group>
        </b-form-group>
        <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
    </validation-provider>
@endif
