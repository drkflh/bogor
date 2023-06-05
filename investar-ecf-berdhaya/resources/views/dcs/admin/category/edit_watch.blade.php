{{--categoryName: function(val){--}}
{{--    this.categoryCode = val.replace(/^\s+|\s+$|\s+(?=\s)/g, '').replace(/[^\w\s]/gi, '').split(' ').join('-').toLowerCase();--}}
{{--},--}}
sectionObject: function(val){
    this.sectionCode = val.sectionCode;
    this.menuAuth = 'dcs-' + this.sectionCode + '-' + val;
},
categoryName: function(val){
    this.menuTitle = val;
},
categoryCode: function(val){
    this.menuAuth = 'dcs-' + this.sectionCode + '-' + val;
},
