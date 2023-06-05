<template>
    <div>
        <multiselect v-model="selectedItem"
                     id="ajax"
                     deselect-label="Can't remove this value"
                     label="text"
                     :selected="selected"
                     :track-by="trackBy"
                     placeholder="Select"
                     :options="options"
                     searchable
                     :allow-empty="true"
                     select-label=""
                     @select="emitValue"
                     class="local-search-select"

        >
            <template slot="tag" slot-scope="{ option, remove }">
                <span class="custom__tag"><span>{{ option.name }}</span><span class="custom__remove" @click="remove(option)">❌</span></span>
            </template>
            <template slot="clear" slot-scope="props">
                <div class="multiselect__clear" v-if="selectedItem" @mousedown.prevent.stop="clearAll(props.search)"></div>
            </template><span slot="noResult">Oops! No item found.</span>
        </multiselect>
        <pre v-if="debug" class="language-json"><code>{{ selectedItem  }}</code></pre>
    </div>
</template>

<script>
    export default {
        name: "LocalSearchSelect",
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
            label: {
                type: String
            },
            selected: {
                type: [Object, String],
                default: function(){
                    return null;
                }
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
            options: {
                type: Array,
                default: function(){
                    return [];
                }
            }

        },
        data () {
            return {
                selectedItem: {},
                selections: [],
                isLoading: false
            }
        },
        watch: {
            selectedItem: function(val){
                if(this.text){
                    this.$emit('input', val[this.outField] );
                }else{
                    this.$emit('input', val );
                }
            },
        },
        methods: {
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
            clearAll () {
                this.selectedItem = {}
            }
        }
    }
</script>

<style scoped>
 #ajax{
        font-size: 12px !important;
    }
</style>
