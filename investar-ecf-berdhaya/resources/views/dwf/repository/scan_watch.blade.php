docUpload: function(val){
    console.log('up', val);
    this.docList.push(val);
},
scanResult: function(val){
    console.log('doc', this.scanResult);
    var doc = _.get(this.scanResult, 'name');
    console.log('docurl', doc);
    this.docList.splice( this.docList.indexOf(doc), 1);
    this.docViewer = _.head(this.docList);
    console.log(this.docList);
},
