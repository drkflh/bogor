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
<span v-if="props.row.emailVerified != true " @click="changeEmailStatus(props.row)"  class="fa fa-envelope"></span> <i class="las la-check" :class="props.row.emailVerified ? 'la-check-circle green' : 'la-circle lightgrey'"></i> @{{ props.row.email ?? '-' }}<hr>
    @{{ props.row.username ?? '-' }}
</template>

<template v-else-if="props.column.field == 'name'">
    @{{ props.row.name ?? '-' }}<hr>
    @{{ props.row.roleName ?? '-' }}
</template>

<template v-else-if="props.column.field == 'mobile'">
<span v-if="props.row.mobileVerified != true " @click="changeMobileStatus(props.row)"  class="fa fa-mobile"></span> <i class="las la-check" :class="props.row.mobileVerified ? 'la-check-circle green' : 'la-circle lightgrey'"></i> @{{ props.row.mobile }}<hr>
    @{{ props.row.phone }}



</template>
<template v-else-if="props.column.field == 'idNumber'">
    <img :src="props.row.idPic" style="height:100px;width: 160px; object-fit: cover; border-radius: 16px; " />
    <hr>
    @{{ props.row.idType }} @{{ props.row.idNumber }}
</template>
{{-- <template v-else-if="props.column.field == 'sihalal_register'">
    <button class="btn btn-icon btn-primary" @click="openRegSihalalModal(props.row)" v-if="props.row.sihalal_member != true">
        <i class="las la-plus"></i></button>
</template>
 --}}
