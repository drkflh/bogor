
    <template v-else-if="props.column.field == 'Item'">
        <span style="color:blue; cursor:pointer;"@click="showViewModal(props.row)">@{{ props.row.Item }}</span>
    </template>
