maxToday(date){
    const today = new Date();
    return date > today;
},
getSequence(){

    if(this.vendorCode != '' && !_.isNull(this.vendorCode)){
        alert('Vendor Code already exists');
        return 0;
    }

    var entity = this.vendorPrefix;
    var company = this.coyName;

    axios.post( '{{ url('sms/directory/vendor/get-seq') }}' , { entity: entity, padding: 5, company: company } )
    .then(response => {
        console.log(response.data);
        if(response.data.result == 'OK'){
            var seq = response.data.padded;
            this.vendorSeq = seq;
            this.vendorCode = this.vendorPrefix + this.vendorSeq;
        } else {
            alert(response.data.msg);
        }
    })
    .catch(function(error) {
        console.log(error);
    });
}
