
    <template v-else-if="props.column.field == 'approvalStatus'">
{{--      <i class="las la-lock" style="font-weight:600;color: lightslategray;font-size:13pt;"
           v-if="parseInt(props.row.revLock) == 1"></i>
           <span :class="colorizeStatus(props.row.approvalStatus)" v-html="props.row.approvalStatus">
        </span>
           <br>
    --}}    <button class="btn btn-icon btn-primary"
            v-if="props.row.approvalStatus ==  'AUDITED'"
                @click="changeSingleApprovalStatus(props.row)">
    </template>