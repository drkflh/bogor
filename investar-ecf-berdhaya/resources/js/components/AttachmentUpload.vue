<template>
    <div style="display:block;">
        <div style="display:block;">
            <vue-clip
                    :on-sending="sending"
                    :on-complete="complete"
                    :options="options">

                <template slot="clip-uploader-action">
                    <div class="drop-pad" >
                        <div class="dz-message text-center"><b-spinner small v-if="isUploading" class="mr-1" ></b-spinner> {{ buttonlabel }}</div>
                    </div>
                </template>
            </vue-clip>
        </div>
        <div v-if="useCaption">
            <label for="captionInput" v-html="captionLabel" ></label>
            <input type="text" v-model="captionInput" class="form-control" ></input>
        </div>
        <div v-if="showList" style="display:block;">
            <a-config-provider>
                <template #renderEmpty>
                    <div style="text-align: center; font-size: 12pt;border-bottom: thin solid lightgray;">
                        <i class="las la-folder-open"></i>
                    </div>
                </template>
                <a-list item-layout="horizontal" row-key="key" :data-source="fileObjects">
                    <a-list-item slot="renderItem" slot-scope="it, idx">
                        <a-list-item-meta
                        >
                            <span class="btn" v-if="!directViewAction" slot="title" @click="itemClick(it)" >{{ it.filename }}</span>
                            <a v-if="directViewAction" slot="title" :href="it.url">{{ it.filename }}</a>
                            <a-avatar
                                slot="avatar"
                                shape="square"
                                icon="file"
                                @click="itemClick(it)"
                                :src="getThumbnail(it)"
                            />
                            <div slot="description" >
                                <input
                                    v-if="useCaption"
                                    type="text"
                                    v-model="it.caption"
                                    placeholder="add description"
                                    class="form-control"
                                />
                                <br v-if="canCopy" >
                                <input v-if="canCopy" type="text" readonly :ref="it.url" class="form-control" v-model="it.url" />
                            </div>
                        </a-list-item-meta>
                        <a slot="actions">
                            <button class="btn btn-icon" @click="removeFile(it)">
                                <i style="color: red;" class="las la-times-circle"></i>
                            </button><br>
                            <button v-if="useCaption" class="btn btn-icon" @click="saveCaption(it)">
                                <i class="las la-save"></i>
                            </button>
                            <hr v-if="canCopy" >
                            <button v-if="canCopy" class="btn btn-icon" @click="copyToClipboard(it.url)">
                                <i class="las la-copy"></i> URL
                            </button>
                        </a>
                    </a-list-item>
                </a-list>

            </a-config-provider>

        </div>
    </div>
</template>

<script>
    export default {
        name: "AttachmentUpload",
        mounted: function(){
            bus.$on('refresh', (ev, data) => {
                this.refresh();
            });
        },
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value: {
                type: [Array, String],
                default: function(){
                    return [];
                }
            },
            fileObjects: {
                type: [Array, Object, String],
                default: function(){
                    return [];
                }
            },
            showList: {
                type: Boolean,
                default: function(){
                    return true;
                }
            },
            label: {
                type: String,
                default: 'Upload'
            },
            labelFor: {
                type: String,
                default: 'Upload'
            },
            uploadurl : {
                type: String,
                default: 'api/v1/core/upload'
            },
            handle : {
                type: String
            },
            ns : {
                type: String
            },
            mode : {
                type: String,
                default: 'multi'
            },
            bucket : {
                type: String,
                default: 'document'
            },
            defaulturl : {
                type: String,
                default: 'images/coffee.png'
            },
            acceptedFiles: {
                type: [ String, Array, Object],
                default: function(){
                    return 'image/*,video/*,audio/*,application/pdf';
                }
            },
            directViewAction : {
                type: Boolean,
                default: function(){
                    return false;
                }
            },
            returnArray : {
                type: Boolean,
                default: function(){
                    return false;
                }
            },
            canCopy : {
                type: Boolean,
                default: function(){
                    return false;
                }
            },
            buttonlabel : {
                type: String,
                default: 'Click or Drag and Drop files here to upload'
            },
            captionUrl : {
                type: String,
                default: 'api/v1/core/upload/caption'
            },
            captionLabel : {
                type: String,
                default: 'Description'
            },
            useCaption: {
                type: Boolean,
                default: function(){
                    return false;
                }
            },
            captionRequired: {
                type: Boolean,
                default: function(){
                    return false;
                }
            },
            extraData: {
                type: [Object, Array, String],
                default: function(){
                    return {};
                }
            }
        },
        data: function (){
            return {
                options: {
                    url: this.uploadurl,
                    paramName: 'file',
                    acceptedFiles: this.acceptedFiles
                },
                images : [],
                docs : [],
                delIcon : false,
                galleryUrls : [],

                isUploading: false,

                lightBoxVisible: false,
                lightBoxindex: 0,
                captionInput: ''

            }
        },
        watch: {
            value: function(files) {
                console.log(this.galleryList);
            }
        },
        methods: {
            itemClick(obj){
                var payload = { selected : obj, items : this.fileObjects, images : this.images, docs : this.docs };
                if(this.directViewAction){
                    bus.$emit('openlightbox', payload);
                }else{
                    this.$emit('onattachmentitemclick', payload );
                }
            },
            copyToClipboard(id){
                var item = this.$refs[id];
                if (navigator && navigator.clipboard && navigator.clipboard.writeText){
                    item.select();
                    item.setSelectionRange(0, 99999);
                    document.execCommand('copy');
                }else{
                    alert('Can not copy to clipboard');
                }
            },
            getThumbnail(obj){
                if( !this.isDoc(obj.url) && obj.filetype == 'image'){
                    return obj.url;
                }else{
                    return this.defaulturl;
                }
            },
            isDoc(file) {
                var extension = file.substr((file.lastIndexOf('.') +1));
                if (/(pdf|zip|doc)$/ig.test(extension)) {
                    return true;
                }else{
                    return false;
                }
            },
            separateImages(objs){
                var imgs = [];
                var docs = [];

                _.forEach(objs, (obj)=>{
                    if(obj.type == 'image'){
                        imgs.push(obj.url);
                    }else{
                        docs.push(obj.url);
                    }
                });

                this.images = imgs;
                this.docs = docs;
            },
            saveCaption(file){
                axios.post( this.captionUrl,
                    {
                        fileObject : file,
                        fileObjects : this.fileObjects,
                        mode: this.mode,
                        extraData : this.extraData
                    })
                    .then( response => {
                        console.log(response.data);
                        if(response.data.result == 'OK'){
                            console.log(response.data.data.upload);
                            this.$emit('input', response.data.data.files);
                            this.$emit('update:fileObjects', response.data.data.files );
                        }
                    })
                    .catch( error=> {
                        console.log(error);
                    });
            },
            removeFile(file){
                console.log(file);
                var r = confirm("Delete file ?");
                if (r == true) {
                    axios.post(this.uploadurl + '/del', {
                        handle: this.handle,
                        files: file,
                        m: this.mode,
                        ns: this.ns
                    })
                    .then( response => {
                        console.log(response.data.data.upload);
                        this.$emit('input', response.data.data.upload);
                        this.$emit('update:fileObjects', response.data.data.upload );
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }

            },
            generateRandomString(length=6){
                return Math.random().toString(20).substr(2, length);
            },
            sending (file, xhr, formData) {
                var newhandle = '';
                if(this.handle == ''){
                    newhandle = this.generateRandomString(5);
                    this.$emit('update:handle', newhandle );
                }else{
                    newhandle = this.handle;
                }
                formData.append('handle', newhandle);
                formData.append('m', this.mode);
                formData.append('ns', this.ns);
                formData.append('bucket', this.bucket);
                formData.append('ra', this.returnArray);
                formData.append('fileObjects', this.fileObjects);
                this.isUploading = true;
                if(this.useCaption){
                    // if(this.captionInput == '' && this.captionRequired){
                    //     alert('Please fill ' + this.captionLabel);
                    // }
                    formData.append('caption', this.captionInput);
                }else{
                    formData.append('caption', '');
                }
            },
            complete (file, status, xhr) {
                var fobj = { _id: null };
                try {
                    fobj = JSON.parse( xhr.response );
                    console.log( 'file response', fobj );
                    console.log( 'file response data', fobj.data );
                    this.captionInput = '';

                    this.separateImages(fobj.data.files);
                    this.$emit('update:fileObjects', fobj.data.files );
                    if(this.mode == 'multi'){
                        this.$emit('input', fobj.data.urls);
                    }else{
                        if(_.isArray(fobj.data.urls) && !_.isEmpty(fobj.data.urls) ){
                            this.$emit('input', fobj.data.urls.shift() );
                        }else{
                            this.$emit('input', fobj.data.urls);
                        }
                    }

                }catch (e) {
                    alert(e.message);
                    //console.log(e.message);
                }
                this.isUploading = false;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .slideshow-button a:not(:first-child){
        display: none;
    }
    .img-title {
        display: block;
        opacity: 0.65;
        padding: 5px;
        font-size: 11px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100%;
        min-height: 25%;
    }
    .img-thumbnail{
        width: 60px;
        height: 60px;
        min-width: 60px;
        object-fit: cover;
        border: none;
        border-radius: 25% !important;
        box-shadow: grey 2px 2px 6px;
    }

    .img-thumbnail-small{
        position:relative;
        width:100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .img-item {
        width: 150px;
        height: 200px;
        display: block;
        float: left;
        margin-right: 10px;
    }
    .img-item-small {
        width: 150px;
        height: 150px;
        float: left;
        margin: 5px;
        border: thin solid lightgrey;
        display: block;
    }
    .h-list {
        display: inline;
        list-style-type: none;
    }
    .center {
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
    .drop-pad {
        width: 100%;padding: 12px;
        margin-top: 8px;
        border: #0a4b3e dashed thin;cursor:pointer;
        border-radius: 4px;
    }

    .scroll-container{
        max-width: 100%;
        overflow-x: auto;
    }

    .ant-list-item-meta-description {
        color: #0a4b3e;
        font-size: 9pt;
    }
    .ant-list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px !important;
    }
    .ant-list-item-action {
        flex: 0 0 auto;
        margin-left: 16px !important;
        padding: 0;
        font-size: 0;
        list-style: none;
    }
    h4.ant-list-item-meta-title{
        margin-bottom: 0px;
        color: rgba(0, 0, 0, 0.65);
        font-size: 10pt !important;
        line-height: 22px;
        margin-top: 4px !important;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100%;
        max-width: 250px;
    }
    .ant-list-item-meta-avatar {
        margin-right: 16px;
        margin-top: 8px;
    }
    .anticon{
        vertical-align: 0px !important;
    }
    hr{
        padding: 0px;
        margin: 4px;
    }


</style>
