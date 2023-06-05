
    <template v-else-if="props.column.field == 'Subject'">
        Document Description
    </template>
    <template v-else-if="props.column.field == 'NoSheet'">
        Pages<hr>
        Sheets
    </template>
    <template v-else-if="props.column.field == 'noNpwp'">
        Company Name<hr> No. Npwp
    </template>
