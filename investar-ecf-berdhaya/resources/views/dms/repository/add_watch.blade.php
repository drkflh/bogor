DocDate : function(val){
    this.RetDate = moment(val).add(parseInt(this.RetPer), 'y').format('YYYY-MM-DD HH:mm:ss');
    this.DispDate = moment(val).add(parseInt(this.DispPer), 'y').format('YYYY-MM-DD HH:mm:ss');
    this.MMYY = moment(val).format('MMYY');
    this.getCallCode();
},
FileUrl : function(val){
    let dt = new Date();
    if( val == '' ){
        this.docViewUrl = '';
    }else{
        this.docViewUrl = val + '?' + dt;
    }
},
RetPer : function(val){
    console.log(val, this.DocDate);
    this.RetDate = moment(this.DocDate).add(parseInt(val), 'y').format('YYYY-MM-DD HH:mm:ss');
},
DispPer : function(val){
    this.DispDate = moment(this.DocDate).add(parseInt(val), 'y').format('YYYY-MM-DD HH:mm:ss');
},
Coy : function(val){
    this.CoyCode = val;
},
CoyCode : function(val){
    this.getCallCode();
},
Topic : function(val){
    this.getCallCode();
},
Feature : function(val){
    this.getCallCode();
},
MMYY : function(val){
    this.getCallCode();
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
