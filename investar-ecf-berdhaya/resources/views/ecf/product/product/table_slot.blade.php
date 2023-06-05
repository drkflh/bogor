<template v-else-if="props.column.field == 'productName'">
    @{{ props.row.productName }}<hr>
    @{{ props.row.category }}
</template>
<template v-else-if="props.column.field == 'price'">
    @{{ props.row.price }}<hr>
    @{{ props.row.currency }}
</template>
<template v-else-if="props.column.field == 'rate'">
    @{{ props.row.rate }}<hr>
    @{{ props.row.stock }}
</template>
<template v-else-if="props.column.field == 'weight'">
    @{{ props.row.weight }}<hr>
    @{{ props.row.unit }}
</template>
