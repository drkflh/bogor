<label>Date of Birth between</label>
<div class="row">
    <div class="col-6">
        <a-date-picker
            v-model="extraData.dobFrom"
            value-type="YYYY-MM-DD HH:mm:ss"
            placeholder="{{ env('DATE_FORMAT', 'DD-MMM-YYYY' ) }}"
            value-format="YYYY-MM-DD"
            format="{{ env('DATE_FORMAT', 'DD-MMM-YYYY' ) }}"
        >
        </a-date-picker>

    </div>
    <div class="col-6">
        <a-date-picker
            v-model="extraData.dobUntil"
            value-type="YYYY-MM-DD HH:mm:ss"
            placeholder="{{ env('DATE_FORMAT', 'DD-MMM-YYYY' ) }}"
            value-format="YYYY-MM-DD"
            format="{{ env('DATE_FORMAT', 'DD-MMM-YYYY' ) }}"
        >
        </a-date-picker>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label for="roleId" class="mr-3">Role</label>
        <b-form-select
            name="roleName"
            v-model="extraData.roleName"
            :options="roleIdOptions"
        ></b-form-select>
    </div>
    <div class="col-md-6">
    <label for="statu" class="mr-3">Employment Status</label>
        <b-form-select
            name="statusEmployee"
            v-model="extraData.statusEmployee"
            :options="statusEmployeeOptions"
        ></b-form-select>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
    <label for="companyName" class="mr-3">Company</label>
        <b-form-select
            name="companyName"
            v-model="extraData.companyName"
            :options="companyNameOptions"
        ></b-form-select>
    </div>
</div>


{{-- <hr> --}}
{{-- <div class="row justify-content-end">
    <div class="d-flex justify-content-end col-6">
        <button class="btn btn-primary-muted" @click="loadTableData()" >
            <i class="fas fa-search"></i> Search
        </button>
    </div>
</div> --}}

