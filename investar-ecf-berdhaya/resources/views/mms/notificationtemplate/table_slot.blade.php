<template v-else-if="props.column.field == 'email'">
    @{{ props.row.email }}<hr>
    @{{ props.row.username }}
</template>

<template v-else-if="props.column.field == 'name'">
    @{{ props.row.name }}<hr>
    @{{ props.row.roleName }}
</template>

<template v-else-if="props.column.field == 'mobile'">
    @{{ props.row.mobile }}<hr>
    @{{ props.row.phone }}
</template>
<template v-else-if="props.column.field == 'qontakAction'">
    <button class="btn mr-1"
            :disabled="updateCheck(props.row)"
            :class="updateCheck(props.row) ? 'btn-outline-secondary' : 'btn-primary'"
            @click="submitTpl(props.row)"
    >
        @{{ updateCheck(props.row) ? 'Submitted' : 'Submit' }}
    </button>
</template>


