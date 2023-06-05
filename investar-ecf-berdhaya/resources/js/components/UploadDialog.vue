<template>
    <div style="display:inline-block;">
        <button v-if="!noButton" v-on:click="openModal()"
                :class="buttonClass"
                style="height:fit-content; margin: 0px ; cursor: pointer; padding: 8px;">
            <i :class="iconClass"> </i><span v-html="buttonText" :class="buttonTextClass"></span>
        </button>

        <b-modal :id="modalId"
                 @ok="closeModal"
                 :size="modalSize"
                 :title="getTitle()"
                 no-close-on-esc
                 no-close-on-backdrop
                 scrollable
                 :hide-backdrop="hideBackdrop"
                 @hidden="onHidden"
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
        </b-modal>

    </div>
</template>

<script>
    export default {
        name: 'UploadDialog',
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
                type: String
            },
            defaulturl : {
                type: String,
                default: 'images/coffee.png'
            },
            buttonlabel : {
                type: String,
                default: 'Upload file'
            },
            modalId : {
                type: String,
                default: 'uploaderModal'
            },
            modalSize: {
                type: String,
                default: 'md'
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
                titleData : '',
                auxData : {}
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
                formData.append('aux', this.auxData);
            },
            complete (file, status, xhr) {
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
            openModal(){
                this.editObj = {};
                this.editObj = _.cloneDeep(this.objectDefault);
                this.$bvModal.show(this.modalId);
            },
            closeModal(){
                this.editIndex = 0;
                this.editObj = _.cloneDeep(this.objectDefault);
                this.$bvModal.hide(this.modalId);
            },
            onHidden(){
                this.$emit('hidden');
            }
        }

    }
</script>

<style scoped>
    .drop-pad {
        width: 100%;
        height: 100%;
        min-height: 150px;
        padding: 12px;
        margin-top: 8px;
        border: #0a4b3e dashed thin;
        border-radius: 4px;
        cursor:pointer;
        max-width: 100%;
    }
</style>
