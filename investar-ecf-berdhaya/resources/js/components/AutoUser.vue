<template>
    <local-search-select
            id="formSelect"
            v-model="selectedUser"
            :options="userOptions"
    ></local-search-select>
</template>

<script>
    export default {
        name: "AutoUser",
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
            userOptions: {
                type: Array
            },
            userName: {
                type: String,
                default: ''
            },
            userPhone: {
                type: String,
                default: ''
            },
            userDepartement: {
                type: String,
                default: ''
            },
             userAddress: {
                type: String,
                 default: ''
            },
             userNIK: {
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
                selectedUser : '',
            }
        },
        watch: {
            selectedUser: function (sel) {

                console.log("ini sel", sel);
                var val = sel.value;

                this.$emit('update:userDepartement', _.get(val, 'Departement', '') );
                this.$emit('update:userName', _.get(val, 'name', '') );
                this.$emit('update:userNIK', _.get(val, 'NIK', '') );
                this.$emit('update:userAddress', _.get(val, 'address', '') );
                this.$emit('update:userPhone', _.get(val, 'userPhone', '') );
                this.$emit('input', val.value);
            }
        },
        methods: {

        }
    }
</script>

<style scoped>

</style>
