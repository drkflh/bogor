
    <b-modal
            id="printLabelModal"
            @ok="printLabelContent"
            ok-title="Print"
            title="Print Label"
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
