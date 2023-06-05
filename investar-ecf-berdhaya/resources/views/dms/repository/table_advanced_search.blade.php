<div class="row">
    <div class="col-5">
        <label for="jobNoFilter" class="mr-3">Company</label>
        <b-form-select
            name="FunctionFilter"
            v-model="extraData.Coy"
            :options="CoyOptions"
        ></b-form-select>
    </div>
    <div class="col-2">
        <label for="statusFilter" class="mr-3">Function</label>
        <b-form-select
            name="FunctionFilter"
            v-model="extraData.Function"
            :options="dmsFunctionOptions"
        ></b-form-select>
    </div>
    <div class="col-5">
        <label for="statusFilter" class="mr-3">Topic</label>
        <b-form-select
            name="topicFilter"
            v-model="extraData.Topic"
            :options="TopicObjectOptions"
        ></b-form-select>
    </div>
</div>
<div class="row">
    <div class="col-4">
        <label for="bidStatusFilter" class="mr-3">Feature</label>
        <input
            type="text"
            name="buyingCompanyFilter"
            v-model="extraData.Feature"
            class="form-control"
        ></input>
    </div>
    <div class="col-4">
        <label for="bidStatusOpFilter" class="mr-3">Status</label>
        <b-form-select
            name="StatusFilter"
            v-model="extraData.Status"
            :options="StatusOptions"
        ></b-form-select>
    </div>
    <div class="col-2">
        <label for="bidStatusOpFilter" class="mr-3">Linked</label>
        <b-form-select
            name="HasLinkFilter"
            v-model="extraData.HasLink"
            :options="booleanOptions"
        ></b-form-select>
    </div>
    <div class="col-2">
        <label for="bidStatusOpFilter" class="mr-3">Expiry</label>
        <b-form-select
            name="HasExpiryFilter"
            v-model="extraData.HasExpiry"
            :options="booleanOptions"
        ></b-form-select>
    </div>
</div>
<div class="row">
    <div class="col-3">
        <label for="jobStatusFilter" class="mr-3">Retain Date</label>
        <b-form-select
            name="RetCriteriaFilter"
            v-model="extraData.RetCriteria"
            :options="timeCriteriaOptions"
        ></b-form-select>
    </div>
    <div class="col-4">
        <label for="RetDateFilter" class="mr-3">&nbsp;</label>
        <a-date-picker
            v-model="extraData.RetDate"
            value-type="YYYY-MM-DD HH:mm:ss"
            placeholder="{{ env('DATE_FORMAT', 'DD-MMM-YYYY' ) }}"
            value-format="YYYY-MM-DD"
            format="{{ env('DATE_FORMAT', 'DD-MMM-YYYY' ) }}"
        >
        </a-date-picker>
    </div>
    <div class="col-5">
        <label for="RetPerFilter" class="mr-3">Retain Period</label>
        <b-form-select
            name="RetPerFilter"
            v-model="extraData.RetPer"
            :options="RetPerOptions"
        ></b-form-select>
    </div>
</div>
<div class="row">
    <div class="col-3">
        <label for="jobStatusFilter" class="mr-3">Disposal Date</label>
        <b-form-select
            name="DispCriteriaFilter"
            v-model="extraData.DispCriteria"
            :options="timeCriteriaOptions"
        ></b-form-select>
    </div>
    <div class="col-4">
        <label for="DispDateFilter" class="mr-3">&nbsp;</label>
        <a-date-picker
            v-model="extraData.DispDate"
            value-type="YYYY-MM-DD HH:mm:ss"
            placeholder="{{ env('DATE_FORMAT', 'DD-MMM-YYYY' ) }}"
            value-format="YYYY-MM-DD"
            format="{{ env('DATE_FORMAT', 'DD-MMM-YYYY' ) }}"
        >
        </a-date-picker>
    </div>
    <div class="col-5">
        <label for="DispPerFilter" class="mr-3">Disposal Period</label>
        <b-form-select
            name="DispPerFilter"
            v-model="extraData.DispPer"
            :options="DispPerOptions"
        ></b-form-select>
    </div>
</div>
<div class="row">
    <div class="col-4">
        <label for="LocationFilter" class="mr-3">Location</label>
        <input
            type="text"
            name="LocationFilter"
            v-model="extraData.Location"
            class="form-control"
        ></input>
    </div>
    <div class="col-4">
        <label for="StoreFilter" class="mr-3">Store</label>
        <input
            type="text"
            name="StoreFilter"
            v-model="extraData.Store"
            class="form-control"
        ></input>
    </div>
    <div class="col-4">
        <label for="OriginFormatFilter" class="mr-3">Original Format</label>
        <b-form-select
            name="OriginFormatFilter"
            v-model="extraData.OriginFormat"
            :options="OriginFormatOptions"
        ></b-form-select>
    </div>
</div>
<br>

<div class="row">
    <div class="col-4">
        <label for="DocRefFilter" class="mr-3">Doc Ref</label>
        <input
            type="text"
            name="DocRefFilter"
            v-model="extraData.DocRef"
            class="form-control"
        ></input>
    </div>
    <div class="col-8">
        <label for="projectOwnerFilter" class="mr-3">Subject</label>
        <input
            type="text"
            name="projectOwnerFilter"
            v-model="extraData.Subject"
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
            v-model="extraData.docYear"
            :options="docYearOptions"
        ></b-form-select>
    </div>
    <div class="col-1" style="width: 45px;padding-top:36px;">
        To
    </div>
    <div class="col-4">
        <label for="yearFilter" class="mr-3">Year</label>
        <b-form-select
            name="yearFilter"
            v-model="extraData.docYearUntil"
            :options="docYearOptions"
        ></b-form-select>
    </div>
</div>

