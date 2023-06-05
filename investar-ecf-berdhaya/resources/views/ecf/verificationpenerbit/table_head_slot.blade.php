
<template v-else-if="props.column.field == 'name'">
    Nama Lengkap
    <hr>Email
</template>
<template v-else-if="props.column.field == 'bizRegisteredName'">
    Nama Badan Usaha
    <hr>Jenis Pendanaan
</template>
<template v-else-if="props.column.field == 'bizCompanyType'">
    Bentuk Badan Usaha
    <hr>Jenis Usaha
</template>


