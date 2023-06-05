<label for="{{ $form['model'] }}" >{{ $label }}</label>
<div class="row">
    <div class="col-6">
        <place-autocomplete-field
                v-model="{{ $form['model'] }}"
                placeholder="Enter an an address, zipcode, or location"
                label="Address"
                name="{{ $form['model'] }}"
                :api-key="gmapApi"
        >
        </place-autocomplete-field>
    </div>
</div>
