<template v-else-if="props.column.field == 'productName'">
    <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; cursor: pointer;" :id="'pop-' + props.row.productName + props.row._id" >@{{ props.row.productName }} </span>
    <b-popover
        :target="'pop-' + props.row.productName + props.row._id"
        placement="bottomleft"
        triggers="hover focus"
        :content="props.row.productName"
    ></b-popover>
    <hr>
    @{{ props.row.productCode ?? '-' }}
</template>
<template v-else-if="props.column.field == 'userName'">
    @{{ props.row.userName ?? '-' }}<hr>
    @{{ props.row.userLocation ?? '-' }}
</template>

<template style="text-align: center;" v-else-if="props.column.field == 'unit'">
    @{{ props.row.unitCount ?? '-' }}<hr>
    @{{ props.row.unit ?? '-' }}
</template>

<template v-else-if="props.column.field == 'price'">
    @{{ props.row.currency }} @{{ props.row.price }}
</template>

<template v-else-if="props.column.field == 'cartSession'">
    @{{ props.row.cartSession }}<hr>
    @{{ formatDateTime( props.row.orderTime ) }}
</template>
<template v-else-if="props.column.field == 'picture'">
    <img :src="_.first( props.row.idPic, '' )" style="height:100px;width: 160px; object-fit: cover; border-radius: 16px; " />
</template>

