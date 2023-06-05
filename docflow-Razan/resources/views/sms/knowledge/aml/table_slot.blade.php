
    <template v-else-if="props.column.field == 'brand'">
        <span style="color:blue; cursor:pointer;"@click="showViewModal(props.row)">@{{ props.row.brand }}</span>
    </template>
     <template v-else-if="props.column.field == 'Company'">
         <span style="color:blue; font-weight:bold;cursor:pointer;"@click="showViewModal(props.row)">@{{ props.row.Company }}</span>
    </template>
     <template v-else-if="props.column.field == 'RefDate'">
        @{{ formatDate(props.row.RefDate) }}
    </template>
