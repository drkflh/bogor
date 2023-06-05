getToken(){

    var apiId = this.itemId;

    axios.post( '{{ url('api-user/token') }}' , { apiId: apiId } )
        .then(response => {
            console.log(response.data);
            if(response.data.result == 'OK'){
                var seq = response.data.data.token;
                this.token = seq;
            }
        })
        .catch(function(error) {
            console.log(error);
        });
},
