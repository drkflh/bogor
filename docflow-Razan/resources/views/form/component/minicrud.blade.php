<crud-component
        :data="mcData"
        :fields="mcFields"
        entity-plural="{{ \Illuminate\Support\Str::plural($label) }}"
        entity-singular="{{ $label }}"
        :http-headers="mcHeader"
        :allow-filter="false"
>
</crud-component>
