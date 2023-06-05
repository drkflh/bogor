<template>
    <div style="display:inline-block;">
        <button v-if="!noButton" v-on:click="openModal()"
                :class="buttonClass"
                :disabled="buttonDisabled"
                style="height:fit-content; margin: 0px ; cursor: pointer; padding: 8px;">
            <i :class="iconClass"> </i><span v-html="buttonText" :class="buttonTextClass"></span>
        </button>

        <b-modal id="approvalDocViewModal"
            size="xl"
                 ok-disabled
                 hide-footer
        >
            <template v-slot:modal-header="{ close }">
                <h4 class="modal-title" v-html="getTitle()"></h4>
                <!-- Emulate built in modal header close button action -->
                <b-button size="sm" variant="outline-secondary" pill @click="closeDocViewModal()">
                    <b-spinner small v-show="isLoading" label="Loading..."></b-spinner>
                    <i v-show="!isLoading" class="las la-times"></i>
                </b-button>
            </template>
            <div style="display: block;height: 100%;">
                <div class="row">
                    <div class="col-12">
                        <div id="printedItemContentFrame"
                             style="height: 100%; min-height: 500px;overflow: auto;"
                        >
                            <iframe
                                :src="docUrl"
                                id="pdf-view-iframe"
                                style="height:100%;width: 100%; min-height: 600px;border:none"
                            >
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>

        </b-modal>


        <b-modal :id="modalId"
                 @ok="addItem"
                 :ok-title="okTitle"
                 :size="modalSize"
                 :title="getModalTitle()"
                 no-close-on-esc
                 no-close-on-backdrop
                 scrollable
                 :hide-backdrop="hideBackdrop"
                 @hidden="onHidden"
                 @shown="onShown">

            <template v-slot:modal-header="{ close }">
                <h4 class="modal-title" v-html="getModalTitle()"></h4>
                <!-- Emulate built in modal header close button action -->
                <b-button size="sm" variant="outline-secondary" pill @click="closeModal()">
                    <b-spinner small v-show="isLoading" label="Loading..."></b-spinner>
                    <i v-show="!isLoading" class="las la-times"></i>
                </b-button>
            </template>

            <div class="row">
                <div class="col-6">
                    <active-view
                        :template="template"
                        :content="content"
                    ></active-view>
                </div>
                <div class="col-6">
                    <div style="display: block;height: 100%;">
                        <button class="btn btn-primary w-100" @click="openDocView" >
                            <i class="las la-eye" ></i> View Doc
                        </button>
                        <div class="row mt-1">
                            <div class="col-12">
                                <div class="form-row mt-2">
                                    <label>Change Date</label>
                                    <input type="text"
                                           :disabled="true"
                                           name="value.changeDate"
                                           v-model="changeDate"
                                           class="form-control ml-2 text-150"
                                           placeholder=""
                                    >
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-row mt-2">
                                    <label>Change By</label>
                                    <input type="text"
                                           :disabled="true"
                                           name="value.changeDate"
                                           v-model="changeBy"
                                           class="form-control ml-2 text-150"
                                           placeholder=""
                                    >
                                </div>
                            </div>
                            <div class="col-12">
                                <label>Change Status To</label>
                                <validation-provider rules="" v-slot="{ errors }" name="changestatusto">
                                    <b-form-group>
                                        <b-form-radio-group id="radio-group-changeStatusTo"
                                                            v-model="changeStatusTo"
                                                            name="changeStatusTo">
                                            <b-form-radio v-for="p in changeStatusToOptions"
                                                          :key="p.value" :value="p.value">{{ p.text }}
                                            </b-form-radio>
                                        </b-form-radio-group>
                                    </b-form-group>
                                    <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">
                                        {{ errors[0] }}
                                    </div>
                                </validation-provider>

                                <label for="changeRemarks" class="">Remarks</label>
                                <validation-provider rules="" v-slot="{ errors }" name="remarks">
                                            <textarea
                                                name="changeRemarks"
                                                v-model="changeRemarks"
                                                class="form-control  "
                                                placeholder=""
                                            >
                                            </textarea>
                                    <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">
                                        {{ errors[0] }}
                                    </div>
                                </validation-provider>
                            </div>
                            <div v-if="showSignPad" class="col-12">
                                <label for="approvalSignature">Signature</label><br>
                                <signature-card-upload
                                    name="approvalSignature"
                                    v-model="approvalSignature"
                                    :handle="handle"
                                    ns="approvalSignature"
                                    :uploadurl="uploadurl"
                                    :sign-upload-url="signUploadUrl"
                                    :hide-upload-button="true"
                                    bucket="signature"
                                    :defaulturl="signaturedefaulturl"
                                    mode="single"
                                    buttonlabel="Upload ID Picture"

                                    :sign-width="signWidth"
                                    :sign-height="signHeight"
                                    :sign-ref="signRef"
                                    :sign-handle="handle"
                                    sign-ns="signature"

                                    :specimen="signatureSpecimen"
                                >

                                </signature-card-upload>
                            </div>
                            <hr>
                            <div class="col-12"  >
                                <label for="pinAuth">PIN</label>
                                <div class="d-flex justify-content-center" >
                                    <pin-input
                                        v-model="pinAuth"
                                        ref-key="pinAuth"
                                        num-inputs="6"
                                        input-type="password"
                                        separator=""
                                    >
                                    </pin-input>
                                    <div class="error" v-html="authError"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </b-modal>

    </div>
</template>

<script>
export default {
    name: "ButtonSingleApprovalPinAjax",
    props: {
        item: {
            type: [String, Object, Array, Boolean],
            default: ''
        },
        changeStatusToOptions: {
            type: Array,
            default: function(){ return [] }
        },
        actionUrl: {
            type: String,
            default: 'api/v1/core/upload'
        },
        handle: {
            type: String
        },
        buttonDisabled: {
            type: [String, Boolean],
            default: false
        },
        buttonText: {
            type: String,
            default: 'Add Item'
        },
        buttonTextClass: {
            type: String,
            default: ''
        },
        buttonClass: {
            type: String,
            default: 'Add Item'
        },
        noButton: {
            type: Boolean,
            default: false
        },
        iconClass: {
            type: String,
            default: 'las la-plus-circle'
        },
        okTitle: {
            type: String,
            default: 'OK'
        },
        content: {
            type: [String, Object, Array]
        },
        params: {
            type: [String, Object, Array]
        },
        template: {
            type: [String, Object, Array]
        },
        objectDefault: {
            type: [String, Object, Array],
            default: function () {
                return {}
            }
        },
        hideAddButton: {
            type: Boolean,
            default: false
        },
        modalId: {
            type: String,
            default: 'spiModal'
        },
        modalSize: {
            type: String,
            default: 'lg'
        },
        splitComma: {
            type: Boolean,
            default: true
        },
        extraData: {
            type: [Object, Array, String],
            default: function () {
                return {};
            }
        },
        ns: {
            type: String,
            default: 'doc'
        },
        pinNumInputs: {
            type: Number,
            default: 6
        },
        pinInputType: {
            type: String,
            default: 'password'
        },
        pinSeparator: {
            type: String,
            default: ''
        },
        signatureSpecimen: {
            type: String,
            default: ''
        },
        initialSpecimen: {
            type: String,
            default: ''
        },
        showSignPad: {
            type: Boolean,
            default: function () {
                return true;
            }
        },
        uploadurl: {
            type: String,
            default: 'api/v1/core/upload'
        },
        signUploadUrl: {
            type: String,
            default: 'api/v1/core/form-upload'
        },
        loadItemUrl: {
            type: String,
            default: 'api/v1/core/form-upload'
        },
        viewItemUrl: {
            type: String,
            default: 'api/v1/core/form-upload'
        },
        viewItemIdField: {
            type: String,
            default: '_id'
        },
        signaturedefaulturl: {
            type: String,
            default: ''
        },
        signWidth: {
            type: String,
            default: '100%'
        },
        signHeight: {
            type: String,
            default: '200px'
        },
        signRef: {
            type: String,
            default: 'signRef'
        },
        signHandle: {
            type: String,
            default: 'signPadHandle'
        },
        signNs: {
            type: String,
            default: 'signPad'
        },
        selectedDoc: {
            type: [Object, Array],
            default: function(){ return {} }
        }

    },
    data: function () {
        return {
            mode: '',
            editIndex: 0,
            editObj: _.cloneDeep(this.objectDefault),
            showModal: false,
            showPad: false,
            titleData: '',
            hideBackdrop: false,
            isLoading: false,
            pinAuth: '',
            authError: '',
            auxData: {},

            approvalSignature: '',
            approvalInitial: '',
            signType: 'signature',
            changeBy: '',
            changeDate: '',
            changeStatusTo: '',
            currentStatus: '',
            changeRemarks: '',
            docUrl:  '',
            docList: [],
            selectedApprovalItems: []
        };
    },
    watch: {
        selectedDoc: function(doc){
              this.viewDoc(doc);
        },
    },
    methods: {
        setModalClass(){
            if(this.modalSize == 'fs'){
                return 'modal-fullscreen'
            }
            if(this.modalSize == 'md'){
                return 'modal-md'
            }
            return 'modal-bv';
        },
        setModalSize(){
            if(this.modalSize == 'fs'){
                return ''
            }
            if(this.modalSize == 'md'){
                return ''
            }
            return this.modalSize;
        },
        viewDoc(doc){
            console.log(doc);
            let url = this.viewItemUrl + '/' + _.get( doc, this.viewItemIdField ) ;
            this.docUrl = url;
        },
        loadApprovalItems(){
            console.log('request approval');
                axios.post( this.loadItemUrl,
                    {
                        tz: window.tz
                    }
                )
                .then((response) => {
                    this.isLoading = false;
                    if(response.data.result == 'OK' ){
                        this.docList = response.data.data;
                    }else{
                        alert(response.data.message);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                    this.isLoading = false;
                    if(error.response.status == 401){
                        var d = new Date();
                        alert('Your session is expired. Please re-login');
                    }
                });
        },
        save() {
            var _this = this;

            var ts = Date.now() / 1000;

            var formData = new FormData();
            formData.append('handle', this.handle);
            formData.append('m', this.mode);
            formData.append('ns', this.ns);

            formData.append('aux', JSON.stringify(this.auxData));
            formData.append('auxOverrides', this.auxOverrides);
            formData.append('resultGroupBy', this.resultGroupBy);

            let data = {
                editObj : this.editObj,
                pinAuth : this.pinAuth,
                approvalSignature : this.approvalSignature,
                approvalInitial : this.approvalInitial,
                signType : this.signType,
                decideAs : this.decideAs,
                changeBy : this.changeBy,
                changeDate : this.changeDate,
                changeStatusTo : this.changeStatusTo,
                currentStatus : this.currentStatus,
                changeRemarks : this.changeRemarks,
                docUrl : this.docUrl,
                docList : this.docList,
                selectedApprovalItems : [this.selectedDoc],
            };

            let formObject = {};
            formObject.data = data;
            formObject.ns = this.ns;
            formObject.handle = this.handle;
            formObject.mode = this.mode;
            formObject.ts = ts;
            formObject.extraData = this.extraData;
            formObject.auth = this.pinAuth;
            formObject.aux = this.auxData;
            formObject.auxOverrides = this.auxOverrides;
            formObject.resultGroupBy = this.resultGroupBy;

            this.isLoading = true;

            axios.post(
                this.actionUrl,
                formObject
            ).then(response => {
                this.isLoading = false;
                if (response.data.result == 'OK') {
                    this.$emit('update:item', this.editObj);
                    this.closeModal();
                } else if (response.data.result == 'AUTHERR' || response.status == 402) {
                    this.authError = 'Wrong PIN';
                } else {
                    alert(response.data.message);
                }

            })
                .catch(e => {
                    if (e.response.status == 402) {
                        this.authError = 'Wrong PIN';
                    } else {
                        alert(e.toString());
                    }
                    this.isLoading = false;
                });
        },
        clear() {
            this.mode = '';
            this.editIndex = 0;
            this.editObj = _.cloneDeep(this.objectDefault);
            this.showModal = false;
            this.showPad = false;
            this.titleData = '';
            this.hideBackdrop = false;
            this.isLoading = false;
            this.pinAuth = '';
            this.authError = '';
            this.auxData = {};
            this.approvalSignature = '';
            this.approvalInitial = '';
            this.signType = 'signature';
            this.decideAs = 'Approve';
            this.changeBy = '';
            this.changeDate = '';
            this.changeStatusTo = '';
            this.currentStatus = '';
            this.changeRemarks = '';
            this.docUrl =  '';
            this.docList = [];
            this.selectedApprovalItems = []
        },
        getTitle() {
            return this.buttonText;
        },
        getModalTitle() {
            return this.titleData;
        },
        setTitleData(val) {
            this.titleData = val;
        },
        setAuxData(obj) {
            this.auxData = obj;
            this.showSignPad = _.get( obj, 'signpad', true );
            this.decideAs = _.get( obj, 'decideas', true );
            this.changeBy = _.get( obj, 'approver', true );
            this.changeDate = _.get( obj, 'changedate', true );
        },
        setData(obj) {
            console.log('rowdata', obj);
            _.forEach(obj, (value, key) => {
                _.set(this.editObj, key, value);
            });
            console.log('roweditata', this.editObj);
        },
        clearData() {
            this.auxData = {};
        },
        closeModal() {
            this.editIndex = 0;
            this.editObj = _.cloneDeep(this.objectDefault);
            this.$bvModal.hide(this.modalId);
        },
        toggleSignPad() {
            this.showPad = !this.showPad;
        },
        checkProperties(obj) {
            if(this.showSignPad){

            }else{
                this.approvalSignature = 'specimen';
            }
            for (var key in obj) {
                if (obj[key] !== null && obj[key] !== "") {
                    return {
                        valid : false,
                        message : key + ' is empty'
                    };
                }
            }
            return {
                valid : true,
                message : 'all valid'
            };
        },
        isExist(val) {
            return !(_.isNull(val) || _.isUndefined(val))
        },
        isPathExist(val, path) {
            return !(_.isNull(val) || _.isUndefined(val) || _.has(val, path))
        },
        addItem(event) {
            event.preventDefault();
            if (this.pinAuth == '') {
                this.authError = 'Empty PIN'
                return;
            }

            if (this.pinAuth < 6) {
                this.authError = 'PIN should be 6 digit number';
                return;
            }

            var validation = this.checkProperties(this.editObj)
            var tempObj = this.objectDefault;
            if (!validation.valid) {
                alert('Empty data !')
                event.preventDefault();
                return;
            } else {
                this.save();
            }
        },
        onHidden() {
            this.$emit('hidden');
        },
        onShown() {
            this.$emit('shown');
        },
        isEmpty(obj) {
            for (var key in obj) {
                if (obj.hasOwnProperty(key))
                    return false;
            }
            return true;
        },
        setObject(obj) {
            this.editObj = {};
            this.editObj = _.cloneDeep(obj);
        },
        openModal() {
            this.mode = 'Create';
            this.editObj = {};
            this.editObj = _.cloneDeep(this.objectDefault);
            this.showModal = true;
            this.$bvModal.show(this.modalId);
        },
        openDocView() {
            this.$bvModal.show('approvalDocViewModal');
        },
        closeDocViewModal(){
            this.$bvModal.hide('approvalDocViewModal');
        },
        saveSplit(str) {
            if (_.isString(str)) {
                if (_.isString(str) != '') {
                    var arr = str.split(',');
                    if (_.isArray(arr)) {
                        return arr
                    } else {
                        return []
                    }
                }
            } else {
                return []
            }
        },
        commaToSpace(str) {
            var sp = this.saveSplit(str);
            return _.isArray(sp) ? sp.join(" ") : str;
        }
    }
}
</script>

<style scoped>
.modal-bv {
    z-index: 10050 !important;
}

td, td div {
    white-space: nowrap;
    vertical-align: top;
    text-overflow: ellipsis;
    overflow: hidden;
}

</style>
