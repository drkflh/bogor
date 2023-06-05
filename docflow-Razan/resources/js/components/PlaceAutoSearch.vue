<template>
    <div>
        <vue-bootstrap-typeahead
                :data="addresses"
                v-model="addressSearch"
                size="lg"
                :serializer="s => s.name"
                placeholder="Type an address..."
                @hit="onSelect"
        >
            <template slot="suggestion" slot-scope="{ data, htmlText }">
                <b><small v-html="htmlText"></small></b>
                <small>{{ data.locality }}</small><br>
                <small>{{ data.country + ',' + data.countryCode }}</small><br>
            </template>
        </vue-bootstrap-typeahead>
        <div   v-show="isSearching" class="text-center">
            <b-spinner small label="Small Spinner" ></b-spinner>
        </div>
        <div v-if="selectedAddress" class="result" style="display:block;padding:8px;">
            {{ selectedAddress.place }}<br>
            {{ selectedAddress.locality }}<br>
            {{ selectedAddress.country }} {{ selectedAddress.countryCode }}<br><br>
            lat: {{ selectedAddress.center.lat }}&nbsp;&nbsp;lng: {{ selectedAddress.center.lng }}
        </div>
    </div>
</template>

<script>
    export default {
        name: "PlaceAutoSearch",
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value: {
                type: [Array, Object],
                default: function(){
                    return [];
                }
            },
            searchUrl: {
                type: String
            },
            searchVar: {
                type: String,
                default: 'q'
            }
        },
        data() {
            return {
                places: [],
                addresses: [],
                addressSearch: '',
                selectedAddress: null,
                isSearching: false
            }
        },
        watch: {
            addressSearch: _.debounce(function(addr){
                this.getAddresses(addr)
            }, 500)
        },
        methods: {
            onSelect(dt){
                console.log(dt);
                this.selectedAddress = dt;
                this.addressSearch = '';
                this.$emit('input', this.selectedAddress);
            },
            getAddresses(query) {
                if(query == ''){
                    this.isSearching = false;
                }else{
                    this.isSearching = true;
                    axios.get(this.searchUrl + '?' + this.searchVar + '=' + query )
                        .then( response => {
                            this.isSearching = false;
                            console.log(response.data);
                            if(response.data.result == 'OK'){
                                try {
                                    console.log(response.data.places);
                                    this.places = response.data.places;
                                    this.addresses = response.data.places;
                                }catch (e) {
                                    console.log(e);
                                }
                            }
                        })
                        .catch( error=> {
                            this.isSearching = false;
                            console.log(error);
                        });

                }
            }
        }
    }
</script>

<style scoped>

</style>
