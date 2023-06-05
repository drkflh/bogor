<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<div class="row">
    <div class="col-6">
        <label for="lat">Latitude</label>
        <input type="text" v-model="{{ $form['model'] }}" class="form-control" />
    </div>
    <div class="col-6">
        <label for="lon">Longitude</label>
        <input type="text" v-model="{{ $form['model'] }}" class="form-control" />
    </div>
</div>
<div class="row">
    <div class="col-12" style="height: 500px; width: 100%; min-height: 500px; padding-top: 0.8em;">
        <map-picker-single
                :zoom="mapZoom"
                :marker-icon="markerIcon"
                :marker-icon-retina="markerIconRetina"
                v-model="{{ $form['model'] }}"
        >
        </map-picker-single>
    </div>
</div>
