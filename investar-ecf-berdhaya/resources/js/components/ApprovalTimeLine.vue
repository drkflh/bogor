<template>
    <div>
        <div style="overflow-y: auto; overflow-x: auto; width: 100%; height:650px;padding: 20px;">
            <a-timeline>
                <a-timeline-item v-for="(obj, key, idx) in value" :key="key" :color="getColor(obj)">
                    <div style="font-size: 11pt;font-weight: bold;" >{{ obj.changeTo }}</div>
                    <div style="font-size: 10pt;" >{{ obj.createdAt }}</div>
                    <div style="font-size: 11pt;" >{{ obj.actorName }} as {{ _.get(obj , 'approveAs', 'Reviewer' ) }}</div>
                    <p v-html="obj.changeRemarks"></p>
                </a-timeline-item>
            </a-timeline>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ApprovalTimeLine",
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value: {
                type: [String, Object, Array, Number]
            },
            objectDefault: {
                type: [String, Object, Array],
                default: function () {
                    return {}
                }
            },
            readOnly: {
                type: Boolean,
                default: false
            }
        },
        data: function () {
            return {
                editObj: this.objectDefault,
                showAll: false,
                search : ''
            };
        },
        watch: {
            value: function(val){
                var obj = val;
                this.$emit('input', obj );
            }
        },
        methods: {
            clearSearch(){
                this.search = '';
            },
            getColor(obj){
                if(obj.changeTo == 'APPROVED'){
                    return 'green';
                }
                if(obj.changeTo == 'REJECTED'){
                    return 'red';
                }
                return 'blue';
            },
            searchAction(obj, key){
                if(this.search == ''){
                    return true;
                }
                console.log('key',key);
                if(obj.label.toUpperCase().indexOf( this.search.toUpperCase() ) > -1
                    //|| obj.descr.toUpperCase().indexOf( this.search.toUpperCase() ) > -1
                    //|| ( !_.isNull(key) && _.isString(key) && key.toUpperCase().indexOf( this.search.toUpperCase() ) > -1 )
                ) {
                    return true;
                }else{
                    return false;
                }
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
.table {
    display: table;
    width: 100%;
}
.tr {
    display: table-row;
    width: 100%;
}
.td {
    display: table-cell;
    padding: 5px;
}
.right {
    text-align: right;
}

</style>
