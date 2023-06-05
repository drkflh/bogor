@if(env('SKIP_VALIDATION', true ))
    <simple-list-input-modal
            label="{{ $label }}"
            modal-id="{{ \Illuminate\Support\Str::random(5) }}"
            :items="{{ $form['model'] }}"
            :object-default="{!!  $form['model'].'ObjDef' ?? '' !!}"
            :cols="{{ $form['model'].'Fields' }}"
            :template="{{ $form['model'].'Template' }}"
            :content="{{ $form['model'].'Content' }}"
            :params="{{ $form['model'].'Params' }}"
            @if( isset($form['hide_add_button']) && $form['hide_add_button'] == true )
                hide-add-button
            @endif
            @if( isset($form['show_table_header']) && $form['show_table_header'] == true )
                show-table-header
            @endif
            @if( isset($form['ordered']) && $form['ordered'] == true )
                ordered
            @endif
    >
    </simple-list-input-modal>
@else
    <validation-provider rules="{{ $form['validator'] ?? '' }}" v-slot="{ errors }" name="{{ strtolower($label) }}">
        <simple-list-input-modal
            label="{{ $label }}"
            modal-id="{{ \Illuminate\Support\Str::random(5) }}"
            :items="{{ $form['model'] }}"
            :object-default="{!!  $form['model'].'ObjDef' ?? '' !!}"
            :cols="{{ $form['model'].'Fields' }}"
            :template="{{ $form['model'].'Template' }}"
            :content="{{ $form['model'].'Content' }}"
            :params="{{ $form['model'].'Params' }}"
            @if( isset($form['hide_add_button']) && $form['hide_add_button'] == true )
                hide-add-button
            @endif
            @if( isset($form['show_table_header']) && $form['show_table_header'] == true )
                show-table-header
            @endif
            @if( isset($form['ordered']) && $form['ordered'] == true )
                ordered
            @endif
            >
        </simple-list-input-modal>
        <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
    </validation-provider>
@endif
