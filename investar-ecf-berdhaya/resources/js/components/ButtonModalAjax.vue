<template>
    <div style="display:inline-block;">
        <button v-if="!noButton" v-on:click="openModal()"
                :class="buttonClass"
                :disabled="disabled"
                style="height:fit-content; margin: 0px ; cursor: pointer; padding: 8px;">
            <i :class="iconClass"> </i><span v-html="buttonText" :class="buttonTextClass"></span>
        </button>

        <b-modal :id="modalId"
                 @ok="addItem"
                 :ok-title="okTitle"
                 :size="modalSize"
                 :title="getTitle()"
                 no-close-on-esc
                 no-close-on-backdrop
                 scrollable
                 :visibility="showModal"
                 :hide-backdrop="hideBackdrop"
                 @hidden="onHidden"
                 @shown="onShown"
                 modal-class="modal-bv" >

            <template v-slot:modal-header="{ close }">
                <span class="modal-title" v-html="getTitle()" ></span>
                <!-- Emulate built in modal header close button action -->
                <b-button size="sm" variant="outline-secondary" pill @click="closeModal()">
                    <b-spinner small v-show="isLoading" label="Loading..."></b-spinner>
                    <i v-show="!isLoading" class="las la-times"></i>
                </b-button>
            </template>



            <active-form
                    v-model="editObj"
                    :template="template"
                    :content="content"
                    :params="params"
                    :object-default="objectDefault"
            ></active-form>
        </b-modal>

    </div>
</template>

<script>
    export default {
        name: "ButtonModalAjax",
        created() {


        },
        props: {
            actionUrl : {
                type: String,
                default: 'api/v1/core/upload'
            },
            handle : {
                type: String
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
            }
        },
        data: function(){
            return {
                mode: '',
                editIndex: 0,
                editObj : _.cloneDeep(this.objectDefault),
                showModal : false,
                hideBackdrop : false,
                isLoading : false
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

                this.isLoading = true;

                axios.post(
                    this.actionUrl,
                    formObject
                ).then( response => {
                    this.isLoading = false;
                    if(response.data.result == 'OK'){
                        this.closeModal();
                    }else{
                        alert( response.data.message );
                    }

                })
                .catch( e =>{
                    alert( e.toString() );
                    this.isLoading = false;
                });
            },
            clear(){
            },
            getTitle(){
                return this.buttonText;
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
