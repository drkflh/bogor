gatewayName: function(val){
    this.gatewaySlug = val.replace(/^\s+|\s+$|\s+(?=\s)/g, '').replace(/[^\w\s]/gi, '').split(' ').join('-').toLowerCase();
}
