<template v-else-if="props.column.field == 'gatewayType'">
    <div class="row" style="font-size: 10pt;color: darkslategray;">
        <div class="col-5 text-250">
            <b>Gateway Type: </b> @{{ props.row.gatewayType ?? '-' }}
        </div>
        <div class="col-5 text-250">
            <b>Gateway Slug: </b> @{{ props.row.gatewaySlug ?? '-' }}
        </div>
    </div>
</template>

<template v-else-if="props.column.field == 'from'">
    <div class="row" style="font-size: 10pt;color: darkslategray;">
        <div class="col-3 text-250">
            <b>From: </b> @{{ props.row.from ?? '-' }}
        </div>
        <div class="col-3 text-250">
            <b>To: </b> @{{ props.row.to ?? '-' }}
        </div>
        <div class="col-3 text-250">
            <b>CC: </b> @{{ props.row.cc ?? '-' }}
        </div>
        <div class="col-3 text-250">
            <b>BCC: </b> @{{ props.row.bcc ?? '-' }}
        </div>
    </div>
</template>

<template v-else-if="props.column.field == 'subject'">
    <div class="row" style="font-size: 10pt;color: darkslategray;">
        <div class="col-4 text-250">
            <b>Subject: </b> @{{ props.row.subject ?? '-' }}
        </div>
        <div class="col-4 text-250">
            <b>Body: </b> @{{ props.row.body ?? '-' }}
        </div>
        <div class="col-4 text-250">
            <b>Attachments: </b> @{{ props.row.attachments ?? '-' }}
        </div>
    </div>
</template>

<template v-else-if="props.column.field == 'status'">
    <div class="row" style="font-size: 10pt;color: darkslategray;">
        <div class="col-4 text-250">
            <b>Status: </b> @{{ props.row.status ?? '-' }}
        </div>
        <div class="col-4 text-250">
            <b>Last Action: </b> @{{ props.row.lastAction ?? '-' }}
        </div>
        <div class="col-4 text-250">
            <b>Last Action Time: </b> @{{ props.row.lastActionTs ?? '-' }}
        </div>
    </div>
</template>