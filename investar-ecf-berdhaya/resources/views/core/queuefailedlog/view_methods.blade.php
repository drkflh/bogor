prettyReq(){
    var json;
    try{
        json = this.prettyJson( this.request_data );
    }catch(err){
        json = this.request_data;
    }
    return json;
},
prettyResp(){
    var json;
    try{
        json = this.prettyJson( this.exception );
    }catch(err){
        json = this.response_data;
    }
    return json;
},
