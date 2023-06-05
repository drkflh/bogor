docNumber(){
    var docNo = this.docNo;
    if(this.formTemplate == 'surat-dinas'){
        var dr = docNo.split('/');
        dr[1] = this.docClass;
        dr[2] = this.docYear;

        var dr2 = dr[0].split('-');
        dr2[0] = this.titleCode.jobCode;
        dr2[1] = this.confidentiality;
        dr[3] = dr2.join('-');

        docNo = dr.join('/');
        //docNo = 'APL.' + this.docStatus + '/' + this.docClass  + '/' + this.docYear  + '/' + this.titleCode.jobCode + '-' + this.confidentiality ;
    }

    if(this.formTemplate == 'nota-dinas'){
        var dr = docNo.split('/');

        var dr2 = dr[0].split('.');
        dr2[0] = this.titleCode.jobCode ;

        dr[0] = dr2.join('.');
        dr[1] = this.docClass;
        dr[2] = this.docYear + '-' + this.confidentiality;

        docNo = dr.join('/');
        //docNo = this.titleCode.jobCode + '.' +this.docStatus + '/' + this.docClass  + '/' + this.docYear  + '-' + this.confidentiality ;
    }

    if(this.formTemplate == 'lembar-disposisi'){
        var dr = docNo.split('.');
        dr[0] = this.titleCode.jobCode ;
        docNo = dr.join('.');
        //docNo =  this.titleCode.jobCode + '.' + this.docStatus;
    }

    if(this.formTemplate == 'memo-internal'){
        var dr = docNo.split('/');
        dr[1] = this.titleCode.jobCode ;
        docNo = dr.join('/');
        //docNo = 'MI.' + this.docStatus + '/' + this.titleCode.jobCode ;
    }

    console.log(docNo);

    this.docNo = docNo;
},
