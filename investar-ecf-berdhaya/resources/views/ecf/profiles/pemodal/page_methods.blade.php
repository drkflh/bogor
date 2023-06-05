maxDob(date){
    return moment( date ).isSameOrBefore( moment(this.minDob) );
},
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
    this.$refs.changePassForm.validate()
        .then((valid) => {
            if(valid) {
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
                            alert('Password changed successfuly')
                        }
                        if(response.data.result == 'ERR'){
                            alert(response.data.message);
                        }
                        this.new_password = '';
                        this.new_confirm_password = '';
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            }
        })
        .catch((error) => {
            alert(error.toString());
        });

},

commitChangePin(event){
    event.preventDefault();
    this.$refs.changePinForm.validate()
    .then((valid) => {
        if(valid) {
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
        }
    })
    .catch((error) => {
        console.log(error);
    })

},


commitSihalal(){
    var data = {
        id: '{{ Auth::user()->_id }}'
    };
        axios.get( '{{ url('/usersihalal') }}' ,  data  )
        .then(response => {
            console.log(response.data, '');
            if(response.data.result == 'OK'){
                alert('Akun Berhasil Terdaftar');
            }
            console.log( 'respon data sihalal', response.data );
        })
        .catch(function(error) {
            console.log(error);
        });

        this.$bvModal.hide('sihalaluser');

},
