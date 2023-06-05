<template>
    <b-form-select
        v-model="value"
        :options="options"
        :disabled="disabled"
        :class="selectClass"
        @input="onInputChange"
        @change="onInputChange"
    >
    </b-form-select>
</template>

<script>
export default {
    name: "SimpleSelectObject",
    model: {
        prop: 'value',
        event: 'input'
    },
    created() {
        this.$nextTick(()=>{
            this.selectedVal = this.value;
        })
    },
    activated() {
        this.$nextTick(()=>{
            this.selectedVal = this.value;
        })
    },
    computed: {

    },
    watch: {

    },
    methods: {
          onInputChange : function (val) {
              console.log(val);
              let obj = _.get( this.objectMap, val );
              this.$emit('input', val);
              this.$emit('update:selectedObject', obj);
          }
    },
    props: {
        objectMap: {
            type: [Object, Array],
            default: function (){
                return {};
            }
        },
        options: {
            type: [Array],
            default: function (){
                return [];
            }
        },
        selectedObject: {
            type: [Object],
            default: function (){
                return {};
            }
        },
        trackBy: {
            type: String,
            default: '_id'
        },
        selectClass: {
            type: String,
            default: 'form-control'
        },
        disabled: {
            type: [String, Boolean],
            default: function () {
                return false;
            }
        }
    },
    data: function (){
        return {
            selectedVal : '',
            flatOptions : []
        }
    }

}
</script>

<style scoped>

</style>
