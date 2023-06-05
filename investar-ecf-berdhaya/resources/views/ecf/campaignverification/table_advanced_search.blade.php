

<div class="row p-4" style="margin-top: -20px;">
    <div class="col-md-6">
    <label for="bizRegisteredName" class="mr-3">Nama Badan Usaha</label>
    <input class="form-control" 
        name="bizRegisteredName" 
        type="text" 
        v-model="extraData.bizRegisteredName"></input>
    </div>
    <div class="col-md-6">
    <label for="bizType" class="mr-3" style="margin-bottom: 5px;">Jenis Usaha</label>
    <b-form-select
            name="bizType"
            v-model="extraData.bizType"
            :options="bizTypeOptions"
        ></b-form-select>
    </div>
</div>

<div class="row p-4">
    <div class="col-md-6">
        <label for="bizTradeMark" class="mr-3">Merek Bisnis</label>
        <input class="form-control" 
            name="bizTradeMark" 
            type="text" 
            v-model="extraData.bizTradeMark"></input>
    </div>
    <div class="col-md-6">
        <label for="productServices" class="mr-3">Produk / Jasa</label>
        <input class="form-control" 
            name="productServices" 
            type="text" 
            v-model="extraData.productServices"></input>
    </div>
</div>

<div class="row p-4">
    <div class="col-md-12">
        <label for="marketingFunnels" class="mr-3" style="margin-bottom: 5px;">Jalur Pemasaran</label>
        <b-form-select
                name="marketingFunnels"
                v-model="extraData.marketingFunnels"
                :options="marketingFunnelsOptions"
            ></b-form-select>
        </div>
</div>


{{-- <hr>
<div class="row justify-content-end">
    <div class="d-flex justify-content-end col-6">
        <button class="btn btn-primary-muted" @click="loadTableData()" >
            <i class="fas fa-search"></i> Search
        </button>
    </div>
</div> --}}

