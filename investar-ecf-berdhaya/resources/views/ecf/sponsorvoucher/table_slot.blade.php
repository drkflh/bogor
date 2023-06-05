<template v-else-if="props.column.field == 'sponsorName'">
    @{{ props.row.sponsorName }}<hr>
    @{{ props.row.programName }}
</template>
<template v-else-if="props.column.field == 'voucherCode'">
    @{{ props.row.voucherCode }}<hr>
    @{{ props.row.voucherValue }}
</template>
<template v-else-if="props.column.field == 'usedAt'">
    @{{ props.row.usedAt }}<hr>
    @{{ props.row.usedByObject }}
</template>