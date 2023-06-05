printLabelContent(){
    this.$htmlToPaper('printedLabelContent');
},
showPrintLabelModal(data){
    console.log(data);
    this.printLabelData = data.FCallCode;
    this.$bvModal.show('printLabelModal');
},
