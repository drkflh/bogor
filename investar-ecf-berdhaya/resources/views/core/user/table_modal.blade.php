
<button-modal-pin-ajax
    ref="changeMobileStatusModal"
    ok-title="OK"
    :no-button="true"
    button-text="Verify Mobile"
    button-text-class=""
    button-class="btn btn-primary"
    action-url="{{ url( 'halal/mobile/verify' ) }}"
    :object-default="mobileStatusChangeObjDef"
    content=""
    :template="mobileStatusChangeTemplate"
    modal-size="md"
    @hidden="mobileStatusChangeHidden"
    @shown="mobileStatusChangeShown"

    handle="{{ \Illuminate\Support\Str::random(5) }}"
    modal-id="{{ \Illuminate\Support\Str::random(5) }}"
>

</button-modal-pin-ajax>
<button-modal-pin-ajax
    ref="changeEmailStatusModal"
    ok-title="OK"
    :no-button="true"
    button-text="Verify Email"
    button-text-class=""
    button-class="btn btn-primary"
    action-url="{{ url( 'halal/email/verify' ) }}"
    :object-default="emailStatusChangeObjDef"
    content=""
    :template="emailStatusChangeTemplate"
    modal-size="md"
    @hidden="emailStatusChangeHidden"
    @shown="emailStatusChangeShown"

    handle="{{ \Illuminate\Support\Str::random(5) }}"
    modal-id="{{ \Illuminate\Support\Str::random(5) }}"
>

</button-modal-pin-ajax>
<button-modal-pin-ajax
    ref="changeBidStatusModal"
    ok-title="OK"
    :no-button="true"
    button-text="Change Bid Status"
    button-text-class=""
    button-class="btn btn-primary"
    action-url="{{ url( 'sms/sales-operation/job-register/chg-stat' ) }}"

    content=""

    modal-size="md"
    @hidden="bidStatusChangeHidden"
    @shown="bidStatusChangeShown"

    handle="{{ \Illuminate\Support\Str::random(5) }}"
    modal-id="{{ \Illuminate\Support\Str::random(5) }}"
>

</button-modal-pin-ajax>
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

