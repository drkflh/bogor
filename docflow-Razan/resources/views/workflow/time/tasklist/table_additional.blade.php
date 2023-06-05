<div class="form-inline">
    <label for="projectFilter" class="mr-3">Project</label>
    <b-form-select
        name="projectFilter"
        v-model="extraData.projectFilter"
        :options="projectCodeOptions"
    ></b-form-select>
    <label for="projectFilter" class="ml-3 mr-3">Status</label>
    <b-form-select
        name="projectFilter"
        v-model="extraData.projectStatusFilter"
        :options="progressStatusFilterOptions"
    ></b-form-select>
</div>
