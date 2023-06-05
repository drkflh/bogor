<template>
    <div>
        <div class="row" >
            <div class="col-11" style="padding-right: 8px;">
                <input v-on:keyup.enter="setNClear($event.target)" class="form-control-lg scanner" ref="scannerinput"  type="text" >
            </div>
            <div class="col-1" style="text-align: center;padding: 0px;padding-top: 8px;padding-right: 8px;">
                <b-spinner v-show="showLoading" variant="info" label="Spinning" ></b-spinner>
            </div>
        </div>
        <div v-if="showResult" class="row" >
            <div class="col-12" style="padding: 8px;">
                <h6  style="padding: 8px;">
                    Scan result : {{ scannedCode }}
                </h6>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ScannerInput",
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value: {
                type: [Array, Object, String],
                default: function(){
                    return [];
                }
            },
            searchUrl: {
                type: String
            },
            searchVar: {
                type: String,
                default: 'q'
            },
            auxData: {
                type: [Array, Object, String],
                default: function(){
                    return [];
                }
            },
            result: {
                type: [Array, Object, String],
                default: function(){
                    return {};
                }
            },
            auxRequired: {
                type: Boolean,
                default: false
            },
            auxReqMessage: {
                type: String,
                default: 'No object selected'
            },
            showResult: {
                type: Boolean,
                default: false
            },
            extraData: {
                type: [Object, Array, String],
                default: function(){
                    return {};
                }
            }
        },
        data: function(){
            return {
                scannedCode: '',
                showLoading: false,
                dataInfo: {}
            }
        },
        methods: {
            setNClear: function(el){
                console.log(el.value);
                this.scannedCode = el.value;
                el.value = '';
                el.focus();
                this.getInfo( this.scannedCode );
            },
            getInfo(query) {
                if(query == ''){
                    this.showLoading = false;
                }else{

                    if(this.auxRequired){
                        if(_.isEmpty(this.auxData)){
                            alert( this.auxReqMessage );
                            return;
                        }
                    }

                    this.showLoading = true;

                    var postData = { aux: this.auxData, extraData : this.extraData };

                    axios.post(this.searchUrl + '?' + this.searchVar + '=' + query, postData )
                        .then( response => {
                            this.showLoading = false;
                            console.log(response.data);
                            if(response.data.result == 'OK'){
                                try {
                                    console.log(response.data);
                                    this.dataInfo = response.data.data;
                                    this.$emit('input', this.dataInfo );
                                    this.$emit('update:result', this.dataInfo );
                                    this.$refs.scannerinput.focus();
                                }catch (e) {
                                    console.log(e);
                                    this.showLoading = false;
                                }
                            }
                        })
                        .catch( error=> {
                            this.showLoading = false;
                            console.log(error);
                        });
                }
            }

        }

    }
</script>

<style scoped>
input.scanner{
    border: thin solid lightslategrey;
    border-radius: 4px;
    width: 100%;
}
input.scanner:focus{
    background-color: skyblue;
    border: thin solid lightslategrey;
}
</style>
