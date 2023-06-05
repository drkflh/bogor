<template>
    <div style="display:inline-block;">
        <image-card-upload
            name="signatureSpecimen"
            v-model="item"
            :handle="handle"
            ns="signatureSpecimen"
            uploadurl="uploadUrl"
            :hide-upload-button="true"
            defaulturl="defaulturl"
            mode="single"
            buttonlabel="Upload Signature File"
        >
        </image-card-upload>
        <button v-if="!noButton" v-on:click="openModal()"
                :class="buttonClass"
                :disabled="buttonDisabled"
                style="height:fit-content; margin: 0px ; cursor: pointer; padding: 8px;">
            <i :class="iconClass"> </i><span v-html="buttonText" :class="buttonTextClass"></span>
        </button>

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
                 @shown="onShown"
                 modal-class="modal-bv" >

            <template v-slot:modal-header="{ close }">
                <h4 class="modal-title" v-html="getTitle()" ></h4>
                <!-- Emulate built in modal header close button action -->
                <b-button size="sm" variant="outline-secondary" pill @click="closeModal()">
                    <b-spinner small v-show="isLoading" label="Loading..."></b-spinner>
                    <i v-show="!isLoading" class="las la-times"></i>
                </b-button>
            </template>

            <div style="display: block;">
                <sign-pad
                    ref="signaturePad"
                    v-model="item"
                    :specimen="specimen"
                    :handle="handle"
                    ns="signature"
                    uploadurl="signUrl"
                    mode="single"
                    width="100%"
                    height="200px"
                >
                </sign-pad>
            </div>
            <div style="display: block;padding-top: 25px;">
                <div class="form-row">
                    <label for="pinAuth">PIN</label>
                    <pin-input
                        v-model="pinAuth"
                        ref-key="pinAuth"
                        num-inputs="6"
                        input-type="password"
                        separator=""
                    >
                    </pin-input>
                </div>
                <div class="error" v-html="authError" ></div>
            </div>
        </b-modal>

    </div>
</template>

<script>
    export default {
        name: "ButtonModalSignPadAjax",
        props: {
            item: {
                type: [ String, Object, Array, Boolean ],
                default: ''
            },
            specimen : {
                type: String,
                default: ''
            },
            actionUrl : {
                type: String,
                default: 'api/v1/core/upload'
            },
            pinUrl : {
                type: String,
                default: '/auth/check-pin'
            },
            uploadUrl : {
                type: String,
                default: '/api/v1/core/upload'
            },
            signUrl : {
                type: String,
                default: '/api/v1/core/form-upload'
            },
            defaulturl : {
                type: String,
                default: '/images/default_256.jpg'
            },
            handle : {
                type: String
            },
            buttonDisabled: {
                type: [String, Boolean],
                default: false
            },
            buttonText : {
                type: String,
                default: 'Add Item'
            },
            buttonTextClass : {
                type: String,
                default: ''
            },
            buttonClass : {
                type: String,
                default: 'Add Item'
            },
            noButton : {
                type: Boolean,
                default: false
            },
            iconClass : {
                type: String,
                default: 'las la-plus-circle'
            },
            okTitle : {
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
            modalId : {
                type: String,
                default: 'spiModal'
            },
            modalSize: {
                type: String,
                default: ''
            },
            splitComma: {
                type: Boolean,
                default: true
            },
            extraData: {
                type: [Object, Array, String],
                default: function(){
                    return {};
                }
            },
            ns: {
                type: String,
                default: 'doc'
            },
            pinNumInputs : {
                type: Number,
                default: 6
            },
            pinInputType : {
                type: String,
                default: 'password'
            },
            pinSeparator : {
                type: String,
                default: ''
            }
        },
        data: function(){
            return {
                mode: '',
                editIndex: 0,
                editObj : _.cloneDeep(this.objectDefault),
                showModal : false,
                titleData : '',
                hideBackdrop : false,
                isLoading : false,
                pinAuth : '',
                authError : '',
                auxData : {}
            };
        },
        methods: {
            save(){
                var _this = this;

                var ts = Date.now() / 1000;

                var formData = new FormData();
                formData.append('handle', this.handle);
                formData.append('m', this.mode);
                formData.append('ns', this.ns);

                formData.append('aux', JSON.stringify(this.auxData));
                formData.append('auxOverrides', this.auxOverrides);
                formData.append('resultGroupBy', this.resultGroupBy);

                var formObject = {};
                formObject.data = _.cloneDeep( this.editObj );
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
                ).then( response => {
                    this.isLoading = false;
                    if(response.data.result == 'OK') {
                        this.$emit( 'update:item', this.editObj );
                        this.closeModal();
                    }else if(response.data.result == 'AUTHERR' || response.status == 402){
                        this.authError = 'Wrong PIN';
                    }else{
                        alert( response.data.message );
                    }

                })
                .catch( e =>{
                    if(e.response.status == 402){
                        this.authError = 'Wrong PIN';
                    }else{
                        alert( e.toString() );
                    }
                    this.isLoading = false;
                });
            },
            clear(){
            },
            getTitle(){
                return this.buttonText;
            },
            getModalTitle(){
                return this.buttonText + ' ' + this.titleData;
            },
            setTitleData(val){
                this.titleData = val;
            },
            setAuxData(obj){
                this.auxData = obj;
            },
            setData(obj){
                console.log('rowdata',obj);
                _.forEach( obj, (value, key)=>{
                    _.set(this.editObj, key, value );
                });
                console.log('roweditata',this.editObj);
            },
            clearData(){
                this.auxData = {};
            },
            closeModal(){
                this.editIndex = 0;
                this.editObj = _.cloneDeep(this.objectDefault);
                this.$bvModal.hide(this.modalId);
            },
            checkProperties(obj) {
                for (var key in obj) {
                    if (obj[key] !== null && obj[key] !== "") {
                        return false;
                    }
                }
                return true;
            },
            isExist(val){
                return !( _.isNull(val) || _.isUndefined(val))
            },
            isPathExist(val,path){
                return !( _.isNull(val) || _.isUndefined(val) || _.has(val,path))
            },
            addItem(event){
                event.preventDefault();
                if(this.pinAuth == ''){
                    this.authError = 'Empty PIN'
                    return;
                }

                if(this.pinAuth < 6){
                    this.authError = 'PIN should be 6 digit number';
                    return;
                }

                var validation = this.checkProperties(this.editObj)
                var tempObj = this.objectDefault;
                if(validation) {
                    alert('Empty data !')
                    event.preventDefault();
                    return;
                }else{
                    this.save();
                }
            },
            onHidden(){
                this.$emit('hidden');
            },
            onShown(){
                this.$emit('shown');
                window.dispatchEvent(new Event('resize'));
            },
            isEmpty(obj) {
                for(var key in obj) {
                    if(obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            },
            setObject(obj){
                this.editObj = {};
                this.editObj = _.cloneDeep(obj);
            },
            openModal(){
                this.mode = 'Create';
                this.editObj = {};
                this.editObj = _.cloneDeep(this.objectDefault);
                this.showModal = true;
                this.$bvModal.show(this.modalId);
            },
            saveSplit(str){
                if(_.isString(str)){
                    if(_.isString(str) != ''){
                        var arr = str.split(',');
                        if( _.isArray(arr) ){
                            return arr
                        } else {
                            return []
                        }
                    }
                }else{
                    return []
                }
            },
            commaToSpace(str){
                var sp = this.saveSplit(str);
                return _.isArray(sp)?sp.join(" "):str;
            }
        }
    }
</script>

<style scoped>
 .modal-bv {
     z-index: 10050 !important;
 }
 td, td div{
     white-space: nowrap;
     vertical-align: top;
     text-overflow: ellipsis;
     overflow: hidden;
 }

</style>
