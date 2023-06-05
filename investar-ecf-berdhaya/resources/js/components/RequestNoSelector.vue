<template>
    <local-search-select
            id="formSelect"
            v-model="selectedRequestno"
            :options="requestNoOptions"
    ></local-search-select>
</template>

<script>
    export default {
        name: "RequestNoSelector",
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value: {
                type: [String, Object, Array, Number]
            },
            options: {
                type: [String, Object, Array]
            },
            requestNoOptions: {
                type: Array
            },
            companyName: {
                type: String
            },
            jobNo: {
                type: String
            },
            costcenter: {
                type: String
            },
            currency: {
                type: String
            }
        },
        data: function() {
            return {
                model: {},
                selectedRequestno : '',
            }
        },
        watch: {
            selectedRequestno: function (sel) {

                console.log("ini sel", sel);
                var val = sel.value;

                this.$emit('update:requestNoText', val.requestNo);
                this.$emit('update:companyName', val.companyName);
                this.$emit('update:jobNo', val.jobNo);
                this.$emit('update:costCenter', val.costCenter);
                this.$emit('update:currency', val.currency);
                this.$emit('input', val.value);
            }
        },
        methods: {

        }
    }
</script>

<style scoped>
    #formSelect {
        height: 20px;
        font-size: 14px;
    }
</style>
