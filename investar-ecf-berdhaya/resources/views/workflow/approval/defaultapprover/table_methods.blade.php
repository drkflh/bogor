printLabelContent(){
    this.$htmlToPaper('printedLabelContent');
},
showPrintLabelModal(data){
    console.log(data);
    this.printLabelData = data;
    this.$bvModal.show('printLabelModal');
},

showPrintBoxTagModal(data){
    console.log(data);
    this.printLabelData = data.FCallCode;
    this.$bvModal.show('printLabelModal');
},

showPrintBoxLabelModal(data){
    console.log(data);
    this.printLabelData = data.FCallCode;
    this.$bvModal.show('printLabelModal');
},

quickEnroll(){
    this.$bvModal.show('quickEnrollModal');
},
setBoxId(){
    {{--var sels = this.$refs['vgt-table'].selectedRows;--}}
    {{--var postObj = { selected : sels, boxId : this.boxIdInput };--}}
    {{--console.log(postObj);--}}

},
onSelectionChanged(sel){
    console.log(sel);
    if(_.isEmpty(sel)){
        this.selectedSheets = 0;

    }else{
        var cnt = 0;
        _.forEach(sel.selectedRows, (val)=>{
        cnt = cnt + parseInt(val['NoSheet']);
        });

        this.selectedSheets = cnt;

    }
},
doQuickEnroll(){

    var member = {
        firstName: this.firstName,
        lastName: this.lastName,
        mobile: this.mobile,
        email: this.email,
        enrollmentType: 'QUICK'
    };


    axios.post( '{{ url('loyalty/member/quickadd') }}' , member )
        .then(response => {
            console.log(response.data);
            if(response.data.result == 'OK'){
                this.$bvModal.hide('quickEnrollModal');
                tvm.fetchData();
            }
        })
        .catch(function(error) {
            console.log(error);
        });


}
