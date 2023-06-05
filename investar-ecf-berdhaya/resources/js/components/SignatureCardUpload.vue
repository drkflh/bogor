<template>
    <div>
        <div style="clear: both;display: block;">
            <div style="display: block;position:relative;height:fit-content;width:300px;min-height: 150px;top: 0;left: 0;margin: auto;">
                <img  :src="value"
                      @error="setAltImg"
                      style="height:200px;width: 100%; object-fit: cover; border-radius: 6px;border: thin solid lightgray; " >
                <div class="d-flex flex-row justify-content-between w-100" style="padding: 8px;height: fit-content;bottom: 0px;">
                    <div class="btn btn-lg btn-secondary upload-round-button" @click="loadSpecimen" >
                        <i class="las la-upload"></i> Specimen
                    </div>
                    <div class="btn btn-lg btn-secondary upload-round-button" @click="toggleSignPad" >
                        <i class="las la-signature"></i> Sign Pad
                    </div>
                    <vue-clip
                        :on-sending="sending"
                        :on-complete="complete"
                        :options="options">
                        <template slot="clip-uploader-action">
                            <div class="btn btn-lg btn-secondary upload-round-button" >
                                <div class="dz-message">
                                    <i class="las la-upload"></i> Upload
                                </div>
                            </div>
                        </template>
                    </vue-clip>

                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center" >
            <sign-pad v-show="showSignPad"
                :ref="signRef"
                v-model="signModel"
                :handle="signHandle"
                :ns="signNs"
                :uploadurl="signUploadUrl"
                mode="single"
                :width="signWidth"
                :height="signHeight"
                :specimen="specimen"
            ></sign-pad>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SignatureCardUpload",
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
            hideUploadButton : {
                type: Boolean,
                default: function(){
                    return false;
                }
            },
            mode : {
                type: String
            },
            bucket : {
                type: String,
                default: 'media'
            },
            defaulturl : {
                type: String,
                default: 'images/coffee.png'
            },
            buttonlabel : {
                type: String,
                default: 'Click or Drag and Drop files here to upload'
            },
            specimen : {
                type: String,
                default: ''
            },
            openSignPad: {
                type: Boolean,
                default: function(){
                    return false;
                }
            },
            signUploadUrl : {
                type: String,
                default: 'api/v1/core/upload'
            },
            signWidth : {
                type: String,
                default: '100%'
            },
            signHeight : {
                type: String,
                default: '200px'
            },
            signRef : {
                type: String,
                default: 'signRef'
            },
            signHandle : {
                type: String,
                default: 'signPadHandle'
            },
            signNs : {
                type: String,
                default: 'signPad'
            }
        },
        data: function (){
            return {
                signModel : '',
                showSignPad : false,
                options: {
                    url: this.uploadurl,
                    paramName: 'file'
                },
                delIcon : false,
                showThumbnail: false
            }
        },
        computed: {

        },
        watch: {
            signModel: function(val){
                console.log('sign', val);
                this.$emit('input', val);
            }
        },
        methods: {
            setAltImg(event){
                event.target.src = this.defaulturl;
            },
            toggleSignPad(){
                var _this = this;
                this.showSignPad = !this.showSignPad;
                window.dispatchEvent(new Event('resize'));
                bus.$emit('resize');
            },
            loadSpecimen(){
                //console.log('specimen', this.specimen);
                if(this.specimen == ''){
                    alert('No specimen available');
                }else{
                    this.signModel = this.specimen;
                }
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
                            this.signModel = response.data.data.upload;
                            //this.$emit('input', response.data.data.upload);
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
                formData.append('bucket', this.bucket);
            },
            complete (file, status, xhr) {
                var fobj = { _id: null };
                try {
                    fobj = JSON.parse( xhr.response );
                    console.log(fobj.count);
                    console.log(fobj.data.upload);

                    this.signModel = fobj.data.upload.base + fobj.data.upload.url;

                    //this.$emit('input', fobj.data.upload.base + fobj.data.upload.url);

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
    .upload-button{
        position: relative;
        color: white;
        width: 36px;
        height: 36px;
        padding: 5px;
        border-radius: 50%;
    }
    .upload-round-button{
        font-size: 9pt;
        position: relative;
        color: white;
        width: fit-content;
        height: 36px;
        padding: 8px;
        border-radius: 6px;
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
