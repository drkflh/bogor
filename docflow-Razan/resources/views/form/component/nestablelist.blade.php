<label for="{{ $form['model'] }}" >{{ $label }}</label>
<div class="list-container"
style="overflow: auto;
    height: 500px;
    max-height: 500px;"
>
    <vue-nestable v-model="{{ $form['model'] }}">
        <vue-nestable-handle
            slot-scope="{ item }"
            :item="item">
            <div class="nestable-item">
                <h6 v-html="item.text"></h6>
                <p v-html="item.description" ></p>
            </div>
        </vue-nestable-handle>
    </vue-nestable>
</div>
