title: function(val){
    this.slug = val.replace(/^\s+|\s+$|\s+(?=\s)/g, '').replace(/[^\w\s]/gi, '').split(' ').join('-').toLowerCase();
},
docUpload: function(val){
    console.log('up', val);
    this.docList.push(val);
},
