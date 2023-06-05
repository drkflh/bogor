<template v-else-if="props.column.field == 'name'">
  @{{ props.row.name }}<hr>
  @{{ props.row.noNpwp }}
</template>
