@if( $label && $label != '' )
    <label for="{{ $form['model'] }}" >{{ $label }}</label><br>
@endif
<br>
@if(env('SKIP_VALIDATION', true ))
    <vue-tel-input
        v-model="{{ $form['model'] }}"
        mode="international"
    >
    </vue-tel-input>
@else
    <validation-provider rules="{{ $form['validator'] ?? '' }}" v-slot="{ errors }" name="{{ strtolower($form['model']) }}">
        <vue-tel-input
            v-model="{{ $form['model'] }}"
            mode="international"
            default-country="ID"
            :auto-format="true"
            :only-countries="['ID','SG','MY']"
            :disabled-formatting="false"
            :enabled-country-code="true"
            :show-dial-code="false"
            :input-options="{ 'showDialCode' : false }"
            :dropdown-options="{ 'disabled' : false ,'showDialCodeInSelection' : false, 'showFlags' : true }"
        >
            <template v-slot:arrow-icon>
                <span>@{{ open ? '▲' : '▼' }}</span>
            </template>
        </vue-tel-input>
        <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
    </validation-provider>
@endif
<br>
