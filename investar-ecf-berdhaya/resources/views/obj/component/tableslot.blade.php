<template slot="avatar" slot-scope="props">
    <img v-bind:src="imageUrl(props.row.avatar)" class="img-thumbnail" style="width: 150px;">
</template>
<template slot="photofiles" slot-scope="props">
    <img v-for="img in props.row.photofiles" v-bind:src="imageUrl(img)" class="img-thumbnail" style="width: 35px;">
</template>


