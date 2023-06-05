<template>
    <div :style="{'min-height': height+'px'}">
        <div class="tabs">
            <div class="tabHeader">
                <div class="list">
                    <div class="item" v-for="(item, index) in header" :key="'tabIndex+'+index" :class="tabIndex===index?'active':''" @click="onTab(index)">{{item}}</div>
                </div>
            </div>
        </div>
        <div class="tabBody">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Tab",
        props: {
            header: {
                type: Array
            },
            height: {
                type: Number,
                default: 500
            }
        },
        data() {
            return {
                tabIndex: 0
            }
        },
        created() {
            this.$emit('tab-index', this.tabIndex)
        },
        methods: {
            onTab(index) {
                this.tabIndex = index
            }
        },
        watch: {
            tabIndex(val) {
                this.$emit('tab-index', val)
            }
        }
    }
</script>

<style scoped>
.tabHeader {
    position: relative;
    background-color: #f2f2f2;
}
.tabHeader .list {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    padding: 10px 10px 0 10px;
}
.tabHeader .list .item {
    padding: 10px 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}
.tabHeader .list .item.active {
    background-color: #fff;
}
.tabBody {
    margin-top: 20px;
    padding: 0 15px;
}
</style>
