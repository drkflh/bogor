createCallCode(){
    if( this.groupCode != '' && this.subGroupCode != '' && this.docTypeCode != '' && this.locationCode != ''){
        this.callCode = this.groupCode + '-' + this.subGroupCode + '-' + this.docTypeCode + '-' + this.locationCode;
        this.menuAuth = 'dwf-archive-' + this.callCode;
    }
},
