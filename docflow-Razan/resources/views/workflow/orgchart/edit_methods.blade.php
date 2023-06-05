labelClassName: function(data) {
    return 'clickable-node'
},
renderContent: function(h, data) {
    return data.label
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
