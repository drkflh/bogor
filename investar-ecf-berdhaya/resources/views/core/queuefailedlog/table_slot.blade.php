<template v-else-if="props.column.field == 'connection'">
    <span v-html="props.row.failed_at"></span>
    <hr/>
    <span style="font-weight: bold;margin-right: 8px;" v-html="props.row.queue"></span>
    <span v-html="props.row.connection"></span>
</template>

<template v-else-if="props.column.field == 'payload'">
    <div style="word-break: break-all;word-wrap: anywhere;width: 100%;">
        <pre v-html="props.row.payload"></pre>
    </div>
</template>

<template v-else-if="props.column.field == 'exception'">
    <div style="word-break: break-all;word-wrap: anywhere;width: 100%;">
        <pre v-html="props.row.exception"></pre>
    </div>
</template>

