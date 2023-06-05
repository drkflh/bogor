@if($label != '')
    <label for="{{ $form['model'] }}" style="display:block;" >{{ __($label) }}</label><br>
@endif
@if(env('SKIP_VALIDATION', false) == false)
    <validation-provider rules="{{ $form['validator'] ?? '' }}" v-slot="{ errors }" name="{{ strtolower($label) }}">
@endif
        <a-range-picker
            v-model="{{ $form['model'] }}"
            value-type="YYYY-MM-DD HH:mm:ss"
            :placeholder="['{{ env('DATE_FORMAT', 'DD-MMM-YYYY' ) }}','{{ env('DATE_FORMAT', 'DD-MMM-YYYY' ) }}']"
            @if(isset($form['value_format']))
                value-format="{{ $form['value_format']  }}"
            format="{{ $form['value_format']  }}"
            @else
                format="{{ env('DATE_FORMAT', 'DD-MMM-YYYY' ) }}"
            @endif
            @if(isset($form['show_time']))
                :show-time="{{ $form['show_time']  }}"
            @endif
            @if(isset($form['date_constraint']))
                :disabled-date="{!! $form['date_constraint'] !!}"
            @endif
        >
        </a-range-picker>

@if(env('SKIP_VALIDATION', false) == false)
            <div style="color: rgba(189, 61, 61, 0.839)">@{{ ( !_.isEmpty(errors) )? errors[0] : '' }}</div>
    </validation-provider>
@endif

<div style="float: none;"></div>

