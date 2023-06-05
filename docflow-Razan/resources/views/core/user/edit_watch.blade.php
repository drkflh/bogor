province: function(val){
    this.setProvince(val);
},
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
