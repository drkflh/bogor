DocDate : function(val){
    this.RetDate = moment(val).add(parseInt(this.RetPer), 'y').format('YYYY-MM-DD HH:mm:ss');
    this.DispDate = moment(val).add(parseInt(this.DispPer), 'y').format('YYYY-MM-DD HH:mm:ss');
    this.MMYY = moment(val).format('MMYY');
    this.getCallCode();
},
RetPer : function(val){
    console.log(val, this.DocDate);
    this.RetDate = moment(this.DocDate).add(parseInt(val), 'y').format('YYYY-MM-DD HH:mm:ss');

},
DispPer : function(val){
    this.DispDate = moment(this.DocDate).add(parseInt(val), 'y').format('YYYY-MM-DD HH:mm:ss');
},

Coy : function(val){
    this.CoyCode = val;
},
CoyCode : function(val){
    this.getCallCode();
},

Topic : function(val){
    this.getCallCode();
},
Feature : function(val){
    this.getCallCode();
},
MMYY : function(val){
    this.getCallCode();
},
coyName: function(val){
    this.setVendorPrefix();
},
companyProfileUrl: function(val){
    console.log('company url', val);
    if(_.isEmpty(val) || val == ''){
        this.companyProfileUrlTemplate = '<span>Company Profile |</span>';
    }else{
        this.companyProfileUrlTemplate = '<span><i class="far fa-file-alt" ></i> Company Profile</span>';
    }
},
mediaUrlCatalog: function(val){
    console.log('company url', val);
    if(_.isEmpty(val) || val == ''){
        this.mediaUrlCatalogTemplate = '<span>Catalogue</span>';
    }else{
        this.mediaUrlCatalogTemplate = '<span><i class="far fa-file-alt" ></i> Catalogue</span>';
    }
},
taxIdNpwp: function(val){
    console.log('company url', val);
    if(_.isEmpty(val) || val == ''){
        this.taxIdNpwpTemplate = '<span>Tax ID(NPWP)</span>';
    }else{
        this.taxIdNpwpTemplate = '<span><i class="far fa-file-alt" ></i> Tax ID(NPWP)</span>';
    }
},
