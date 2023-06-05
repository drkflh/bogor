openPasswordModal(val){
    this.val = val;
    console.log('change pass');
    this.$bvModal.show('changePasswordModal');
},
openPinModal(val){
    this.val = val;
    console.log('change pin');
    this.$bvModal.show('changePinModal');
},
commitChangePassword(event){
    event.preventDefault();
    var data = {
        id: this.val,
        password: this.new_password,
        confirm_password: this.new_confirm_password
    };
    if(this.password == this.confirm_password){
        axios.post( '{{ url('/profile-edit/change-password') }}' , data )
        .then(response => {
            console.log(response.data);
            if(response.data.result == 'OK'){
                this.$bvModal.hide('changePasswordModal');
                this.new_password = '';
                this.new_confirm_password = '';
                alert('Password changed successfuly')
            }
            if(response.data.result == 'ERR'){
                alert(response.data.message);
            }
        })
        .catch(function(error) {
            console.log(error);
        });
    }else{
        alert('Password tidak sama')
    }
},

commitChangePin(event){
    event.preventDefault();

    tvm.$refs.changePinForm.validate()
    .then((valid) => {
        if(valid) {
            var data = {
                id: this.val,
                pin: this.new_pin,
                confirm_pin: this.new_confirm_pin
            };
            if(this.pin == this.confirm_pin){
                axios.post( '{{ url('/profile-edit/change-pin') }}' , data )
                    .then(response => {
                        console.log(response.data);
                        if(response.data.result == 'OK'){
                            this.$bvModal.hide('changePinModal');
                            this.new_pin = '';
                        this.new_confirm_pin = '';
                            alert('PIN changed successfuly')
                        }
                        if(response.data.result == 'ERR'){
                            alert(response.data.message);
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            }else{
                alert('PIN tidak sama')
            }
        }
    })
    .catch((error) => {
        console.log(error);
    })

},
