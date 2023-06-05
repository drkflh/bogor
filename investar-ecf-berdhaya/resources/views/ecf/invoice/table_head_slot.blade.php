<template v-else-if="props.column.field == 'fname'">
    First Name<hr>
    Last Name
</template>
<template v-else-if="props.column.field == 'email'">
    Email<hr>
    Mobile
</template>
<template v-else-if="props.column.field == 'delivery_option'">
    Delivery<hr>
    Payment
</template>
<template v-else-if="props.column.field == 'shippingCost'">
    Shipping Cost<hr>
    Status
</template>
<template v-else-if="props.column.field == 'city'">
    City<hr>
    ZIP Code
</template>
<template v-else-if="props.column.field == 'billing_address'">
    Address
</template>