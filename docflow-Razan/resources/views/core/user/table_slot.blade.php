<template v-else-if="props.column.field == 'username'">
    <p style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; cursor: pointer;" :id="'pop-' + props.row.username + props.row._id" >@{{ props.row.username }} </p>
        <b-popover
            :target="'pop-' + props.row.username + props.row._id"
            placement="bottomleft"
            triggers="hover focus"
            :content="props.row.username"
        ></b-popover>
</template>
<template v-else-if="props.column.field == 'email'">
    @{{ props.row.email ?? '-' }}<hr>
    @{{ props.row.username ?? '-' }}
</template>

<template v-else-if="props.column.field == 'name'">
    @{{ props.row.name ?? '-' }}<hr>
    @{{ props.row.roleName ?? '-' }}
</template>

<template v-else-if="props.column.field == 'mobile'">
    @{{ props.row.mobile }}<hr>
    @{{ props.row.phone }}
</template>
<template v-else-if="props.column.field == 'idNumber'">
    <img :src="props.row.idPic" style="height:100px;width: 160px; object-fit: cover; border-radius: 16px; " /><hr>
    @{{ props.row.idType }} @{{ props.row.idNumber }}
</template>


