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
jobStatus: function(val){
    axios.get('{{ url('sms/changejobstatus') }}')
    .then((response) => {
        if(response.data.result == 'OK'){
            this.changeDate = response.data.date;
            this.changeBy = response.data.name;
            console.log(response);
        }
    },(error) => {
        console.log(error);
    });
},

{{-- status : function(val){
    this.getGenerateCode();
},
area : function(val){
    this.getGenerateCode();
},
participatingCompany : function(val){
    this.getGenerateCode();
},
inquiryDate : function(val){
    this.getGenerateCode();
},
inquiryDate : function(val){

    this.inquiryDate = moment(val).format('YYYY');
    this.getGenerateCode();
}, --}}

