jobObject: function(val){
    this.jobTitle = val.jobTitle;
    this.jobTitleCode = val.jobCode;
    this.jobTitleSeq = val.seq;
    this.jobGroup = val.subGroup;
    this.jobGroupSeq = val.seq;
},
bizUnit: function(val){
    this.bizUnitId = _.get(val, '_id');
    this.bizUnitName = _.get(val, 'farmName');
},
kabupaten: function(val){
    let kab = _.get( this.kabupatenObjectMap, val );
    this.kabupatenObject = kab;
    this.kabupatenCode = _.get( kab , 'kabupatenCode' );
    this.province = _.get( kab , 'provinceName' );
    this.provinceCode = _.get( kab , 'provinceCode' );
},
relativeKabupaten: function(val){
    let kab = _.get( this.kabupatenObjectMap, val );
    this.relativeKabupatenObject = kab;
    this.relativeKabupatenCode = _.get( kab , 'kabupatenCode' );
    this.relativeProvince = _.get( kab , 'provinceName' );
    this.relativeProvinceCode = _.get( kab , 'provinceCode' );
},
dateOfBirth : function(val){
    this.getAgeStatus(); 
},
