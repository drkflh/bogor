
    <b-modal
            id="printLabelModal"
            @ok="printLabelContent"
            ok-title="Print"
            title="Print Card"
            scrollable
            centered
            :hide-backdrop="false"
            modal-class="modal-bv" >
        <div id="printedLabelContent">
            <active-view
                    :content="printLabelData"
                    :template="printTemplate"
            >
            </active-view>
        </div>
    </b-modal>


    <b-modal
            id="quickEnrollModal"
            @ok="doQuickEnroll"
            ok-title="Save"
            title="Quick Enroll"
            scrollable
            centered
            :hide-backdrop="false"
            modal-class="modal-bv" >
        <div id="quickEnrollForm">
            {!! Former::text('firstName', 'First Name')->v_model('firstName') !!}
            {!! Former::text('lastName', 'Last Name')->v_model('lastName') !!}
            {!! Former::text('mobile', 'Mobile')->v_model('mobile') !!}
            {!! Former::text('email', 'Email')->v_model('email') !!}
        </div>
    </b-modal>

