<template>
    <div>
        <div style="width: 100%; height: 100%;position: relative;">
            <div style="height: 100%;width: 100%; text-align:center;overflow: auto;">
                <div class="doc-bar">
                    <div style="display:block;position:absolute; height: 100%; width: 100%;background-color: black; opacity: 0.5;"></div>
                    <div class="top" v-if="loadedRatio > 0 && loadedRatio < 1"
                         style="background-color: green; color: white; text-align: center;height: 100%;display: block;"
                         :style="{ width: loadedRatio * 100 + '%' }"></div>
                    <div class="left v-center form form-inline">
                        <label v-if="loadedRatio > 0 && loadedRatio < 1" class="center">{{ Math.floor(loadedRatio * 100) }}%</label>
                    </div>
                    <div class="right v-center form form-inline">
                        <button class="btn btn-icon" style="margin-right: 8px;" @click="prevPage" ><i class="las la-2x fa-chevron-left"></i></button>
                        <button class="btn btn-icon" style="margin-right: 8px;" @click="zoomLevel -= 1"><i class="las la-search-minus"></i></button>
                        <button class="btn btn-icon" style="margin-right: 8px;" @click="zoomLevel += 1"><i class="las la-search-plus"></i></button>
                        <button class="btn btn-icon" style="margin-right: 8px;" @click="rotate -= 90"><i class="las la-undo"></i></button>
                        <button class="btn btn-icon" style="margin-right: 8px;" @click="rotate += 90"><i class="las la-redo"></i></button>
                        <button class="btn btn-icon" style="margin-right: 8px;" @click="$refs.pdf.print()"><i class="las la-print"></i></button>
                        <input  class="form-control" v-model.number="page" type="number" style="width: 5em; margin-right: 8px;"> of {{numPages}}
                        <button class="btn btn-icon" style="margin-left: 8px;" @click="nextPage"><i class="las la-2x fa-chevron-right"></i></button>
                    </div>
                    <button class="btn btn-icon left v-center form form-inline" style="display:none; padding: 7px 12px;width: fit-content;" >
                        <i class="las la-2x fa-times" @click="closeBox" ></i> close
                    </button>
                </div>
                <div style="display: block; ">
                    <pdf v-if="show" ref="pdf" style="border: 1px solid lightgray;min-width: 1000px;width: 1500px;"
                         :style="{ width: absZoom + '%' }"
                         :src="normalUrl"
                         :page="page"
                         :rotate="rotate"
                         @password="password"
                         @progress="loadedRatio = $event"
                         @error="error"
                         @num-pages="numPages = $event"
                         @link-clicked="page = $event"></pdf>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PdfView",
        props: {
            docUrl: {
                type: String,
                default: ''
            },
            baseUrl: {
                type: String,
                default: ''
            }
        },
        watch: {
            src: function(val){
                this.page = 1;
            }
        },
        computed: {
            normalUrl:function() {
                var t = Date.now();

                if( this.baseUrl == ''){
                    return this.docUrl + '?'+ t ;
                }else{
                    return this.baseUrl + '/' + this.docUrl +'?'+ t;
                }
            },
            absZoom: function(){
                if(this.zoomLevel < 0){
                    this.zoomLevel = 0;
                }
                if(this.zoomLevel > 8 ){
                    this.zoomLevel = 8;
                }

                return (this.zoomLevel * 25 ) + 100;


            }
        },
        data () {
            return {
                currentPage: 0,
                pageCount: 0,
                show: true,
                pdfList: [
                    '',
                    'https://cdn.mozilla.net/pdfjs/tracemonkey.pdf',
                    'https://cdn.rawgit.com/mozilla/pdf.js/c6e8ca86/test/pdfs/freeculture.pdf',
                    'https://cdn.rawgit.com/mozilla/pdf.js/c6e8ca86/test/pdfs/annotation-link-text-popup.pdf',
                    'https://cdn.rawgit.com/mozilla/pdf.js/c6e8ca86/test/pdfs/calrgb.pdf',
                    'https://cdn.rawgit.com/sayanee/angularjs-pdf/68066e85/example/pdf/relativity.protected.pdf',
                    'data:application/pdf;base64,JVBERi0xLjUKJbXtrvsKMyAwIG9iago8PCAvTGVuZ3RoIDQgMCBSCiAgIC9GaWx0ZXIgL0ZsYXRlRGVjb2RlCj4+CnN0cmVhbQp4nE2NuwoCQQxF+/mK+wMbk5lkHl+wIFislmIhPhYEi10Lf9/MVgZCAufmZAkMppJ6+ZLUuFWsM3ZXxvzpFNaMYjEriqpCtbZSBOsDzw0zjqPHZYtTrEmz4eto7/0K54t7GfegOGCBbBdDH3+y2zsMsVERc9SoRkXORqKGJupS6/9OmMIUfgypJL4KZW5kc3RyZWFtCmVuZG9iago0IDAgb2JqCiAgIDEzOAplbmRvYmoKMiAwIG9iago8PAogICAvRXh0R1N0YXRlIDw8CiAgICAgIC9hMCA8PCAvQ0EgMC42MTE5ODcgL2NhIDAuNjExOTg3ID4+CiAgICAgIC9hMSA8PCAvQ0EgMSAvY2EgMSA+PgogICA+Pgo+PgplbmRvYmoKNSAwIG9iago8PCAvVHlwZSAvUGFnZQogICAvUGFyZW50IDEgMCBSCiAgIC9NZWRpYUJveCBbIDAgMCA1OTUuMjc1NTc0IDg0MS44ODk3NzEgXQogICAvQ29udGVudHMgMyAwIFIKICAgL0dyb3VwIDw8CiAgICAgIC9UeXBlIC9Hcm91cAogICAgICAvUyAvVHJhbnNwYXJlbmN5CiAgICAgIC9DUyAvRGV2aWNlUkdCCiAgID4+CiAgIC9SZXNvdXJjZXMgMiAwIFIKPj4KZW5kb2JqCjEgMCBvYmoKPDwgL1R5cGUgL1BhZ2VzCiAgIC9LaWRzIFsgNSAwIFIgXQogICAvQ291bnQgMQo+PgplbmRvYmoKNiAwIG9iago8PCAvQ3JlYXRvciAoY2Fpcm8gMS4xMS4yIChodHRwOi8vY2Fpcm9ncmFwaGljcy5vcmcpKQogICAvUHJvZHVjZXIgKGNhaXJvIDEuMTEuMiAoaHR0cDovL2NhaXJvZ3JhcGhpY3Mub3JnKSkKPj4KZW5kb2JqCjcgMCBvYmoKPDwgL1R5cGUgL0NhdGFsb2cKICAgL1BhZ2VzIDEgMCBSCj4+CmVuZG9iagp4cmVmCjAgOAowMDAwMDAwMDAwIDY1NTM1IGYgCjAwMDAwMDA1ODAgMDAwMDAgbiAKMDAwMDAwMDI1MiAwMDAwMCBuIAowMDAwMDAwMDE1IDAwMDAwIG4gCjAwMDAwMDAyMzAgMDAwMDAgbiAKMDAwMDAwMDM2NiAwMDAwMCBuIAowMDAwMDAwNjQ1IDAwMDAwIG4gCjAwMDAwMDA3NzIgMDAwMDAgbiAKdHJhaWxlcgo8PCAvU2l6ZSA4CiAgIC9Sb290IDcgMCBSCiAgIC9JbmZvIDYgMCBSCj4+CnN0YXJ0eHJlZgo4MjQKJSVFT0YK',
                ],
                src:'',
                loadedRatio: 0,
                page: 1,
                numPages: 0,
                rotate: 0,
                zoomLevel: 0
            }
        },
        methods: {
            prevPage: function(){
                this.page = parseInt(this.page) - 1;
                this.page = ( this.page <= 0)? 1 : this.page;
            },
            nextPage: function(){
                this.page = parseInt(this.page) + 1;
                this.page = ( this.page > this.numPages)? this.numPages : this.page ;
            },
            password: function(updatePassword, reason) {

                updatePassword(prompt('password is "test"'));
            },
            error: function(err) {

                console.log(err);
            },
            closeBox: function(){
                this.$emit('on-close');
            }
        }
    }
</script>

<style lang="scss" scoped>
    .center {
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
    .top{
        position: absolute;
        top:0;
    }
    .left{
        position: absolute;
        left:0;
    }
    .right{
        position: absolute;
        right:0;
    }
    .v-center {
        margin: 0;
        position: absolute;
        top: 50%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
    }

    .btn-icon{
        color: white;
    }

    .doc-bar{
        height:45px;
        position:relative;
        top:0;
        left:0;
        width: 100%;
        text-align: center;
        display: block;
        font-size: 10pt;
        background-color: transparent;
        color:white;
    }
</style>
