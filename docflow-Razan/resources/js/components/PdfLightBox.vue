<template>
    <div v-if="lightShow" class="full-screen light-box" >
        <div class="full-screen bg">
        </div>
        <div class="full-screen">
            <div class="doc-nav">
                <div class="doc-container">
                    <pdf-view style="max-height: 100%; height: 100%; width: 100%;"
                              :doc-url="docUrl"
                              @on-close="closeBox"
                    >
                    </pdf-view>
                </div>
            </div>
            <div class="btn btn-lg btn-icon top-right" @click="closeBox" >
                <i class="las la-2x fa-times" ></i> close
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PdfLightBox",
        props: {
            show: {
                type: Boolean,
                default: false
            },
            docUrl: {
                type: String,
                default: ''
            }
        },
        watch: {
            show: function(val){
                if(val == true){
                    this.showBox();
                }else{
                    this.closeBox();
                }
                // this.lightShow = val;
            }
        },
        data: function(){
            return {
                lightShow : false
            }
        },
        methods: {
            closeBox: function () {
                this.lightShow = false;
                this.$emit('update:show', false);
            },
            showBox: function () {
                this.lightShow = true;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .full-screen {
        text-align: center;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        margin: 0px;
        padding: 0px;
    }
    .light-box{
        position: fixed;
        z-index: 9980;
        display: block;
    }
    .bg {
        z-index: 9985;
        position: fixed;
        background-color: black;
        opacity: 0.5;
    }
    .doc-nav{
        min-width: 1035px;
        width: 100%;
        position: relative;
        height: 100%;
        margin: auto;
        text-align: left;
    }
    .doc-container{
        height: 100%;
        width: auto;
        display: block;
        max-width: 1500px;
        margin: auto;
        z-index: 12000;
        position: relative;
        /*overflow: scroll;*/
    }
    .btn-icon{
        color: whitesmoke;
        cursor: pointer;
        z-index: 12000;
    }
    .top-right{
        top: 6px;
        right: 0;
        margin: 8px;
        position: absolute;
    }
</style>
