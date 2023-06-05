<div id="bodyparam">
    <div class="row">
        <div class="col-2" style="text-overflow: ellipsis; ">
            <label for="paramKey" >Key</label>
            <input class="form-control" name="ProductID" type="text" v-model="value.paramKey" style="text-overflow: ellipsis;" />
        </div>
        <div class="col-6">
            <label for="paramText" >Text</label>
            <input class="form-control" name="Notes" type="text" v-model="value.paramText" />
        </div>
        <div class="col-4">
            <label for="paramField" >Value Field</label>
            <input class="form-control" name="QTY" type="text" v-model="value.paramField" />
        </div>
    </div>
</div>
