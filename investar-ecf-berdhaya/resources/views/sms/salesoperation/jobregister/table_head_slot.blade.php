@if( $table_component == 'vue-good-table')
    <template v-else-if="props.column.field == 'jobNo'">
        Job No.
    </template>
    <template v-else-if="props.column.field == 'participatingCompany'">
        Participating Coy<hr>
        Area
    </template>
     <template v-else-if="props.column.field == 'inquiryDate'">
        Inquiry Date<hr>
        RFQ Reference
    </template>
    <template v-else-if="props.column.field == 'project'">
        Project Description<hr>
        Project Scope
    </template>
    <template v-else-if="props.column.field == 'company'">
        Buying Company<hr>
        Project End User
    </template>
     <template v-else-if="props.column.field == 'quotationNo'">
        Quotation No.<hr>
        Quotation Date
    </template>
     <template v-else-if="props.column.field == 'awardPoNo'">
         Client PO No.<hr>
         Client PO Date
    </template>
    <template v-else-if="props.column.field == 'requestDelivery'">
        Request Delivery<hr>
        Actual Delivery
    </template>
    <template v-else-if="props.column.field == 'bidStatus'">
        Bid Status<hr>
        Job Status
    </template>
    <template v-else-if="props.column.field == 'bidStatusRemarks'">
        Bid Status Remarks<hr>
        Job Status Remarks
    </template>
@else
    <template slot="FullCallCode" slot-scope="props">
        <b style="font-size: 9pt;">@{{ props.row.FullCallCode }}</b><br>
        <div v-html="props.row.Subject" style="width: 100%;max-width: 450px; white-space: nowrap; text-overflow: ellipsis;overflow: hidden;" ></div>
        <div class="row" style="font-size: 11pt;color: grey;">
            <div class="col-3">
                <b>Type: </b> @{{ props.row.Tipe }}
            </div>
            <div class="col-3">
                <b>Topic: </b> @{{ props.row.Topic }}
            </div>
            <div class="col-3">
                <b>Func: </b> @{{ props.row.Function }}
            </div>
            <div class="col-3">
                <b>Feat: </b> @{{ props.row.Feature }}
            </div>
        </div>
    </template>
    <template slot="IO" slot-scope="props">
        @{{ props.row.IO }}<br>
        @{{ props.row.Tipe }}
    </template>
@endif

