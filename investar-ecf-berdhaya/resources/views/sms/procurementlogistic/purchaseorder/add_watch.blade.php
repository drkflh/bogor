bidAmount: function(val){
    this.idrEquiv = parseFloat(this.xrate) * parseFloat(this.bidAmount);
},

itbIkppValidity: function(val){
    this.validityThru = moment(this.bidSubmission).add(parseInt(val), 'd').format('YYYY-MM-DD HH:mm:ss');
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
    {{-- this.idrEquiv = val * this.bidAmount; --}}
},

total : function(val){
    this.discCalc();
},

discountSwitch : function(val){
    this.discCalc();
},

discountLumpSumSwitch : function(val){
    this.discCalc();
},

discountLumpSum : function(val){
    if(this.discountLumpSum > this.total){
        this.discountLumpSum = this.total
    }
    this.discCalc();
},

discountPercentage : function(val){
    if(this.discountPercentage > 100){
        this.discountPercentage = 100;
    }else if(this.discountPercentage < 0){
        this.discountPercentage = 0;
    }
    this.discCalc();
},

vat : function(val){
    if(this.vat > 100){
        this.vat = 100;
    }else if(this.vat < 0){
        this.vat = 0;
    }
    this.discCalc();
},

