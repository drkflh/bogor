<div style="height: 100%; width: 100%; min-height: 500px ">
    <div class="info" style="height: 15%">
        <span>Center: @{{ mapCenter }}</span>
        <span>Zoom: @{{ mapZoom }}</span>
        <span>Bounds: @{{ mapBounds }}</span>
    </div>
    <l-map
            style="height: 80%; width: 100%"
            :zoom="mapZoom"
            :center="mapCenter"
            @update:zoom="zoomUpdated"
            @update:center="centerUpdated"
            @update:bounds="boundsUpdated"
    >
        <l-tile-layer :url="mapUrl"></l-tile-layer>
    </l-map>
</div>
