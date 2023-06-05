<template>
    <div class="row">
        <div :class="isLoading?'col-11':'col-12'">
            <b-form-select
                v-model="value"
                :options="selections"
            ></b-form-select>
        </div>
        <div v-if="isLoading" >
            <b-spinner></b-spinner>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ChainSelect",
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value: {
                type: [String, Object, Array, Number]
            },
            trigger: {
                type: [String, Object, Array, Number],
                default: function () {
                    return {}
                }
            },
            options: {
                type: Array,
                default: function () {
                    return []
                }
            },
            readOnly: {
                type: Boolean,
                default: false
            },
            searchUrl: {
                type: String
            },
            searchVar: {
                type: String,
                default: 'q'
            },
            text: {
                type: Boolean,
                default: false
            }
        },
        data: function () {
            return {
                selectedItem: {},
                selections: [],
                isLoading: false,
                editObj: this.objectDefault,
                showAll: false
            };
        },
        watch: {
            value: function(val){
                var obj = val;
                this.$emit('input', obj );
            },
            trigger: function(val){
                console.log(val);
                this.asyncFind(val);
            },
            selectedItem: function(val){
                if(this.text){
                    this.$emit('input', val[this.outField] );
                }else{
                    this.$emit('input', val );
                }
            }
        },
        methods: {
            asyncFind (query) {
                if(query == ''){
                    return;
                }
                this.isLoading = true;
                axios.get(this.searchUrl + '?' + this.searchVar + '=' + query )
                    .then( response => {
                        this.isSearching = false;
                        console.log(response.data);
                        if(response.data.result == 'OK'){
                            try {
                                this.selections = response.data.data;
                                this.isLoading = false
                            }catch (e) {
                                console.log(e);
                            }
                        }
                    })
                    .catch( error=> {
                        this.isLoading = false
                        console.log(error);
                    });

            },
            getKey(parentKey, childKey){
                return parentKey + '-' + childKey;
            },
            fmtDate(dateString, dateFormat){
                var dtrans = moment(dateString).format(dateFormat);
                return dtrans;
            },
            toggleShowAll(){
                this.showAll = !this.showAll;
            },
            splitCamel(str){
                str = str.replace(/([a-z\xE0-\xFF])([A-Z\xC0\xDF])/g, "$1 $2");
                str = str.toLowerCase(); //add space between camelCase text
                return str;
            },
            lowerCase(str) {
                if(str == null || str == undefined ){

                }else{
                    str = str.toLowerCase();
                }
                return str.toLowerCase();

            },
            upperCase(str) {
                if(str == null || str == undefined ){

                }else{
                    str = str.toUpperCase();
                }
                return str.toUpperCase();
            },
            properCase(str) {
                if(str == null || str == undefined ){

                }else{
                    str = this.lowerCase(str).replace(/^\w|\s\w/g, this.upperCase);
                }
                return str;
            },
            bus(evt, payload){
                bus.$emit(evt, payload );
            }
        }
    }
</script>

<style scoped>

</style>
