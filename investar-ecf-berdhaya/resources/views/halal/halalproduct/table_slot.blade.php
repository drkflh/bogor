<template v-else-if="props.column.field == 'tradeMark'">
    @{{ props.row.tradeMark }}<hr>
    @{{ props.row.businessRef }}
</template>

<template v-else-if="props.column.field == 'sihalal_register'"> 
    <button v-if="props.row.sihalal_certified != 'true'" class="btn btn-success" @click="openRegModal(props.row)">
        <i style="color:white;">add</i></button>
</template>

<template v-else-if="props.column.field == 'sihalal_reg'">
       
    <button  v-if=" !props.row.sihalal_certified" class="btn btn-success">
            <a v-if=" !props.row.sihalal_registered" href="sihalal-register" >
                <i style="color:white;">Daftar Sertifikasi</i>
            </a>
            <a v-if=" props.row.sihalal_registered" href="sihalal-register2">
                <i style="color:white;">Daftar Sertifikasi</i>
            </a>
    </button>  
     
</template>