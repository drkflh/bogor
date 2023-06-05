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
  axios.post( '{{ url('sfm/reference/city') }}',{provinceName:val.value.value})
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
setCity(val) {
  console.log(val)
  this.cityName =  val.value.text
},
setCustomerPrefix(){
    var myStr = this.customerName;

    //var matches = myStr.match(/\b(\w)/g);

    var str = myStr.split(" ");
    if (str.length > 1){
        var S1 = str[0].substring(0,1).toUpperCase();
        var S2 = str[1].substring(0,1).toUpperCase();
    } else {
        var S1 = str[0].substring(0,1).toUpperCase();
        var S2 = S1;
    }
    this.customerPrefix = "C" + S1 + S2;
},

getSequence(){

    var entity = this.customerPrefix;
    var customer = this.customerName;

    axios.post( '{{ url('sfm/directory/customer/get-seq') }}' , { entity: entity, padding: 5, customer: customer } )
    .then(response => {
        console.log(response.data);
        if(response.data.result == 'OK'){
            var seq = response.data.padded;
            this.customerSeq = seq;
            this.customerCode = this.customerPrefix + this.customerSeq;
        } else {
            alert(response.data.msg);
        }
    })
    .catch(function(error) {
        console.log(error);
    });
}



