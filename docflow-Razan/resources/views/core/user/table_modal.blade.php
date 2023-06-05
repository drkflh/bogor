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
                <validation-provider rules="required" v-slot="{ errors }" name="new_password">
                    <label>New Password</label>
                    <input type="password" class="form-control" v-model="new_password" />
                    <div style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
                </validation-provider>
                <validation-provider rules="required" v-slot="{ errors }" name="new_confirm_password">
                    <label>Confirm New Password</label>
                    <input type="password" class="form-control" v-model="new_confirm_password" />
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
                            v-model="new_pin"
                            name="new_pin"
                            num-inputs="6"
                            input-type="password"
                            separator=""
                            v-validate="'digits:6'"
                        >
                    </pin-input>
                    <div style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
                </validation-provider>
                <validation-provider rules="required" v-slot="{ errors }" name="confirm_pin">
                    <p class="mt-2">Confirm PIN</p>
                        <pin-input
                            v-model="new_confirm_pin"
                            name="new_confirm_pin"
                            num-inputs="6"
                            input-type="password"
                            separator=""
                            v-validate="'digits:6'"
                        >
                    </pin-input>
                    <div style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
                </validation-provider>
            </validation-observer>

        </div>
    </div>
</b-modal>

