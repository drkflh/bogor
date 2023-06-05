<?php
    $is_inline = isset($form['inline']) && $form['inline'] == true ? true : false;
    $has_prepend = isset($form['prepend']) && $form['prepend'] == true ? true : false;
    $has_append = isset($form['append']) && $form['append'] == true ? true : false;
?>
@if( $is_inline )
    <div class="form-row mt-2">
@else
    <div style="display: block;">
@endif
@if($label != '')
    <label for="{{ $form['model'] }}"
            @if( !$is_inline )
                style="display: block !important;"
            @endif
    >{{ __($label) }}</label>
@endif
    @if($has_prepend || $has_append)
        <div class="input-group">
    @endif
        @if($has_prepend)
            <div class="input-group-prepend">
                @if($form['prepend'] == 'select')
                    <b-form-select
                        v-model="{{ $form['select_model'] }}"
                        :options="{{ $form['select_model'].'Options'  }}"
                        class="{{ $form['select_class'] ?? '' }} {{ $is_inline ? 'ml-2':'' }}"
                    @if( isset($form['addon_item_change']) && $form['addon_item_change'] == true )
                        @change="{{ $form['addon_item_change'] }}"
                    @endif
                    ></b-form-select>
                @else
                    <span class="input-group-text" >{{ $form['prepend'] }}</span>
                @endif
            </div>
        @endif
@if(env('SKIP_VALIDATION', false) == false)
    <validation-provider rules="{{ $form['validator'] ?? '' }}" v-slot="{ errors }" name="{{ strtolower($label) }}">
@endif
        <a-date-picker
            v-model="{{ $form['model'] }}"
            value-type="YYYY-MM-DD HH:mm:ss"
            placeholder="{{ env('DATE_FORMAT', 'DD-MMM-YYYY' ) }}"
            :input-read-only="false"
            class="{{ $has_prepend || $is_inline ? 'ml-2':'' }} {!! $form['class'] ?? '' !!}"
            @if(isset($form['value_format']))
                value-format="{{ $form['value_format']  }}"
                format="{{ $form['value_format']  }}"
            @else
            @if(isset($form['show_time']))
                value-format="YYYY-MM-DD HH:mm"
            @else
                value-format="YYYY-MM-DD"
            @endif
                format="{{ env('DATE_FORMAT', 'DD-MMM-YYYY' ) }}"
            @endif
            @if(isset($form['show_time']))
                :show-time="{!! $form['show_time']  !!}"
            @endif
            @if(isset($form['date_constraint']))
                :disabled-date="{!! $form['date_constraint'] !!}"
            @endif
        >
        </a-date-picker>
@if(env('SKIP_VALIDATION', false) == false)
        <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
    </validation-provider>
@endif
        @if($has_append)
            <div class="input-group-append">
                @if($form['append'] == 'select')
                    <b-form-select
                        v-model="{{ $form['select_model'] }}"
                        :options="{{ $form['select_model'].'Options'  }}"
                        class="{{ $form['select_class'] ?? '' }} ml-2"
                    @if( isset($form['addon_item_change']) && $form['addon_item_change'] == true )
                        @change="{{ $form['addon_item_change'] }}"
                    @endif
                    ></b-form-select>
                @else
                    <span class="input-group-text" >{{ $form['append'] }}</span>
                @endif
            </div>
        @endif

    @if($has_prepend || $has_append)
        </div>
    @endif
{{--@if( $is_inline )--}}
    </div>
{{--@endif--}}
