<template v-else-if="props.column.field == 'taskName'">
    @{{ props.row.taskName ?? 'Any' }}<hr>
    @{{ props.row.projectName ?? 'Any' }}
</template>
<template v-else-if="props.column.field == 'timerSec'">
    <template v-if="props.row.event == 'TIMER_START'">
        @{{ moment.duration(parseInt(props.row.timerSec), 'seconds').format("h [hrs], m [min], s [sec]") }}
    </template>
    <template v-else>
        &nbsp;
    </template>
</template>
<template v-else-if="props.column.field == 'clockInTime'">
    <template v-if="props.row.event == 'CLOCK_IN' || props.row.event == 'CLOCK_ADJ'">
        @{{ formatDateTime(props.row.clockInTime) }}
    </template>
    <template v-else-if="props.row.event == 'TIMER_START' || props.row.event == 'TIMER_ADJ'">
        @{{ formatDateTime(props.row.timerStart) }}
    </template>
    <template v-else-if="props.row.event == 'START_BREAK'">
        @{{ formatDateTime(props.row.breakStart) }}
    </template>
    <template v-else>
        &nbsp;
    </template>
</template>
<template v-else-if="props.column.field == 'clockOutTime'">
    <template v-if="props.row.event == 'CLOCK_IN' || props.row.event == 'CLOCK_ADJ'">
        @{{ formatDateTime(props.row.clockOutTime) }}
    </template>
    <template v-else-if="props.row.event == 'TIMER_START' || props.row.event == 'TIMER_ADJ'">
        @{{ formatDateTime(props.row.timerStop) }}
    </template>
    <template v-else-if="props.row.event == 'START_BREAK'">
        @{{ formatDateTime(props.row.breakStop) }}
    </template>
    <template v-else>
        &nbsp;
    </template>
</template>
<template v-else-if="props.column.field == 'attendanceSession'">
    <template v-if="props.row.event == 'CLOCK_IN' || props.row.event == 'CLOCK_ADJ'">
        @{{ props.row.attendanceSession }}
    </template>
    <template v-else-if="props.row.event == 'TIMER_START' || props.row.event == 'TIMER_ADJ'">
        @{{ props.row.timetrackSession }}
    </template>
    <template v-else-if="props.row.event == 'START_BREAK'">
        @{{ props.row.breakSession }}
    </template>
    <template v-else>
        &nbsp;
    </template>
</template>
<template v-else-if="props.column.field == 'clockSec'">
    <template v-if="props.row.event == 'CLOCK_IN' || props.row.event == 'CLOCK_ADJ'">
        @{{ moment.duration(parseInt(props.row.clockSec), 'seconds').format("h [hrs], m [min], s [sec]") }}
    </template>
    <template v-else-if="props.row.event == 'TIMER_START' || props.row.event == 'TIMER_ADJ'">
        @{{ moment.duration(parseInt(props.row.timerSec), 'seconds').format("h [hrs], m [min], s [sec]") }}
    </template>
    <template v-else-if="props.row.event == 'START_BREAK'">
        @{{ moment.duration(parseInt(props.row.breakSec), 'seconds').format("h [hrs], m [min], s [sec]") }}
    </template>
    <template v-else>
        &nbsp;
    </template>
</template>
<template v-else-if="props.column.field == 'breakSec'">
    <template v-if="props.row.event == 'START_BREAK'">
        @{{ moment.duration(parseInt(props.row.breakSec), 'seconds').format("h [hrs], m [min], s [sec]") }}
    </template>
    <template v-else>
        &nbsp;
    </template>
</template>
