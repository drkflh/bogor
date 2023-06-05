@if($label != '')
    <label for="{{ $form['model'] }}" >{{ __( $label ) }}</label><br>
@endif
<vendor-selector
        v-model="{{ $form['model'] }}"
        :vendor-options="{{ $form['model'].'Options' }}"
        :vendor-text.sync="{{ $form['vendorText'] }}"
        :vendor-name.sync="{{ $form['vendorName'] }}"
        :vendor-address.sync="{{ $form['vendorAddress']}}"
        :vendor-phone.sync="{{ $form['vendorPhone']}}"
        :vendor-pic.sync="{{ $form['vendorPic']}}"
        :vendor-email.sync="{{ $form['vendorEmail']}}"
        :vendor-address2.sync="{{ $form['vendorAddress2']}}"
        :vendor-city.sync="{{ $form['vendorCity']}}"
        :vendor-country.sync="{{ $form['vendorCountry']}}"
        :vendor-province.sync="{{ $form['vendorProvince']}}"
        :vendor-postal.sync="{{ $form['vendorPostal']}}"

        @if(isset($form['attr']))
            @foreach($form['attr'] as $att=>$v)
                {{ $att }}="{{ $v }}"
            @endforeach
        @endif
/>
