<template>
    <b-table
        striped
        hover
        :items="tableItems"
        :fields="tableFields"
    >
    </b-table>
</template>

<script>
    export default {
        name: "SimpleTable",
        props: {
            fields:{
                type: Array,
            },
            items:{
                type: Array,
            },
            ordered: {
                type: Boolean,
                default: false
            }
        },
        computed:{
            tableItems: function(){
                if(this.ordered){
                    var ordered = [];
                    _.forEach(this.items, (it, ky )=>{
                        it.seq = ky + 1;
                        ordered.push(it);
                    });
                    return ordered;
                }else{
                    return this.items;
                }
            },
            tableFields: function(){
                if(this.ordered){
                    return _.concat( { key: 'seq', label:'No' } ,this.fields );
                }else{
                    return this.fields;
                }
            }

        }
    }
</script>

<style scoped>

</style>
