@if($label && $label != '')
<label>{{ __($label) }}</label>
@endif
@if(env('SKIP_VALIDATION', true ))
<b-form-group>
    <b-form-checkbox-group id="checkbox-group-{{ $form['model'] }}" v-model="{{ $form['model'] }}" name="{{ $form['model'] }}">

        @if(isset($form['options']))
            @foreach($form['options'] as $opt)
                <b-form-checkbox class="col-3" value="{{ $opt['value'] }}">{{ $opt['text'] }}</b-form-checkbox>
            @endforeach
        @endif
        @if(isset($form['param']))
            @foreach($form['param'] as $opt)
                <b-form-checkbox class="col-3" value="{{ $opt['value'] }}">{{ $opt['text'] }}</b-form-checkbox>
            @endforeach
        @endif

    </b-form-checkbox-group>
</b-form-group>
@else
<validation-provider rules="{{ $form['validator'] ?? '' }}" v-slot="{ errors }" name="{{ strtolower($label) }}">
    <b-form-group>
        <b-form-checkbox-group id="checkbox-group-{{ $form['model'] }}" v-model="{{ $form['model'] }}" name="{{ $form['model'] }}">

            @if(isset($form['options']))
                @foreach($form['options'] as $opt)
                    <b-form-checkbox class="col-3" value="{{ $opt['value'] }}">{{ $opt['text'] }}</b-form-checkbox>
                @endforeach
            @endif
            @if(isset($form['param']))
                @foreach($form['param'] as $opt)
                    <b-form-checkbox class="col-3" value="{{ $opt['value'] }}">{{ $opt['text'] }}</b-form-checkbox>
                @endforeach
            @endif

        </b-form-checkbox-group>
    </b-form-group>
    <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
</validation-provider>
@endif
