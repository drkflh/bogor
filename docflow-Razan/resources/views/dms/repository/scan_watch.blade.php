docUpload: function(val){
    console.log('up', val);
    this.docList.push(val);
},
scanResult: function(val){
    console.log('doc', this.scanResult);
    var doc = _.get(this.scanResult, 'name');
    console.log('docurl', doc);

    var docIndex = _.findIndex(this.docUploadObjects, (o) => { return o.url == doc; });
    console.log( 'docIndex', docIndex);
    this.docUploadObjects.splice( docIndex, 1);

    this.docUpload.splice( this.docUpload.indexOf(doc), 1);
    this.docViewer = _.head(this.docUpload);
    console.log(this.docList);
},
