<template>
    <div>
        <div class="input-group">
            <input type="text" v-model="search" class="form-control" placeholder="Search" ></input>
            <button
                @click="clearSearch()"
                type="button" class="btn bg-transparent" style="margin-left: -40px; z-index: 100;">
                <i class="las la-times"></i>
            </button>
        </div>
        <hr>
        <div style="overflow-y: auto; overflow-x: auto; width: 100%; height:650px;">
            <b-card  v-for="(obj, key, idx) in value" :key="key" class="mt-2" v-if="searchAction(obj, key)"  >
                <div class="table">
                    <div class="tr">
                        <div class="td">
                            <p class="card-text">[ {{ key }} ] {{ obj.label }}</p>
                        </div>
                        <div class="td right">
                            <!--                        <b-form-checkbox v-model="obj.enabled" :name="getKey( key, 'enabled' )" :disabled="readOnly" inline switch>-->
                            <!--                            Enabled-->
                            <!--                        </b-form-checkbox>-->
                        </div>
                    </div>
                </div>
                <p class="card-text">{{ obj.descr }}</p>
                <b-form-checkbox v-for="acl in obj.acl" :key="getKey( key, acl.key )" v-model="acl.value" :name="getKey( key, acl.key )" :disabled="readOnly" inline switch>
                    {{ acl.label }}
                </b-form-checkbox>
            </b-card>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ActiveCheckList",
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
            searchAction(obj, key){

                if(this.search == ''){
                    return true;
                }

                if(obj.label.toUpperCase().indexOf( this.search.toUpperCase() ) > -1
                    || ( !_.isNull(obj.descr) && _.isString(obj.descr) && obj.descr.toUpperCase().indexOf( this.search.toUpperCase() ) > -1 )
                    || ( !_.isNull(key) && _.isString(key) && key.toUpperCase().indexOf( this.search.toUpperCase() ) > -1 )
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
