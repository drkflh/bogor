    @if(isset($form['position']) && $form['position'] == 'hidden')
        <label for="{{ $form['model'] }}" >{{ $label }}</label><br>
    @endif

    @if(v-model="discountSwitch" && position="left")
    <simple-switch
        label="{{ $label }}"
        v-model="discountSwitch"
        :model="discountSwitch"
        position="left"
        :checkedlabel="false"
    >
    </simple-switch>
    <simple-switch
        label="{{ $label }}"
        v-model="discountLumpSumSwitch"
        :model="discountLumpSumSwitch"
        position="right"
        :checkedlabel="true"
    >
    </simple-switch>
    @elseif (v-model=="discountLumpSumSwitch" && position=="left")
    <simple-switch
        label="{{ $label }}"
        v-model="discountSwitch"
        :model="discountSwitch"
        position="right"
        :checkedlabel="true"
    >
    </simple-switch>
    <simple-switch
        label="{{ $label }}"
        v-model="discountLumpSumSwitch"
        :model="discountLumpSumSwitch"
        position="left"
        :checkedlabel="false"
    >
    </simple-switch>
    @endif
