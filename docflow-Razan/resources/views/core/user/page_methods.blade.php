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

    if(this.new_password == '' || this.new_confirm_password == '' ){
        alert('Password tidak boleh kosong');
        return;
    }
    if(this.new_password.length < 8 ){
        alert('Password kurang dari 8 karakter');
        return;
    }

    var regex = /[^A-Za-z0-9]+/g;
    if(this.new_password.match(regex)){
        alert('Password hanya terdiri dari angka dan huruf, minimal 8 karakter');
        return;
    }

    if(this.new_password == this.new_confirm_password){
        var data = {
            id: '{{ Auth::user()->_id }}',
            password: this.new_password,
            confirm_password: this.new_confirm_password
        };

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

    if(this.new_pin.length < 6 || ! _.isNumber( parseInt( this.new_pin ) )){
        alert('Pin kurang dari 6 digit atau bukan angka');
        return;
    }
    if(this.new_pin == this.new_confirm_pin){
        var data = {
            id: '{{ Auth::user()->_id }}',
            pin: this.new_pin,
            confirm_pin: this.new_confirm_pin
        };
        axios.post( '{{ url('/profile-edit/change-pin') }}' , data )
        .then(response => {
            console.log(response.data);
            if(response.data.result == 'OK'){
                this.$bvModal.hide('changePinModal');
                this.new_pin = null;
                this.new_confirm_pin = null;
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

