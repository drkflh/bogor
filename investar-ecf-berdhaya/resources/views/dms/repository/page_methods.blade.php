maxToday(date){
    const today = new Date();
    return date > today;
},
betweenDocDateNow(date){
    const today = new Date();
    const before = new Date(this.DocDate);
    return before > date || date > today;
},
viewPdf(){
    bus.$emit('viewPdf', this.FileUrl );
},
getCallCode(){
    if( !_.isEmpty(this.Topic) && !_.isEmpty(this.Function) && !_.isEmpty(this.CoyCode) && !_.isEmpty(this.Feature) && !_.isEmpty(this.MMYY)  ){

        this.CallCode = this.Topic + '-' + this.CoyCode + '-' + this.Feature + '-' + this.MMYY;

        if( !_.isEmpty(this.Urut) ){
            this.FCallCode = this.Topic + '-' + this.CoyCode + '-' + this.Feature + '-' + this.MMYY + '-' + this.Urut;
        }
    }
},
getDocUrl(){
    return '{{ url('/') }}/{{ env('DOC_READER_ROOT') }}/' + this.DocPath;
},
getSequence(){

    var entity = this.CallCode;

    axios.post( '{{ url('dms/repo/get-seq') }}' , { entity: entity, padding: 2 } )
        .then(response => {
            console.log(response.data);
            if(response.data.result == 'OK'){
                var seq = response.data.data.padded;
                this.Urut = seq;
                this.getCallCode();
            }
        })
        .catch(function(error) {
           console.log(error);
        });
},
