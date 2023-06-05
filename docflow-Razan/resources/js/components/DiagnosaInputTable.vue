<template>
    <div class="card sti-container">
        <div class="card-header">
            <label>{{ label }}</label>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <td class="col-4" style="min-width: 20%;width:20%;">
                        <label for="mata" >Mata</label><br>
                        <!--<b-form-select-->
                                <!--v-model="editObj.mata"-->
                                <!--:options="params.mataoptions">-->
                        <!--</b-form-select>-->
                        <local-select
                                v-model="editObj.mata"
                                :options="params.mataoptions"
                                :selected="defaultMata"
                                text
                        ></local-select>
                        <div style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
                    </td>
                    <td class="col-7"  style="max-width: 80%;width:80%;">
                        <label for="icdx" >ICD-X</label><br>
                        <remote-select
                                id="icdx"
                                v-model="editObj.icdx"
                                :search-url="params.icdxUrl"
                                :selected="editObj.icdx"
                                track-by="id"
                                out-field="text"
                                text
                        ></remote-select>
                    </td>
                    <td v-if="!hideAddButton" style="position: relative;width: 50px;max-width: 50px;vertical-align: bottom;padding-right: 0px;padding-bottom: 16px;">
                        <span v-on:click="addItem()" style="cursor: pointer;" class="btn btn-sm btn-primary pull-right" ><i class="las la-plus-circle"></i></span>
                    </td>
                </tr>
            </table>
            <table class="table">
                <tr v-for="item in items">
                    <td v-for="col in cols">
                        {{ item[col.key] }}
                    </td>
                    <td style="position: relative;width: 150px;max-width: 200px;vertical-align: bottom;padding-right: 0px;">
                        <span v-on:click="removeItem(item)" style="cursor: pointer;" class="btn btn-sm btn-danger pull-right" ><i class="las la-times-circle"></i></span>
                        <span v-if="!hideEditButton" v-on:click="editItem(item)"  style="cursor: pointer;margin-right:15px;" class="btn btn-sm btn-primary pull-right" ><i class="las la-pencil-alt"></i></span>
                    </td>
                </tr>
            </table>

        </div>
        <div class="card-footer">

        </div>
    </div>
</template>

<script>
    export default {
        name: "DiagnosaInputTable",
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
            hideEditButton: {
                type: Boolean,
                default: false
            },
            defaultMata: {
                type: String,
                default: 'OD'
            }
        },
        watch:{
            defaultMata:function(val){
                this.editObj.mata = val;
            }
        },
        data: function(){
            return {
                mode: '',
                editIndex: 0,
                editObj : { mata: '', icdx: ''},
                showModal : false,
                errorMsg : ''
            };
        },
        methods: {
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
        }
    }
</script>

<style scoped>

</style>
