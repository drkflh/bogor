<template v-else-if="props.column.field == 'email'">
    @{{ props.row.email }}<hr>
    @{{ props.row.username }}
</template>

<template v-else-if="props.column.field == 'created_at'">
    @{{ props.row.created_at }}<hr>
    @{{ props.row.type }}
</template>

<template v-else-if="props.column.field == 'notifiable_id'">
    @{{ props.row.notifiable_id }}<hr>
    @{{ props.row.notifiable_type }}
</template>
<template v-else-if="props.column.field == 'idNumber'">
    <img :src="props.row.idPic" style="height:100px;width: 160px; object-fit: cover; border-radius: 16px; " /><hr>
    @{{ props.row.idType }} @{{ props.row.idNumber }}
</template>
<template v-else-if="props.column.field == 'data'">
    <table>
        <tr v-for="(nval,nkey,index) in props.row.data">
            <td style="font-size:9pt;font-weight: bold;width: 30%;min-width: 150px !important;" class="ellipsis" >
                @{{ nkey }}
            </td>
            <td style="font-size:9pt;" class="ellipsis" >
                @{{ nval }}
            </td>
        </tr>
    </table>
</template>


