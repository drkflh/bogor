<template>
    <local-search-select
            id="formSelect"
            v-model="selectedVendor"
            :options="vendorOptions"
    ></local-search-select>
</template>

<script>
    export default {
        name: "VendorSelector",
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
            vendorOptions: {
                type: Array
            },
            vendorAddress: {
                type: String,
                default: ''
            },
            vendorAddress2: {
                type: String,
                default: ''
            },
            vendorName: {
                type: String,
                default: ''
            },
            vendorPhone: {
                type: String,
                default: ''
            },
            vendorPic: {
                type: [String, Object, Array]
            },
            vendorText: {
                type: String,
                default: ''
            },
            vendorEmail: {
                type: String,
                default: ''
            },
            vendorCity: {
                type: String,
                default: ''
            },
            vendorCountry: {
                type: String,
                default: ''
            },
            vendorProvince: {
                type: String,
                default: ''
            },
            vendorPostal: {
                type: [Number, String],
                default: ''
            }
        },
        data: function() {
            return {
                model: {},
                selectedVendor : '',
            }
        },
        watch: {
            selectedVendor: function (sel) {

                console.log("ini sel", sel);

                var val = sel.value;
                // this.$emit('update:topicText', val.Topic);

                var picContact;

                for ( var i = 0; i < val.picContacts.length; i++ ){
                    var curr = val.picContacts[i];
                    console.log('curr',curr.contactName);

                    if( _.has(curr, 'contactName') && _.get( curr, 'contactName') == true ){
                        picContact = curr.contactName;
                    }

                    var picContact = curr.contactName;
                    console.log("ini tes", picContact);
                }

                // console.log('pic contact',picContact);
                // console.log('ini selectedvendor', sel.value);
                this.$emit('update:vendorText', val.vendorCode);
                this.$emit('update:vendorName', val.coyName);
                this.$emit('update:vendorAddress', val.address);
                this.$emit('update:vendorAddress2', val.address2);
                this.$emit('update:vendorCity', val.city);
                this.$emit('update:vendorCountry', val.country);
                this.$emit('update:vendorProvince', val.province);
                this.$emit('update:vendorPostal', val.postalCode);
                this.$emit('update:vendorPhone', val.picContacts[0].contactPhone);
                this.$emit('update:vendorPic', val.picContacts[0].contactName);
                this.$emit('update:vendorEmail', val.picContacts[0].contactEmail);
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
