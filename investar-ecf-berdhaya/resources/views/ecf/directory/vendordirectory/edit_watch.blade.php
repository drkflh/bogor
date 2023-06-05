companyProfileUrl: function(val){
    console.log('company url', val);
    if(_.isEmpty(val)){
        this.companyProfileUrlTemplate = '<span>Company Profile |</span>';
    }else{
        this.companyProfileUrlTemplate = '<span><i class="far fa-file-alt" ></i> Company Profile</span>';
    }
},
mediaUrlCatalog: function(val){
    console.log('company url', val);
    if(_.isEmpty(val)){
        this.mediaUrlCatalogTemplate = '<span>Catalogue</span>';
    }else{
        this.mediaUrlCatalogTemplate = '<span><i class="far fa-file-alt" ></i> Catalogue</span>';
    }
},
taxIdNpwp: function(val){
    console.log('company url', val);
    if(_.isEmpty(val)){
        this.taxIdNpwpTemplate = '<span>Tax ID(NPWP)</span>';
    }else{
        this.taxIdNpwpTemplate = '<span><i class="far fa-file-alt" ></i> Tax ID(NPWP)</span>';
    }
},
