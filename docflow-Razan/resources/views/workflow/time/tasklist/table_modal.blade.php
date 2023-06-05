<b-modal
id="changeStatModal"
@ok="doChangeStat"
ok-title="Save"
title="Change Status"
scrollable
centered
:hide-backdrop="false"
modal-class="modal-bv" >
<div id="changeStatForm">
<validation-observer v-slot="{ invalid }" ref="changeStatForm">
    <p>Status</p>
    <b-form-select
    name="status"
    v-model="status"
    :options="progressStatusOptions"
    ></b-form-select>
    <validation-provider rules="required" v-slot="{ errors }" name="note">
        {!! Former::textarea('note', 'Note')->v_model('note') !!}
        <div style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
    </validation-provider>
    <p class="mt-2">PIN</p>
        <pin-input
        v-model="pin"
        num-inputs="6"
        input-type="password"
        separator=""
    >
    </pin-input>

</validation-observer>
</div>
</b-modal>
