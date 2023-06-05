<?php
    $is_inline = isset($form['inline']) && $form['inline'] == true ? true : false;
    $has_prepend = true;
    $has_append = false;
?>
@if( $is_inline )
    <div class="form-row mt-2">
@endif
@if($label != '')
    <label for="{{ $form['model'] }}" class="{{ $form['label_class'] ?? '' }}" >{{ __($label) }}</label>
@endif
    @if($has_prepend || $has_append)
        <div class="input-group">
    @endif
        @if($has_prepend)
            <div class="input-group-prepend">
                    <b-form-select
                        style="width: 60px;min-width: 55px;"
                        v-model="{{ $form['model'].'Country' }}"
                        :options="mobileCountryOptions"
                        class="{{ $form['select_class'] ?? '' }} {{ $is_inline ? 'ml-2':'' }}"
                    @if( isset($form['addon_item_change']) && $form['addon_item_change'] == true )
                        @change="{{ $form['addon_item_change'] }}"
                    @endif
                    ></b-form-select>
            </div>
        @endif
@if(env('SKIP_VALIDATION', false) == false)
    <validation-provider rules="{{ $form['validator'] ?? '' }}" v-slot="{ errors }" name="{{ strtolower($label) }}">
@endif
        <input type="text"
            name="{{ $form['model'] }}"
            v-model="{{ $form['model'] }}"
            class="form-control text-left {{ $has_prepend || $is_inline ? 'ml-2':'' }} {!! $form['class'] ?? '' !!}"
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
@if( $is_inline )
    </div>
@endif
