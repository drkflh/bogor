<div class="row">
    <div class="col-12">
        <label for="customerFilter" class="ml-3 mr-3">Customer</label>
        <input type="text"
               v-model="extraData.customerName"
               class="form-control" name="customerFilter" ></input>
    </div>
</div>
<br>
<div class="row">
    <div class="col-12">
        <label for="productFilter" class="ml-3 mr-3">Products</label>
        <tags-input
            v-model="extraData.products"
        ></tags-input>
    </div>
</div>
<br>
<div class="row">
    <div class="col-12">
        <label for="brandFilter" class="ml-3 mr-3">Brands</label>
        <tags-input
            v-model="extraData.brands"
        ></tags-input>
    </div>
</div>
<br>
<div class="row">
    <div class="col-12">
        <label for="serviceFilter" class="ml-3 mr-3">Services</label>
        <tags-input
            v-model="extraData.services"
        ></tags-input>
    </div>
</div>
<br>
<div class="row">
    <div class="col-6">

    </div>
    <div class="col-6 text-right">
        <button class="btn btn-primary-muted mt-4" @click="loadTableData()" >
            <i class="fas fa-search"></i> Search
        </button>
    </div>
</div>

