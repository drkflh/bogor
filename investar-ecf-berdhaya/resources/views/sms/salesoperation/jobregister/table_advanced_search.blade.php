<div class="row">
    <div class="col-6">
        <label for="jobNoFilter" class="mr-3">Job No</label>
        <input type="text"
               v-model="extraData.jobNo"
               class="form-control" name="jobNoFilter" >
        </input>
    </div>
    <div class="col-6">
        <label for="statusFilter" class="mr-3">Inquiry Status</label>
        <b-form-select
            name="statusFilter"
            v-model="extraData.status"
            :options="statusFilterOptions"
        ></b-form-select>
    </div>
</div>
<div class="row">
    <div class="col-4">
        <label for="bidStatusFilter" class="mr-3">Bid Status</label>
        <b-form-select
            name="bidStatusOpFilter"
            v-model="extraData.bidStatusOp"
            :options="operatorOptions"
        ></b-form-select>
    </div>
    <div class="col-6">
        <label for="bidStatusOpFilter" class="mr-3"></label>
        <b-form-select
            name="bidStatusFilter"
            v-model="extraData.bidStatus"
            :options="bidStatusOptions"
        ></b-form-select>
    </div>
</div>
<div class="row">
    <div class="col-4">
        <label for="jobStatusFilter" class="mr-3">Job Status</label>
        <b-form-select
            name="jobStatusOpFilter"
            v-model="extraData.jobStatusOp"
            :options="operatorOptions"
        ></b-form-select>
    </div>
    <div class="col-6">
        <label for="jobStatusFilter" class="mr-3"></label>
        <b-form-select
            name="jobStatusFilter"
            v-model="extraData.jobStatus"
            :options="jobStatusOptions"
        ></b-form-select>
    </div>
</div>
<br>
<div class="row">
    <div class="col-6">
        <label for="companyFilter" class="mr-3">Company</label>
        <b-form-select
            name="companyFilter"
            v-model="extraData.participatingCompany"
            :options="participatingCompanyFilterOptions"
        ></b-form-select>
    </div>
    <div class="col-6">
        <label for="projectFilter" class="mr-3">Area</label>
        <b-form-select
            name="areaFilter"
            v-model="extraData.area"
            :options="areaFilterOptions"
        ></b-form-select>
    </div>
</div>
<br>
<div class="row">
    <div class="col-6">
        <label for="companyFilter" class="mr-3">Buying Company</label>
        <input
            type="text"
            name="buyingCompanyFilter"
            v-model="extraData.company"
            class="form-control"
        ></input>
    </div>
    <div class="col-6">
        <label for="projectOwnerFilter" class="mr-3">End User</label>
        <input
            type="text"
            name="projectOwnerFilter"
            v-model="extraData.projectOwner"
            class="form-control"
        ></input>
    </div>
    <div class="col-12">
        <label for="projectFilter" class="mr-3">Project Description</label>
        <input
            type="text"
            name="projectFilter"
            v-model="extraData.project"
            class="form-control"
        ></input>
    </div>
    <div class="col-6">
        <label for="scopeFilter" class="mr-3">Scope</label>
        <input
            type="text"
            name="scopeFilter"
            v-model="extraData.scope"
            class="form-control"
        ></input>
    </div>
    <div class="col-6">
        <label for="brandFilter" class="mr-3">Brand</label>
        <input
            type="text"
            name="brandFilter"
            v-model="extraData.brand"
            class="form-control"
        ></input>
    </div>
</div>
<br>
<div class="row">
    <div class="col-4">
        <label for="yearFilter" class="mr-3">Year</label>
        <b-form-select
            name="yearFilter"
            v-model="extraData.bidYear"
            :options="bidYearOptions"
        ></b-form-select>
    </div>
    <div class="col-1" style="width: 45px;padding-top:36px;">
        To
    </div>
    <div class="col-4">
        <label for="yearFilter" class="mr-3">Year</label>
        <b-form-select
            name="yearFilter"
            v-model="extraData.bidYearUntil"
            :options="bidYearOptions"
        ></b-form-select>
    </div>
</div>

