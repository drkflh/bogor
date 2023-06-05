<template>
    <div class="st-modal">
        <div class="">
            <div>
                <label class="pull-left" >{{ label }}</label>
                <span v-on:click="openAddItem()" class="btn btn-sm btn-primary pull-right" style="cursor: pointer;" ><i class="las la-plus-circle"></i></span>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr v-if="showTableHeader">
                        <th v-if="ordered" class="seq">
                            No.
                        </th>
                        <th v-for="col in cols" v-if="!( col == qtyCol || col == unitTotalCol )" >
                            {{ col.label }}
                        </th>
                        <td>
                            Qty
                        </td>
                        <td>
                            Total
                        </td>
                    </tr>
                    <tr v-for="(item, index) in items">
                        <td v-if="ordered" style="max-width: 35px;" >
                            {{ index + 1 }}
                        </td>
                        <td v-for="col in cols" v-if="!( col == qtyCol || col == unitTotalCol )" >
                            {{ item[col.key] }}
                        </td>
                        <td>
                            {{ item[qtyCol] }}
                        </td>
                        <td>
                            {{ item[unitTotalCol] }}
                        </td>
                        <td style="width: 150px;max-width: 200px;padding-right: 0px;">
                            <span v-on:click="removeItem(item)"  style="cursor: pointer;" class="btn btn-sm btn-danger pull-right" ><i class="las la-times-circle"></i></span>
                            <span v-on:click="editItem(item)"  style="cursor: pointer;margin-right:15px;" class="btn btn-sm btn-primary pull-right" ><i class="las la-pencil-alt"></i></span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <b-modal :id="modalId"
                 @ok="addItem"
                 size="lg"
                 :title="getTitle()"
                 :visibility="showModal"
                 :hide-backdrop="hideBackdrop"
                 modal-class="modal-bv" >
            <active-form
                    v-model="editObj"
                    :template="template"
                    :content="content"
                    :params="params"
                    :object-default="objectDefault"
            ></active-form>
        </b-modal>

    </div>
</template>

<script>
    export default {
        name: "InvoiceItems",
        props: {
            label : {
                type: String,
                default: 'Table Input'
            },
            cols : {
                type: [Array,Object],
                default: function(){
                    return [];
                }
            },
            items : {
                type: Array,
                default: function(){
                    return [];
                }
            },
            ordered : {
                type : Boolean,
                default : false

            },
            content: {
                type: [String, Object, Array]
            },
            params: {
                type: [String, Object, Array]
            },
            template: {
                type: [String, Object, Array]
            },
            objectDefault: {
                type: [String, Object, Array],
                default: function () {
                    return {}
                }
            },
            hideAddButton: {
                type: Boolean,
                default: false
            },
            modalId : {
                type: String,
                default: 'spiModal'
            },
            showTableHeader: {
                type: Boolean,
                default: false
            },
            qtyCol: {
                type: String
            },
            unitTotalCol: {
                type: String
            },
            unitPriceCol: {
                type: String
            },
            subTotal: {
                type: Number,
                default: 0
            },
            grandTotal: {
                type: Number,
                default: 0
            },
            discIn:{
                type: String,
                default: 'percent'
            },
            taxIn:{
                type: String,
                default: 'percent'
            }

        },
        data: function(){
            return {
                mode: '',
                editIndex: 0,
                editObj : _.clone(this.objectDefault),
                showModal : false,
                hideBackdrop : false
            };
        },
        methods: {
            getTitle(){
                return this.mode + ' ' + this.label;
            },
            closeModal(){
                this.editIndex = 0;
                //this.editObj = {};
                this.editObj = this.objectDefault;
                this.$bvModal.hide(this.modalId);
            },
            addItem(){
                var tempObj = this.objectDefault;
                if(this.isEmpty(this.editObj)){
                    alert('Empty data !')
                }else{
                    var newObj = this.editObj;
                    newObj[this.unitPriceCol] = parseFloat(newObj[this.unitPriceCol]);
                    var total = parseFloat(newObj[this.qtyCol]) * parseFloat(newObj[this.unitPriceCol]);
                    newObj[this.unitTotalCol] = total;

                    if(this.mode == 'Edit'){
                        this.items[this.editIndex] = newObj;
                    }else{
                        this.items.push(newObj);
                    }
                    this.editIndex = 0;
                    this.editObj = _.clone(this.objectDefault);
                    this.$bvModal.hide(this.modalId);
                }
            },
            removeItem(obj){
                var index = this.items.indexOf(obj);
                this.items.splice(index, 1);
            },
            editItem(obj){
                this.editIndex = this.items.indexOf(obj);
                this.editObj = _.clone(this.items[this.editIndex]);
                this.mode = 'Edit';
                this.showModal = true;
                this.$bvModal.show(this.modalId);
            },
            isEmpty(obj) {
                for(var key in obj) {
                    if(obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            },
            openAddItem(){
                this.mode = 'Create';
                this.editObj = {};
                this.editObj = _.clone(this.objectDefault);
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
