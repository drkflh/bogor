<template v-else-if="props.column.field == 'approvalStatus'">
    <button class="btn btn-icon btn-primary" v-if="( props.row.needReview || props.row.needSigning )"
        @click="changeSingleApprovalStatus(props.row)">
        <i class="las la-signature"></i>
    </button>
</template>
<template v-else-if="props.column.field == 'name'">
    @{{ props.row.name ?? '-' }}<hr>
    @{{ props.row.email ?? '-' }}
</template>
<template v-else-if="props.column.field == 'gender'">
    @{{ props.row.gender ?? '-' }}<hr>
    @{{ props.row.maritalStatus ?? '-' }}
</template>
<template v-else-if="props.column.field == 'citizenship'">
    @{{ props.row.citizenship ?? '-' }}<hr>
    @{{ props.row.IdCardAddress ?? '-' }}
</template>
<template v-else-if="props.column.field == 'bankName'">
    @{{ props.row.bankName ?? '-' }}<hr>
    @{{ props.row.bankNoOwner ?? '-' }}
</template>
<template v-else-if="props.column.field == 'investmentGoal'">
    @{{ props.row.investmentGoal ?? '-' }}<hr>
    @{{ props.row.investmentPreference ?? '-' }}
</template>