<label for="{{ $form['model'] }}" >{{ $label }}</label>
<div>
    <fish-tag  v-for="opt in {{ $form['model'] }}" :key="{{ $form['model'] }}" size="medium" >
        @{{ opt }}
    </fish-tag>
</div>
