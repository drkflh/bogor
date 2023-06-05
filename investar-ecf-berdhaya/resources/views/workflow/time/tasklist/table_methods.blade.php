showChangeStat(val){
    this.val = val;
    this.$bvModal.show('changeStatModal');
},

doChangeStat(event){
    event.preventDefault();
    tvm.$refs.changeStatForm.validate()
    .then((valid) => {
        console.log('valid', valid)
        if(valid) {
            var stat = {
                status: this.status,
                note: this.note,
                pin: this.pin,
                id: this.val
            };

            axios.post( '{{ url('workflow/time/task-list/changestat') }}' , stat )
            .then(response => {
                console.log(response.data);
                if(response.data.result == 'OK'){
                    this.$bvModal.hide('changeStatModal');
                    tvm.fetchData();
                    tvm.loadTableData();
                    this.status = null;
                    this.note = null;
                    this.pin = null;
                }
                if(response.data.result == 'ERR'){
                    alert(response.data.message);
                }
                tvm.$refs.add_veeObserver.reset();
            })
            .catch(function(error) {
                console.log(error);
            });
        }
    })
    .catch((error) => {})

},
