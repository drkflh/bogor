console.log(data);
if( data.docStatus == 'DRAFT' || data.docStatus == 'APPROVED' ){
    this.lock = false;
}else{
    this.lock = true;
}
