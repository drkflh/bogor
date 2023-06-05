<template v-else-if="props.column.field == 'url'">
    <span v-html="props.row.created_at"></span>
    <hr/>
    <span style="font-weight: bold;margin-right: 8px;" v-html="props.row.method"></span>
    <span v-html="props.row.url"></span>
    <hr/>
    <span style="font-weight: bold;margin-right: 8px;" v-if="props.row.actor" v-html="props.row.actor.roleName"></span>
    <span v-if="props.row.actor" v-html="props.row.actor.name"></span>
</template>

<template v-else-if="props.column.field == 'request_data'">
    <div style="word-break: break-all;word-wrap: anywhere;width: 100%;">
        <pre v-html="props.row.request_data"></pre>
    </div>
</template>

<template v-else-if="props.column.field == 'response_data'">
    <div style="word-break: break-all;word-wrap: anywhere;width: 100%;">
        <pre v-html="props.row.response_data"></pre>
    </div>
</template>

