<template>
    <div>
        <div style="display: block;width: 100%;min-height: 350px;height:350px;overflow-y: scroll;" >
            <div class="text-center" style="display: block;position: relative">
                <div style="position: absolute;top:16px;right:8px;display: block;width: 80px;text-align: right;">
                    <button v-on:click="editFile(value)" class="btn btn-primary"  >
                        <i class="las la-pencil-alt""></i>
                    </button>

                    <vue-clip
                            v-if="canUpload"
                            :on-sending="sending"
                            :on-complete="complete"
                            :options="uploadOptions">

                        <template slot="clip-uploader-action">
                            <div class="btn btn-primary" style="margin-top: 16px;">
                                <div class="dz-message"><i class="las la-upload"></i></div>
                            </div>
                        </template>

                    </vue-clip>
                    <img v-if="hasUpload" :src="imageUpload"
                         @click="showLightBox( 0 )"
                         style="cursor: pointer; width: 75px;height:75px; object-fit: cover;margin-top:16px;border-radius: 4px;border: thin solid grey;" />
                </div>

                <img v-on:click="editFile(value)"
                     :src="urlTime"
                     style="width:100%;height: auto;cursor:pointer;border: thin solid lightgrey;" >
            </div>
        </div>

        <vue-easy-lightbox
                :visible="lightBoxVisible"
                :imgs="lightBoxUrls"
                :index="lightBoxindex"
                @hide="lightBoxHandleHide"
        ></vue-easy-lightbox>
    </div>

</template>

<script>
    export default {
        name: "DrawingBoard",
        props: {

            itemId : {
                type: String,
                default: ''
            },

            tabKey : {
                type: [ Object, String, Array],
                default: function(){
                    return {};
                }
            },

            imageUpload : {
                type: String
            },

            imageUrl : {
                type: String
            },

            canUpload : {
                type: Boolean,
                default: false
            },

            imageName : {
                type: String
            },

            imageId : {
                type: String
            },

            imageToken : {
                type: String
            },

            urlLoad : {
                type: String
            },

            urlReturn : {
                type: String
            },

            urlSave : {
                type: String
            },

            editorUrl : {
                type: String
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
            docbase: {
                type: String,
                default: ''
            },
            drawbase: {
                type: String,
                default: '2221'
            },

            //upload
            uploadurl : {
                type: String,
                default: 'api/v1/core/upload'
            }

        },
        computed:{
            urlTime: function(){
                var d = new Date();
                var n = d.getTime();

                var rgx = /2221$/i.test(this.imageUrl);

                var defpat = new RegExp(this.defaulturl + '$', 'gi');
                var defrgx = this.imageUrl.match(defpat);

                console.log('rgx',rgx);

                if(this.imageUrl == this.docbase || _.isEmpty( this.imageUrl) || rgx || defrgx){
                    return this.defaulturl;
                }else{
                    return this.imageUrl + '?' + n;
                }

            }
        },
        data: function (){
            return {
                uploadOptions: {
                    url: this.uploadurl,
                    paramName: 'file'
                },
                hasUpload : false,
                lightBoxVisible: false,
                lightBoxindex: 0,
                lightBoxUrls: []
            }
        },
        watch:{
            imageUrl: function(val){
                if(_.isEmpty(val)){
                    this.imageUrl = this.defaultUrl;
                }
            },
            imageUpload: function (val) {
                if(_.isEmpty(val)){
                    this.hasUpload = false;
                }else{
                    this.hasUpload = true;
                    this.lightBoxUrls = [val];
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
            editFile(file){

                var token = this.imageToken;
                var id  = btoa(this.imageId);
                var name = this.imageName;
                var urlReturn = encodeURI( this.urlReturn );
                var urlSave = encodeURI( this.urlSave );
                var urlLoad = encodeURI( this.urlLoad );

                var tabKey = '';
                var tabKey = ( !_.isEmpty(this.tabKey) && _.has(this.tabKey, 'key') )?_.get(this.tabKey, 'key'): "";

                var url = this.editorUrl + '?token=' + token
                        + '&tab_key=' + tabKey
                        + '&item_id=' + this.itemId
                        + '&id=' + id
                        + '&name=' + name
                        + '&urlReturn=' + urlReturn
                        + '&urlSave=' + urlSave
                        + '&urlLoad=' + urlLoad;

                window.location = url;
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
                    var upl = _.get(fobj, 'upload.base' ) + _.get(fobj, 'upload.url' );

                    this.$emit('update:imageUpload', upl);

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
        width: 100%;
        height: auto;
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
