<template v-else-if="props.column.field == 'jobRemark'">
    <div class="d-flex justify-content-center align-content-center">
        <button class="btn btn-icon mr-1" @click="openLogModal(props.row)">
            <i class="las la-clock"></i></button>
    </div>
</template>
<template v-else-if="props.column.field == 'position'">
    @{{ props.row.email }}<hr>
    @{{ props.row.contactWA }}
</template> 
<template v-else-if="props.column.field == 'email'">
    @{{ props.row.name }}<hr>
    @{{ props.row.position }}
</template> 
<template v-else-if="props.column.field == 'bizTradeMark'">
    @{{ props.row.bizTradeMark }}<hr>
    @{{ props.row.bizType }}
</template> 
<template v-else-if="props.column.field == 'bizRegisteredName'">
   @{{ props.row.bizRegisteredName }} <hr>
    @{{ props.row.bizCompanyType }}
</template> 
<template v-else-if="props.column.field == 'establishedSinceYear'">
    @{{ props.row.establishedSinceYear }}<hr>
    @{{ props.row.establishedYear }}
</template>
<template v-else-if="props.column.field == 'requiredFunding'">
    @{{ props.row.requiredFunding }}<hr>
    @{{ props.row.typeOfFunding }}
</template>  
<template v-else-if="props.column.field == 'campaignTitle'">
    @{{ props.row.campaignTitle }}<hr>
    @{{ props.row.campaignPeriod }}
</template>
<template v-else-if="props.column.field == 'campaignStart'">
    @{{ props.row.campaignStart }}<hr>
    @{{ props.row.campaignEnd }}
</template>
<template v-else-if="props.column.field == 'lotEmitted'">
    @{{ props.row.lotEmitted }}<hr>
    @{{ props.row.pricePerLot }}
</template>
<template v-else-if="props.column.field == 'unitPerLot'">
    @{{ props.row.unitPerLot }}<hr>
    @{{ props.row.minLot }}
</template>
<template v-else-if="props.column.field == 'dividendPeriod'">
    @{{ props.row.dividendPeriod }}<hr>
    @{{ props.row.dividendPeriodUnit }}
</template>