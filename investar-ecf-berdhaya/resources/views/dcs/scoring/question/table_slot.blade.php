<template v-else-if="props.column.field == 'answer1'">
    @{{ props.row.answer1 == '' ? '&nbsp;' : props.row.answer1 }}<br>
    @{{ _.get(props.row , 'score1', '' ) }}
</template>
<template v-else-if="props.column.field == 'answer2'">
    @{{ props.row.answer2 == '' ? '&nbsp;' : props.row.answer2 }}<br>
    @{{ _.get(props.row , 'score2', '' ) }}
</template>
<template v-else-if="props.column.field == 'answer3'">
    @{{ props.row.answer3 == '' ? '&nbsp;' : props.row.answer3 }}<br>
    @{{ _.get(props.row , 'score3', '' ) }}
</template>
<template v-else-if="props.column.field == 'answer4'">
    @{{ props.row.answer4 == '' ? '&nbsp;' : props.row.answer4 }}<br>
    @{{ _.get(props.row , 'score4', '' ) }}
</template>
<template v-else-if="props.column.field == 'answer5'">
    @{{ props.row.answer5 == '' ? '&nbsp;' : props.row.answer5 }}<br>
    @{{ _.get(props.row , 'score5', '' ) }}
</template>
<template v-else-if="props.column.field == 'defaultAnswer'">
    @{{ props.row.defaultAnswer == '' ? '&nbsp;' : props.row.defaultAnswer }}<br>
    @{{ _.get(props.row, 'defaultScore', '' ) }}
</template>

