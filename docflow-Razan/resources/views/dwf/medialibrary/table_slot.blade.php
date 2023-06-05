<template v-else-if="props.column.field == 'videoDescription'">
    <span :style="props.row.mediaUrl == '' || _.isNull(props.row.mediaUrl) ? '' : 'color:blue;' "  style="cursor:pointer;"@click="showViewModal(props.row)">@{{ props.row.videoDescription }}</span>
</template>
