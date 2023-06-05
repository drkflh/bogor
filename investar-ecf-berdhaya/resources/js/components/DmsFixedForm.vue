<template>
    <div>
        <validation-observer v-slot="{ invalid }" ref="dmsdialog_veeObserver">

        <div class="row">
            <div class="col-lg-5 col-md-5" style="border-right: thin solid darkgrey;overflow: auto;">
                <div class="row">
                    <div class="col-12">
                        <label for="FileUrl">Upload File</label><br>
                        <doc-upload
                            v-model="FileUrl"
                            :base-url.sync="DocBase"
                            :doc-path.sync="DocPath"
                            :filename="FCallCode"
                            :handle="handle"
                            :qr="true"
                            :file-object.sync="FileObject"
                            accepted-files="application/pdf"
                            bucket="docs"
                            buttonlabel="Upload PDF"
                            :defaulturl="params.defaultUrl"
                            dir="documents"
                            mode="single"
                            no-handle
                            ns="FileUrl"
                            :uploadurl="params.uploadUrl"
                        >

                        </doc-upload>

                    </div>
                    <div class="col-12" style="cursor:pointer;" @click="viewPdf()">
                        <label class="" for="FileUrl">Soft File</label>
                        <validation-provider v-slot="{ errors }" name="soft file" rules="">
                            <input v-model="FileUrl"
                                   class="form-control  "
                                   name="FileUrl"
                                   type="text"
                            >
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>


                    </div>
                </div>
                <h5>Label</h5>
                <div class="row">
                    <div class="col-md-8 mt-2 ml-2">
                        <active-view
                            :content="FCallCode"
                            :template="params.printTemplate"
                        ></active-view>

                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-icon" @click="embedQR()">
                            <i class="las la-qrcode" style="font-size: 16pt;"></i>
                        </button>
                        Embed QR
                        <b-spinner v-if="isEmbedding" small></b-spinner>
                        <hr style="margin: 4px;">
                        <print-element
                            :content="FCallCode"
                            :options="{ styles: [ params.printCss ] }"
                            :template="params.printTemplate"

                        ></print-element>

                    </div>
                </div>
                <hr>
                <h5>Call Code</h5>
                <hr>
                <div class="row">
                    <div class="col-2 pr-0">
                        <label for="TopicObject">Topic</label><br>
                        <input v-model="Topic"
                               class="form-control  "
                               name="Coy"
                               type="text"
                               disabled="disabled"
                               readonly="readonly"
                        >
                    </div>
                    <div class="col-2 pr-0">
                        <label class="" for="Coy">Company</label>
                        <input v-model="Coy"
                               class="form-control  "
                               name="Coy"
                               type="text"
                               disabled="disabled"
                               readonly="readonly"
                        >
                    </div>
                    <div class="col-3 pr-0">
                        <label class="" for="Feature">Feature</label>
                        <input v-model="Feature"
                               class="form-control  "
                               name="Coy"
                               type="text"
                               disabled="disabled"
                               readonly="readonly"
                        >
                    </div>
                    <div class="col-2 pr-0">
                        <label class="" for="MMYY">MMYY</label>
                        <input v-model="MMYY"
                               class="form-control  "
                               name="MMYY"
                               type="text"
                               disabled="disabled"
                               readonly="readonly"
                        >
                    </div>
                    <div class="col-3">
                        <label class="" for="Urut">Sequence</label>
                        <div class="input-group">
                            <validation-provider v-slot="{ errors }" name="sequence" rules="">
                                <input v-model="Urut"
                                       class="form-control  text-50"
                                       name="Urut"
                                       type="text"
                                       readonly="readonly"
                                >
                                <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                            </validation-provider>
                            <div class="input-group-append">
                                <span class="input-group-text" style="width: fit-content;padding:0px;"><button
                                    class="btn btn-icon" @click="getDocSequence()"><i
                                    class="las la-plus-square"></i></button></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="TopicObject">Topic</label>
                        <validation-provider v-slot="{ errors }" name="topic" rules="required">
                            <b-form-select
                                v-model="TopicObject"
                                class="form-control"
                            >
                                <b-form-select-option
                                    v-for="opt in topics"
                                    :value="opt"
                                    :key="opt.text"
                                >
                                    {{ opt.text }}
                                </b-form-select-option>
                            </b-form-select>
                        <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>
                    </div>
                    <div class="col-md-5">
                        <label class="" for="Coy">Company</label>
                        <validation-provider v-slot="{ errors }" name="company" rules="required">
                            <b-form-select
                                v-model="Coy"
                                :options="params.CoyOptions"
                                class="form-control  "
                            ></b-form-select>
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>
                    </div>
                    <div class="col-md-4">
                        <div style="display: block;">
                            <label for="DocDate"
                                   style="display: block !important;"
                            >Doc Date</label>
                            <validation-provider v-slot="{ errors }" name="doc date" rules="">
                                <a-date-picker
                                    v-model="DocDate"
                                    :disabled-date="beforeToday"
                                    :input-read-only="false"
                                    class=" "
                                    format="DD MMM YYYY"
                                    placeholder="DD MMM YYYY"
                                    value-format="YYYY-MM-DD"
                                    value-type="YYYY-MM-DD HH:mm:ss"
                                >
                                </a-date-picker>
                                <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                            </validation-provider>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label class="" for="Feature">Feature</label>
                        <validation-provider v-slot="{ errors }" name="feature" rules="">
                            <input v-model="Feature"
                                   class="form-control  "
                                   name="Feature"
                                   type="text"
                            >
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>
                    </div>
                    <div class="col-md-9">
                        <label class="" for="DocRef">Doc Ref</label>
                        <validation-provider v-slot="{ errors }" name="doc ref" rules="">
                            <input v-model="DocRef"
                                   class="form-control  "
                                   name="DocRef"
                                   type="text"
                            >
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="" for="TopicDescr">Topic Descr.</label>
                        <validation-provider v-slot="{ errors }" name="topic descr." rules="">
                            <input v-model="TopicDescr"
                                   class="form-control  "
                                   name="TopicDescr"
                                   type="text"
                                   readonly="readonly"
                            >
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>
                    </div>
                </div>

                <h5>Document Cataloging</h5>
                <div class="row">
                    <div class="col-md-4">
                        <label class="" for="Tipe">Type</label>
                        <validation-provider v-slot="{ errors }" name="type" rules="">
                            <b-form-select
                                v-model="Tipe"
                                :options="params.TipeOptions"
                                class="form-control"
                            ></b-form-select>
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>
                    </div>
                    <div class="col-md-4">
                        <label class="" for="IO">IO</label>
                        <validation-provider v-slot="{ errors }" name="io" rules="">
                            <b-form-select
                                v-model="IO"
                                :options="params.IOOptions"
                                class="form-control"
                            ></b-form-select>
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>
                    </div>
                    <div class="col-md-4">
                        <label class="" for="OriginFormat">OriginFormat</label>
                        <validation-provider v-slot="{ errors }" name="originformat" rules="">
                            <b-form-select
                                v-model="OriginFormat"
                                :options="params.OriginFormatOptions"
                                class="form-control"
                            ></b-form-select>
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div style="display: block;">
                            <label for="IODate"
                                   style="display: block !important;"
                            >Input Date</label>
                            <validation-provider v-slot="{ errors }" name="input date" rules="">
                                <a-date-picker
                                    v-model="IODate"
                                    :disabled-date="beforeToday"
                                    :input-read-only="false"
                                    class=" "
                                    format="DD MMM YYYY"
                                    placeholder="DD MMM YYYY"
                                    value-format="YYYY-MM-DD"
                                    value-type="YYYY-MM-DD HH:mm:ss"
                                >
                                </a-date-picker>
                                <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="display: block;">
                            <label for="ExpDate"
                                   style="display: block !important;"
                            >Expired Date</label>
                            <validation-provider v-slot="{ errors }" name="expired date" rules="">
                                <a-date-picker
                                    v-model="ExpDate"
                                    :input-read-only="false"
                                    class=" "
                                    format="DD MMM YYYY"
                                    placeholder="DD MMM YYYY"
                                    value-format="YYYY-MM-DD"
                                    value-type="YYYY-MM-DD HH:mm:ss"
                                >
                                </a-date-picker>
                                <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                            </validation-provider>
                        </div>
                    </div>
                </div>
                <label class="" for="Subject">Subject</label>
                <validation-provider v-slot="{ errors }" name="subject" rules="">
                    <input v-model="Subject"
                           class="form-control  "
                           name="Subject"
                           type="text"
                    >
                    <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                </validation-provider>
                <div class="row">
                    <div class="col-md-6">
                        <label class="" for="Sender">Sender</label>
                        <validation-provider v-slot="{ errors }" name="sender" rules="">
                            <input v-model="Sender"
                                   class="form-control  "
                                   name="Sender"
                                   type="text"
                            >
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>
                    </div>
                    <div class="col-md-6">
                        <label class="" for="Recipient">Recipient</label>
                        <validation-provider v-slot="{ errors }" name="recipient" rules="">
                            <input v-model="Recipient"
                                   class="form-control  "
                                   name="Recipient"
                                   type="text"
                            >
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>
                    </div>
                </div>
                <hr>
                <h5>Document Storage Management</h5>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <label class="" for="NoSheet"># of Sheets</label>
                        <validation-provider v-slot="{ errors }" name="# of sheets" rules="">
                            <input v-model="NoSheet"
                                   class="form-control text-right  "
                                   name="NoSheet"
                                   type="number"
                            >
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>
                    </div>
                    <div class="col-md-3">
                        <label class="" for="NoPage"># of Page</label>
                        <validation-provider v-slot="{ errors }" name="# of page" rules="">
                            <input v-model="NoPage"
                                   class="form-control text-right  "
                                   name="NoPage"
                                   type="number"
                            >
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>
                    </div>
                    <div class="col-md-3">
                        <label class="" for="Location">Location</label>
                        <validation-provider v-slot="{ errors }" name="location" rules="">
                            <input v-model="Location"
                                   class="form-control  "
                                   name="Location"
                                   type="text"
                            >
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>
                    </div>
                    <div class="col-md-3">
                        <label class="" for="Store">Store</label>
                        <validation-provider v-slot="{ errors }" name="store" rules="">
                            <input v-model="Store"
                                   class="form-control  "
                                   name="Store"
                                   type="text"
                            >
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label class="" for="Class">Class</label>
                        <validation-provider v-slot="{ errors }" name="class" rules="">
                            <input v-model="Class"
                                   class="form-control  "
                                   name="Class"
                                   type="text"
                            >
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>
                    </div>
                    <div class="col-md-3">
                        <label class="" for="Status">Status</label>
                        <validation-provider v-slot="{ errors }" name="status" rules="">
                            <b-form-select
                                v-model="Status"
                                :options="params.StatusOptions"
                                class="form-control  "
                            ></b-form-select>
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>
                    </div>
                    <div class="col-md-6">
                        <label for="NotifyTo">Notify To</label><br>
                        <tags-input
                            v-model="NotifyTo"
                            :init-tags="NotifyTo"
                            :search-url="params.searchUserUrl"
                        ></tags-input>
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Active</h6>
                        <div class="row">
                            <div class="col-md-5">
                                <label class="" for="RetPer">Active Years</label>
                                <validation-provider v-slot="{ errors }" name="active years" rules="">
                                    <input v-model="RetPer"
                                           class="form-control  "
                                           name="RetPer"
                                           type="text"
                                    >
                                    <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                                </validation-provider>
                            </div>
                            <div class="col-md-7">
                                <div style="display: block;">
                                    <label for="RetDate"
                                           style="display: block !important;"
                                    >Retain Until</label>
                                    <validation-provider v-slot="{ errors }" name="retain until" rules="">
                                        <a-date-picker
                                            v-model="RetDate"
                                            :input-read-only="false"
                                            class=" "
                                            format="DD MMM YYYY"
                                            placeholder="DD MMM YYYY"
                                            value-format="YYYY-MM-DD"
                                            value-type="YYYY-MM-DD HH:mm:ss"
                                        >
                                        </a-date-picker>
                                        <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                                    </validation-provider>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Disposal</h6>
                        <div class="row">
                            <div class="col-md-5">
                                <label class="" for="DispPer">Period</label>
                                <validation-provider v-slot="{ errors }" name="disposal period" rules="">
                                    <input v-model="DispPer"
                                           class="form-control  "
                                           name="DispPer"
                                           type="text"
                                    >
                                    <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                                </validation-provider>
                            </div>
                            <div class="col-md-7">
                                <div style="display: block;">
                                    <label for="DispDate"
                                           style="display: block !important;"
                                    >Disposal Date</label>
                                    <validation-provider v-slot="{ errors }" name="disposal date" rules="">
                                        <a-date-picker
                                            v-model="DispDate"
                                            :input-read-only="false"
                                            class=" "
                                            format="DD MMM YYYY"
                                            placeholder="DD MMM YYYY"
                                            value-format="YYYY-MM-DD"
                                            value-type="YYYY-MM-DD HH:mm:ss"
                                        >
                                        </a-date-picker>
                                        <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                                    </validation-provider>


                                </div>


                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-7 col-md-7">
                <label for="docViewUrl">Doc View</label><br>
                <div id="printedItemContentFrame" style="height: 100%; min-height: 800px;">
                    <iframe id="print-iframe" :src="docViewUrl"
                            style="height:100%;width: 100%; min-height: 800px;border:none">
                    </iframe>
                </div>

            </div>
        </div>

        </validation-observer>
    </div>
</template>

<script>
    export default {
        name: "DmsFixedForm",
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value: {
                type: [String, Object, Array, Number]
            },
            command: {
                type: [String, Object, Array]
            },
            content: {
                type: [String, Object, Array]
            },
            params: {
                type: [String, Object, Array]
            },
            template: {
                type: [String, Object]
            },
            handle: {
                type: String
            },
            topics: {
                type: [String, Object, Array],
                default: function () {
                    return []
                }
            },
            objectDefault: {
                type: [String, Object, Array],
                default: function () {
                    return {}
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
        },
        data: function () {
            return {
                //editObj : _.cloneDeep(this.objectDefault),
                showAll: false,
                isLoading: false,
                isEmbedding: false,
                docViewUrl: '',

                Coy : '' ,
                Function : '' ,
                FunctionDesc : '' ,
                IO : this.objectDefault.IO ,
                IODate : '' ,
                Feature : '' ,
                DocDate : '' ,
                DocStatus : this.objectDefault.DocStatus ,
                OriginFormat : this.objectDefault.OriginFormat ,
                FCallCode : '' ,
                Subject : '' ,
                Tipe : '' ,
                DocRef : '' ,
                Scope : '' ,
                TopicObject : '' ,
                Topic : '' ,
                TopicDescr : '' ,
                Feature : '' ,
                MMYY : '' ,
                Urut : '' ,
                NoPage : '' ,
                NoSheet : '' ,
                CallCode : '' ,
                FCallCode : '' ,
                FCallCode : '' ,
                Sender : '' ,
                Recipient : '' ,
                Action : '' ,
                Class : '' ,
                Copy : '' ,
                Location : '' ,
                Store : '' ,
                Status : this.objectDefault.Status ,
                Keyword : '' ,
                ExpDate : '' ,
                NotifyTo : '' ,
                RetPer : this.objectDefault.RetPer ,
                RetDate : '' ,
                DispPer : this.objectDefault.DispPer ,
                DispDate : '' ,
                Dispatch : '' ,
                Boxing : '' ,
                BoxId : '' ,
                EndDisp : '' ,
                Filestat : '' ,
                Linked : '' ,
                FileUrl : '' ,
                FileObject : this.objectDefault.FileObject ,
                DocBase : '' ,
                DocPath : '' ,
                FCallCode : ''
            };
        },
        watch: {
            DocDate : function(val){
                this.RetDate = moment(val).add(parseInt(this.RetPer), 'y').format('YYYY-MM-DD HH:mm:ss');
                this.DispDate = moment(val).add(parseInt(this.DispPer), 'y').format('YYYY-MM-DD HH:mm:ss');
                this.MMYY = moment(val).format('MMYY');
                this.getCallCode();
            },
            FileUrl : function(val){
                let dt = new Date();
                if( val == '' ){
                    this.docViewUrl = '';
                }else{
                    this.docViewUrl = val + '?' + dt;
                }
            },
            RetPer : function(val){
                console.log(val, this.DocDate);
                this.RetDate = moment(this.DocDate).add(parseInt(val), 'y').format('YYYY-MM-DD HH:mm:ss');

            },
            DispPer : function(val){
                this.DispDate = moment(this.DocDate).add(parseInt(val), 'y').format('YYYY-MM-DD HH:mm:ss');
            },

            Coy : function(val){
                this.CoyCode = val;
            },
            CoyCode : function(val){
                this.getCallCode();
            },
            Topic : function(val){
                this.getCallCode();
            },
            Feature : function(val){
                this.getCallCode();
            },
            MMYY : function(val){
                this.getCallCode();
            },
            TopicObject: function(val){
                console.log(val);
                let tval = _.get(val, 'value');
                this.Topic = _.get( tval, 'Topic', '' );
                this.TopicDescr = _.get( tval, 'TopicDescr', '' );
                this.Function = _.get( tval, 'Function', '' );
                this.RetPer = parseInt( _.get( tval, 'ActiveYrs',0 ) );
                this.DispPer = parseInt( _.get( tval, 'DispPer',0 ) );
                this.Class = _.get( tval, 'DocClass', '' );
            }
        },
        methods: {
            emitData(){
                this.$emit('input', this.editObj );
            },
            showModal(_id, obj) {
                this.$bvModal.show(_id);
            },
            hideModal(_id) {
                this.$bvModal.hide(_id);
                this.emitData();
            },
            fmtDate(dateString, dateFormat){
                var dtrans = moment(dateString).format(dateFormat);
                return dtrans;
            },
            sumColumn(collection, fieldname){
                var items = collection.map( it => { return it[fieldname] } );
                var total = items.reduce( ( prev, curr) => {
                    prev + parseFloat(curr);
                }, 0 );
                return total;
            },
            mx( val1, val2 ){
                return parseFloat(val1) * parseFloat(val2);
            },
            mult( obj1, field1, obj2, field2 ){
                var first = parseFloat(obj1[field1]);
                var second = parseFloat(obj2[field2]);
                return first * second;
            },
            multSet( obj1, field1, obj2, field2, acc, accField ){
                var first = parseFloat(obj1[field1]);
                var second = parseFloat(obj2[field2]);
                acc[ accField ] = first * second;
                return first * second;
            },
            toggleShowAll(){
                this.showAll = !this.showAll;
            },
            splitCamel(str){

                str = str.replace(/([a-z\xE0-\xFF])([A-Z\xC0\xDF])/g, "$1 $2");
                str = str.toLowerCase(); //add space between camelCase text
                return str;
            },
            lowerCase(str) {
                if(str == null || str == undefined ){

                }else{
                    str = str.toLowerCase();
                }
                return str.toLowerCase();

            },
            upperCase(str) {
                if(str == null || str == undefined ){

                }else{
                    str = str.toUpperCase();
                }
                return str.toUpperCase();
            },
            properCase(str) {
                if(str == null || str == undefined ){

                }else{
                    str = this.lowerCase(str).replace(/^\w|\s\w/g, this.upperCase);
                }
                return str;
            },
            startLoading(){
                this.isLoading = true;
            },
            doneLoading(){
                this.isLoading = false;
            },
            bus(evt, payload){
                bus.$emit(evt, payload );
            },
            beforeToday(date){
                const today = new Date();
                return date >= today;
            },
            untilToday(date){
                const today = new Date();
                return date <= today;
            },
            fromToday(date){
                const today = new Date();
                return date >= today;
            },
            maxTodayNotBefore(date){
                const today = new Date();
                const before = new Date(this.value.DocDate);
                return before > date || date > today;
            },
            viewDocPdf(){
                bus.$emit('viewPdf', this.value.FileUrl );
            },
            generateRandomString(length=6){
                return Math.random().toString(20).substr(2, length);
            },
            maxToday(date){
                const today = new Date();
                return date > today;
            },
            betweenDocDateNow(date){
                const today = new Date();
                const before = new Date(this.DocDate);
                return before > date || date > today;
            },
            minDay(date){
                const today = moment(this.serviceRequestDate);
                return date < today;
            },
            viewPdf(){
                bus.$emit('viewPdf', this.FileUrl );
            },
            getCallCode(){
                if( !_.isEmpty(this.Topic) && !_.isEmpty(this.Function) && !_.isEmpty(this.CoyCode) && !_.isEmpty(this.Feature) && !_.isEmpty(this.MMYY)  ){

                    this.CallCode = this.Topic + '-' + this.CoyCode + '-' + this.Feature + '-' + this.MMYY;

                    if( !_.isEmpty(this.Urut) ){
                        this.FCallCode = this.Topic + '-' + this.CoyCode + '-' + this.Feature + '-' + this.MMYY + '-' + this.Urut;
                    }
                }
            },
            validateData(){
                this.$refs.dmsdialog_veeObserver.validate()
                    .then((valid) => {
                        console.log('validation success',valid);
                        if(valid) {
                            return true;
                        }else{
                            return false;
                        }
                    })
                    .catch((error) => {
                        return false;
                    })
            },
            async saveItem(event) {

                this.$refs.dmsdialog_veeObserver.validate()
                    .then((valid) => {
                        console.log('validation success',valid);
                        if(valid) {
                            console.log( "post dms data")
                            this.postData(event);
                        }else{
                            console.log("invalid form data");
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    })


                // this.$refs.dmsdialog_veeObserver
                //     .validate()
                //     .then((valid) => {
                //         console.log('validation success',valid);
                //         if(valid) {
                //             this.postData(event);
                //         }
                //     })
                //     .catch((error) => {
                //         console.log('validation error',error.);
                //     })
            },
            postData(act){
                var self = this;
                var postData = this.collectData();

                postData.mode = 'add';

                postData.itemId = this.itemId;
                postData.handle = this.handle;
                postData.formMode = this.formMode;
                postData.timestamp = moment().unix();

                var postUrl = this.params.docAddUrl;

                this.savingInProgress = true;
                this.actionState = '';

                console.log('mode', postData.mode );
                console.log('post url', postUrl);

                axios.post( postUrl , postData )
                    .then(response => {
                        console.log(response.data);
                        if(response.data.result == 'OK'){
                            alert(response.data.msg);

                            var rdoc = {
                                docId : response.data.itemId,
                                docCallCode : this.FCallCode
                            };

                            this.$emit('onDocumentSaved', rdoc);
                        }
                        this.savingInProgress = false;
                    })
                    .catch(function(error) {
                        this.savingInProgress = false;
                        console.log(error);
                    });
            },
            collectData(){

                var model_set = {
                    Coy : this.Coy,
                    Function : this.Function,
                    FunctionDesc : this.FunctionDesc,
                    IO : this.IO,
                    IODate : this.IODate,
                    Feature : this.Feature,
                    DocDate : this.DocDate,
                    DocStatus : this.DocStatus,
                    OriginFormat : this.OriginFormat,
                    FCallCode : this.FCallCode,
                    Subject : this.Subject,
                    Tipe : this.Tipe,
                    DocRef : this.DocRef,
                    Scope : this.Scope,
                    TopicObject : this.TopicObject,
                    Topic : this.Topic,
                    TopicDescr : this.TopicDescr,
                    Feature : this.Feature,
                    MMYY : this.MMYY,
                    Urut : this.Urut,
                    NoPage : this.NoPage,
                    NoSheet : this.NoSheet,
                    CallCode : this.CallCode,
                    FCallCode : this.FCallCode,
                    FCallCode : this.FCallCode,
                    Sender : this.Sender,
                    Recipient : this.Recipient,
                    Action : this.Action,
                    Class : this.Class,
                    Copy : this.Copy,
                    Location : this.Location,
                    Store : this.Store,
                    Status : this.Status,
                    Keyword : this.Keyword,
                    ExpDate : this.ExpDate,
                    NotifyTo : this.NotifyTo,
                    RetPer : this.RetPer,
                    RetDate : this.RetDate,
                    DispPer : this.DispPer,
                    DispDate : this.DispDate,
                    Dispatch : this.Dispatch,
                    Boxing : this.Boxing,
                    BoxId : this.BoxId,
                    EndDisp : this.EndDisp,
                    Filestat : this.Filestat,
                    Linked : this.Linked,
                    FileUrl : this.FileUrl,
                    FileObject : this.FileObject,
                    DocBase : this.DocBase,
                    DocPath : this.DocPath,
                    FCallCode : this.FCallCode,
                };
                _.set( model_set, 'ajax', true);
                _.set( model_set, 'handle', this.handle);
                _.set( model_set, 'tz', window.tz);
                return model_set;
            },
            clearDmsForm() {
                _.forEach(this.objectDefault, (val, key)=>{
                    _.set(this, key, val);
                })
            },
            getDocSequence(){

                var entity = this.CallCode;

                const re = this.callCodeUnseqRePattern;
                if( entity == '' || !re.exec(entity) ){
                    alert('Call Code prefix should be complete');
                    return;
                }

                axios.post( this.params.getSeqUrl , { entity: entity, padding: 2 } )
                    .then(response => {
                        console.log(response.data);
                        console.log(response.data.result);
                        if(response.data.result == 'OK'){
                            console.log(response.data.data);
                            var seq = response.data.padded;
                            this.Urut = seq;
                            this.getCallCode();
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            },
            refreshDocUrl(){
                let dt = new Date();
                if( this.FileUrl == '' ){
                    this.docViewUrl = '' ;
                }else{
                    this.docViewUrl = this.FileUrl + '?' + dt ;
                }
            },
            embedQR(){
                const re = this.callCodeRePattern;
                if(this.FCallCode == '' || !re.exec(this.FCallCode) ){
                    alert('Call Code can not be empty or incomplete');
                    return;
                }
                if(_.isEmpty(this.FileObject) || _.isUndefined(this.FileObject) || _.isNull(this.FileObject)){
                    alert('No file to embed in, upload a file first');
                    return;
                }
                var entity = _.cloneDeep(this.FileObject);

                _.set(entity, 'addQR', true);
                _.set(entity, 'FCallCode', this.FCallCode);

                this.isEmbedding = true;

                axios.post( this.params.embedQRUrl , { entity: entity } )
                    .then(response => {
                            console.log(response.data);
                            console.log(response.data.result);
                            if(response.data.result == 'OK'){
                                console.log(response.data.data);
                                let file = response.data.data.file;
                                this.FileUrl = file.FileUrl;
                                this.FileObject = file.FileObject;

                                this.refreshDocUrl();

                                let hasQR = _.get(file.FileObject, 'has_qr' );
                                if( hasQR == false){
                                    alert('QR Embedding failed, probably caused by unsupported pdf format');
                                }
                            }
                            this.isEmbedding = false;
                        })
                    .catch(function(error) {
                        console.log(error);
                    });
            },

        }
    }
</script>

<style scoped>

</style>
