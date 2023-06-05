<template v-else-if="props.column.field == 'email'">
    @{{ props.row.email }}<hr>
    @{{ props.row.username }}
</template>

<template v-else-if="props.column.field == 'name'">
    @{{ props.row.name }}<hr>
    @{{ props.row.roleName }}
</template>

<template v-else-if="props.column.field == 'mobile'">
    @{{ props.row.mobile }}<hr>
    @{{ props.row.phone }}
</template>
<template v-else-if="props.column.field == 'idNumber'">
    <img :src="props.row.idPic" style="height:100px;width: 160px; object-fit: cover; border-radius: 16px; " /><hr>
    @{{ props.row.idType }} @{{ props.row.idNumber }}
</template>


