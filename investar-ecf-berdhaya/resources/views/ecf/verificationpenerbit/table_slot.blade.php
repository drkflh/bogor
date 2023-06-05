<template v-else-if="props.column.field == 'approvalStatus'">
    <button class="btn btn-icon btn-primary" v-if="( props.row.needReview || props.row.needSigning )"
        @click="changeSingleApprovalStatus(props.row)">
        <i class="las la-signature"></i>
    </button>
</template>

<template v-else-if="props.column.field == 'name'">
    <span v-if="props.row.nameVerified != true "></span> @{{ props.row.name ?? '-' }}
    <hr>
    @{{ props.row.email ?? '' }}
</template>

<template v-else-if="props.column.field == 'bizRegisteredName'">
    <span v-if="props.row.bizRegisteredNameVerified != true "></span> @{{ props.row.bizRegisteredName ?? '-' }}
    <hr>
    @{{ props.row.typeOfFunding ?? '' }}
</template>

<template v-else-if="props.column.field == 'bizCompanyType'">
    <span v-if="props.row.bizCompanyTypeVerified != true "></span> @{{ props.row.bizCompanyType ?? '-' }}
    <hr>
    @{{ props.row.bizType ?? '' }}
</template>
