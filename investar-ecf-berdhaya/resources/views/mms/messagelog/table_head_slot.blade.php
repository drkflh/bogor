<template v-else-if="props.column.field == 'messageId'">
    Message ID
</template>
<template v-else-if="props.column.field == 'from'">
    From & To<hr> CC & BCC
</template>
<template v-else-if="props.column.field == 'subject'">
    Content
</template>
<template v-else-if="props.column.field == 'status'">
    Status<hr>Timestamp
</template>