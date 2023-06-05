<template>
    <div class="row">
        <div class="col-12 image-strip">
            <flickity :options="flickityOptions" >
                <div v-for="(img, index) in images"  class="carousel-cell" :key="index" style="position: relative;" >
                    <button @click="showLightBox( index )" class="btn btn-sm btn-secondary btn-expand"><i class="las la-expand"></i></button>
                    <img :src="img" :alt="img" class="img-item"  >
                </div>
            </flickity>
            <vue-easy-lightbox
                    :visible="lightBoxVisible"
                    :imgs="images"
                    :index="lightBoxindex"
                    @hide="lightBoxHandleHide"
            ></vue-easy-lightbox>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ImageStrip",
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
                flickityOptions: {
                    initialIndex: this.initialIndex,
                    prevNextButtons: this.prevNextButtons,
                    pageDots: this.pageDots,
                    wrapAround: this.wrapAround,
                    freeScroll: this.freeScroll,
                    contain: this.contain
                }

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
    .image-strip{
        max-height: 250px;
        height: 170px;
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
