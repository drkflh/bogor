maxToday(date){
    const today = new Date();
    return date > today;
},
maxTodayNotBefore(date){
    const today = new Date();
    const before = new Date(this.DocDate);

    console.log( date, today, before);

    return before > date || date > today;
},
//scan methods
clearScanTemp(){
    axios.post( '{{ url('dms/repository/cleartemp') }}' , postObj )
    .then(response => {
        console.log(response.data);
        if(response.data.result == 'OK'){
            this.boxIdInput = '';
            this.$bvModal.hide('boxIdModal');
        }
    })
    .catch(function(error) {
        alert(error);
    });
}
