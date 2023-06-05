<template>
    <div class="row" >
        <div class="col-lg-6 col-md-6 col-sm-12">
            <place-auto-search
                v-model="origin"
                :search-url="searchUrl"
            >
            </place-auto-search>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <place-auto-search
                v-model="destination"
                :search-url="searchUrl"
            >
            </place-auto-search>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TripRoutePicker",
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value: {
                type: Array,
                default: function(){
                    return [];
                }
            },
            searchUrl: {
                type: String
            },
            searchVar: {
                type: String,
                default: 'q'
            }
        },
        watch:{
            origin: function(val){
                if(this.addressPair.length > 2){
                    this.addressPair.unshift(val);
                }else{
                    this.addressPair.shift();
                    this.addressPair.unshift(val);
                }
                this.$emit('input', this.addressPair );
            },
            destination: function(val){
                if(this.addressPair.length > 2){
                    this.addressPair.push(val);
                }else{
                    this.addressPair.pop();
                    this.addressPair.push(val);
                }
                this.$emit('input', this.addressPair );
            },
            addressPair: function(val){
                console.log('address pair', val);
            }
        },
        data: function(){
            return {
                origin : {},
                destination: {},
                addressPair: [{}, {}],
                waypoints: []
            }
        }
    }
</script>

<style scoped>

</style>
