<template>
    <div v-bind:class="sumClass" >
        {{ valString }}
    </div>
</template>

<script>
    export default {
        name: "OneColumnSum",
        model: {
            prop: 'value',
            event: 'input'
        },
        props:{
            value: {
                type: Number,
                default: 0
            },
            items: {
                type: Array,
                default: function(){
                    return [];
                }
            },
            multiplyCol:{
                type: [String, Number, Boolean],
                default: false
            },
            colName:{
                type: [String, Number],
                default: 0
            },
            sumClass:{
                type: String,
                default: ''
            }
        },
        data: function(){
            return {
                valTotal : 0
            }
        },
        computed:{
            totalVal: function(){
                var total = _.sumBy( this.items, obj => {
                    if(this.multiplyCol){
                        return  parseFloat(obj[this.colName]) * parseFloat(obj[this.multiplyCol]);
                    }else{
                        return  parseFloat(obj[this.colName]);
                    }
                });
                this.valTotal = total;
                return total;
            },
            valString: function(){
                return this.valTotal
            }
        },
        watch: {
            valTotal: function (val) {
                this.$emit('input', val);
            }
        }
    }
</script>

<style scoped>

</style>
