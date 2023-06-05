bidStatusChangeHidden(){
    console.log('campaign hidden');
    this.selectedRow = {};
    bus.$emit('refreshTable');
},
bidStatusChangeShown(event){
    console.log('bid shown', event);
    var row = this.selectedRow;
    var aux = { id : row._id, field: 'bidStatus' };
    var edit = {
        changeDate : '{{ date('Y-m-d H:i:s', time()) }}',
        changeBy : '{{ \Illuminate\Support\Facades\Auth::user()->name }}',
        currentStatus : row.bidStatus,
        changeStatusTo : row.bidStatus,
        changeRemarks: row.bidStatusRemarks
    };
    this.$refs.changeBidStatusModal.setTitleData( row.id );
    this.$refs.changeBidStatusModal.setData( edit );
    this.$refs.changeBidStatusModal.setAuxData(aux);

},
changeBidStatus(row){
    this.selectedRow = row;
    this.$refs.changeBidStatusModal.openModal();
},

jobStatusChangeHidden(){
    console.log('campaign hidden');
    this.selectedRow = {};
    bus.$emit('refreshTable');
},
jobStatusChangeShown(){
    console.log('job shown', event);
    var row = this.selectedRow;
    var aux = { id : row._id, field: 'jobStatus' };
    var edit = {
        changeDate : '{{ date('Y-m-d H:i:s', time()) }}',
        changeBy : '{{ \Illuminate\Support\Facades\Auth::user()->name }}',
        currentStatus : row.jobStatus,
        changeStatusTo : row.jobStatus,
        changeRemarks: row.jobStatusRemarks
    };
    this.$refs.changeJobStatusModal.setTitleData( row.id );
    this.$refs.changeJobStatusModal.setData( edit );
    this.$refs.changeJobStatusModal.setAuxData(aux);
},
changeJobStatus(row){
    this.selectedRow = row;
    this.$refs.changeJobStatusModal.openModal();
},

jobRemarkChangeHidden(){
    console.log('campaign hidden');
    this.selectedRow = {};
    bus.$emit('refreshTable');
},
jobRemarkChangeShown(){
    console.log('job shown', event);
    var row = this.selectedRow;
    var aux = { id : row._id, field: 'jobRemark' };
    var edit = {
        changeDate : '{{ date('Y-m-d H:i:s', time()) }}',
        changeBy : '{{ \Illuminate\Support\Facades\Auth::user()->name }}',
        currentStatus : row.jobRemark,
        changeStatusTo : row.jobRemark,
        changeRemarks: row.jobRemark
    };
    this.$refs.changeJobRemarkModal.setTitleData( row.id );
    this.$refs.changeJobRemarkModal.setData( edit );
    this.$refs.changeJobRemarkModal.setAuxData(aux);
},
changeJobRemark(row){
    this.selectedRow = row;
    this.$refs.changeJobRemarkModal.openModal();
},
logModalTitle(title){
    return this.docHistoryTitle;
},
openLogModal(row, status = 'all') {
    axios.post( '{{ url('sms/sales-operation/job-register/history') }}' , {
        itemId : row._id,
        status : status
    } )
    .then(response => {
        console.log(response.data);
        if(response.data.result == 'OK'){
            this.docHistory = response.data.data;
            this.docHistoryTitle = row.jobNo;
        }
    })
    .catch(function(error) {
        console.log(error);
    });

    this.$bvModal.show('historyLogModal');
},
hideLogModal() {
    this.$bvModal.hide('historyLogModal');
},
logModalShown(){

},
logModalHidden(){
    this.docHistory = [];
},

enableJobButton(row){
    if( row.bidStatus == 'Awarded' || row.bidStatus == 'Not Awarded' || row.bidStatus == 'Fail'|| row.bidStatus == 'Closed'|| row.bidStatus == 'Decline'|| row.bidStatus == 'Cancelled' ){
        return true;
    }
    return false;
},

attachDoc(){
    alert('attach doc');
},
