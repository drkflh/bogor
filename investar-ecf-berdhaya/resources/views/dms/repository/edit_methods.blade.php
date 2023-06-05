maxToday(date){
    const today = new Date();
    return date > today;
},
betweenDocDateNow(date){
    const today = new Date();
    const before = new Date(this.DocDate);
    return before > date || date > today;
},
minDay(date){
    const today = moment(this.serviceRequestDate);
    return date < today;
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
refreshDocUrl(){
    let dt = new Date();
    if( this.FileUrl != '' ){
        this.docViewUrl = this.FileUrl + '?' + dt ;
    }else{
        this.docViewUrl = this.FileUrl ;
    }
},
getDocSequence(){

    var entity = this.CallCode;

    const re = {{ env('DMS_CALLCODE_UNSEQ_PATTERN') }};
    if( entity == '' || !re.exec(entity) ){
        alert('{{__('Call Code prefix should be complete')}}');
        return;
    }

    axios.post( '{{ url('dms/repo/get-seq') }}' , { entity: entity, padding: 2 } )
        .then(response => {
            console.log(response.data);
            console.log(response.data.result);
            if(response.data.result == 'OK'){
                console.log(response.data.data);
                var seq = response.data.padded;
                this.Urut = seq;
                this.getCallCode();
            }
        })
        .catch(function(error) {
           console.log(error);
        });
},
embedQR(){
    const re = {{ env('DMS_CALLCODE_PATTERN') }};
    if(this.FCallCode == '' || !re.exec(this.FCallCode) ){
        alert('{{ __('Call Code can not be empty or incomplete') }}');
        return;
    }
    if(_.isEmpty(this.FileObject) || _.isUndefined(this.FileObject) || _.isNull(this.FileObject)){
        alert('No file to embed in, upload a file first');
        return;
    }

    var entity = _.cloneDeep(this.FileObject);

    _.set(entity, 'addQR', true);
    _.set(entity, 'FCallCode', this.FCallCode);

    this.isEmbedding = true;

    axios.post( '{{ url('dms/embed-qr') }}' , { entity: entity } )
        .then(response => {
            console.log(response.data);
            console.log(response.data.result);
            if(response.data.result == 'OK'){
                console.log(response.data.data);
                let file = response.data.data.file;
                this.FileUrl = file.FileUrl;
                this.FileObject = file.FileObject;

                this.refreshDocUrl();

                let hasQR = _.get(file.FileObject, 'has_qr' );
                if( hasQR == false){
                    alert('QR Embedding failed, probably caused by unsupported pdf format');
                }
            }
            this.isEmbedding = false;
        })
        .catch(function(error) {
           console.log(error);
        });
},
