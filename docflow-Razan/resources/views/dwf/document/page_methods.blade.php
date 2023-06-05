docNumber(){
    var docNo = '';
    if(this.formTemplate == 'surat-dinas'){
        docNo = 'APL.' + this.docStatus + '/' + this.docClass  + '/' + this.docYear  + '/' + this.titleCode.jobCode + '-' + this.confidentiality ;
    }

    if(this.formTemplate == 'nota-dinas'){
        docNo = this.titleCode.jobCode + '.' +this.docStatus + '/' + this.docClass  + '/' + this.docYear  + '-' + this.confidentiality ;
    }

    this.docNo = docNo;
},
