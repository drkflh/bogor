<template>
    <div class="card">
        <div class="card-header">
            <label :for="labelFor">{{ label }}</label>
            <button v-if="!docStrip" class="btn btn-secondary pull-right" @click="showLightBox( 0 )" ><i class="las la-tv"></i></button>
        </div>
        <div class="card-body">
            <div style="clear: both; overflow-x: auto ;display: block;max-height:275px;">
                <swiper v-if="!disableSwiper" :options="swiperOption" >
                    <div class="swiper-button-prev" slot="button-prev"></div>
                    <swiper-slide  v-for="img in value" :key="img._id" >
                        <div :class="[ docStrip?'img-item-small':'img-item']">
                            <div  :class="[ docStrip?'img-thumbnail-small':'img-thumbnail', 'text-center' ]">
                                <img :src="img.thumbnail" @click="showLightBox( img )"
                                     class="center" style="max-width:140px;max-height: 140px;height:auto;cursor:pointer;"
                                />
                                <div v-if="!docStrip" class="img-title" v-html="img.title"></div>
                                <span v-show="!isLocked(img.lock)" v-on:click="removeFile(img)" class="btn" style="position:absolute;padding: 8px;cursor: pointer;top: 2px;left:2px;background-color: white;" >
                                        <i class="las la-times-circle" style="color:red;"></i>
                                </span>
                            </div>
                        </div>
                    </swiper-slide>
                    <div class="swiper-button-next" slot="button-next"></div>
                    <div class="swiper-pagination" slot="pagination"></div>
                </swiper>
                <div v-if="disableSwiper" >
                    <div v-if="!disableSwiper" class="swiper-button-prev" slot="button-prev"></div>
                    <div  v-for="img in value" :key="img._id" >
                        <div :class="[ docStrip?'img-item-small':'img-item']">
                            <div  :class="[ docStrip?'img-thumbnail-small':'img-thumbnail', 'text-center' ]">
                                <img :src="img.thumbnail" @click="showLightBox( img )"
                                     class="center" style="max-width:140px;max-height: 140px;height:auto;cursor:pointer;"
                                />
                                <span v-show="!isLocked(img.lock)" v-on:click="removeFile(img)" class="btn" style="position:absolute;padding: 8px;cursor: pointer;top: 2px;left:2px;background-color: white;" >
                                        <i class="las la-times-circle" style="color:red;"></i>
                                </span>
                            </div>
                            <div class="img-title" v-html="img.title"></div>
                        </div>
                    </div>
                    <div v-if="!value.length > 0" style="display: block;height:55px;padding-top:12px;"  >No Document</div>
                    <div v-if="!disableSwiper" class="swiper-button-next" slot="button-next"></div>
                    <div v-if="!disableSwiper" class="swiper-pagination" slot="pagination"></div>
                </div>
            </div>
            <pdf-light-box
                    ref="lightBox"
                :show="lightBoxVisible"
                :doc-url="docUrl"
                    :max-height="maxHeight"
            >
            </pdf-light-box>
        </div>
        <div class="card-footer">
            <vue-clip
                    v-show="!hideUploader"
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
    import PdfLightBox from "./PdfLightBox";
    export default {
        name: "MultiPdfUpload",
        components: {PdfLightBox},
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
                type: Array,
                default: function(){
                    return [];
                }
            },
            disableSwiper:{
                type: Boolean,
                default: false
            },
            docStrip: {
                type: Boolean,
                default: false
            },
            hideUploader: {
                type: Boolean,
                default: false
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
                type: String
            },
            defaulturl : {
                type: String,
                default: 'images/coffee.png'
            },
            buttonlabel : {
                type: String,
                default: 'Click or Drag and Drop files here to upload'
            },
            slidesPerView: {
                type: [Number,String],
                default: 4
            },
            spaceBetween: {
                type: [Number,String],
                default: 20
            },
            maxHeight: {
                type: Number,
                default: 800
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
                docUrl: '',

                swiperOption: {
                    slidesPerView: this.slidesPerView,
                    spaceBetween: this.spaceBetween,
                    watchOverflow: true,
                    freeMode: true,
                    pagination: {
                        el: '.swiper-pagination',
                        type: 'fraction'
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev'
                    },
                    // breakpoints: {
                    //     1024: {
                    //         slidesPerView: 4,
                    //         spaceBetween: 40
                    //     },
                    //     768: {
                    //         slidesPerView: 3,
                    //         spaceBetween: 30
                    //     },
                    //     640: {
                    //         slidesPerView: 2,
                    //         spaceBetween: 20
                    //     },
                    //     320: {
                    //         slidesPerView: 1,
                    //         spaceBetween: 10
                    //     }
                    // }
                }
            }
        },
        watch: {
            value: function(files) {
                this.galleryList = this.imageUrls(files);
                //console.log(this.galleryList);
            }
        },
        computed: {
            galleryUrls: function(){
                this.galleryList = this.imageUrls(this.value);

                var images = [];
                _.forEach(this.galleryList, img => {
                    if(_.isEmpty(img) || _.get(img, 'url') == '' ){

                    }else{
                        images.push( img.url );
                    }
                });
                return images;
            }
        },
        methods: {
            refresh() {
                this.galleryList = this.imageUrls(this.value);
                //console.log(this.galleryList);
            },
            isLocked(lock){
              if(this.docStrip){
                  return true;
              }else{
                  return lock;
              }
            },
            showLightBox(img){
                this.lightBoxindex = this.value.indexOf(img);
                var doc = img;
                this.docUrl = doc.url;
                this.$refs.lightBox.showBox();
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
            imageUrls(files){
                //console.log('files', files);
                var defUrl = this.defaulturl;
                if(_.isEmpty(files)){

                    var imageThumb = {
                        url: defUrl, // origin image source
                        thumbnail: defUrl, // thumbnail source
                        width: '150px', // thumbnail width
                        height: 'auto', // thumbnail height
                        title: 'No Image', // Image name which shows in footer
                        class: 'img-thumbnail',
                        lock: true
                    };
                    return [imageThumb];
                }else{
                    var images = [];
                    var idx = 500;
                    _.forEach(files, img => {
                        if(_.isEmpty(img) || _.get(img, 'url') == '' ){
                            //console.log( 'fileobject', 'empty' );

                        }else{

                            if(_.has(img, 'base')){

                                //console.log( 'fileobject', img.url );

                                var thumb = img.base + img.thumbnail;

                                var imageurl = img.base + img.url;

                                var lock = _.get(img, 'lock');

                                lock = (lock === undefined )? false : lock ;

                                var _id = img._id;

                                var iwidth = ( img.filetype == 'image' )? '150px': 'auto';

                                var ititle = img.filename;
                            }else{

                                //console.log( 'urlonly', img.url );

                                var thumb = img.thumbnail;

                                var imageurl = img.url;

                                var lock = true;

                                var _id = idx++;

                                var iwidth = 'auto';

                                var ititle = img.url;

                            }

                            var imageThumb = {
                                _id: _id,
                                url: imageurl, // origin image source
                                thumbnail: thumb, // thumbnail source
                                width: iwidth, // thumbnail width
                                height: 'auto', // thumbnail height
                                title: ititle, // Image name which shows in footer
                                class: 'img-thumbnail',
                                lock: lock
                            };
                            //console.log( imageThumb );

                            images.push( imageThumb );
                        }
                    });
                    return images;
                }
            },

            removeFile(file){
                //console.log(file);
                var r = confirm("Delete file ?");
                if (r == true) {
                    axios.post(this.uploadurl + '/del', {
                        handle: this.handle,
                        files: file,
                        m: this.mode,
                        ns: this.ns
                    })
                    .then( response => {
                        //console.log(response.data.data.upload);
                        this.$emit('input', response.data.data.upload);
                    })
                    .catch(function (error) {
                        //console.log(error);
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
                    //console.log(fobj.count);
                    //console.log(fobj.data.upload);
                    this.$emit('input', fobj.data.upload);

                }catch (e) {
                    //console.log(e.message);
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
        /* left: -0.08rem; */
        display: block;
        text-align: center;
        color: black;
        padding: 5px;
        font-size: 11px;
        overflow-wrap: break-word;
        width: 130px;
        min-height: 25%;
    }
    .img-thumbnail{
        display: block;
        position:relative;
        height:150px;
        max-height: 150px;
    }

    .img-thumbnail-small{
        display: block;
        position:relative;
        height:64px;
        max-height: 150px;
    }

    .img-item {
        width: 150px;
        height: 200px;
        display: block;
        float: left;
        margin-right: 10px;
    }
    .img-item-small {
        height: 100px;
        display: block;
        float: left;
        margin-right: 10px;
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
