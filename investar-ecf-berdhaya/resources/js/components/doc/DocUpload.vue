<template>
    <div>
        <div style="clear: both;display: block;">
            <vue-clip
                    :on-sending="sending"
                    :on-complete="complete"
                    :options="options">

                <template slot="clip-uploader-action">
                    <div class="drop-pad" >
                        <div class="dz-message text-center">
                            <b-spinner small v-if="isLoading" class="mr-1" ></b-spinner> {{ buttonlabel }}
                        </div>
                    </div>
                </template>

            </vue-clip>
        </div>
        <vue-easy-lightbox
                :visible="lightBoxVisible"
                :imgs="galleryUrls"
                :index="lightBoxindex"
                @hide="lightBoxHandleHide"
        ></vue-easy-lightbox>
    </div>
</template>

<script>
    export default {
        name: "DocUpload",
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value: {
                type: String,
                default: 'images/default_256.jpg'
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
                type: String
            },
            noHandle : {
                type: Boolean,
                default: function(){ return false; }
            },
            qr : {
                type: Boolean,
                default: function(){ return false; }
            },
            qrString : {
                type: String,
                default: ''
            },
            rawUpload : {
                type: Boolean,
                default: function(){ return false; }
            },
            dir : {
                type: String
            },
            filename : {
                type: String
            },
            baseUrl : {
                type: String
            },
            docPath : {
                type: String
            },
            bucket : {
                type: String,
                default: 'docs'
            },
            acceptedFiles: {
                type: [ String, Array, Object],
                default: function(){
                    return 'application/pdf';
                }
            },
            defaulturl : {
                type: String,
                default: 'images/coffee.png'
            },
            buttonlabel : {
                type: String,
                default: 'Click or Drag and Drop files here to upload'
            },
            fileObject : {
                type: [Array, Object],
                default: function () {
                    return {};
                }
            }
        },
        data: function (){
            return {
                isLoading: false,
                options: {
                    url: this.uploadurl,
                    paramName: 'file',
                    acceptedFiles: this.acceptedFiles
                },
                delIcon : false,
                galleryList : [],

                lightBoxVisible: false,
                lightBoxindex: 0,
                showThumbnail: false
            }
        },
        computed: {
            galleryUrls: function(){
                var images = [];
                _.forEach(this.galleryList, img => {
                    if(_.isEmpty(img) || _.get(img, 'url') == '' ){

                    }else{
                        images.push( img.url );
                    }
                });

                this.showThumbnail = !_.isEmpty( images );

                return images;
            }

        },
        watch: {
            value: function(img) {
                this.galleryList = [img];
            }
        },
        methods: {
            showLightBox(index){
                this.lightBoxindex = index;
                this.lightBoxVisible = true;
            },
            lightBoxHandleHide(){
                this.lightBoxVisible = false;
                this.lightBoxindex = 0;
            },
            makeUrl(file){
                if(_.isEmpty(file)){
                    this.delIcon = false;
                    return this.defaulturl;
                }else{

                    var imageurl;

                    if(_.get(file, 'filetype') != '' ){
                        imageurl = ( file.filetype == 'image' )? file.base + file.url : file.base + file.thumbnail;
                    }else{
                        imageurl = file.base + file.url;
                    }

                    var lock = (file.lock === undefined )? false : file.lock ;

                    this.delIcon = !lock;

                    return imageurl;
                }
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
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }

            },
            sending (file, xhr, formData) {
                this.isLoading = true;

                let upbucket = this.bucket;
                let upfilename = this.filename;
                let upqr = this.qr;

                if( _.isNull(this.filename) || this.filename == '' || _.isUndefined(this.filename) ){
                    upbucket = 'tmp';
                    upfilename = this.generateRandomString(10);
                    upqr = false;
                }


                formData.append('handle', this.handle);
                formData.append('m', this.mode);
                formData.append('ns', this.ns);
                formData.append('filename', upfilename);
                formData.append('dir', this.dir);
                formData.append('bucket', upbucket);
                formData.append('nohandle', this.noHandle);
                formData.append('rawupload', this.rawUpload);
                formData.append('qr', upqr);
                formData.append('qrstring', this.qrString);
            },
            complete (file, status, xhr) {
                this.isLoading = false;
                var fobj = { _id: null };
                try {
                    fobj = JSON.parse( xhr.response );
                    console.log(fobj.count);
                    console.log(fobj.data.upload);

                    this.$emit('input', fobj.data.upload.base + fobj.data.upload.url);
                    this.$emit('update:baseUrl', fobj.data.upload.base);
                    this.$emit('update:fileObject', fobj.data.upload);
                    this.$emit('update:docPath', this.dir +'/'+fobj.data.upload.filename);

                }catch (e) {
                    console.log(e.message);
                }

            },
            generateRandomString(length=6){
                return Math.random().toString(20).substr(2, length);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .slideshow-button a:not(:first-child){
        display: none;
    }
    img.fit{
        object-fit: cover;
    }
    .img-title {
        bottom: 5px;
        display: block;
        text-align: center;
        color: #999999;
        padding-top: 5px;
        font-size: 10px;
        overflow-wrap: break-word;
    }
    .img-item {
        width: 150px;
        height: 150px;
        display: block;
        padding: 0px;
        border: lightgray solid thin;

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
</style>
