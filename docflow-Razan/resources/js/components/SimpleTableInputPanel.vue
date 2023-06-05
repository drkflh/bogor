<template>
    <div class="st-modal">
        <div v-show="showModal" class="card" >
            <div class="card-header">
                <label>{{ label }}</label>
                <span v-on:click="showModal=false"  style="cursor: pointer;" class="btn btn-sm btn-danger pull-right" ><i class="las la-times-circle"></i> Cancel</span>
                <span v-on:click="addItem"  style="cursor: pointer;margin-right:15px;" class="btn btn-sm btn-primary pull-right" ><i class="las la-check-circle"></i> Save</span>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr v-for="col in cols">
                        <td>
                            <label :for="col.key">{{ col.label }}</label>
                            <input type="text" class="form-control" v-model="editObj[col.key]" ></input>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <span class="error">{{ errorMsg }}</span>
            </div>
        </div>
        <div v-show="!showModal" class="card">
            <div class="card-header">
                <label>{{ label }}</label>
                <span v-on:click="openAddItem()" class="btn btn-sm btn-primary pull-right" style="cursor: pointer;" ><i class="las la-plus-circle"></i></span>
            </div>
            <div class="card-body">
                <table class="table" style="margin-top: 20px;">
                    <tr v-for="item in items">
                        <td v-for="col in cols">
                            {{ item[col.key] }}
                        </td>
                        <td style="width: 150px;max-width: 200px;padding-right: 0px;">
                            <span v-on:click="removeItem(item)"  style="cursor: pointer;" class="btn btn-sm btn-danger pull-right" ><i class="las la-times-circle"></i></span>
                            <span v-on:click="editItem(item)"  style="cursor: pointer;margin-right:15px;" class="btn btn-sm btn-primary pull-right" ><i class="las la-pencil-alt"></i></span>
                        </td>
                    </tr>
                </table>

            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SimpleTableInputPanel",
        props: {
            label : {
                type: String,
                default: 'Table Input'
            },
            cols : {
                type: Array,
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
            modalId : {
                type: String,
                default: 'spiModal'
            }
        },
        data: function(){
            return {
                mode: '',
                editIndex: 0,
                editObj : {},
                showModal : false,
                errorMsg : ''
            };
        },
        methods: {
            getTitle(){
                return this.mode + ' ' + this.label;
            },
            closeModal(){
                this.editIndex = 0;
                this.editObj = {};
                this.showModal = false;
                this.$bvModal.hide(this.modalId);
            },
            addItem(){
                if(this.isEmpty(this.editObj)){
                    this.errorMsg = 'Empty data !';
                }else{
                    if(this.mode == 'Edit'){
                        this.items[this.editIndex] = this.editObj;
                    }else{
                        this.items.push(this.editObj);
                    }
                    this.editIndex = 0;
                    this.editObj = {};
                    this.showModal = false;
                    this.$bvModal.hide(this.modalId);
                }
            },
            removeItem(obj){
                var index = this.items.indexOf(obj);
                this.items.splice(index, 1);
            },
            editItem(obj){
                this.editIndex = this.items.indexOf(obj);
                this.editObj = obj;
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
