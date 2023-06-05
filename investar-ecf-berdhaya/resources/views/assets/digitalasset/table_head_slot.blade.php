<template v-else-if="props.column.field == 'assetId'">
    Program ID
</template>
<template v-else-if="props.column.field == 'title'">
    Content
</template>
<template v-else-if="props.column.field == 'publishFrom'">
    Publish Time<hr>Publish Status
</template>
<template v-else-if="props.column.field == 'constraintProgram'">
    Program Constraint<hr>Master Handle
</template>
<template v-else-if="props.column.field == 'variants'">
    Variants<hr>Asset Group
</template>