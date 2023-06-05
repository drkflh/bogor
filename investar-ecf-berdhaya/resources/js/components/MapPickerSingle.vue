<template>
    <l-map style="height: 80%; width: 100%"
           :zoom=zoom
           :center=markerLatLng
           @update:center="centerUpdate"
           @update:zoom="zoomUpdate"
    >
        <l-tile-layer :url="url"></l-tile-layer>
        <v-geosearch :options="geosearchOptions" ></v-geosearch>
        <l-marker
                :lat-lng.sync="markerLatLng"
                :draggable="true"
                @update:latLng="handleInput"
        >
            <l-icon
                :iconUrl=markerIcon
                :iconRetinaUrl="markerIconRetina"
            </l-icon>
        </l-marker>
    </l-map>
</template>

<script>
    import { LMap, LTileLayer, LMarker, LIcon } from "vue2-leaflet";
    import { OpenStreetMapProvider } from 'leaflet-geosearch';

    export default {
        components: {
            LMap,
            LTileLayer,
            LMarker,
        },
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value : {
                type: Object,
                default: function () {
                    return { lat: -6.175374199999999, lng: 106.82578719999992 };
                }
            },
            center : {
                type: Object,
                default: function () {
                    return { lat: -6.175374199999999, lng: 106.82578719999992 };
                }
            },
            zoom : {
                type: Number,
                default: 12
            },
            markerIcon : {
                type: String
            },
            markerIconRetina : {
                type: String
            },
        },
        data () {
            return {
                url: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
            };
        },
        methods: {
            zoomUpdate(zoom) {
                this.currentZoom = zoom;
            },
            centerUpdate(center) {
                //this.markerLatLng = center;
                this.currentCenter = center;
            },
            handleInput (e) {
                console.log(this.markerLatLng);
                this.$emit('input', this.markerLatLng);
            },
        }
    }
</script>
