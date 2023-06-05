docTypeName: function(val){
    this.docType = val.replace(/^\s+|\s+$|\s+(?=\s)/g, '').replace(/[^\w\s]/gi, '').split(' ').join('-').toLowerCase();
},
