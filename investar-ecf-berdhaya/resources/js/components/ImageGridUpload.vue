<template>
    <div style="display: block;">
        <div class="row">
            <div v-for="(img, index) in galleryUrls" :key="index"
                 class="gallery_product"
                 v-bind:class="gridClass"
            >
                <img :src="img" :alt="img" class="img-responsive" @click="showLightBox( index )" >
            </div>

            <vue-easy-lightbox
                    :visible="lightBoxVisible"
                    :imgs="galleryUrls"
                    :index="lightBoxindex"
                    @hide="lightBoxHandleHide"
            ></vue-easy-lightbox>
        </div>
        <div style="display: block;">
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
    export default {
        name: "ImageGridUpload",
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
                type: [String, Array],
                default: function(){
                    return [];
                }
            },
            externalLightbox: {
                type: Boolean,
                default: false
            },
            fixedGrid: {
                type: Boolean,
                default: false
            },
            fixedGridColumn: {
                type: Number,
                default: 2 //max of 4
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
            showPresentButton: {
                type: Boolean,
                default: false
            }

        },
        computed: {
            gridClass: function(){
                if(this.fixedGrid){
                    var col = parseInt(this.fixedGridColumn);
                    col = ( col > 4)?4:col;
                    col = ( col < 1)?1:col;
                    var colclass = Math.floor( 12 / col );
                    return 'col-' + colclass;

                }else{
                    return 'col-xl-3 col-lg-4 col-md-4 col-sm-6 col-xs-6';
                }
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
                galleryUrls : [],

                lightBoxVisible: false,
                lightBoxindex: 0,

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
                    }
                }
            }
        },
        watch: {
            value: function(files) {
                this.galleryList = this.imageUrls(files);
                console.log(this.galleryList);
            },
            galleryList: function(val){
                var images = [];
                _.forEach(this.galleryList, img => {
                    if(_.isEmpty(img) || _.get(img, 'url') == '' ){

                    }else{
                        images.push( img.url );
                    }
                });
                this.galleryUrls = images;
            }
        },
        methods: {
            refresh() {
                this.galleryList = this.imageUrls(this.value);
                console.log(this.galleryList);
            },
            isLocked(lock){
                if(this.docStrip){
                    return true;
                }else{
                    return lock;
                }
            },
            showLightBox(index){

                if(this.externalLightbox){
                    bus.$emit('openlightbox', {
                        gallery: this.galleryUrls,
                        index: index
                    });
                }else{
                    this.lightBoxindex = index;
                    this.lightBoxVisible = true;
                }
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
                        var b = _.isNull(file, 'base') ? '' : _.get(file, 'base');
                        imageurl = ( file.filetype == 'image' )? b + file.url : b + file.thumbnail;
                    }else{
                        var b = _.isNull(file, 'base') ? '' : _.get(file, 'base');
                        imageurl = b + file.url;
                    }

                    var lock = (file.lock === undefined )? false : file.lock ;

                    this.delIcon = !lock;

                    return imageurl;
                }
            },
            imageUrls(files){
                console.log('files', files);
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
                    //return [imageThumb];
                    return [];
                }else{
                    var images = [];
                    var idx = 500;
                    _.forEach(files, img => {
                        if(_.isEmpty(img) || _.get(img, 'url') == '' ){
                            console.log( 'fileobject', 'empty' );

                        }else{

                            if(_.has(img, 'base')){

                                console.log( 'fileobject', img.url );

                                var b = _.isNull(img, 'base') ? '' : _.get(img, 'base');

                                var thumb = b + img.thumbnail;


                                var imageurl = ( img.filetype == 'image' )? b + img.url : b + img.thumbnail;

                                var lock = _.get(img, 'lock');

                                lock = (lock === undefined )? false : lock ;

                                var _id = img._id;

                                var iwidth = ( img.filetype == 'image' )? '150px': 'auto';

                                var ititle = img.filename;
                            }else{

                                console.log( 'urlonly', img.url );

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
                            console.log( imageThumb );

                            images.push( imageThumb );
                        }
                    });
                    return images;
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
    .gallery_product
    {
        margin-bottom: 30px;
    }

    .img-responsive, .thumbnail>img, .thumbnail a>img, .carousel-inner>.item>img, .carousel-inner>.item>a>img {
        display: block;
        max-width: 100%;
        height: auto;
        -webkit-box-shadow: 2px 3px 16px -6px rgba(0,0,0,0.61);
        -moz-box-shadow: 2px 3px 16px -6px rgba(0,0,0,0.61);
        box-shadow: 2px 3px 16px -6px rgba(0,0,0,0.61);

        border-radius: 10px 10px 10px 10px;
        -moz-border-radius: 10px 10px 10px 10px;
        -webkit-border-radius: 10px 10px 10px 10px;
        border: 0px solid #9c9c9c;

        cursor: pointer;
    }

    .slideshow-button a:not(:first-child){
        display: none;
    }
    .img-title {
        position: absolute;
        bottom: 5px;
        /* left: -0.08rem; */
        display: block;
        text-align: center;
        background-color: black;
        opacity: 0.65;
        color: white;
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
        width: 100%;padding: 12px;margin-top: 8px; border: #0a4b3e dashed thin;cursor:pointer;
    }

    .scroll-container{
        max-width: 100%;
        overflow-x: auto;
    }

</style>
