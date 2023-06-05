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
        name: "ActiveView",
        props: {
            content: {
                type: [String, Object, Array]
            },
            template: {
                type: [String, Object]
            },
            dateFormat: {
                type: String,
                default: 'DD MMM YYYY'
            }
        },
        data: function () {
            return {
                showAll: false
            };
        },
        created() {
            this.setInitial(this.content)
        },
        methods: {
            fmtDate(dateString, dateFormat){
                var dtrans = moment(dateString).format(this.dateFormat);
                return dtrans;
            },
            sumColumn(collection, fieldname){
                var items = collection.map( it => { return it[fieldname] } );
                var total = items.reduce( ( prev, curr) => {
                    var item = curr.replace( /,|\./gi , '');
                    return prev + parseFloat(item);
                }, 0 );
                console.log(total);
                return total;
            },
            mult( obj1, field1, obj2, field2 ){
                var first = parseFloat(obj1[field1]);
                var second = parseFloat(obj2[field2]);
                return first * second;
            },
            formatDate(dt) {
                return formatDate(dt);
            },
            formatCurrency(val){
                return accounting.formatMoney( parseFloat(val) , '' ,2, '.', ',');
            },
            toggleShowAll(){
                this.showAll = !this.showAll;
            },
            splitCamel(str){

                if(str != null && str != undefined ){
                    str = str.replace(/([a-z\xE0-\xFF])([A-Z\xC0\xDF])/g, "$1 $2");
                    str = str.toLowerCase(); //add space between camelCase text
                    return str;
                }else{
                    return str;
                }
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
            },
            remove(index) {
                this.$emit('remove', index)
            },
            selected(index, item) {
                this.$emit('selected', {
                    index: index,
                    item: item
                })
            },
            setInitial(data) {
                this.$emit('initial', data)
            }

        }
    }
</script>

<style scoped>

</style>
