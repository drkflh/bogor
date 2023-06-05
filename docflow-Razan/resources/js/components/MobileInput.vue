<template>
    <div style="display: flex; flex-direction: row;">
        <vue-phone-number-input
            default-country-code="defaultCountry"
            v-model="value"
        >
        </vue-phone-number-input>
        <button class="btn btn-outline-secondary" style="border:none;"  @click="handleClearInput()"><i class="las la-times-circle"></i></button>
    </div>
</template>

<script>
    export default {
        name: "MobileInput",
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value: {
                type: String,
                default: function(){
                    return '';
                }
            },
            defaultCountry: {
                type: String,
                default: ''
            },
            refKey: {
                type: String,
                default: function(){
                    return 'pin'
                }
            }
        },
        data: function(){
            return {
                tag: '',
                tags: [],
                autocompleteItems: [],
                debounce: null,
            };
        },
        watch: {

        },
        computed: {
            intNumInputs: function(){
                return parseInt(this.numInputs);
            }
        },
        methods: {
            handleOnComplete(value) {
                console.log('OTP completed: ', value);
            },
            handleOnChange(value) {
                console.log('OTP changed: ', value);
                this.$emit('input', value);
            },
            handleClearInput() {
                this.$refs[this.refKey].clearInput();
            }

        },

    }
</script>

<style lang="less" >
.otp-input {
    width: 40px;
    height: 40px;
    padding: 5px;
    margin: 0 4px;
    font-size: 20px;
    border-radius: 4px;
    border: 1px solid rgba(0, 0, 0, 0.3);
    text-align: center;
    &.error {
        border: 1px solid red !important;
    }
}
.otp-input::-webkit-inner-spin-button,
.otp-input::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
