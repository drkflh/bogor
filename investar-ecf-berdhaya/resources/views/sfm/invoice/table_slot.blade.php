<template v-else-if="props.column.field == 'fname'">
    @{{ props.row.fname ?? '-' }}<hr>
    @{{ props.row.lname ?? '-' }}
</template>
<template v-else-if="props.column.field == 'email'">
    @{{ props.row.email ?? '-' }}<hr>
    @{{ props.row.mobile ?? '-' }}
</template>
<template v-else-if="props.column.field == 'delivery_option'">
    @{{ props.row.delivery_option ?? '-' }}<hr>
    @{{ props.row.payment_option ?? '-' }}
</template>
<template v-else-if="props.column.field == 'shippingCost'">
    @{{ props.row.shippingCost ?? '-' }}<hr>
    @{{ props.row.status ?? '-' }}
</template>
<template v-else-if="props.column.field == 'city'">
    @{{ props.row.city ?? '-' }}<hr>
    @{{ props.row.zipcode ?? '-' }}
</template>
<template v-else-if="props.column.field == 'billing_address'">
    @{{ props.row.billing_address ?? '-' }}<hr>
    @{{ props.row.billing_address2 ?? '-' }}
</template>