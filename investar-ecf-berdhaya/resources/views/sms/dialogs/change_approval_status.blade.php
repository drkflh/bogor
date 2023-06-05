<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-md-8 col-sm-12 d-none d-md-inline-block">
                <div id="printedItemContentFrame" style="height: 100%; min-height: 500px;overflow: auto;">
                    <iframe :src="value.pdfDocUrl" id="pdf-view-iframe"
                            style="height:100%;width: 100%; min-height: 600px;border:none"></iframe>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="row">
                    <div class="col-12" style="height: 300px;overflow: auto;" >
                        <b-list-group class="p-1">
                            <b-form-checkbox-group
                                id="checkbox-approval-item"
                                v-model="value.selectedApprovalItems"
                                name="checkbox-approval-item"
                            >
                            <b-list-group-item v-for="(it, key, idx) in value.pdfDocList" :key="it._id">
                                <div class="d-flex align-items-start">
                                    <b-form-checkbox :value="it._id" ></b-form-checkbox>
                                    <div class="d-flex flex-column p-0" >
                                        <h6 style="font-size: 11pt;margin-top:0px;">@{{ it.approvalTitle }}</h6>
                                        <p style="font-size: 10pt;margin-bottom:0px;">@{{ it.approvalDescription }}</p>
                                    </div>
                                </div>
                            </b-list-group-item>
                            </b-form-checkbox-group>
                        </b-list-group>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-12">
                        {!!  $changeStatusTo ?? '' !!}
                        {!!  $changeRemarks ?? '' !!}
                    </div>
                    <div v-if="value.signType == 'signature'" class="col-12">
                        {!! $approvalSignature !!}
                    </div>
                    <div v-if="value.signType == 'signature && showPad'"  class="col-12">
                        {!! $signatureInput !!}
                    </div>
                    <div v-if="value.signType == 'initial'" class="col-12">
                        {!! $approvalInitial !!}
                    </div>
                    <div v-if="value.signType == 'initial' && showPad" class="col-12">
                        {!! $initialInput !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
