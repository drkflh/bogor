<template v-else-if="props.column.field == 'userName'">
    Name<hr>Location
</template>
<template v-else-if="props.column.field == 'productName'">
    Product<hr>Code
</template>
<template v-else-if="props.column.field == 'unit'">
    Unit Count<hr>Unit
</template>
<template v-else-if="props.column.field == 'cartSession'">
    Cart Session<hr>Timestamp
</template>
<template v-else-if="props.column.field == 'idNumber'">
    ID Photo<hr>
    ID Number
</template>
