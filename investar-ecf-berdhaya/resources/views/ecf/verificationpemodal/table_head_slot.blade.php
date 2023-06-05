{{-- <template v-else-if="props.column.field == 'citizenship'">
    <div style="width: 50px;">
        Kewarganegaraan
    </div>
</template> --}}
<template v-else-if="props.column.field == 'name'">
    Nama Lengkap<hr>
    Email
</template>
<template v-else-if="props.column.field == 'gender'">
   Jenis Kelamin<hr>
    Status Penikahan
</template>
<template v-else-if="props.column.field == 'citizenship'">
    Kewarganegaraan<hr>
     Alamat Sesuai KTP
 </template>
 <template v-else-if="props.column.field == 'bankName'">
    Bank<hr>
    Pemilik Rekening
 </template>
 <template v-else-if="props.column.field == 'investmentGoal'">
   <div>
    Tujuan Investasi<hr>
    Preferensi Investasi
    </div>
 </template>
