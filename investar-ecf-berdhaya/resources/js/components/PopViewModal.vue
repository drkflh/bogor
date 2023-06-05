<template>
    <div class="pv-modal">
        <b-modal :id="modalId"
                 size="lg"
                 ok-disabled
                 scrollable
                 no-close-on-backdrop
                 no-close-on-esc
                 :title="label"
                 :visibility="showModal"
                 :hide-backdrop="hideBackdrop"
                 modal-class="modal-bv" >
            <active-view
                    :content="content"
                    :template="template"
            ></active-view>
        </b-modal>
    </div>
</template>

<script>
    export default {
        name: "PopViewModal",
        props: {
            content :{
                type: [Object, Array, String]
            },
            template : {
                type: String
            },
            label : {
                type: String,
                default: 'Pop View'
            },
            modalId : {
                type: String,
                default: 'pvModal'
            },
        },
        data: function(){
            return {
                showModal : false,
                hideBackdrop : false
            };
        },
        methods: {
            getTitle(){
                return this.mode + ' ' + this.label;
            },
            closeModal(){
                this.$bvModal.hide(this.modalId);
            },
            openModal(){
                this.showModal = true;
                this.$bvModal.show(this.modalId);
            }
        }
    }
</script>

<style scoped>
 .modal-bv {
     z-index: 10050 !important;
 }

</style>
