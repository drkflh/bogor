<template v-else-if="props.column.field == 'gatewayType'">
    Gateway
</template>
<template v-else-if="props.column.field == 'from'">
    From & To<hr> CC & BCC
</template>
<template v-else-if="props.column.field == 'subject'">
    Content
</template>
<template v-else-if="props.column.field == 'status'">
    Status<hr>Last Action Time
</template>