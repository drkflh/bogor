<div class="row">
    <div class="col-12">
        <label for="companyFilter" class="ml-3 mr-3">Company</label>
        <input type="text"
               v-model="extraData.coyName"
               class="form-control" name="companyFilter" ></input>
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
    <div class="col-md-6 col-xs-12">

    </div>
    <div class="col-md-6 col-xs-12 text-right">
        <button class="btn btn-primary-muted mt-4" @click="loadTableData()" >
            <i class="fas fa-search"></i> Search
        </button>
    </div>
</div>

