<template>
    <div>
        <vue-json-editor
            v-model="jsonTree"
            :show-btns="true"
            :expandedOnStart="true"
            @json-change="onJsonChange">

        </vue-json-editor>
    </div>
</template>

<script>
export default {
    name: "JsonEditor",
    props:{
        jsonTree: {
            type: [Array, Object],
            default: function(){
                return {};
            }
        }
    },
    methods: {
        onJsonChange (value) {
            this.$emit('update:jsonTree', value );
            console.log('value:', value)
        }
    }
}
</script>

<style scoped>

</style>
