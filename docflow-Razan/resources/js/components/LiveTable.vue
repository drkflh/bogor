<template>
    <div>
<!--        <div style="width:100%">-->
<!--            <button class="btn btn-alt-primary pull-right" @click="loadTableData()">-->
<!--                <i class="las la-redo-alt"></i>-->
<!--            </button>-->
<!--        </div>-->
        <a-table
            :columns="columns"
            :row-key="record => record._id"
            :data-source="rows"
            :pagination="{ total: totalRecords, position : 'top' }"
            :loading="isLoading"
            :scroll="{ y: 650, x: 2500 }"
            :row-selection="{ selectedRowKeys: selectedRowKeys, onChange: onSelectChange }"
            table-layout="auto"
            @change="handleTableChange"
        >
        </a-table>
    </div>
</template>

<script>
    export default {
        name: "LiveTable",
        mounted() {
            this.loadTableData();
        },
        props: {
            dataUrl: {
                type: String
            },
            columns: {
                type: Array,
                default: function(){
                    return [];
                }
            },
            perPage: {
                type: Number,
                default: 25
            },
            readOnly: {
                type: Boolean,
                default: false
            },
            extraData: {
                type: [Object, Array, String],
                default: function(){
                    return {};
                }
            },
            selectedKeys: {
                type: [Object, Array, String],
                default: function(){
                    return [];
                }
            }
        },
        data: function () {
            return {
                showAll: false,
                showProgress: false,
                selectedRows: [],
                rows: [],
                selectedRowKeys: [],
                isLoading: false,
                totalRecords: 0,
                serverParams: {
                    columnFilters: {},
                    sort: {
                        field: '',
                        type: '',
                    },
                    page: 1,
                    perPage: this.perPage,
                    extraData: this.extraData
                }
            };
        },
        watch: {
            selectedRowKeys: function(val){
                this.$emit('update:selectedKeys', this.selectedRowKeys);
            }
        },
        methods: {
            loadTableData() {
                console.log('VGT load');
                this.isLoading = true;
                this.serverParams.extraData = this.extraData;
                axios.post(this.dataUrl, this.serverParams )
                    .then(response =>{
                        console.log(response);
                        if(response.status == 200){
                            this.rows = response.data.data;
                            this.totalRecords = response.data.total;
                        }else if(response.status == 401){
                            alert('Your session is expired. Please re-login');
                        }
                        this.isLoading = false;
                    })
                    .catch(error => {
                        this.isLoading = false;
                    });

            },
            handleTableChange(pagination, filters, sorter) {

                //this.serverParams.page = pager.current;

                console.log( pagination );
                console.log( filters );
                console.log( sorter );
                console.log( this.serverParams );

                this.serverParams.page = pagination.current;
                this.serverParams.perPage = pagination.pageSize;
                this.loadTableData();
            },
            onSelectChange(selectedRowKeys, selectedRows) {
                console.log('selectedRow changed: ', selectedRows);
                console.log('selectedRowKeys changed: ', selectedRowKeys);
                this.selectedRowKeys = selectedRowKeys
                this.selectedRows = selectedRows;
            },
            setExtraData(val){
                this.extraData = val;
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
.ant-table-fixed{
    width: 100% !important;
}
ul.ant-table-pagination.ant-pagination {
    float: left !important;
    margin: 16px 0;
}
</style>
