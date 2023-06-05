<div class="row">
    <div class="col-12">
        <label for="dateFilter" class="mr-3">From / To</label>
        <a-range-picker
            name="dateFilter"
            v-model="extraData.dateFilter"
            style="width: 250px;"
        >
        </a-range-picker>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <label for="userFilterOptions" class="mr-3">User</label>
        <b-form-select
            name="userFilter"
            v-model="extraData.userFilter"
            :options="userFilterOptions"
        ></b-form-select>
    </div>
    <div class="col-6">
        <label for="eventFilter" class="mr-3">Event</label>
        <b-form-select
            name="eventFilter"
            v-model="extraData.eventFilter"
            :options="eventFilterOptions"
        ></b-form-select>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <label for="projectFilter">Project / Task</label>
        <b-form-select
            name="projectFilter"
            v-model="extraData.projectFilter"
            :options="projectFilterOptions"
        ></b-form-select>
    </div>
    <div class="col-6">
        <label for="clientFilter" >Client</label>
        <b-form-select
            name="clientFilter"
            v-model="extraData.clientFilter"
            :options="clientFilterOptions"
        ></b-form-select>
    </div>
</div>

