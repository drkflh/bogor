<template v-else-if="props.column.field == 'assignedTo'">
    Assigned To
</template>
<template v-else-if="props.column.field == 'taskName'">
    Task
</template>
<template v-else-if="props.column.field == 'startDateTime'">
    From - Until <br>Estd. Duration
</template>
<template v-else-if="props.column.field == 'mobile'">
    Mobile<hr>Home
</template>
<template v-else-if="props.column.field == 'idNumber'">
    ID Photo<hr>
    ID Number
</template>
