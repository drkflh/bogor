<template v-else-if="props.column.field == 'assignedTo'">
    <b>Developer :</b><br>
    <span v-for="p in props.row.assignedTo" v-html="p.text" class="badge badge-pill badge-primary p-2 mr-2 mt-1" ></span>
    <br><br>
    <b>QA :</b><br>
    <span v-for="p in props.row.reviewer" v-html="p.text" class="badge badge-pill badge-primary p-2 mr-2 my-1" ></span>
</template>
<template v-else-if="props.column.field == 'approvalStatus'">
    <span v-if=" !_.isUndefined(props.row.approvalStatus) && props.row.approvalStatus != ''" v-html="capitalize(props.row.approvalStatus) + (props.row.approvalStatus != 'PENDING' && !_.isEmpty(props.row.approvalBy) ? ' by ' + props.row.approvalBy : '' )" class="badge badge-pill p-2 mr-2 mt-1" :class="props.row.approvalStatus == 'PENDING' ? 'badge-danger' : 'badge-warning' " ></span>
</template>
<template v-else-if="props.column.field == 'startDateTime'">
    @{{formatDate(props.row.startDateTime)}} - @{{formatDate(props.row.endDateTime)}}
    <p class="text-center">@{{props.row.duration}} hours</p>
</template>
<template v-else-if="props.column.field == 'taskName'">
    <b style="font-weight: 400; font-size: 10pt;">@{{ props.row.taskName }}</b><br>
    <vue-markdown>@{{props.row.taskDescription}}</vue-markdown>

    <div class="row mt-3 mb-1">
        <div class="col-md-6">
            <span v-if=" !_.isUndefined(props.row.progressStatus) && props.row.progressStatus != ''" v-html="capitalize(props.row.progressStatus)" class="badge badge-pill p-2 mt-1" :class="props.row.approvalStatus == 'PENDING' ? 'badge-danger' : 'badge-warning' " ></span>
            <i class="las la-pen" style="cursor: pointer;" @click="showChangeStat(props.row._id)"></i>
        </div>
        <div class="col-md-6">
            <span class="btn btn-success p-2 mt-1" style="font-size: 10px">@{{sumColumn(props.row.issues) ?? '0'}} Open Issues</span>
            <i class="las la-pen" style="cursor: pointer;"></i>
        </div>
    </div>
    <span v-html="props.row.taskType" class="badge badge-pill badge-info p-2 mr-2 my-2" ></span>
</template>
<template v-else-if="props.column.field == 'taskGuide'">
    <span class="btn btn-outline-secondary btn-sm" v-b-toggle="props.row._id">toggle guide</span>
    <br>
    <b-collapse :id="props.row._id" class="mt-2">
        <vue-markdown>@{{props.row.taskGuide}}</vue-markdown>
    </b-collapse>
</template>
