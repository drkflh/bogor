
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


    <b-modal
            id="boxIdModal"
            @ok="setBoxId"
            ok-title="Print"
            title="Set Box"
            scrollable
            centered
            :hide-backdrop="false"
            modal-class="modal-bv" >
        <div id="printedLabelContent">
            Selected Sheets : @{{ selectedSheets }} sheets<br/>
            <input type="text" class="form-control" v-model="boxIdInput" ></input>
        </div>
    </b-modal>
