<template v-else-if="props.column.field == 'name'">
    @{{ props.row.name }}<hr>
    @{{ props.row.slug }}
</template>
<template v-else-if="props.column.field == 'link'">
    @{{ props.row.link }}<hr>
    @{{ props.row.promoCode }}
</template>