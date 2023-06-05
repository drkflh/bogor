<template v-else-if="props.column.field == 'title'">
    <b v-html="props.row.title" ></b>
    <hr>
    <b v-html="props.row.slug" ></b>
    <p v-html="props.row.description"></p>
</template>
<template v-else-if="props.column.field == 'section'">
    <b v-html="props.row.section + ' / ' + props.row.category " ></b>
    <hr>
    <p v-html="props.row.tags"></p>
    <p v-if="_.isArray(props.row.attachments) && !_.isEmpty(props.row.attachments) ">@{{ props.row.attachments.length }} file(s)</p>
</template>
