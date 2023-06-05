@if( $table_component == 'vue-good-table')
    <template v-else-if="props.column.field == 'vendorCode'">
        Vendor
    </template>
    <template v-else-if="props.column.field == 'requestNo'">
        PR No.
    </template>
    <template v-else-if="props.column.field == 'requestDate'">
        PR Date
    </template>
    <template v-else-if="props.column.field == 'companyName'">
        Company Name
    </template>
    <template v-else-if="props.column.field == 'companyCode'">
        Company Code
    </template>
     <template v-else-if="props.column.field == 'vendorName'">
        Vendor Name
    </template>
    <template v-else-if="props.column.field == 'vendorAddress'">
        Vendor Address
    </template>
    <template v-else-if="props.column.field == 'details'">
       Total Request
    </template>
     <template v-else-if="props.column.field == 'vendorPhone'">
        Vendor Phone
    </template>

     <template v-else-if="props.column.field == 'jobNo'">
      Job No.<hr>
      Cost Center
    </template>
     <template v-else-if="props.column.field == 'referenceNo'">
        Reference No
    </template>
    <template v-else-if="props.column.field == 'referenceDate'">
       Reference Date
    </template>
     <template v-else-if="props.column.field == 'deliveryDate'">
       Delivery Date
    </template>
     <template v-else-if="props.column.field == 'deliveryPeriod'">
       Delivery Period
    </template>
    <template v-else-if="props.column.field == 'purposeOfPurchase'">
        Purpose Of Purchase
     </template>
     <template v-else-if="props.column.field == 'currency'">
        Currency
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

