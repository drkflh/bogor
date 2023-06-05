bidDocFormChange(val){
    console.log('biddocitem',val.DocType);

    var topics = _.get( this.docCategoryMap, 'Bid Documents' );

    this.$refs.bidDocumentRef.editObj.Topic = topics[ val.DocType ]['Topic'] ;
    this.$refs.bidDocumentRef.dmsDoc.Topic = topics[ val.DocType ]['Topic'] ;
    this.$refs.bidDocumentRef.dmsDefault.Topic = topics[ val.DocType ]['Topic'] ;

    this.$refs.bidDocumentRef.editObj.TopicObject = this.docTopicMap[this.$refs.bidDocumentRef.editObj.Topic] ;
    this.$refs.bidDocumentRef.dmsDoc.TopicObject = this.docTopicMap[ this.$refs.bidDocumentRef.dmsDoc.Topic] ;
    this.$refs.bidDocumentRef.dmsDefault.TopicObject = this.docTopicMap[ this.$refs.bidDocumentRef.dmsDefault.Topic ] ;
},
principalFormChange(val){
    console.log('principalitem',val.quotationCategory);
    var topics = _.get( this.docCategoryMap, 'Principal Terms' );
    this.$refs.principalTermsRef.editObj.quotationTopic = topics[ val.quotationCategory ]['Topic'] ;
},
commercialFormChange(val){
    console.log('commercialitem',val.DocType);
    var topics = _.get( this.docCategoryMap, 'Commercial' );
    this.$refs.commercialRef.editObj.Topic = topics[ val.DocType ]['Topic'] ;
},
bidDocItemChange(val){
    console.log('biddocform',val);
},
principalItemChange(val){
    console.log('biddocform',val);
},
commercialItemChange(val){
    console.log('biddocform',val);
},
attachDoc(){
    alert('attach doc');
},

maxToday(date){
    const today = new Date();
    return date > today;
},
maxTodayNotBefore(date){
    const today = new Date();
    const before = new Date(this.DocDate);

    console.log( date, today, before);

    return before > date || date > today;
},
setProvince(val) {
  console.log(val)
  this.provinceName =  val.value.text
  this.spinner = true
  axios.post( '{{ url('sms/reference/city') }}',{provinceName:val.value.value})
    .then(response => {
      console.log(response.data);
      if(response.status === 200){
        if(response.data.data.length>0) {
          let city = []
          response.data.data.map((item) => {
            city.push({
              text: item.cityName,
              value: item
            })
          })
      this.cityNameOptions = city
      }
  }
  this.spinner = false
})
    .catch(function(error) {
    console.log(error);
  });
},
setCity(val) {
  console.log(val)
  this.cityName =  val.value.text
},
getJobCode(){
    if( !_.isEmpty(this.setStatus) && !_.isEmpty(this.setCompany) && !_.isEmpty(this.setArea) && !_.isEmpty(this.inquiryDateYY)   ){

        this.jobNoPrefix = this.setStatus + this.setCompany + this.setArea + this.inquiryDateYY;

        if( !_.isEmpty(this.Urut) ){
            this.jobNo = this.jobNoPrefix + this.Urut;
        }else{
            console.log("error", this.jobNoPrefix );
        }

    }else{
        console.log("error");
    }
},
getJRSequence(){

    var entity = this.jobNoPrefix;
    var company = this.area + this.status + this.participatingCompany + this.inquiryDate;

    axios.post( '{{ url('sms/sales-operation/job-register/get-seq') }}' , { entity: entity, padding: 3, company: company } )
    .then(response => {
        console.log(response.data);
        if(response.data.result == 'OK'){
            var seq = response.data.padded;
            this.Urut = seq;
            this.getJobCode();
        }
    })
    .catch(function(error) {
        console.log(error);
    });
},

{{--setArea(){--}}
{{--    var str = this.area;--}}
{{--    if (str == "Jakarta"){--}}
{{--        str = str[0].substring(0,1).toUpperCase();--}}
{{--    }--}}
{{--    if (str == "Balikpapan"){--}}
{{--        str = str[0].substring(0,1).toUpperCase();--}}
{{--    }--}}
{{--},--}}

{{--getArea(){--}}
{{--    let str = this.area;--}}
{{--    if(str == "Jakarta"){--}}
{{--        str = str.charAt(0);--}}
{{--    }--}}
{{--    if (str == "Balikpapan"){--}}
{{--        str = str.charAt(0);--}}
{{--    }--}}
{{--},--}}
