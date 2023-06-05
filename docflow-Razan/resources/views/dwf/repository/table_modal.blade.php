
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

    <b-modal
        id="scanLinkModal"
        @ok="scanDirectory"
        ok-title="Scan & Link"
        title="Scan Directory & Link Document"
        scrollable
        centered
        :hide-backdrop="false"
        modal-class="modal-bv" >
        <div id="scanDirDialog">
            <div class="row">
                <div class="col-3">
                    {!! Former::select('scanMode', '')->options(['copy'=>'copy','move'=>'move'])->v_model('scanMode') !!}
                </div>
                <div class="col-8" style="display: table;height: 35px;">
                    <span style="display: table-cell;vertical-align: bottom;">
                        from
                    </span>
                </div>
                <div class="col-1">
                    <b-spinner v-show="scanning"></b-spinner>
                </div>
            </div>
            {!! Former::text('sourceDir', 'Source Directory')->v_model('sourceDir') !!}
        </div>
    </b-modal>
