<template v-else-if="props.column.field == 'jobNo'">
    <span style="color:blue; width: 80px; font-weight:bold;cursor:pointer;"@click="showViewModal(props.row)">@{{ props.row.jobNo ?? '' }}</span>
</template>
<template v-else-if="props.column.field == 'participatingCompany'">
    @{{ props.row.participatingCompany ?? '-' }}<hr>
    @{{ props.row.area ?? '-' }}
</template>
<template v-else-if="props.column.field == 'inquiryDate'">
    @{{ formatDate(props.row.inquiryDate) }}<hr>
    <p style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; cursor: pointer;color: blue;" :id="'pop-' + props.row.rfqReference + props.row._id " >@{{ props.row.rfqReference ?? '-' }} </p>
        <b-popover
            :target="'pop-' + props.row.rfqReference + props.row._id"
            placement="bottomleft"
            triggers="hover focus"
            :content="props.row.rfqReference ?? '-'"
        ></b-popover>
</template>
<template v-else-if="props.column.field == 'project'">
    <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;cursor: pointer; color: blue;" :id="'pop-' + props.row.project + props.row._id " v-html="emptySub(props.row.project)" ></span>
        <b-popover
            :target="'pop-' + props.row.project + props.row._id"
            placement="bottomleft"
            triggers="hover focus"
            :content="props.row.project ?? '-'"
        ></b-popover>
   <hr>
    <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; cursor: pointer;color: blue;" :id="'pop-' + props.row.scope "  v-html="emptySub(props.row.scope)" ></span>
        <b-popover
            :target="'pop-' + props.row.scope "
            placement="bottomleft"
            triggers="hover focus"
            :content="props.row.scope ?? '-' "
        ></b-popover>
</template>


<template v-else-if="props.column.field == 'company'">
    <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;cursor: pointer; color: blue;" :id="'pop-' + props.row.company + props.row._id"  v-html="emptySub(props.row.company)" ></span>
    <b-popover
        :target="'pop-' + props.row.company + props.row._id"
        placement="bottomleft"
        triggers="hover focus"
        :content="props.row.company ?? '-'"
    ></b-popover>
   <hr>
    <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; cursor: pointer;color: blue;" :id="'pop-' + props.row.projectOwner"  v-html="emptySub(props.row.projectOwner)" ></span>
        <b-popover
            :target="'pop-' + props.row.projectOwner"
            placement="bottomleft"
            triggers="hover focus"
            :content="props.row.projectOwner"
        ></b-popover>
</template>
<template v-else-if="props.column.field == 'quotationNo'">
    @{{ props.row.quotationNo ?? '-' }}<hr>
    <span v-if="props.row.commercialDate">
        @{{ props.row.commercialDate ? formatDate(props.row.commercialDate) : '-' }}
    </span>
    <span v-else>-</span>
</template>
<template v-else-if="props.column.field == 'awardPoNo'">
    @{{ props.row.awardPoNo ?? '-' }}<hr>
    <span v-if="props.row.awardPoNoDate">
        @{{ props.row.awardPoNoDate ? formatDate(props.row.awardPoNoDate) : '-' }}
    </span>
    <span v-else>-</span>
</template>

<template v-else-if="props.column.field == 'dummi'">
    @{{ formatCurrency(props.row.bidAmount) }}<hr>
    @{{ formatCurrency(props.row.idrEquiv) }}
</template>

<template v-else-if="props.column.field == 'pocontract'">
    @{{ props.row.pocontract ?? '-' }}<hr>
    @{{ props.row.poAmount ?? '-' }}
</template>

<template v-else-if="props.column.field == 'requestDelivery'">
    <span v-if="props.row.requestDelivery">
        @{{ formatDate(props.row.requestDelivery) }}<hr>
    </span>
    <span v-else>-<hr></span>
    <span v-if="props.row.actualDelivery">
        @{{ formatDate(props.row.actualDelivery) }}
    </span>
    <span v-else>-</span>
</template>

<template v-else-if="props.column.field == 'bidStatus'">
    <span @click="changeBidStatus(props.row)" style="cursor:pointer;font-weight: bolder;">@{{ props.row.bidStatus ?? '-' }}</span><hr>
    <span v-if="enableJobButton(props.row)" @click="changeJobStatus(props.row)" style="cursor:pointer;font-weight: bolder;">@{{ props.row.jobStatus ?? '-' }}</span>
    <span v-if="!enableJobButton(props.row)" class="disabled" style="cursor:pointer;font-weight: bolder;">@{{ props.row.jobStatus ?? '-' }}</span>
</template>
<template v-else-if="props.column.field == 'bidStatusRemarks'">
    <span style="cursor:pointer;font-size:10pt;font-weight: bolder;">@{{ props.row.bidStatusRemarks ?? '-' }}</span><hr>
    <span style="cursor:pointer;font-size:10pt;font-weight: bolder;">@{{ props.row.jobStatusRemarks ?? '-' }}</span>
</template>
<template v-else-if="props.column.field == 'jobRemark'">
    <div class="d-flex justify-content-start align-content-start">
        <button class="btn btn-icon mr-1" @click="openLogModal(props.row)"><i class="las la-clock"></i></button>
        <div class="text-left">
            <span @click="changeJobRemark(props.row)" style="cursor:pointer;font-size:10pt;font-weight: bolder; ">
                @{{ props.row.jobRemark ?? '[ + ]' }}
            </span><br>
            <span class="small" style="color: lightslategrey;">@{{ props.row.jobRemarkDate ?? '' }}</span>
        </div>
    </div>
</template>

<template v-else-if="props.column.field == 'proposalBy'">
    @{{ props.row.proposalBy ?? '-' }}<hr>
    @{{ props.row.salesPerson ?? '-' }}
</template>

