@if( $table_component == 'vue-good-table')

    <template v-else-if="props.column.field == 'enrollmentDate'">
        @{{ props.row.enrollmentType }}<hr>
        @{{ props.row.enrollmentDate }}
    </template>

    <template v-else-if="props.column.field == 'active'">
        @{{ props.row.active ? 'yes' : 'no' }}
    </template>

@endif

