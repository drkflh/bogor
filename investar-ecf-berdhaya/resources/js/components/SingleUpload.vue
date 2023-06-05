<template>
    <div>
        <div style="clear: both;display: block;">
            <div style="display: block;position:relative;height:200px;width:300px;min-height: 150px;top: 0;left: 0;margin: auto;">
                    <vue-clip
                        :on-sending="sending"
                        :on-complete="complete"
                        :options="options">

                        <template slot="clip-uploader-action">
                            <div class="dz-message" style="cursor: pointer;padding:4px;">
                                <div class="dz-message" v-html="buttonTemplate" style="display: inline-block;margin-right: 4px;"></div>
                                <b-spinner v-if="isLoading"  small variant="secondary"  style="margin-right:20px;" ></b-spinner>
                            </div>
                        </template>
                    </vue-clip>
            </div>
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
        name: "SingleUpload",
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
            defaulturl : {
                type: String,
                default: 'images/coffee.png'
            },
            buttonLabel : {
                type: String,
                default: 'Click or Drag and Drop files here to upload'
            },
            buttonTemplate : {
                type : String,
                default : '<span>Upload Document</span>'
            },
            acceptedFiles: {
                type: [ String, Array, Object],
                default: function(){
                    return 'application/pdf';
                }
            },
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
                        if (_.isString(img)){
                            images.push(img);
                        } else if (_.has(img, 'url')) {
                            images.push(_.get(img, 'url'));
                        }
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
                formData.append('handle', this.handle);
                formData.append('m', this.mode);
                formData.append('ns', this.ns);
            },
            complete (file, status, xhr) {
                this.isLoading = false;
                var fobj = { _id: null };
                try {
                    fobj = JSON.parse( xhr.response );
                    console.log(fobj.count);
                    console.log(fobj.data.upload);

                    this.$emit('input', fobj.data.upload.base + fobj.data.upload.url);

                }catch (e) {
                    console.log(e.message);
                }

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
        width: 100%;padding: 12px;margin-top: 8px; border: #0a4b3e dashed thin;cursor:pointer;
    }
</style>
