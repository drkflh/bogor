<div class="row">
    <div class="col-md-6">
    <label for="maritalStatus" class="mr-3">Marital Status</label>
    <b-form-select
        name="maritalStatus" 
        v-model="extraData.maritalStatus"
        :options="maritalStatusOptions"
    ></b-form-select>
    </div>
    <div class="col-md-6">
        <label for="citizenship" class="mr-3">Alamat</label>
             <b-form-select
                name="citizenship" 
                v-model="extraData.citizenship"
                :options="citizenshipOptions"
             ></b-form-select>
    </div>
    <div class="col-md-6">
        <label for="maritalStatus" class="mr-3">Tipe Investor</label>
        <b-form-select
            name="investorType" 
            v-model="extraData.investorType"
            :options="investorTypeOptions"
        ></b-form-select>
    </div>
    <div class="col-md-6">
        <label for="investmentPreference" class="mr-3">Preferensi Investasi</label>
        <b-form-select
            name="investmentPreference" 
            v-model="extraData.investmentPreference"
            :options="investmentPreferenceOptions"
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



