printLabelContent(){
    this.$htmlToPaper('printedLabelContent');
},
showPrintLabelModal(data){
    console.log(data);
    this.printLabelData = data.FCallCode;
    this.$bvModal.show('printLabelModal');
},

showPrintBoxTagModal(data){
    var payload = {
        ns: 'box-tag',
        obj: [data],
        multi: false,
        modalClass: '',
        modalSize: '',
        showSelect: false,
        defaultTemplate: 'document-qr-tag'
    };
    //console.log(data);
    bus.$emit('printitem', payload );
},

showPrintBoxLabelModal(data){
    console.log(data);
    this.printLabelData = data.FCallCode;
    this.$bvModal.show('printLabelModal');
},

notifyHasExpired(row){
    if(!_.isEmpty(row.ExpDate)){
        var exp = moment(row.ExpDate);
        return  moment().isSameOrAfter(exp, 'days');
    }else{
        return false;
    }
},
notifyWillExpire(row){
    if(!_.isEmpty(row.ExpDate)){
        var exp = moment(row.ExpDate);
        var will = moment(row.ExpDate).subtract(30, 'days');
        return moment().isSameOrAfter(will, 'days') && moment().isBefore(exp, 'days')  ;
    }else{
        return false;
    }
},
notifyCanExpire(row){
    if(!_.isEmpty(row.ExpDate)){
        var exp = moment(row.ExpDate);
        var will = moment(row.ExpDate).subtract(31, 'days');
        return moment().isBefore(will, 'days')  ;
    }else{
        return false;
    }
},
setBox(){
    console.log(this.selectedSheets);
    if(this.selectedSheets == 0 ){
        alert('Please select Document(s) to be boxed');
    }else{
        this.$bvModal.show('boxIdModal');
    }
},

setBoxId(bvModalEvt){

    bvModalEvt.preventDefault()
    var sels = this.$refs['vgt-table'].selectedRows;
    var postObj = { selected : sels, boxId : this.boxIdInput };
    console.log(postObj);

    axios.post( '{{ url('dms/dispatch/setbox') }}' , postObj )
        .then(response => {
            console.log(response.data);
            if(response.data.result == 'OK'){
                this.boxIdInput = '';
                this.$bvModal.hide('boxIdModal');
            }
        })
        .catch(function(error) {
            alert(error);
        });


},

openScanner(){
    this.$bvModal.show('scanLinkModal');
},

scanDirectory(bvModalEvt){

    bvModalEvt.preventDefault();

    var postObj = { sourceDir : this.sourceDir, scanMode : this.scanMode };

    this.scanning = true;
    axios.post( '{{ url('dms/repository/scanlink') }}' , postObj )
        .then(response => {
            console.log(response.data);
            if(response.data.result == 'OK'){
                this.$bvModal.hide('scanLinkModal');
                this.scanning = false;
            }
        })
        .catch(function(error) {
            this.scanning = false;
            alert(error);
        });


},

