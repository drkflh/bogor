refreshSignature(){
    bus.$emit('resize');
},
refreshEmployment(){
    bus.$emit('resize');
},
setProvince(val) {
  this.province =  val
  this.spinner = true
  axios.post( '{{ url('central/reference/city') }}',{province: val})
    .then(response => {
      if(response.status === 200){
        if(response.data.length>0) {
          let city = []
          response.data.map((item) => {
            city.push({
              text: item.text,
              value: item.value
            })
          })
      this.cityOptions = city
      }
  }
})
    .catch(function(error) {
    console.log(error);
  });
},
setCity(val) {
  console.log(val)
  this.city =  val
},
