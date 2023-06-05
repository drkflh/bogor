bidDocFormChange(val){
    console.log('biddocitem',val.DocType);
    var topics = _.get( this.docCategoryMap, 'Bid Documents' );
    this.$refs.bidDocumentRef.editObj.Topic = topics[ val.DocType ]['Topic'] ;
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

bidStatusChangeHidden(event){
    console.log('bid status hidden', event);
    this.bidStatus = this.bidStatusObject.changeStatusTo;
    this.bidStatusRemarks = this.bidStatusObject.changeRemarks;
},
bidStatusChangeShown(event){
    console.log('bid shown', event);
    var aux = { id : this.itemId, field: 'bidStatus' };
    var edit = {
        changeDate : '{{ date('Y-m-d H:i:s', time()) }}',
        changeBy : '{{ \Illuminate\Support\Facades\Auth::user()->name }}',
        currentStatus : this.bidStatus,
        changeStatusTo : this.bidStatus
    };
    this.$refs.changeBidStatusModal.setTitleData( this.jobNo );
    this.$refs.changeBidStatusModal.setData( edit );
    this.$refs.changeBidStatusModal.setAuxData(aux);

},

jobStatusChangeHidden(event){
    console.log('campaign hidden', event);
    this.jobStatus = this.jobStatusObject.changeStatusTo;
    this.jobStatusRemarks = this.jobStatusObject.changeRemarks;

},
jobStatusChangeShown(){
    console.log('job shown', event);
    var row = this.selectedRow;
    var aux = { id : this.itemId, field: 'jobStatus' };
    var edit = {
        changeDate : '{{ date('Y-m-d H:i:s', time()) }}',
        changeBy : '{{ \Illuminate\Support\Facades\Auth::user()->name }}',
        currentStatus : this.jobStatus,
        changeStatusTo : this.jobStatus
    };
    this.$refs.changeJobStatusModal.setTitleData( this.jobNo );
    this.$refs.changeJobStatusModal.setData( edit );
    this.$refs.changeJobStatusModal.setAuxData(aux);
},

attachDoc(){
    alert('attach doc');
},

maxToday(date){
    const today = new Date();
    return date > today;
},
getJobCode(){
    if( !_.isEmpty(this.setStatus) && !_.isEmpty(this.participatingCompany) && !_.isEmpty(this.setArea) && !_.isEmpty(this.inquiryDateYY)   ){

        this.jobNoPrefix = this.setStatus + this.participatingCompany + this.setArea + this.inquiryDateYY;

        if( !_.isEmpty(this.Urut) ){
            this.jobNo = this.jobNoPrefix + this.Urut;
        }
    } else {
         alert("Data harus diisi");
    }
},
getJRSequence(){

    var entity = this.jobNoPrefix;

    axios.post( '{{ url('sms/sales-operation/job-register/get-seq') }}' , { entity: entity, padding: 3 } )
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

