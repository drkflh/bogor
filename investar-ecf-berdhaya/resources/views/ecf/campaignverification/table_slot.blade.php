<template v-else-if="props.column.field == 'approvalStatus'">
    <button class="btn btn-icon btn-primary" v-if="( props.row.needReview || props.row.needSigning )"
        @click="changeSingleApprovalStatus(props.row)">
        <i class="las la-signature"></i>
    </button>
</template>