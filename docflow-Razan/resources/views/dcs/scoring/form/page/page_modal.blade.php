<b-modal id="changePasswordModal"
         no-close-on-backdrop
         no-close-on-esc
         @ok="commitChangePassword"
         ok-title="Change Password"
         size="md"
         centered
         scrollable
         title="Change Password"
         modal-class="modal-bv">
    <div class="row" id="changePassForm">
        <div class="col-12">
            <validation-observer v-slot="{ invalid }" ref="changePassForm">
                <validation-provider rules="required" v-slot="{ errors }" name="password">
                    {!!  Former::password('password','Password')->v_model(  'password' ); !!}
                    <div style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
                </validation-provider>
                <validation-provider rules="required" v-slot="{ errors }" name="confirm_password">
                    {!!  Former::password('confirm_password','Confirm Password')->v_model(  'confirm_password' ); !!}
                    <div style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
                </validation-provider>
            </validation-observer>

        </div>
    </div>
</b-modal>

<b-modal id="changePinModal"
         no-close-on-backdrop
         no-close-on-esc
         @ok="commitChangePin"
         size="md"
         centered
         scrollable
         title="Change Pin"
         modal-class="modal-bv">
    <div class="row" id="changePinForm">
        <div class="col-12">
            <validation-observer v-slot="{ invalid }" ref="changePinForm">
                <validation-provider rules="required" v-slot="{ errors }" name="pin">
                    <p class="mt-2">PIN</p>
                        <pin-input
                        v-model="pin"
                        num-inputs="6"
                        input-type="password"
                        separator=""
                    >
                    </pin-input>
                    <div style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
                </validation-provider>
                <validation-provider rules="required" v-slot="{ errors }" name="confirm_pin">
                    <p class="mt-2">Confirm PIN</p>
                        <pin-input
                        v-model="confirm_pin"
                        num-inputs="6"
                        input-type="password"
                        separator=""
                    >
                    </pin-input>
                    <div style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
                </validation-provider>
            </validation-observer>

        </div>
    </div>
</b-modal>

