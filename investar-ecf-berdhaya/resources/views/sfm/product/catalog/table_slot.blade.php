<template v-else-if="props.column.field == 'productName'">
    @{{ props.row.productName }}<hr>
    @{{ props.row.category }}
</template>
<template v-else-if="props.column.field == 'price'">
    @{{ props.row.price }}<hr>
    @{{ props.row.unit }}
</template>
<template v-else-if="props.column.field == ''">
    @{{ props.row.price }}<hr>
    @{{ props.row.unit }}
</template>
