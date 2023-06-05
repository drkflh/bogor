<template v-else-if="props.column.field == 'answer1'">
    @{{ props.row.answer1 == '' ? '&nbsp;' : props.row.answer1 }}<br>
    @{{ props.row.score1 == '' || props.row.score1 == 0 ? '&nbsp;' : props.row.score1 }}
</template>
<template v-else-if="props.column.field == 'answer2'">
    @{{ props.row.answer2 == '' ? '&nbsp;' : props.row.answer2 }}<br>
    @{{ props.row.score2 == '' || props.row.score2 == 0 ? '&nbsp;' : props.row.score2 }}
</template>
<template v-else-if="props.column.field == 'answer3'">
    @{{ props.row.answer3 == '' ? '&nbsp;' : props.row.answer3 }}<br>
    @{{ props.row.score3 == '' || props.row.score3 == 0 ? '&nbsp;' : props.row.score3 }}
</template>
<template v-else-if="props.column.field == 'answer4'">
    @{{ props.row.answer4 == '' ? '&nbsp;' : props.row.answer4 }}<br>
    @{{ props.row.score4 == '' || props.row.score4 == 0 ? '&nbsp;' : props.row.score4 }}
</template>
<template v-else-if="props.column.field == 'answer5'">
    @{{ props.row.answer5 == '' ? '&nbsp;' : props.row.answer5 }}<br>
    @{{ props.row.score5 == '' || props.row.score5 == 0 ? '&nbsp;' : props.row.score5 }}
</template>
<template v-else-if="props.column.field == 'defaultAnswer'">
    @{{ props.row.defaultAnswer == '' ? '&nbsp;' : props.row.defaultAnswer }}<br>
    @{{ props.row.defaultScore == '' || props.row.defaultScore == 0 ? '&nbsp;' : props.row.defaultScore }}
</template>

