<template>
    <div>
        <multiselect v-model="selectedItem"
                     id="ajax"
                     :label="label"
                     :track-by="trackBy"
                     placeholder="Type to search"
                     :selected="selectedItem"
                     open-direction="bottom"
                     :options="selections"
                     :multiple="false"
                     :searchable="true"
                     :loading="isLoading"
                     :internal-search="false"
                     :clear-on-select="true"
                     :close-on-select="true"
                     :options-limit="100"
                     :limit="3"
                     :limit-text="limitText"
                     :max-height="600"
                     :show-no-results="false"
                     :hide-selected="true"
                     select-label=""
                     @search-change="asyncFind"
                     @select="emitValue"
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
        name: "RemoteSelect",
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
            }

        },
        data () {
            return {
                selectedItem: {},
                selections: [],
                isLoading: false,
                selectedItemObject: {},
                lastQuery: ''
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

</style>
