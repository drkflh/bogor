@if( $table_component == 'vue-good-table')
    <template v-else-if="props.column.field == 'Subject'">
        <div class="row" style="font-size: 10pt;color: darkslategray;">
            <div class="col-6 text-250">
                <template v-if="_.isEmpty( props.row.FileUrl )">
                    <b style="font-size: 11pt;">@{{ props.row.FCallCode }}</b>
                </template>
                <template v-else>
                    <span @click="showPdf(props.row.FileUrl)" style="cursor: pointer;">
                        <b style="font-size: 11pt;color:blue;">@{{ props.row.FCallCode }}</b>
                    </span>
                </template>
                <br>
            </div>
            <div class="col-6">
                <b>Topic: </b> @{{ props.row.Topic }}
            </div>
        </div>
        <div v-html="props.row.Subject"
             style="width: 600px;max-width: 600px;min-width: 600px; white-space: nowrap; text-overflow: ellipsis;overflow: hidden;line-height: 2em;" ></div>
        <div class="row"  style="font-size: 10pt;color: darkslategray;" >
            <div class="col-5 text-200">
                <b>Doc.Ref: </b> @{{ props.row.DocRef }}
            </div>
            <div class="col-3 text-150">
                <b>In/Out: </b> @{{ props.row.IO }}
            </div>
            <div class="col-2 text-100">
                <b>Type: </b> @{{ props.row.Tipe }}
            </div>
            <div class="col-2 text-100">
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

