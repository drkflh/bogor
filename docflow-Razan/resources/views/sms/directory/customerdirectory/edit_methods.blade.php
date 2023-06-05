maxToday(date){
    const today = new Date();
    return date > today;
},
getSequence(){

    if(this.customerCode != '' && !_.isNull(this.customerCode)){
        alert('Customer Code already exists');
        return 0;
    }

    var entity = this.customerPrefix;
    var customer = this.customerName;

    axios.post( '{{ url('sms/directory/customer/get-seq') }}' , { entity: entity, padding: 5, customer: customer } )
    .then(response => {
        console.log(response.data);
        if(response.data.result == 'OK'){
            var seq = response.data.padded;
            this.customerSeq = seq;
            this.customerCode = this.customerPrefix + this.customerSeq;
        } else {
            alert(response.data.msg);
        }
    })
    .catch(function(error) {
        console.log(error);
    });
}
