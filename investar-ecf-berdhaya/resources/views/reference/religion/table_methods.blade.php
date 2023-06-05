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
