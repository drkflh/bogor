<template v-else-if="props.column.field == 'sponsorName'">
    Nama Sponsor<hr>Nama Program
</template>
<template v-else-if="props.column.field == 'voucherCode'">
    Kode Voucher<hr>Nilai Voucher
</template>
<template v-else-if="props.column.field == 'usedAt'">
    Pemakai<hr>Jenis Pakai
</template>
