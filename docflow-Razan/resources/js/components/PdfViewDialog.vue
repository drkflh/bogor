<template>
    <b-modal id="pViewModel"
             @ok="closeBox"
             title=""
             scrollable
             centered
             no-close-on-backdrop
             no-close-on-esc
             ok-only
             size="xl"
             modal-class="modal-bv" >

            <div class="doc-container">
                <pdf-view style="max-height: 100%; height: 100%; width: 100%;"
                          :doc-url="docUrl"
                >
                </pdf-view>
            </div>

    </b-modal>
</template>

<script>
    export default {
        name: "PdfViewDialog",
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
                this.$bvModal.hide('pViewModel');
                this.$emit('update:show', false);
            },
            showBox: function () {
                this.$bvModal.show('pViewModel');
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
