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
    this.$refs.changePassForm.validate()
        .then((valid) => {
            if(valid) {
                var data = {
                    id: this.val,
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
                id: this.val,
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

bidStatusChangeHidden(){
    console.log('campaign hidden');
    this.selectedRow = {};
    bus.$emit('refreshTable');
},
bidStatusChangeShown(event){
    console.log('bid shown', event);
    var row = this.selectedRow;
    var aux = { id : row._id, field: 'bidStatus' };
    var edit = {
        changeDate : '{{ date('Y-m-d H:i:s', time()) }}',
        changeBy : '{{ \Illuminate\Support\Facades\Auth::user()->name }}',
        currentStatus : row.bidStatus,
        changeStatusTo : row.bidStatus,
        changeRemarks: row.bidStatusRemarks
    };
    this.$refs.changeBidStatusModal.setTitleData( row.id );
    this.$refs.changeBidStatusModal.setData( edit );
    this.$refs.changeBidStatusModal.setAuxData(aux);

},
changeBidStatus(row){
    this.selectedRow = row;
    this.$refs.changeBidStatusModal.openModal();
},

jobStatusChangeHidden(){
    console.log('campaign hidden');
    this.selectedRow = {};
    bus.$emit('refreshTable');
},
jobStatusChangeShown(){
    console.log('job shown', event);
    var row = this.selectedRow;
    var aux = { id : row._id, field: 'jobStatus' };
    var edit = {
        changeDate : '{{ date('Y-m-d H:i:s', time()) }}',
        changeBy : '{{ \Illuminate\Support\Facades\Auth::user()->name }}',
        currentStatus : row.jobStatus,
        changeStatusTo : row.jobStatus,
        changeRemarks: row.jobStatusRemarks
    };
    this.$refs.changeJobStatusModal.setTitleData( row.id );
    this.$refs.changeJobStatusModal.setData( edit );
    this.$refs.changeJobStatusModal.setAuxData(aux);
},
changeJobStatus(row){
    this.selectedRow = row;
    this.$refs.changeJobStatusModal.openModal();
},

mobileStatusChangeHidden(){
    console.log('campaign hidden');
    this.selectedRow = {};
    bus.$emit('refreshTable');
},
mobileStatusChangeShown(){
    console.log('job shown', event);
    var row = this.selectedRow;
    console.log('mobile', row.mobile);
    var aux = { id : row._id, field: 'mobile' };
    var edit = {
        changeDate : '{{ date('Y-m-d H:i:s', time()) }}',
        changeBy : '{{ \Illuminate\Support\Facades\Auth::user()->name }}',
        changeById : '{{ \Illuminate\Support\Facades\Auth::user()->_id }}',
        mobile : row.mobile,

    };
    this.$refs.changeMobileStatusModal.setTitleData( row.id );
    this.$refs.changeMobileStatusModal.setData( edit );
    this.$refs.changeMobileStatusModal.setAuxData(aux);
},
changeMobileStatus(row){
    this.selectedRow = row;
    this.$refs.changeMobileStatusModal.openModal();
},

emailStatusChangeHidden(){
    console.log('campaign hidden');
    this.selectedRow = {};
    bus.$emit('refreshTable');
},
emailStatusChangeShown(){

    var row = this.selectedRow;
    console.log('email', row.email);
    var aux = { id : row._id, field: 'email' };
    var edit = {
        changeDate : '{{ date('Y-m-d H:i:s', time()) }}',
        changeBy : '{{ \Illuminate\Support\Facades\Auth::user()->name }}',
        changeById : '{{ \Illuminate\Support\Facades\Auth::user()->_id }}',
        email : row.email,

    };
    this.$refs.changeEmailStatusModal.setTitleData( row.id );
    this.$refs.changeEmailStatusModal.setData( edit );
    this.$refs.changeEmailStatusModal.setAuxData(aux);
},
changeEmailStatus(row){
    this.selectedRow = row;
    this.$refs.changeEmailStatusModal.openModal();
},
