<?php
    $is_inline = isset($form['inline']) && $form['inline'] == true ? true : false;
    $has_prepend = isset($form['prepend']) && $form['prepend'] == true ? true : false;
    $has_append = isset($form['append']) && $form['append'] == true ? true : false;
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
        <select-2
            v-model="{{ $form['model'] }}"

            :options="{{ $form['select_options'] ?? $form['model'].'Options'  }}"

            :settings="{ width: '100%' , multiple : {{ isset($form['multiple']) && $form['multiple'] ? 'true':'false'  }} }"

            @if( isset($form['disabled']) && $form['disabled'] != '' )
                :disabled="{{ $form['disabled'] }}"
            @endif

            class="{{ $has_prepend || $is_inline ? 'ml-2':'' }} {!! $form['class'] ?? '' !!}"

            @if( isset($form['on_item_change']) && $form['on_item_change'] == true )
                @change="{{ $form['on_item_change'] }}"
            @endif
            @if(isset($form['attr']) && is_array($form['attr']))
                @foreach($form['attr'] as $att=>$v)
                    {{ $att }}="{{ $v }}"
                @endforeach
            @endif
        ></select-2>
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
