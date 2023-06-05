<div id="doc">
    <div class="row">
        <div class="col-1" style="text-overflow: ellipsis; ">
            <label for="ProductID" style="color:#000000;font-weight: bold;">Product ID</label>
            <input class="form-control" name="ProductID" type="text" v-model="value.ProductID" style="text-overflow: ellipsis;" />
        </div>
        <div style="width: 250px;" >
            <label for="Descriptions" style="color:#000000;font-weight: bold;">Descriptions</label>
            <input class="form-control" name="Descriptions" type="text" v-model="value.Descriptions" style="text-overflow: ellipsis;"/>
        </div>
        <div class="col-2">
            <label for="Notes" style="color:black;font-weight: bold;">Notes</label>
            <input class="form-control" name="Notes" type="text" v-model="value.Notes" />
        </div>
        <div style="width: 50px; margin-right: 10px;">
            <label for="Delivery" style="color:black;font-weight: bold;">Delivery</label>
            <input class="form-control" name="Delivery" type="number" v-model="value.Delivery" />
        </div>
        <div style="width: 90px;margin-right: 10px;">
            <label for="Period" style="color:black;font-weight: bold;">Period</label>
            <b-form-select name="Period" type="text" v-model="value.Period">
                <b-form-select-option value="Days">Days</b-form-select-option>
                <b-form-select-option value="Weeks">Weeks</b-form-select-option>
                <b-form-select-option value="Months">Months</b-form-select-option>
             </b-form-select>
        </div>
        <div style="width: 50px;margin-right: 10px;">
            <label for="QTY" style="color:#000000;font-weight: bold;">Quantity</label>
            <input class="form-control" name="QTY" type="number" v-model="value.QTY" style="text-align: right;"/>
        </div>
        <div style="width: 90px;">
            <label for="UOM" style="color:#000000;font-weight: bold;">UoM</label>
            <b-form-select v-model="value.uom" :options="params.uom"></b-form-select>
        </div>
        <div style="width: 150px;margin-left: 10px;">
            <label for="UnitPrice" style="color:#000000;font-weight: bold;">Unit Price</label>
                <currency-input class="form-control"
                    v-model="value.UnitPrice"
                    :currency="null"
                />
        </div>
        <div style="width: 150px;margin-left: 10px;"">
            <label for="AmountOrdered" style="color:#000000;font-weight: bold;">Amount Ordered</label>
            <input class="form-control"  name="AmountOrdered" type="number" v-model="value.UnitPrice * value.QTY" />
        </div>
    </div>
</div>
