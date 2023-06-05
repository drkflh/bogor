@if( $table_component == 'ant-vue-table')
    <template slot="Subject" slot-scope="text, record">
        <div class="tbl" style="font-size: 10pt;color: darkslategray;;">
            <div class="text-350" style="display: table-cell;">
                <template v-if="_.isEmpty( record.FileUrl )">
                    <b style="font-size: 11pt;">@{{ record.FCallCode }}</b>
                </template>
                <template v-else>
                    <span @click="showPdf( '{{ url('/') }}/{{ env('DOC_READER_ROOT') }}/' + record.DocPath)" style="cursor: pointer;">
                        <b style="font-size: 11pt;color:blue;">@{{ record.FCallCode }}</b>
                    </span>
                </template>
                <br>
            </div>
            <div class="tcell"  style="width: 100%;">
                <b>Topic: </b> @{{ record.Topic }} <span style="margin-left: 20px;cursor: pointer;color: blue;" :id="'pop-' + record.FCallCode" variant="primary"><i class="fa fa-info-circle" ></i></span>
                <b-popover
                    :target="'pop-' + record.FCallCode"
                    placement="bottomright"
                    triggers="hover focus"
                    :content="record.TopicDescr"
                ></b-popover>
            </div>
            <div class="text-150 tcell" style="display: flex; align-items: center;" >
                <template v-if="notifyCanExpire(record)" >
                    <b-iconstack font-scale="2">
                        <b-icon stacked icon="circle" variant="primary"></b-icon>
                        <b-icon stacked icon="bell-fill" scale="0.55" variant="primary"></b-icon>
                    </b-iconstack>
                    <span style="font-size: 9pt;padding-left: 8px;">@{{ formatDate(record.ExpDate) }}</span>
                </template>
                <template v-if="notifyWillExpire(record)" >
                    <b-iconstack font-scale="2">
                        <b-icon stacked icon="circle-fill" animation="fade" variant="danger"></b-icon>
                        <b-icon stacked icon="bell-fill" scale="0.55" variant="danger"></b-icon>
                    </b-iconstack>
                    <span style="font-size: 9pt;padding-left: 8px;">@{{ formatDate(record.ExpDate) }}</span>
                </template>
                <template v-else-if="notifyHasExpired(record)" >
                    <b-iconstack font-scale="2">
                        <b-icon stacked icon="circle-fill" variant="danger"></b-icon>
                        <b-icon stacked icon="exclamation" variant="white"></b-icon>
                    </b-iconstack>
                    <span style="font-size: 9pt;padding-left: 8px;color: red; font-weight: bold;">@{{ formatDate(record.ExpDate) }}</span>
                </template>
            </div>
        </div>
        <div v-html="record.Subject"
             style="width: 600px;max-width: 600px;min-width: 600px; white-space: nowrap; text-overflow: ellipsis;overflow: hidden;line-height: 2em;" ></div>
        <div class="tbl"  style="font-size: 10pt;color: darkslategray;" >
            <div class="tcell text-350" >
                <b>Doc.Ref: </b> @{{ record.DocRef }}
            </div>
            <div class="tcell text-150">
                <b>In/Out: </b> @{{ record.IO }}
            </div>
            <div class="tcell text-150">
                <b>Type: </b> @{{ record.Tipe }}
            </div>
            <div class="tcell text-100">
                <b>Doc Class: </b> @{{ record.Class }}
            </div>
        </div>
    </template>
    <template slot="IODate" slot-scope="text, record" >
        @{{ formatDate(record.IODate) }}<hr>
        @{{ formatDate(record.DocDate) }}
    </template>
    <template slot="NoSheet" slot-scope="text, record" >
        @{{ record.NoPage }} pages<hr>
        @{{ record.NoSheet }} sheets
    </template>
    <template slot="RetDate" slot-scope="text, record" >
        @{{ record.RetPer }} years<hr>
        @{{ formatMonth(record.RetDate) }}
    </template>
    <template slot="DispDate" slot-scope="text, record" >
        @{{ record.DispPer }} years<hr>
        @{{ formatMonth(record.DispDate) }}
    </template>

@elseif( $table_component == 'vue-good-table')
    <template v-else-if="props.column.field == 'Subject'">
        <div class="tbl" style="font-size: 10pt;color: darkslategray;;">
            <div class="text-350" style="display: table-cell;">
                <template v-if="_.isEmpty( props.row.FileUrl )">
                    <b style="font-size: 11pt;">@{{ props.row.FCallCode }}</b>
                </template>
                <template v-else>
                    <span @click="showPdf( '{{ url('/') }}/{{ env('DOC_READER_ROOT') }}/' + props.row.DocPath)" style="cursor: pointer;">
                        <b style="font-size: 11pt;color:blue;">@{{ props.row.FCallCode }}</b>
                    </span>
                </template>
                <br>
            </div>
            <div class="tcell"  style="width: 100%;">
                <b>Topic: </b> @{{ props.row.Topic }} <span style="margin-left: 20px;cursor: pointer;color: blue;" :id="'pop-' + props.row.FCallCode" variant="primary"><i class="fa fa-info-circle" ></i></span>
                <b-popover
                    :target="'pop-' + props.row.FCallCode"
                    placement="bottomright"
                    triggers="hover focus"
                    :content="props.row.TopicDescr"
                ></b-popover>
            </div>
            <div class="text-150 tcell" style="display: flex; align-items: center;" >
                <template v-if="notifyCanExpire(props.row)" >
                    <b-iconstack font-scale="2">
                        <b-icon stacked icon="circle" variant="primary"></b-icon>
                        <b-icon stacked icon="bell-fill" scale="0.55" variant="primary"></b-icon>
                    </b-iconstack>
                    <span style="font-size: 9pt;padding-left: 8px;">@{{ formatDate(props.row.ExpDate) }}</span>
                </template>
                <template v-if="notifyWillExpire(props.row)" >
                    <b-iconstack font-scale="2">
                        <b-icon stacked icon="circle-fill" animation="fade" variant="danger"></b-icon>
                        <b-icon stacked icon="bell-fill" scale="0.55" variant="danger"></b-icon>
                    </b-iconstack>
                    <span style="font-size: 9pt;padding-left: 8px;">@{{ formatDate(props.row.ExpDate) }}</span>
                </template>
                <template v-else-if="notifyHasExpired(props.row)" >
                    <b-iconstack font-scale="2">
                        <b-icon stacked icon="circle-fill" variant="danger"></b-icon>
                        <b-icon stacked icon="exclamation" variant="white"></b-icon>
                    </b-iconstack>
                    <span style="font-size: 9pt;padding-left: 8px;color: red; font-weight: bold;">@{{ formatDate(props.row.ExpDate) }}</span>
                </template>
            </div>
        </div>
        <div v-html="props.row.Subject"
             style="width: 600px;max-width: 600px;min-width: 600px; white-space: nowrap; text-overflow: ellipsis;overflow: hidden;line-height: 2em;" ></div>
        <div class="tbl"  style="font-size: 10pt;color: darkslategray;" >
            <div class="tcell text-350" >
                <b>Doc.Ref: </b> @{{ props.row.DocRef }}
            </div>
            <div class="tcell text-150">
                <b>In/Out: </b> @{{ props.row.IO }}
            </div>
            <div class="tcell text-150">
                <b>Type: </b> @{{ props.row.Tipe }}
            </div>
            <div class="tcell text-100">
                <b>Doc Class: </b> @{{ props.row.Class }}
            </div>
        </div>
    </template>
    <template v-else-if="props.column.field == 'IODate'">
        @{{ formatDate(props.row.IODate) }}<hr>
        @{{ formatDate(props.row.DocDate) }}
    </template>
    <template v-else-if="props.column.field == 'NoSheet'">
        @{{ props.row.NoPage }} pages<hr>
        @{{ props.row.NoSheet }} sheets
    </template>
    <template v-else-if="props.column.field == 'RetDate'">
        @{{ props.row.RetPer }} years<hr>
        @{{ formatMonth(props.row.RetDate) }}
    </template>
    <template v-else-if="props.column.field == 'DispDate'">
        @{{ props.row.DispPer }} years<hr>
        @{{ formatMonth(props.row.DispDate) }}
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

