<template>
    <div style="display: block;width: 100%; height: 100%;">

        <l-map style="height: 80%; width: 100%;"
               :zoom=zoom
               :center=center
               @update:center="centerUpdate"
               @update:zoom="zoomUpdate"
               @click="mapClick"
               ref="mainMap"
        >
            <l-tile-layer :url="url"></l-tile-layer>

            <l-control position="topright" >
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <button v-show="showAllButtons" class="btn btn-primary" @click="getCurrentLocation" style="margin-right: 10px" ><i class="las la-map-marker"></i></i></button>
                        <button v-show="showAllButtons" class="btn btn-primary" @click="sortDistance" style="margin-right: 10px" ><i class="las la-sort-amount-up"></i></button>
                        <button v-show="showAllButtons" class="btn btn-primary" @click="toggleCenter" style="margin-right: 10px" ><i class="las la-crosshairs"></i></button>
                        <button v-show="showAllButtons" class="btn btn-primary" @click="toggleClosedPoly" style="margin-right: 10px" ><i class="las la-draw-polygon"></i></button>
                        <button v-show="showAllButtons" class="btn btn-primary" @click="toggleAdd" ><i v-bind:class="modeIcon"></i> Mode : {{ mode }} </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <span class="pull-right">
                            {{ helpMessage }}
                        </span>
                    </div>
                </div>
            </l-control>

            <l-circle-marker
                    v-if="showCenter"
                    :key="centerCircle._id"
                    :lat-lng="centerCircle.center"
                    :radius="centerCircle.radius"
                    :color="centerCircle.color"
            />
            <l-polygon
                    v-if="closedPoly"
                    :lat-lngs="polyCoords"
                    :color="polyColor">
            </l-polygon>
            <l-polyline
                    v-if="!closedPoly"
                    :lat-lngs="polyCoords"
                    :color="polyColor">
            </l-polyline>
            <l-marker v-for="marker in value"
                      :key="marker._id"
                      :lat-lng.sync="marker.center"
                      :icon="icon"
                      :draggable="marker.draggable"
                      @update:latLng="updateCoord"
                      @ready="dropMarker"
            >
                <l-popup :content="marker.name" />
            </l-marker>
        </l-map>
    </div>
</template>

<script>
    import { LMap, LTileLayer, LMarker, LCircleMarker, LIcon, LControl } from "vue2-leaflet";
    export default {
        name: "MapDisplay",
        components: {
            LMap,
            LTileLayer,
            LMarker,
            LIcon
        },
        props: {
            value : {
                type: [Object, Array],
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
            closePolygon: {
                type: Boolean,
                default: function(){ return true }
            },
            markerIcon : {
                type: String
            },
            markerIconRetina : {
                type: String
            },
            showAllButtons : {
                type: Boolean,
                default: function(){ return true }
            }
        },
        watch: {
            closePolygon: function(val){
                this.closedPoly = val;
            },
            center: function (val){
                this.$refs.mainMap.mapObject.panTo(val);
            }
        },
        data () {
            return {
                mode: 'Display',
                showCenter: true,
                closedPoly: true,
                helpMessage: '',
                icon: L.icon({
                    iconUrl: this.markerIcon,
                    iconSize: [26, 40],
                    iconAnchor: [13, 40],
                    popupAnchor: [0,-40]
                }),
                centerMarker : {
                    _id : 'centerMarker',
                    center:{ lat: -6.175374199999999, lng: 106.82578759999992 },
                    icon: 10,
                    color: 'red'
                },
                centerCircle : {
                    _id : 'centerCircleMark',
                    center:{ lat: -6.175374199999999, lng: 106.82578759999992 },
                    radius: 10,
                    color: 'red'
                },
                circles: [],
                markers: [],
                defId: 10,
                currentCenter: { lat: -6.175374199999999, lng: 106.82578719999992 },
                url: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
                polyColor: 'yellow'
            };
        },
        computed:{
            polyCoords: function(){
                var coords = [];
                _.forEach( this.value , val=>{
                    coords.push( val.center );
                } );
                return coords;
            },
            modeIcon: function () {
                if(this.mode == 'Add'){
                    this.helpMessage = 'Click map to add new place, drag to move marker';
                    return 'las la-plus-circle';
                }else{
                    this.helpMessage = 'Drag to move marker';
                    return 'las la-eye';
                }
            },
        },
        methods: {
            toggleClosedPoly(){
                this.closedPoly = !this.closedPoly;
            },
            toggleCenter(){
                this.showCenter = !this.showCenter;
            },
            toggleAdd(){
                if(this.mode == 'Add'){
                    this.mode = 'Display';
                }else{
                    this.mode = 'Add';
                }
            },
            zoomUpdate(zoom) {
                this.centerCircle.center = [ this.currentCenter.lat, this.currentCenter.lng ];
                console.log(this.currentZoom);
            },
            panMapTo(center){
                this.$refs.myMap.mapObject.panTo(center);
            },
            centerUpdate(center) {
                this.currentCenter = center;
                this.centerCircle.center = [ this.currentCenter.lat, this.currentCenter.lng ];
                console.log(this.currentCenter);
            },
            updateCoord(data){
                console.log(this);
                console.log(data);
                var newList = this.value;
                this.$emit('input', newList);
            },
            dropMarker(){
                var newList = this.value;
                this.$emit('input', newList);
            },
            mapClick(data){
                this.defId++;

                if(this.mode == 'Add'){

                    var newList = this.value;

                    newList.push(
                        {
                            _id: this.defId + 5000,
                            center: data.latlng,
                            lat : _.get(data.latlng, 'lat'),
                            lng : _.get(data.latlng, 'lng'),
                            radius: 6,
                            color: 'green',
                            draggable: true,
                            name: 'New Marker ' + ( this.defId + 500 )
                        }
                    );

                    this.$emit('input', newList).preventDefault();

                }
            },
            sortDistance(){
                var opts = {
                    yName: 'center.lat',
                    xName: 'center.lng'
                };
                var origin = _.head(this.value);
                if( origin === undefined ){

                }else{
                    var points = this.value;
                    var sortedList = sortByDistance(origin, points, opts);

                    this.$emit('input', sortedList).preventDefault();
                }
            },
            getCurrentLocation(){
                this.$getLocation({
                    enableHighAccuracy: true, //defaults to false
                    timeout: Infinity, //defaults to Infinity
                    maximumAge: 0 //defaults to 0

                })
                .then(coordinates => {
                    console.log(coordinates);
                });
            }

        }
    }
</script>

<style scoped>

</style>
