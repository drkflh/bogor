<template v-else-if="props.column.field == 'programId'">
        Sponsor ID.<hr>
        Sponsor Name
    </template>

    <template v-else-if="props.column.field == 'description'">
        Program ID.<hr>
        Program Name
    </template>

    <template v-else-if="props.column.field == 'sponsorName'">
        Product<hr>
        Product Name
    </template>
    <template v-else-if="props.column.field == 'voucherPicture'">
        Voucher Code<hr>
        Currency
    </template>
