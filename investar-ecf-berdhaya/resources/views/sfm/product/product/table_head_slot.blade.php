<template v-else-if="props.column.field == 'productName'">
    Product Name<hr>Category
</template>
<template v-else-if="props.column.field == 'price'">
    Price<hr>Currency
</template>
<template v-else-if="props.column.field == 'rate'">
    Rating<hr>Stock
</template>
<template v-else-if="props.column.field == 'weight'">
    Weight<hr>Unit
</template>
