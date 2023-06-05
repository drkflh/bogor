<template>
    <div>
        <label>{{ label }}</label>
        <div v-for="(col, cId) in cols" :key="cId" class="listInput">
            <v-select
                label="text"
                :options="params"
                v-model="editObj[col.key]">
            </v-select>
            <div>
                <span v-on:click="addItem()" style="cursor: pointer;" class="btn btn-primary pull-right" ><i class="las la-plus-circle"></i></span>
            </div>
        </div>
        <div class="listInput" v-for="(item, index) in items" :key="item.value">
            <div class="listNumber" v-if="ordered">{{ index + 1 }}</div>
            <div class="listText" v-for="col in cols" :key="col.text">
                <div>{{ item }}</div>
            </div>
            <div class="listAction">
                <div>
                    <span v-on:click="removeItem(item)" style="cursor: pointer;" class="btn btn-danger pull-right" ><i class="las la-times-circle"></i></span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SimpleListInput",
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

            },
            params: {
                type: [String, Object, Array]
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
                    this.items.push(this.editObj.description.value);
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
            }
        }
    }
</script>

<style scoped>
    .listInput {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .listInput .v-select, .listInput .listText {
        flex: 1;
        margin-right: 10px;
    }
    .listInput .btn {
        height: 35px;
        width: 35px;
        border-radius: 3px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .seq{
        text-align: center;
        padding-bottom: 16px;
        vertical-align: bottom;
    }
</style>
