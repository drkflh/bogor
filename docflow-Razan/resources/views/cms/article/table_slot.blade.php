<template v-else-if="props.column.field == 'title'">
    <b v-html="props.row.title" ></b>
    <hr>
    <span v-html="props.row.slug" ></span><br>
    <p v-html="props.row.description"></p>
</template>
<template v-else-if="props.column.field == 'section'">
    <b v-html="props.row.section + ' / ' + props.row.category " ></b>
    <hr>
    <p v-html="props.row.tags"></p>
</template>
