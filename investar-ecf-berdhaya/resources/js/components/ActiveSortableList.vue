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
                <template
                    v-if="itemTemplate == '' "
                >
                    <div @click="onItemClick(element)" >
                        {{ element.name }}
                        <span v-on:click="removeItem(element)"  style="cursor: pointer; padding: 8px;position: absolute; bottom: 2px;right: 2px;" class="pull-right" ><i class="las la-times-circle"></i></span>
                    </div>
                </template>
                <template
                    v-else
                >
                <div style="position: relative;">
                    <div style="display: block;">
                        <active-form
                            :template="itemTemplate"
                            :value="element"
                            :params="params"
                            :objectDefault="objectDefault"
                            @click="onItemClick(element)"
                        >
                        </active-form>
                    </div>
                    <div style="height:fit-content;display:block;width: 100%;">
                        <button
                                v-on:click="doCopy(element)"
                                class="btn btn-icon pull-right"
                                style="color: green;cursor: pointer; padding: 8px;" >
                            <i class="las la-copy"></i>
                        </button>
                        <button v-on:click="removeItem(element)"
                                style="color:red; cursor: pointer; padding: 8px;float-right;" class="btn btn-icon pull-right" >
                            <i class="las la-times-circle"></i>
                        </button>
                    </div>
                </div>
                </template>
            </div>
        </draggable>
    </div>
</template>

<script>
    export default {
        name: "ActiveSortableList",
        props: {
            list : {
                type: Array,
                default: function () {
                    return [];
                }
            },
            itemTemplate: {
                type: [String, Object],
                default: function () {
                    return ''
                }
            },
            params: {
                type: [String, Object, Array]
            },
            objectDefault: {
                type: [String, Object, Array],
                default: function () {
                    return {}
                }
            },
            clicked: {
                type: [String, Object, Array]
            }
        },
        data() {
            return {
                enabled: true,
                dragging: false,
                copyData: ''
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
            onItemClick(item){
                console.log('item', item);
                this.$emit('update:clicked', item );
            },
            doCopy(value){
                console.log(value);
                this.copyData = value;

                bus.$emit('copyToClipboard', value);

            }
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
