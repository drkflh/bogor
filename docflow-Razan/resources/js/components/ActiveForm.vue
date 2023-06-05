<template>
    <div>
        <v-runtime-template
            :template="template"
        >
        </v-runtime-template>
    </div>
</template>

<script>
    export default {
        name: "ActiveForm",
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value: {
                type: [String, Object, Array, Number]
            },
            content: {
                type: [String, Object, Array]
            },
            params: {
                type: [String, Object, Array]
            },
            template: {
                type: [String, Object]
            },
            objectDefault: {
                type: [String, Object, Array],
                default: function () {
                    return {}
                }
            },
        },
        data: function () {
            return {
                editObj: this.objectDefault,
                showAll: false,
                isLoading: false
            };
        },
        watch: {
            value: function(val){
                this.editObj = val;
            }
        },
        methods: {
            contentToModel(obj){
                this.editObj = obj;
            },
            modelToDefault(){
                this.editObj = this.objectDefault;
            },
            emitData(){
                var val = this.value;
                this.$emit('input', this.editObj );
            },
            showModal(_id, obj) {
                this.$bvModal.show(_id);
            },
            hideModal(_id) {
                this.$bvModal.hide(_id);
                this.emitData();
            },
            fmtDate(dateString, dateFormat){
                var dtrans = moment(dateString).format(dateFormat);
                return dtrans;
            },
            sumColumn(collection, fieldname){
                var items = collection.map( it => { return it[fieldname] } );
                var total = items.reduce( ( prev, curr) => {
                    prev + parseFloat(curr);
                }, 0 );
                return total;
            },
            mx( val1, val2 ){
                return parseFloat(val1) * parseFloat(val2);
            },
            mult( obj1, field1, obj2, field2 ){
                var first = parseFloat(obj1[field1]);
                var second = parseFloat(obj2[field2]);
                return first * second;
            },
            multSet( obj1, field1, obj2, field2, acc, accField ){
                var first = parseFloat(obj1[field1]);
                var second = parseFloat(obj2[field2]);
                acc[ accField ] = first * second;
                return first * second;
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
            startLoading(){
                this.isLoading = true;
            },
            doneLoading(){
                this.isLoading = false;
            },
            bus(evt, payload){
                bus.$emit(evt, payload );
            }
        }
    }
</script>

<style scoped>

</style>
