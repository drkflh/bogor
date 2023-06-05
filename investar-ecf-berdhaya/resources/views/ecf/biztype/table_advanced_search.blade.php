{{-- 
<div class="row">
    <div class="col-md-6">
        <label for="typeOfFunding" class="mr-3">Jenis Pendanaan</label>
        <input class="form-control" name="typeOfFunding" type="text" v-model="extraData.typeOfFunding" />
    </div>
</div>


<hr>
<div class="row justify-content-end">
    <div class="d-flex justify-content-end col-6">
        <button class="btn btn-primary-muted" @click="loadTableData()">
            <i class="fas fa-search"></i> Search
        </button>
    </div>
</div> --}}

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <label for="name" class="mr-3">Nama Lengkap</label>
            <input class="form-control" name="name" type="text" v-model="extraData.name" />
        </div>
    </div>
</div>


<hr>
<div class="row justify-content-end">
    <div class="d-flex justify-content-end col-6">
        <button class="btn btn-primary-muted" @click="loadTableData()">
            <i class="fas fa-search"></i> Search
        </button>
    </div>
</div>

