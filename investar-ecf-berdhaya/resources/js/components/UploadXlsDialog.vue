<template>
    <div style="display:inline-block;">
        <button v-if="!noButton" v-on:click="openModal()"
                :class="buttonClass"
                :disabled="disabled"
                style="height:fit-content; margin: 0px ; cursor: pointer; padding: 8px;">
            <i :class="iconClass"> </i><span v-html="buttonText" :class="buttonTextClass"></span>
        </button>

        <b-modal :id="modalId"
                 @ok="commitData"
                 ok-title="Commit"
                 :size="modalSize"
                 :title="getTitle()"
                 no-close-on-esc
                 no-close-on-backdrop
                 scrollable
                 :hide-backdrop="hideBackdrop"
                 @hidden="onHidden"
                 @shown="onShown"
                 modal-class="modal-bv" >

            <div style="display:block; width: 100%;text-align: center;" >
                <vue-clip
                    :on-sending="sending"
                    :on-complete="complete"
                    :options="options">

                    <template slot="clip-uploader-action">
                        <div class="drop-pad" >
                            <div class="dz-message text-center">{{ buttonlabel }}
                                <span v-if="isLoading" class="pull-right" style="float: right;">
                                <b-spinner  variant="primary"></b-spinner>
                            </span>
                            </div>
                        </div>
                    </template>

                </vue-clip>
            </div>
            <div  style="display:block; width: 100%;text-align:left;">
                <div style="display: table;width: 100%;border-bottom: thin solid #cbcbcb">
                    <template v-if="!hideUtilButton">
                        <div
                            v-on:click="downloadTemplate()"
                            class="pull-right" style="height:fit-content; margin: 0px ;margin-top: 6px ; vertical-align: middle; cursor: pointer; float: right; padding: 8px;">
                            <i class="las la-download"></i> XLS Template
                        </div>
                    </template>
                </div>

                <label>Data Preview</label>
                <live-table
                    ref="tab"
                    :data-url="getDataUrl()"
                    :columns="columns"
                    :extra-data="tableExtraData"
                >
                </live-table>
            </div>

        </b-modal>

    </div>
</template>

<script>
    export default {
        name: 'UploadXlsDialog',
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value: {
                type: [Object, String],
                default: function(){
                    return {};
                }
            },
            buttonText : {
                type: String,
                default: 'Upload Data File'
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
            commiturl : {
                type: String,
                default: 'api/v1/core/import/commit'
            },
            uploadurl : {
                type: String,
                default: 'api/v1/core/import/upload'
            },
            sourceurl : {
                type: String,
                default: 'api/v1/core/import/source'
            },
            previewheadings : {
                type: [Array, Object],
                default: function(){
                    return [];
                }
            },
            previewcolumns : {
                type: Array,
                default: function(){
                    return [];
                }
            },
            downloadTmplUrl : {
                type: String,
                default: ''
            },
            handle : {
                type: String
            },
            ns : {
                type: String
            },
            mode : {
                type: String,
                default: 'single'
            },
            defaulturl : {
                type: String,
                default: 'images/coffee.png'
            },
            buttonlabel : {
                type: String,
                default: 'Upload XLS / CSV file'
            },
            modalId : {
                type: String,
                default: 'uploaderModal'
            },
            modalSize: {
                type: String,
                default: 'xl'
            },
            hideUtilButton: {
                type: Boolean,
                default: function(){
                    return false;
                }
            },
            disabled: {
                type: Boolean,
                default: function(){
                    return false;
                }
            },
            auxOverrides: {
                type: [Array, String, Object],
                default: function(){
                    return [];
                }
            },
            tableExtraData: {
                type: [Object, Array, String],
                default: function(){
                    return {};
                }
            },
            resultGroupBy: {
                type: String,
                default: ''
            }
        },
        data: function (){
            return {
                isLoading: false,
                options: {
                    url: this.uploadurl,
                    paramName: 'file'
                },
                columns: this.previewcolumns,
                taboptions: {
                    filterable: false,

                    headings: this.previewheadings,
                    requestFunction: (data) => {
                        var url = this.sourceurl + '?importid=' + this.importid;
                        return axios.post(url, {
                            params: data
                        }).catch(function (e) {
                            console.log(e);
                            //this.dispatch('error', e);
                        });
                    }
                },
                delIcon : false,
                galleryList : [],
                hideBackdrop : false,
                isLoading : false,
                importid : '',
                titleData : '',
                auxData : {},
                uploadResult : {},
                commitResult : {}
            }
        },
        methods: {
            getDataUrl(){
                var url = this.sourceurl + '?importid=' + this.importid;
                return url;
            },
            removeFile(file){
                console.log(file);
                var r = confirm("Delete file ?");
                if (r == true) {
                    axios.post(this.uploadurl + '/del', {
                        importid: this.importid,
                        handle: this.handle,
                        files: file,
                        m: this.mode,
                        ns: this.ns
                    })
                        .then( response => {
                            //this.$refs.tab.refresh();
                            this.$refs.tab.loadTableData();
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }

            },
            sending (file, xhr, formData) {
                this.isLoading = true;
                formData.append('importid', this.importid);
                formData.append('handle', this.handle);
                formData.append('m', this.mode);
                formData.append('ns', this.ns);
                formData.append('aux', JSON.stringify(this.auxData));
                formData.append('auxOverrides', this.auxOverrides);
                formData.append('resultGroupBy', this.resultGroupBy);
            },
            complete (file, status, xhr) {
                console.log( 'complete', status, xhr.response );
                this.uploadResult = JSON.parse( xhr.response );
                this.$emit('uploaded', this.uploadResult );
                this.isLoading = false;
                //this.$refs.tab.refresh();
                this.$refs.tab.loadTableData();
            },
            getTitle(){
                return this.buttonText + ' ' + this.titleData;
            },
            setTitleData(val){
                this.titleData = val;
            },
            setAuxData(obj){
                this.auxData = obj;
            },
            clearData(){
                this.auxData = {};
            },
            openModal(){
                this.editObj = {};
                this.editObj = _.cloneDeep(this.objectDefault);
                this.importid = this.generateRandomString(6);
                this.$bvModal.show(this.modalId);
            },
            closeModal(){
                this.editIndex = 0;
                this.editObj = _.cloneDeep(this.objectDefault);
                this.$bvModal.hide(this.modalId);
            },
            onHidden(){
                this.clearData();
                this.$emit('hidden');
            },
            onShown(){
                this.$emit('shown');
            },
            commitData() {
                var url = this.commiturl + '?importid=' + this.importid;
                return axios.post(url, {
                    groupBy : this.resultGroupBy,
                    aux : this.auxData,
                    params: {}
                }).then(response => {
                    if (response.data.result == 'OK') {
                        this.$emit('commited', response.data);
                        this.closeModal();
                    }
                }).catch(function (e) {
                    this.dispatch('error', e);
                });
            },
            downloadTemplate(){
                console.log( this.downloadTmplUrl,  this.previewheadings);
                axios.post(this.downloadTmplUrl, {
                    headings : this.previewheadings,
                    includeData : false
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
            }
        }
    }
</script>

<style scoped>
    .drop-pad {
        width: 100%;
        height: 100%;
        min-height: 100px;
        padding: 12px;
        margin-top: 8px;
        border: #0a4b3e dashed thin;
        border-radius: 4px;
        cursor:pointer;
        max-width: 100%;
    }
    .ant-table-pagination.ant-pagination {
        float: left;
        margin: 16px;
    }
</style>
