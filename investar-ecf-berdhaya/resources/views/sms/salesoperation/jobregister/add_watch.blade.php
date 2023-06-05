bidDocument: {
    deep: true,
    handler(){
        console( 'bdoctype' ,this.bidDocument.DocType )
    }
},
bidAmount: function(val){
    this.idrEquiv = parseFloat(this.xrate) * parseFloat(this.bidAmount);
},

itbIkppValidity: function(val){
    if(this.itbIkppValidityPeriod == 'Weeks'){
        this.validityThru = moment(this.bidSubmission).add(parseInt(val), 'w').add(1, 'd').format('YYYY-MM-DD HH:mm:ss');
    }
    if(this.itbIkppValidityPeriod == 'Months'){
        this.validityThru = moment(this.bidSubmission).add(parseInt(val), 'm').add(1, 'd').format('YYYY-MM-DD HH:mm:ss');
    }
    if(this.itbIkppValidityPeriod == 'Days'){
        this.validityThru = moment(this.bidSubmission).add(parseInt(val) + 1, 'd').format('YYYY-MM-DD HH:mm:ss');
    }
},

itbIkppValidityPeriod: function(val){
    var valp = this.itbIkppValidity;
    if(val == 'Weeks'){
        this.validityThru = moment(this.bidSubmission).add(parseInt(valp), 'w').add(1, 'd').format('YYYY-MM-DD HH:mm:ss');
    }
    if(val == 'Months'){
        this.validityThru = moment(this.bidSubmission).add(parseInt(valp), 'm').add(1, 'd').format('YYYY-MM-DD HH:mm:ss');
    }
    if(val == 'Days'){
        this.validityThru = moment(this.bidSubmission).add(parseInt(valp) + 1, 'd').format('YYYY-MM-DD HH:mm:ss');
    }
},

evaluationMethod : function(val){
    this.submissionMethod = val;
},
currency: function(val){
    axios.get('{{ url('api/v1/core/xrate') }}?q=' + val)
        .then((response) => {
            if(response.data.result == 'OK'){
                this.xrate = response.data.xrate;
                console.log(response);
            }
        },(error) => {
            console.log(error);
        });
},
xrate :  function(val){
    this.idrEquiv = val * this.bidAmount;
},

inquiryDate : function(val){
    this.inquiryDateYY = moment(val).format('YY');
    console.log(this.inquiryDateYY);
    this.getJobCode();
    this.getJRSequence();
},
area: function(val){
    if(this.area == "Jakarta"){
        this.setArea = "J";
    } else if(this.area == "Balikpapan"){
        this.setArea = "B"
    }
    this.getJobCode();
    this.getJRSequence();
},
status : function(val){
    if(this.status == "Firm Buying"){
        this.setStatus = "C"
    } else if(this.status == "Budgetary"){
        this.setStatus = "B"
    }
    this.getJobCode();
    this.getJRSequence();
},
participatingCompany: function(val){
    if(this.participatingCompany == "01"){
        this.setCompany = "1"
    } else if (this.participatingCompany == "02"){
        this.setCompany = "2"
    } else if(this.participatingCompany == "03") {
        this.setCompany = "3"
    }
    this.getJobCode();
    this.getJRSequence();
},

getArea(){
    let str = this.area;
    if(str == "Jakarta"){
        str = str.charAt(0);
    }
    if (str == "Balikpapan"){
        str = str.charAt(0);
    }
    this.getJobCode();
    this.getJRSequence();
},

