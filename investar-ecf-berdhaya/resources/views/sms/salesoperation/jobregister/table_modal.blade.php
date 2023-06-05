<button-modal-pin-ajax
    ref="changeBidStatusModal"
    ok-title="OK"
    :no-button="true"
    button-text="Change Bid Status"
    button-text-class=""
    button-class="btn btn-primary"
    action-url="{{ url( 'sms/sales-operation/job-register/chg-stat' ) }}"
    :object-default="bidStatusChangeObjDef"
    content=""
    :template="bidStatusChangeTemplate"
    modal-size="md"
    @hidden="bidStatusChangeHidden"
    @shown="bidStatusChangeShown"

    handle="{{ \Illuminate\Support\Str::random(5) }}"
    modal-id="{{ \Illuminate\Support\Str::random(5) }}"
>

</button-modal-pin-ajax>

<button-modal-pin-ajax
    ref="changeJobStatusModal"
    ok-title="OK"
    :no-button="true"
    button-text="Change Job Status"
    button-text-class=""
    button-class="btn btn-primary"
    action-url="{{ url( 'sms/sales-operation/job-register/chg-stat' ) }}"
    :object-default="jobStatusChangeObjDef"
    content=""
    :template="jobStatusChangeTemplate"
    modal-size="md"
    @hidden="jobStatusChangeHidden"
    @shown="jobStatusChangeShown"

    handle="{{ \Illuminate\Support\Str::random(5) }}"
    modal-id="{{ \Illuminate\Support\Str::random(5) }}"
>

</button-modal-pin-ajax>

<button-modal-pin-ajax
    ref="changeJobRemarkModal"
    ok-title="OK"
    :no-button="true"
    button-text="Add Progress Remark"
    button-text-class=""
    button-class="btn btn-primary"
    action-url="{{ url( 'sms/sales-operation/job-register/chg-remark' ) }}"
    :object-default="jobRemarkChangeObjDef"
    content=""
    :template="jobRemarkChangeTemplate"
    modal-size="md"
    @hidden="jobRemarkChangeHidden"
    @shown="jobRemarkChangeShown"

    handle="{{ \Illuminate\Support\Str::random(5) }}"
    modal-id="{{ \Illuminate\Support\Str::random(5) }}"
>

</button-modal-pin-ajax>

<b-modal id="historyLogModal"
         size="md"
         centered
         no-close-on-backdrop
         no-close-on-esc
         @ok="hideLogModal"
         ok-title="Close"
         cancel-title="Close"
         @hidden="logModalHidden"
         @shown="logModalShown"
         modal-class="modal-bv"
         :hide-footer="true"
         style="min-height: 300px;"
>
    <template v-slot:modal-header="{ close }">
            <span class="modal-title" >
                            <h4 style="margin-bottom: 0px;" v-html="logModalTitle()"  ></h4>
            </span>
        <!-- Emulate built in modal header close button action -->
        <b-button size="sm" variant="outline-secondary" pill @click="close()">
            <b-spinner small v-show="isLoading" label="Loading..."></b-spinner>
            <i v-show="!isLoading" class="fa fa-times"></i>
        </b-button>
    </template>
    <template v-slot:modal-footer >
        {{--            <button class="btn btn-outline-danger" pill @click="hideLogModal()">--}}
        {{--                <i class="fa fa-times" ></i> Close--}}
        {{--            </button>--}}
    </template>
    <approval-time-line
        v-model="docHistory"
    ></approval-time-line>

</b-modal>
