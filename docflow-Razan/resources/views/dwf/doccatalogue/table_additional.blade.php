<label for="dateRange" class="mr-2" >Tanggal</label>
<div style="display:inline-block;float:right;">
    <a-range-picker
        v-model="extraData.dateRange"
        format="DD MMM YYYY"
        value-format="YYYY-MM-DD"
        type="date"
        value-type="date"
        range
        :placeholder="['From', 'Until']">
    </a-range-picker>
</div>
