
<div class="row p-4" style="margin-top: -20px;">
    <div class="col-md-5">
        <label for="companyId" class="mr-3">Company ID</label>
        <input class="form-control" 
            name="companyId" 
            type="text" 
            v-model="extraData.companyId"></input>
        </div>
    <div class="col-md-7">
    <label for="typeproduct" class="mr-3">Jenis Produk</label>
    <input class="form-control" 
        name="typeproduct" 
        type="text" 
        v-model="extraData.typeproduct"></input>
    </div>
</div>
<div class="row p-4" >
    <div class="col-md-12">
        <label for="productName" class="mr-3">Nama Produk</label>
        <input class="form-control" 
            name="productName" 
            type="text" 
            v-model="extraData.productName"></input>
    </div>
</div>

{{-- <hr>
<div class="row justify-content-end">
    <div class="d-flex justify-content-end col-6">
        <button class="btn btn-primary-muted" @click="loadTableData()" >
            <i class="fas fa-search"></i> Search
        </button>
    </div>
</div>
 --}}
