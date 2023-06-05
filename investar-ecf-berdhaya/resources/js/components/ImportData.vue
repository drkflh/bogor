<template>
    <div style="display:block; width: 100%;" >
        <div style="display:block; width: 100%;" >
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
        <div  style="display:table; width: 100%;">
            <div style="display: table-row;width: 100%;border-bottom: thin solid #cbcbcb">
                <div style="display:table-cell;height:fit-content; margin: 0px ;margin-top: 6px ; vertical-align: middle; cursor: pointer; float: left; padding: 8px;">
                    <h6>Data Preview</h6>
                </div>
                <div style="display:table-cell;height:fit-content; margin: 0px ;margin-top: 6px ; vertical-align: middle; cursor: pointer; float: left; padding: 8px;">
                    <b-form-checkbox v-model="importAll" name="check-button" switch size="lg">
                        Import all data
                    </b-form-checkbox>
                </div>
                <template v-if="!hideUtilButton">
                    <div
                        v-on:click="downloadTemplate()"
                        class="btn btn-outline-primary pull-right"
                        style="display:table-cell;height:fit-content; width: fit-content; margin: 0px ;margin-top: 6px ; vertical-align: middle; cursor: pointer; float: right; padding: 8px;">
                        <i class="las la-download"></i> XLS Template
                    </div>
                </template>
            </div>
        </div>
        <div  style="display:table; width: 100%;">
            <live-table
                ref="tab"
                :data-url="getDataUrl()"
                :columns="columns"
                :extra-data="tableExtraData"
                :selected-keys.sync="selectedDataKeys"
            >
            </live-table>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ImportData',
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
            importid : {
                type: [String, Number]
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
            loading : {
                type: Boolean,
                default: function(){return false}
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
            },
            selectedKeys: {
                type: [Object, Array, String],
                default: function(){
                    return [];
                }
            },
            importAllData: {
                type: Boolean,
                default: function(){
                    return false;
                }
            }
        },
        data: function (){
            return {
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
                importAll : false,
                titleData : '',
                auxData : {},
                uploadResult : {},
                commitResult : {},
                selectedDataKeys : []
            }
        },
        watch: {
            selectedDataKeys: function(val){
                this.$emit('update:selectedKeys', this.selectedDataKeys);
            },
            importAll: function(val){
                this.$emit('update:importAllData', this.importAll);
            },
            isLoading: function(){
                this.$emit('update:loading', this.isLoading);
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
                formData.append('filename', file.name);
                formData.append('m', this.mode);
                formData.append('ns', this.ns);
                formData.append('importAll', this.importAll);
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
            downloadTemplate(){
                console.log( this.downloadTmplUrl,  this.previewheadings);
                this.isLoading = true;
                axios.post(this.downloadTmplUrl, {
                    headings : this.previewheadings,
                    includeData : false,
                    selectedKeys : this.selectedKeys,
                    importAll : this.importAll
                })
                    .then( response => {
                        this.isLoading = false;
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
        padding: 12px;
        margin-top: 8px;
        border: #0a4b3e dashed thin;
        border-radius: 4px;
        cursor:pointer;
        max-width: 50%;
    }
</style>
