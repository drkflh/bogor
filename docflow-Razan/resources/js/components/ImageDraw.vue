<template>
    <div class="card" style="width: 100%;height:350px;overflow-y: scroll;" >
        <div class="card-body text-center" style="display: block;position: relative">
            <button v-on:click="editFile(value)" class="btn btn-primary " style="position: absolute;top:8px;right:8px" >
                <i class="las la-pencil-alt""></i>
            </button>

            <img :src="makeUrl(value)" style="width:100%;height: auto;cursor:pointer;border: thin solid lightgrey;" >
        </div>
        <div class="card-footer">

        </div>
    </div>
</template>

<script>
    export default {
        name: "ImageDraw",
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value: {
                type: [Object, Array, String],
                default: function(){
                    return {};
                }
            },

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
            docbase: {
                type: String,
                default: ''
            }
        },
        data: function (){
            return {
                options: {
                    url: this.uploadurl,
                    paramName: 'file'
                },
                delIcon : false,
                galleryList : []
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
            editFile(file){

                var id  = this.imageId;
                var name = this.imageName;
                var urlReturn = encodeURI( this.urlReturn );
                var urlSave = encodeURI( this.urlSave );
                var urlLoad = encodeURI( this.urlLoad );
                var token = this.imageToken;

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

                //window.open( url, '_blank');
                window.location = url;
                //bus.$emit('opendraw',{});
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
