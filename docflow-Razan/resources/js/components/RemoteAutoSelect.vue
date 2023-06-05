<template>
    <div style="width: 100%;" class="remote-auto-select" >
        <a-auto-complete
            v-model="selectedItem"
            size="large"
            style="width: 100%"
            defaultValue="selected"
            @select="onSelect"
            @search="asyncFind"
            @change="onChange"
            :defaultValue="value"
        >
            <template slot="dataSource">
                <a-select-option v-for="sel in selections" :key="sel.text">{{ sel.text }}</a-select-option>
            </template>
        </a-auto-complete>
    </div>
</template>

<script>
    export default {
        name: "RemoteAutoSelect",
        model: {
            prop: 'value',
            event: 'input'
        },
        props:{
            searchUrl: {
                type: String
            },
            searchVar: {
                type: String,
                default: 'q'
            },
            options: {
                type: Array,
                default: function () {
                    return []
                }
            },
            clearOnSelect:{
                type: Boolean,
                default: true
            },
            closeOnSelect: {
                type: Boolean,
                default: true
            },
            selected: {
                type: [Object, String],
                default: function(){
                    return null;
                }
            },
            selectedObject:{
                type: Object,
                default: function(){
                    return {};
                }
            },
            label: {
                type: String,
                default: 'text'
            },
            trackBy: {
                type: String,
                default: 'value'
            },
            outField: {
                type: String,
                default: 'value'
            },
            debug: {
                type: Boolean,
                default: false
            },
            text: {
                type: Boolean,
                default: false
            },
            extraData: {
                type: [Object, Array, String],
                default: function(){
                    return {};
                }
            }
        },
        data () {
            return {
                selectedItem: this.selected,
                selections: [],
                isLoading: false,
                selectedItemObject: {},
                lastQuery: ''
            }
        },
        watch: {
            selectedItem: function(val){
                let obj = this.getObject(val);
                this.$emit('update:selectedObject', obj );
                this.$emit('input', this.selectedItem );
            }
        },
        created() {

        },
        methods: {
            getObject(val){
                for( let i = 0; i < this.selections.length ; i++){
                    if(this.selections[i].text == val){
                        return this.selections[i].value;
                    }
                }
                return {};
            },
            onSearch(query) {
                this.asyncFind(query);
                //this.dataSource = !searchText ? [] : [searchText, searchText.repeat(2), searchText.repeat(3)];
            },
            onSelect(value) {
                console.log('autoselect', value);
                let obj = this.getObject(value);
                console.log('autoselectobj', obj);
                this.$emit('input', value );
                this.$emit('update:selectedObject', obj );

            },
            onChange(value) {
                this.$emit('input', value );
                console.log('onChange', value);
            },
            limitText (count) {
                return `and ${count} other items`
            },
            emitValue(){
                this.$emit('input', this.selectedItem );
            },
            asyncFind (query) {
                if(query == ''){
                    return;
                }
                this.isLoading = true;

                this.lastQuery = query;

                axios.post( this.searchUrl, { q : query, extraData : this.extraData }  )
                // axios.get(this.searchUrl + '?' + this.searchVar + '=' + query )
                    .then( response => {
                        this.isSearching = false;
                        console.log(response.data, this.lastQuery);
                        if(response.data.result == 'OK'){

                            try {
                                if(response.data.q == this.lastQuery){
                                    this.selections = response.data.data;
                                    this.lastQuery = '';
                                    this.isLoading = false
                                }
                            }catch (e) {
                                console.log(e);
                            }
                        }
                    })
                    .catch( error=> {
                        this.isLoading = false;
                        this.lastQuery = '';
                        console.log(error);
                    });

            },
            clearAll () {
                this.selectedItem = {}
            }
        }
    }
</script>

<style scoped>
.ant-select-auto-complete.ant-select-lg .ant-input {
    font-size: 12pt !important;
    height: 32px;
    padding-top: 6px;
    padding-bottom: 6px;
}
</style>
