@if( $table_component == 'vue-good-table')
    <template v-else-if="props.column.field == 'deliveryDate'">
        @{{ formatDate(props.row.deliveryDate) }}
    </template>
    <template v-else-if="props.column.field == 'purchaseOrderDate'">
        <div class="row">
            <div class="col-4">
                @{{ formatDate(props.row.purchaseOrderDate) }}
                <span style="white-space: nowrap; overflow: hidden;cursor: pointer;color: blue;" :id="'pop-' + props.row.rfqReference" >@{{ props.row.rfqReference }} </span>
                    <b-popover
                        :target="'pop-' + props.row.rfqReference"
                        placement="bottomleft"
                        triggers="hover focus"
                        :content="props.row.rfqReference">
                    </b-popover>
            </div>
            <div class="col-7">
                @{{ props.row.prNo }}
            </div>
        </div>
    </template>
    <template v-else-if="props.column.field == 'project'">
                <span style="white-space: nowrap; overflow: hidden;cursor: pointer;color: blue;" :id="'pop-' + props.row.project" >@{{ props.row.project }} </span>
                <b-popover
                    :target="'pop-' + props.row.project"
                    placement="bottomleft"
                    triggers="hover focus"
                    :content="props.row.project"
                ></b-popover>
   <hr>
    <span style="white-space: nowrap; overflow: hidden;cursor: pointer;color: blue;" :id="'pop-' + props.row.scope" >@{{ props.row.scope }} </span>
                <b-popover
                    :target="'pop-' + props.row.scope"
                    placement="bottomleft"
                    triggers="hover focus"
                    :content="props.row.scope"
                ></b-popover>

    </template>
    <template v-else-if="props.column.field == 'vendorCode'">
        <div class="row">
            <div class="col-4">
                @{{ props.row.vendorCode }}
            </div>
            <div class="col-8 text-left">
                @{{ props.row.vendorName }}
            </div>
        </div>
    </template>
    <template v-else-if="props.column.field == 'companyName'">
        @{{ props.row.companyName }}
    </template>
    <template v-else-if="props.column.field == 'jobNo'">
        @{{ props.row.jobNo ?? "-"}}<hr>
        @{{ props.row.costCenter ?? "-"}}
    </template>
    <template v-else-if="props.column.field == 'companyCode'">
        @{{ props.row.companyCode }}
    </template>
    <template v-else-if="props.column.field == 'services'">
        <b>Products</b> <br>
        @{{ props.row.products }} <br>
        <b>Services</b> <br>
        @{{ props.row.services }} <br>
        <b>Brands</b> <br>
        @{{ props.row.brands }}
    </template>
    <template v-else-if="props.column.field == 'address'">
        @{{ props.row.address }} <hr>
        <b>Phones</b>
        <div class="row">
            <div class="col-12">
              <span v-for="phone in saveSplit( props.row.offPhones )" style="display:block; padding-left:4px;"> @{{ phone }} </span>
            </div>
        </div>
        <b>Faxes</b>
        <div class="row">
            <div class="col-12">
              <span v-for="fax in saveSplit( props.row.offFaxes )" style="display:block; padding-left:4px;"> @{{ fax }} </span>
            </div>
        </div>
        <b>Emails</b>
        <div class="row">
            <div class="col-12">
              <span>
              <a style="display:block;" v-for="email in saveSplit( props.row.offEmails )" :href="'mailto:' + email" target="_blank" rel="noopener noreferrer">@{{ email }}</a><br>
              </span>
            </div>
        </div>
    </template>
    <template v-else-if="props.column.field == 'details'">
        <span v-html="totalDetail(props.row)">
        </span>
    </template>
    <template v-else-if="props.column.field == 'approvalStatus'">
        <span :class="colorizeStatus(props.row.approvalStatus)" v-html="props.row.approvalStatus">
        </span>
    </template>
    {{-- <template v-else-if="props.column.field == 'details'">
        <template v-if="!_.isEmpty(props.row.details)">
            <template v-for="detail in props.row.details">
              @{{ formatCurrency(sumColumn(props.row.details, 'AmountOrdered')) }}
            </template>
        </template>
        <template v-else>
            NA
        </template>
    </template> --}}

    <template v-else-if="props.column.field == 'requestNo'">
        @{{ props.row.requestNo }}-@{{ props.row.rev }}
    </template>
    <template v-else-if="props.column.field == 'status'">
        @{{ props.row.status }}
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


