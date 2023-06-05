<template v-else-if="props.column.field == 'registrationNo'">
    @{{ props.row.registrationNo }}<hr>
    @{{ props.row.registrationDate }}
</template>
<template v-else-if="props.column.field == 'productName'">
    @{{ props.row.productName }}<hr>
    @{{ props.row.productClassification }}
</template>
<template v-else-if="props.column.field == 'validatorInstitution'">
    @{{ props.row.validatorInstitution }}<hr>
    @{{ props.row.validatorName }}
</template>
<template v-else-if="props.column.field == 'tradeMark'">
    @{{ props.row.tradeMark }}<hr>
    @{{ props.row.businessRef }}
</template>
