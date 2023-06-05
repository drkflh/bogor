<template>
<div style="display:inline-block;">
    <span class="badge badge-danger p-2 mr-2 my-2" style="font-size: 10px;cursor: pointer;" v-on:click="openModal()">{{countIssue}} Issues</span>

        <b-modal :id="modalId"
                 size="xl"
                 @ok="save()"
                 :title="getTitle()"
                 no-close-on-esc
                 no-close-on-backdrop
                 scrollable
                 @hidden="onHidden"
                 :visibility="showModal"
                  >

        <div v-if="dataIssue != ''">
        <b-card no-body>
            <b-tabs pills card vertical>
                <template v-for="(item, index) in dataIssue">
                    <b-tab :title="item.ownerName" active>
                        <div class="row">
                            <div class="col-8">
                                <b>{{item.title}}</b>
                                <vue-markdown
                                    style="min-height: 400px;"
                                    :source="item.description"
                                ></vue-markdown>
                            </div>
                            <div class="col-4">
                                <b>{{item.projectName}} - {{item.taskName}}</b>
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <p>Status</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button class="btn btn-outline-secondary" @click="save" >
                                            <i class="far fa-save"></i> Update Issue
                                        </button>
                                    </div>
                                </div>

                                <b-form-select
                                    name="issuestatus"
                                    :value="item.issueStatus"
                                    v-model="item.issueStatus"
                                    :options="issueStatusOptions"
                                >
                                </b-form-select>
                                <hr>
                                <p>Attachments</p>
                                <attachment-upload
                                    v-model="item.issueAttachments"
                                    :file-objects.sync="item.issueAttachmentsObjects"
                                    label="Attachments"
                                    label-for="issueAttachments"
                                    :handle.sync="item.issueHandle"
                                    @onAttachmentItemClick="attachmentClick"
                                    ns="issueAttachments"
                                    :uploadurl="uploadurl"
                                    mode="multi"
                                    :defaulturl="defaulturl"
                                    buttonlabel="Click or drop to upload"
                                >
                                </attachment-upload>


                            </div>
                        </div>
                    </b-tab>
                </template>
            </b-tabs>
        </b-card>
        </div>
        <div v-else-if="dataIssue == ''">
            <h4 class="text-center">No Issue</h4>
        </div>
    </b-modal>
</div>
</template>

<script>
    export default {
        name: "IssueView",
        props: {
            dataUrl : {
                type: String,
                default: 'get-data'
            },
            updateUrl : {
                type: String,
                default: 'update-issue'
            },
            extraData: {
                type: [String,Object,Array]
            },
            modalId: {
                type: [String,Array]
            },
            defaulturl : {
                type: String,
                default: 'images/coffee.png'
            },
            issueStatusOptions: {
                type: [String,Array]
            },
            countIssue: {
                type: [Number]
            },
            uploadurl : {
                type: String,
                default: 'api/v1/core/upload'
            },
        },
        data: function() {
            return {
                showModal : false,
                dataIssue : []
            }
        },
        watch: {

        },
        computed:{

        },
        mounted() {

        },
        methods: {
            getData(){
                //this.url = 'get-issue';
                var data = {};

                data.id = this.extraData._id;
                axios.post(this.dataUrl,data)
                    .then( response => {
                        console.log(response.data);
                        if(response.data.result == 'OK'){
                            this.dataIssue = response.data.data.data;
                            //this.issueStatusOptions = response.data.data.options;
                        }
                    })
                    .catch( error=> {
                        console.log(error);
                    });
            },
            getCount(){
                //this.url = 'get-issue';
                var data = {};

                data.id = this.extraData._id;
                axios.post(this.dataUrl,data)
                    .then( response => {
                        console.log(response.data);
                        if(response.data.result == 'OK'){
                            this.$emit('update:countIssue', response.data.data.count );
                        }
                    })
                    .catch( error=> {
                        console.log(error);
                    });
            },
            getTitle(){
                return 'View Issue' + ' ' + this.extraData.taskCode;
            },
            openModal(){
                this.showModal = true;
                this.$bvModal.show(this.modalId);
                this.getData();
            },
            closeModal(){
                this.$bvModal.hide(this.modalId);
            },
            attachmentClick(payload){
                console.log('issue payload', payload);
                bus.$emit('openlightbox', payload);
            },
            save(){
                //this.url = 'update-issue';
                var data = {};

                data = this.dataIssue;
                axios.post(this.updateUrl,data)
                    .then( response => {
                        console.log(response.data);
                        if(response.data.result == 'OK'){
                           this.closeModal();
                           this.$refs.tab.loadTableData();
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
        },
    }
</script>

<style scoped>
.text-right{
    text-align: right;
}
</style>
