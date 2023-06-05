<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<requestno-selector
        v-model="{{ $form['model'] }}"
        :prno-options="{{ $form['model'].'Options' }}"
        :prno-text.sync="{{ $form['requestNoText'] }}"
        {{-- :company-name.sync="{{ $form['companyName']}}"
        :jobno.sync="{{ $form['jobNo']}}"
        :costcenter.sync="{{ $form['costCenter']}}"
        :currency.sync="{{ $form['currency']}}" --}}

        @if(isset($form['attr']))
            @foreach($form['attr'] as $att=>$v)
                {{ $att }}="{{ $v }}"
            @endforeach
        @endif
/>
