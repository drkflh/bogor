docNumber(){
    var docNo = '';
    if(this.formTemplate == 'surat-dinas'){
        docNo = 'APL.' + this.docStatus + '/' + this.docClass  + '/' + this.docYear  + '/' + this.titleCode.jobCode + '-' + this.confidentiality ;
    }

    if(this.formTemplate == 'nota-dinas'){
        docNo = this.titleCode.jobCode + '.' +this.docStatus + '/' + this.docClass  + '/' + this.docYear  + '-' + this.confidentiality ;
    }

    if(this.formTemplate == 'lembar-disposisi'){
        docNo =  this.titleCode.jobCode + '.' + this.docStatus;
    }

    if(this.formTemplate == 'memo-internal'){
        docNo = 'MI.' + this.docStatus + '/' + this.titleCode.jobCode ;
    }

    console.log(docNo);

    this.docNo = docNo;
},
