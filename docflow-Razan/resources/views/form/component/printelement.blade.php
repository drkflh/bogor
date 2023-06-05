<print-element
    :content="{{ $form['model'] }}"
    :template="{{ $form['template'] }}"
    :options="{ styles: [ '{{ url('css/print.css')  }}' ] }"

></print-element>
