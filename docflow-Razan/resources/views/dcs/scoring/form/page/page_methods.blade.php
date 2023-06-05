refreshSignature(){
    bus.$emit('resize');
},
refreshEmployment(){
    bus.$emit('resize');
},
openPasswordModal(val){
    this.val = val;
    console.log('change pass');
    this.$bvModal.show('changePasswordModal');
},
openPinModal(){
    console.log('change pin');
    this.$bvModal.show('changePinModal');
},
commitChangePassword(event){
    event.preventDefault();
    var data = {
        id: '{{ Auth::user()->_id }}',
        password: this.password,
        confirm_password: this.password
    };
    if(this.password == this.confirm_password){
        axios.post( '{{ url('/profile-edit/change-password') }}' , data )
        .then(response => {
            console.log(response.data);
            if(response.data.result == 'OK'){
                this.$bvModal.hide('changePasswordModal');
                this.password = null;
                this.confirm_password = null;
                alert('Password changed successfully')
            }
            if(response.data.result == 'ERR'){
                alert(response.data.message);
            }
        })
        .catch(function(error) {
            console.log(error);
        });
    }else{
        alert('Password Tidak sama')
    }
},

commitChangePin(event){
    event.preventDefault();
    var data = {
        id: '{{ Auth::user()->_id }}',
        pin: this.pin,
        confirm_pin: this.confirm_pin
    };
    if(this.pin == this.confirm_pin){
        axios.post( '{{ url('/profile-edit/change-pin') }}' , data )
        .then(response => {
            console.log(response.data);
            if(response.data.result == 'OK'){
                this.$bvModal.hide('changePinModal');
                this.pin = null;
                this.confirm_pin = null;
                alert('PIN changed successfully')
            }
            if(response.data.result == 'ERR'){
                alert(response.data.message);
            }
        })
        .catch(function(error) {
            console.log(error);
        });
    }else{
        alert('Pin Tidak sama')
    }
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

