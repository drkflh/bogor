<template>
    <div style="display: block;">
        <VueNestable
            v-model="tree"
            :max-depth="3"
            :hooks="{
                'beforeMove': beforeMove
              }"
            @change="onChange"
            key-prop="key"
            children-prop="children"
            class-prop="class"
        >
            <template slot-scope="{ item }">
                <!-- Handler -->
                    <VueNestableHandle :item="item" >
                        <div class="btn">
                            <i class="fas fa-arrows-alt"/>
                        </div>
                    </VueNestableHandle>

                    <!-- Content -->
                    <div class="content-block" style="display:table-cell" v-html="item.text" ></div>
            </template>
        </VueNestable>
    </div>
</template>

<script>
export default {
    name: "SimpleNestable",
    props: {
        tree : {
            type: [Array, Object],
            default: function(){
                return [
                    {
                        key: 1,
                        class: 'item-block section',
                        text: 'Section',
                        children: [{
                            key: 2,
                            class: 'item-block category',
                            text: 'Category',
                            children: [
                                {
                                    key: 3,
                                    class: 'item-block item',
                                    text: 'Item 1'
                                },
                                {
                                    key: 4,
                                    class: 'item-block item',
                                    text: '<h6>Title 2</h6><p>Looooong description</p>'
                                },
                            ]
                        }]
                    }
                ];
            }
        }
    },
    data() {
        return {
            nestableItems: [
                {
                    key: 0,
                    class: 'purple-text-color',
                    text: 'Andy'
                }, {
                    key: 1,
                    class: 'blue-text-color',
                    text: 'Harry',
                    children: [{
                        key: 2,
                        text: 'David'
                    }]
                }, {
                    key: 3,
                    class: 'red-text-color',
                    text: 'Lisa'
                }, {
                    key: 4,
                    text: 'I can not be nested'
                }
            ]
        }
    },
    methods: {
        onChange(){
            this.$emit('update:tree', this.tree);
        },
        beforeMove({dragItem, pathFrom, pathTo}) {
            // Item 4 can not be nested more than one level
            if (dragItem.key === 4) {
                return pathTo.length === 1
            }
            // All other items can be
            return true
        }
    }
}

</script>

<style scoped>
.nestable-handle{
    display: inline-block;
}
.content-block{
    display: inline-block;
}
.item-block {
    display: block;
    position: relative;
}
.section {
    color: #415ad4;
}
.category {
    color: #b43ceb;
}
.item {
    color: #e13a3a;
}
</style>
