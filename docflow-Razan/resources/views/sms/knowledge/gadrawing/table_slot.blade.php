
    <template v-else-if="props.column.field == 'brand'">
        <span style="color:blue; cursor:pointer;"@click="showViewModal(props.row)">@{{ props.row.brand }}</span>
    </template>
