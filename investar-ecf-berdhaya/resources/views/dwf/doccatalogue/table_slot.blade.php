<template v-else-if="props.column.field == 'Subject'">
    <span :style="props.row.FileUrl == '' || _.isNull(props.row.FileUrl) ? '' : 'color:blue;' "   style="cursor:pointer;" @click="showViewModal(props.row)">@{{ props.row.Subject }}</span>
</template>
<template v-else-if="props.column.field == 'Recipient'">
    <a-config-provider>
        <template #renderEmpty>
            <div style="text-align: center">
                <i style="color: orange;" class="las la-exclamation-triangle"></i>
            </div>
        </template>
        <a-list item-layout="horizontal" row-key="key" :data-source="sortArray(props.row.Recipient, [ 'obj.seq' ] )">
            <a-list-item slot="renderItem" slot-scope="it, idx">
                <a-list-item-meta
                    :description="it.obj.name"
                >
                </a-list-item-meta>
            </a-list-item>
        </a-list>
    </a-config-provider>
</template>
