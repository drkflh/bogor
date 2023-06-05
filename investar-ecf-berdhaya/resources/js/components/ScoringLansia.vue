<template>
<div style="display:inline-block;">
     <b style="font-size: 11pt;color:blue;cursor: pointer;" v-on:click="openModal()">Scoring Lansia</b>
        <!-- <button v-on:click="openModal()"
             class="btn btn-primary"
             style="height:fit-content; margin: 0px ; cursor: pointer; padding: 8px;">
           <span >Scoring Lansia</span>
        </button> -->

        <b-modal :id="modalId"
                 size="lg"
                 @ok="save()"
                 title="Scoring Lansia"
                 no-close-on-esc
                 no-close-on-backdrop
                 scrollable
                 @hidden="onHidden"
                 :visibility="showModal"
                 modal-class="modal-bv" >

        <!-- <template v-for="(item, index) in extraData" > -->
            <div class="row">
                <div class="col-6">
                    <input style="margin-bottom:10px;" class="form-control" type="text" readonly :value="extraData.nik">
                </div>
                <div class="col-6">
                    <input style="margin-bottom:10px;" class="form-control" type="text" readonly :value="extraData.namaLansia">
                </div>
            </div>
        <!-- </template> -->
        <b-tabs content-class="mt-3 tabHeader" nav-class="tab-header" justified >
        <b-tab title="ADL" active>
            <template v-for="(item, index) in this.valueADL">
                <div>
                    <h5 style="margin-top:10px;margin-bottom:-5px;margin-top:10px;"><b>{{item.code}} </b>{{item.question}}</h5>
                </div>
                <div>
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <input type="radio" :name="item.code" :value="parseInt(item.score1)" v-model="scoreAdl[index]">
                                <label >{{item.answer1}}</label>
                            </div>
                            <div>
                                <input v-if="item.answer3" :name="item.code" type="radio" :value="parseInt(item.score3)" v-model="scoreAdl[index]">
                                <label >{{item.answer3}}</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <input :name="item.code" type="radio"  :value="parseInt(item.score2)" v-model="scoreAdl[index]">
                                <label >{{item.answer2}}</label>
                            </div>
                            <div>
                                <input v-if="item.answer4" type="radio" :name="item.code" :value="parseInt(item.score4)" v-model="scoreAdl[index]">
                                <label >{{item.answer4}}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-3">
                    <span>Score: {{ scoreAdl[index] }}</span>
                </div>
            </template>
            <div class="alert alert-primary" role="alert">
                <span>Total: {{ totalADL }}</span>
            </div>
        </b-tab>
        <b-tab title="IADL">
           <template v-for="(item, index) in this.valueIADL">
                <div>
                    <h5 style="margin-top:10px;margin-bottom:-5px;margin-top:10px;"><b>{{item.code}} </b>{{item.question}}</h5>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex">
                            <input style="margin-top: 12px" type="radio" :name="item.code" :value="parseInt(item.score1)" v-model="scoreIadl[index]">
                            <label class="ml-2">{{item.answer1}}</label>
                        </div>
                        <div class="d-flex">
                            <input style="margin-top: 12px" :name="item.code" type="radio"  :value="parseInt(item.score2)" v-model="scoreIadl[index]">
                            <label class="ml-2">{{item.answer2}}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex">
                            <input style="margin-top: 12px" v-if="item.answer3" :name="item.code" type="radio" :value="parseInt(item.score3)" v-model="scoreIadl[index]">
                            <label class="ml-2">{{item.answer3}}</label>
                        </div>
                        <div class="d-flex">
                            <input style="margin-top: 12px" v-if="item.answer4" type="radio" :name="item.code" :value="parseInt(item.score4)" v-model="scoreIadl[index]">
                            <label class="ml-2">{{item.answer4}}</label>
                        </div>
                    </div>
                </div>
                <div class="my-3">
                    <span>Score: {{ scoreIadl[index] }}</span>
                </div>
            </template>
            <div class="alert alert-primary" role="alert">
                <span>Total: {{ totalIADL }}</span>
            </div>
        </b-tab>
        <b-tab title="GDS">
            <template v-for="(item, index) in this.valueSDG">
                <div>
                    <h5 style="margin-top:10px;margin-bottom:-5px;margin-top:10px;"><b>{{item.code}} Type: {{item.type}}, </b>{{item.question}}</h5>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div>
                            <input type="radio" :name="item.code+item.type" :value="parseInt(item.score1)" v-model="scoreSdg[index]">
                            <label >{{item.answer1}}</label>
                        </div>
                        <div>
                            <input v-if="item.answer3" :name="item.answer3" type="radio" :value="parseInt(item.score3)" v-model="scoreSdg[index]">
                            <label >{{item.answer3}}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <input v-if="item.code+item.type" :name="item.code+item.type" type="radio" :value="parseInt(item.score2)" v-model="scoreSdg[index]">
                            <label >{{item.answer2}}</label>
                        </div>
                        <div>
                            <input v-if="item.answer4" type="radio" :name="item.code+item.type" :value="parseInt(item.score4)" v-model="scoreSdg[index]">
                            <label >{{item.answer4}}</label>
                        </div>
                    </div>
                </div>
                <div>
                    <span>Score: {{ scoreSdg[index] }}</span>
                </div>
            </template>
            <div class="alert alert-primary" role="alert">
                <span>Total: {{ totalSDG }}</span>
            </div>
        </b-tab>
        <b-tab title="Demensia">
            <div>
                <avatar-upload
                    v-model="photo"
                    :handle="handle"
                    :uploadurl="uploadUrl"
                    ns="photo"
                    mode="single"
                    :defaulturl="defaultpicturl"
                >
                </avatar-upload>
            </div>
            <template v-for="(item, index) in this.valueDemensia">
                <div v-if="item.type === 'gambar'">
                    <div>
                        <h5 style="margin-top:10px;margin-bottom:-5px;margin-top:10px;"><b>{{item.code}} </b>{{item.question}}</h5>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <input type="radio" :name="item.code" :value="parseInt(item.score1)" v-model="scoreDemensia[index]">
                            <label >{{item.answer1}}</label>
                        </div>
                        <div>
                            <input :name="item.code" type="radio"  :value="parseInt(item.score2)" v-model="scoreDemensia[index]">
                            <label >{{item.answer2}}</label>
                        </div>
                        <div>
                            <input v-if="item.answer3" :name="item.code" type="radio" :value="parseInt(item.score3)" v-model="scoreDemensia[index]">
                            <label >{{item.answer3}}</label>
                        </div>
                        <div>
                            <input v-if="item.answer4" type="radio" :name="item.code" :value="parseInt(item.score4)" v-model="scoreDemensia[index]">
                            <label >{{item.answer4}}</label>
                        </div>
                    </div>
                    <div class="my-3">
                        <span>Score: {{ scoreDemensia[index] }}</span>
                    </div>
                </div>
            </template>
            <template v-for="(item, index) in this.valueDemensiaRecall">
                    <div>
                        <h5 style="margin-top:10px;margin-bottom:-5px;margin-top:10px;"><b>{{item.code}} </b>{{item.question}}</h5>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <input type="checkbox" :name="item.code" :value="parseInt(item.score1)" v-model="scoreDemensiaRecall[0]">
                            <label >{{item.answer1}}</label>
                        </div>
                        <div>
                            <input type="checkbox" :name="item.code" :value="parseInt(item.score2)" v-model="scoreDemensiaRecall[1]">
                            <label >{{item.answer2}}</label>
                        </div>
                        <div>
                            <input v-if="item.answer3" type="checkbox" :name="item.code" :value="parseInt(item.score3)" v-model="scoreDemensiaRecall[2]">
                            <label >{{item.answer3}}</label>
                        </div>
                        <div>
                            <input v-if="item.answer4" type="checkbox" :name="item.code" :value="parseInt(item.score4)" v-model="scoreDemensiaRecall[3]">
                            <label >{{item.answer4}}</label>
                        </div>
                    </div>
                    <div class="my-3">
                        <span>Score: {{totalDemensiaRecall }}</span>
                    </div>
                </template>
            <div class="alert alert-primary" role="alert">
                <span>Total Score Gambar: {{ totalDemensia }}</span><hr>
                <span>Total Score Recall: {{ totalDemensiaRecall }}</span>
            </div>
        </b-tab>
        <b-tab title="Disabilitas">
            <template v-for="(item, index) in this.valueDisabilitas">
               <div>
                    <h5 style="margin-top:10px;margin-bottom:-5px;margin-top:10px;"><b>{{item.code}} </b>{{item.question}}</h5>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div>
                            <input type="radio" :name="item.code" :value="parseInt(item.score1)" v-model="scoreDisabilitas[index]">
                            <label >{{item.answer1}}</label>
                        </div>
                        <div>
                            <input :name="item.code" type="radio"  :value="parseInt(item.score2)" v-model="scoreDisabilitas[index]">
                            <label >{{item.answer2}}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <input v-if="item.answer3" :name="item.code" type="radio" :value="parseInt(item.score3)" v-model="scoreDisabilitas[index]">
                            <label >{{item.answer3}}</label>
                        </div>
                        <div>
                            <input v-if="item.answer4" type="radio" :name="item.code" :value="parseInt(item.score4)" v-model="scoreDisabilitas[index]">
                            <label >{{item.answer4}}</label>
                        </div>
                    </div>
                </div>
                <div class="my-3">
                    <span>Score: {{ scoreDisabilitas[index] }}</span>
                </div>
            </template>
            <div class="alert alert-primary" role="alert">
                <span>Total: {{ totalDisabilitas }}</span>
            </div>
        </b-tab>
        <b-tab title="CFS">
            <template v-for="(item, index) in this.valueCFS">
                <div>
                    <h5 style="margin-top:10px;margin-bottom:-5px;margin-top:10px;"><b>{{item.code}} </b>{{item.question}}</h5>
                </div>
                <div>
                    <div class="d-flex mt-2">
                        <input style="margin-top: 12px" type="radio" :name="item.code" :value="parseInt(item.score1)" v-model="scoreCfs[index]">
                        <label class="ml-2">{{item.answer1}}</label>
                    </div>
                    <div class="d-flex mt-2">
                        <input style="margin-top: 12px" :name="item.code" type="radio"  :value="parseInt(item.score2)" v-model="scoreCfs[index]">
                        <label class="ml-2">{{item.answer2}}</label>
                    </div>
                    <div class="d-flex mt-2">
                        <input v-if="item.answer3" style="margin-top: 12px" :name="item.code" type="radio" :value="parseInt(item.score3)" v-model="scoreCfs[index]">
                        <label class="ml-2">{{item.answer3}}</label>
                    </div>
                    <div class="d-flex mt-2">
                        <input v-if="item.answer4" style="margin-top: 12px" type="radio" :name="item.code" :value="parseInt(item.score4)" v-model="scoreCfs[index]">
                        <label class="ml-2">{{item.answer4}}</label>
                    </div>
                    <div class="d-flex mt-2">
                        <input v-if="item.answer5" style="margin-top: 12px" type="radio" :name="item.code" :value="parseInt(item.score5)" v-model="scoreCfs[index]">
                        <label class="ml-2">{{item.answer5}}</label>
                    </div>
                    <div class="d-flex mt-2">
                        <input v-if="item.answer6" style="margin-top: 12px" type="radio" :name="item.code" :value="parseInt(item.score6)" v-model="scoreCfs[index]">
                        <label class="ml-2">{{item.answer6}}</label>
                    </div>
                    <div class="d-flex mt-2">
                        <input v-if="item.answer7" style="margin-top: 12px" type="radio" :name="item.code" :value="parseInt(item.score7)" v-model="scoreCfs[index]">
                        <label class="ml-2">{{item.answer7}}</label>
                    </div>
                    <div class="d-flex mt-2">
                        <input v-if="item.answer8" style="margin-top: 12px" type="radio" :name="item.code" :value="parseInt(item.score8)" v-model="scoreCfs[index]">
                        <label class="ml-2">{{item.answer8}}</label>
                    </div>
                    <div class="d-flex mt-2">
                        <input v-if="item.answer9" style="margin-top: 12px" type="radio" :name="item.code" :value="parseInt(item.score9)" v-model="scoreCfs[index]">
                        <label class="ml-2">{{item.answer9}}</label>
                    </div>
                </div>
                <div class="my-3">
                    <span>Score: {{ scoreCfs[index] }}</span>
                </div>
            </template>
            <div class="alert alert-primary" role="alert">
                <span>Total: {{ totalCFS }}</span>
            </div>
        </b-tab>
    </b-tabs>
    </b-modal>
</div>
</template>

<script>
    export default {
        name: "ScoringLansia",
        props: {
            label: {
                type: [String]
            },
            // url : {
            //     type: String,
            //     default: 'scoring-get-adl'
            // },
            photo : {
                type: String
            },
            extraData: {
                type: [String,Object,Array]
            },
            // scoreAdl: {
            //     type: [String,Object,Array]
            // },
            // scoreIadl: {
            //     type: [String,Object,Array]
            // },
            // scoreSdg: {
            //     type: [String,Object,Array]
            // },
            // scoreDemensia: {
            //     type: [String,Object,Array]
            // },
            // scoreDisabilitas: {
            //     type: [String,Object,Array]
            // },
            // scoreDemensiaRecall: {
            //     type: [String,Object,Array]
            // },
            // scoreCfs: {
            //     type: [String,Object,Array]
            // },
            // valueADL: {
            //     type: [String,Array]
            // },
            // valueIADL: {
            //     type: [String,Array]
            // },
            // valueSDG: {
            //     type: [String,Array]
            // },
            // valueDemensia: {
            //     type: [String,Array]
            // },
            // valueDemensiaRecall: {
            //     type: [String,Array]
            // },
            // valueDisabilitas: {
            //     type: [String,Array]
            // },
            // valueCFS: {
            //     type: [String,Array]
            // },
            modalId: {
                type: [String,Array]
            },
            handle: {
                type: [String]
            },
            uploadUrl: {
                type: [String],
                default: '/api/v1/core/upload'
            },
            defaultpicturl: {
                type: [String],
                default: '/images/default_256.png'
            }
        },
        data: function() {
            return {
                showModal : false,
                url : 'scoring-get-adl',
                scoreAdl :  [],
                scoreIadl :  [],
                scoreSdg :  [],
                scoreDemensia :  [],
                scoreDisabilitas :  [],
                scoreDemensiaRecall :  [],
                scoreCfs :  [],
                valueADL :  [],
                valueIADL :  [],
                valueSDG :  [],
                valueDemensia :  [],
                valueDemensiaRecall :  [],
                valueDisabilitas :  [],
                valueCFS :  []
            }
        },
        watch: {
            // scoreAdl:function(val){
            //     console.log(val);
            //     this.$emit('update:scoreAdl',val)
            // },
            // scoreIadl:function(val){
            //     this.$emit('update:scoreIadl',val)
            // },
            // scoreSdg:function(val){
            //     this.$emit('update:scoreSdg',val)
            // },
            // scoreDemensia:function(val){
            //     this.$emit('update:scoreDemensia',val)
            // },
            // scoreDemensiaRecall:function(val){
            //     this.$emit('update:scoreDemensiaRecall',val)
            // },
            // scoreDisabilitas:function(val){
            //     this.$emit('update:scoreDisabilitas',val)
            // },
            // scoreCfs:function(val){
            //     this.$emit('update:scoreAdl',val)
            // },
        },
        computed:{
            totalADL() {
                if(this.scoreAdl){
                    console.log(this.scoreAdl.reduce((a, b) => a + b, 0));
                    const hasil = this.scoreAdl.reduce((a, b) => a + b, 0);
                    return hasil;
                }else{

                }
            },
            totalIADL() {
                if(this.scoreIadl){
                    console.log(this.scoreIadl.reduce((a, b) => a + b, 0));
                    const hasil = this.scoreIadl.reduce((a, b) => a + b, 0);
                    return hasil;
                }else{

                }
            },
            totalSDG() {
                if(this.scoreSdg){
                    console.log(this.scoreSdg.reduce((a, b) => a + b, 0));
                    const hasil = this.scoreSdg.reduce((a, b) => a + b, 0);
                    return hasil;
                }else{

                }
            },
            totalDemensia() {
                if(this.scoreDemensia){
                    console.log(this.scoreDemensia.reduce((a, b) => a + b, 0));
                    const hasil = this.scoreDemensia.reduce((a, b) => a + b, 0);
                    return hasil;
                }else{

                }
            },
            totalDemensiaRecall() {
                if(this.scoreDemensiaRecall){
                    const hasil = this.scoreDemensiaRecall.filter(Boolean).length;
                    return hasil;
                }else{

                }
            },
            totalDisabilitas() {
                if(this.scoreDisabilitas){
                    console.log(this.scoreDisabilitas.reduce((a, b) => a + b, 0));
                    const hasil = this.scoreDisabilitas.reduce((a, b) => a + b, 0);
                    return hasil;
                }else{

                }
            },
            totalCFS() {
                if(this.scoreCfs){
                    console.log(this.scoreCfs.reduce((a, b) => a + b, 0));
                    const hasil = this.scoreCfs.reduce((a, b) => a + b, 0);
                    return hasil;
                }else{

                }
            },
        },
        methods: {
            getADL(){
                this.url = 'scoring-get-adl';
                 var data = {};

                data.id = this.extraData._id;
                axios.post(this.url,data)
                    .then( response => {
                        console.log(response.data);
                        if(response.data.result == 'OK'){
                            this.valueADL = response.data.data.score;
                            this.scoreAdl = response.data.data.answer;
                        }
                    })
                    .catch( error=> {
                        console.log(error);
                    });
            },
            getIADL(){
                this.url = 'scoring-get-iadl';
                var data = {};

                data.id = this.extraData._id;
                axios.post(this.url,data)
                    .then( response => {
                        console.log(response.data);
                        if(response.data.result == 'OK'){
                            this.valueIADL = response.data.data.score;
                            this.scoreIadl = response.data.data.answer;
                        }
                    })
                    .catch( error=> {
                        console.log(error);
                    });
            },
            getSDG(){
                this.url = 'scoring-get-sdg';
                var data = {};

                data.id = this.extraData._id;
                axios.post(this.url,data)
                    .then( response => {
                        console.log(response.data);
                        if(response.data.result == 'OK'){
                            this.valueSDG = response.data.data.score;
                            this.scoreSdg = response.data.data.answer;
                        }
                    })
                    .catch( error=> {
                        console.log(error);
                    });
            },
            getDemensia(){
                this.url = 'scoring-get-demensia';
                var data = {};

                data.id = this.extraData._id;
                axios.post(this.url,data)
                    .then( response => {
                        console.log(response.data);
                        if(response.data.result == 'OK'){
                            this.valueDemensia = response.data.data.score;
                            this.valueDemensiaRecall = response.data.data.scoreRecall;
                            this.scoreDemensia = response.data.data.answer;
                            this.scoreDemensiaRecall = response.data.data.answerRecall;
                        }
                    })
                    .catch( error=> {
                        console.log(error);
                    });
            },
            getDisabilitas(){
                this.url = 'scoring-get-disabilitas';
                 var data = {};

                data.id = this.extraData._id;
                axios.post(this.url,data)
                    .then( response => {
                        console.log(response.data);
                        if(response.data.result == 'OK'){
                            this.valueDisabilitas = response.data.data.score;
                            this.scoreDisabilitas = response.data.data.answer;
                        }
                    })
                    .catch( error=> {
                        console.log(error);
                    });
            },
            getCFS(){
                this.url = 'scoring-get-cfs';
                 var data = {};

                data.id = this.extraData._id;
                axios.post(this.url,data)
                    .then( response => {
                        console.log(response.data);
                        if(response.data.result == 'OK'){
                            this.valueCFS = response.data.data.score;
                            this.scoreCfs = response.data.data.answer;
                        }
                    })
                    .catch( error=> {
                        console.log(error);
                    });
            },
            openModal(){
                this.showModal = true;
                this.getADL();
                this.getIADL();
                this.getSDG();
                this.getDemensia();
                this.getDisabilitas();
                this.getCFS();
                this.checkLansia();
            },
            checkLansia(){
                // if(this.extraData.length > 1){
                //     alert('Data Tidak Boleh Multiple !')
                //     this.$bvModal.hide(this.modalId);
                // }else if(this.extraData.length < 1){
                //     alert('Data Tidak Boleh Kosong !')
                // }else if(this.extraData.length = 1){
                //     this.$bvModal.show(this.modalId);
                // }
                // console.log(this.extraData.length);
                this.$bvModal.show(this.modalId);
                console.log(this.extraData.namaLansia);
            },
            closeModal(){
                this.$bvModal.hide(this.modalId);
            },
            save(){
                this.url = 'scoring-lansia-member';
                var data = {};

                data.answerAdl = this.scoreAdl;
                data.answerIadl = this.scoreIadl;
                data.answerSdg = this.scoreSdg;
                data.answerDemensia = this.scoreDemensia;
                data.answerDemensiaRecall = this.scoreDemensiaRecall;
                data.answerDisabilitas = this.scoreDisabilitas;
                data.answerCfs = this.scoreCfs;

                data.photo = this.photo;

                data.scoreAdl = this.totalADL;
                data.scoreIadl = this.totalIADL;
                data.scoreSdg = this.totalSDG;
                data.scoreDemensia = this.totalDemensia;
                data.scoreDisabilitas = this.totalDisabilitas;
                data.scoreDemensiaRecall = this.totalDemensiaRecall;
                data.scoreCfs = this.totalCFS;
                data.dataLansia = [this.extraData];
                axios.post(this.url,data)
                    .then( response => {
                        console.log(response.data);
                        if(response.data.result == 'OK'){
                           this.closeModal();
                        }else{
                            alert( response.data.message );
                        }
                    })
                    .catch( error=> {
                        console.log(error);
                    });
            },
            onHidden(){
                this.$emit('hidden');
            },
        }
    }
</script>

<style scoped>

</style>
