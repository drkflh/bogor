<template>
<div class="st-modal">
    <a v-on:click="openModal(label)">{{ label }}</a>
    <b-modal     
        :id="modalid"
        size="lg"
        :title="title"
        :visibility="showModal"
        :hide-backdrop="hideBackdrop">

        <b-tabs content-class="mt-3 tabHeader" nav-class="tab-header" fill justified >
            <b-tab title="Info Project" active>
                <div class="row">
                    <div class="col-md-6">
                        <h5><b>Trading Apps</b></h5>
                        <p><i class="las la-sticky-note"></i> Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia, laborum pariatur provident quos voluptatem necessitatibus.</p>
                        <p class="text-muted"><i class="las la-stopwatch"></i> 25 Jul 2021 - 12 Aug 2021</p>
                    </div>
                    <div class="col-md-6">
                        <h5><b>PT Ainsoft</b></h5>
                        <p><i class="las la-user"></i> Pak Hyung Sik</p>
                        <p class="text-muted"><i class="las la-phone"></i> 0251-2348-213</p>
                        <span class="badge badge-success p-2">On Progress</span>
                    </div>
                </div>
            </b-tab>
            <b-tab title="Personnel">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Role</th>
                                <th scope="col">Name</th>
                                <th scope="col">Task Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Employee</td>
                                    <td>Budi</td>
                                    <td>12 Project Handle</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Employee</td>
                                    <td>Bani</td>
                                    <td>8 Task Handle</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </b-tab>
            <b-tab title="Issues">
                <div class="row">
                <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Task</th>
                                <th scope="col">Issue</th>
                                <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Chart Daily</td>
                                    <td>wording issue</td>
                                    <td>On Progress</td>
                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Chart Weekly</td>
                                    <td>wording issue</td>
                                    <td>Open</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </b-tab>
        </b-tabs>
    </b-modal>
</div>
</template>

<script>
    export default {
        name: "DetailProject",
        props: {
            label: {
                type: [String]
            },
            idProject: {
                type: [String]
            },
            value: {
                type: [String,Array]
            },
            modalId : {
                type: String,
                default: 'spiModal'
            },
            projectUrl : {
                type: String,
            },
        },
        data: function() {
            return {
                showModal : false,
                hideBackdrop : false,
                modalid : Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)
            }
        },
        methods: {
            openModal(val){
                this.title = "Project " + val;
                this.showModal = true;
                this.$bvModal.show(this.modalid);
                axios.get(this.projectUrl + '/' + this.idProject )
                    .then( response => {
                        console.log(response.data);
                        if(response.data.result == 'OK'){
                            this.value = response.data.data;
                        }
                    })
                    .catch( error=> {
                        console.log(error);
                    });
            }
        }
    }
</script>
