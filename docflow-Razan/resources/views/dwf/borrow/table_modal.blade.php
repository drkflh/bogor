
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
            {!! Former::text('boxIdInput', 'Box ID')->v_model('boxIdInput') !!}
        </div>
    </b-modal>

