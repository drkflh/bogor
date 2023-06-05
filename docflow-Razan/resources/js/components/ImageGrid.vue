<template>
    <div class="row">
        <div v-for="(img, index) in images" :key="index"  class="gallery_product col-xl-3 col-lg-4 col-md-4 col-sm-6 col-xs-6">
            <img :src="img" :alt="img" class="img-responsive" @click="showLightBox( index )" >
        </div>
        <vue-easy-lightbox
                :visible="lightBoxVisible"
                :imgs="images"
                :index="lightBoxindex"
                @hide="lightBoxHandleHide"
        ></vue-easy-lightbox>
    </div>
</template>

<script>
    export default {
        name: "ImageGrid",
        computed:{
            getItems:function () {
                var items = [];
                _.forEach(this.images, im => {
                    items.push( { src: im, thumbnail: im } );
                });

                return items;
            }
        },
        data: function(){
            return {
                lightBoxVisible: false,
                lightBoxindex: 0,
                // flickityOptions: {
                //     initialIndex: this.initialIndex,
                //     prevNextButtons: this.prevNextButtons,
                //     pageDots: this.pageDots,
                //     wrapAround: this.wrapAround,
                //     freeScroll: this.freeScroll,
                //     contain: this.contain
                // }

            };
        },
        props:{
            images: {
                type: Array,
                default: []
            },
            initialIndex: {
                type: Number,
                default: 3
            },
            prevNextButtons: {
                type: Boolean,
                default: false
            },
            pageDots: {
                type: Boolean,
                default: false
            },
            wrapAround: {
                type: Boolean,
                default: false
            },
            freeScroll: {
                type: Boolean,
                default: true
            },
            contain: {
                type: Boolean,
                default: false
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
            getIndex(){
                return Math.floor((Math.random() * 1000) + 1).toString();
            }
        }
    }
</script>

<style scoped>
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

    .img-item{
        height: 155px;
        max-height: 200px;
        width: auto;
        margin: 5px;
    }
    .btn-expand{
        border: none;
        background-color: black;
        opacity: 60%;
        color: white;
        position: absolute;
        right: 8px; bottom: 8px;
    }
    .flickity-page-dots { bottom: 10px; }
</style>
