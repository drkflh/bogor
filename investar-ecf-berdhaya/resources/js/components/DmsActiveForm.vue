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
        name: "DmsActiveForm",
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value: {
                type: [String, Object, Array, Number]
            },
            command: {
                type: [String, Object, Array]
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
            callCodeRePattern : {
                type: [Object, String, RegExp],
                default: function(){
                    const re = /.{1}-.{2}-.{2}-.{2}-.{7}-.{4}-.{2}/m;
                    return re;
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
            value: {
                deep: true,
                handler(val){
                    this.editObj = val;
                }
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
            },
            getDocSequence(){

                var entity = this.value.CallCode;

                console.log('getseq',entity);

                axios.post( this.params.getSeqUrl , { entity: entity, padding: 2 } )
                    .then(response => {
                        console.log(response.data);
                        if(response.data.result == 'OK'){
                            var seq = response.data.padded;
                            var newVal = this.value;
                            newVal.Urut = seq;
                            this.$emit('input', newVal);
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            },
            untilToday(date){
                const today = new Date();
                return date <= today;
            },
            fromToday(date){
                const today = new Date();
                return date >= today;
            },
            maxTodayNotBefore(date){
                const today = new Date();
                const before = new Date(this.value.DocDate);
                return before > date || date > today;
            },
            viewDocPdf(){
                bus.$emit('viewPdf', this.value.FileUrl );
            },
            generateRandomString(length=6){
                return Math.random().toString(20).substr(2, length);
            },
            embedQR(){
                const re = this.callCodeRePattern;
                if(this.value.FCallCode == '' && !re.exec(this.value.FCallCode) ){
                    alert('Call Code can not be empty');
                    return;
                }
                var entity = this.value.FileObject;

                entity.FCallCode = this.value.FCallCode;
                entity.addQR = true;
                entity.FCallCode = this.value.FCallCode;


                axios.post( this.params.embedQRUrl , { entity: entity } )
                    .then(response => {
                        console.log(response.data);
                        console.log(response.data.result);
                        if(response.data.result == 'OK'){
                            console.log(response.data.data);
                            let file = response.data.data.file;
                            this.value.FileUrl = file.FileUrl;
                            this.value.FileObject = file.FileObject;
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            },
            clearDmsForm() {

            },


        }
    }
</script>

<style scoped>

</style>
