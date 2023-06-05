<template>
    <div class="st-modal">
        <div style="display: block;width: 100%;">
            <div style="display: table;width: 100%;border-bottom: thin solid #cbcbcb">
                <label>{{ label }}</label>
                <div v-on:click="openAddItem()" class="pull-right" style="height:fit-content; margin: 0px ;margin-top: 6px ; vertical-align: middle; cursor: pointer; float: right; padding: 8px;"><i class="las la-plus-circle"></i></div>
            </div>
            <div style="display: block;" >
                <div style="display: table;width: 100%;border: thin solid lightgrey;" v-if="!hideUtilButton" >
                    <div
                        v-on:click="openImportDialog()"
                        class="pull-right" style="height:fit-content; margin: 0px ;margin-top: 6px ; vertical-align: middle; cursor: pointer; float: right; padding: 8px;">
                        <i class="las la-upload"></i> XLS
                    </div>
                    <div
                        v-on:click="downloadTemplate()"
                        class="pull-right" style="height:fit-content; margin: 0px ;margin-top: 6px ; vertical-align: middle; cursor: pointer; float: right; padding: 8px;">
                        <i class="las la-download"></i> XLS Template
                    </div>
                    <div
                        class="pull-right" style="height:fit-content; margin: 0px ;margin-top: 6px ; vertical-align: middle; cursor: pointer; float: right; padding: 8px;padding-top: 0px;">
                        <b-form-checkbox
                            switch
                            v-model="includeData"
                        >
                            Include Data in Template
                        </b-form-checkbox>
                    </div>
                </div>
                <table class="table">
                    <tr v-if="showTableHeader">
                        <th v-if="ordered" class="seq">
                            No.
                        </th>
                        <th v-for="col in cols"
                            :class="isExist(col.class)? col.class:''" >
                            {{ col.label }}
                        </th>
                        <th style="width: 75px;max-width: 75px;padding-right: 0px;">
                            <span v-on:click="refreshTable()"  style="cursor: pointer;"  ><i class="las la-redo"></i></span>
                        </th>
                    </tr>
                    <tr v-for="(item, index) in items">
                        <td v-if="ordered" style="max-width: 35px;" >
                            {{ index + 1 }}
                        </td>
                        <td v-for="col in cols"  :class="isExist(col.class)? col.class:''" >
                            <div v-if="typeof item[col.key]=='object'">
                                <template v-if="splitComma">
                                    <div  v-html="isPathExist(item[col.key],'text')? commaToSpace(item[col.key].text): ''" ></div>
                                </template>
                                <template v-else>
                                    <div  v-html="isPathExist(item[col.key],'text')? setFormat(col, item[col.key].text ) : ''" ></div>
                                </template>
                            </div>
                            <div v-else>
                                <template v-if="splitComma">
                                    <div  v-html="isExist(item[col.key])? commaToSpace(item[col.key]): ''" ></div>
                                </template>
                                <template v-else>
                                    <div  v-html="isExist(item[col.key])? setFormat(col, item[col.key] ): ''" ></div>
                                </template>
                            </div>
                        </td>
                        <td style="width: 75px;max-width: 75px;padding-right: 0px;">
                            <span v-on:click="editItem(item)"  style="cursor: pointer;margin-right:15px;" class="pull-right" ><i class="las la-pencil-alt"></i></span>
                            <span v-on:click="removeItem(item)"  style="cursor: pointer;" class="pull-right" ><i class="las la-times-circle"></i></span>
                        </td>
                    </tr>

                    <tr style="border-top: thin solid black">
                        <td v-if="ordered" style="max-width: 35px;" >

                        </td>
                        <td v-for="col in cols"  :class="isExist(col.class)? col.class:''" >
                            <div  v-html="isExist(itemTotal[col.key])? setFormat(col, itemTotal[col.key] ): ''" ></div>
                        </td>
                        <td>

                        </td>
                    </tr>

                </table>
            </div>

        </div>
        <b-modal id="alertId"
                title="Required"
                ok-only
                >
                Data is empty!!
        </b-modal>

        <b-modal :id="importDialogId"
                 @ok="commitData"
                 size="xl"
                 centered
                 scrollable
                 title="Upload Items"
                 modal-class="modal-bv">
            <import-data
                :importid="importId"
                :sourceurl="sourceUrl"
                :previewcolumns="previewColumns"
                :previewheadings="previewHeadings"
                :uploadurl="uploadUrl"
                :commiturl="commitUrl"
            ></import-data>

        </b-modal>

        <b-modal :id="modalId"
                 @ok="addItem"
                 :size="modalSize"
                 :title="getTitle()"
                 :visibility="showModal"
                 :hide-backdrop="hideBackdrop"
                 modal-class="modal-bv" >
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
        name: "DocumentListModal",
        created() {
            bus.$on('returneditdocument', (payload) => {
                console.log('createdocument', payload);
                if( _.has( payload, 'ns' ) && ( _.get( payload, 'ns' ) == this.ns) ){
                    var idx = _.get( payload, 'id' );
                    var data = _.get( payload, 'obj' );
                    var itm = _.cloneDeep(this.items);
                    itm[idx] = data;
                    this.$emit('update:items', itm );
                }
            });
            bus.$on('returnadddocument', (payload) => {
                if( _.has( payload, 'ns' ) && ( _.get( payload, 'ns' ) == this.ns) ){
                    var data = _.get( payload, 'obj' );
                    this.items.push(data);
                }
            });
        },
        mounted() {
            this.mode = 'Create';
            this.itemName = this.modalEntity;
        },
        props: {
            label : {
                type: String,
                default: 'Table Input'
            },
            modalEntity : {
                type: String,
                default: 'Item'
            },
            entityNameKey : {
                type: [String, Array],
                default: function(){
                    return 'id';
                }
            },
            cols : {
                type: [Array,Object],
                default: function(){
                    return [];
                }
            },
            items : {
                type: Array,
                default: function(){
                    return [];
                }
            },
            itemTotal : {
                type: [Array, Object],
                default: function(){
                    return [];
                }
            },
            ordered : {
                type : Boolean,
                default : false

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
            hideUtilButton: {
                type: Boolean,
                default: false
            },
            modalId : {
                type: String,
                default: 'spiModal'
            },
            importDialogId : {
                type: String,
                default: 'spiImportModal'
            },
            showTableHeader: {
                type: Boolean,
                default: false
            },
            modalSize: {
                type: String,
                default: ''
            },
            splitComma: {
                type: Boolean,
                default: false
            },
            extAdd: {
                type: [Boolean, String],
                default: false
            },
            extEdit: {
                type: [Boolean, String],
                default: false
            },
            extAddCmd: {
                type: String,
                default: ''
            },
            extEditCmd: {
                type: String,
                default: ''
            },
            ns: {
                type: String,
                default: 'doc'
            },
            /* below are item uploader props */
            previewColumns : {
                type: [Object, Array],
                default: function(){
                    return [];
                }
            },
            previewHeadings : {
                type: [Object, Array],
                default: function(){
                    return [];
                }
            },
            sourceUrl : {
                type: String,
                default: ''
            },
            uploadUrl : {
                type: String,
                default: ''
            },
            commitUrl : {
                type: String,
                default: ''
            },
            dowloadTmplUrl : {
                type: String,
                default: ''
            }
        },
        data: function(){
            return {
                mode: '',
                editIndex: 0,
                editObj : _.clone(this.objectDefault),
                showModal : false,
                hideBackdrop : false,
                itemName : '',
                importId : '',
                includeData : false
            };
        },
        watch: {
            items: {
                deep: true,
                handler(items){
                    console.log( 'items emit', items );
                }
            }
        },
        methods: {
            getTitle(){
                return this.mode + ' ' + this.modalEntity;
            },
            closeModal(){
                this.editIndex = 0;
                //this.editObj = {};
                this.editObj = this.objectDefault;
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
            setFormat(col,val){
                // console.log('coldef', col);
                var fmt = _.get(col, 'format');
                // console.log('fmt', fmt);
                if(fmt){
                    if(fmt == 'currency'){
                        return this.formatCurrency(val);
                    }
                    if(fmt == 'numeric'){
                        return this.formatNumeric(val, 2);
                    }
                    if(fmt == 'integer'){
                        return this.formatNumeric(val, 0);
                    }
                    return val;
                }else{
                    return val;
                }
            },
            fixType(val){
                var out;
                _.each( val, (val,key, idx)=> {
                    if( _.has( this.cols[idx] , 'type' ) && _.get( this.cols[idx], 'type' ) == 'Number'){
                        out[idx][key] = parseFloat( val[idx][key] );
                    }else{
                        out[idx][key] = val[idx][key];
                    }
                } );

                return out;
            },
            formatCurrency(val){
                return accounting.formatMoney( parseFloat(val) , '' ,2, '.', ',');
            },
            formatNumeric(val, precision){
                return accounting.formatNumber( parseFloat(val) , precision ,'.', ',');
            },
            refreshTable(){
                this.$emit('onitemchange', this.items);
            },
            addItem(event){
                var validation = this.checkProperties(this.editObj)
                var tempObj = this.objectDefault;
                if(validation) {
                    // alert('Empty data !')
                    this.$bvModal.show('alertId');
                    event.preventDefault();
                    return;
                }else{
                    var newObj = this.editObj;
                    if(this.mode == 'Edit'){
                        this.items[this.editIndex] = newObj;
                    }else{
                        this.items.push(newObj);
                    }
                    this.editIndex = 0;
                    this.editObj = _.clone(this.objectDefault);
                    this.$bvModal.hide(this.modalId);
                }
                this.$emit('onitemchange', this.items);
                this.resetForm();
            },
            resetForm(){
                this.mode = 'Create';
                this.itemName = this.modalEntity;
                this.editObj = _.clone(this.objectDefault);
            },
            contentToModel(obj){
                this.editObj = obj;
            },
            modelToDefault(){
                this.editObj = _.clone(this.objectDefault);
            },
            removeItem(obj){
                var index = this.items.indexOf(obj);
                this.items.splice(index, 1);
                this.$emit('onitemchange', this.items);
            },
            editItem(obj){
                this.mode = 'Edit';
                this.editIndex = this.items.indexOf(obj);
                this.editObj = _.clone(this.items[this.editIndex]);

                if(_.has( this.editObj, this.entityNameKey ) ){
                    this.itemName = _.get( this.editObj, this.entityNameKey );
                }else{
                    this.itemName = '';
                }
                this.showModal = true;
                if(this.extEdit){
                    var payload = { id: this.editIndex, obj: this.editObj, ns: this.ns };
                    bus.$emit(this.extEditCmd, payload);
                }else{
                    this.$bvModal.show(this.modalId);
                }
            },
            isEmpty(obj) {
                for(var key in obj) {
                    if(obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            },
            openAddItem(){
                this.mode = 'Create';
                this.editObj = {};
                this.editObj = _.clone(this.objectDefault);
                this.showModal = true;
                this.itemName = this.modalEntity;
                if(this.extAdd){
                    bus.$emit(this.extAddCmd, { ns: this.ns });
                }else{
                    this.$bvModal.show(this.modalId);
                }
            },
            openImportDialog(){
                this.importId = this.generateRandomString(10);
                console.log(this.importId);
                this.$bvModal.show('uploadItemModal');
            },
            commitData(){

                axios.post(this.sourceUrl + '?importid=' + this.importId, {
                    page: 'all',
                    perPage: 100,
                    columnFilters: {},
                    sort: {field: '', type: ''}
                })
                    .then( response => {
                        if(response.data.result == 'OK'){
                            var items = response.data.data;
                            this.$emit('update:items', items);
                            this.$bvModal.hide('uploadItemModal');
                            this.$emit('onitemchange', this.items);
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    }).finally(function (){
                    this.$emit('onitemchange', this.items);
                });
            },
            downloadTemplate(){
                console.log( this.dowloadTmplUrl,  this.previewHeadings);
                axios.post(this.dowloadTmplUrl, {
                    headings : this.previewHeadings,
                    items : this.items,
                    includeData : this.includeData
                })
                    .then( response => {
                        if(response.data.result == 'OK'){
                            window.location.href = response.data.data.urlxls;
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            generateRandomString(length=6){
                return Math.random().toString(20).substr(2, length);
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
     .st-modal{
         width: 100%;
         padding-left: 8px;
         padding-right: 8px;
     }
     .text-right{
         text-align: right;
     }
     .text-center{
         text-align: center;
     }

</style>
