<b-modal id="changePasswordModal"
         no-close-on-backdrop
         no-close-on-esc
         @ok.prevent="commitChangePassword"
         ok-title="Change Password"
         size="md"
         centered
         scrollable
         title="Change Password"
         modal-class="modal-bv">
    <div class="row" id="changePassForm">
        <div class="col-12">
            <validation-observer v-slot="{ invalid }" ref="changePassForm">
                <validation-provider rules="required|min:8" v-slot="{ errors }" name="New Password" vid="new_password" >
                    <label for="password">Password</label>
                    <input class="form-control" ref="new_password"   v-model="new_password" id="new_password" type="password" name="new_password">
                    <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
                </validation-provider>
                <validation-provider rules="required|confirmed:new_password" v-slot="{ errors }" name="Password confirmation" data-vv-as="password" >
                    <label for="new_confirm_password">Confirm Password</label>
                    <input class="form-control" ref="new_confirm_password" v-model="new_confirm_password" id="new_confirm_password" type="password" name="new_confirm_password" >
                    <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
                </validation-provider>
            </validation-observer>
        </div>
    </div>
</b-modal>

<b-modal id="changePinModal"
         no-close-on-backdrop
         no-close-on-esc
         @ok.prevent="commitChangePin"
         size="md"
         centered
         scrollable
         title="Change Pin"
         modal-class="modal-bv">
    <div class="row" id="changePinForm">
        <div class="col-12">
            <validation-observer v-slot="{ invalid }" ref="changePinForm">
                <validation-provider rules="required|min:6" v-slot="{ errors }" name="new_pin" vid="new_pin" >
                    <p class="mt-2">PIN</p>
                        <pin-input
                            v-model="new_pin"
                            name="new_pin"
                            num-inputs="6"
                            input-type="password"
                            separator=""
                        >
                    </pin-input>
                    <div style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
                </validation-provider>
                <validation-provider rules="required|confirmed:new_pin" v-slot="{ errors }" name="Confirm PIN">
                    <p class="mt-2">Confirm PIN</p>
                        <pin-input
                            v-model="new_confirm_pin"
                            name="new_confirm_pin"
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

