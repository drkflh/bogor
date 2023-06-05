<template v-else-if="props.column.field == 'minWeight'">
    @{{ props.row.minWeight ?? '-' }}<hr>
    @{{ props.row.maxWeight ?? '-' }}
</template>
