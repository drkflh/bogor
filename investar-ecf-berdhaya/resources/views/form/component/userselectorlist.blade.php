@if($label != '')
    <label for="{{ $form['model'] }}" >{{  __($label)  }}</label><br>
@endif
{{--@if(env('SKIP_VALIDATION', false) == false)--}}
{{--    <validation-provider rules="{{ $form['validator'] ?? '' }}" v-slot="{ errors }" name="{{ strtolower($label) }}">--}}
{{--@endif--}}

<user-selector-list
    :items.sync="{{ $form['model'] }}"
    :default-value="{{ $form['model'] }}"
    mode="{{ $form['mode'] ?? 'multi' }}"
    @if(isset($form['extra_data']))
        :extra-data="{{ $form['extra_data'] ?? '{}'  }}"
    @endif
    @if(isset($form['options']))
        search-url="{{ url( $form['options']['url'] ?? '' )  }}"
    @endif
    @if(isset($form['param']))
        search-url="{{ url( $form['param']['url'] ?? '' )  }}"
    @endif
></user-selector-list>

{{--@if(env('SKIP_VALIDATION', false) == false)--}}
{{--            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>--}}
{{--    </validation-provider>--}}
{{--@endif--}}
