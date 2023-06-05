<template>
    <div class="col-12">
        <draggable
                :list="list"
                :disabled="!enabled"
                class="list-group"
                ghost-class="ghost"
                :move="checkMove"
                @start="dragging = true"
                @end="dragging = false"
        >
            <div class="list-group-item"
                    v-for="element in list"
                    :key="element._id"
            >
                {{ element.name }}
                <span v-on:click="removeItem(element)"  style="cursor: pointer; padding: 8px;position: absolute; bottom: 2px;right: 2px;" class="pull-right" ><i class="las la-times-circle"></i></span>
            </div>
        </draggable>
    </div>
</template>

<script>
    export default {
        name: "SimpleSortableList",
        props: {
            list : {
                type: Array,
                default: function () {
                    return [];
                }
            }
        },
        data() {
            return {
                enabled: true,
                dragging: false
            };
        },
        methods: {
            checkMove: function(e) {
                window.console.log("Future index: " + e.draggedContext.futureIndex);
            },
            removeItem(obj){
                var index = this.list.indexOf(obj);
                this.list.splice(index, 1);
            },
        }
    }
</script>

<style scoped>
    .buttons {
        margin-top: 35px;
    }
    .ghost {
        opacity: 0.5;
        background: #c8ebfb;
    }
    .list-group-item{
        overflow-wrap: break-word;
    }

</style>
