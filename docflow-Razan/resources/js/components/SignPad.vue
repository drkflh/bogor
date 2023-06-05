<template>
    <div style="border: thin solid lightgray;border-radius: 6px;padding: 8px; width: fit-content;">
        <VueSignaturePad
            id="signature"
            :width="width"
            :height="height"
            ref="signaturePad"
            :images="bgImages"
        />
        <br/>
        <div class="row">
            <div class="col-12 pull-right" style="font-size:11pt;">
                <div class="btn-group" role="group" style="float:right;margin-left:4px;" >
                    <button type="button" class="btn btn-sm btn-outline-secondary" @click="refreshCanvas"><i class="las la-redo" ></i></button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" @click="loadSpecimen">Load Specimen</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" @click="clear">Clear</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" @click="undo">Undo</button>
                    <button type="button" class="btn btn-sm " :class="status=='unsaved' ? 'btn-primary':'btn-outline-secondary' " @click="save">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SignPad",
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
            uploadurl : {
                type: String,
                default: 'api/v1/core/upload'
            },
            handle : {
                type: String
            },
            width : {
                type: String,
                default: '100%'
            },
            height : {
                type: String,
                default: '300px'
            },
            refKey : {
                type: String
            },
            ns : {
                type: String
            },
            mode : {
                type: String
            },
            specimen : {
                type: String,
                default: ''
            },
            bucket : {
                type: String,
                default: 'signature'
            },
            defaulturl : {
                type: String,
                default: 'images/coffee.png'
            },
            buttonlabel : {
                type: String,
                default: 'Click or Drag and Drop files here to upload'
            },
        },

        data: function(){
            return {
                option:{
                    penColor:"rgb(0, 0, 0)",
                    backgroundColor:"rgb(255,255,255)"
                },
                disabled:false,
                status: 'unsaved',
                bgImages: []
            }
        },
        mounted() {
            bus.$on('resize', (payload) => {
                console.log('sign resizing canvas');
                this.$nextTick(()=>{
                    this.refreshCanvas();
                });
            });
        },
        methods: {
            loadSpecimen(){
                if(this.specimen == ''){
                    alert('No specimen available');
                }else{
                    this.$emit('input', this.specimen );
                    this.bgImages = [ {src: this.specimen, x: 0, y: 0 }];
                    this.$refs.signaturePad.mergeImageAndSignature();
                }
            },
            save(){
                var _this = this;

                var data = _this.$refs.signaturePad.toData();
                var png = _this.$refs.signaturePad.saveSignature('image/png');
                var svg = _this.$refs.signaturePad.saveSignature('image/svg+xml');
                var jpeg = _this.$refs.signaturePad.saveSignature('image/jpeg');

                console.log('data',data);
                console.log('png',png);
                console.log('jpeg',jpeg);
                console.log('svg',svg);

                var formData = new FormData();

                var ts = Date.now() / 1000;

                formData.append('handle', this.handle);
                formData.append('m', this.mode);
                formData.append('ns', this.ns);
                formData.append('bucket', this.bucket);
                formData.append('filename', this.ns + this.handle + ts + '.png');
                formData.append('file', png.data);

                axios.post( this.uploadurl,
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then( response => {
                    if(response.data.result == 'OK'){
                        console.log(response.data.data.upload);
                        var obj = response.data.data.upload;
                        var url = obj.base + obj.url;

                        console.log(url);
                        this.status = 'saved';
                        this.$emit('input', url);
                    }
                })
                .catch( e =>{
                    console.log( e.toString() );
                });
            },
            clear(){
                var _this = this;
                this.status = 'unsaved';
                _this.$refs.signaturePad.clearSignature();
            },
            undo(){
                var _this = this;
                this.status = 'unsaved';
                _this.$refs.signaturePad.undoSignature();
            },
            refreshCanvas(){
                var _this = this;
                console.log('refresh canvas');
                this.status = 'unsaved';
                _this.$refs.signaturePad.resizeCanvas();
            },
            addWaterMark(){
                var _this = this;
                _this.$refs.signaturePad.addWaterMark({
                    text:"mark text",          // watermark text, > default ''
                    font:"20px Arial",         // mark font, > default '20px sans-serif'
                    style:'all',               // fillText and strokeText,  'all'/'stroke'/'fill', > default 'fill
                    fillStyle:"red",           // fillcolor, > default '#333'
                    strokeStyle:"blue",	   // strokecolor, > default '#333'
                    x:100,                     // fill positionX, > default 20
                    y:200,                     // fill positionY, > default 20
                    sx:100,                    // stroke positionX, > default 40
                    sy:200                     // stroke positionY, > default 40
                });
            },
            fromDataURL(url){
                var _this = this;
                _this.$refs.signaturePad.fromDataURL("data:image/png;base64,iVBORw0K...");
            },
            handleDisabled(){
                var _this = this;
                _this.disabled  = !_this.disabled
            }
        }
    }
</script>

<style scoped>

</style>
