getWASession(){
    axios.post( '{{ url('mms/message-gateway/wa-session') }}' , { gatewaySessionId: this.gatewaySessionKey, delExist : this.delExist } )
    .then(response => {
        console.log(response.data);
        if(response.data.result == 'OK'){
            var qr = response.data.data.qr;
            this.waSessionQR = qr;
        }else{
            alert(response.msg)
        }
    })
    .catch(function(error) {
        console.log(error);
    });

},
