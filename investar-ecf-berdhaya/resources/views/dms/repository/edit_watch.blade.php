DocDate : function(val){
    this.RetDate = moment(val).add(parseInt(this.RetPer), 'y').format('YYYY-MM-DD HH:mm:ss');
    this.DispDate = moment(val).add(parseInt(this.DispPer), 'y').format('YYYY-MM-DD HH:mm:ss');
    this.MMYY = moment(val).format('MMYY');
    //this.getCallCode();
},
FileUrl : function(val){
    let dt = new Date();
    if( val == '' ){
        this.docViewUrl = '';
    }else{
        this.docViewUrl = val + '?' + dt;
    }
},
TopicObject: function(val){
    console.log(val);
    this.Topic = _.get( val, 'Topic', '' );
    this.TopicDescr = _.get( val, 'TopicDescr', '' );
    this.Function = _.get( val, 'Function', '' );
    this.RetPer = parseInt( _.get( val, 'ActiveYrs',0 ) );
    this.DispPer = parseInt( _.get( val, 'DispPer',0 ) );
    this.Class = _.get( val, 'DocClass', '' );
},
