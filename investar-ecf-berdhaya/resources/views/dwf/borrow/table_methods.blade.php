printLabelContent(){
    this.$htmlToPaper('printedLabelContent');
},
showPrintLabelModal(data){
    console.log(data);
    this.printLabelData = data.FCallCode;
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




setBox(){
    console.log(this.selectedSheets);
    if(this.selectedSheets == 0 ){
        alert('Please select Document(s) to be boxed');
    }else{
        this.$bvModal.show('boxIdModal');
    }
},
setBoxId(){
    var sels = this.$refs['vgt-table'].selectedRows;
    var postObj = { selected : sels, boxId : this.boxIdInput };
    console.log(postObj);

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
}
