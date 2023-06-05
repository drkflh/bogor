<template>
    <div class="sti-container">
        <div style="display: block;width: 100%;">
            <div style="display: table;width: 100%;border-bottom: thin solid #cbcbcb">
                <label style="font-size: 15px;color: black;">{{ label }}</label>
                <div v-if="collapsible"
                     v-on:click="togglePanel()"
                     class="pull-right" style="height:fit-content; margin: 0px ;margin-top: 6px ; vertical-align: middle; cursor: pointer; float: right; padding: 8px;">
                    <i class="las" :class="(showPanel)?'la-chevron-circle-up':'la-chevron-circle-down'"></i>
                </div>
                <template v-if="!hideUtilButton">
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
                        class="pull-right import-tool" style="height:fit-content; margin: 0px ;margin-top: 6px ; vertical-align: middle; cursor: pointer; float: right; padding: 8px;padding-top: 0px;">
                        <b-form-checkbox
                            switch
                            v-model="includeData"
                        >
                            Include Data in Template
                        </b-form-checkbox>
                    </div>
                </template>
            </div>
            <div style="display: block;">
                <template v-if="showPanel" >
                    <h5>
                        {{ mode }} {{ itemName }}
                    </h5>
                    <div style="display:table;width:100%;margin-bottom: 20px;" >
                        <div style="display: table-cell;width:auto;" >
                            <active-form
                                v-model="editObj"
                                :template="template"
                                :content="content"
                                :params="params"
                                :object-default="objectDefault"
                            ></active-form>
                        </div>
                        <div style="display: table-cell;width: 30px;text-align: center;vertical-align:bottom;" class="add-container">
                            <button v-if="useDms" v-on:click="attachDoc()" style="cursor: pointer;margin-bottom: 8px;border: none" class="btn btn-sm btn-outline-secondary mt-1" ><i class="las la-paperclip"></i><br>DMS</button>
                            <button v-on:click="resetForm()" style="cursor: pointer;margin-bottom: 8px;border: none" class="btn btn-sm btn-outline-secondary" ><i class="las la-undo"></i></button>
                            <button v-on:click="addItem()" style="cursor: pointer;margin-bottom: 8px;border:none;" class="btn btn-outline-secondary btn-sm " ><i class="las la-save"></i></button>
                        </div>
                    </div>
                </template>
                <table class="table">
                    <tr v-if="showTableHeader">
                        <th v-if="ordered" class="seq">
                            No.
                        </th>
                        <th v-for="col in cols"
                            :class="isExist(col.class)? col.class:''" >
                            {{ col.label }}
                        </th>
                        <th style="width: 75px;max-width: 75px;padding-right: 10px;text-align: right;">
                            <span v-on:click="refreshTable()"  style="cursor: pointer;"  ><i class="las la-redo-alt"></i></span>
                        </th>
                    </tr>
                    <tr v-for="(item, index) in items">
                        <td v-if="ordered" style="max-width: 35px;" class="text-center" >
                            {{ index + 1 }}
                        </td>
                        <td v-for="col in cols"  :class="isExist(col.class)? col.class:'text-right'" >
                                <div v-if="typeof item[col.key]=='object'">
                                    <a-tooltip placement="top" :title="_.get(item[col.key] , 'text' )" >
                                        <template v-if="splitComma">
                                            <div  v-html="isPathExist(item[col.key],'text')? commaToSpace(item[col.key].text): ''" ></div>
                                        </template>
                                        <template v-else>
                                            <div  v-html="isPathExist(item[col.key],'text')? setFormat(col, item[col.key].text ) : ''" ></div>
                                        </template>
                                    </a-tooltip>
                                </div>
                                <div v-else>
                                    <a-tooltip placement="top" :title="item[col.key]" >
                                        <template v-if="splitComma">
                                            <div  v-html="isExist(item[col.key])? commaToSpace(item[col.key]): ''" ></div>
                                        </template>
                                        <template v-else>
                                            <div  v-html="isExist(item[col.key])? setFormat(col, item[col.key] ): ''" ></div>
                                        </template>
                                    </a-tooltip>
                                </div>
                        </td>
                        <td class="d-flex justify-content-end">
                            <span v-on:click="editItem(item)"  style="cursor: pointer;margin-right:15px;" class="mr-2" ><i class="las la-pencil-alt"></i></span>
                            <span v-on:click="removeItem(item)"  style="cursor: pointer;" class="" ><i class="las la-times-circle"></i></span>
                        </td>
                    </tr>

                    <tr style="border-top: thin solid black">
                        <td v-if="ordered" style="max-width: 35px;" >

                        </td>
                        <td v-for="col in cols"  :class="isExist(col.class)? col.class:'text-right'"
                            v-html="isExist(itemTotal[col.key])? setFormat(col, itemTotal[col.key] ): ''"
                        >
                        </td>
                        <td>

                        </td>
                    </tr>

                </table>
            </div>

        </div>
        <b-modal :id="alertId"
                title="Required"
                ok-only
                >
            All fields should not be empty.
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

        <b-modal :id="dmsDialogId"
                 @ok.prevent="commitDms"
                 size="xl"
                 centered
                 scrollable
                 title="Upload To DMS"
                 modal-class="modal-bv">
<!--            DMS Layout Start-->
                <dms-fixed-form
                    ref="dms_form"
                    v-model="dmsDoc"
                    :content="dmsContent"
                    :object-default="dmsDefault"
                    :params="dmsParams"
                    :handle="dmsHandle"
                    :topics="dmsTopics"
                    :call-code-re-pattern="callCodeRePattern"
                    :call-code-unseq-re-pattern="callCodeUnseqRePattern"
                    @onDocumentSaved="onDocSaved"
                ></dms-fixed-form>
<!--            DMS Layout End-->
        </b-modal>


    </div>
</template>

<script>
    export default {
        name: "SimpleTableInputTemplate",
        created() {

        },
        mounted() {
            this.mode = 'Create';
            this.itemName = this.modalEntity;
            this.showPanel = this.openShowPanel;
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
            linkedDoc: {
                type: [String, Object, Array]
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
            collapsible: {
                type: Boolean,
                default: true
            },
            openShowPanel: {
                type: Boolean,
                default: function () {
                    return false;
                }
            },
            hideAddButton: {
                type: Boolean,
                default: function(){ return false }
            },
            hideUtilButton: {
                type: Boolean,
                default: function () {
                    return false;
                }
            },
            importDialogId : {
                type: String,
                default: 'spiImportModal'
            },
            useDms : {
                type: [String, Boolean],
                default: function(){ return true }
            },
            dmsDialogId : {
                type: String,
                default: 'spiDmsModal'
            },
            dmsTemplate : {
                type: String,
                default: ''
            },
            dmsContent : {
                type: String,
                default: ''
            },
            dmsDefault : {
                type: Object,
                default: function(){
                    return {};
                }
            },
            dmsParams : {
                type: Object,
                default: function(){
                    return {};
                }
            },
            dmsTopics : {
                type: [ Array, Object],
                default: function(){
                    return [];
                }
            },
            modalId : {
                type: String,
                default: 'spiModal'
            },
            alertId : {
                type: String,
                default: 'spiAlertModal'
            },
            showTableHeader: {
                type: Boolean,
                default: function(){ return false }
            },
            modalSize: {
                type: String,
                default: ''
            },
            splitComma: {
                type: Boolean,
                default: function () {
                    return false;
                }
            },
            extAdd: {
                type: [Boolean, String],
                default: function () {
                    return false;
                }
            },
            extEdit: {
                type: [Boolean, String],
                default: function () {
                    return false;
                }
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
            callCodeRePattern : {
                type: [Object, String, RegExp],
                default: function(){
                    const re = /.{1}-.{2}-.{2}-.{2}-.{7}-.{4}-.{2}/m;
                    return re;
                }
            },
            callCodeUnseqRePattern : {
                type: [Object, String, RegExp],
                default: function(){
                    const re = /.{1}-.{2}-.{2}-.{2}-.{7}-.{4}/m;
                    return re;
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
            embedQRUrl : {
                type: String,
                default: ''
            },
            commitUrl : {
                type: String,
                default: ''
            },
            downloadTmplUrl : {
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
                hideBackdrop : false,
                itemName : '',
                importId : '',
                includeData : false,
                showPanel : false,
                dmsHandle: '',
                dmsDoc : _.clone(this.dmsDefault),
            };
        },
        watch: {
            items: {
                deep: true,
                handler(items){
                    this.$emit( 'onitemchange', this.items );
                    console.log( 'items emit', items );
                }
            },
            editObj: {
                deep: true,
                handler(val){
                    this.$emit( 'onformchange', this.editObj );
                    console.log( 'form object emit', val );
                }
            },
            dmsDoc: {
                deep: true,
                handler(doc){
                    this.dmsDoc.CoyCode = doc.Coy;
                    this.dmsDoc.RetDate = moment(this.dmsDoc.DocDate).add(parseInt(this.dmsDoc.RetPer), 'y').format('YYYY-MM-DD HH:mm:ss');
                    this.dmsDoc.DispDate = moment(this.dmsDoc.DocDate).add(parseInt(this.dmsDoc.DispPer), 'y').format('YYYY-MM-DD HH:mm:ss');
                    this.dmsDoc.MMYY = moment(this.dmsDoc.DocDate).format('MMYY');

                    this.getCallCode();

                    if( !_.isEmpty(this.dmsDoc.CallCode) ){
                        this.getSequence();
                    }

                    console.log( 'doc change', doc );
                }
            }
        },
        methods: {
            getTitle(){
                return this.mode + ' ' + this.modalEntity;
            },
            closeModal(){
                this.editIndex = 0;
                this.editObj = _.cloneDeep(this.objectDefault);
                this.$bvModal.hide(this.modalId);
            },
            checkProperties(obj) {
                var valid = true;
                console.log('validate',obj);
                for (var key in obj) {

                    var col = _.find(this.cols, { key : key } );
                    console.log('validate rule', col);
                    var validator = '';
                    if(_.has(col, 'validator')){
                        validator = _.get(col, 'validator');
                    }
                    if( validator == 'required'){
                        if ( obj[key] === '' || obj[key] === null || typeof obj[key] === undefined )
                            //_.isUndefined(obj[key]) || _.isEmpty(obj[key]) || ( ( parseInt(obj[key]) != 0 ) && _.isNull(obj[key]) ) || obj[key] == ''  )
                        {
                            valid = false;
                        }
                    }
                }
                return valid;
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

                if(!validation) {
                    this.$bvModal.show(this.alertId);
                    //event.preventDefault();
                }else{
                    var newObj = this.editObj;
                    if(this.mode == 'Edit'){
                        this.items[this.editIndex] = newObj;
                    }else{
                        this.items.push(newObj);
                    }
                    this.editIndex = 0;
                    this.editObj = _.cloneDeep(this.objectDefault);
                    this.$bvModal.hide(this.modalId);
                    this.$emit('onitemchange', this.items);
                    this.resetForm();
                }
            },
            resetForm(){
                this.mode = 'Create';
                this.itemName = this.modalEntity;
                this.editObj = _.cloneDeep(this.objectDefault);
            },
            removeItem(obj){
                var index = this.items.indexOf(obj);
                this.items.splice(index, 1);
                this.$emit('onitemchange', this.items);
            },
            editItem(obj){
                this.mode = 'Edit';
                this.editIndex = this.items.indexOf(obj);
                this.editObj = _.cloneDeep(this.items[this.editIndex]);

                this.showPanel = true;
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
            togglePanel(){
                this.showPanel = !this.showPanel;
            },
            openAddItem(){
                this.mode = 'Create';
                this.editObj = {};
                this.editObj = _.cloneDeep(this.objectDefault);
                this.showPanel = true;
                this.itemName = this.modalEntity;
            },
            openImportDialog(){
                this.importId = this.generateRandomString(10);
                console.log(this.importId);
                this.$bvModal.show(this.importDialogId);
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
                        this.$bvModal.hide(this.importDialogId);
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
                console.log( this.downloadTmplUrl,  this.previewHeadings);
                axios.post(this.downloadTmplUrl, {
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
            },
            maxToday(date){
                const today = new Date();
                return date >= today;
            },
            maxTodayNotBefore(date){
                const today = new Date();
                const before = new Date(this.dmsDoc.DocDate);
                return before > date || date > today;
            },
            attachDoc(){
                this.dmsHandle = this.generateRandomString(6);
                this.$bvModal.show(this.dmsDialogId);
            },
            //DMS related methods
            betweenDocDateNow(date){
                const today = new Date();
                const before = new Date(this.DocDate);
                return before > date || date > today;
            },
            minDay(date){
                const today = moment(this.serviceRequestDate);
                return date < today;
            },
            getCallCode(){
                if( !_.isEmpty(this.dmsDoc.Topic) && !_.isEmpty(this.dmsDoc.Function) && !_.isEmpty(this.dmsDoc.CoyCode) && !_.isEmpty(this.dmsDoc.Feature) && !_.isEmpty(this.dmsDoc.MMYY)  ){

                    this.dmsDoc.CallCode = this.dmsDoc.Topic + '-' + this.dmsDoc.CoyCode + '-' + this.dmsDoc.Feature + '-' + this.dmsDoc.MMYY;

                    if( !_.isEmpty(this.dmsDoc.Urut) ){
                        this.dmsDoc.FCallCode = this.dmsDoc.Topic + '-' + this.dmsDoc.CoyCode + '-' + this.dmsDoc.Feature + '-' + this.dmsDoc.MMYY + '-' + this.dmsDoc.Urut;
                    }
                }
            },
            onDocSaved(doc){
                console.log(doc);
                _.set( this.editObj, 'docId', doc.docId);
                _.set( this.editObj, 'docCallCode', doc.docCallCode);
                _.set( this.editObj, 'FCallCode', doc.docCallCode);


                this.$bvModal.hide(this.dmsDialogId);
                this.clearDmsForm();
            },
            getDocSequence(){

                var entity = this.dmsDoc.CallCode;

                console.log('getseq',entity);

                axios.post( this.dmsParams.getSeqUrl , { entity: entity, padding: 2 } )
                    .then(response => {
                        console.log(response.data);
                        if(response.data.result == 'OK'){
                            var seq = response.data.padded;
                            this.dmsDoc.Urut = seq;
                            this.getCallCode();
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            },
            embedQR(){
                const re = this.callCodeRePattern;
                if(this.dmsDoc.FCallCode == '' && !re.exec(this.dmsDoc.FCallCode) ){
                    alert('Call Code can not be empty');
                    return;
                }
                var entity = this.dmsDoc.FileObject;

                entity.FCallCode = this.dmsDoc.FCallCode;
                entity.addQR = true;
                entity.FCallCode = this.dmsDoc.FCallCode;


                axios.post( this.dmsParams.embedQRUrl , { entity: entity } )
                    .then(response => {
                            console.log(response.data);
                            console.log(response.data.result);
                            if(response.data.result == 'OK'){
                                console.log(response.data.data);
                                let file = response.data.data.file;
                                this.dmsDoc.FileUrl = file.FileUrl;
                                this.dmsDoc.FileObject = file.FileObject;
                            }
                        })
                    .catch(function(error) {
                        console.log(error);
                    });
            },
            commitDms(){
                this.$refs.dms_form.saveItem('ADD');
            },
            clearDmsForm() {
                this.$refs.dms_form.clearDmsForm();
            },
            viewDocPdf(){
                bus.$emit('viewPdf', this.dmsDoc.FileUrl );
            }
        }
    }
</script>

<style scoped>
    .add-container{
        margin-top: 8px;
        margin-bottom: 8px;
        text-align: right;
        width: 100%;
    }
    td, td div{
        white-space: nowrap;
        vertical-align: top;
        text-overflow: ellipsis;
        overflow: hidden;
    }
    .sti-container{
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
    .import-tool label{
        padding-top:0px;
    }

</style>
