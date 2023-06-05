refreshSignature(){
    bus.$emit('resize');
},
refreshEmployment(){
    bus.$emit('resize');
},
getAgeStatus(){

var dateOfBirth = this.dateOfBirth;

axios.post( '{{ url('ecf/profile/pemodal/get-age') }}' , { dateOfBirth : dateOfBirth } )
    .then(response => {
        console.log( response.data );
        if(response.data.result == 'OK'){
            var userAge =  _.get( response.data , 'userAge' );          
            this.userAge = userAge;
            var ageStatus =  _.get( response.data , 'status' );          
            this.ageStatus = ageStatus;
        }
    })
    .catch(function(error) {
        console.log(error);
    });
},