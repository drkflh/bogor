<template>
    <div class="st-modal">
        <div class="listBlock">
            <div>{{ label }}</div>
            <div class="listBlockAction" v-on:click="openAddItem()"><i class="las la-plus" aria-hidden="true"></i></div>
        </div>
        <table class="listBlockTable" v-if="items.length>0">
            <tr v-if="showTableHeader">
                <th v-for="col in cols">
                    {{ col.label }}
                </th>
                <th></th>
            </tr>
            <tr v-for="item in items">
                <td v-for="col in cols">
                    {{ item[col.key] }}
                </td>
                <td class="listBlockActions">
                    <div class="listBlockAction" v-on:click="removeItem(item)"><i class="las la-minus" aria-hidden="true"></i></div>
                    <div class="listBlockAction" v-on:click="editItem(item)"><i class="las la-pencil-alt" aria-hidden="true"></i></div>
                </td>
            </tr>
        </table>
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
        name: "SimpleListInputModal",
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
 .listBlock {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 600;}
    .listBlock .listBlockAction {
        cursor: pointer;
        font-size: 15px;
        background-color: #138080;
        height: 16px;
        width: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 100%;}
        .listBlock .listBlockAction i{
        font-size: 8pt;
        color: #fff}
.listBlockTable {
    position: relative;
    margin-top: 5px;}
    .listBlockTable th {
    background-color: #f2f2f2;
    padding: 6px}
    .listBlockTable td {
        padding: 6px}
    .listBlockTable .listBlockActions {
        width: 100%;
        display: flex;
        margin: 4px 0;}
    .listBlockTable .listBlockAction {
        cursor: pointer;
        font-size: 15px;
        background-color: #138080;
        height: 16px;
        width: 18px;
        margin: 0 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 5px}
        .listBlockTable .listBlockAction i {
        font-size: 8pt;
        color: #fff}
.listItems {
    display: block;
    border: 1px solid #f2f2f2;
    border-radius: 3px;
    margin-top: 15px;}
    /* .listItems:nth-child(even) {
        background-color: #f1f1f1;
    } */
    .listItems .item {
        display: flex;
        justify-content: flex-start;
        align-items: center;}
    .listItems .item .listContent{
        flex: 1;
        display: flex;
        padding-left: 15px;
        padding-right: 15px; }
        .listItems .item .listContent .listLabel {
            min-width: 100px;
            font-weight: 600;
            display: flex;
            align-items: center;}
        .listItems .item .listContent .listKey {
            flex: 1;
            padding: 5px;
            border: 1px solid #f2f2f2;}
    .listItems .listAction {
        display: flex;
        justify-content: flex-end;
        margin-top: 5px;
        margin-bottom: 5px;
        margin-right: 10px}
    .listItems .listAction .edit {
        padding: 3px 6px;
        border-radius: 20px;
        background-color: #0153c7;
        margin-right: 5px;
        color: #fff;
        font-size: 10px;
        cursor: pointer;}
    .listItems .listAction .remove {
        padding: 3px 6px;
        border-radius: 20px;
        background-color: #d10c3d;
        color: #fff;
        font-size: 10px;
        cursor: pointer;}
    .listItems .item .listAction{
        display: flex; }

</style>
