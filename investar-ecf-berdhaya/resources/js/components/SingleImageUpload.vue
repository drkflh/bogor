<template>
    <div class="card" style="width: 200px;" >
        <div class="card-body text-center">
            <div style="clear: both;display: block;">
                <div v-show="showThumbnail" class="img-item" >
                    <div  class="text-center img-thumbnail"  style="display: block;position:relative;height:150px;max-height: 150px;">
                        <img :src="makeUrl(value)" @click="showLightBox( 0 )" class="center" style="max-width:140px;max-height: 140px;height:auto;cursor:pointer;" >
                        <span v-show="delIcon" v-on:click="removeFile(value)" class="btn" style="position:absolute;padding: 8px;cursor: pointer;bottom: 2px;right:2px;background-color: white;" >
                            <i class="las la-trash-alt" style="color:red;"></i>
                        </span>
                    </div>
                    <div class="img-title" v-html="makeTitle(value)"></div>
                </div>
            </div>
            <vue-easy-lightbox
                    :visible="lightBoxVisible"
                    :imgs="galleryUrls"
                    :index="lightBoxindex"
                    @hide="lightBoxHandleHide"
            ></vue-easy-lightbox>
        </div>
        <div class="card-footer">
            <vue-clip
                    :on-sending="sending"
                    :on-complete="complete"
                    :options="options">

                <template slot="clip-uploader-action">
                    <div class="drop-pad" >
                        <div class="dz-message text-center">{{ buttonlabel }}</div>
                    </div>
                </template>

            </vue-clip>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SingleImageUpload",
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
            buttonlabel : {
                type: String,
                default: 'Click or Drag and Drop files here to upload'
            }
        },
        data: function (){
            return {
                options: {
                    url: this.uploadurl,
                    paramName: 'file'
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
                console.log(img);

                if(_.isEmpty(img) || _.get(img, 'url') == '' ){

                }else{

                    var thumb = ( img.filetype == 'image' )? img.base + img.url : img.base + img.thumbnail;
                    var imageurl = ( img.filetype == 'image' )? img.base + img.url : img.base + img.thumbnail;
                    var lock = _.get(img, 'lock');

                    var imageThumb = {
                        _id: img._id,
                        url: imageurl, // origin image source
                        thumbnail: thumb, // thumbnail source
                        width: ( img.filetype == 'image' )? '150px': 'auto', // thumbnail width
                        height: 'auto', // thumbnail height
                        title: img.filename, // Image name which shows in footer
                        class: 'img-thumbnail',
                        lock: lock
                    };
                    this.galleryList = [imageThumb];
                }
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
            makeTitle(file){

                if(_.isEmpty(file)){
                    return "";
                }else{
                    return file.filename;
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
                formData.append('handle', this.handle);
                formData.append('m', this.mode);
                formData.append('ns', this.ns);
            },
            complete (file, status, xhr) {
                var fobj = { _id: null };
                try {
                    fobj = JSON.parse( xhr.response );
                    console.log(fobj.count);
                    console.log(fobj.data.upload);
                    this.$emit('input', fobj.data.upload);

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
        height: 180px;
        display: block;
        margin: auto;
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
