<div class="row">
    <div class="col-md-6">
    <label for="bizRegisteredName" class="mr-3">Nama Badan Usaha sesuai Akta Perusahaan</label>
    <input class="form-control" name="bizRegisteredName" type="text" v-model="extraData.bizRegisteredName" />
    </div>
</div>
<div class="row">
    <div class="col-md-12">
    <label for="bizType" class="mr-3">Jenis Usaha</label>
        <b-form-select
            name="bizType"
            v-model="extraData.bizType"
            :options="bizTypeOptions"
        ></b-form-select>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
    <label for="bizCompanyType" class="mr-3">Bentuk Badan Usaha</label>
        <b-form-select
            name="bizCompanyType"
            v-model="extraData.bizCompanyType"
            :options="bizCompanyTypeOptions"
        ></b-form-select>
    </div>
</div>


<hr>
<div class="row justify-content-end">
    <div class="d-flex justify-content-end col-6">
        <button class="btn btn-primary-muted" @click="loadTableData()" >
            <i class="fas fa-search"></i> Search
        </button>
    </div>
</div>

