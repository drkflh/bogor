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
setVendorPrefix(){
    var myStr = this.coyName;

    //var matches = myStr.match(/\b(\w)/g);

    var str = myStr.split(" ");
    if (str.length > 1){
        var S1 = str[0].substring(0,1).toUpperCase();
        var S2 = str[1].substring(0,1).toUpperCase();
    } else {
        var S1 = str[0].substring(0,1).toUpperCase();
        var S2 = S1;
    }
    this.vendorPrefix = "V" + S1 + S2;
},
getDocUrl(){
    return '{{ url('/') }}/{{ env('DOC_READER_ROOT') }}/' + this.DocPath;
},
getSequence(){

    var entity = this.vendorPrefix;
    var company = this.coyName;

    axios.post( '{{ url('sfm/directory/vendor/get-seq') }}' , { entity: entity, padding: 5, company: company } )
    .then(response => {
        console.log(response.data);
        if(response.data.result == 'OK'){
            var seq = response.data.padded;
            this.vendorSeq = seq;
            this.vendorCode = this.vendorPrefix + this.vendorSeq;
        } else {
            alert(response.data.msg);
        }
    })
    .catch(function(error) {
        console.log(error);
    });
}



