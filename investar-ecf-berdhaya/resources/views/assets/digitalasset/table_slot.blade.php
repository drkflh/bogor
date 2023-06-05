<template v-else-if="props.column.field == 'assetId'">
    <div class="row" style="font-size: 10pt;color: darkslategray;">
        <div class="col-5 text-250">
            <b>Program ID: </b> @{{ props.row.assetId ?? '-' }}
        </div>
        <div class="col-5 text-250">
            <b>Active: </b> @{{ props.row.active ?? '-' }}
        </div>
    </div>
</template>

<template v-else-if="props.column.field == 'title'">
    <div class="row" style="font-size: 10pt;color: darkslategray;">
        <div class="col-5 text-250">
            <b>Title: </b> @{{ props.row.title ?? '-' }}
        </div>
        <div class="col-5 text-250">
            <b>Description: </b> @{{ props.row.description ?? '-' }}
        </div>
    </div>
</template>

<template v-else-if="props.column.field == 'publishFrom'">
    <div class="row" style="font-size: 10pt;color: darkslategray;">
        <div class="col-4 text-250">
            <b>Publish From: </b> @{{ props.row.publishFrom ?? '-' }}
        </div>
        <div class="col-4 text-250">
            <b>Publish Until: </b> @{{ props.row.publishUntil ?? '-' }}
        </div>
        <div class="col-4 text-250">
            <b>Publish Status: </b> @{{ props.row.publishStatus ?? '-' }}
        </div>
    </div>
</template>

<template v-else-if="props.column.field == 'constraintProgram'">
    <div class="row" style="font-size: 10pt;color: darkslategray;">
        <div class="col-4 text-250">
            <b>Program Constraint: </b> @{{ props.row.constraintProgram ?? '-' }}
        </div>
        <div class="col-4 text-250">
            <b>Entity Constraint: </b> @{{ props.row.constraintEntity ?? '-' }}
        </div>
        <div class="col-4 text-250">
            <b>Master Handle: </b> @{{ props.row.masterHandle ?? '-' }}
        </div>
    </div>
</template>

<template v-else-if="props.column.field == 'variants'">
    <div class="row" style="font-size: 10pt;color: darkslategray;">
        <div class="col-5 text-250">
            <b>Variants: </b> @{{ props.row.variants ?? '-' }}
        </div>
        <div class="col-5 text-250">
            <b>Asset Group: </b> @{{ props.row.assetGroup ?? '-' }}
        </div>
    </div>
</template>