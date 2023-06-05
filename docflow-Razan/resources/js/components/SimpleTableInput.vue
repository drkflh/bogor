<template>
    <div>
        <label class="label">{{ label }}</label>
        <table class="table">
            <tr>
                <td v-if="ordered" class="seq">
                    No.
                </td>
                <th v-for="col in cols">
                    <label :for="col.key">{{ col.label }}</label>
                    <input type="text" class="form-control" v-model="editObj[col.key]" ></input>
                </th>
                <th style="position: relative;width: 50px;vertical-align: bottom;padding-right: 0px;">
                    <span v-on:click="addItem()" style="cursor: pointer;" class="pull-right"><i class="las la-plus-circle"></i></span>
                </th>
            </tr>
            <tr v-for="(item, index) in items">
                <td v-if="ordered" style="max-width: 35px;" >
                    {{ index + 1 }}
                </td>
                <td v-for="col in cols">
                    {{ item[col.key] }}
                </td>
                 <td style="width: 75px;max-width: 75px;padding-right: 0px;">
                    <span v-on:click="removeItem(item)"  style="cursor: pointer;float:right;" class="pull-right"><i class="las la-trash-alt"></i></span>
                    <span v-on:click="editItem(item)"  style="cursor: pointer;float:right;margin-right:15px;" class="pull-right" ><i class="las la-paperclip"></i></span>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        name: "SimpleTableInput",
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
            ordered : {
                type : Boolean,
                default : false

            }
        },
        data: function(){
            return {
                editObj : {},
            };
        },
        methods: {
            addItem(){
                if(this.isEmpty(this.editObj)){
                    alert('Empty data !')
                }else{
                    this.items.push(this.editObj);
                    this.editObj = {};
                }
            },
            removeItem(obj){
                var index = this.items.indexOf(obj);
                this.items.splice(index, 1);
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
    .seq{
        text-align: center;
        padding-bottom: 16px;
        vertical-align: bottom;
    }
    .label{
        font-size: 16px;
    }
</style>
