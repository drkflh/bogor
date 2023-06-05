<template>
    <local-search-select
            id="formSelect"
            v-model="selectedCompany"
            :options="companyOptions"
    ></local-search-select>
</template>

<script>
    export default {
        name: "CompanySelector",
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
            companyOptions: {
                type: Array
            },
            companyCode: {
                type: String,
                default: ''
            },
            companyAddress: {
                type: String,
                default: ''
            },
            companyAddress1: {
                type: String,
                default: ''
            },
            companyAddress2: {
                type: String,
                default: ''
            },
            companyName: {
                type: String,
                default: ''
            },
            companyLogo: {
                type: String,
                default: ''
            },
            companyText: {
                type: String,
                default: ''
            },
             companyPhone: {
                type: String,
                 default: ''
            },
             companyPhone2: {
                type: String,
                 default: ''
            },
             companyFax: {
                type: String,
                 default: ''
            },
            // noNpwp: {
            //     type: String
            // }
        },
        data: function() {
            return {
                model: {},
                selectedCompany : '',
            }
        },
        watch: {
            selectedCompany: function (sel) {

                console.log("ini sel", sel);
                var val = sel.value;

                this.$emit('update:companyText', _.get(val, 'companyName', '') );
                this.$emit('update:companyCode', _.get(val, 'companyCode', '') );
                this.$emit('update:companyFax', _.get(val, 'companyFax', '') );
                this.$emit('update:companyPhone', _.get(val, 'companyPhone', '') );
                this.$emit('update:companyPhone2', _.get(val, 'companyPhone2', '') );
                this.$emit('update:companyName', _.get(val, 'companyName', '') );
                this.$emit('update:companyAddress', _.get(val, 'companyAddress', '') );
                this.$emit('update:companyAddress1', _.get(val, 'companyAddress1', '') );
                this.$emit('update:companyAddress2', _.get(val, 'companyAddress2', '') );
                this.$emit('update:companyLogo', _.get(val, 'companyLogo', '') );
                this.$emit('input', val.value);
            }
        },
        methods: {

        }
    }
</script>

<style scoped>

</style>
