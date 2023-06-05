getHalalCode(){
    console.log('job number gen');

    if( this.businessRef != ''){
        console.log('isi halal market :' + this.tradeMark);
        this.tradeMark = this.tradeMark;

    } else{
        console.log("no Number generated");
    }

},
getHalalSequence(){

    console.log( 'entity var businessRef :', this.businessRef );
    var businessRef = this.businessRef;

    axios.post( '{{ url('halal/halal-certification/get-seq') }}' , { businessRef: businessRef } )
        .then(response => {
            console.log( 'responseraw', response.data );
            if(response.data.result == 'OK'){
                console.log( 'resultseq', response.data );
                var trade = _.get( response.data , 'tradeMark', '' );
                this.tradeMark = trade;
                //console.log( 'resul trade ', trade );
                //this.getHalalCode();
            }
        })
        .catch(function(error) {
            console.log(error);
        });
},
