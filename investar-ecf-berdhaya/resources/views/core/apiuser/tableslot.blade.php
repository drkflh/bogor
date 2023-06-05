<template slot="address" slot-scope="props">
    @{{ props.row.address }}<br>
    @{{ props.row.kelurahan }} @{{ props.row.kecamatan }}<br>
    @{{ props.row.city }} @{{ props.row.ZIP }}<br>
</template>
<template slot="roleName" slot-scope="props">
    @{{ props.row.roleName }}<br>
    @{{ props.row.roleId }}
</template>
<template slot="idNumber" slot-scope="props">
    <img v-bind:src="imageUrl(props.row.idPic)" class="img-thumbnail" style="width: 150px;min-width: 150px;">
    <br>
    @{{ _.get(props.row, 'idType', '') + ' ' +  _.get(props.row, 'idNumber', '') }}
</template>



