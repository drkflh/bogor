<template v-else-if="props.column.field == 'messageId'">
    <div class="row" style="font-size: 10pt;color: darkslategray;">
        <div class="col-5 text-250">
            <b>Message ID: </b> @{{ props.row.messageId ?? '-' }}
        </div>
        <div class="col-5 text-250">
            <b>Action: </b> @{{ props.row.action ?? '-' }}
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
        <div class="col-5 text-250">
            <b>Subject: </b> @{{ props.row.subject ?? '-' }}
        </div>
        <div class="col-5 text-250">
            <b>Attachments: </b> @{{ props.row.attachments ?? '-' }}
        </div>
    </div>
</template>

<template v-else-if="props.column.field == 'status'">
    <div class="row" style="font-size: 10pt;color: darkslategray;">
        <div class="col-5 text-250">
            <b>Status: </b> @{{ props.row.status ?? '-' }}
        </div>
        <div class="col-5 text-250">
            <b>Timestamp: </b> @{{ props.row.timestamp ?? '-' }}
        </div>
    </div>
</template>