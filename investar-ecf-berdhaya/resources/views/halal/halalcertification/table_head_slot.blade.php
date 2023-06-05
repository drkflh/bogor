<template v-else-if="props.column.field == 'registrationNo'">
    No. Registrasi<hr>Tgl. Registrasi
</template>
<template v-else-if="props.column.field == 'productName'">
    Nama Produk<hr>Klasifikasi
</template>
<template v-else-if="props.column.field == 'validatorInstitution'">
    Lembaga Pendamping<hr>Nama Pendamping
</template>
<template v-else-if="props.column.field == 'tradeMark'">
    Merk Dagang<hr>Badan Usaha
</template>
