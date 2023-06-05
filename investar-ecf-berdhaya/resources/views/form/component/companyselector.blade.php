<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<company-selector
        v-model="{{ $form['model'] }}"
        :company-options="{{ $form['model'].'Options' }}"
        :company-text.sync="{{ $form['companyText'] }}"
        :company-code.sync="{{ $form['companyCode'] }}"
        :company-phone.sync="{{ $form['companyPhone'] }}"
        :company-phone2.sync="{{ $form['companyPhone2'] }}"
        :company-fax.sync="{{ $form['companyFax'] }}"
        :company-address.sync="{{ $form['companyAddress']}}"
        :company-address1.sync="{{ $form['companyAddress1']}}"
        :company-address2.sync="{{ $form['companyAddress2']}}"
        :company-logo.sync="{{ $form['companyLogo']}}"

        @if(isset($form['attr']))
            @foreach($form['attr'] as $att=>$v)
                {{ $att }}="{{ $v }}"
            @endforeach
        @endif
/>
<br>
