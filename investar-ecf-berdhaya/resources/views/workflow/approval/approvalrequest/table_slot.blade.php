<template v-else-if="props.column.field == 'requestApprovers'">
    <span v-for="p in props.row.requestApprovers" v-html="p.text" class="badge badge-pill badge-primary p-2 mr-2 mt-1" ></span>
</template>
