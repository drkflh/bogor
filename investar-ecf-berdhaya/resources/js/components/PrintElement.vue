<template>
    <div>
        <button type="button" class="btn btn-icon" @click="openPrintModal">
            <i class="las la-print"  style="font-size: 16pt"></i>
        </button>
        <span class="d-sm-inline-block">{{ buttonLabel }}</span>
        <b-modal
            id="printModal"
            @ok="printContent"
            ok-title="Print"
            size="xl"
            title="Print"
            scrollable
            centered
            :visibility="showModal"
            :hide-backdrop="false" >
            <div id="printedContent">
                <active-view
                        :content="content"
                        :template="template"
                >
                </active-view>
            </div>
        </b-modal>
    </div>
</template>

<script>
    export default {
        name: "PrintElement",
        props: {
            content: {
                type: [String, Object, Array],
                default: {}
            },
            template: {
                type: [String, Object],
                default: '<h1>Blank Page</h1>'
            },
            buttonLabel:{
                type: String,
                default: 'Print'
            },
            options : {
                type: Object,
                default: null
            }
        },
        data:function(){
            return {
                showModal: false
            };
        },
        methods: {
            printContent: function(){
                this.$htmlToPaper('printedContent', this.options );
            },
            openPrintModal: function(){
                this.$bvModal.show('printModal');
            }

        }
    }
</script>

<style scoped>

</style>
