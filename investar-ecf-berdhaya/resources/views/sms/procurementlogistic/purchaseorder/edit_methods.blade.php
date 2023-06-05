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
minDay(date){
    const today = moment(this.requestDate);
    return date < today;
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
    if( !_.isEmpty(this.jobNo) && !_.isEmpty(this.purchaseOrderDateYYMM) ){

        this.PurchaseReqPrefix = this.jobNo + "-" + this.purchaseOrderDateYYMM;

        if( !_.isEmpty(this.purchaseSequence) ){
            this.orderNo = "PO" + "-" + this.PurchaseReqPrefix + "-" + this.purchaseSequence + "-" + this.rev ;
        } else{
            console.log("error");
        }

    } else if(_.isEmpty(this.jobNo) && !_.isEmpty(this.costCenter) && !_.isEmpty(this.purchaseOrderDateYYMM)){
        this.PurchaseReqPrefix = this.costCenter + "-" + this.purchaseOrderDateYYMM;

        if( !_.isEmpty(this.purchaseSequence) ){
            this.orderNo = "PO" + "-" + this.PurchaseReqPrefix + "-" + this.purchaseSequence + "-" + this.rev;
        } else{
            console.log("error");
        }
    } else{
        console.log("error, please check your fields");
    }
},
getSequence(){

    var entity = this.PurchaseReqPrefix;
    var company = this.jobNo + this.purchaseOrderDateYYMM;

    axios.post( '{{ url('sms/procurement-logistics/purchase-order/get-seq') }}' , { entity: entity, padding: 2, company: company } )
    .then(response => {
        console.log(response.data);
        if(response.data.result == 'OK'){
            let seq = response.data.padded;
            this.purchaseSequence = seq;
            this.getJobCode();
        }
    })
    .catch(function(error) {
        console.log(error);
    });
},
searchPR(){
    var pr = this.prNo;
    var pquery = '?pr='+ pr ;
    this.getParam(pquery)
},
searchFax(){
    var companyName = this.companyName;
    var pquery = '?companyName='+ companyName ;
    this.getParam(pquery)
},

detailCalc(items){

    console.log('detailCalc PO Edit', items);

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
onLocalSelect(val){
    console.log('PR',val);
    var pquery = '?pr='+ val.value ;
    this.getParam(pquery)
},
