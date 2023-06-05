@if( $table_component == 'vue-good-table')
    <template v-else-if="props.column.field == 'roleACL' && !(_.isNull(props.row.roleACL) || _.isUndefined(props.row.roleACL) ) ">
        @{{ _.keys(props.row.roleACL).length }} Objects
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

