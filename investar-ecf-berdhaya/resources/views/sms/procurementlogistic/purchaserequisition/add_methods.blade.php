/* PR Add Method Snippets */
maxToday(date){
    const today = new Date();
    return date > today;
},
maxTodayNotBefore(date){
    const today = new Date();
    const before = new Date(this.DocDate);

    console.log( date, today, before);

    return before > date || date > today;
},
setProvince(val) {
  console.log(val)
  this.provinceName =  val.value.text
  this.spinner = true
  axios.post( '{{ url('sms/reference/city') }}',{provinceName:val.value.value})
    .then(response => {
      console.log(response.data);
      if(response.status === 200){
        if(response.data.data.length>0) {
          let city = []
          response.data.data.map((item) => {
            city.push({
              text: item.cityName,
              value: item
            })
          })
      this.cityNameOptions = city
      }
  }
  this.spinner = false
})
    .catch(function(error) {
    console.log(error);
  });
},

getJobCode(){
    if( this.jobNo != '' && this.requestDateYYMM != '' ){
        this.PurchaseReqPrefix = this.jobNo + "-" + this.requestDateYYMM;
    }

    if( this.jobNo == '' && this.costCenter != '' && this.requestDateYYMM != '' ){
        this.PurchaseReqPrefix = this.costCenter + "-" + this.requestDateYYMM;
    }

    if( this.purchaseSequence != ''){
        this.requestNo = "PR" + "-" + this.PurchaseReqPrefix + "-" + this.purchaseSequence + "-" + this.rev;
        this.requestNoPrefix = "PR" + "-" + this.PurchaseReqPrefix + "-" + this.purchaseSequence;
    } else{
        console.log("no Number generated");
    }
},
getPRSequence(){
    console.log('get sequence');
    var entity = this.PurchaseReqPrefix;
    var company = this.jobNo + this.requestDateYYMM;

    axios.post( '{{ url('sms/procurement-logistics/purchase-requisition/get-seq') }}' , { entity: entity, padding: 2, company: company } )
        .then(response => {
            console.log( 'responseraw', response.data );
            if(response.data.result == 'OK'){
                console.log( 'resultseq', response.data );
                var seq = _.get( response.data , 'padded', '' );
                this.purchaseSequence = seq;
                console.log( 'resultseq', seq );
                this.getJobCode();
            }
        })
        .catch(function(error) {
            console.log(error);
        });
},
detailCalc(items){

    console.log('detail', items);

    var total = 0;

    _.each( items, (item, idx)=>{

        item.QTY = parseFloat(item.QTY);
        item.UnitPrice = parseFloat(item.UnitPrice);

        item.AmountOrdered = item.QTY * item.UnitPrice ;

        total = total + item.AmountOrdered;

        console.log( idx,  this.details[idx] );

    });

    this.totals = total;
    // this.total = total * this.xrate;
    this.total = total;
},

discCalc(){

    var discSwitch = this.discountSwitch;
    var lump = this.discountLumpSumSwitch;

    if(discSwitch == false){
        this.discountPercentage = 0;
        //this.totalDisc = "(" + 0 + ")";
    }
    if(lump == false){
        this.discountLumpSum = 0;
        //this.totalDisc = "(" + 0 + ")";
    }

    var totalAfterDisc = parseFloat(this.total) - parseFloat(this.totalDisc);
    console.log('disc all', disc, totalAfterDisc);
    this.totalVat = ( parseFloat(this.vat) / 100 ) * parseFloat(totalAfterDisc);
    this.grandTotal = parseFloat(totalAfterDisc) + parseFloat(this.totalVat);


    if(discSwitch == true && lump == false){
        var disc = parseFloat(this.total) * (parseFloat(this.discountPercentage) / 100);
        if(this.discountPercentage != ''){
            this.totalDisc = disc;
        }else{
            this.totalDisc = 0;
        }
        var totalAfterDisc = parseFloat(this.total) - parseFloat(this.totalDisc);
        console.log('disc pct', disc, totalAfterDisc);
        this.totalVat = ( parseFloat(this.vat) / 100 ) * parseFloat(totalAfterDisc);
        this.grandTotal = parseFloat(totalAfterDisc) + parseFloat(this.totalVat);

    }

    if(discSwitch == false && lump == true){
        var disclump = parseFloat(this.discountLumpSum);
        this.totalDisc = disclump;

        var totalAfterDisc = parseFloat(this.total) - parseFloat(this.totalDisc);
        console.log('disc lump', disc, totalAfterDisc);

        this.totalVat = ( parseFloat(this.vat) / 100 ) * parseFloat(totalAfterDisc);
        this.grandTotal = parseFloat(totalAfterDisc) + parseFloat(this.totalVat);
    }

    if(discSwitch == true && lump == true){
        var disc = parseFloat(this.total) * parseFloat(this.discountPercentage) / 100;
        var disclump = parseFloat(this.discountLumpSum);
        disc = disc + disclump;
        this.totalDisc = disc;

        var totalAfterDisc = parseFloat(this.total) - parseFloat(this.totalDisc);
        this.totalVat = ( parseFloat(this.vat) / 100 ) * parseFloat(totalAfterDisc);

        this.grandTotal = parseFloat(totalAfterDisc) + parseFloat(this.totalVat);
    }

    console.log('discCalc', this.totalDisc);

},
setCompany(){
    this.companyObject = _.get( this.companyCodeMap , this.companyCode );
},
