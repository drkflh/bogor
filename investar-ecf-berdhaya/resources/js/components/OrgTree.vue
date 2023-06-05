<template>
<div>
    <vue2-org-tree
        :data="treeData"
        :horizontal="horizontal"
        :collapsable="collapsable"
        :label-class-name="labelClassName"
        :render-content="renderContent"
        selected-class-name="bg-tomato"
        selected-key="selectedKey"
        @on-expand="onExpand"
        @on-node-click="onNodeClick"
    />
</div>
</template>

<script>
export default {
    name: "OrgTree",
    props:{
        treeData: {
            type: [Array, Object],
            default: function(){
                return {};
            }
        },
        expandAll: {
            type: Boolean,
            default: false
        },
        horizontal:{
            type: Boolean,
            default: false
        },
        collapsable: {
            type: Boolean,
            default: true
        }
    },
    data () {
        return {};
    },
    created() {

    },
    watch: {

    },
    methods: {
        labelClassName: function(data) {
            return 'clickable-node'
        },
        renderContent: function(h, data) {
            console.log(h, data);
            if(_.isUndefined(data.subTitle)){
                return data.label;
            }else{
                return data.label + '<hr>' + data.subTitle;
            }
        },
        onExpand: function(e, data) {
            if ('expand' in data) {
                data.expand = !data.expand

                if (!data.expand && data.children) {
                    this.collapse(data.children)
                }
            } else {
                this.$set(data, 'expand', true)
            }
        },
        onNodeClick: function(e, data) {
            console.log('onNodeClick: %o', data)
            this.$set(data, 'selectedKey', !data.selectedKey)
        },
        collapse: function(list) {
            var _this = this
            list.forEach(function(child) {
                if (child.expand) {
                    child.expand = false
                }
                child.children && _this.collapse(child.children)
            })
        },
        expandChange: function() {
            this.toggleExpand(this.data, this.expandAll)
        },
        toggleExpand: function(data, val) {
            var _this = this
            if (Array.isArray(data)) {
                data.forEach(function(item){
                    _this.$set(item, 'expand', val)
                    if (item.children) {
                        _this.toggleExpand(item.children, val)
                    }
                })
            } else {
                this.$set(data, 'expand', val)
                if (data.children) {
                    _this.toggleExpand(data.children, val)
                }
            }
        }

    }
}
</script>

<style scoped>

</style>
