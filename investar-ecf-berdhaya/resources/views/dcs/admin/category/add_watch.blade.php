categoryName: function(val){
    this.categoryCode = val.replace(/^\s+|\s+$|\s+(?=\s)/g, '').replace(/[^\w\s]/gi, '').split(' ').join('-').toLowerCase();
    this.menuTitle = val;
},
sectionObject: function(val){
    this.sectionCode = _.get(val, 'sectionCode');
    this.menuAuth = 'dcs-' + this.sectionCode + '-' + val;
},
categoryCode: function(val){
    this.menuAuth = 'dcs-' + this.sectionCode + '-' + val;
},
