<template v-else-if="props.column.field == 'userName'">
    Buyer
</template>
<template v-else-if="props.column.field == 'productName'">
    Product
</template>
<template v-else-if="props.column.field == 'unit'">
    Unit
</template>
<template v-else-if="props.column.field == 'cartSession'">
    Cart Session<hr>Timestamp
</template>
<template v-else-if="props.column.field == 'idNumber'">
    ID Photo<hr>
    ID Number
</template>
