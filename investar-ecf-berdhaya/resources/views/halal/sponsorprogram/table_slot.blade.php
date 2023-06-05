<template v-else-if="props.column.field == 'programId'">
    @{{ props.row.programId ?? '-' }}<hr>
    @{{ props.row.programName ?? '-' }}
</template>
<template v-else-if="props.column.field == 'description'">
    @{{ props.row.description ?? '-' }}<hr>
    @{{ props.row.sponsorId ?? '-' }}
</template>
<template v-else-if="props.column.field == 'sponsorName'">
    @{{ props.row.sponsorName ?? '-' }}<hr>
    @{{ props.row.sponsor ?? '-' }}
</template>
<template v-else-if="props.column.field == 'voucherPicture'">
    @{{ props.row.voucherPicture ?? '-' }}<hr>
    @{{ props.row.voucherUnitCurrency ?? '-' }}
</template>