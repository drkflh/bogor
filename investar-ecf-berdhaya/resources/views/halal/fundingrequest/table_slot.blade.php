
{{--    <template v-else-if="props.column.field == 'approvalStatus'">--}}
{{--    <button class="btn btn-icon btn-primary"--}}
{{--            v-if="props.row.approvalStatus ==  'OPEN'"--}}
{{--            @click="changeSingleApprovalStatus(props.row)">--}}
{{--        <i class="las la-signature"></i>--}}
{{--    </button>--}}
{{--    </template>--}}
    <template v-else-if="props.column.field == 'bizTradeMark'">
        @{{ props.row.bizTradeMark }}<hr>
        @{{ props.row.bizRegisteredName }}
    </template>
    <template v-else-if="props.column.field == 'bizAddress'">
        @{{ props.row.bizAddress }}<hr>
        @{{ props.row.contactWA }}
    </template>
    <template v-else-if="props.column.field == 'bizPicName'">
        @{{ props.row.bizPicName }}<hr>
        @{{ props.row.bizPicPosition }}
    </template>
    <template v-else-if="props.column.field == 'typeOfFunding'">
        @{{ props.row.requiredFunding }}<hr>
        @{{ props.row.typeOfFunding }}
    </template>
    <template v-else-if="props.column.field == 'approvalAction'">
        <button class="btn btn-icon btn-primary"
                v-if="( props.row.needReview || props.row.needSigning )
                {{--
                && props.row.approvalStatus != 'APPROVED'
                --}}
                "
                @click="changeSingleApprovalStatus(props.row)"
        >
            <i class="las la-signature"></i>
        </button>
    </template>
